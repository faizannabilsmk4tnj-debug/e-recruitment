<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
        'cv_id',
        'cover_letter',
        'resume_url',
        'status',
        'hr_notes',
    ];

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    // ── Helpers ──

    /**
     * Map status ke label tampilan HR.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'applied'     => 'Submitted',
            'reviewed'    => 'Reviewed',
            'shortlisted' => 'Shortlisted',
            'interview'   => 'Interview',
            'offered'     => 'Offered',
            'rejected'    => 'Rejected',
            'withdrawn'   => 'Withdrawn',
            default       => ucfirst($this->status),
        };
    }

    /**
     * Warna badge untuk status.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'applied'     => 'text-gray-600 bg-gray-100 border-gray-200',
            'reviewed'    => 'text-purple-700 bg-purple-50 border-purple-200',
            'shortlisted' => 'text-amber-700 bg-amber-50 border-amber-200',
            'interview'   => 'text-blue-700 bg-blue-50 border-blue-200',
            'offered'     => 'text-green-700 bg-green-50 border-green-200',
            'rejected'    => 'text-red-700 bg-red-50 border-red-200',
            'withdrawn'   => 'text-gray-500 bg-gray-50 border-gray-200',
            default       => 'text-gray-600 bg-gray-100 border-gray-200',
        };
    }

    /**
     * Inisial untuk avatar.
     */
    public function getAvatarInitialsAttribute(): string
    {
        $name = $this->user?->name ?? 'NN';
        $parts = explode(' ', $name);
        if (count($parts) >= 2) {
            return strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
        }
        return strtoupper(mb_substr($name, 0, 2));
    }

    /**
     * Warna avatar (deterministik berdasarkan user_id).
     */
    public function getAvatarColorAttribute(): string
    {
        $colors = [
            'bg-blue-500', 'bg-pink-500', 'bg-amber-500', 'bg-red-400',
            'bg-purple-500', 'bg-teal-500', 'bg-green-600', 'bg-indigo-500',
            'bg-rose-500', 'bg-blue-600', 'bg-cyan-500', 'bg-orange-500',
        ];
        return $colors[($this->user_id ?? 0) % count($colors)];
    }
}
