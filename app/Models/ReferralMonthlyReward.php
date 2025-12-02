<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralMonthlyReward extends Model
{
    protected $fillable = [
        'referral_id',
        'referrer_id',
        'referred_id',
        'month',
        'year',
        'reward_amount',
        'subscription_amount',
        'status',
        'paid_at',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'reward_amount' => 'decimal:2',
        'subscription_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the referral this reward belongs to
     */
    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }

    /**
     * Get the user earning the reward (referrer)
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the referred user (whose subscription is generating the reward)
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Mark reward as paid
     */
    public function markPaid(string $paymentMethod = null, string $notes = null): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_method' => $paymentMethod,
            'notes' => $notes,
        ]);

        // Update referral total_paid
        $this->referral->addPaid($this->reward_amount);
    }

    /**
     * Scope for pending rewards
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for paid rewards
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope for specific month/year
     */
    public function scopeForMonth($query, int $month, int $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }
}
