<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
    ];

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'category_id');
    }
}
