<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralFreeMonth extends Model
{
    protected $fillable = [
        'user_id',
        'earned_at',
        'referral_milestone',
        'is_claimed',
        'claimed_at',
        'expires_at',
        'applied_month',
        'applied_year',
        'admin_approved',
        'admin_approved_at',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
        'claimed_at' => 'datetime',
        'expires_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'is_claimed' => 'boolean',
        'admin_approved' => 'boolean',
        'referral_milestone' => 'integer',
        'applied_month' => 'integer',
        'applied_year' => 'integer',
    ];

    /**
     * Get the user who earned this free month
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved this
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Mark as claimed
     */
    public function claim(int $month, int $year): void
    {
        $this->update([
            'is_claimed' => true,
            'claimed_at' => now(),
            'applied_month' => $month,
            'applied_year' => $year,
        ]);
    }

    /**
     * Approve by admin
     */
    public function approve(User $admin, string $notes = null): void
    {
        $this->update([
            'admin_approved' => true,
            'admin_approved_at' => now(),
            'approved_by' => $admin->id,
            'notes' => $notes,
        ]);
    }

    /**
     * Scope for unclaimed free months
     */
    public function scopeUnclaimed($query)
    {
        return $query->where('is_claimed', false);
    }

    /**
     * Scope for claimed free months
     */
    public function scopeClaimed($query)
    {
        return $query->where('is_claimed', true);
    }

    /**
     * Scope for pending admin approval
     */
    public function scopePendingApproval($query)
    {
        return $query->where('admin_approved', false);
    }

    /**
     * Check if free month is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
