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
            ->whereIn('status', ['open', 'closed']);

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
            $activeNav = $request->get('saved') == '1' ? 'saved-jobs' : 'vacancies';
            return view('pelamar.lowongan', compact('jobs', 'categories', 'locations', 'savedJobIds', 'activeNav'));
        }

        $layout = 'layouts.landing';

        return view('lowongan', compact('jobs', 'categories', 'locations', 'layout'));
    }

    public function show(Request $request, $id)
    {
        $vacancy = JobPosting::with('category')->findOrFail($id);
        
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
                    'name' => 'Template Standar',
                    'is_active' => true,
                    'status' => 'published',
                ]);
            }
            $cv = \App\Models\ApplicantCv::create([
                'user_id' => $userId,
                'template_id' => $template->id,
                'title' => 'CV Utama ' . $user->name,
                'cv_data' => [
                    'objective' => 'Mencari posisi yang sesuai dengan kemampuan saya.',
                    'sections' => ['experience', 'education', 'skills']
                ],
                'is_primary' => true,
            ]);
        }
        
        if ($user->getProfileCompletionPercentage() < 75) {
            return redirect()->route('pelamar.profil.edit')
                ->with('error', 'Kelengkapan profil Anda baru mencapai ' . $user->getProfileCompletionPercentage() . '%. Harap lengkapi data profil Anda minimal hingga 75% sebelum melamar pekerjaan.');
        }

        // Check eligibility via Stored Function (fn_cek_kelayakan_melamar)
        $eligibility = \Illuminate\Support\Facades\DB::selectOne("SELECT fn_cek_kelayakan_melamar(?, ?) as eligibility", [$userId, $id])->eligibility;
        
        if ($eligibility !== 'ELIGIBLE') {
            $errorMsg = match($eligibility) {
                'SUDAH_MELAMAR' => 'Anda sudah melamar pekerjaan ini.',
                'MELEBIHI_BATAS_AKTIF' => 'Anda tidak dapat memiliki lebih dari 3 lamaran aktif secara bersamaan.',
                'TANGGAL_LAHIR_KOSONG' => 'Lowongan ini memiliki syarat batas usia. Mohon lengkapi Tanggal Lahir di profil Anda terlebih dahulu.',
                'USIA_KURANG' => "Usia Anda kurang dari syarat minimum lowongan ini ({$vacancy->age_min} tahun).",
                'USIA_MELEBIHI' => "Usia Anda melebihi batas maksimum syarat lowongan ini ({$vacancy->age_max} tahun).",
                default => 'Anda tidak memenuhi syarat untuk melamar pekerjaan ini.'
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

        if ($user->getProfileCompletionPercentage() < 75) {
            return response()->json([
                'success' => false,
                'message' => 'Kelengkapan profil Anda baru mencapai ' . $user->getProfileCompletionPercentage() . '%. Harap lengkapi data profil Anda minimal hingga 75% sebelum melamar pekerjaan.'
            ], 422);
        }

        // Check eligibility via Stored Function (fn_cek_kelayakan_melamar)
        $eligibility = \Illuminate\Support\Facades\DB::selectOne("SELECT fn_cek_kelayakan_melamar(?, ?) as eligibility", [$userId, $id])->eligibility;
        
        if ($eligibility !== 'ELIGIBLE') {
            $errorMsg = match($eligibility) {
                'SUDAH_MELAMAR' => 'Anda sudah mengirimkan lamaran untuk loker ini.',
                'MELEBIHI_BATAS_AKTIF' => 'Anda tidak dapat memiliki lebih dari 3 lamaran aktif secara bersamaan.',
                'TANGGAL_LAHIR_KOSONG' => 'Lowongan ini memiliki syarat batas usia. Mohon lengkapi Tanggal Lahir di profil Anda terlebih dahulu.',
                'USIA_KURANG' => "Usia Anda kurang dari syarat minimum lowongan ini ({$vacancy->age_min} tahun).",
                'USIA_MELEBIHI' => "Usia Anda melebihi batas maksimum syarat lowongan ini ({$vacancy->age_max} tahun).",
                default => 'Anda tidak memenuhi syarat untuk melamar pekerjaan ini.'
            };
            
            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ], 422);
        }

        $request->validate([
            'cv_source' => 'required|in:builder,upload',
            'cover_letter' => 'nullable|string',
            'file_cv' => 'required_if:cv_source,upload|nullable|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        ]);

        // Find CV
        $cv = \App\Models\ApplicantCv::where('user_id', $userId)->orderByDesc('is_primary')->first();
        if (!$cv) {
            return response()->json([
                'success' => false,
                'message' => 'CV utama tidak ditemukan.'
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
            $application = \App\Models\Application::create([
                'user_id' => $userId,
                'job_id' => $id,
                'cv_id' => $cv->id,
                'cover_letter' => $request->cover_letter,
                'resume_url' => $resumeUrl,
                'status' => 'applied',
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
                        'Lowongan Ditutup Otomatis',
                        "Lowongan \"{$vacancy->title}\" telah ditutup otomatis karena kuota pendaftar terpenuhi ({$vacancy->applicant_count}/{$vacancy->quota}).",
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

        // Create log entry if needed, but not strictly required
        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil terkirim!',
            'redirect_url' => '/pelamar/lamaran-terkirim'
        ]);
    }
}
