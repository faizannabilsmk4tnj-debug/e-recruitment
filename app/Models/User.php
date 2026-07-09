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
        'is_active',
        'has_privilege',
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
            'has_privilege'     => 'boolean',
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
     * Calculate profile completion percentage.
     */
    public function getProfileCompletionPercentage(): int
    {
        $poin = 0;
        $userId = $this->id;

        $profile = \Illuminate\Support\Facades\DB::table('user_profiles')->where('user_id', $userId)->first();

        if ($profile) {
            if (!empty($profile->avatar_url))   $poin += 5;
            if (!empty($this->name))            $poin += 5; // +2 points
            if (!empty($profile->gender))       $poin += 3; // +1 point
            if (!empty($this->phone))           $poin += 5; // +2 points
            if (!empty($this->email))           $poin += 3; // +1 point
            if (!empty($profile->birth_date))   $poin += 3;
            if (!empty($profile->address))      $poin += 4;
            if (!empty($profile->city))         $poin += 2;
            if (!empty($profile->province))     $poin += 2;

            $latestEdu = \Illuminate\Support\Facades\DB::table('educations')->where('user_id', $userId)->exists();
            if ($latestEdu) $poin += 3;
        }

        $education = \Illuminate\Support\Facades\DB::table('educations')
            ->where('user_id', $userId)
            ->whereNotNull('institution')
            ->whereNotNull('degree')
            ->exists();
        if ($education) $poin += 20;

        $portfolio = \Illuminate\Support\Facades\DB::table('portofolio')
            ->where('user_id', $userId)
            ->exists();
        if ($portfolio) $poin += 15;

        $workExp = \Illuminate\Support\Facades\DB::table('work_experiences')
            ->where('user_id', $userId)
            ->exists();
        if ($workExp) $poin += 15;

        $orgExp = \Illuminate\Support\Facades\DB::table('organization_experiences')
            ->where('user_id', $userId)
            ->exists();
        if ($orgExp) $poin += 10;

        $sertifikat = \Illuminate\Support\Facades\DB::table('applicant_skills')
            ->where('user_id', $userId)
            ->whereNotNull('cert_file_path')
            ->exists();
        if ($sertifikat) $poin += 5;

        return min($poin, 100);
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
