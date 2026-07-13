<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobPosting;
use App\Services\NotificationService;
use App\Models\Notification;
use Carbon\Carbon;

class CheckVacancyDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-vacancy-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check vacancy deadlines and send notifications to HR';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today('Asia/Jakarta');
        $this->info("Checking vacancy status and deadlines for: " . $today->toDateString());
 
        // Get all open job postings
        $jobs = JobPosting::where('status', 'open')->get();
 
        $processedCount = 0;
 
        /** @var \App\Models\JobPosting $job */
        foreach ($jobs as $job) {
            $isClosed = false;
            
            // 1. Check if Quota is met (only if auto_close_method allows quota closure)
            if (in_array($job->auto_close_method, ['quota', 'both'])) {
                if ($job->quota > 0 && $job->applicant_count >= $job->quota) {
                    $job->update([
                        'status' => 'closed',
                        'closed_at' => now()
                    ]);
                    $this->info("Job ID {$job->id} ({$job->title}) automatically closed: Quota met ({$job->applicant_count}/{$job->quota}).");
                    $isClosed = true;
                    
                    // Notify HR about automatic closure due to quota
                    $this->notifyHRClosure($job, 'quota');
                    $processedCount++;
                }
            }
            
            // 2. Check if Deadline is passed (if not already closed and auto_close_method allows deadline closure)
            if (!$isClosed && $job->deadline && in_array($job->auto_close_method, ['deadline', 'both'])) {
                $nowLocal = Carbon::now('Asia/Jakarta');
                $deadline = Carbon::parse($job->deadline->format('Y-m-d'), 'Asia/Jakarta')->endOfDay();
                
                if ($nowLocal->greaterThan($deadline)) {
                    $job->update([
                        'status' => 'closed',
                        'closed_at' => now()
                    ]);
                    $this->info("Job ID {$job->id} ({$job->title}) automatically closed: Deadline passed.");
                    $isClosed = true;
                    
                    // Notify HR about automatic closure due to deadline
                    $this->notifyHRClosure($job, 'deadline');
                    $processedCount++;
                } else {
                    // Check if deadline is approaching (3 days or 1 day)
                    $daysRemaining = (int) $today->diffInDays(Carbon::parse($job->deadline->format('Y-m-d'), 'Asia/Jakarta')->startOfDay(), false);
                    if (in_array($daysRemaining, [3, 1])) {
                        $this->notifyHRApproaching($job, $daysRemaining);
                        $processedCount++;
                    }
                }
            }
        }
 
        $this->info("Finished checking vacancies. Processed {$processedCount} actions.");
    }

    /**
     * Notify HR that a vacancy has been closed automatically
     */
    private function notifyHRClosure($job, $reason)
    {
        $hrUsers = \App\Models\User::whereIn('role', ['hr', 'hr_master'])
            ->where('is_active', true)
            ->get();

        foreach ($hrUsers as $hr) {
            $pref = \App\Models\NotificationPreference::where('user_id', $hr->id)->first();
            if ($pref && !$pref->notif_vacancy_deadline) {
                continue;
            }

            // Check if already notified today for this closure
            $alreadyNotified = Notification::where('user_id', $hr->id)
                ->where('type', 'vacancy_closed_auto')
                ->where('data->job_id', $job->id)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            $message = $reason === 'quota' 
                ? "Lowongan \"{$job->title}\" telah ditutup otomatis karena kuota pendaftar terpenuhi ({$job->applicant_count}/{$job->quota})."
                : "Lowongan \"{$job->title}\" telah ditutup otomatis karena telah melewati batas tenggat waktu pendaftaran.";

            $title = $reason === 'quota' 
                ? 'Lowongan Ditutup (Kuota Penuh)' 
                : 'Lowongan Ditutup (Deadline Lewat)';

            NotificationService::create(
                $hr->id,
                'vacancy_closed_auto',
                $title,
                $message,
                [
                    'job_id'    => $job->id,
                    'job_title' => $job->title,
                    'reason'    => $reason,
                ]
            );
        }
    }

    /**
     * Notify HR that a vacancy deadline is approaching
     */
    private function notifyHRApproaching($job, $daysRemaining)
    {
        $hrUsers = \App\Models\User::whereIn('role', ['hr', 'hr_master'])
            ->where('is_active', true)
            ->get();

        foreach ($hrUsers as $hr) {
            $pref = \App\Models\NotificationPreference::where('user_id', $hr->id)->first();
            if ($pref && !$pref->notif_vacancy_deadline) {
                continue;
            }

            $alreadyNotified = Notification::where('user_id', $hr->id)
                ->where('type', 'vacancy_deadline')
                ->where('data->job_id', $job->id)
                ->where('data->days_remaining', $daysRemaining)
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            NotificationService::create(
                $hr->id,
                'vacancy_deadline',
                'Lowongan Segera Berakhir',
                "Lowongan \"{$job->title}\" akan berakhir dalam {$daysRemaining} hari.",
                [
                    'job_id'         => $job->id,
                    'job_title'      => $job->title,
                    'days_remaining' => $daysRemaining,
                ]
            );
        }
    }
}
