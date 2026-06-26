<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
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
