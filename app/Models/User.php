<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Disesuaikan dengan kolom di tabel users.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'job_title',
        'language',
        'is_active',
    ];

    /**
     * Kolom yang disembunyikan saat model dikonversi ke array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast otomatis untuk tipe data tertentu.
     * 'password' => 'hashed' → Laravel otomatis hash password sebelum disimpan.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',  // ← inilah yang melakukan hashing
            'is_active'         => 'boolean',
        ];
    }
    /**
     * Relasi ke UserProfile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function organizationExperiences(): HasMany
    {
        return $this->hasMany(OrganizationExperience::class);
    }

    public function applicantCvs(): HasMany
    {
        return $this->hasMany(ApplicantCv::class);
    }

    public function applicantSkills(): HasMany
    {
        return $this->hasMany(ApplicantSkill::class, 'id_user');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'id_user');
    }

    /**
     * Relasi ke NotificationPreference.
     */
    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }
}
