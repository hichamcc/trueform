<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyLog;
use Carbon\Carbon;

class ProgressController extends Controller
{
    /**
     * Display progress analytics and milestone tracking for 360-day journey
     *
     * Features:
     * - Baseline vs Current comparisons for all 5 wellness metrics
     * - Percentage change calculations (positive = improvement)
     * - Interactive Chart.js visualizations (Mito-Age Score + All Metrics)
     * - All 8 milestone badges with unlock status
     * - Stage-themed progress insights
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $baseline = $user->baseline;
        $enrollment = $user->programEnrollment;

        // Get current stage information (1=Foundation, 2=Expansion, 3=Mastery)
        $currentStage = $enrollment ? $enrollment->getCurrentStage() : 1;
        $stageName = $enrollment ? $enrollment->getStageName() : 'Foundation';
        $stageTheme = $enrollment ? $enrollment->getStageTheme() : [];

        // Get all daily logs for charting (sorted chronologically)
        $allLogs = $user->dailyLogs()
            ->orderBy('log_date', 'asc')
            ->get();

        // Get most recent log for current comparison
        $latestLog = $user->dailyLogs()
            ->orderBy('log_date', 'desc')
            ->first();

        // Calculate baseline vs current comparisons for all metrics
        $comparisons = [];
        if ($baseline && $latestLog) {
            $comparisons = $this->calculateComparisons($baseline, $latestLog);
        }

        // Get all 8 milestones (30, 60, 90, 120, 150, 180, 270, 360)
        $milestones = $user->milestones()
            ->orderBy('milestone_day')
            ->get();

        // Prepare data for Chart.js visualizations
        $chartData = [
            'labels' => $allLogs->pluck('log_date')->map(fn($date) => $date->format('M d'))->toArray(),
            'energy' => $allLogs->pluck('energy')->toArray(),
            'focus' => $allLogs->pluck('focus')->toArray(),
            'sleep' => $allLogs->pluck('sleep')->toArray(),
            'gut_health' => $allLogs->pluck('gut_health')->toArray(),
            'skin_glow' => $allLogs->pluck('skin_glow')->toArray(),
            'mito_age_score' => $allLogs->pluck('mito_age_score')->toArray(),
        ];

        // Calculate 7/30/90-day improvement statistics
        $improvements = $this->calculateTimeWindowImprovements($user, $baseline);

        return view('dashboard.progress', compact(
            'baseline',
            'latestLog',
            'comparisons',
            'milestones',
            'chartData',
            'enrollment',
            'currentStage',
            'stageName',
            'stageTheme',
            'improvements'
        ));
    }

    /**
     * Calculate baseline vs current comparisons for all wellness metrics
     *
     * Returns array with:
     * - baseline: Starting value
     * - current: Latest value
     * - change: Absolute difference (current - baseline)
     * - percentage: Percentage change ((current - baseline) / baseline * 100)
     *
     * Positive percentage = improvement, Negative percentage = decline
     */
    private function calculateComparisons($baseline, $latestLog): array
    {
        $metrics = ['energy', 'focus', 'sleep', 'gut_health', 'skin_glow', 'mito_age_score'];
        $comparisons = [];

        foreach ($metrics as $metric) {
            $baselineValue = $baseline->$metric;
            $currentValue = $latestLog->$metric;
            $change = $currentValue - $baselineValue;
            $percentage = $baselineValue > 0
                ? (($currentValue - $baselineValue) / $baselineValue) * 100
                : 0;

            $comparisons[$metric] = [
                'baseline' => $baselineValue,
                'current' => $currentValue,
                'change' => $change,
                'percentage' => $percentage
            ];
        }

        return $comparisons;
    }

    /**
     * Calculate improvement percentages for 7, 30, and 90-day windows
     * Compares average of each window against baseline
     */
    private function calculateTimeWindowImprovements($user, $baseline): array
    {
        if (!$baseline) {
            return [
                '7_days' => null,
                '30_days' => null,
                '90_days' => null,
            ];
        }

        $improvements = [];
        $windows = [
            '7_days' => 7,
            '30_days' => 30,
            '90_days' => 90,
        ];

        foreach ($windows as $key => $days) {
            $logs = $user->dailyLogs()
                ->where('log_date', '>=', Carbon::now()->subDays($days))
                ->get();

            if ($logs->count() > 0) {
                $improvements[$key] = [
                    'count' => $logs->count(),
                    'energy' => $this->calculateMetricImprovement($baseline->energy, $logs->avg('energy')),
                    'focus' => $this->calculateMetricImprovement($baseline->focus, $logs->avg('focus')),
                    'sleep' => $this->calculateMetricImprovement($baseline->sleep, $logs->avg('sleep')),
                    'gut_health' => $this->calculateMetricImprovement($baseline->gut_health, $logs->avg('gut_health')),
                    'skin_glow' => $this->calculateMetricImprovement($baseline->skin_glow, $logs->avg('skin_glow')),
                    'mito_age_score' => $this->calculateMetricImprovement($baseline->mito_age_score, $logs->avg('mito_age_score')),
                ];
            } else {
                $improvements[$key] = null;
            }
        }

        return $improvements;
    }

    /**
     * Calculate improvement percentage for a single metric
     */
    private function calculateMetricImprovement($baseline, $current): float
    {
        if ($baseline == 0) return 0;
        return round((($current - $baseline) / $baseline) * 100, 1);
    }
}
