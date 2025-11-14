@extends('admin.layouts.admin')

@section('page-title', 'User Details')
@section('page-subtitle', $user->name)

@section('content')
<div class="space-y-6">
    <!-- User Info & Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="lg:col-span-2 bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-4">User Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-silver-500 text-sm">Name</p>
                    <p class="text-silver-100 font-medium mt-1">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Email</p>
                    <p class="text-silver-100 font-medium mt-1">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">User ID</p>
                    <p class="text-silver-100 font-medium mt-1">#{{ $user->id }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Registered</p>
                    <p class="text-silver-100 font-medium mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Admin Status</p>
                    <p class="mt-1">
                        @if($user->is_admin)
                            <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-lg text-xs font-medium">ADMIN</span>
                        @else
                            <span class="px-3 py-1 bg-silver-900/30 text-silver-400 rounded-lg text-xs font-medium">USER</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                        {{ $user->is_admin ? 'Demote from Admin' : 'Promote to Admin' }}
                    </button>
                </form>

                @if($user->programEnrollment)
                    <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                            {{ $user->programEnrollment->is_active ? 'Deactivate Program' : 'Activate Program' }}
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.users.export', $user) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-medium transition-colors text-center">
                    Export User Data
                </a>

                <a href="{{ route('admin.users.index') }}" class="block w-full bg-silver-900/30 hover:bg-silver-900/50 text-silver-300 px-4 py-2 rounded-xl font-medium transition-colors text-center">
                    Back to Users
                </a>
            </div>
        </div>
    </div>

    <!-- Program Enrollment -->
    @if($user->programEnrollment)
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-4">Program Enrollment</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-silver-500 text-sm">Start Date</p>
                    <p class="text-silver-100 font-medium mt-1">{{ \Carbon\Carbon::parse($user->programEnrollment->start_date)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Current Day</p>
                    <p class="text-silver-100 font-medium mt-1">Day {{ $user->programEnrollment->getCurrentDay() }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Days Remaining</p>
                    <p class="text-silver-100 font-medium mt-1">{{ $user->programEnrollment->getDaysRemaining() }} days</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Status</p>
                    <p class="mt-1">
                        @if($user->programEnrollment->is_active)
                            <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-xs font-medium">Active</span>
                        @else
                            <span class="px-3 py-1 bg-red-600/20 text-red-400 rounded-lg text-xs font-medium">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Baseline Metrics -->
    @if($user->baseline)
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-xl font-bold text-silver-100 mb-4">Baseline Metrics</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div>
                    <p class="text-silver-500 text-sm">Energy</p>
                    <p class="text-2xl font-bold text-silver-100 mt-1">{{ $user->baseline->energy }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Focus</p>
                    <p class="text-2xl font-bold text-silver-100 mt-1">{{ $user->baseline->focus }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Sleep</p>
                    <p class="text-2xl font-bold text-silver-100 mt-1">{{ $user->baseline->sleep }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Gut Health</p>
                    <p class="text-2xl font-bold text-silver-100 mt-1">{{ $user->baseline->gut_health }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Skin Glow</p>
                    <p class="text-2xl font-bold text-silver-100 mt-1">{{ $user->baseline->skin_glow }}</p>
                </div>
                <div>
                    <p class="text-silver-500 text-sm">Mito-Age Score</p>
                    <p class="text-2xl font-bold text-green-400 mt-1">{{ number_format($user->baseline->mito_age_score, 1) }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Daily Logs -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Daily Logs History ({{ $user->dailyLogs->count() }} total)</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Date</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Energy</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Focus</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Sleep</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Gut Health</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Skin Glow</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Mito-Age Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->dailyLogs->take(10) as $log)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-300">{{ \Carbon\Carbon::parse($log->log_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->energy }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->focus }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->sleep }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->gut_health }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->skin_glow }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-sm font-medium">
                                    {{ number_format($log->mito_age_score, 1) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-silver-500">No daily logs yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Milestones -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Milestones</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([30, 60, 90] as $day)
                @php
                    $milestone = $user->milestones->firstWhere('milestone_day', $day);
                @endphp
                <div class="p-4 bg-[#16213e] rounded-xl border {{ $milestone && $milestone->unlocked_at ? 'border-yellow-600/50' : 'border-silver-900/30' }}">
                    <div class="flex items-center gap-3">
                        <div class="p-3 {{ $milestone && $milestone->unlocked_at ? 'bg-yellow-600/20' : 'bg-silver-900/30' }} rounded-xl">
                            <x-phosphor-trophy class="w-6 h-6 {{ $milestone && $milestone->unlocked_at ? 'text-yellow-400' : 'text-silver-600' }}" />
                        </div>
                        <div>
                            <p class="font-bold text-silver-100">Day {{ $day }}</p>
                            @if($milestone && $milestone->unlocked_at)
                                <p class="text-xs text-green-400">Unlocked {{ $milestone->unlocked_at->diffForHumans() }}</p>
                            @else
                                <p class="text-xs text-silver-500">Not unlocked</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
