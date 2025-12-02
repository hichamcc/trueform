@extends('layouts.dashboard')

@section('page-title', 'Skin Glow Assessment')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-silver-200 to-silver-400 bg-clip-text text-transparent mb-2">
            Skin Glow Assessment
        </h1>
        <p class="text-sm lg:text-base text-gray-400">
            You only need to do this every 30 days. These check-ins help you track real changes in your skin over your 90–360 day journey.
        </p>
        @if($latestAssessment)
            <div class="mt-2 inline-block px-3 py-1 bg-blue-600/20 border border-blue-600/30 rounded-lg">
                <span class="text-xs lg:text-sm text-blue-400">
                    Next assessment available: Day {{ collect([0, 30, 60, 90, 180, 270, 360])->first(fn($d) => $d > $currentDay) ?? 360 }}
                </span>
            </div>
        @endif
    </div>

    <!-- Section A: Current Status / Summary -->
    @if($latestAssessment)
    <div class="mb-6 bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 lg:p-6 border border-[#2a2a3e]">
        <h2 class="text-lg lg:text-xl font-bold text-silver-200 mb-4">Current Status</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Current Skin Score -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Current Skin Score</p>
                <p class="text-3xl font-bold text-green-400">{{ number_format($currentScore, 1) }}</p>
            </div>

            <!-- Change vs Baseline -->
            @if($changeVsBaseline !== null)
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Change vs Baseline</p>
                <p class="text-3xl font-bold {{ $changeVsBaseline >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $changeVsBaseline >= 0 ? '+' : '' }}{{ number_format($changeVsBaseline, 1) }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    {{ $changeVsBaseline >= 0 ? '↑' : '↓' }}
                    {{ number_format(abs($changeVsBaseline / $baselineScore * 100), 1) }}%
                </p>
            </div>
            @endif

            <!-- Last Assessment -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Last Assessment</p>
                <p class="text-lg font-semibold text-silver-300">
                    {{ $latestAssessment->getMilestoneLabel() }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    {{ $latestAssessment->assessment_date->format('M j, Y') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Section B: Milestone Cards -->
    <div class="mb-6">
        <h2 class="text-lg lg:text-xl font-bold text-silver-200 mb-4">Assessment Milestones</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($milestoneData as $milestone)
            <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 border {{ $milestone['is_completed'] ? 'border-green-600/50' : ($milestone['is_available'] ? 'border-blue-600/50' : 'border-[#2a2a3e]') }}">
                <!-- Milestone Header -->
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base lg:text-lg font-bold text-silver-200">
                        {{ $milestone['label'] }}
                    </h3>
                    <div>
                        @if($milestone['is_completed'])
                            <span class="px-2 py-1 bg-green-600/20 border border-green-600/30 rounded text-xs text-green-400 font-semibold">
                                ✓ Completed
                            </span>
                        @elseif($milestone['is_available'])
                            <span class="px-2 py-1 bg-blue-600/20 border border-blue-600/30 rounded text-xs text-blue-400 font-semibold">
                                Available
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-600/20 border border-gray-600/30 rounded text-xs text-gray-400 font-semibold">
                                Locked
                            </span>
                        @endif
                    </div>
                </div>

                @if($milestone['is_completed'])
                    <!-- Completed: Show score and thumbnail -->
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Skin Score</p>
                        <p class="text-2xl font-bold text-green-400">
                            {{ number_format($milestone['assessment']->skin_score, 1) }}
                        </p>
                    </div>

                    @if($milestone['assessment']->photo)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $milestone['assessment']->photo) }}"
                             alt="{{ $milestone['label'] }} photo"
                             class="w-full h-32 object-cover rounded-lg border border-[#2a2a3e]">
                    </div>
                    @endif

                    <a href="{{ route('dashboard.skin-assessment.show', $milestone['assessment']->id) }}"
                       class="block w-full px-4 py-2 bg-silver-600/20 hover:bg-silver-600/30 border border-silver-600/30 text-silver-300 text-sm font-semibold rounded-lg transition text-center">
                        View Details
                    </a>
                @elseif($milestone['is_available'])
                    <!-- Available: Show Complete Check-In button -->
                    <p class="text-xs text-gray-400 mb-3">
                        Complete your {{ $milestone['label'] }} skin assessment to track your progress.
                    </p>
                    <a href="{{ route('dashboard.skin-assessment.create', $milestone['day']) }}"
                       class="block w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white text-sm font-semibold rounded-lg transition text-center">
                        Complete Check-In
                    </a>
                @else
                    <!-- Locked: Show when it will be available -->
                    <p class="text-xs text-gray-400">
                        This assessment will be available on Day {{ $milestone['day'] }}.
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        You're currently on Day {{ $currentDay }}.
                    </p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
