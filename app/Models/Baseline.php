<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baseline extends Model
{
    protected $fillable = [
        'user_id',
        'energy',
        'focus',
        'sleep',
        'gut_health',
        'image',
        'photo',
    ];

    protected $casts = [
        'energy' => 'decimal:1',
        'focus' => 'decimal:1',
        'sleep' => 'decimal:1',
        'gut_health' => 'decimal:1',
        'mito_age_score' => 'decimal:1',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
