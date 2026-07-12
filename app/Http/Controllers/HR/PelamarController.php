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
        // Auto-run migrations if any columns are missing or if bio column still exists in user_profiles
        if (!\Illuminate\Support\Facades\Schema::hasColumn('job_postings', 'is_archived') || 
            !\Illuminate\Support\Facades\Schema::hasColumn('applications', 'is_seen') || 
            \Illuminate\Support\Facades\Schema::hasColumn('user_profiles', 'bio')) {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        }

        // 1. Calculate stats for cards
        $totalApplicants = Application::count();
        $submittedCount  = Application::where('status', 'applied')->count();
        $shortlistedCount = Application::where('status', 'shortlisted')->count();
        $interviewCount  = Application::where('status', 'interview')->count();
        $acceptedCount   = Application::where('status', 'accepted')->count();
        $rejectedCount   = Application::where('status', 'rejected')->count();
        $decisionCount   = Application::whereIn('status', ['shortlisted'])->count();

        // 2. Fetch non-archived job postings
        $jobs = JobPosting::with(['category', 'applications.user.profile'])
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $lowonganList = [];
        $deptList = [];

        foreach ($jobs as $index => $job) {
            $applications = $job->applications;

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

            $lowonganList[] = [
                'id' => $job->id,
                'title' => $job->title,
                'status' => $job->status,
                'department' => $deptName,
                'total' => $applications->count(),
                'posted' => $job->created_at ? $job->created_at->format('d M Y') : 'N/A',
                'days_since' => $job->created_at ? $job->created_at->diffInDays(now()) : 30,
                'deadline_days' => $job->deadline ? now()->diffInDays($job->deadline, false) : 30,
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
    public function cvPreview($id)
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
        $linkedin = e(optional($profile)->linkedin_url ?? '');
        $bio      = e(optional($profile)->bio ?? '');

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
                $works, $educations, $organizations, $skills
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
</style>
</head><body>
<div class="page">
' . $blocksHtml . '
</div>
</body></html>';

        return response($html, 200, ['Content-Type' => 'text/html; charset=utf-8']);
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
            'interview_type' => 'required|in:online,offline,phone',
            'location_or_link' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Check for schedule overlap
        $overlap = \App\Http\Controllers\HR\InterviewController::checkOverlap($request->scheduled_at, $request->duration_minutes);
        if ($overlap['has_overlap']) {
            return response()->json([
                'success' => false,
                'message' => $overlap['message']
            ], 422);
        }

        $application = Application::findOrFail($id);
        $oldStatus = $application->status;

        // 1. Create interview record
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
                'reason' => 'Scheduled ' . $request->interview_type . ' interview. Notes: ' . ($request->notes ?? '-'),
                'created_at' => now(),
            ]);
        } else {
            // Log interview addition without status change
            DB::table('application_status_logs')->insert([
                'application_id' => $application->id,
                'changed_by' => auth()->id() ?? 1,
                'old_status' => 'interview',
                'new_status' => 'interview',
                'reason' => 'Scheduled new interview: ' . $request->interview_type . ' interview.',
                'created_at' => now(),
            ]);
        }

        // Notify the applicant about the scheduled interview
        $interview->load('application.job');
        NotificationService::notifyInterviewScheduled($interview);

        return response()->json([
            'success' => true,
            'message' => 'Interview scheduled successfully.'
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
        $application = \App\Models\Application::findOrFail($id);
        $vacancy = \App\Models\JobPosting::findOrFail($application->job_id);
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
        $works, $educations, $organizations, $skills
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
            $job->update(['is_archived' => true]);

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
