<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'bio',
        'address',
        'city',
        'province',
        'birth_date',
        'gender',
        'avatar_url',
        'linkedin_url',
        'portfolio_url',
        'updated_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
