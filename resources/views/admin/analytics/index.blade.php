@extends('admin.layouts.admin')

@section('page-title', 'Analytics & Reports')
@section('page-subtitle', 'Deep insights and data analysis')

@section('content')
<div class="space-y-6">
    <!-- Metrics Improvement -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Average Metrics Improvement</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div>
                <p class="text-silver-500 text-sm">Energy</p>
                <p class="text-2xl font-bold text-green-400 mt-1">+{{ number_format($metricsImprovement->energy_improvement ?? 0, 1) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Focus</p>
                <p class="text-2xl font-bold text-green-400 mt-1">+{{ number_format($metricsImprovement->focus_improvement ?? 0, 1) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Sleep</p>
                <p class="text-2xl font-bold text-green-400 mt-1">+{{ number_format($metricsImprovement->sleep_improvement ?? 0, 1) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Gut Health</p>
                <p class="text-2xl font-bold text-green-400 mt-1">+{{ number_format($metricsImprovement->gut_health_improvement ?? 0, 1) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Skin Glow</p>
                <p class="text-2xl font-bold text-green-400 mt-1">+{{ number_format($metricsImprovement->skin_glow_improvement ?? 0, 1) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Overall</p>
                <p class="text-2xl font-bold text-green-400 mt-1">+{{ number_format($metricsImprovement->overall_improvement ?? 0, 1) }}</p>
            </div>
        </div>
    </div>

    <!-- Completion Rates -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Milestone Completion Rates</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-silver-500 text-sm">Day 30 Milestone</p>
                <p class="text-3xl font-bold text-silver-100 mt-1">{{ number_format($completionRates['day_30']) }}</p>
                <p class="text-xs text-silver-500 mt-1">users reached</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Day 60 Milestone</p>
                <p class="text-3xl font-bold text-silver-100 mt-1">{{ number_format($completionRates['day_60']) }}</p>
                <p class="text-xs text-silver-500 mt-1">users reached</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Day 90 Milestone</p>
                <p class="text-3xl font-bold text-silver-100 mt-1">{{ number_format($completionRates['day_90']) }}</p>
                <p class="text-xs text-silver-500 mt-1">users completed</p>
            </div>
        </div>
    </div>

    <!-- Engagement Stats -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Engagement Statistics</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-silver-500 text-sm">Total Logs</p>
                <p class="text-2xl font-bold text-silver-100 mt-1">{{ number_format($engagementStats['total_logs']) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Avg Logs/User</p>
                <p class="text-2xl font-bold text-silver-100 mt-1">{{ $engagementStats['avg_logs_per_user'] }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Logs This Week</p>
                <p class="text-2xl font-bold text-green-400 mt-1">{{ number_format($engagementStats['logs_this_week']) }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">Active Users (Week)</p>
                <p class="text-2xl font-bold text-blue-400 mt-1">{{ number_format($engagementStats['active_users_week']) }}</p>
            </div>
        </div>
    </div>

    <!-- Export Button -->
    <div class="flex justify-end">
        <a href="{{ route('admin.analytics.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
            Export Analytics Report
        </a>
    </div>
</div>
@endsection
