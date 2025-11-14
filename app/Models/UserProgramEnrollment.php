<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserProgramEnrollment extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'current_stage',
        'current_streak',
        'longest_streak',
        'last_log_date',
        'is_active',
        'baseline_completed',
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_log_date' => 'date',
        'current_stage' => 'integer',
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
        'is_active' => 'boolean',
        'baseline_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get current day in the 360-day program (1-360)
     */
    public function getCurrentDay(): int
    {
        return $this->start_date->diffInDays(Carbon::today()) + 1;
    }

    /**
     * Get days remaining in the 360-day program
     */
    public function getDaysRemaining(): int
    {
        return max(0, 360 - $this->getCurrentDay());
    }

    /**
     * Check if the 360-day program is completed
     */
    public function isCompleted(): bool
    {
        return $this->getCurrentDay() > 360;
    }

    /**
     * Get current stage based on day count
     * Stage 1 (Foundation): Days 1-90
     * Stage 2 (Expansion): Days 91-180
     * Stage 3 (Mastery): Days 181-360
     */
    public function getCurrentStage(): int
    {
        $day = $this->getCurrentDay();

        if ($day <= 90) {
            return 1; // Foundation
        } elseif ($day <= 180) {
            return 2; // Expansion
        } else {
            return 3; // Mastery
        }
    }

    /**
     * Get stage name
     */
    public function getStageName(): string
    {
        return match($this->getCurrentStage()) {
            1 => 'Foundation',
            2 => 'Expansion',
            3 => 'Mastery',
            default => 'Unknown',
        };
    }

    /**
     * Get stage theme color
     */
    public function getStageTheme(): array
    {
        return match($this->getCurrentStage()) {
            1 => [
                'name' => 'Foundation',
                'color' => 'green',
                'gradient' => 'from-green-600 to-green-500',
                'bg' => 'bg-green-900/30',
                'text' => 'text-green-400',
                'border' => 'border-green-500/30',
            ],
            2 => [
                'name' => 'Expansion',
                'color' => 'blue',
                'gradient' => 'from-blue-600 to-blue-500',
                'bg' => 'bg-blue-900/30',
                'text' => 'text-blue-400',
                'border' => 'border-blue-500/30',
            ],
            3 => [
                'name' => 'Mastery',
                'color' => 'gold',
                'gradient' => 'from-yellow-600 to-yellow-500',
                'bg' => 'bg-yellow-900/30',
                'text' => 'text-yellow-400',
                'border' => 'border-yellow-500/30',
            ],
            default => [
                'name' => 'Unknown',
                'color' => 'silver',
                'gradient' => 'from-silver-600 to-silver-500',
                'bg' => 'bg-silver-900/30',
                'text' => 'text-silver-400',
                'border' => 'border-silver-500/30',
            ],
        };
    }

    /**
     * Update streak counter when user logs daily metrics
     */
    public function updateStreak(): void
    {
        $today = Carbon::today();
        $lastLogDate = $this->last_log_date;

        if ($lastLogDate && $lastLogDate->addDay()->isSameDay($today)) {
            // Consecutive day - increment streak
            $this->current_streak++;
        } elseif (!$lastLogDate || !$lastLogDate->isSameDay($today)) {
            // First log or streak broken - reset to 1
            $this->current_streak = 1;
        }
        // If same day, don't change streak

        // Update longest streak if current exceeds it
        $this->longest_streak = max($this->longest_streak, $this->current_streak);
        $this->last_log_date = $today;
        $this->save();
    }

    /**
     * Get streak status message
     */
    public function getStreakMessage(): string
    {
        $streak = $this->current_streak;

        if ($streak >= 90) {
            return "Legendary! {$streak} days strong! 👑";
        } elseif ($streak >= 30) {
            return "On fire! {$streak} days in a row! 🔥🔥";
        } elseif ($streak >= 7) {
            return "One week streak! Keep it up! 🔥";
        } elseif ($streak >= 3) {
            return "{$streak} days and counting! 💪";
        } elseif ($streak == 1) {
            return "Great start! Build your streak! ⚡";
        }

        return "Start your streak today!";
    }
}
