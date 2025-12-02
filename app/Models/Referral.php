<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'subscription_active',
        'subscription_started_at',
        'subscription_ended_at',
        'total_earned',
        'total_paid',
        'discount_percentage',
        'discount_amount',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'rewarded_at' => 'datetime',
        'subscription_started_at' => 'datetime',
        'subscription_ended_at' => 'datetime',
        'subscription_active' => 'boolean',
        'total_earned' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
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

    /**
     * Get monthly rewards for this referral
     */
    public function monthlyRewards(): HasMany
    {
        return $this->hasMany(ReferralMonthlyReward::class);
    }

    /**
     * Activate subscription tracking
     */
    public function activateSubscription(float $subscriptionAmount): void
    {
        $this->update([
            'subscription_active' => true,
            'subscription_started_at' => now(),
            'subscription_ended_at' => null,
        ]);
    }

    /**
     * Deactivate subscription tracking
     */
    public function deactivateSubscription(): void
    {
        $this->update([
            'subscription_active' => false,
            'subscription_ended_at' => now(),
        ]);
    }

    /**
     * Add monthly reward earned amount
     */
    public function addEarned(float $amount): void
    {
        $this->increment('total_earned', $amount);
    }

    /**
     * Mark reward as paid
     */
    public function addPaid(float $amount): void
    {
        $this->increment('total_paid', $amount);
    }

    /**
     * Get unpaid balance
     */
    public function getUnpaidBalanceAttribute(): float
    {
        return (float) ($this->total_earned - $this->total_paid);
    }
}
