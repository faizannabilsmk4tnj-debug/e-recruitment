<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $application_id
 * @property int $scheduled_by
 * @property \Carbon\Carbon $scheduled_at
 * @property int $duration_minutes
 * @property string $interview_type
 * @property string|null $location_or_link
 * @property string $status
 * @property string|null $notes
 * @property string|null $attendance_status
 * @property \Carbon\Carbon|null $attendance_confirmed_at
 * @property string|null $attendance_photo
 * @property string|null $reschedule_reason
 * @property int|null $reschedule_requested_by
 * @property string|null $reschedule_request_status
 * @property \Carbon\Carbon|null $proposed_scheduled_at
 * @property string|null $proposed_interview_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User $scheduler
 * @property-read \App\Models\InterviewResult|null $result
 */
class Interview extends Model
{
    protected $fillable = [
        'application_id',
        'scheduled_by',
        'scheduled_at',
        'duration_minutes',
        'interview_type',
        'location_or_link',
        'status',
        'notes',
        'attendance_status',
        'attendance_confirmed_at',
        'attendance_photo',
        'reschedule_reason',
        'reschedule_requested_by',
        'reschedule_request_status',
        'proposed_scheduled_at',
        'proposed_interview_type',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'proposed_scheduled_at' => 'datetime',
        'attendance_confirmed_at' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function scheduler()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function result()
    {
        return $this->hasOne(InterviewResult::class, 'interview_id');
    }
}
