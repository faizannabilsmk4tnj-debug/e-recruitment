<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantCv extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'cv_data',
        'pdf_url',
        'is_primary',
    ];

    protected $casts = [
        'cv_data' => 'array',
        'is_primary' => 'boolean',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(CvTemplate::class, 'template_id');
    }
}
