<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'institution',
        'degree',
        'major',
        'certificate_number',
        'gpa',
        'start_year',
        'end_year',
        'diploma_file',
        'skhu_file',
    ];

    protected function casts(): array
    {
        return [
            'gpa' => 'decimal:2',
            'start_year' => 'integer',
            'end_year' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
