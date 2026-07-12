<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nik',
        'address',
        'city',
        'province',
        'birth_place',
        'birth_date',
        'gender',
        'marital_status',
        'latest_education',
        'school_name',
        'education_completed_at',
        'gpa',
        'ktp_province',
        'ktp_city',
        'ktp_district',
        'ktp_subdistrict',
        'ktp_address',
        'dom_province',
        'dom_city',
        'dom_district',
        'dom_subdistrict',
        'dom_address',
        'avatar_url',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
