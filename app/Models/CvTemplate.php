<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class CvTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'preview_url',
        'content_html',
        'status',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function getUsageCountAttribute(): int
    {
        return $this->applicant_cvs_count ?? 0;
    }

    public function applicantCvs(): HasMany
    {
        return $this->hasMany(ApplicantCv::class, 'template_id');
    }
}
