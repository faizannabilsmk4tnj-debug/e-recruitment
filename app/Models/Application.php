<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'cv_id',
        'resume_title',
        'cover_letter',
        'resume_url',
        'status',
        'hr_notes',
        'source',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job()
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    public function cv()
    {
        return $this->belongsTo(ApplicantCv::class, 'cv_id');
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class, 'application_id');
    }
}
