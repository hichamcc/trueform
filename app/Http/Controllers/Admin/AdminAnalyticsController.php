<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailyLog;
use App\Models\Baseline;
use App\Models\Milestone;
use App\Models\UserProgramEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        // Metrics Overview
        $metricsImprovement = $this->getMetricsImprovement();

        // Completion Rates
        $completionRates = $this->getCompletionRates();

        // Engagement Analytics
        $engagementStats = $this->getEngagementStats();

        // Progress Analytics
        $progressStats = $this->getProgressStats();

        // Retention Data
        $retentionData = $this->getRetentionData();

        return view('admin.analytics.index', compact(
            'metricsImprovement',
            'completionRates',
            'engagementStats',
            'progressStats',
            'retentionData'
        ));
    }

    private function getMetricsImprovement()
    {
        return DB::table('baselines')
            ->join('daily_logs', 'baselines.user_id', '=', 'daily_logs.user_id')
            ->select([
                DB::raw('AVG(daily_logs.energy - baselines.energy) as energy_improvement'),
                DB::raw('AVG(daily_logs.focus - baselines.focus) as focus_improvement'),
                DB::raw('AVG(daily_logs.sleep - baselines.sleep) as sleep_improvement'),
                DB::raw('AVG(daily_logs.gut_health - baselines.gut_health) as gut_health_improvement'),
                DB::raw('AVG(daily_logs.skin_glow - baselines.skin_glow) as skin_glow_improvement'),
                DB::raw('AVG(daily_logs.mito_age_score - baselines.mito_age_score) as overall_improvement'),
            ])
            ->first();
    }

    private function getCompletionRates()
    {
        $total = UserProgramEnrollment::count();

        return [
            'day_30' => Milestone::where('milestone_day', 30)->whereNotNull('unlocked_at')->count(),
            'day_60' => Milestone::where('milestone_day', 60)->whereNotNull('unlocked_at')->count(),
            'day_90' => Milestone::where('milestone_day', 90)->whereNotNull('unlocked_at')->count(),
            'total_enrollments' => $total,
        ];
    }

    private function getEngagementStats()
    {
        $totalUsers = User::count();
        $totalLogs = DailyLog::count();

        return [
            'total_logs' => $totalLogs,
            'avg_logs_per_user' => $totalUsers > 0 ? round($totalLogs / $totalUsers, 1) : 0,
            'logs_today' => DailyLog::whereDate('log_date', today())->count(),
            'logs_this_week' => DailyLog::whereBetween('log_date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'active_users_week' => DailyLog::whereBetween('log_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->distinct('user_id')
                ->count('user_id'),
        ];
    }

    private function getProgressStats()
    {
        $enrollments = UserProgramEnrollment::all();

        $stats = [
            'avg_days_to_complete' => 0,
            'completion_rate' => 0,
            'dropout_analysis' => [],
        ];

        // Calculate average days for completed programs
        $completed = $enrollments->filter(function($enrollment) {
            return $enrollment->getCurrentDay() > 90;
        });

        if ($completed->count() > 0) {
            $stats['avg_days_to_complete'] = round($completed->avg(function($enrollment) {
                return $enrollment->getCurrentDay();
            }), 1);
            $stats['completion_rate'] = round(($completed->count() / $enrollments->count()) * 100, 1);
        }

        return $stats;
    }

    private function getRetentionData()
    {
        $data = [];
        for ($day = 1; $day <= 90; $day += 10) {
            $activeOnDay = UserProgramEnrollment::whereRaw("DATEDIFF(CURRENT_DATE, start_date) >= ?", [$day])
                ->count();
            $data[] = [
                'day' => $day,
                'active_users' => $activeOnDay,
            ];
        }
        return $data;
    }

    public function export()
    {
        // Export comprehensive analytics report
        $data = [
            'generated_at' => now()->toDateTimeString(),
            'metrics_improvement' => $this->getMetricsImprovement(),
            'completion_rates' => $this->getCompletionRates(),
            'engagement_stats' => $this->getEngagementStats(),
            'progress_stats' => $this->getProgressStats(),
            'retention_data' => $this->getRetentionData(),
        ];

        $filename = "analytics_report_" . now()->format('Y-m-d') . ".json";

        return response()->json($data)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
