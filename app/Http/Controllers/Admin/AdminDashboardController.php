<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailyLog;
use App\Models\Milestone;
use App\Models\UserProgramEnrollment;
use App\Models\Baseline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total Users
        $totalUsers = User::count();

        // Active Programs (users with active enrollments)
        $activePrograms = UserProgramEnrollment::where('is_active', true)->count();

        // Completed Programs (users past day 90)
        $completedPrograms = UserProgramEnrollment::whereRaw('DATEDIFF(CURRENT_DATE, start_date) > 90')->count();

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
            'logSubmissions'
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
}
