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

    <!-- IMPROVEMENT SUMMARY & ADHERENCE STATS -->
    @if($user->baseline && !$user->dailyLogs->isEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Improvement Summary (7-Day Rolling Average vs Baseline) -->
            <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-6 border border-silver-900/30">
                <h3 class="text-xl font-bold text-silver-100 mb-2">Improvement Summary</h3>
                <p class="text-silver-500 text-xs mb-4">7-day rolling average vs baseline</p>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-[#0f0f0f] rounded-lg">
                        <span class="text-silver-300 text-sm">Energy</span>
                        <span class="text-lg font-bold {{ $improvementSummary['energy'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $improvementSummary['energy'] >= 0 ? '+' : '' }}{{ $improvementSummary['energy'] }}%
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-[#0f0f0f] rounded-lg">
                        <span class="text-silver-300 text-sm">Focus</span>
                        <span class="text-lg font-bold {{ $improvementSummary['focus'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $improvementSummary['focus'] >= 0 ? '+' : '' }}{{ $improvementSummary['focus'] }}%
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-[#0f0f0f] rounded-lg">
                        <span class="text-silver-300 text-sm">Sleep</span>
                        <span class="text-lg font-bold {{ $improvementSummary['sleep'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $improvementSummary['sleep'] >= 0 ? '+' : '' }}{{ $improvementSummary['sleep'] }}%
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-[#0f0f0f] rounded-lg">
                        <span class="text-silver-300 text-sm">Gut Health</span>
                        <span class="text-lg font-bold {{ $improvementSummary['gut_health'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $improvementSummary['gut_health'] >= 0 ? '+' : '' }}{{ $improvementSummary['gut_health'] }}%
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-[#0f0f0f] rounded-lg border border-green-900/30">
                        <span class="text-silver-300 font-semibold">Mito-Age Score</span>
                        <span class="text-xl font-bold {{ $improvementSummary['mito_age_score'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $improvementSummary['mito_age_score'] >= 0 ? '+' : '' }}{{ $improvementSummary['mito_age_score'] }}%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Adherence Stats -->
            <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
                <h3 class="text-xl font-bold text-silver-100 mb-2">Adherence Statistics</h3>
                <p class="text-silver-500 text-xs mb-4">Tracking consistency and engagement</p>

                <div class="space-y-4">
                    <div class="p-4 bg-[#16213e] rounded-xl">
                        <p class="text-silver-400 text-sm mb-2">Days Logged</p>
                        <p class="text-3xl font-bold text-silver-100">{{ $adherenceStats['days_logged'] }}</p>
                        <p class="text-xs text-silver-500 mt-1">out of {{ $adherenceStats['days_since_start'] }} days since start</p>
                    </div>

                    <div class="p-4 bg-[#16213e] rounded-xl">
                        <p class="text-silver-400 text-sm mb-2">Adherence Rate</p>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold {{ $adherenceStats['adherence_percent'] >= 70 ? 'text-green-400' : ($adherenceStats['adherence_percent'] >= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                                {{ $adherenceStats['adherence_percent'] }}%
                            </p>
                            @if($adherenceStats['adherence_percent'] >= 70)
                                <span class="text-green-400 text-sm mb-1">Excellent</span>
                            @elseif($adherenceStats['adherence_percent'] >= 50)
                                <span class="text-yellow-400 text-sm mb-1">Good</span>
                            @else
                                <span class="text-red-400 text-sm mb-1">Needs Work</span>
                            @endif
                        </div>
                        <!-- Progress bar -->
                        <div class="w-full bg-gray-800 rounded-full h-2 mt-3">
                            <div class="h-full rounded-full transition-all {{ $adherenceStats['adherence_percent'] >= 70 ? 'bg-green-500' : ($adherenceStats['adherence_percent'] >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                 style="width: {{ min($adherenceStats['adherence_percent'], 100) }}%"></div>
                        </div>
                    </div>

                    <div class="p-4 bg-[#16213e] rounded-xl">
                        <p class="text-silver-400 text-sm mb-2">Current Streak</p>
                        <div class="flex items-center gap-2">
                            <x-phosphor-fire class="w-6 h-6 {{ $currentStreak >= 7 ? 'text-orange-400' : 'text-silver-600' }}" />
                            <p class="text-3xl font-bold {{ $currentStreak >= 7 ? 'text-orange-400' : 'text-silver-100' }}">
                                {{ $currentStreak }}
                            </p>
                            <span class="text-silver-400">{{ $currentStreak == 1 ? 'day' : 'days' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Before/After Photos -->
    @if($user->baseline)
        <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-8 border border-silver-900/30">
            <h3 class="text-2xl font-bold text-silver-100 mb-6 flex items-center">
                <x-phosphor-camera class="w-7 h-7 text-purple-400 mr-3" />
                Transformation Photos
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <!-- Before Photo -->
                <div class="space-y-3">
                    <p class="text-silver-400 font-medium text-sm">Before (Baseline)</p>
                    @if($user->baseline->photo || $user->baseline->image)
                        @php
                            $baselinePhoto = $user->baseline->photo ?? $user->baseline->image;
                        @endphp
                        <div class="relative rounded-xl overflow-hidden border-2 border-blue-500/50 aspect-[3/4] bg-[#0a0a0a] w-full max-w-[300px] mx-auto shadow-lg">
                            <img src="{{ Storage::url($baselinePhoto) }}"
                                 alt="Before Photo"
                                 class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3 bg-blue-600/90 backdrop-blur-sm px-3 py-1 rounded-lg">
                                <p class="text-xs font-semibold text-white">Baseline</p>
                            </div>
                        </div>
                        <p class="text-xs text-silver-500 text-center">Uploaded: {{ \Carbon\Carbon::parse($user->baseline->created_at)->format('M d, Y') }}</p>
                    @else
                        <div class="relative rounded-xl border-2 border-dashed border-silver-900/50 aspect-[3/4] bg-[#0a0a0a] flex items-center justify-center w-full max-w-[300px] mx-auto">
                            <div class="text-center">
                                <x-phosphor-camera class="w-12 h-12 text-silver-700 mx-auto mb-3" />
                                <p class="text-silver-600 text-sm">No baseline photo uploaded</p>
                                <p class="text-silver-700 text-xs mt-1">User hasn't added their before photo</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Current Photo -->
                <div class="space-y-3">
                    <p class="text-silver-400 font-medium text-sm">Current Progress</p>
                    @if($user->current_photo)
                        <div class="relative rounded-xl overflow-hidden border-2 border-green-500/50 aspect-[3/4] bg-[#0a0a0a] w-full max-w-[300px] mx-auto shadow-lg">
                            <img src="{{ Storage::url($user->current_photo) }}"
                                 alt="Current Photo"
                                 class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3 bg-green-600/90 backdrop-blur-sm px-3 py-1 rounded-lg">
                                <p class="text-xs font-semibold text-white">Current</p>
                            </div>
                        </div>
                        <p class="text-xs text-silver-500 text-center">Updated: {{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y') }}</p>
                    @else
                        <div class="relative rounded-xl border-2 border-dashed border-silver-900/50 aspect-[3/4] bg-[#0a0a0a] flex items-center justify-center w-full max-w-[300px] mx-auto">
                            <div class="text-center">
                                <x-phosphor-camera class="w-12 h-12 text-silver-700 mx-auto mb-3" />
                                <p class="text-silver-600 text-sm">No current photo uploaded</p>
                                <p class="text-silver-700 text-xs mt-1">User hasn't added their progress photo</p>
                            </div>
                        </div>
                    @endif
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
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-sm font-medium">
                                    {{ number_format($log->mito_age_score, 1) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-silver-500">No daily logs yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Skin Assessments History -->
    @if(!$user->skinAssessments->isEmpty())
        <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-8 border border-silver-900/30">
            <h3 class="text-2xl font-bold text-silver-100 mb-6 flex items-center">
                <x-phosphor-sparkle class="w-7 h-7 text-pink-400 mr-3" />
                Skin Assessment History
            </h3>

            @php
                $baseline = $user->skinAssessments->where('milestone_day', 0)->first();
                $latestAssessment = $user->skinAssessments->where('milestone_day', '>', 0)->sortByDesc('milestone_day')->first();
            @endphp

            <!-- Summary Cards -->
            @if($baseline)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-[#0f0f0f] rounded-xl p-6 border border-blue-900/30">
                        <p class="text-silver-500 text-sm mb-2">Baseline Score</p>
                        <p class="text-3xl font-bold text-blue-400">
                            {{ number_format(($baseline->radiance + $baseline->smoothness + $baseline->calmness + $baseline->clarity + $baseline->hydration + $baseline->firmness + $baseline->evenness) / 7, 1) }}
                        </p>
                        <p class="text-xs text-silver-600 mt-1">Day 0</p>
                    </div>

                    @if($latestAssessment)
                        @php
                            $latestScore = ($latestAssessment->radiance + $latestAssessment->smoothness + $latestAssessment->calmness + $latestAssessment->clarity + $latestAssessment->hydration + $latestAssessment->firmness + $latestAssessment->evenness) / 7;
                            $baselineScore = ($baseline->radiance + $baseline->smoothness + $baseline->calmness + $baseline->clarity + $baseline->hydration + $baseline->firmness + $baseline->evenness) / 7;
                            $improvement = $baselineScore > 0 ? (($latestScore - $baselineScore) / $baselineScore) * 100 : 0;
                        @endphp
                        <div class="bg-[#0f0f0f] rounded-xl p-6 border border-green-900/30">
                            <p class="text-silver-500 text-sm mb-2">Latest Score</p>
                            <p class="text-3xl font-bold text-green-400">{{ number_format($latestScore, 1) }}</p>
                            <p class="text-xs text-silver-600 mt-1">Day {{ $latestAssessment->milestone_day }}</p>
                        </div>

                        <div class="bg-[#0f0f0f] rounded-xl p-6 border border-purple-900/30">
                            <p class="text-silver-500 text-sm mb-2">Overall Improvement</p>
                            <p class="text-3xl font-bold {{ $improvement >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $improvement >= 0 ? '+' : '' }}{{ number_format($improvement, 1) }}%
                            </p>
                            <p class="text-xs text-silver-600 mt-1">From baseline</p>
                        </div>
                    @else
                        <div class="bg-[#0f0f0f] rounded-xl p-6 border border-silver-900/30 col-span-2">
                            <p class="text-silver-500 text-sm mb-2">Progress Status</p>
                            <p class="text-lg text-silver-400">Only baseline assessment completed</p>
                            <p class="text-xs text-silver-600 mt-1">Waiting for follow-up assessments</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Detailed Assessment Table -->
            <div class="bg-[#0f0f0f] rounded-xl p-6 border border-silver-900/30">
                <h4 class="text-lg font-semibold text-silver-200 mb-4">All Assessments ({{ $user->skinAssessments->count() }})</h4>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-silver-900/30">
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Day</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Date</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Avg Score</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Radiance</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Smoothness</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Calmness</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Clarity</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Hydration</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Firmness</th>
                                <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Evenness</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->skinAssessments as $assessment)
                                @php
                                    $avgScore = ($assessment->radiance + $assessment->smoothness + $assessment->calmness + $assessment->clarity + $assessment->hydration + $assessment->firmness + $assessment->evenness) / 7;
                                @endphp
                                <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 {{ $assessment->milestone_day == 0 ? 'bg-blue-600/20 text-blue-400' : 'bg-silver-900/30 text-silver-300' }} rounded-lg text-xs font-medium">
                                            Day {{ $assessment->milestone_day }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->created_at->format('M d, Y') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 bg-pink-600/20 text-pink-400 rounded-lg text-sm font-semibold">
                                            {{ number_format($avgScore, 1) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->radiance }}</td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->smoothness }}</td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->calmness }}</td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->clarity }}</td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->hydration }}</td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->firmness }}</td>
                                    <td class="py-3 px-4 text-silver-300">{{ $assessment->evenness }}</td>
                                </tr>
                                @if($assessment->notes)
                                    <tr class="border-b border-silver-900/30">
                                        <td colspan="10" class="py-2 px-4 bg-[#0a0a0a]">
                                            <p class="text-xs text-silver-500"><strong>Notes:</strong> {{ $assessment->notes }}</p>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Milestones -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Milestones Progress</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach([30, 60, 90, 120, 150, 180, 270, 360] as $day)
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
