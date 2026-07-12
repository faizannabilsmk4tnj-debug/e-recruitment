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
            ->orderByRaw("CASE 
                WHEN status = 'open' THEN 1 
                WHEN status = 'draft' THEN 2 
                WHEN status = 'filled' THEN 3
                WHEN status = 'closed' THEN 4 
                ELSE 5 
            END")
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics based on real data
        $totalVacancies = JobPosting::count();
        $activeApplicants = DB::table('applications')
            ->whereIn('status', ['applied', 'shortlisted', 'interview'])
            ->count();
        
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
                'closed' => JobPosting::whereIn('status', ['closed', 'filled'])->where('updated_at', '>=', now()->subDay())->count(),
            ],
            'weekly' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subWeek())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subWeek())->count(),
                'closed' => JobPosting::whereIn('status', ['closed', 'filled'])->where('updated_at', '>=', now()->subWeek())->count(),
            ],
            'monthly' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subMonth())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subMonth())->count(),
                'closed' => JobPosting::whereIn('status', ['closed', 'filled'])->where('updated_at', '>=', now()->subMonth())->count(),
            ],
            'yearly' => [
                'vacancies' => JobPosting::where('created_at', '>=', now()->subYear())->count(),
                'applicants' => DB::table('applications')->where('created_at', '>=', now()->subYear())->count(),
                'closed' => JobPosting::whereIn('status', ['closed', 'filled'])->where('updated_at', '>=', now()->subYear())->count(),
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

    public function create(Request $request)
    {
        $categories = JobCategory::where('is_active', true)->get();
        $locations = \App\Models\WorkLocation::where('is_active', true)->get();
        
        $draft = null;
        if ($request->has('draft_id')) {
            $draft = JobPosting::where('status', 'draft')->find($request->query('draft_id'));
        }
        
        return view('hr.lowongan-buat', compact('categories', 'locations', 'draft'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isDraft = $request->input('status') === 'draft';

        $rules = [
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:job_categories,id',
            'location' => 'required|string|max:200',
            'quota' => 'required|integer|min:1',
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0',
            'passing_grade' => 'nullable|integer|min:0|max:100',
            'deadline' => $isDraft ? 'nullable|date' : 'required|date',
            'description' => $isDraft ? 'nullable|string' : 'required|string',
            'requirements' => $isDraft ? 'nullable|string' : 'required|string',
            'benefits' => 'nullable|array',
            'salary_min' => 'nullable|string',
            'salary_max' => 'nullable|string',
            'show_salary' => 'boolean',
            'status' => 'required|in:draft,open,closed,filled',
            'auto_close_method' => 'nullable|in:deadline,quota,both,manual',
            'banner_image' => 'nullable|string',
            'employment_type' => $isDraft ? 'nullable|in:full-time,part-time,contract,internship' : 'required|in:full-time,part-time,contract,internship',
        ];

        $validated = $request->validate($rules);

        // Age validation
        $ageMin = isset($validated['age_min']) ? (int)$validated['age_min'] : null;
        $ageMax = isset($validated['age_max']) ? (int)$validated['age_max'] : null;
        if ($ageMin !== null && $ageMax !== null && $ageMax < $ageMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'age_max' => ['Maximum age cannot be less than minimum age.'],
            ]);
        }

        // Clean salary inputs using regex (e.g. "Rp 10.000.000" -> 10000000)
        $salaryMin = null;
        if (!empty($validated['salary_min'])) {
            $salaryMin = (float) preg_replace('/[^0-9]/', '', $validated['salary_min']);
        }
        
        $salaryMax = null;
        if (!empty($validated['salary_max'])) {
            $salaryMax = (float) preg_replace('/[^0-9]/', '', $validated['salary_max']);
        }

        // Salary validation
        if ($salaryMin !== null && $salaryMax !== null && $salaryMax < $salaryMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'salary_max' => ['Maximum salary cannot be less than minimum salary.'],
            ]);
        }

        // Auto close method & deadline validation
        if (!$isDraft && in_array($validated['auto_close_method'], ['deadline', 'both']) && empty($validated['deadline'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'deadline' => ['Deadline date is required if time-based auto close method is selected.'],
            ]);
        }



        // Save banner image if provided as base64
        $bannerPath = null;
        if (!empty($validated['banner_image']) && str_starts_with($validated['banner_image'], 'data:image/')) {
            list($type, $data) = explode(';', $validated['banner_image']);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $extension = 'jpg';
            if (str_contains($type, 'png')) {
                $extension = 'png';
            } elseif (str_contains($type, 'gif')) {
                $extension = 'gif';
            } elseif (str_contains($type, 'webp')) {
                $extension = 'webp';
            }

            $fileName = 'banner_' . time() . '_' . uniqid() . '.' . $extension;
            \Illuminate\Support\Facades\Storage::disk('public')->put('job_banners/' . $fileName, $data);
            $bannerPath = 'storage/job_banners/' . $fileName;
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
            'banner_image' => $bannerPath,
            'description' => $validated['description'] ?? '',
            'requirements' => $validated['requirements'] ?? '',
            'benefits' => $benefitsStr,
            'employment_type' => $validated['employment_type'] ?? 'full-time',
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

        $categories = JobCategory::where('is_active', true)->get();
        $locations = \App\Models\WorkLocation::where('is_active', true)->get();

        return view('hr.lowongan-detail', compact('vacancy', 'applicants', 'stats', 'weeklyDailyData', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $isDraft = $request->input('status') === 'draft';

        $rules = [
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:job_categories,id',
            'location' => $isDraft ? 'nullable|string|max:200' : 'required|string|max:200',
            'quota' => 'required|integer|min:1',
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0',
            'passing_grade' => 'nullable|integer|min:0|max:100',
            'deadline' => $isDraft ? 'nullable|date' : 'required|date',
            'status' => 'required|in:draft,open,closed,filled',
            'auto_close_method' => 'nullable|in:deadline,quota,both,manual',
            'description' => $isDraft ? 'nullable|string' : 'required|string',
            'requirements' => $isDraft ? 'nullable|string' : 'required|string',
            'benefits' => 'nullable',
            'salary_min' => 'nullable|string',
            'salary_max' => 'nullable|string',
            'show_salary' => 'boolean',
            'banner_image' => 'nullable|string',
            'employment_type' => $isDraft ? 'nullable|in:full-time,part-time,contract,internship' : 'required|in:full-time,part-time,contract,internship',
        ];

        $validated = $request->validate($rules);

        $job = JobPosting::findOrFail($id);

        if (in_array($job->status, ['closed', 'filled'])) {
            return response()->json([
                'success' => false,
                'message' => 'This vacancy can no longer be edited because it is already closed or filled.'
            ], 422);
        }
        
        // Age validation
        $ageMin = isset($validated['age_min']) ? (int)$validated['age_min'] : null;
        $ageMax = isset($validated['age_max']) ? (int)$validated['age_max'] : null;
        if ($ageMin !== null && $ageMax !== null && $ageMax < $ageMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'age_max' => ['Maximum age cannot be less than minimum age.'],
            ]);
        }

        // Clean salary inputs using regex (e.g. "Rp 10.000.000" -> 10000000)
        $salaryMin = null;
        if (!empty($validated['salary_min'])) {
            $salaryMin = (float) preg_replace('/[^0-9]/', '', $validated['salary_min']);
        }
        
        $salaryMax = null;
        if (!empty($validated['salary_max'])) {
            $salaryMax = (float) preg_replace('/[^0-9]/', '', $validated['salary_max']);
        }

        // Salary validation
        if ($salaryMin !== null && $salaryMax !== null && $salaryMax < $salaryMin) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'salary_max' => ['Maximum salary cannot be less than minimum salary.'],
            ]);
        }

        // Auto close method & deadline validation
        if (!$isDraft && in_array($validated['auto_close_method'], ['deadline', 'both']) && empty($validated['deadline'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'deadline' => ['Deadline date is required if time-based auto close method is selected.'],
            ]);
        }



        // Save banner image if provided as base64 or keep old banner image or remove if null
        $bannerPath = null;
        if (!empty($validated['banner_image'])) {
            if (str_starts_with($validated['banner_image'], 'data:image/')) {
                list($type, $data) = explode(';', $validated['banner_image']);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                $extension = 'jpg';
                if (str_contains($type, 'png')) {
                    $extension = 'png';
                } elseif (str_contains($type, 'gif')) {
                    $extension = 'gif';
                } elseif (str_contains($type, 'webp')) {
                    $extension = 'webp';
                }

                $fileName = 'banner_' . time() . '_' . uniqid() . '.' . $extension;
                \Illuminate\Support\Facades\Storage::disk('public')->put('job_banners/' . $fileName, $data);
                $bannerPath = 'storage/job_banners/' . $fileName;
            } else {
                // Keep the old one (if it's a URL/path)
                // Remove the domain if it has one
                $parsedUrl = parse_url($validated['banner_image']);
                $path = $parsedUrl['path'] ?? $validated['banner_image'];
                $bannerPath = ltrim($path, '/');
            }
        }

        // Convert benefits array/string to string
        $benefitsStr = '';
        if (isset($validated['benefits'])) {
            if (is_array($validated['benefits'])) {
                $benefitsStr = implode(', ', $validated['benefits']);
            } else {
                $benefitsStr = $validated['benefits'];
            }
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
            'description' => $validated['description'] ?? $job->description ?? '',
            'requirements' => $validated['requirements'] ?? $job->requirements ?? '',
            'benefits' => $benefitsStr,
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'show_salary' => $validated['show_salary'] ?? false,
            'banner_image' => $bannerPath,
            'employment_type' => $validated['employment_type'] ?? $job->employment_type ?? 'full-time',
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
            'status' => 'required|in:draft,open,closed,filled',
        ]);

        $job = JobPosting::findOrFail($id);

        if ($validated['status'] === 'open') {
            $incompleteFields = [];
            if (empty($job->description) || trim(strip_tags($job->description)) === '') {
                $incompleteFields[] = 'Description';
            }
            if (empty($job->requirements) || trim(strip_tags($job->requirements)) === '') {
                $incompleteFields[] = 'Requirements';
            }
            if (empty($job->deadline)) {
                $incompleteFields[] = 'Deadline';
            }
            if (empty($job->category_id)) {
                $incompleteFields[] = 'Category';
            }
            if (empty($job->location)) {
                $incompleteFields[] = 'Work Location';
            }
            if (empty($job->employment_type)) {
                $incompleteFields[] = 'Employment Type';
            }
            if (empty($job->quota) || $job->quota < 1) {
                $incompleteFields[] = 'Quota';
            }

            if (!empty($incompleteFields)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The data for this vacancy is incomplete. Please complete it before publishing.'
                ], 422);
            }
        }

        $job->status = $validated['status'];
        if ($validated['status'] === 'closed' || $validated['status'] === 'filled') {
            $job->closed_at = now();
        }
        $job->save();

        return response()->json([
            'success' => true,
            'message' => 'Job status updated successfully.',
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
            'message' => 'New category added successfully.',
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
            'message' => 'New work location added successfully.',
            'location' => $location
        ]);
    }

    /**
     * Delete a category via AJAX
     */
    public function destroyCategory($id)
    {
        $category = JobCategory::findOrFail($id);
        
        $count = \App\Models\JobPosting::where('category_id', $id)->count();
        if ($count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Category cannot be deleted because it is currently used by ' . $count . ' vacancies.'
            ], 422);
        }
        
        $category->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }

    /**
     * Delete a location via AJAX
     */
    public function destroyLocation($id)
    {
        $location = \App\Models\WorkLocation::findOrFail($id);
        
        $locationName = trim($location->name);
        $firstWord = preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $locationName)[0]);

        $count = \App\Models\JobPosting::where(function($query) use ($locationName, $firstWord) {
            $query->where('location', 'like', '%' . $locationName . '%');
            if (!empty($firstWord)) {
                $query->orWhere('location', 'like', '%' . $firstWord . '%');
            }
        })->count();

        if ($count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Location cannot be deleted because it is currently used by ' . $count . ' vacancies.'
            ], 422);
        }
        
        $location->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Location deleted successfully.'
        ]);
    }
}
