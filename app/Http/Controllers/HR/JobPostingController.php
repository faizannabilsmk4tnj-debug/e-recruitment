<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = JobCategory::where('is_active', true)->get();
        $locations = \App\Models\WorkLocation::where('is_active', true)->get();
        
        $vacancies = JobPosting::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics based on real data
        $totalVacancies = JobPosting::count();
        $activeApplicants = DB::table('applications')->count();
        
        // Closing soon (deadline within 7 days and status is open)
        $closingSoon = JobPosting::where('status', 'open')
            ->whereNotNull('deadline')
            ->where('deadline', '<=', now()->addDays(7))
            ->where('deadline', '>=', now()->startOfDay())
            ->count();

        // Calculate recruitment target fill percentage
        $totalQuota = JobPosting::where('status', 'open')->sum('quota');
        $totalApplicantsFilled = JobPosting::where('status', 'open')->sum('applicant_count');
        $recruitmentTargetPercentage = $totalQuota > 0 ? min(100, round(($totalApplicantsFilled / $totalQuota) * 100)) : 0;

        // Compute trend stats (using actual database counts based on database records)
        $trends = [
            'daily' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subDay())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subDay())->count(),
                'closed' => JobPosting::where('status', 'closed')->where('updated_at', '>=', now()->subDay())->count(),
            ],
            'weekly' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subWeek())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subWeek())->count(),
                'closed' => JobPosting::where('status', 'closed')->where('updated_at', '>=', now()->subWeek())->count(),
            ],
            'monthly' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subMonth())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subMonth())->count(),
                'closed' => JobPosting::where('status', 'closed')->where('updated_at', '>=', now()->subMonth())->count(),
            ],
            'yearly' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subYear())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subYear())->count(),
                'closed' => JobPosting::where('status', 'closed')->where('updated_at', '>=', now()->subYear())->count(),
            ],
        ];

        return view('hr.lowongan', compact(
            'vacancies',
            'categories',
            'locations',
            'totalVacancies',
            'activeApplicants',
            'closingSoon',
            'recruitmentTargetPercentage',
            'trends'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = JobCategory::where('is_active', true)->get();
        $locations = \App\Models\WorkLocation::where('is_active', true)->get();
        return view('hr.lowongan-buat', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:job_categories,id',
            'location' => 'required|string|max:200',
            'quota' => 'required|integer|min:1',
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0',
            'passing_grade' => 'nullable|integer|min:0|max:100',
            'deadline' => 'nullable|date',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|array',
            'salary_min' => 'nullable|string',
            'salary_max' => 'nullable|string',
            'show_salary' => 'boolean',
            'status' => 'required|in:draft,open,closed,expired',
            'auto_close_method' => 'nullable|in:deadline,quota,both,manual',
        ]);

        // Age validation
        $ageMin = isset($validated['age_min']) ? (int)$validated['age_min'] : null;
        $ageMax = isset($validated['age_max']) ? (int)$validated['age_max'] : null;
        if ($ageMin !== null && $ageMax !== null && $ageMax < $ageMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'age_max' => ['Umur maksimal tidak boleh lebih kecil dari umur minimal.'],
            ]);
        }

        // Clean salary inputs (e.g. "10.000.000" -> 10000000)
        $salaryMin = null;
        if (!empty($validated['salary_min'])) {
            $salaryMin = (float) str_replace('.', '', $validated['salary_min']);
        }
        
        $salaryMax = null;
        if (!empty($validated['salary_max'])) {
            $salaryMax = (float) str_replace('.', '', $validated['salary_max']);
        }

        // Salary validation
        if ($salaryMin !== null && $salaryMax !== null && $salaryMax < $salaryMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'salary_max' => ['Gaji maksimal tidak boleh lebih kecil dari gaji minimal.'],
            ]);
        }

        // Determine location type
        $locationType = 'onsite';
        if (strtolower($validated['location']) === 'remote') {
            $locationType = 'remote';
        } else if (str_contains(strtolower($validated['location']), 'hybrid')) {
            $locationType = 'hybrid';
        }

        // Convert benefits array to string
        $benefitsStr = '';
        if (!empty($validated['benefits'])) {
            $benefitsStr = implode(', ', $validated['benefits']);
        }

        // Create the Job Posting
        $job = JobPosting::create([
            'hr_user_id' => auth()->id() ?: 1, // Fallback to user ID 1 if not logged in (e.g. testing)
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            'description' => $validated['description'],
            'requirements' => $validated['requirements'],
            'benefits' => $benefitsStr,
            'employment_type' => 'full-time',
            'location_type' => $locationType,
            'location' => $validated['location'],
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'show_salary' => $validated['show_salary'] ?? false,
            'quota' => $validated['quota'],
            'age_min' => $validated['age_min'] ?? null,
            'age_max' => $validated['age_max'] ?? null,
            'passing_grade' => $validated['passing_grade'] ?? 70,
            'status' => $validated['status'],
            'auto_close_method' => $validated['auto_close_method'] ?? 'both',
            'deadline' => $validated['deadline'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job vacancy created successfully.',
            'redirect_url' => route('hr.lowongan.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vacancy = JobPosting::with(['category', 'hrUser'])->findOrFail($id);
        
        // Fetch applicants for this vacancy
        $applicants = DB::table('applications')
            ->join('users', 'applications.user_id', '=', 'users.id')
            ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->where('applications.job_id', $id)
            ->select(
                'applications.*',
                'users.name as applicant_name',
                'users.email as applicant_email',
                'users.phone as applicant_phone',
                'user_profiles.latest_education as education_level'
            )
            ->get();

        // Calculate count of different statuses for statistics
        $stats = [
            'total' => $applicants->count(),
            'shortlisted' => $applicants->where('status', 'shortlisted')->count(),
            'interview' => $applicants->where('status', 'interview')->count(),
            'rejected' => $applicants->where('status', 'rejected')->count(),
        ];

        // Generate 4 weeks of daily data (28 days total) starting from the vacancy posted date
        $postedDate = $vacancy->created_at;
        $weeklyDailyData = [];
        for ($week = 0; $week < 4; $week++) {
            $weekData = [];
            for ($day = 0; $day < 7; $day++) {
                $targetDateStart = $postedDate->copy()->addDays($week * 7 + $day)->startOfDay();
                $targetDateEnd = $targetDateStart->copy()->endOfDay();
                
                $count = DB::table('applications')
                    ->where('job_id', $id)
                    ->whereBetween('created_at', [$targetDateStart, $targetDateEnd])
                    ->count();
                    
                $weekData[] = $count;
            }
            $weeklyDailyData[] = $weekData;
        }

        return view('hr.lowongan-detail', compact('vacancy', 'applicants', 'stats', 'weeklyDailyData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:job_categories,id',
            'location' => 'nullable|string|max:200',
            'quota' => 'required|integer|min:1',
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0',
            'passing_grade' => 'nullable|integer|min:0|max:100',
            'deadline' => 'nullable|date',
            'status' => 'required|in:draft,open,closed,expired',
            'auto_close_method' => 'nullable|in:deadline,quota,both,manual',
            'description' => 'nullable|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'salary_min' => 'nullable|string',
            'salary_max' => 'nullable|string',
            'show_salary' => 'boolean',
        ]);

        $job = JobPosting::findOrFail($id);
        
        // Age validation
        $ageMin = isset($validated['age_min']) ? (int)$validated['age_min'] : null;
        $ageMax = isset($validated['age_max']) ? (int)$validated['age_max'] : null;
        if ($ageMin !== null && $ageMax !== null && $ageMax < $ageMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'age_max' => ['Umur maksimal tidak boleh lebih kecil dari umur minimal.'],
            ]);
        }

        // Clean salary inputs
        $salaryMin = null;
        if (!empty($validated['salary_min'])) {
            $salaryMin = (float) str_replace('.', '', $validated['salary_min']);
        }
        
        $salaryMax = null;
        if (!empty($validated['salary_max'])) {
            $salaryMax = (float) str_replace('.', '', $validated['salary_max']);
        }

        // Salary validation
        if ($salaryMin !== null && $salaryMax !== null && $salaryMax < $salaryMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'salary_max' => ['Gaji maksimal tidak boleh lebih kecil dari gaji minimal.'],
            ]);
        }

        $updateData = [
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'quota' => $validated['quota'],
            'age_min' => $validated['age_min'] ?? null,
            'age_max' => $validated['age_max'] ?? null,
            'passing_grade' => $validated['passing_grade'] ?? $job->passing_grade ?? 70,
            'deadline' => $validated['deadline'] ?? null,
            'status' => $validated['status'],
            'auto_close_method' => $validated['auto_close_method'] ?? $job->auto_close_method ?? 'both',
            'description' => $validated['description'] ?? $job->description,
            'requirements' => $validated['requirements'],
            'benefits' => $validated['benefits'] ?? '',
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'show_salary' => $validated['show_salary'] ?? false,
        ];

        if (!empty($validated['location'])) {
            $updateData['location'] = $validated['location'];
            
            // Determine location type
            $locationType = 'onsite';
            if (strtolower($validated['location']) === 'remote') {
                $locationType = 'remote';
            } else if (str_contains(strtolower($validated['location']), 'hybrid')) {
                $locationType = 'hybrid';
            }
            $updateData['location_type'] = $locationType;
        }

        $job->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Vacancy updated successfully.',
            'job' => $job
        ]);
    }

    /**
     * Update status (e.g. Mark as Filled / Close Vacancy via AJAX)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,open,closed,expired',
        ]);

        $job = JobPosting::findOrFail($id);
        $job->status = $validated['status'];
        if ($validated['status'] === 'closed') {
            $job->closed_at = now();
        }
        $job->save();

        return response()->json([
            'success' => true,
            'message' => 'Status lowongan berhasil diperbarui.',
            'status' => $job->status
        ]);
    }

    /**
     * Store a new category via AJAX
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:job_categories,name',
        ]);

        $category = JobCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori baru berhasil ditambahkan.',
            'category' => $category
        ]);
    }

    /**
     * Store a new work location via AJAX
     */
    public function storeLocation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:work_locations,name',
        ]);

        $location = \App\Models\WorkLocation::create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lokasi kerja baru berhasil ditambahkan.',
            'location' => $location
        ]);
    }
}
