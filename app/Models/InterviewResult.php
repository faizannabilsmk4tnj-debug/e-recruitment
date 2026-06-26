<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewResult extends Model
{
    public $timestamps = false; // The table only has created_at timestamp

    protected $fillable = [
        'interview_id',
        'reviewed_by',
        'score',
        'feedback',
        'recommendation',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function interview()
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
