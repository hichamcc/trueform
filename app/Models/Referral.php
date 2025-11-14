<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code',
        'referred_email',
        'status',
        'completed_at',
        'rewarded_at',
        'reward_type',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'rewarded_at' => 'datetime',
    ];

    /**
     * Get the user who is referring
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the user who was referred
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Mark referral as completed (user signed up)
     */
    public function markCompleted(User $user): void
    {
        $this->update([
            'referred_id' => $user->id,
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark referral as rewarded
     */
    public function markRewarded(string $rewardType = 'free_month'): void
    {
        $this->update([
            'status' => 'rewarded',
            'rewarded_at' => now(),
            'reward_type' => $rewardType,
        ]);
    }
}
