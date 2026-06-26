<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Models\SavedJob;
use App\Models\Notification;

class PelamarController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $persentase = $this->hitungPersentaseProfil($user->id);

        // Fetch applicant statistics using database stored procedure sp_statistik_pelamar
        $stats = DB::selectOne("CALL sp_statistik_pelamar(?)", [$user->id]);
        $totalLamaran = $stats->total_lamaran ?? 0;
        $aktif        = $stats->lamaran_aktif ?? 0;
        $ditolak      = $stats->ditolak ?? 0;
        $wawancara    = Application::where('user_id', $user->id)->where('status', 'interview')->count();

        $lamaran      = Application::with('jobPosting')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->take(5)
                            ->get();

        $savedJobs    = SavedJob::with('jobPosting')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->take(3)
                            ->get();

        $notifications = Notification::where('user_id', $user->id)
                            ->latest()
                            ->take(3)
                            ->get();

        return view('pelamar.dashboard', compact(
            'user', 'totalLamaran', 'aktif', 'ditolak', 'wawancara',
            'lamaran', 'savedJobs', 'notifications', 'persentase'
        ));
    }

    private function hitungPersentaseProfil($userId)
    {
        $poin = 0;

        $profile = DB::table('user_profiles')->where('user_id', $userId)->first();
        $user    = DB::table('users')->where('id', $userId)->first();

        if ($profile) {
            if (!empty($profile->avatar_url))   $poin += 5;
            if (!empty($user->name))            $poin += 3;
            if (!empty($profile->gender))       $poin += 2;
            if (!empty($user->phone))           $poin += 3;
            if (!empty($user->email))           $poin += 2;
            if (!empty($profile->birth_date))   $poin += 3;
            if (!empty($profile->address))      $poin += 4;
            if (!empty($profile->city))         $poin += 2;
            if (!empty($profile->province))     $poin += 2;
            if (!empty($profile->bio))          $poin += 3;
            if (!empty($profile->linkedin_url)) $poin += 3;

            $latestEdu = DB::table('educations')->where('user_id', $userId)->exists();
            if ($latestEdu) $poin += 3;
        }

        $education = DB::table('educations')
            ->where('user_id', $userId)
            ->whereNotNull('institution')
            ->whereNotNull('degree')
            ->exists();
        if ($education) $poin += 20;

        $portfolio = DB::table('portofolio')
            ->where('user_id', $userId)
            ->exists();
        if ($portfolio) $poin += 15;

        $workExp = DB::table('work_experiences')
            ->where('user_id', $userId)
            ->exists();
        if ($workExp) $poin += 15;

        $sertifikat = DB::table('applicant_skills')
            ->where('user_id', $userId)
            ->whereNotNull('cert_file_path')
            ->exists();
        if ($sertifikat) $poin += 5;

        return min($poin, 100);
    }

    /**
     * Show applicant's application history & tracking
     */
    public function statusLamaran()
    {
        $user = Auth::user();
        $persentase = $this->hitungPersentaseProfil($user->id);

        $applications = Application::with(['jobPosting.category', 'interviews' => function($q) {
            $q->orderBy('scheduled_at', 'desc');
        }])
        ->where('user_id', $user->id)
        ->latest()
        ->get();

        return view('pelamar.status-lamaran', compact('user', 'applications', 'persentase'));
    }

    /**
     * Withdraw an application
     */
    public function withdrawApplication($id)
    {
        $user = Auth::user();
        $application = Application::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        if ($application->status !== 'applied') {
            return response()->json([
                'success' => false,
                'message' => 'Application cannot be withdrawn after the document review stage.'
            ], 400);
        }

        $oldStatus = $application->status;
        $application->status = 'withdrawn';
        $application->save();

        // Log the status change
        DB::table('application_status_logs')->insert([
            'application_id' => $application->id,
            'changed_by' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => 'withdrawn',
            'reason' => 'Withdrawn by applicant via dashboard.',
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application withdrawn successfully.'
        ]);
    }

    /**
     * Confirm attendance for an interview session
     */
    public function confirmInterviewAttendance(Request $request, $id)
    {
        $user = Auth::user();
        
        $interview = \App\Models\Interview::where('id', $id)
            ->whereHas('application', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->firstOrFail();

        // 1. Time restriction: Absen only allowed starting 60 minutes before the interview
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $scheduledAt = \Carbon\Carbon::parse($interview->scheduled_at->format('Y-m-d H:i:s'), 'Asia/Jakarta');
        
        if ($now->lt($scheduledAt->copy()->subMinutes(60))) {
            return response()->json([
                'success' => false,
                'message' => 'Absen belum dibuka. Anda baru bisa melakukan absen paling cepat 60 menit sebelum jadwal wawancara dimulai (' . $scheduledAt->format('H:i') . ' WIB).'
            ], 422);
        }

        // 2. Photo validation for Offline interviews
        $photoUrl = null;
        if ($interview->interview_type === 'offline') {
            if (!$request->hasFile('attendance_photo')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Foto bukti kehadiran (selfie di lokasi) wajib diunggah untuk wawancara offline.'
                ], 422);
            }
            
            $file = $request->file('attendance_photo');
            $filename = 'attendance_' . $interview->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attendance_photos', $filename, 'public');
            $photoUrl = '/storage/attendance_photos/' . $filename;
        }

        // Update interview details
        $interview->attendance_status = 'present';
        $interview->attendance_confirmed_at = now();
        if ($photoUrl) {
            $interview->attendance_photo = $photoUrl;
        }
        $interview->save();

        return response()->json([
            'success' => true,
            'message' => 'Kehadiran Anda berhasil dikonfirmasi. Terima kasih!',
            'photo_url' => $photoUrl
        ]);
    }

    /**
     * Show applicant's saved jobs page
     */
    public function savedJobs()
    {
        $user = Auth::user();
        $persentase = $this->hitungPersentaseProfil($user->id);

        $savedJobs = SavedJob::with(['jobPosting.category'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('pelamar.lowongan-tersimpan', compact('user', 'savedJobs', 'persentase'));
    }

    /**
     * Toggle saved status of a job posting
     */
    public function toggleSaveJob($id)
    {
        $user = Auth::user();
        
        // Check if job exists and is open/closed
        $job = \App\Models\JobPosting::whereIn('status', ['open', 'closed'])->findOrFail($id);

        $saved = SavedJob::where('user_id', $user->id)->where('job_id', $id)->first();

        if ($saved) {
            $saved->delete();
            $isSaved = false;
            $message = 'Lowongan berhasil dihapus dari bookmark.';
        } else {
            SavedJob::create([
                'user_id' => $user->id,
                'job_id' => $id
            ]);
            $isSaved = true;
            $message = 'Lowongan berhasil disimpan ke bookmark.';
        }

        return response()->json([
            'success' => true,
            'is_saved' => $isSaved,
            'message' => $message
        ]);
    }
}
