<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class TransformationProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $enrollment = $user->programEnrollment;
        $baseline = $user->baseline;

        // Get current stage information
        $currentStage = $enrollment ? $enrollment->getCurrentStage() : 1;
        $stageName = $enrollment ? $enrollment->getStageName() : 'Foundation';
        $stageTheme = $enrollment ? $enrollment->getStageTheme() : [];
        $currentDay = $enrollment ? $enrollment->getCurrentDay() : 1;
        $daysRemaining = $enrollment ? $enrollment->getDaysRemaining() : 359;

        // Calculate overall stats
        $totalLogs = $user->dailyLogs()->count();
        $recentLogs = $user->dailyLogs()
            ->orderBy('log_date', 'desc')
            ->limit(30)
            ->get();

        // Calculate current averages (last 7 days)
        $currentAverages = null;
        $overallImprovement = 0;
        $dynamicTagline = "Start your transformation journey";
        $weakestMetric = null;
        $strongestMetric = null;

        if ($totalLogs > 0 && $baseline) {
            $last7Days = $user->dailyLogs()
                ->orderBy('log_date', 'desc')
                ->limit(7)
                ->get();

            if ($last7Days->count() > 0) {
                $currentAverages = [
                    'energy' => round($last7Days->avg('energy'), 1),
                    'focus' => round($last7Days->avg('focus'), 1),
                    'sleep' => round($last7Days->avg('sleep'), 1),
                    'gut_health' => round($last7Days->avg('gut_health'), 1),
                    'mito_age_score' => round($last7Days->avg('mito_age_score'), 1),
                ];

                // Calculate improvements
                $improvements = [
                    'energy' => (($currentAverages['energy'] - $baseline->energy) / $baseline->energy) * 100,
                    'focus' => (($currentAverages['focus'] - $baseline->focus) / $baseline->focus) * 100,
                    'sleep' => (($currentAverages['sleep'] - $baseline->sleep) / $baseline->sleep) * 100,
                    'gut_health' => (($currentAverages['gut_health'] - $baseline->gut_health) / $baseline->gut_health) * 100,
                ];

                // Overall improvement
                $overallImprovement = round(array_sum($improvements) / count($improvements), 0);

                // Generate dynamic tagline
                if ($overallImprovement > 0) {
                    $dynamicTagline = abs($overallImprovement) . "% Improved Since Start";
                } elseif ($overallImprovement < 0) {
                    $dynamicTagline = "Keep pushing forward";
                } else {
                    $dynamicTagline = "Maintaining your baseline";
                }

                // Find weakest and strongest metrics
                arsort($improvements);
                $strongestMetric = array_key_first($improvements);
                asort($improvements);
                $weakestMetric = array_key_first($improvements);
            }
        }

        // Get milestones
        $milestones = $user->milestones()
            ->whereNotNull('unlocked_at')
            ->orderBy('milestone_day')
            ->get();

        // Calculate streak
        $currentStreak = $enrollment ? $enrollment->current_streak : 0;
        $longestStreak = $enrollment ? $enrollment->longest_streak : 0;

        // Tier badge info
        $tierBadge = $this->getTierBadge($currentDay);

        // Get recommendations for weakest metric
        $recommendations = [];
        if ($weakestMetric) {
            $recommendations = Recommendation::getForKpi($weakestMetric);
        }

        return view('dashboard.transformation-profile', compact(
            'user',
            'enrollment',
            'baseline',
            'currentStage',
            'stageName',
            'stageTheme',
            'currentDay',
            'daysRemaining',
            'totalLogs',
            'currentAverages',
            'overallImprovement',
            'dynamicTagline',
            'weakestMetric',
            'strongestMetric',
            'milestones',
            'currentStreak',
            'longestStreak',
            'tierBadge',
            'recentLogs',
            'recommendations'
        ));
    }

    private function getTierBadge($currentDay)
    {
        if ($currentDay >= 360) {
            return [
                'name' => 'Elite 360 Master',
                'level' => 360,
                'color' => 'gold',
                'gradient' => 'from-yellow-400 to-amber-500',
                'icon' => '👑'
            ];
        } elseif ($currentDay >= 180) {
            return [
                'name' => 'Elite 180 Advanced',
                'level' => 180,
                'color' => 'gold',
                'gradient' => 'from-yellow-500 to-yellow-600',
                'icon' => '⭐'
            ];
        } elseif ($currentDay >= 90) {
            return [
                'name' => 'Elite 90 Graduate',
                'level' => 90,
                'color' => 'blue',
                'gradient' => 'from-blue-400 to-blue-600',
                'icon' => '🔷'
            ];
        } else {
            return [
                'name' => 'Elite Foundation',
                'level' => $currentDay,
                'color' => 'green',
                'gradient' => 'from-green-400 to-emerald-500',
                'icon' => '🌱'
            ];
        }
    }
}
