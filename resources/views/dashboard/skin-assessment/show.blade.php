@extends('layouts.dashboard')

@section('page-title', 'Assessment Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('dashboard.skin-assessment.index') }}" class="inline-flex items-center text-sm text-blue-400 hover:text-blue-300 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Assessments
        </a>

        <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-silver-200 to-silver-400 bg-clip-text text-transparent mb-2">
            {{ $assessment->getMilestoneLabel() }} Assessment
        </h1>
        <p class="text-sm lg:text-base text-gray-400">
            Completed on {{ $assessment->assessment_date->format('F j, Y') }} (Day {{ $assessment->day_in_program }})
        </p>
    </div>

    <!-- Overall Score Card -->
    <div class="mb-6 bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 lg:p-6 border border-[#2a2a3e]">
        <div class="text-center">
            <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">Overall Skin Score</p>
            <p class="text-5xl font-bold text-green-400 mb-1">{{ number_format($assessment->skin_score, 1) }}</p>
            <p class="text-xs text-gray-400">Average of 7 metrics</p>
        </div>
    </div>

    <!-- Photo -->
    @if($assessment->photo)
    <div class="mb-6 bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 lg:p-6 border border-[#2a2a3e]">
        <h2 class="text-lg font-bold text-silver-200 mb-4">Photo</h2>
        <img src="{{ asset('storage/' . $assessment->photo) }}"
             alt="{{ $assessment->getMilestoneLabel() }} photo"
             class="w-full max-w-2xl mx-auto rounded-lg border border-[#2a2a3e]">
    </div>
    @endif

    <!-- Detailed Metrics -->
    <div class="mb-6 bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 lg:p-6 border border-[#2a2a3e]">
        <h2 class="text-lg font-bold text-silver-200 mb-4">Detailed Metrics</h2>

        <div class="space-y-4">
            <!-- Radiance -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Radiance & Glow</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->radiance, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->radiance / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Smoothness -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Skin Texture Smoothness</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->smoothness, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->smoothness / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Calmness -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Calmness (Redness/Inflammation)</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->calmness, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->calmness / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Clarity -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Clarity (Breakouts/Acne)</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->clarity, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->clarity / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Hydration -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Hydration Level</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->hydration, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->hydration / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Firmness -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Firmness & Youthfulness</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->firmness, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->firmness / 10) * 100 }}%"></div>
                </div>
            </div>

            <!-- Evenness -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-silver-300">Skin Tone Evenness</span>
                    <span class="text-lg font-bold text-blue-400">{{ number_format($assessment->evenness, 1) }}</span>
                </div>
                <div class="w-full bg-[#0a0a0a] rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-2 rounded-full"
                         style="width: {{ ($assessment->evenness / 10) * 100 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($assessment->notes)
    <div class="mb-6 bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 lg:p-6 border border-[#2a2a3e]">
        <h2 class="text-lg font-bold text-silver-200 mb-4">Your Notes</h2>
        <p class="text-sm text-gray-300 whitespace-pre-wrap">{{ $assessment->notes }}</p>
    </div>
    @endif
</div>
@endsection
