<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hr_user_id',
        'category_id',
        'title',
        'slug',
        'banner_image',
        'description',
        'requirements',
        'benefits',
        'employment_type',
        'location_type',
        'location',
        'salary_min',
        'salary_max',
        'show_salary',
        'quota',
        'age_min',
        'age_max',
        'passing_grade',
        'applicant_count',
        'status',
        'auto_close_method',
        'deadline',
        'closed_at',
        'is_archived',
    ];

    protected $casts = [
        'show_salary' => 'boolean',
        'quota' => 'integer',
        'age_min' => 'integer',
        'age_max' => 'integer',
        'passing_grade' => 'integer',
        'applicant_count' => 'integer',
        'deadline' => 'date',
        'closed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->slug)) {
                $job->slug = Str::slug($job->title) . '-' . uniqid();
            }
        });
    }

    public function hrUser()
    {
        return $this->belongsTo(User::class, 'hr_user_id');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}
