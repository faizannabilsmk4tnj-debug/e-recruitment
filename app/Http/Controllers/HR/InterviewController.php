<?php
/**
 * File: App/Http/Controllers/HR/InterviewController.php
 * Author: Antigravity AI
 */

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\NotificationService;

class InterviewController extends Controller
{
    /**
     * Display a listing of interviews (table view) with filters.
     */
    public function index(Request $request)
    {
        $query = Interview::with(['application.user', 'application.job', 'scheduler', 'result.reviewer']);

        // Search candidate name or job title or email
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('application.user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('application.job', function($jq) use ($search) {
                    $jq->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('interview_type', $request->type);
        }

        // Date filter
        if ($request->filled('date')) {
            $dateVal = $request->get('date');
            if (str_contains($dateVal, ' - ')) {
                $parts = explode(' - ', $dateVal);
                try {
                    $start = Carbon::parse($parts[0])->startOfDay();
                    $end = Carbon::parse($parts[1])->endOfDay();
                    $query->whereBetween('scheduled_at', [$start, $end]);
                } catch (\Exception $e) {}
            } else {
                try {
                    $day = Carbon::parse($dateVal);
                    $query->whereDate('scheduled_at', $day);
                } catch (\Exception $e) {}
            }
        }

        $interviews = $query->orderBy('scheduled_at', 'desc')->paginate(10)->withQueryString();

        // Calculate statistics for cards
        $totalScheduled = Interview::where('status', 'scheduled')->count();
        
        $completedCount = Interview::where('status', 'completed')->count();
        $cancelledCount = Interview::where('status', 'cancelled')->count();
        $totalEnded = $completedCount + $cancelledCount;
        $attendanceRate = $totalEnded > 0 ? round(($completedCount / $totalEnded) * 100) : 100;

        $avgDuration = round(Interview::avg('duration_minutes') ?? 45);

        // Fetch active applications for the schedule modal dropdown
        $applications = Application::with(['user', 'job'])
            ->whereIn('status', ['applied', 'shortlisted', 'interview'])
            ->get();

        // Pending reschedule requests from applicants
        $rescheduleRequests = Interview::with(['application.user', 'application.job'])
            ->where('status', 'rescheduled')
            ->where('reschedule_request_status', 'pending')
            ->orderBy('updated_at', 'desc')
            ->get();

        $rescheduleCount = $rescheduleRequests->count();

        return view('hr.wawancara-daftar', compact(
            'interviews',
            'totalScheduled',
            'attendanceRate',
            'avgDuration',
            'applications',
            'rescheduleRequests',
            'rescheduleCount'
        ));
    }

    /**
     * Display a calendar view of interviews.
     */
    public function calendar(Request $request)
    {
        $month = intval($request->get('month', now()->month));
        $year = intval($request->get('year', now()->year));

        $firstDayOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        $daysInMonth = $firstDayOfMonth->daysInMonth;
        
        $dayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)
        $emptyDaysBefore = ($dayOfWeek + 6) % 7; // Mon = 0, Sun = 6

        $prevMonth = (clone $firstDayOfMonth)->subMonth();
        $daysInPrevMonth = $prevMonth->daysInMonth;
        
        $totalCells = $emptyDaysBefore + $daysInMonth;
        $gridRows = ceil($totalCells / 7);
        $totalGridCells = $gridRows * 7;
        $emptyDaysAfter = $totalGridCells - $totalCells;

        $startDate = (clone $firstDayOfMonth)->startOfMonth();
        $endDate = (clone $firstDayOfMonth)->endOfMonth();

        // Fetch interviews grouped by day
        $interviews = Interview::with(['application.user', 'application.job'])
            ->whereBetween('scheduled_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function($item) {
                return $item->scheduled_at->day;
            });

        // Retrieve coming up interviews (upcoming scheduled)
        $comingUpInterviews = Interview::with(['application.user', 'application.job'])
            ->where('scheduled_at', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at', 'asc')
            ->limit(5)
            ->get();

        return view('hr.wawancara', compact(
            'month',
            'year',
            'daysInMonth',
            'emptyDaysBefore',
            'daysInPrevMonth',
            'emptyDaysAfter',
            'interviews',
            'comingUpInterviews'
        ));
    }

    /**
     * Helper to check overlap for a scheduled interview.
     */
    public static function checkOverlap($scheduledAt, $durationMinutes, $excludeId = null)
    {
        $newStart = Carbon::parse($scheduledAt);
        $durationMinutes = (int) $durationMinutes;
        $newEnd = (clone $newStart)->addMinutes($durationMinutes);

        // Fetch all interviews on the same day
        $query = Interview::whereIn('status', ['scheduled', 'completed', 'rescheduled'])
            ->whereDate('scheduled_at', $newStart->toDateString());

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $interviews = $query->get();

        foreach ($interviews as $interview) {
            $start = Carbon::parse($interview->scheduled_at);
            $duration = (int) $interview->duration_minutes;
            $end = (clone $start)->addMinutes($duration);

            // Overlap check: (StartA < EndB) and (EndA > StartB)
            if ($newStart->lt($end) && $newEnd->gt($start)) {
                $candidateName = $interview->application->user->name ?? 'Candidate';
                $jobTitle = $interview->application->job->title ?? 'Position';
                return [
                    'has_overlap' => true,
                    'message' => "Schedule conflicts with interview for {$candidateName} ({$jobTitle}) at " . $start->format('H:i') . " - " . $end->format('H:i') . "."
                ];
            }
        }

        return ['has_overlap' => false];
    }

    /**
     * API to fetch booked slots on a specific date.
     */
    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $date = Carbon::parse($request->get('date'))->toDateString();

        $interviews = Interview::with(['application.user', 'application.job'])
            ->whereIn('status', ['scheduled', 'completed', 'rescheduled'])
            ->whereDate('scheduled_at', $date)
            ->get();

        $slots = $interviews->map(function($interview) {
            $start = Carbon::parse($interview->scheduled_at);
            $duration = (int) $interview->duration_minutes;
            $end = (clone $start)->addMinutes($duration);
            return [
                'id' => $interview->id,
                'candidate' => $interview->application->user->name ?? 'Candidate',
                'job' => $interview->application->job->title ?? 'Job',
                'start' => $start->format('H:i'),
                'end' => $end->format('H:i'),
                'start_time' => $start->toTimeString(),
                'end_time' => $end->toTimeString(),
                'duration' => $duration,
            ];
        });

        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }

    /**
     * Store a newly scheduled interview session.
     */
    public function store(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer',
            'interview_type' => 'required|in:online,offline',
            'location_or_link' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Check for schedule overlap
        $overlap = self::checkOverlap($request->scheduled_at, $request->duration_minutes);
        if ($overlap['has_overlap']) {
            return response()->json([
                'success' => false,
                'message' => $overlap['message']
            ], 422);
        }

        $application = Application::findOrFail($request->application_id);
        $oldStatus = $application->status;

        $interview = new Interview();
        $interview->application_id = $application->id;
        $interview->scheduled_by = auth()->id() ?? 1;
        $interview->scheduled_at = $request->scheduled_at;
        $interview->duration_minutes = $request->duration_minutes;
        $interview->interview_type = $request->interview_type;
        $interview->location_or_link = $request->location_or_link;
        $interview->status = 'scheduled';
        $interview->notes = $request->notes;
        $interview->save();

        // Update application status to 'interview'
        if ($application->status !== 'interview') {
            $application->status = 'interview';
            $application->save();

            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => $oldStatus,
                'new_status' => 'interview',
                'reason' => 'Scheduled ' . $request->interview_type . ' interview via Management System.',
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview session scheduled successfully.'
        ]);
    }

    /**
     * HR decision on an applicant's reschedule request: approve or decline.
     */
    public function rescheduleDecision(Request $request, $id)
    {
        $request->validate([
            'decision'        => 'required|in:approved,declined',
            'scheduled_at'    => 'required_if:decision,approved|nullable|date',
            'duration_minutes'=> 'required_if:decision,approved|nullable|integer',
            'interview_type'  => 'required_if:decision,approved|nullable|in:online,offline',
            'location_or_link'=> 'nullable|string',
            'decline_reason'  => 'required_if:decision,declined|nullable|string|max:500',
        ]);

        $interview = Interview::findOrFail($id);

        if ($request->decision === 'approved') {
            // Check overlap (excluding current interview)
            $overlap = self::checkOverlap($request->scheduled_at, $request->duration_minutes, $id);
            if ($overlap['has_overlap']) {
                return response()->json([
                    'success' => false,
                    'message' => $overlap['message']
                ], 422);
            }

            $oldScheduledAt = $interview->scheduled_at;

            $interview->scheduled_at              = $request->scheduled_at;
            $interview->duration_minutes          = $request->duration_minutes;
            $interview->interview_type            = $request->interview_type;
            $interview->location_or_link          = $request->location_or_link;
            $interview->status                    = 'scheduled';
            $interview->reschedule_request_status = 'approved';

            // Update notes with clean info about the approved reschedule
            $typeLabel = $request->interview_type === 'online' ? 'Online Meeting' : 'Offline (face-to-face)';
            $newSchedule = Carbon::parse($request->scheduled_at)->format('d M Y, H:i');
            $interview->notes = "Schedule updated after reschedule request was approved.\n"
                . "New schedule: {$newSchedule} WIB ({$request->duration_minutes} minutes)\n"
                . "Type: {$typeLabel}"
                . ($request->location_or_link ? "\nLocation/Link: {$request->location_or_link}" : '');

            $interview->save();

            // Notify applicant: request approved
            if ($interview->application) {
                NotificationService::create(
                    $interview->application->user_id,
                    'interview_scheduled',
                    'Reschedule Request Approved',
                    'Your reschedule request for the position of ' . ($interview->application->job->title ?? 'Job') . ' has been approved. New schedule: ' . Carbon::parse($request->scheduled_at)->format('d M Y, H:i') . '.',
                    [
                        'application_id' => $interview->application_id,
                        'interview_id'   => $interview->id,
                        'scheduled_at'   => $request->scheduled_at,
                        'interview_type' => $request->interview_type,
                    ]
                );

                DB::table('application_status_logs')->insert([
                    'application_id' => $interview->application_id,
                    'changed_by'     => auth()->id() ?? 1,
                    'old_status'     => $interview->application->status,
                    'new_status'     => $interview->application->status,
                    'reason'         => 'HR approved reschedule request. New schedule: ' . Carbon::parse($request->scheduled_at)->format('d M Y, H:i'),
                    'created_at'     => now(),
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Reschedule request approved. The new schedule has been confirmed.']);

        } else {
            // Decline: mark request as declined, revert status to scheduled (original schedule still stands)
            $interview->reschedule_request_status = 'declined';
            $interview->status                    = 'scheduled';
            $interview->save();

            // Notify applicant: request declined
            if ($interview->application) {
                $declineMsg = $request->decline_reason
                    ? 'Your reschedule request has been declined by HR. Reason: ' . $request->decline_reason . '. Please attend according to the original schedule.'
                    : 'Your reschedule request has been declined by HR. Please attend according to the original schedule.';

                NotificationService::create(
                    $interview->application->user_id,
                    'interview_scheduled',
                    'Reschedule Request Declined',
                    $declineMsg,
                    [
                        'application_id' => $interview->application_id,
                        'interview_id'   => $interview->id,
                    ]
                );

                DB::table('application_status_logs')->insert([
                    'application_id' => $interview->application_id,
                    'changed_by'     => auth()->id() ?? 1,
                    'old_status'     => $interview->application->status,
                    'new_status'     => $interview->application->status,
                    'reason'         => 'HR declined reschedule request. ' . ($request->decline_reason ? 'Reason: ' . $request->decline_reason : ''),
                    'created_at'     => now(),
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Reschedule request declined. The applicant will be notified.']);
        }
    }

    /**
     * Reschedule an existing interview session.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer',
            'interview_type' => 'required|in:online,offline',
            'location_or_link' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Check for schedule overlap (excluding current interview id)
        $overlap = self::checkOverlap($request->scheduled_at, $request->duration_minutes, $id);
        if ($overlap['has_overlap']) {
            return response()->json([
                'success' => false,
                'message' => $overlap['message']
            ], 422);
        }

        $interview = Interview::findOrFail($id);
        $oldScheduledAt = $interview->scheduled_at;
        
        $interview->scheduled_at = $request->scheduled_at;
        $interview->duration_minutes = $request->duration_minutes;
        $interview->interview_type = $request->interview_type;
        $interview->location_or_link = $request->location_or_link;
        $interview->notes = $request->notes;
        $interview->save();

        NotificationService::notifyInterviewRescheduled($interview, $oldScheduledAt);

        // Log the rescheduling
        $application = $interview->application;
        if ($application) {
            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => $application->status,
                'new_status' => $application->status,
                'reason' => 'Rescheduled interview from ' . $oldScheduledAt->format('d M Y H:i') . ' to ' . Carbon::parse($request->scheduled_at)->format('d M Y H:i'),
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview session rescheduled successfully.'
        ]);
    }

    /**
     * Update status of an interview session (completed, cancelled, scheduled).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $interview = Interview::findOrFail($id);
        $oldStatus = $interview->status;
        
        $interview->status = $request->status;
        if ($request->has('notes')) {
            $interview->notes = $request->notes;
        }
        $interview->save();

        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            NotificationService::notifyInterviewCancelled($interview);
            
            $application = $interview->application;
            if ($application && $application->status === 'interview') {
                $this->restorePreviousApplicationStatus($application);
            }
        }

        $application = $interview->application;
        if ($application) {
            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => $application->status,
                'new_status' => $application->status,
                'reason' => 'Interview status changed from ' . $oldStatus . ' to ' . $request->status . '. ' . ($request->notes ? 'Notes: ' . $request->notes : ''),
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview status updated successfully to ' . ucfirst($request->status)
        ]);
    }

    /**
     * Delete an interview session.
     */
    public function destroy($id)
    {
        $interview = Interview::findOrFail($id);
        $application = $interview->application;

        if ($application) {
            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => $application->status,
                'new_status' => $application->status,
                'reason' => 'Deleted interview session scheduled for ' . $interview->scheduled_at->format('d M Y H:i'),
                'created_at' => now(),
            ]);
        }

        NotificationService::notifyInterviewCancelled($interview);
        $interview->delete();

        if ($application && $application->status === 'interview') {
            $this->restorePreviousApplicationStatus($application);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview session deleted successfully.'
        ]);
    }

    /**
     * Revert application status to its previous status if no other scheduled interviews remain.
     */
    private function restorePreviousApplicationStatus($application)
    {
        if (!$application) return;

        // If there are still active scheduled interviews, do not revert status
        $hasActiveInterview = Interview::where('application_id', $application->id)
            ->where('status', 'scheduled')
            ->exists();
        if ($hasActiveInterview) return;

        // Find the last status before 'interview' in status logs
        $lastLog = DB::table('application_status_logs')
            ->where('application_id', $application->id)
            ->where('new_status', '!=', 'interview')
            ->orderBy('id', 'desc')
            ->first();

        // Fallback status if no log found
        $restoreStatus = $lastLog ? $lastLog->new_status : 'shortlisted';

        $oldStatus = $application->status;
        if ($oldStatus !== $restoreStatus) {
            $application->status = $restoreStatus;
            $application->save();

            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => $oldStatus,
                'new_status' => $restoreStatus,
                'reason' => 'Interview cancelled or deleted. Status reverted to ' . $restoreStatus . '.',
                'created_at' => now(),
            ]);

            // Notify user about reverting status
            NotificationService::notifyStatusChange($application, $restoreStatus);
        }
    }
}
