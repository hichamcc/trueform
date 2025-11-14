<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    /**
     * Valid milestone days across all 3 stages
     * Stage 1 (Foundation): 30, 60, 90
     * Stage 2 (Expansion): 120, 150, 180
     * Stage 3 (Mastery): 270, 360
     */
    public const VALID_MILESTONE_DAYS = [30, 60, 90, 120, 150, 180, 270, 360];

    protected $fillable = [
        'user_id',
        'milestone_day',
        'unlocked_at',
        'reward_claimed',
        'reward_title',
        'reward_description',
    ];

    protected $casts = [
        'unlocked_at' => 'datetime',
        'reward_claimed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUnlocked(): bool
    {
        return !is_null($this->unlocked_at);
    }

    /**
     * Get which stage this milestone belongs to
     * Stage 1: Days 30, 60, 90
     * Stage 2: Days 120, 150, 180
     * Stage 3: Days 270, 360
     */
    public function getMilestoneStage(): int
    {
        return match($this->milestone_day) {
            30, 60, 90 => 1,        // Foundation
            120, 150, 180 => 2,     // Expansion
            270, 360 => 3,          // Mastery
            default => 0,
        };
    }

    /**
     * Get milestone details including rewards
     */
    public function getDefaultReward(): array
    {
        return match($this->milestone_day) {
            30 => [
                'title' => 'Foundation: First Month Complete',
                'description' => 'You\'ve completed your first 30 days! Your cellular foundation is building.',
            ],
            60 => [
                'title' => 'Foundation: Two Months Strong',
                'description' => 'Day 60 milestone achieved! Your mitochondria are adapting and strengthening.',
            ],
            90 => [
                'title' => 'Foundation Stage Complete',
                'description' => 'Congratulations! You\'ve completed the Foundation stage. Ready for Expansion?',
            ],
            120 => [
                'title' => 'Expansion: 120 Days of Growth',
                'description' => 'Four months in! Your cellular energy systems are expanding and optimizing.',
            ],
            150 => [
                'title' => 'Expansion: Five Months Milestone',
                'description' => 'Day 150 reached! You\'re building advanced metabolic resilience.',
            ],
            180 => [
                'title' => 'Expansion Stage Complete',
                'description' => 'Half a year complete! You\'ve mastered expansion. Time for true mastery.',
            ],
            270 => [
                'title' => 'Mastery: Nine Months of Excellence',
                'description' => 'Day 270 achieved! Your transformation is in the mastery phase.',
            ],
            360 => [
                'title' => 'Mastery Stage Complete - Full Year!',
                'description' => 'You\'ve completed the entire 360-day journey! You are True Form Elite.',
            ],
            default => [
                'title' => 'Milestone Achieved',
                'description' => 'You\'ve reached an important milestone in your journey.',
            ],
        };
    }
}
