<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailyLog;
use App\Models\Milestone;
use App\Models\UserProgramEnrollment;
use App\Models\Baseline;
use App\Models\SkinAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total Users
        $totalUsers = User::count();

        // Active Programs (users with active enrollments)
        $activePrograms = UserProgramEnrollment::where('is_active', true)->count();

        // Completed Programs (users past day 360)
        $completedPrograms = UserProgramEnrollment::whereRaw('DATEDIFF(CURRENT_DATE, start_date) > 360')->count();

        // Completion Rate
        $completionRate = $totalUsers > 0 ? round(($completedPrograms / $totalUsers) * 100, 1) : 0;

        // Average Mito-Age Score Improvement
        $avgImprovement = $this->calculateAverageImprovement();

        // Today's Activity (logs submitted today)
        $todayLogs = DailyLog::whereDate('log_date', today())->count();

        // Recent Registrations (last 7 days)
        $recentRegistrations = User::where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent Daily Logs (last 10)
        $recentLogs = DailyLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent Milestone Unlocks (last 10)
        $recentMilestones = Milestone::with('user')
            ->whereNotNull('unlocked_at')
            ->orderBy('unlocked_at', 'desc')
            ->limit(10)
            ->get();

        // Quick Stats
        $totalBaselines = Baseline::count();
        $totalDailyLogs = DailyLog::count();
        $avgLogsPerUser = $totalUsers > 0 ? round($totalDailyLogs / $totalUsers, 1) : 0;

        // User Growth Chart Data (last 30 days)
        $userGrowth = $this->getUserGrowthData();

        // Daily Log Submissions Chart (last 30 days)
        $logSubmissions = $this->getLogSubmissionsData();

        // === NEW ANALYTICS ===

        // 1. Global Metrics Overview - Average improvements across all metrics
        $globalMetrics = $this->calculateGlobalMetricsImprovement();

        // 2. Stage Completion Statistics
        $stageCompletionStats = $this->calculateStageCompletionStats();

        // 3. Consistency Analytics
        $consistencyStats = $this->calculateConsistencyStats();

        // 4. Skin Glow Assessment Analytics
        $skinAssessmentStats = $this->calculateSkinAssessmentStats();

        // 5. Global Cohort Stats
        $cohortStats = $this->calculateCohortStats();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'activePrograms',
            'completedPrograms',
            'completionRate',
            'avgImprovement',
            'todayLogs',
            'recentRegistrations',
            'recentLogs',
            'recentMilestones',
            'totalBaselines',
            'totalDailyLogs',
            'avgLogsPerUser',
            'userGrowth',
            'logSubmissions',
            'globalMetrics',
            'stageCompletionStats',
            'consistencyStats',
            'skinAssessmentStats',
            'cohortStats'
        ));
    }

    private function calculateAverageImprovement()
    {
        $improvements = DB::table('baselines')
            ->join('daily_logs', 'baselines.user_id', '=', 'daily_logs.user_id')
            ->select(DB::raw('
                AVG(daily_logs.mito_age_score - baselines.mito_age_score) as avg_improvement
            '))
            ->first();

        return $improvements ? round($improvements->avg_improvement ?? 0, 1) : 0;
    }

    private function getUserGrowthData()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = User::whereDate('created_at', $date)->count();
            $data[] = [
                'date' => $date,
                'count' => $count
            ];
        }
        return $data;
    }

    private function getLogSubmissionsData()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = DailyLog::whereDate('log_date', $date)->count();
            $data[] = [
                'date' => $date,
                'count' => $count
            ];
        }
        return $data;
    }

    /**
     * Calculate global metrics improvement across all users
     * Average improvement from baseline to latest log for each metric
     */
    private function calculateGlobalMetricsImprovement()
    {
        $metrics = DB::select("
            SELECT
                AVG(latest.energy - b.energy) as energy_avg,
                AVG(latest.focus - b.focus) as focus_avg,
                AVG(latest.sleep - b.sleep) as sleep_avg,
                AVG(latest.gut_health - b.gut_health) as gut_health_avg,
                AVG(latest.mito_age_score - b.mito_age_score) as mito_age_score_avg
            FROM baselines b
            INNER JOIN (
                SELECT
                    user_id,
                    energy,
                    focus,
                    sleep,
                    gut_health,
                    mito_age_score,
                    ROW_NUMBER() OVER (PARTITION BY user_id ORDER BY log_date DESC) as rn
                FROM daily_logs
            ) latest ON b.user_id = latest.user_id AND latest.rn = 1
        ");

        return [
            'energy' => isset($metrics[0]) ? round($metrics[0]->energy_avg ?? 0, 1) : 0,
            'focus' => isset($metrics[0]) ? round($metrics[0]->focus_avg ?? 0, 1) : 0,
            'sleep' => isset($metrics[0]) ? round($metrics[0]->sleep_avg ?? 0, 1) : 0,
            'gut_health' => isset($metrics[0]) ? round($metrics[0]->gut_health_avg ?? 0, 1) : 0,
            'mito_age_score' => isset($metrics[0]) ? round($metrics[0]->mito_age_score_avg ?? 0, 1) : 0,
        ];
    }

    /**
     * Calculate stage completion statistics
     * % of users who reached various day milestones
     */
    private function calculateStageCompletionStats()
    {
        $totalUsers = User::count();
        if ($totalUsers === 0) return [
            'day_30' => 0,
            'day_60' => 0,
            'day_90' => 0,
            'day_180' => 0,
            'day_360' => 0,
        ];

        return [
            'day_30' => round((DailyLog::select('user_id')->distinct()->havingRaw('COUNT(DISTINCT log_date) >= 30')->groupBy('user_id')->count() / $totalUsers) * 100, 1),
            'day_60' => round((DailyLog::select('user_id')->distinct()->havingRaw('COUNT(DISTINCT log_date) >= 60')->groupBy('user_id')->count() / $totalUsers) * 100, 1),
            'day_90' => round((DailyLog::select('user_id')->distinct()->havingRaw('COUNT(DISTINCT log_date) >= 90')->groupBy('user_id')->count() / $totalUsers) * 100, 1),
            'day_180' => round((DailyLog::select('user_id')->distinct()->havingRaw('COUNT(DISTINCT log_date) >= 180')->groupBy('user_id')->count() / $totalUsers) * 100, 1),
            'day_360' => round((DailyLog::select('user_id')->distinct()->havingRaw('COUNT(DISTINCT log_date) >= 360')->groupBy('user_id')->count() / $totalUsers) * 100, 1),
        ];
    }

    /**
     * Calculate consistency analytics
     */
    private function calculateConsistencyStats()
    {
        $totalUsers = User::count();
        if ($totalUsers === 0) return [
            'avg_logs_per_week' => 0,
            'avg_streak' => 0,
            'logged_today_percent' => 0,
            'streak_7plus_percent' => 0,
        ];

        // Average logs per user per week (approximate)
        $avgLogsPerWeek = round(DailyLog::count() / max($totalUsers, 1) / max(UserProgramEnrollment::avg(DB::raw('DATEDIFF(CURRENT_DATE, start_date) / 7')) ?? 1, 1), 1);

        // % users who logged today
        $loggedToday = DailyLog::whereDate('log_date', Carbon::today())->distinct('user_id')->count();
        $loggedTodayPercent = round(($loggedToday / $totalUsers) * 100, 1);

        // Average streak and 7+ day streak % (simplified calculation)
        $streaks = $this->calculateUserStreaks();
        $avgStreak = count($streaks) > 0 ? round(array_sum($streaks) / count($streaks), 1) : 0;
        $streak7Plus = count(array_filter($streaks, fn($s) => $s >= 7));
        $streak7PlusPercent = count($streaks) > 0 ? round(($streak7Plus / count($streaks)) * 100, 1) : 0;

        return [
            'avg_logs_per_week' => $avgLogsPerWeek,
            'avg_streak' => $avgStreak,
            'logged_today_percent' => $loggedTodayPercent,
            'streak_7plus_percent' => $streak7PlusPercent,
        ];
    }

    /**
     * Calculate user streaks (current consecutive days logged)
     */
    private function calculateUserStreaks()
    {
        $users = User::with(['dailyLogs' => function($query) {
            $query->orderBy('log_date', 'desc')->take(90); // Check last 90 days
        }])->get();

        $streaks = [];
        foreach ($users as $user) {
            $streak = 0;
            $expectedDate = Carbon::today();

            foreach ($user->dailyLogs as $log) {
                $logDate = Carbon::parse($log->log_date);
                if ($logDate->isSameDay($expectedDate)) {
                    $streak++;
                    $expectedDate = $expectedDate->subDay();
                } else {
                    break;
                }
            }

            if ($streak > 0) {
                $streaks[] = $streak;
            }
        }

        return $streaks;
    }

    /**
     * Calculate skin assessment analytics
     */
    private function calculateSkinAssessmentStats()
    {
        $totalAssessments = SkinAssessment::count();

        // Average skin score at baseline (assuming milestone_day 0 or earliest assessment)
        $avgBaseline = SkinAssessment::whereIn('id', function($query) {
            $query->select(DB::raw('MIN(id)'))
                  ->from('skin_assessments')
                  ->groupBy('user_id');
        })->avg(DB::raw('(radiance + smoothness + calmness + clarity + hydration + firmness + evenness) / 7'));

        // Average skin score at 30-day checkpoints
        $avg30Day = SkinAssessment::where('milestone_day', 30)->avg(DB::raw('(radiance + smoothness + calmness + clarity + hydration + firmness + evenness) / 7'));
        $avg60Day = SkinAssessment::where('milestone_day', 60)->avg(DB::raw('(radiance + smoothness + calmness + clarity + hydration + firmness + evenness) / 7'));
        $avg90Day = SkinAssessment::where('milestone_day', 90)->avg(DB::raw('(radiance + smoothness + calmness + clarity + hydration + firmness + evenness) / 7'));

        // Overall improvement % - only if we have both baseline and 90-day data
        $improvementPercent = null;
        if ($avgBaseline > 0 && $avg90Day > 0) {
            $improvementPercent = round((($avg90Day - $avgBaseline) / $avgBaseline) * 100, 1);
        }

        return [
            'total_assessments' => $totalAssessments,
            'avg_baseline' => round($avgBaseline ?? 0, 1),
            'avg_30_day' => round($avg30Day ?? 0, 1),
            'avg_60_day' => round($avg60Day ?? 0, 1),
            'avg_90_day' => round($avg90Day ?? 0, 1),
            'improvement_percent' => $improvementPercent,
        ];
    }

    /**
     * Calculate cohort statistics for active users
     */
    private function calculateCohortStats()
    {
        // Get users with at least 2 logs
        $activeUsers = User::whereHas('dailyLogs', function($query) {
            $query->select('user_id', DB::raw('COUNT(*) as log_count'))
                  ->groupBy('user_id')
                  ->havingRaw('COUNT(*) >= 2');
        })->with(['baseline', 'dailyLogs' => function($query) {
            $query->orderBy('log_date', 'desc')->take(7); // Last 7 days for rolling average
        }])->get();

        if ($activeUsers->isEmpty()) {
            return [
                'avg_energy_improvement' => 0,
                'avg_focus_improvement' => 0,
                'avg_sleep_improvement' => 0,
                'avg_gut_improvement' => 0,
                'avg_skin_improvement' => 0,
                'avg_mito_improvement' => 0,
                'adherence_70plus_percent' => 0,
                'avg_program_day' => 0,
                'improvement_20plus_percent' => 0,
            ];
        }

        $improvements = ['energy' => [], 'focus' => [], 'sleep' => [], 'gut_health' => [], 'mito_age_score' => []];
        $adherenceCount = 0;
        $programDays = [];
        $significant_improvement_count = 0;

        foreach ($activeUsers as $user) {
            if (!$user->baseline || $user->dailyLogs->isEmpty()) continue;

            $baseline = $user->baseline;
            $enrollment = $user->programEnrollment;

            if ($enrollment) {
                $programDays[] = $enrollment->getCurrentDay();
                $daysSinceStart = $enrollment->getCurrentDay();
                $logsCount = $user->dailyLogs->count();
                $adherencePercent = ($logsCount / max($daysSinceStart, 1)) * 100;

                if ($adherencePercent >= 70) {
                    $adherenceCount++;
                }
            }

            // Calculate 7-day rolling average
            $latest7Avg = [
                'energy' => $user->dailyLogs->avg('energy'),
                'focus' => $user->dailyLogs->avg('focus'),
                'sleep' => $user->dailyLogs->avg('sleep'),
                'gut_health' => $user->dailyLogs->avg('gut_health'),
                'mito_age_score' => $user->dailyLogs->avg('mito_age_score'),
            ];

            $metricsImproved = 0;
            foreach ($improvements as $key => $values) {
                if (isset($baseline->{$key}) && $baseline->{$key} > 0) {
                    $percentChange = (($latest7Avg[$key] - $baseline->{$key}) / $baseline->{$key}) * 100;
                    $improvements[$key][] = $percentChange;

                    if ($percentChange >= 20) {
                        $metricsImproved++;
                    }
                }
            }

            if ($metricsImproved >= 3) {
                $significant_improvement_count++;
            }
        }

        $totalActive = $activeUsers->count();

        return [
            'avg_energy_improvement' => count($improvements['energy']) > 0 ? round(array_sum($improvements['energy']) / count($improvements['energy']), 1) : 0,
            'avg_focus_improvement' => count($improvements['focus']) > 0 ? round(array_sum($improvements['focus']) / count($improvements['focus']), 1) : 0,
            'avg_sleep_improvement' => count($improvements['sleep']) > 0 ? round(array_sum($improvements['sleep']) / count($improvements['sleep']), 1) : 0,
            'avg_gut_improvement' => count($improvements['gut_health']) > 0 ? round(array_sum($improvements['gut_health']) / count($improvements['gut_health']), 1) : 0,
            'avg_mito_improvement' => count($improvements['mito_age_score']) > 0 ? round(array_sum($improvements['mito_age_score']) / count($improvements['mito_age_score']), 1) : 0,
            'adherence_70plus_percent' => $totalActive > 0 ? round(($adherenceCount / $totalActive) * 100, 1) : 0,
            'avg_program_day' => count($programDays) > 0 ? round(array_sum($programDays) / count($programDays), 1) : 0,
            'improvement_20plus_percent' => $totalActive > 0 ? round(($significant_improvement_count / $totalActive) * 100, 1) : 0,
        ];
    }
}
