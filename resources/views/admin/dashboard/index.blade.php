@extends('admin.layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of all metrics and activity')

@section('content')
<div class="space-y-8">
    <!-- Key Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-6 border border-silver-900/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-silver-500 text-sm">Total Users</p>
                    <p class="text-3xl font-bold text-silver-100 mt-2">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="p-4 bg-blue-600/20 rounded-xl">
                    <x-phosphor-users class="w-8 h-8 text-blue-400" />
                </div>
            </div>
        </div>

        <!-- Active Programs -->
        <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-6 border border-silver-900/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-silver-500 text-sm">Active Programs</p>
                    <p class="text-3xl font-bold text-silver-100 mt-2">{{ number_format($activePrograms) }}</p>
                </div>
                <div class="p-4 bg-green-600/20 rounded-xl">
                    <x-phosphor-calendar class="w-8 h-8 text-green-400" />
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-6 border border-silver-900/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-silver-500 text-sm">Completion Rate</p>
                    <p class="text-3xl font-bold text-silver-100 mt-2">{{ $completionRate }}%</p>
                </div>
                <div class="p-4 bg-purple-600/20 rounded-xl">
                    <x-phosphor-trophy class="w-8 h-8 text-purple-400" />
                </div>
            </div>
        </div>

        <!-- Avg Improvement -->
        <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-6 border border-silver-900/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-silver-500 text-sm">Avg Mito-Age Score +</p>
                    <p class="text-3xl font-bold text-green-400 mt-2">+{{ $avgImprovement }}</p>
                </div>
                <div class="p-4 bg-green-600/20 rounded-xl">
                    <x-phosphor-trend-up class="w-8 h-8 text-green-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Today's Logs</p>
            <p class="text-2xl font-bold text-silver-100 mt-2">{{ number_format($todayLogs) }}</p>
        </div>

        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Total Baselines</p>
            <p class="text-2xl font-bold text-silver-100 mt-2">{{ number_format($totalBaselines) }}</p>
        </div>

        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Avg Logs per User</p>
            <p class="text-2xl font-bold text-silver-100 mt-2">{{ $avgLogsPerUser }}</p>
        </div>
    </div>

    <!-- GLOBAL METRICS OVERVIEW PANEL -->
    <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-8 border border-silver-900/30">
        <h3 class="text-2xl font-bold text-silver-100 mb-6 flex items-center">
            <x-phosphor-chart-line-up class="w-7 h-7 text-green-400 mr-3" />
            Global Metrics Overview - Average Improvement
        </h3>
        <p class="text-silver-400 text-sm mb-6">Average improvement from baseline to latest log across all users</p>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="bg-[#0f0f0f] rounded-xl p-4 border border-green-900/30">
                <p class="text-silver-500 text-xs mb-1">Energy</p>
                <p class="text-2xl font-bold {{ $globalMetrics['energy'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $globalMetrics['energy'] >= 0 ? '+' : '' }}{{ $globalMetrics['energy'] }}
                </p>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl p-4 border border-blue-900/30">
                <p class="text-silver-500 text-xs mb-1">Focus</p>
                <p class="text-2xl font-bold {{ $globalMetrics['focus'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $globalMetrics['focus'] >= 0 ? '+' : '' }}{{ $globalMetrics['focus'] }}
                </p>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl p-4 border border-purple-900/30">
                <p class="text-silver-500 text-xs mb-1">Sleep</p>
                <p class="text-2xl font-bold {{ $globalMetrics['sleep'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $globalMetrics['sleep'] >= 0 ? '+' : '' }}{{ $globalMetrics['sleep'] }}
                </p>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl p-4 border border-orange-900/30">
                <p class="text-silver-500 text-xs mb-1">Gut Health</p>
                <p class="text-2xl font-bold {{ $globalMetrics['gut_health'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $globalMetrics['gut_health'] >= 0 ? '+' : '' }}{{ $globalMetrics['gut_health'] }}
                </p>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl p-4 border border-green-900/30">
                <p class="text-silver-500 text-xs mb-1">Mito-Age Score</p>
                <p class="text-2xl font-bold {{ $globalMetrics['mito_age_score'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $globalMetrics['mito_age_score'] >= 0 ? '+' : '' }}{{ $globalMetrics['mito_age_score'] }}
                </p>
            </div>
        </div>
    </div>

    <!-- STAGE COMPLETION STATISTICS -->
    <div class="bg-[#1a1a2e] rounded-2xl p-8 border border-silver-900/30">
        <h3 class="text-2xl font-bold text-silver-100 mb-6 flex items-center">
            <x-phosphor-trophy class="w-7 h-7 text-yellow-400 mr-3" />
            Stage Completion Statistics
        </h3>
        <p class="text-silver-400 text-sm mb-6">Percentage of users who reached each milestone (based on total logged days)</p>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-[#16213e] rounded-xl p-5 border border-green-900/30 text-center">
                <p class="text-silver-400 text-sm mb-2">Day 30</p>
                <p class="text-3xl font-bold text-green-400">{{ $stageCompletionStats['day_30'] }}%</p>
            </div>

            <div class="bg-[#16213e] rounded-xl p-5 border border-blue-900/30 text-center">
                <p class="text-silver-400 text-sm mb-2">Day 60</p>
                <p class="text-3xl font-bold text-blue-400">{{ $stageCompletionStats['day_60'] }}%</p>
            </div>

            <div class="bg-[#16213e] rounded-xl p-5 border border-purple-900/30 text-center">
                <p class="text-silver-400 text-sm mb-2">Day 90</p>
                <p class="text-3xl font-bold text-purple-400">{{ $stageCompletionStats['day_90'] }}%</p>
            </div>

            <div class="bg-[#16213e] rounded-xl p-5 border border-orange-900/30 text-center">
                <p class="text-silver-400 text-sm mb-2">Day 180</p>
                <p class="text-3xl font-bold text-orange-400">{{ $stageCompletionStats['day_180'] }}%</p>
            </div>

            <div class="bg-[#16213e] rounded-xl p-5 border border-yellow-900/30 text-center">
                <p class="text-silver-400 text-sm mb-2">Day 360</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $stageCompletionStats['day_360'] }}%</p>
            </div>
        </div>
    </div>

    <!-- CONSISTENCY & COHORT ANALYTICS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Consistency Analytics -->
        <div class="bg-[#1a1a2e] rounded-2xl p-8 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-6 flex items-center">
                <x-phosphor-fire class="w-6 h-6 text-orange-400 mr-3" />
                Consistency Analytics
            </h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300">Avg Logs per Week</span>
                    <span class="text-2xl font-bold text-silver-100">{{ $consistencyStats['avg_logs_per_week'] }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300">Average Streak</span>
                    <span class="text-2xl font-bold text-orange-400">{{ $consistencyStats['avg_streak'] }} days</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300">Logged Today</span>
                    <span class="text-2xl font-bold text-green-400">{{ $consistencyStats['logged_today_percent'] }}%</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300">7+ Day Streaks</span>
                    <span class="text-2xl font-bold text-blue-400">{{ $consistencyStats['streak_7plus_percent'] }}%</span>
                </div>
            </div>
        </div>

        <!-- Cohort Statistics -->
        <div class="bg-[#1a1a2e] rounded-2xl p-8 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-6 flex items-center">
                <x-phosphor-users-three class="w-6 h-6 text-purple-400 mr-3" />
                Active User Cohort Stats
            </h3>
            <p class="text-silver-500 text-xs mb-4">Users with 2+ logs, 7-day rolling average</p>

            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300 text-sm">Avg Program Day</span>
                    <span class="text-lg font-bold text-silver-100">{{ $cohortStats['avg_program_day'] }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300 text-sm">≥70% Adherence</span>
                    <span class="text-lg font-bold text-green-400">{{ $cohortStats['adherence_70plus_percent'] }}%</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-[#16213e] rounded-lg">
                    <span class="text-silver-300 text-sm">+20% in 3+ Metrics</span>
                    <span class="text-lg font-bold text-purple-400">{{ $cohortStats['improvement_20plus_percent'] }}%</span>
                </div>

                <div class="grid grid-cols-3 gap-2 mt-4">
                    <div class="bg-[#0f0f0f] rounded p-2 text-center">
                        <p class="text-xs text-silver-500">Energy</p>
                        <p class="text-sm font-bold {{ $cohortStats['avg_energy_improvement'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $cohortStats['avg_energy_improvement'] >= 0 ? '+' : '' }}{{ $cohortStats['avg_energy_improvement'] }}%
                        </p>
                    </div>
                    <div class="bg-[#0f0f0f] rounded p-2 text-center">
                        <p class="text-xs text-silver-500">Focus</p>
                        <p class="text-sm font-bold {{ $cohortStats['avg_focus_improvement'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $cohortStats['avg_focus_improvement'] >= 0 ? '+' : '' }}{{ $cohortStats['avg_focus_improvement'] }}%
                        </p>
                    </div>
                    <div class="bg-[#0f0f0f] rounded p-2 text-center">
                        <p class="text-xs text-silver-500">Sleep</p>
                        <p class="text-sm font-bold {{ $cohortStats['avg_sleep_improvement'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $cohortStats['avg_sleep_improvement'] >= 0 ? '+' : '' }}{{ $cohortStats['avg_sleep_improvement'] }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SKIN ASSESSMENT ANALYTICS -->
    <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-8 border border-silver-900/30">
        <h3 class="text-2xl font-bold text-silver-100 mb-6 flex items-center">
            <x-phosphor-sparkle class="w-7 h-7 text-pink-400 mr-3" />
            Skin Glow Assessment Analytics
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-[#0f0f0f] rounded-xl p-6 border border-pink-900/30">
                <p class="text-silver-500 text-sm mb-2">Total Assessments</p>
                <p class="text-3xl font-bold text-silver-100">{{ $skinAssessmentStats['total_assessments'] }}</p>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl p-6 border border-blue-900/30">
                <p class="text-silver-500 text-sm mb-2">Avg Baseline Score</p>
                <p class="text-3xl font-bold text-silver-100">{{ $skinAssessmentStats['avg_baseline'] }}</p>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl p-6 border border-green-900/30">
                <p class="text-silver-500 text-sm mb-2">Overall Improvement</p>
                @if($skinAssessmentStats['improvement_percent'] !== null)
                    <p class="text-3xl font-bold {{ $skinAssessmentStats['improvement_percent'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $skinAssessmentStats['improvement_percent'] >= 0 ? '+' : '' }}{{ $skinAssessmentStats['improvement_percent'] }}%
                    </p>
                @else
                    <p class="text-3xl font-bold text-silver-500">N/A</p>
                    <p class="text-xs text-silver-600 mt-1">Waiting for Day 90 data</p>
                @endif
            </div>
        </div>

        <div class="bg-[#16213e] rounded-xl p-6">
            <h4 class="text-lg font-semibold text-silver-200 mb-4">Skin Score Progression</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-sm text-silver-400 mb-2">Baseline</p>
                    <p class="text-2xl font-bold text-silver-100">{{ $skinAssessmentStats['avg_baseline'] }}</p>
                </div>

                <div class="text-center">
                    <p class="text-sm text-silver-400 mb-2">Day 30</p>
                    <p class="text-2xl font-bold text-blue-400">{{ $skinAssessmentStats['avg_30_day'] }}</p>
                </div>

                <div class="text-center">
                    <p class="text-sm text-silver-400 mb-2">Day 60</p>
                    <p class="text-2xl font-bold text-purple-400">{{ $skinAssessmentStats['avg_60_day'] }}</p>
                </div>

                <div class="text-center">
                    <p class="text-sm text-silver-400 mb-2">Day 90</p>
                    <p class="text-2xl font-bold text-green-400">{{ $skinAssessmentStats['avg_90_day'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Registrations -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-4">Recent Registrations</h3>
            <div class="space-y-3">
                @forelse($recentRegistrations as $user)
                    <div class="flex items-center justify-between p-3 bg-[#16213e] rounded-xl">
                        <div>
                            <p class="font-medium text-silver-100">{{ $user->name }}</p>
                            <p class="text-sm text-silver-500">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-silver-500">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-silver-500 text-sm">No recent registrations</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Milestones -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-4">Recent Milestone Unlocks</h3>
            <div class="space-y-3">
                @forelse($recentMilestones as $milestone)
                    <div class="flex items-center justify-between p-3 bg-[#16213e] rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-yellow-600/20 rounded-lg">
                                <x-phosphor-trophy class="w-5 h-5 text-yellow-400" />
                            </div>
                            <div>
                                <p class="font-medium text-silver-100">{{ $milestone->user->name }}</p>
                                <p class="text-sm text-silver-500">Day {{ $milestone->milestone_day }} Milestone</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-silver-500">{{ $milestone->unlocked_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-silver-500 text-sm">No recent milestone unlocks</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Daily Logs -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Recent Daily Logs</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">User</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Date</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Energy</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Focus</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Sleep</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Mito-Age Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLogs as $log)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-100">{{ $log->user->name }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ \Carbon\Carbon::parse($log->log_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->energy }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->focus }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->sleep }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-sm font-medium">
                                    {{ number_format($log->mito_age_score, 1) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-silver-500">No recent logs</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
