<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPosting;
use App\Models\Interview;
use App\Models\CvTemplate;
use App\Models\Education;
use App\Models\WorkExperience;
use App\Models\OrganizationExperience;
use App\Models\ApplicantSkill;
use App\Models\Portofolio;
use App\Models\UserProfile;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelamarController extends Controller
{
    /**
     * Display a listing of applicants grouped by vacancies.
     */
    public function index()
    {
        // 1. Calculate stats for cards (excluding archived vacancies)
        $totalApplicants = Application::whereHas('job', function ($q) {
            $q->where('is_archived', false);
        })->whereHas('user')->count();
        $submittedCount  = Application::where('status', 'applied')
            ->whereHas('job', function ($q) {
                $q->where('is_archived', false);
            })->whereHas('user')->count();
        $shortlistedCount = Application::where('status', 'shortlisted')
            ->whereHas('job', function ($q) {
                $q->where('is_archived', false);
            })->whereHas('user')->count();
        $interviewCount  = Application::where('status', 'interview')
            ->whereHas('job', function ($q) {
                $q->where('is_archived', false);
            })->whereHas('user')->count();
        $acceptedCount   = Application::where('status', 'accepted')
            ->whereHas('job', function ($q) {
                $q->where('is_archived', false);
            })->whereHas('user')->count();
        $rejectedCount   = Application::where('status', 'rejected')
            ->whereHas('job', function ($q) {
                $q->where('is_archived', false);
            })->whereHas('user')->count();
        $decisionCount   = Application::whereIn('status', ['shortlisted'])
            ->whereHas('job', function ($q) {
                $q->where('is_archived', false);
            })->whereHas('user')->count();

        // 2. Fetch job postings (both active and archived)
        $jobs = JobPosting::with(['category', 'applications.user.profile'])
            ->orderBy('created_at', 'desc')
            ->get();

        $lowonganList = [];
        $deptList = [];

        foreach ($jobs as $index => $job) {
            $applications = $job->applications->sortByDesc('created_at');

            // Collect unique departments for the view dropdown filter
            $deptName = $job->category ? $job->category->name : 'General';
            if (!in_array($deptName, $deptList)) {
                $deptList[] = $deptName;
            }

            // If a job posting has no applicants, we can still list it or skip it based on preference.
            // Let's include it so HR sees all vacancies, but filter it dynamically
            $pelamarData = [];
            foreach ($applications as $appIdx => $app) {
                $user = $app->user;
                if (!$user) continue;

                $profile = $user->profile;
                $name = $user->name;
                $initials = $this->getInitials($name);
                $color = $this->getAvatarColor($name);

                // Calculate a mock assessment score based on GPA, skills and experience for premium feel
                $gpa = $profile ? ($profile->gpa ?? 3.0) : 3.0;
                $score = round($gpa * 22); // e.g. 3.8 GPA * 22 = 83.6
                // Add points for each experience & skill
                $skillsCount = ApplicantSkill::where('user_id', $user->id)->count();
                $expCount = WorkExperience::where('user_id', $user->id)->count();
                $score += ($skillsCount * 2) + ($expCount * 3);
                $score = min(98, max(50, $score)); // Caps between 50 and 98

                // Map database status 'applied' to view status 'submitted'
                $viewStatus = $app->status === 'applied' ? 'submitted' : $app->status;

                $pelamarData[] = [
                    'id' => $app->id,
                    'name' => $name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '-',
                    'gpa' => $profile ? ($profile->gpa ?? '-') : '-',
                    'date' => $app->created_at ? $app->created_at->format('d M Y') : 'N/A',
                    'status' => $viewStatus,
                    'score' => $score,
                    'avatar' => $initials,
                    'color' => $color,
                    'is_seen' => (bool)$app->is_seen,
                ];
            }

            $unreviewed = $applications->whereIn('status', ['applied', 'shortlisted'])->count();
            $interviewCountJob = $applications->where('status', 'interview')->count();
            $decisionCountJob = $applications->whereIn('status', ['shortlisted'])->count();

            $newApplicantsCount = $applications->where('is_seen', false)->count();

            // Calculate countdown text
            $now = \Carbon\Carbon::now('Asia/Jakarta');
            $deadline = $job->deadline ? \Carbon\Carbon::parse($job->deadline->format('Y-m-d'), 'Asia/Jakarta')->endOfDay() : null;
            $countdownText = '';
            if ($deadline) {
                if ($now->greaterThan($deadline)) {
                    $countdownText = 'Deadline Passed';
                } else {
                    $diff = $now->diff($deadline);
                    if ($diff->days > 0) {
                        $countdownText = 'Deadline ' . $diff->days . 'd ' . $diff->h . 'h left';
                    } else if ($diff->h > 0) {
                        $countdownText = 'Deadline ' . $diff->h . 'h ' . $diff->i . 'm left';
                    } else {
                        $countdownText = 'Deadline ' . $diff->i . 'm left';
                    }
                }
            } else {
                $countdownText = 'No deadline';
            }

            $lowonganList[] = [
                'id' => $job->id,
                'title' => $job->title,
                'status' => $job->status,
                'department' => $deptName,
                'total' => $applications->count(),
                'posted' => $job->created_at ? $job->created_at->format('d M Y') : 'N/A',
                'days_since' => $job->created_at ? $job->created_at->diffInDays($now) : 30,
                'deadline_days' => $job->deadline ? $now->diffInDays($deadline, false) : 30,
                'auto_close_method' => $job->auto_close_method,
                'quota' => $job->quota,
                'new_applicants_count' => $newApplicantsCount,
                'countdown_text' => $countdownText,
                'deadline_timestamp' => $deadline ? $deadline->toIso8601String() : null,
                'is_archived' => (bool)$job->is_archived,
                'counts' => [
                    'submitted' => $applications->where('status', 'applied')->count(),
                    'shortlisted' => $applications->where('status', 'shortlisted')->count(),
                    'interview' => $applications->where('status', 'interview')->count(),
                    'accepted' => $applications->where('status', 'accepted')->count(),
                    'rejected' => $applications->where('status', 'rejected')->count(),
                ],
                'unreviewed' => $unreviewed,
                'interview' => $interviewCountJob,
                'decision' => $decisionCountJob,
                'expanded' => $index === 0, // Expand the first card by default
                'pelamar' => $pelamarData,
            ];
        }

        return view('hr.pelamar', compact(
            'totalApplicants',
            'submittedCount',
            'shortlistedCount',
            'interviewCount',
            'acceptedCount',
            'rejectedCount',
            'decisionCount',
            'lowonganList',
            'deptList'
        ));
    }

    /**
     * Show detail page for a specific applicant (via application ID).
     */
    public function show($id)
    {
        $application = Application::with([
            'user.profile',
            'user.educations',
            'user.workExperiences',
            'user.organizationExperiences',
            'job.category',
            'cv'
        ])->findOrFail($id);

        if (!$application->is_seen) {
            $application->is_seen = true;
            $application->save();
        }

        $user = $application->user;
        $profile = $user->profile;

        // Calculate age
        $age = 'N/A';
        if ($profile && $profile->birth_date) {
            $age = $profile->birth_date->age . ' Years Old';
        }

        // Get activity/status log history
        $statusLogs = DB::table('application_status_logs')
            ->join('users', 'application_status_logs.changed_by', '=', 'users.id')
            ->where('application_id', $application->id)
            ->select('application_status_logs.*', 'users.name as changer_name', 'users.role as changer_role')
            ->orderBy('created_at', 'desc')
            ->get();

        // Retrieve the closest upcoming interview session
        $nextInterview = Interview::with(['result.reviewer'])
            ->where('application_id', $application->id)
            ->where('scheduled_at', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at', 'asc')
            ->first();

        // Get all interviews for this application (historical list)
        $interviews = Interview::with(['result.reviewer', 'scheduler'])
            ->where('application_id', $application->id)
            ->orderBy('scheduled_at', 'desc')
            ->get();

        $educations = $user->educations()->orderByDesc('end_year')->get();
        $latestEducation = $educations->first();
        $workExperiences = $user->workExperiences()->orderByDesc('start_date')->get();
        $organizationExperiences = $user->organizationExperiences()->orderByDesc('start_date')->get();
        $skills = ApplicantSkill::where('user_id', $user->id)->orderBy('skill_name')->get();

        return view('hr.pelamar-detail', compact(
            'application',
            'user',
            'profile',
            'age',
            'statusLogs',
            'nextInterview',
            'interviews',
            'educations',
            'latestEducation',
            'workExperiences',
            'organizationExperiences',
            'skills'
        ));
    }

    /**
     * Generate dynamic CV HTML for the preview iframe on the detail page.
     */
    public function cvPreview(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $user = $application->user;
        if (!$user) {
            return response('User not found', 404);
        }

        $profile       = UserProfile::where('user_id', $user->id)->first();
        $works         = WorkExperience::where('user_id', $user->id)->orderByDesc('start_date')->get();
        $educations    = Education::where('user_id', $user->id)->orderByDesc('start_year')->get();
        $organizations = OrganizationExperience::where('user_id', $user->id)->orderByDesc('start_date')->get();
        $skills        = ApplicantSkill::where('user_id', $user->id)->get();
        $portos        = Portofolio::where('user_id', $user->id)->get();

        // Try to fetch primary template or fallback to first
        $template = CvTemplate::where('status', 'published')->orderByDesc('is_default')->first();
        if (!$template) {
            $template = CvTemplate::first();
        }

        $templateHtml = $template ? $template->content_html : '';

        // Extract block types
        preg_match_all('/data-type="([^"]+)"/', $templateHtml, $matches);
        $blockTypes = $matches[1] ?? [];

        $accentColor = '#0f3c20';
        $initials = $this->getInitials($user->name);
        $name = e($user->name);
        $latestJob = $works->first();
        $position  = $latestJob ? e($latestJob->position) : ($user->job_title ? e($user->job_title) : 'Applicant');

        $email    = e($user->email);
        $phone    = e($user->phone ?? (optional($profile)->phone ?? ''));
        $city     = e(optional($profile)->city ?? '');
        $province = e(optional($profile)->province ?? '');
        // Kolom linkedin_url & bio telah dihapus via migration (drop_bio_and_linkedin_url)
        $linkedin = '';
        $bio      = '';

        $blocksHtml = '';

        if (empty($blockTypes)) {
            $blockTypes = ['header', 'contact', 'summary', 'exp', 'edu', 'skills'];
        }

        // Reuse the logic from ApplicantCvController
        foreach ($blockTypes as $type) {
            $blocksHtml .= $this->renderBlockHtml(
                $type, $accentColor,
                $name, $initials, $position,
                $email, $phone, $city, $province, $linkedin, $bio,
                $works, $educations, $organizations, $skills, $portos
            );
        }

        if (!in_array('certificates', $blockTypes)) {
            $blocksHtml .= $this->renderBlockHtml(
                'certificates', $accentColor,
                $name, $initials, $position,
                $email, $phone, $city, $province, $linkedin, $bio,
                $works, $educations, $organizations, $skills, $portos
            );
        }

        if (!in_array('portfolio', $blockTypes)) {
            $blocksHtml .= $this->renderBlockHtml(
                'portfolio', $accentColor,
                $name, $initials, $position,
                $email, $phone, $city, $province, $linkedin, $bio,
                $works, $educations, $organizations, $skills, $portos
            );
        }

$html = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>CV — ' . $name . '</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:#fff;display:flex;flex-direction:column;align-items:center;
     padding:0;font-family:\'Segoe UI\',sans-serif}
.page{width:595px;background:#fff;min-height:842px;}
.blk{position:relative}
@media print{
  body{background:#fff;padding:0}
  .page{width:100%}
}
</style>';

        if ($request->has('download')) {
            $html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const element = document.querySelector(".page");
        const opt = {
            margin:       0,
            filename:     "CV_' . str_replace("'", "\\'", str_replace(' ', '_', $name)) . '.pdf",
            image:        { type: "jpeg", quality: 0.98 },
            html2canvas:  { scale: 2.5, useCORS: true, logging: false },
            jsPDF:        { unit: "mm", format: "a4", orientation: "portrait" }
        };
        
        html2pdf().set(opt).from(element).save().then(() => {
            setTimeout(() => {
                window.close();
            }, 1500);
        }).catch(err => {
            console.error("PDF generation failed:", err);
        });
    });
</script>';
        }

        $html .= '</head><body>
<div class="page">
' . $blocksHtml . '
</div>
</body></html>';

        $headers = ['Content-Type' => 'text/html; charset=utf-8'];
        
        return response($html, 200, $headers);
    }

    /**
     * Update applicant status.
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $oldStatus = $application->status;
        $newStatus = $request->input('status');

        $request->validate([
            'status' => 'required|in:shortlisted,interview,accepted,rejected',
        ]);

        // If trying to accept without prior interview, make reason / justification mandatory
        if ($newStatus === 'accepted' && $oldStatus !== 'interview') {
            $request->validate([
                'reason' => 'required|string|min:5',
            ], [
                'reason.required' => 'Reason for skipping the interview stage is required.',
                'reason.min' => 'The reason must be at least 5 characters.',
            ]);
        } else {
            $request->validate([
                'reason' => 'nullable|string',
            ]);
        }

        // Guard: reject if status is not actually changing
        if ($oldStatus === $newStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Applicant status is already ' . ucfirst($newStatus) . '. No change was made.',
            ], 422);
        }

        $application->status = $newStatus;
        if ($request->has('reason')) {
            $application->hr_notes = $request->reason;
        }
        $application->save();

        // Log the status change
        DB::table('application_status_logs')->insert([
            'application_id' => $application->id,
            'changed_by' => auth()->id() ?? 1, // fallback to ID 1 if not authenticated for some reason
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'reason' => $request->reason ?? 'Status changed by HR.',
            'created_at' => now(),
        ]);

        // Notify the applicant about status change
        $application->load('job');
        NotificationService::notifyStatusChange($application, $newStatus);

        return response()->json([
            'success' => true,
            'message' => 'Status successfully updated to ' . ucfirst($newStatus),
            'status' => $newStatus
        ]);
    }

    /**
     * Save an internal HR note (without changing status).
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $application = Application::findOrFail($id);

        // Add note as a status log where old_status = new_status
        DB::table('application_status_logs')->insert([
            'application_id' => $application->id,
            'changed_by' => auth()->id() ?? 1,
            'old_status' => $application->status,
            'new_status' => $application->status,
            'reason' => $request->note,
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note added successfully.'
        ]);
    }

    /**
     * Schedule a new interview session.
     */
    public function scheduleInterview(Request $request, $id)
    {
        $request->validate([
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer',
            'interview_type' => 'required|in:online,offline', // Konsisten dengan InterviewController::store()
            'location_or_link' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $application = Application::findOrFail($id);
        $oldStatus = $application->status;

        // Check if there is an existing scheduled interview for this application
        $interview = Interview::where('application_id', $application->id)
            ->where('status', 'scheduled')
            ->first();

        $isNew = !$interview;
        $excludeId = $isNew ? null : $interview->id;

        // Check for schedule overlap (excluding our own interview if we're updating it)
        $overlap = \App\Http\Controllers\HR\InterviewController::checkOverlap($request->scheduled_at, $request->duration_minutes, $excludeId);
        if ($overlap['has_overlap']) {
            return response()->json([
                'success' => false,
                'message' => $overlap['message']
            ], 422);
        }

        if ($isNew) {
            $interview = new Interview();
            $interview->application_id = $application->id;
            $interview->scheduled_by = auth()->id() ?? 1;
        }

        $interview->scheduled_at = $request->scheduled_at;
        $interview->duration_minutes = $request->duration_minutes;
        $interview->interview_type = $request->interview_type;
        $interview->location_or_link = $request->location_or_link;
        $interview->status = 'scheduled';
        $interview->notes = $request->notes;
        $interview->save();

        // 2. Update application status to 'interview' if it isn't already
        if ($application->status !== 'interview') {
            $application->status = 'interview';
            $application->save();

            // Log status change
            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => $oldStatus,
                'new_status' => 'interview',
                'reason' => ($isNew ? 'Scheduled ' : 'Updated schedule for ') . $request->interview_type . ' interview. Notes: ' . ($request->notes ?? '-'),
                'created_at' => now(),
            ]);
        } else {
            // Log interview addition/update without status change
            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => 'interview',
                'new_status' => 'interview',
                'reason' => $isNew 
                    ? ('Scheduled new interview: ' . $request->interview_type . ' interview.') 
                    : ('Updated existing interview schedule to: ' . $request->interview_type . ' interview.'),
                'created_at' => now(),
            ]);
        }

        // Notify the applicant about the scheduled interview
        $interview->load('application.job');
        NotificationService::notifyInterviewScheduled($interview);

        return response()->json([
            'success' => true,
            'message' => $isNew ? 'Interview scheduled successfully.' : 'Interview schedule updated successfully.'
        ]);
    }

    /**
     * Submit interview result/evaluation.
     */
    public function evaluateInterview(Request $request, $id, $interviewId)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'required|string|min:5',
            'recommendation' => 'required|in:proceed,hold,reject',
            'attendance_status' => 'nullable|in:pending,present,absent',
        ]);

        $interview = Interview::where('application_id', $id)->findOrFail($interviewId);

        // Fetch vacancy passing grade
        $application = Application::findOrFail($id);
        $vacancy = JobPosting::findOrFail($application->job_id);
        $passingGrade = $vacancy->passing_grade ?? 70;

        if ($request->recommendation === 'proceed' && $request->score < $passingGrade) {
            return response()->json([
                'success' => false,
                'message' => "The 'PROCEED' recommendation is not allowed because the score ({$request->score}) is less than this vacancy's passing grade ({$passingGrade})."
            ], 422);
        }

        // Update or insert result with trigger exception handling
        try {
            DB::table('interview_results')->updateOrInsert(
                ['interview_id' => $interview->id],
                [
                    'reviewed_by' => auth()->id() ?? 1,
                    'score' => $request->score,
                    'feedback' => $request->feedback,
                    'recommendation' => $request->recommendation,
                    'created_at' => now(),
                ]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '45000' || str_contains($e->getMessage(), '45000')) {
                $message = $e->getMessage();
                if (preg_match('/SQLSTATE\[45000\]: [^:]+: (.+)/', $message, $matches)) {
                    $message = trim($matches[1]);
                }
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }
            throw $e;
        }

        // Update interview status to completed and attendance status if provided
        $interview->status = 'completed';
        if ($request->has('attendance_status')) {
            $interview->attendance_status = $request->attendance_status;
            if ($request->attendance_status === 'present' && !$interview->attendance_confirmed_at) {
                $interview->attendance_confirmed_at = now();
            }
        }
        $interview->save();

        // Optional: auto-log this evaluation to application status log
        DB::table('application_status_logs')->insert([
            'application_id' => $id,
            'changed_by' => auth()->id() ?? 1,
            'old_status' => 'interview',
            'new_status' => 'interview',
            'reason' => 'Evaluated interview. Recommendation: ' . strtoupper($request->recommendation) . '. Score: ' . $request->score . '/100. Feedback: ' . substr($request->feedback, 0, 50) . '...',
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Interview evaluation saved successfully.'
        ]);
    }

    /**
     * Toggle applicant's system access privilege.
     */
    public function togglePrivilege(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $user = $application->user;
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Applicant user not found.'
            ], 404);
        }

        // Toggle the has_privilege attribute
        $user->has_privilege = !$user->has_privilege;
        $user->save();

        // Send system notification
        NotificationService::notifyPrivilegeChange($user, $user->has_privilege);

        $statusStr = $user->has_privilege ? 'granted' : 'revoked';

        // Log this change to application status logs for administrative history
        DB::table('application_status_logs')->insert([
            'application_id' => $application->id,
            'changed_by' => auth()->id() ?? 1,
            'old_status' => $application->status,
            'new_status' => $application->status,
            'reason' => 'Applicant access privilege ' . $statusStr . ' by HR.',
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Applicant access privilege successfully ' . $statusStr . '.',
            'has_privilege' => $user->has_privilege
        ]);
    }

    // --- HELPER METHODS ---

    private function getInitials($name)
    {
        $words = explode(' ', trim($name));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            if (!empty($w)) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
        }
        return $initials ?: 'AP';
    }

    private function getAvatarColor($name)
    {
        $colors = ['bg-blue-500', 'bg-pink-500', 'bg-amber-500', 'bg-red-400', 'bg-purple-500', 'bg-teal-500', 'bg-green-600', 'bg-indigo-500', 'bg-rose-500'];
        $hash = crc32($name);
        return $colors[abs($hash) % count($colors)];
    }

    private function renderBlockHtml(
        string $type, string $accent,
        string $name, string $initials, string $position,
        string $email, string $phone, string $city, string $province, string $linkedin, string $bio,
        $works, $educations, $organizations, $skills, $portos = null
    ): string {
        switch ($type) {
            case 'header':
                return '<div class="blk" data-type="header">
                    <div style="display:flex;align-items:center;gap:16px;padding:20px 28px">
                        <div style="width:64px;height:64px;border-radius:50%;background:' . $accent . ';flex-shrink:0;
                             display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;color:#fff">
                            ' . $initials . '
                        </div>
                        <div>
                            <div style="font-size:20px;font-weight:800;color:#111">' . $name . '</div>
                            ' . ($position ? '<div style="font-size:12px;font-weight:600;margin-top:3px;color:' . $accent . '">' . $position . '</div>' : '') . '
                        </div>
                    </div>
                </div>';

            case 'contact':
                $parts = [];
                if ($email)    $parts[] = '&#9993; ' . $email;
                if ($phone)    $parts[] = '&#128222; ' . $phone;
                if ($city)     $parts[] = '&#128205; ' . $city . ($province ? ', ' . $province : '');
                if ($linkedin) $parts[] = '&#128279; ' . $linkedin;
                return '<div class="blk" data-type="contact">
                    <div style="padding:10px 28px;background:#f9fafb;font-size:11px;color:#374151;
                          display:flex;flex-wrap:wrap;gap:6px 20px">
                        ' . implode('', array_map(fn($p) => '<span>' . $p . '</span>', $parts)) . '
                    </div>
                </div>';

            case 'summary':
                if (!$bio) return '';
                return '<div class="blk" data-type="summary">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:8px">Profile Summary</div>
                        <p style="font-size:11px;line-height:1.7;color:#374151;margin:0;
                           border-left:3px solid ' . $accent . ';padding-left:10px">' . $bio . '</p>
                    </div>
                </div>';

            case 'exp':
                $inner = '';
                if ($works->count()) {
                    foreach ($works as $w) {
                        $s   = $w->start_date ? $w->start_date->format('M Y') : '';
                        $end = $w->is_current ? 'Present' : ($w->end_date ? $w->end_date->format('M Y') : '');
                        $inner .= '<div style="margin-bottom:12px">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                                <div>
                                    <div style="font-size:12px;font-weight:700;color:#111">' . e($w->position) . '</div>
                                    <div style="font-size:11px;color:#6b7280">' . e($w->company_name) . '</div>
                                </div>
                                <div style="font-size:10px;color:#9ca3af;white-space:nowrap">' . $s . ' &ndash; ' . $end . '</div>
                            </div>
                            ' . ($w->description ? '<p style="font-size:10px;color:#374151;margin:4px 0 0 0;line-height:1.5">' . e($w->description) . '</p>' : '') . '
                        </div>';
                    }
                } else {
                    $inner = '<p style="font-size:11px;color:#9ca3af">No work experience recorded.</p>';
                }
                return '<div class="blk" data-type="exp">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px">Work Experience</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'edu':
                $inner = '';
                if ($educations->count()) {
                    foreach ($educations as $edu) {
                        $inner .= '<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
                            <div>
                                <div style="font-size:12px;font-weight:700;color:#111">' . e($edu->degree) . ' — ' . e($edu->major) . '</div>
                                <div style="font-size:11px;color:#6b7280">' . e($edu->institution) . '</div>
                                ' . ($edu->gpa ? '<div style="font-size:10px;color:#9ca3af">GPA: ' . $edu->gpa . '</div>' : '') . '
                            </div>
                            <div style="font-size:10px;color:#9ca3af;white-space:nowrap">' . $edu->start_year . ' &ndash; ' . $edu->end_year . '</div>
                        </div>';
                    }
                } else {
                    $inner = '<p style="font-size:11px;color:#9ca3af">No education data recorded.</p>';
                }
                return '<div class="blk" data-type="edu">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px">Education</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'org':
            case 'organisasi':
                if ($organizations->isEmpty()) return '';
                $inner = '';
                foreach ($organizations as $org) {
                    $e   = $org->end_date ? $org->end_date->format('Y') : 'Present';
                    $inner .= '<div style="margin-bottom:8px">
                        <div style="font-size:12px;font-weight:700;color:#111">' . e($org->position) . '</div>
                        <div style="font-size:11px;color:#6b7280">' . e($org->organization_name) . ' &bull; ' . ($org->start_date ? $org->start_date->format('Y') : '') . '&ndash;' . $e . '</div>
                    </div>';
                }
                return '<div class="blk" data-type="org">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px">Organization</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'skills':
                $inner = '';
                if ($skills->count()) {
                    foreach ($skills as $s) {
                        $inner .= '<span style="background:#f0fdf4;color:' . $accent . ';font-size:10px;font-weight:600;
                                   padding:2px 9px;border-radius:20px;border:1px solid #bbf7d0;margin:2px">'
                                 . e($s->skill_name) . '</span>';
                    }
                } else {
                    $inner = '<span style="font-size:11px;color:#9ca3af">No skills recorded.</span>';
                }
                return '<div class="blk" data-type="skills">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:8px">Skills</div>
                        <div style="display:flex;flex-wrap:wrap;gap:4px">' . $inner . '</div>
                    </div>
                </div>';

            case 'certificates':
                $inner = '';
                $hasCerts = false;
                if ($skills && $skills->count()) {
                    foreach ($skills as $s) {
                        if ($s->cert_name || $s->cert_file_path) {
                            $hasCerts = true;
                            $certTitle = e($s->cert_name ?: $s->skill_name . ' Certificate');
                            $skillTag = e($s->skill_name);
                            $imgHtml = '';
                            if ($s->cert_file_path) {
                                $ext = strtolower(pathinfo($s->cert_file_path, PATHINFO_EXTENSION));
                                $fileUrl = asset('storage/' . $s->cert_file_path);
                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                                    $imgHtml = '<div style="margin-top:6px;"><img src="' . $fileUrl . '" alt="' . $certTitle . '" style="max-width:100%;max-height:180px;border-radius:6px;border:1px solid #e2e8f0;object-fit:contain;"></div>';
                                } else {
                                    $imgHtml = '<div style="margin-top:4px;"><a href="' . $fileUrl . '" target="_blank" style="font-size:10px;color:#15803d;text-decoration:underline;">📄 View Certificate File (' . strtoupper($ext) . ')</a></div>';
                                }
                            }
                            $inner .= '<div style="margin-bottom:12px;padding:8px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;">
                                    <div style="font-size:11px;font-weight:700;color:#1e293b;">📜 ' . $certTitle . '</div>
                                    <span style="font-size:9px;background:#e2e8f0;color:#334155;padding:1px 6px;border-radius:4px;">' . $skillTag . '</span>
                                </div>
                                ' . $imgHtml . '
                            </div>';
                        }
                    }
                }
                if (!$hasCerts) return '';
                return '<div class="blk" data-type="certificates">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px;border-bottom:1.5px solid ' . $accent . ';padding-bottom:4px">Certificates & Credentials</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'portfolio':
                if (!$portos || $portos->isEmpty()) return '';
                $inner = '';
                foreach ($portos as $p) {
                    $pTitle = e($p->title);
                    $pDesc = e($p->description ?? '');
                    $pLink = $p->link_url ? e($p->link_url) : '';
                    $pFile = $p->file_url;
                    
                    $linkHtml = '';
                    if ($pLink) {
                        $linkHtml = '<div style="margin-top:4px;font-size:10px;"><a href="' . $pLink . '" target="_blank" style="color:#2563eb;text-decoration:underline;word-break:break-all;">🔗 ' . $pLink . '</a></div>';
                    }

                    $imgHtml = '';
                    if ($pFile) {
                        $ext = strtolower(pathinfo($pFile, PATHINFO_EXTENSION));
                        $fileUrl = asset('storage/' . $pFile);
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                            $imgHtml = '<div style="margin-top:6px;"><img src="' . $fileUrl . '" alt="' . $pTitle . '" style="max-width:100%;max-height:220px;border-radius:6px;border:1px solid #e2e8f0;object-fit:contain;"></div>';
                        } else {
                            $imgHtml = '<div style="margin-top:4px;"><a href="' . $fileUrl . '" target="_blank" style="font-size:10px;color:#15803d;text-decoration:underline;">📁 View Portfolio File (' . strtoupper($ext) . ')</a></div>';
                        }
                    }

                    $inner .= '<div style="margin-bottom:14px;padding:10px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;">
                        <div style="font-size:12px;font-weight:700;color:#0f172a;">💼 ' . $pTitle . '</div>
                        ' . ($pDesc ? '<p style="font-size:10px;color:#475569;margin:4px 0;line-height:1.5;">' . $pDesc . '</p>' : '') . '
                        ' . $imgHtml . '
                        ' . $linkHtml . '
                    </div>';
                }

                return '<div class="blk" data-type="portfolio">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px;border-bottom:1.5px solid ' . $accent . ';padding-bottom:4px">Portfolio & Projects</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'div':
                return '<div class="blk" data-type="div">
                    <div style="padding:4px 0">
                        <hr style="border:none;border-top:1px solid #e5e7eb;margin:0 28px">
                    </div>
                </div>';

            default:
                return '';
        }
    }

    /**
     * Mark all applications of a specific vacancy as seen (AJAX).
     */
    public function markSeen($id)
    {
        try {
            Application::where('job_id', $id)
                ->where('is_seen', false)
                ->update(['is_seen' => true]);

            return response()->json([
                'success' => true,
                'message' => 'All applications marked as seen.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Archive/hide a job vacancy.
     */
    public function archive($id)
    {
        try {
            $job = JobPosting::with('applications')->findOrFail($id);

            // Validation: Cannot archive if vacancy is open
            if ($job->status === 'open') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot archive an active/open vacancy. Please close the vacancy first.'
                ], 400);
            }

            // Validation: Cannot archive if there are undecided candidates (applied, shortlisted, interview)
            $undecidedCount = $job->applications->whereIn('status', ['applied', 'shortlisted', 'interview'])->count();
            if ($undecidedCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot archive vacancy. There are still ' . $undecidedCount . ' undecided candidates.'
                ], 400);
            }

            // Update is_archived = true
            $job->is_archived = true;
            $job->save();

            return response()->json([
                'success' => true,
                'message' => 'Vacancy archived successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
