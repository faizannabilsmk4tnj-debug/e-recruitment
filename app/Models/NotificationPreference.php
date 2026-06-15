<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    protected $table = 'user_notification_preferences';

    protected $fillable = [
        'user_id',
        'notif_new_applicant',
        'notif_interview_schedule',
        'notif_vacancy_capacity',
        'notif_vacancy_deadline',
    ];

    protected $casts = [
        'notif_new_applicant' => 'boolean',
        'notif_interview_schedule' => 'boolean',
        'notif_vacancy_capacity' => 'boolean',
        'notif_vacancy_deadline' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
