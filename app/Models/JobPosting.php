<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'hr_user_id',
        'category_id',
        'title',
        'slug',
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
        'applicant_count',
        'status',
        'deadline',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'salary_min'      => 'decimal:2',
            'salary_max'      => 'decimal:2',
            'show_salary'     => 'boolean',
            'quota'           => 'integer',
            'applicant_count' => 'integer',
            'deadline'        => 'date',
            'closed_at'       => 'datetime',
        ];
    }

    // ── Relationships ──

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

    // ── Helpers ──

    /**
     * Map status DB (open/draft/closed/expired) ke label tampilan HR.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open'    => 'ACTIVE',
            'draft'   => 'DRAFT',
            'closed'  => 'CLOSED',
            'expired' => 'CLOSED',
            default   => strtoupper($this->status),
        };
    }

    /**
     * Hitung progress bar: (jumlah applicants / quota) * 100
     */
    public function getProgressAttribute(): int
    {
        if ($this->quota <= 0) return 0;
        return (int) min(round(($this->applications()->count() / $this->quota) * 100), 100);
    }

    /**
     * Format deadline untuk tampilan tabel.
     */
    public function getFormattedDeadlineAttribute(): string
    {
        return $this->deadline
            ? $this->deadline->format('d M Y')
            : '-';
    }
}
