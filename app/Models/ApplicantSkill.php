<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantSkill extends Model
{
    protected $table = 'applicant_skills';

    protected $fillable = [
        'id_user',
        'skill_name',
        'category',
        'level',
        'cert_name',
        'cert_file_path',
        'cert_file_size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
