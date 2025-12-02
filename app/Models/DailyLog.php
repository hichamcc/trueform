<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyLog extends Model
{
    protected $fillable = [
        'user_id',
        'log_date',
        'energy',
        'focus',
        'sleep',
        'gut_health',
        'notes',
    ];

    protected $casts = [
        'log_date' => 'date',
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
