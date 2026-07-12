<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\User;
use App\Models\Application;
use App\Models\Interview;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Active vacancies count
        $activeVacanciesCount = JobPosting::where('status', 'open')->count();

        // 2. Total applicants today & overall
        $applicantsToday = Application::whereDate('created_at', now()->toDateString())->count();
        $applicantsOverall = Application::count();

        // 3. Interviews this week & overall
        $interviewsThisWeek = Interview::whereBetween('scheduled_at', [
            now()->startOfWeek()->toDateTimeString(),
            now()->endOfWeek()->toDateTimeString()
        ])->count();
        $interviewsOverall = Interview::count();

        // --- CALCULATE ADDED / REMOVED CHANGE INDICATORS ---
        // Active Vacancies
        $vacanciesAdded = JobPosting::whereIn('status', ['open', 'closed'])->count();
        $vacanciesRemoved = JobPosting::where('status', 'closed')->count();

        // Applicants (Today)
        $applicantsTodayAdded = Application::whereDate('created_at', now()->toDateString())->count();
        $applicantsTodayRemoved = \DB::table('application_status_logs')
            ->where('new_status', 'withdrawn')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        // Applicants (Overall)
        $applicantsOverallAdded = Application::count();
        $applicantsOverallRemoved = \DB::table('application_status_logs')
            ->where('new_status', 'withdrawn')
            ->count();

        // Interviews (Week)
        $interviewsWeekAdded = Interview::whereBetween('created_at', [
            now()->startOfWeek()->toDateTimeString(),
            now()->endOfWeek()->toDateTimeString()
        ])->count();
        $interviewsWeekRemoved = Interview::where('status', 'cancelled')
            ->whereBetween('updated_at', [
                now()->startOfWeek()->toDateTimeString(),
                now()->endOfWeek()->toDateTimeString()
            ])->count();

        // Interviews (Overall / Scheduled)
        $interviewsOverallAdded = Interview::count();
        $interviewsOverallRemoved = Interview::where('status', 'cancelled')->count();

        // 4. Recruitment trends for chart (100% database-driven calendar months Jan-Dec)
        $monthlyTrends = [];
        $currentYear = now()->year;
        for ($m = 1; $m <= 12; $m++) {
            $monthDate = now()->setDate($currentYear, $m, 1);
            $label = strtoupper($monthDate->format('M'));
            $dbCount = Application::whereMonth('created_at', $m)
                ->whereYear('created_at', $currentYear)
                ->count();
            $monthlyTrends[$label] = $dbCount;
        }

        $weeklyTrends = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $label = strtoupper($day->format('D'));
            $dbCount = Application::whereDate('created_at', $day->toDateString())->count();
            $weeklyTrends[$label] = $dbCount;
        }

        // 5. Active vacancies list
        $activeVacancies = JobPosting::with('category')
            ->withCount('applications')
            ->where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 6. Upcoming Interviews schedule grouping by date
        $interviews = Interview::with(['application.user.profile', 'application.job'])
            ->where('scheduled_at', '>=', now()->toDateString())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        // Group interviews by date for the dropdown/list
        $wawancaraData = [];
        foreach ($interviews as $interview) {
            $dateStr = $interview->scheduled_at->toDateString();
            $timeCarbon = $interview->scheduled_at;
            
            $applicantName = $interview->application->user->name ?? 'Applicant';
            $jobTitle = $interview->application->job->title ?? 'Position';
            
            $wawancaraData[$dateStr][] = [
                'time' => $timeCarbon->format('H:i'),
                'name' => $applicantName,
                'role' => $jobTitle,
                'location' => $interview->location_or_link ?? 'Online',
                'isOnline' => filter_var($interview->location_or_link, FILTER_VALIDATE_URL) || stripos($interview->location_or_link, 'zoom') !== false || stripos($interview->location_or_link, 'meet') !== false,
                'statusClass' => $interview->status === 'completed' ? 'border-green-700' : ($interview->status === 'cancelled' ? 'border-red-500' : 'border-blue-500')
            ];
        }

        return view('hr.dashboard', compact(
            'activeVacanciesCount',
            'applicantsToday',
            'applicantsOverall',
            'interviewsThisWeek',
            'interviewsOverall',
            'monthlyTrends',
            'weeklyTrends',
            'activeVacancies',
            'wawancaraData',
            'vacanciesAdded',
            'vacanciesRemoved',
            'applicantsTodayAdded',
            'applicantsTodayRemoved',
            'applicantsOverallAdded',
            'applicantsOverallRemoved',
            'interviewsWeekAdded',
            'interviewsWeekRemoved',
            'interviewsOverallAdded',
            'interviewsOverallRemoved'
        ));
    }
}
