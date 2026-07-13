<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobPosting;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $categories = JobCategory::where('is_active', true)->get();
        $locations = \App\Models\WorkLocation::where('is_active', true)->get();
        
        $query = JobPosting::with('category')
            ->whereIn('status', ['open', 'closed', 'filled']);

        if ($request->filled('q')) {
            $search = $request->q;
            if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
                // If it's a simple word or phrase, wrap or format if needed, but BOOLEAN MODE allows simple keywords
                $query->whereRaw("MATCH(title, description, requirements, benefits) AGAINST(? IN BOOLEAN MODE)", [$search]);
            } else {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('requirements', 'like', "%{$search}%")
                      ->orWhere('benefits', 'like', "%{$search}%");
                });
            }
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();

        if ($request->is('pelamar/*')) {
            $savedJobIds = \App\Models\SavedJob::where('user_id', auth()->id())
                ->pluck('job_id')
                ->toArray();
            $activeNav = $request->input('saved') == '1' ? 'saved-jobs' : 'vacancies';
            return view('pelamar.lowongan', compact('jobs', 'categories', 'locations', 'savedJobIds', 'activeNav'));
        }

        $layout = 'layouts.landing';

        return view('lowongan', compact('jobs', 'categories', 'locations', 'layout'));
    }

    public function show(Request $request, $id)
    {
        $vacancy = JobPosting::with('category')->findOrFail($id);
        
        // Log source traffic if query parameter source exists
        $source = $request->query('source');
        if ($source) {
            // Keep it in session so we can attach to application if they apply
            session(['job_source_' . $id => $source]);
        }
        
        if ($request->is('pelamar/*')) {
            $isSaved = false;
            if (auth()->check()) {
                $isSaved = \App\Models\SavedJob::where('user_id', auth()->id())->where('job_id', $id)->exists();
            }
            return view('pelamar.detail-lowongan', compact('vacancy', 'isSaved'));
        }

        $layout = 'layouts.landing';

        return view('detail-lowongan', compact('vacancy', 'layout'));
    }

    public function showReview($id)
    {
        $vacancy = JobPosting::findOrFail($id);
        $user = auth()->user();
        $userId = $user->id;
        
        // Find or create profile
        $profile = \App\Models\UserProfile::where('user_id', $userId)->first();
        if (!$profile) {
            $profile = \App\Models\UserProfile::create([
                'user_id' => $userId,
            ]);
        }
        
        // Ensure they have a CV record in the database
        $cv = \App\Models\ApplicantCv::where('user_id', $userId)->orderByDesc('is_primary')->first();
        if (!$cv) {
            $template = \App\Models\CvTemplate::where('status', 'published')->orderByDesc('is_default')->first() 
                ?: \App\Models\CvTemplate::first();
            if (!$template) {
                $template = \App\Models\CvTemplate::create([
                    'name' => 'Standard Template',
                    'is_active' => true,
                    'status' => 'published',
                ]);
            }
            $cv = \App\Models\ApplicantCv::create([
                'user_id' => $userId,
                'template_id' => $template->id,
                'title' => 'Primary CV ' . $user->name,
                'cv_data' => [
                    'objective' => 'Seeking a position that matches my skills.',
                    'sections' => ['experience', 'education', 'skills']
                ],
                'is_primary' => true,
            ]);
        }
        
        if (!$user->has_privilege) {
            return redirect()->route('pelamar.lowongan.show', $id)
                ->with('error', 'You do not have access privilege to apply for jobs.');
        }

        if ($user->getProfileCompletionPercentage() < 75) {
            return redirect()->route('pelamar.profil.edit')
                ->with('error', 'Your profile completion is only ' . $user->getProfileCompletionPercentage() . '%. Please complete your profile data to at least 75% before applying for jobs.');
        }

        // Check eligibility via Stored Function (fn_cek_kelayakan_melamar)
        $eligibility = \Illuminate\Support\Facades\DB::selectOne("SELECT fn_cek_kelayakan_melamar(?, ?) as eligibility", [$userId, $id])->eligibility;
        
        if ($eligibility !== 'ELIGIBLE') {
            $errorMsg = match($eligibility) {
                'SUDAH_MELAMAR' => 'You have already applied for this job.',
                'MELEBIHI_BATAS_AKTIF' => 'You cannot have more than 3 active applications at the same time.',
                'TANGGAL_LAHIR_KOSONG' => 'This vacancy has age limit requirements. Please complete the Birth Date in your profile first.',
                'USIA_KURANG' => "Your age is less than the minimum requirement for this vacancy ({$vacancy->age_min} years old).",
                'USIA_MELEBIHI' => "Your age exceeds the maximum limit requirement for this vacancy ({$vacancy->age_max} years old).",
                default => 'You do not meet the requirements to apply for this job.'
            };
            
            if ($eligibility === 'TANGGAL_LAHIR_KOSONG') {
                return redirect()->route('pelamar.profil.edit')
                    ->with('error', $errorMsg);
            }
            
            return redirect()->route('pelamar.lowongan.show', $id)
                ->with('error', $errorMsg);
        }

        return view('pelamar.review-lamaran', compact('vacancy', 'user', 'profile', 'cv'));
    }

    public function submitApplication(Request $request, $id)
    {
        $user = auth()->user();
        $userId = $user->id;
        $vacancy = JobPosting::findOrFail($id);

        if (!$user->has_privilege) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access privilege to apply for jobs.'
            ], 403);
        }

        if ($user->getProfileCompletionPercentage() < 75) {
            return response()->json([
                'success' => false,
                'message' => 'Your profile completion is only ' . $user->getProfileCompletionPercentage() . '%. Please complete your profile data to at least 75% before applying for jobs.'
            ], 422);
        }

        // Check eligibility via Stored Function (fn_cek_kelayakan_melamar)
        $eligibility = \Illuminate\Support\Facades\DB::selectOne("SELECT fn_cek_kelayakan_melamar(?, ?) as eligibility", [$userId, $id])->eligibility;
        
        if ($eligibility !== 'ELIGIBLE') {
            $errorMsg = match($eligibility) {
                'SUDAH_MELAMAR' => 'You have already submitted an application for this job.',
                'MELEBIHI_BATAS_AKTIF' => 'You cannot have more than 3 active applications at the same time.',
                'TANGGAL_LAHIR_KOSONG' => 'This vacancy has age limit requirements. Please complete the Birth Date in your profile first.',
                'USIA_KURANG' => "Your age is less than the minimum requirement for this vacancy ({$vacancy->age_min} years old).",
                'USIA_MELEBIHI' => "Your age exceeds the maximum limit requirement for this vacancy ({$vacancy->age_max} years old).",
                default => 'You do not meet the requirements to apply for this job.'
            };
            
            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ], 422);
        }

        $request->validate([
            'resume_title' => 'required|string|max:150',
            'cover_letter' => 'nullable|string',
            'file_cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        ]);

        // Find CV
        $cv = \App\Models\ApplicantCv::where('user_id', $userId)->orderByDesc('is_primary')->first();
        if (!$cv) {
            return response()->json([
                'success' => false,
                'message' => 'Primary CV not found.'
            ], 422);
        }

        // Store file
        $resumeUrl = null;
        if ($request->hasFile('file_cv')) {
            $file = $request->file('file_cv');
            $filename = 'cv_' . $userId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('resumes', $filename, 'public');
            $resumeUrl = '/storage/resumes/' . $filename;
        }

        // Create application with try-catch to capture database trigger errors
        try {
            $source = session('job_source_' . $id) ?: $request->query('source') ?: 'website';
            $application = \App\Models\Application::create([
                'user_id' => $userId,
                'job_id' => $id,
                'cv_id' => $cv->id,
                'resume_title' => $request->resume_title,
                'cover_letter' => $request->cover_letter,
                'resume_url' => $resumeUrl,
                'status' => 'applied',
                'source' => strtolower($source),
            ]);
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


        // Increment applicant count on job posting
        $vacancy = JobPosting::findOrFail($id);
        $vacancy->increment('applicant_count');

        // Check if quota is now met and auto-close method allows it
        $vacancy->refresh();
        if (in_array($vacancy->auto_close_method, ['quota', 'both'])) {
            if ($vacancy->quota > 0 && $vacancy->applicant_count >= $vacancy->quota) {
                $vacancy->update([
                    'status' => 'closed',
                    'closed_at' => now(),
                ]);

                // Notify HR about automatic closure due to quota
                $hrUsers = \App\Models\User::whereIn('role', ['hr', 'hr_master'])
                    ->where('is_active', true)
                    ->get();

                foreach ($hrUsers as $hr) {
                    $pref = \App\Models\NotificationPreference::where('user_id', $hr->id)->first();
                    if ($pref && !$pref->notif_vacancy_deadline) {
                        continue;
                    }

                    NotificationService::create(
                        $hr->id,
                        'vacancy_closed_auto',
                        'Lowongan Ditutup (Kuota Penuh)',
                        "Lowongan \"{$vacancy->title}\" telah ditutup secara otomatis karena kuota pelamar sudah terpenuhi ({$vacancy->applicant_count}/{$vacancy->quota}).",
                        [
                            'job_id'    => $vacancy->id,
                            'job_title' => $vacancy->title,
                            'reason'    => 'quota',
                        ]
                    );
                }
            }
        }

        // Notify all HR users about the new application
        $application->load(['user', 'job']);
        NotificationService::notifyNewApplication($application);

        // Log initial submission so Activity Log always has a complete trail
        \Illuminate\Support\Facades\DB::table('application_status_logs')->insert([
            'application_id' => $application->id,
            'changed_by'     => $userId,
            'old_status'     => 'applied',
            'new_status'     => 'applied',
            'reason'         => 'Application submitted by candidate.',
            'created_at'     => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application successfully submitted!',
            'redirect_url' => '/pelamar/application-submitted'
        ]);
    }
}
