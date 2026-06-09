<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portofolio extends Model
{
    protected $table = 'portofolio';

    protected $fillable = [
        'id_user',
        'title',
        'description',
        'type',
        'link_url',
        'file_url',
        'file_size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
