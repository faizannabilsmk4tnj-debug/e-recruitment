<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'job_id'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }
}
