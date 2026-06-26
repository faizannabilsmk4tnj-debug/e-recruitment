<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a specific user.
     */
    public static function create(int $userId, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'data'    => !empty($data) ? $data : null,
        ]);
    }

    /**
     * Notify all active HR users about a new application.
     * Respects user notification preferences (notif_new_applicant).
     */
    public static function notifyNewApplication($application): void
    {
        $applicantName = $application->user->name ?? 'Pelamar';
        $jobTitle      = $application->job->title ?? 'Lowongan';

        $hrUsers = User::whereIn('role', ['hr', 'hr_master'])
            ->where('is_active', true)
            ->get();

        foreach ($hrUsers as $hr) {
            // Check notification preference
            $pref = NotificationPreference::where('user_id', $hr->id)->first();
            if ($pref && !$pref->notif_new_applicant) {
                continue;
            }

            self::create(
                $hr->id,
                'new_applicant',
                'Pelamar Baru',
                "{$applicantName} melamar posisi {$jobTitle}.",
                [
                    'application_id' => $application->id,
                    'job_id'         => $application->job_id,
                    'applicant_name' => $applicantName,
                    'job_title'      => $jobTitle,
                ]
            );
        }
    }

    /**
     * Notify applicant when their application status changes.
     */
    public static function notifyStatusChange($application, string $newStatus): void
    {
        $jobTitle = $application->job->title ?? 'Lowongan';

        $statusLabels = [
            'shortlisted' => 'Shortlisted',
            'interview'   => 'Tahap Interview',
            'accepted'    => 'Diterima',
            'rejected'    => 'Ditolak',
        ];

        $label = $statusLabels[$newStatus] ?? ucfirst($newStatus);

        self::create(
            $application->user_id,
            'status_change',
            'Status Lamaran Berubah',
            "Lamaran Anda untuk posisi {$jobTitle} telah diperbarui ke status: {$label}.",
            [
                'application_id' => $application->id,
                'job_id'         => $application->job_id,
                'job_title'      => $jobTitle,
                'new_status'     => $newStatus,
            ]
        );
    }

    /**
     * Notify applicant when an interview is scheduled for them.
     */
    public static function notifyInterviewScheduled($interview): void
    {
        $application = $interview->application ?? null;
        if (!$application) return;

        $jobTitle    = $application->job->title ?? 'Lowongan';
        $scheduledAt = $interview->scheduled_at;

        // Format the date nicely
        $dateStr = $scheduledAt
            ? \Carbon\Carbon::parse($scheduledAt)->translatedFormat('d M Y, H:i')
            : 'Segera';

        $typeLabel = match ($interview->interview_type) {
            'online'  => 'Online',
            'offline' => 'Offline',
            'phone'   => 'Telepon',
            default   => ucfirst($interview->interview_type),
        };

        self::create(
            $application->user_id,
            'interview_scheduled',
            'Jadwal Interview',
            "Interview {$typeLabel} untuk posisi {$jobTitle} dijadwalkan pada {$dateStr}.",
            [
                'application_id' => $application->id,
                'interview_id'   => $interview->id,
                'job_title'      => $jobTitle,
                'scheduled_at'   => $scheduledAt,
                'interview_type' => $interview->interview_type,
                'location'       => $interview->location_or_link,
            ]
        );
    }

    /**
     * Notify applicant when an interview is rescheduled.
     */
    public static function notifyInterviewRescheduled($interview, $oldScheduledAt): void
    {
        $application = $interview->application ?? null;
        if (!$application) return;

        $jobTitle    = $application->job->title ?? 'Lowongan';
        $newScheduledAt = $interview->scheduled_at;

        $oldDateStr = $oldScheduledAt
            ? \Carbon\Carbon::parse($oldScheduledAt)->translatedFormat('d M Y, H:i')
            : 'Jadwal Sebelumnya';
        $newDateStr = $newScheduledAt
            ? \Carbon\Carbon::parse($newScheduledAt)->translatedFormat('d M Y, H:i')
            : 'Segera';

        $typeLabel = match ($interview->interview_type) {
            'online'  => 'Online',
            'offline' => 'Offline',
            'phone'   => 'Telepon',
            default   => ucfirst($interview->interview_type),
        };

        self::create(
            $application->user_id,
            'interview_rescheduled',
            'Jadwal Interview Diperbarui',
            "Jadwal interview {$typeLabel} untuk posisi {$jobTitle} diubah dari {$oldDateStr} menjadi {$newDateStr}.",
            [
                'application_id' => $application->id,
                'interview_id'   => $interview->id,
                'job_title'      => $jobTitle,
                'old_scheduled_at' => $oldScheduledAt,
                'new_scheduled_at' => $newScheduledAt,
                'interview_type' => $interview->interview_type,
                'location'       => $interview->location_or_link,
            ]
        );
    }

    /**
     * Notify applicant when an interview is cancelled.
     */
    public static function notifyInterviewCancelled($interview): void
    {
        $application = $interview->application ?? null;
        if (!$application) return;

        $jobTitle    = $application->job->title ?? 'Lowongan';
        $scheduledAt = $interview->scheduled_at;

        $dateStr = $scheduledAt
            ? \Carbon\Carbon::parse($scheduledAt)->translatedFormat('d M Y, H:i')
            : '';

        $typeLabel = match ($interview->interview_type) {
            'online'  => 'Online',
            'offline' => 'Offline',
            'phone'   => 'Telepon',
            default   => ucfirst($interview->interview_type),
        };

        self::create(
            $application->user_id,
            'interview_cancelled',
            'Interview Dibatalkan',
            "Interview {$typeLabel} untuk posisi {$jobTitle}" . ($dateStr ? " pada {$dateStr}" : "") . " telah dibatalkan.",
            [
                'application_id' => $application->id,
                'interview_id'   => $interview->id,
                'job_title'      => $jobTitle,
                'scheduled_at'   => $scheduledAt,
                'interview_type' => $interview->interview_type,
            ]
        );
    }

    /**
     * Notify HR users about vacancies approaching deadline.
     * Respects user notification preferences (notif_vacancy_deadline).
     */
    public static function notifyVacancyDeadline($jobPosting, int $daysRemaining): void
    {
        $hrUsers = User::whereIn('role', ['hr', 'hr_master'])
            ->where('is_active', true)
            ->get();

        foreach ($hrUsers as $hr) {
            $pref = NotificationPreference::where('user_id', $hr->id)->first();
            if ($pref && !$pref->notif_vacancy_deadline) {
                continue;
            }

            self::create(
                $hr->id,
                'vacancy_deadline',
                'Lowongan Segera Berakhir',
                "Lowongan \"{$jobPosting->title}\" akan berakhir dalam {$daysRemaining} hari.",
                [
                    'job_id'         => $jobPosting->id,
                    'job_title'      => $jobPosting->title,
                    'days_remaining' => $daysRemaining,
                ]
            );
        }
    }
}
