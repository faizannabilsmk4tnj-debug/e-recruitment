<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use App\Models\JobPosting;

class ApplicantController extends Controller
{
    /**
     * Display list of applicants grouped by job posting
     */
    public function index()
    {
        // Fetch all active job postings with their categories
        $jobPostings = JobPosting::with('category')
            ->where('status', '!=', 'expired')
            ->orderBy('created_at', 'desc')
            ->get();

        // Build vacancies list with applicants
        $lowonganList = [];
        foreach ($jobPostings as $job) {
            // Fetch applicants for this job
            $applicants = Application::with('user', 'user.profile')
                ->where('job_id', $job->id)
                ->get();

            // Count by status
            $counts = [
                'terkirim' => $applicants->where('status', 'applied')->count(),
                'shortlisted' => $applicants->where('status', 'shortlisted')->count(),
                'interview' => $applicants->where('status', 'interview')->count(),
                'reviewed' => $applicants->where('status', 'reviewed')->count(),
                'rejected' => $applicants->where('status', 'rejected')->count(),
            ];

            // Transform applicants to display format
            $pelamar = $applicants->map(function ($app) {
                $user = $app->user;
                $name = $user->name ?? 'Unknown';
                $parts = explode(' ', $name);
                $avatar = '';
                foreach ($parts as $part) {
                    $avatar .= strtoupper(substr($part, 0, 1));
                }
                $avatar = substr($avatar, 0, 2);

                // Deterministic color based on user_id
                $colors = [
                    'bg-blue-500', 'bg-pink-500', 'bg-amber-500', 'bg-red-400',
                    'bg-purple-500', 'bg-teal-500', 'bg-green-600', 'bg-indigo-500',
                    'bg-rose-500', 'bg-blue-600', 'bg-cyan-500', 'bg-orange-500',
                ];
                $color = $colors[($user->id ?? 0) % count($colors)];

                // Generate score based on application data (for demo)
                $score = rand(45, 95);

                return [
                    'id' => $app->id,
                    'user_id' => $user->id,
                    'name' => $name,
                    'email' => $user->email ?? '',
                    'date' => $app->created_at->format('d M Y'),
                    'status' => $app->status ?? 'applied',
                    'score' => $score,
                    'avatar' => $avatar,
                    'color' => $color,
                ];
            })->toArray();

            $lowonganList[] = [
                'id' => $job->id,
                'title' => $job->title,
                'department' => $job->category->name ?? 'General',
                'total' => $applicants->count(),
                'posted' => $job->created_at->format('d M Y'),
                'days_since' => $job->created_at->diffInDays(now()),
                'deadline_days' => $job->deadline ? $job->deadline->diffInDays(now()) : 999,
                'counts' => $counts,
                'expanded' => count($lowonganList) === 0, // Expand first by default
                'pelamar' => $pelamar,
            ];
        }

        return view('hr.pelamar', compact('lowonganList'));
    }

    /**
     * Display applicant detail page
     */
    public function show($userId)
    {
        $user = User::with('profile', 'educations', 'workExperiences', 'applicantSkills', 'certificates', 'portofolios')
            ->findOrFail($userId);

        // Try to get the most recent application
        $application = Application::where('user_id', $userId)
            ->latest()
            ->first();

        // Get profile data with safe access
        $profile = $user->profile ?? (object)[];

        return view('hr.pelamar-detail', compact('user', 'profile', 'application'));
    }
}
