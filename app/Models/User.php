<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'password',
        'role',
        'phone',
        'job_title',
        'language',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'password_hash',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Accessor for password.
     */
    public function getPasswordAttribute()
    {
        return $this->password_hash;
    }

    /**
     * Mutator for password.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = $value;
    }

    /**
     * Return the password hash for authentication.
     * Reads from password_hash first, falls back to password column.
     */
    public function getAuthPassword()
    {
        return $this->password_hash ?: $this->password;
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
        return $this->hasMany(ApplicantSkill::class, 'user_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'user_id');
    }

    /**
     * Relasi ke NotificationPreference.
     */
    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }

    /**
     * Relasi ke Notifications.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
