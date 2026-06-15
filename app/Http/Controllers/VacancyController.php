<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\JobPosting;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $categories = JobCategory::where('is_active', true)->get();
        
        // Load only open/closed job postings for applicants
        $jobs = JobPosting::with('category')
            ->whereIn('status', ['open', 'closed'])
            ->orderBy('created_at', 'desc')
            ->get();

        $layout = $request->is('pelamar/*') ? 'layouts.pelamar-public' : 'layouts.landing';

        return view('lowongan', compact('jobs', 'categories', 'layout'));
    }

    public function show(Request $request, $id)
    {
        $vacancy = JobPosting::with('category')->findOrFail($id);
        
        $layout = $request->is('pelamar/*') ? 'layouts.pelamar-public' : 'layouts.landing';

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
        
        // Check if already applied
        $alreadyApplied = \App\Models\Application::where('user_id', $userId)->where('job_id', $id)->exists();
        if ($alreadyApplied) {
            return redirect()->route('pelamar.lowongan.show', $id)
                ->with('error', 'Anda sudah melamar pekerjaan ini.');
        }

        return view('pelamar.review-lamaran', compact('vacancy', 'user', 'profile', 'cv'));
    }

    public function submitApplication(Request $request, $id)
    {
        $user = auth()->user();
        $userId = $user->id;

        // Check if already applied to prevent duplicate entry exception
        $alreadyApplied = \App\Models\Application::where('user_id', $userId)->where('job_id', $id)->exists();
        if ($alreadyApplied) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengirimkan lamaran untuk loker ini.'
            ], 422);
        }

        $request->validate([
            'cover_letter' => 'nullable|string',
            'file_cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
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
            $path = $file->storeAs('public/resumes', $filename);
            $resumeUrl = '/storage/resumes/' . $filename;
        }

        // Create application
        \App\Models\Application::create([
            'user_id' => $userId,
            'job_id' => $id,
            'cv_id' => $cv->id,
            'cover_letter' => $request->cover_letter,
            'resume_url' => $resumeUrl,
            'status' => 'applied',
        ]);

        // Increment applicant count on job posting
        $vacancy = JobPosting::findOrFail($id);
        $vacancy->increment('applicant_count');

        // Create log entry if needed, but not strictly required
        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil terkirim!',
            'redirect_url' => '/pelamar/lamaran-terkirim'
        ]);
    }
}
