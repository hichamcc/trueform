<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'kpi',
        'product_name',
        'product_link',
        'description',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Get active recommendations for a specific KPI
     */
    public static function getForKpi(string $kpi)
    {
        return self::where('kpi', $kpi)
            ->where('is_active', true)
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get KPI display name
     */
    public function getKpiDisplayName(): string
    {
        return match($this->kpi) {
            'energy' => 'Energy',
            'focus' => 'Focus',
            'sleep' => 'Sleep',
            'gut_health' => 'Gut Health',
            'skin_glow' => 'Skin Glow',
            default => ucfirst($this->kpi),
        };
    }
}
