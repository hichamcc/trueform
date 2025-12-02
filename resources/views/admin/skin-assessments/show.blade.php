@extends('admin.layouts.admin')

@section('page-title', 'Assessment Details')
@section('page-subtitle', $assessment->user->name . ' - ' . $assessment->getMilestoneLabel())

@section('content')
<div class="space-y-4">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.skin-assessments.index') }}"
           class="inline-flex items-center text-sm text-blue-400 hover:text-blue-300">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Assessments
        </a>
    </div>

    <!-- User & Assessment Info -->
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 border border-silver-900/30">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">User</p>
                <p class="text-lg font-semibold text-silver-300">{{ $assessment->user->name }}</p>
                <p class="text-xs text-gray-400">{{ $assessment->user->email }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Milestone</p>
                <p class="text-lg font-semibold text-blue-400">{{ $assessment->getMilestoneLabel() }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Day in Program</p>
                <p class="text-lg font-semibold text-silver-300">Day {{ $assessment->day_in_program }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Assessment Date</p>
                <p class="text-lg font-semibold text-silver-300">{{ $assessment->assessment_date->format('F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Overall Skin Score -->
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-6 border border-silver-900/30 text-center">
        <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">Overall Skin Score</p>
        <p class="text-5xl font-bold text-green-400 mb-1">{{ number_format($assessment->skin_score, 1) }}</p>
        <p class="text-xs text-gray-400">Average of 7 metrics</p>
    </div>

    <!-- Photo -->
    @if($assessment->photo)
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 border border-silver-900/30">
        <h3 class="text-lg font-bold text-silver-200 mb-4">Assessment Photo</h3>
        <img src="{{ asset('storage/' . $assessment->photo) }}"
             alt="Assessment photo"
             class="w-full max-w-2xl mx-auto rounded-lg border border-[#2a2a3e]">
    </div>
    @endif

    <!-- Detailed Metrics -->
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 border border-silver-900/30">
        <h3 class="text-lg font-bold text-silver-200 mb-4">Detailed Metrics</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Radiance -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Radiance & Glow</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->radiance, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->radiance / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Smoothness -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Smoothness</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->smoothness, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->smoothness / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Calmness -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Calmness</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->calmness, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->calmness / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Clarity -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Clarity</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->clarity, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->clarity / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Hydration -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Hydration</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->hydration, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->hydration / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Firmness -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Firmness</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->firmness, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->firmness / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Evenness -->
            <div class="bg-[#0a0a0a]/50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300 font-medium">Evenness</span>
                    <span class="text-2xl font-bold text-blue-400">{{ number_format($assessment->evenness, 1) }}</span>
                </div>
                <div class="w-full bg-[#16213e] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->evenness / 10) * 100 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($assessment->notes)
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 border border-silver-900/30">
        <h3 class="text-lg font-bold text-silver-200 mb-4">User Notes</h3>
        <p class="text-sm text-gray-300 whitespace-pre-wrap">{{ $assessment->notes }}</p>
    </div>
    @endif
</div>
@endsection
