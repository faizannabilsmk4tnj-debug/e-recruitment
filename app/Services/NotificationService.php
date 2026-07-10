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
        $notification = Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'data'    => !empty($data) ? $data : null,
        ]);

        try {
            $user = User::find($userId);
            if ($user && !empty($user->email)) {
                $shouldEmail = false;
                $actionUrl = null;
                $actionText = null;

                if ($user->role === 'applicant') {
                    // Send email to applicant for application status changes and interviews
                    $allowedTypes = [
                        'status_change',
                        'interview_scheduled',
                        'interview_rescheduled',
                        'interview_cancelled'
                    ];
                    if (in_array($type, $allowedTypes)) {
                        $shouldEmail = true;
                        $actionUrl = url('/pelamar/status-lamaran');
                        $actionText = 'View Application Status';
                    }
                } elseif (in_array($user->role, ['hr', 'hr_master'])) {
                    // Send email to HR for vacancy closures and approaching deadlines
                    $allowedTypes = [
                        'vacancy_closed_auto',
                        'vacancy_deadline'
                    ];
                    if (in_array($type, $allowedTypes)) {
                        $shouldEmail = true;
                        $actionUrl = url('/hr/lowongan');
                        $actionText = 'Manage Vacancies';
                    }
                }

                if ($shouldEmail) {
                    \Illuminate\Support\Facades\Mail::to($user->email)->send(
                        new \App\Mail\NotificationMail($title, $message, $actionUrl, $actionText)
                    );
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send notification email: ' . $e->getMessage());
        }

        return $notification;
    }

    /**
     * Notify all active HR users about a new application.
     * Respects user notification preferences (notif_new_applicant).
     */
    public static function notifyNewApplication($application): void
    {
        $applicantName = $application->user->name ?? 'Applicant';
        $jobTitle      = $application->job->title ?? 'Vacancy';

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
                'New Applicant',
                "{$applicantName} applied for the {$jobTitle} position.",
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
        $jobTitle = $application->job->title ?? 'Vacancy';

        $statusLabels = [
            'shortlisted' => 'Shortlisted',
            'interview'   => 'Interview Stage',
            'accepted'    => 'Accepted',
            'rejected'    => 'Rejected',
        ];

        $label = $statusLabels[$newStatus] ?? ucfirst($newStatus);

        self::create(
            $application->user_id,
            'status_change',
            'Application Status Updated',
            "Your application for the position {$jobTitle} has been updated to: {$label}.",
            [
                'application_id' => $application->id,
                'job_id'         => $application->job_id,
                'job_title'      => $jobTitle,
                'new_status'     => $newStatus,
            ]
        );
    }

    /**
     * Notify applicant when their system privilege is granted or revoked.
     */
    public static function notifyPrivilegeChange($user, bool $hasPrivilege): void
    {
        $title = $hasPrivilege ? 'Access Privilege Granted' : 'Access Privilege Revoked';
        $message = $hasPrivilege 
            ? 'Your recruitment system access privilege has been GRANTED by HR. You are now able to apply for new vacancies.'
            : 'Your recruitment system access privilege has been REVOKED by HR. You are temporarily unable to apply for new vacancies.';

        self::create(
            $user->id,
            'privilege_change',
            $title,
            $message,
            [
                'user_id' => $user->id,
                'has_privilege' => $hasPrivilege,
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

        $jobTitle    = $application->job->title ?? 'Vacancy';
        $scheduledAt = $interview->scheduled_at;

        // Format the date nicely
        $dateStr = $scheduledAt
            ? \Carbon\Carbon::parse($scheduledAt)->format('d M Y, H:i')
            : 'Soon';

        $typeLabel = match ($interview->interview_type) {
            'online'  => 'Online',
            'offline' => 'Offline',
            default   => ucfirst($interview->interview_type),
        };

        self::create(
            $application->user_id,
            'interview_scheduled',
            'Interview Scheduled',
            "Your {$typeLabel} interview for the position {$jobTitle} is scheduled on {$dateStr}.",
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

        $jobTitle    = $application->job->title ?? 'Vacancy';
        $newScheduledAt = $interview->scheduled_at;

        $oldDateStr = $oldScheduledAt
            ? \Carbon\Carbon::parse($oldScheduledAt)->format('d M Y, H:i')
            : 'Previous Schedule';
        $newDateStr = $newScheduledAt
            ? \Carbon\Carbon::parse($newScheduledAt)->format('d M Y, H:i')
            : 'Soon';

        $typeLabel = match ($interview->interview_type) {
            'online'  => 'Online',
            'offline' => 'Offline',
            default   => ucfirst($interview->interview_type),
        };

        self::create(
            $application->user_id,
            'interview_rescheduled',
            'Interview Rescheduled',
            "The {$typeLabel} interview schedule for the position {$jobTitle} has been rescheduled from {$oldDateStr} to {$newDateStr}.",
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

        $jobTitle    = $application->job->title ?? 'Vacancy';
        $scheduledAt = $interview->scheduled_at;

        $dateStr = $scheduledAt
            ? \Carbon\Carbon::parse($scheduledAt)->format('d M Y, H:i')
            : '';

        $typeLabel = match ($interview->interview_type) {
            'online'  => 'Online',
            'offline' => 'Offline',
            default   => ucfirst($interview->interview_type),
        };

        self::create(
            $application->user_id,
            'interview_cancelled',
            'Interview Cancelled',
            "The {$typeLabel} interview for the position {$jobTitle}" . ($dateStr ? " scheduled on {$dateStr}" : "") . " has been cancelled.",
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
                'Vacancy Closing Soon',
                "The vacancy \"{$jobPosting->title}\" is closing in {$daysRemaining} days.",
                [
                    'job_id'         => $jobPosting->id,
                    'job_title'      => $jobPosting->title,
                    'days_remaining' => $daysRemaining,
                ]
            );
        }
    }
}
