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
