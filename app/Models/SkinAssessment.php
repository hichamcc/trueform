<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkinAssessment extends Model
{
    protected $fillable = [
        'user_id',
        'milestone_day',
        'day_in_program',
        'assessment_date',
        'radiance',
        'smoothness',
        'calmness',
        'clarity',
        'hydration',
        'firmness',
        'evenness',
        'photo',
        'notes',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'radiance' => 'decimal:1',
        'smoothness' => 'decimal:1',
        'calmness' => 'decimal:1',
        'clarity' => 'decimal:1',
        'hydration' => 'decimal:1',
        'firmness' => 'decimal:1',
        'evenness' => 'decimal:1',
        'skin_score' => 'decimal:1',
    ];

    /**
     * Get the user that owns the assessment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the milestone label for this assessment
     */
    public function getMilestoneLabel(): string
    {
        return match($this->milestone_day) {
            0 => 'Baseline',
            30 => 'Day 30',
            60 => 'Day 60',
            90 => 'Day 90',
            180 => 'Day 180',
            270 => 'Day 270',
            360 => 'Day 360',
            default => "Day {$this->milestone_day}",
        };
    }

    /**
     * Check if this is the baseline assessment
     */
    public function isBaseline(): bool
    {
        return $this->milestone_day === 0;
    }
}
