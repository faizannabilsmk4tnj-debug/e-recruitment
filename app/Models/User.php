<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }
}
