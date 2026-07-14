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

        // 1. Informasi Profil Pribadi (Total 40%)
        if (!empty($this->name)) {
            $poin += 5;
        }
        if (!empty($this->email)) {
            $poin += 5;
        }
        if (!empty($this->phone)) {
            $poin += 5;
        }
        if ($profile) {
            if (!empty($profile->nik)) {
                $poin += 5;
            }
            if (!empty($profile->birth_date)) {
                $poin += 5;
            }
            // Alamat Lengkap: checks ktp_address or dom_address or generic address
            if (!empty($profile->address) || !empty($profile->ktp_address) || !empty($profile->dom_address)) {
                $poin += 5;
            }
            if (!empty($profile->gender)) {
                $poin += 4;
            }
            if (!empty($profile->city) || !empty($profile->ktp_city) || !empty($profile->dom_city)) {
                $poin += 3;
            }
            if (!empty($profile->province) || !empty($profile->ktp_province) || !empty($profile->dom_province)) {
                $poin += 3;
            }
            
            // Foto Profil (Avatar) (Opsional - 5%)
            if (!empty($profile->avatar_url)) {
                $poin += 5;
            }
        }

        // 2. Riwayat Pendidikan (Wajib - 20%)
        $education = \Illuminate\Support\Facades\DB::table('educations')
            ->where('user_id', $userId)
            ->whereNotNull('institution')
            ->whereNotNull('degree')
            ->exists();
        if ($education) {
            $poin += 20;
        }

        // 3. Portofolio (Wajib - 15%)
        $portfolio = \Illuminate\Support\Facades\DB::table('portofolio')
            ->where('user_id', $userId)
            ->exists();
        if ($portfolio) {
            $poin += 15;
        }

        // 4. Riwayat Pengalaman Kerja (Opsional - 15%)
        $workExp = \Illuminate\Support\Facades\DB::table('work_experiences')
            ->where('user_id', $userId)
            ->exists();
        if ($workExp) {
            $poin += 15;
        }

        // 5. Pengalaman Organisasi (Opsional - 10%)
        $orgExp = \Illuminate\Support\Facades\DB::table('organization_experiences')
            ->where('user_id', $userId)
            ->exists();
        if ($orgExp) {
            $poin += 10;
        }

        // 6. Sertifikat Pendukung (Opsional - 5%)
        $sertifikat = \Illuminate\Support\Facades\DB::table('applicant_skills')
            ->where('user_id', $userId)
            ->whereNotNull('cert_file_path')
            ->exists();
        if ($sertifikat) {
            $poin += 5;
        }

        return min($poin, 100);
    }

    /**
     * Check if the user meets all requirements to apply for a job.
     * Returns an array with 'eligible' (bool) and list of 'missing' fields.
     */
    public function getApplyRequirementsStatus(): array
    {
        $missing = [];
        $userId = $this->id;

        $profile = \Illuminate\Support\Facades\DB::table('user_profiles')->where('user_id', $userId)->first();

        // 1. Check mandatory personal info
        if (empty($this->name)) {
            $missing[] = 'Nama Lengkap';
        }
        if (empty($this->email)) {
            $missing[] = 'Email';
        }
        if (empty($this->phone)) {
            $missing[] = 'Nomor Telepon';
        }

        if (!$profile) {
            $missing[] = 'Profil Pribadi (NIK, Jenis Kelamin, Tanggal Lahir, Alamat)';
        } else {
            if (empty($profile->nik)) {
                $missing[] = 'Nomor Induk Kependudukan (NIK)';
            }
            if (empty($profile->gender)) {
                $missing[] = 'Jenis Kelamin';
            }
            if (empty($profile->birth_date)) {
                $missing[] = 'Tanggal Lahir';
            }
            if (empty($profile->address) && empty($profile->ktp_address) && empty($profile->dom_address)) {
                $missing[] = 'Alamat Lengkap';
            }
            if (empty($profile->city) && empty($profile->ktp_city) && empty($profile->dom_city)) {
                $missing[] = 'Kota/Kabupaten';
            }
            if (empty($profile->province) && empty($profile->ktp_province) && empty($profile->dom_province)) {
                $missing[] = 'Provinsi';
            }
        }

        // 2. Check education
        $hasEdu = \Illuminate\Support\Facades\DB::table('educations')
            ->where('user_id', $userId)
            ->whereNotNull('institution')
            ->whereNotNull('degree')
            ->exists();
        if (!$hasEdu) {
            $missing[] = 'Minimal 1 Riwayat Pendidikan';
        }

        // 3. Check portfolio
        $hasPortfolio = \Illuminate\Support\Facades\DB::table('portofolio')
            ->where('user_id', $userId)
            ->exists();
        if (!$hasPortfolio) {
            $missing[] = 'Minimal 1 Portofolio';
        }

        // 4. Check overall percentage
        $percentage = $this->getProfileCompletionPercentage();
        if ($percentage < 70) {
            $missing[] = "Persentase Kelengkapan Profil minimal 70% (Saat ini: {$percentage}%)";
        }

        return [
            'eligible' => empty($missing),
            'missing' => $missing,
            'percentage' => $percentage,
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
