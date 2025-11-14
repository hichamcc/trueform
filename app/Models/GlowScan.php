<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class GlowScan extends Model
{
    protected $fillable = [
        'user_id',
        'scan_date',
        'glow_score',
        'image_path',
        'api_response',
    ];

    protected $casts = [
        'scan_date' => 'datetime',
        'glow_score' => 'decimal:1',
        'api_response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get the latest scan for a user
     */
    public function scopeLatestScan(Builder $query): Builder
    {
        return $query->orderBy('scan_date', 'desc')->limit(1);
    }

    /**
     * Scope to get scans for a specific date range
     */
    public function scopeDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('scan_date', [$startDate, $endDate]);
    }

    /**
     * Get glow score rating (Poor, Fair, Good, Excellent)
     */
    public function getGlowRating(): string
    {
        return match(true) {
            $this->glow_score >= 80 => 'Excellent',
            $this->glow_score >= 60 => 'Good',
            $this->glow_score >= 40 => 'Fair',
            default => 'Needs Improvement',
        };
    }

    /**
     * Get color class based on glow score
     */
    public function getGlowColorClass(): string
    {
        return match(true) {
            $this->glow_score >= 80 => 'text-green-400',
            $this->glow_score >= 60 => 'text-blue-400',
            $this->glow_score >= 40 => 'text-yellow-400',
            default => 'text-red-400',
        };
    }
}
