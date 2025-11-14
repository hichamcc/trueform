<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProgramEnrollment;
use App\Models\DailyLog;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    /**
     * Display the main dashboard with 360-day program overview
     * Shows current stage, progress, recent activity, and milestones
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Auto-enroll user in 360-day transformation program if not already enrolled
        $enrollment = UserProgramEnrollment::firstOrCreate(
            ['user_id' => $user->id],
            [
                'start_date' => Carbon::today(),
                'current_stage' => 1, // Start at Stage 1: Foundation
                'current_streak' => 0,
                'longest_streak' => 0,
                'is_active' => true,
                'baseline_completed' => false
            ]
        );

        // Calculate current progress in 360-day journey
        $currentDay = $enrollment->getCurrentDay();
        $daysRemaining = $enrollment->getDaysRemaining();

        // Get current stage information (1=Foundation, 2=Expansion, 3=Mastery)
        $currentStage = $enrollment->getCurrentStage();
        $stageName = $enrollment->getStageName();
        $stageTheme = $enrollment->getStageTheme();

        // Get user's baseline metrics
        $baseline = $user->baseline;

        // Get today's log if exists
        $todayLog = $user->dailyLogs()
            ->whereDate('log_date', Carbon::today())
            ->first();

        // Get recent 7 days of activity
        $recentLogs = $user->dailyLogs()
            ->orderBy('log_date', 'desc')
            ->limit(7)
            ->get();

        // Get all 8 milestones (30, 60, 90, 120, 150, 180, 270, 360)
        $milestones = $user->milestones()
            ->orderBy('milestone_day')
            ->get();

        // Calculate current Mito-Age Score (average of 5 metrics)
        $currentMitoAge = $todayLog
            ? $todayLog->mito_age_score
            : ($baseline ? $baseline->mito_age_score : null);

        // Calculate Transformation Glow Percentage (0-100%)
        $transformationPercentage = 0;
        if ($baseline && $recentLogs->count() > 0) {
            // Get average of recent logs (last 7 days)
            $avgEnergy = $recentLogs->avg('energy');
            $avgFocus = $recentLogs->avg('focus');
            $avgSleep = $recentLogs->avg('sleep');
            $avgGutHealth = $recentLogs->avg('gut_health');
            $avgSkinGlow = $recentLogs->avg('skin_glow');

            // Calculate overall improvement percentage from baseline
            $energyImprovement = $baseline->energy > 0 ? (($avgEnergy - $baseline->energy) / $baseline->energy) * 100 : 0;
            $focusImprovement = $baseline->focus > 0 ? (($avgFocus - $baseline->focus) / $baseline->focus) * 100 : 0;
            $sleepImprovement = $baseline->sleep > 0 ? (($avgSleep - $baseline->sleep) / $baseline->sleep) * 100 : 0;
            $gutImprovement = $baseline->gut_health > 0 ? (($avgGutHealth - $baseline->gut_health) / $baseline->gut_health) * 100 : 0;
            $glowImprovement = $baseline->skin_glow > 0 ? (($avgSkinGlow - $baseline->skin_glow) / $baseline->skin_glow) * 100 : 0;

            // Average improvement across all metrics
            $avgImprovement = ($energyImprovement + $focusImprovement + $sleepImprovement + $gutImprovement + $glowImprovement) / 5;

            // Convert to 0-100 scale (assuming max realistic improvement is 50%)
            // Normalize: -50% to +50% improvement maps to 0-100%
            $transformationPercentage = max(0, min(100, (($avgImprovement + 50) / 100) * 100));
        }

        return view('dashboard.welcome', compact(
            'enrollment',
            'currentDay',
            'daysRemaining',
            'currentStage',
            'stageName',
            'stageTheme',
            'baseline',
            'todayLog',
            'recentLogs',
            'milestones',
            'currentMitoAge',
            'transformationPercentage'
        ));
    }
}
