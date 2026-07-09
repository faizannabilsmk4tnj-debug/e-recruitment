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
        $persentase = $user->getProfileCompletionPercentage();

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



    /**
     * Show applicant's application history & tracking
     */
    public function statusLamaran()
    {
        $user = Auth::user();
        $persentase = $user->getProfileCompletionPercentage();

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

        // Decrement applicant count on job posting
        $job = \App\Models\JobPosting::find($application->job_id);
        if ($job && $job->applicant_count > 0) {
            $job->decrement('applicant_count');
        }

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

        // Limit to maximum 30 minutes after the interview start time
        if ($now->gt($scheduledAt->copy()->addMinutes(30))) {
            return response()->json([
                'success' => false,
                'message' => 'Absen sudah ditutup. Batas maksimal konfirmasi kehadiran adalah 30 menit setelah jadwal wawancara dimulai (' . $scheduledAt->copy()->addMinutes(30)->format('H:i') . ' WIB).'
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
     * Request a reschedule for an interview session
     */
    public function rescheduleInterviewRequest(Request $request, $id)
    {
        $user = Auth::user();
        
        $interview = \App\Models\Interview::where('id', $id)
            ->whereHas('application', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->firstOrFail();

        $request->validate([
            'reschedule_reason'   => 'required|string|max:1000',
            'proposed_date'       => 'required|date|after:now',
            'proposed_type'       => 'required|in:online,offline',
        ]);

        // Store the reschedule request data in dedicated columns
        $interview->reschedule_reason         = $request->reschedule_reason;
        $interview->proposed_scheduled_at     = $request->proposed_date;
        $interview->proposed_interview_type   = $request->proposed_type;
        $interview->reschedule_requested_by   = 'applicant';
        $interview->reschedule_request_status = 'pending';
        $interview->status                    = 'rescheduled';
        $interview->save();

        // Log the status change
        DB::table('application_status_logs')->insert([
            'application_id' => $interview->application_id,
            'changed_by'     => $user->id,
            'old_status'     => 'interview',
            'new_status'     => 'interview',
            'reason'         => 'Pelamar mengajukan reschedule interview. Alasan: ' . $request->reschedule_reason . ' | Usulan: ' . \Carbon\Carbon::parse($request->proposed_date)->translatedFormat('d M Y, H:i'),
            'created_at'     => now(),
        ]);

        // Notify HR
        try {
            $jobTitle = $interview->application->job->title ?? 'Pekerjaan';
            \App\Services\NotificationService::create(
                $interview->scheduled_by,
                'interview_reschedule_request',
                'Permintaan Reschedule Interview',
                $user->name . ' mengajukan reschedule untuk posisi ' . $jobTitle . '. Tinjau dan putuskan di halaman Interviews.',
                [
                    'interview_id'   => $interview->id,
                    'application_id' => $interview->application_id,
                    'applicant_name' => $user->name,
                    'reason'         => $request->reschedule_reason,
                    'proposed_date'  => $request->proposed_date,
                    'link'           => '/hr/wawancara/daftar?status=rescheduled',
                ]
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Reschedule Notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan reschedule berhasil diajukan ke tim HR.'
        ]);
    }

    /**
     * Decline / Reject an interview session
     */
    public function declineInterview(Request $request, $id)
    {
        $user = Auth::user();
        
        $interview = \App\Models\Interview::where('id', $id)
            ->whereHas('application', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->firstOrFail();

        $request->validate([
            'decline_reason' => 'required|string|max:500',
        ]);

        // 1. Cancel the interview session
        $interview->status = 'cancelled';
        
        $declineNote = "[Wawancara Ditolak oleh Pelamar]\nAlasan: " . $request->decline_reason;
        $interview->notes = $interview->notes 
            ? $declineNote . "\n\n-------------------\nCatatan HR Sebelumnya:\n" . $interview->notes
            : $declineNote;
            
        $interview->save();

        // 2. Automatically reject/eliminate the application
        $application = $interview->application;
        $oldStatus = $application->status;
        $application->status = 'rejected';
        $application->save();

        // 3. Log the status change (interview -> rejected)
        DB::table('application_status_logs')->insert([
            'application_id' => $application->id,
            'changed_by' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => 'rejected',
            'reason' => 'Pelamar menolak jadwal interview (Otomatis Tereliminasi). Alasan: ' . $request->decline_reason,
            'created_at' => now(),
        ]);

        // 4. Notify HR
        try {
            \App\Services\NotificationService::create(
                $interview->scheduled_by,
                'interview_declined',
                'Interview Ditolak Pelamar (Tereliminasi)',
                $user->name . ' menolak undangan interview untuk posisi ' . ($application->jobPosting->title ?? 'Pekerjaan') . '. Pelamar otomatis dinyatakan gugur/tereliminasi.',
                [
                    'interview_id' => $interview->id,
                    'application_id' => $application->id,
                    'applicant_name' => $user->name,
                    'reason' => $request->decline_reason
                ]
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Decline Notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Undangan wawancara telah Anda tolak. Lamaran pekerjaan Anda otomatis dinyatakan gugur (tereliminasi).'
        ]);
    }

    /**
     * API to fetch booked slots on a specific date for applicants.
     */
    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $date = \Carbon\Carbon::parse($request->get('date'))->toDateString();

        $interviews = \App\Models\Interview::with(['application.user', 'application.job'])
            ->whereIn('status', ['scheduled', 'completed', 'rescheduled'])
            ->whereDate('scheduled_at', $date)
            ->get();

        $slots = $interviews->map(function($interview) {
            $start = \Carbon\Carbon::parse($interview->scheduled_at);
            $duration = (int) $interview->duration_minutes;
            $end = (clone $start)->addMinutes($duration);
            return [
                'id' => $interview->id,
                'candidate' => $interview->application->user->name ?? 'Candidate',
                'job' => $interview->application->job->title ?? 'Job',
                'start' => $start->format('H:i'),
                'end' => $end->format('H:i'),
                'start_time' => $start->toTimeString(),
                'end_time' => $end->toTimeString(),
                'duration' => $duration,
            ];
        });

        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }

    /**
     * Show applicant's saved jobs page
     */
    public function savedJobs()
    {
        $user = Auth::user();
        $persentase = $user->getProfileCompletionPercentage();

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
