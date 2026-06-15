<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['user_id', 'job_id', 'cv_id', 'cover_letter', 'resume_url', 'status', 'hr_notes'];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
