@extends('layouts.dashboard')

@section('title', 'Progress & Milestones')
@section('page-title', 'Progress & Milestones')

@section('content')
<div class="space-y-6">
    <!-- Stage Indicator -->
    @if($enrollment)
        <div class="bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-xl p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="px-4 py-1 glass-light rounded-full text-white text-sm font-semibold">
                            Stage {{ $currentStage }} of 3
                        </span>
                        <span class="text-white/90 text-sm">{{ $stageName }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Your Progress Through the Stages</h2>
                </div>
                <div class="text-right">
                    <div class="text-white/80 text-sm mb-1">Total Program Progress</div>
                    <div class="text-3xl font-bold text-white">{{ $enrollment->getCurrentDay() }}/360 Days</div>
                </div>
            </div>
        </div>
    @endif

    @if($baseline && $latestLog)
        <!-- 7/30/90-Day Improvement Overview -->
        <div class="bg-gradient-to-br from-[#16213e] to-[#1a1a2e] rounded-2xl p-6 border border-purple-500/30">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Improvement Over Time</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $windows = [
                        '7_days' => ['label' => 'Last 7 Days', 'icon' => '📅', 'color' => 'blue'],
                        '30_days' => ['label' => 'Last 30 Days', 'icon' => '📊', 'color' => 'purple'],
                        '90_days' => ['label' => 'Last 90 Days', 'icon' => '🎯', 'color' => 'green'],
                    ];
                @endphp

                @foreach($windows as $key => $window)
                    <div class="bg-[#0f0f0f] rounded-xl p-6 border border-silver-900/30">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="text-3xl">{{ $window['icon'] }}</div>
                            <div>
                                <h3 class="text-lg font-bold text-silver-200">{{ $window['label'] }}</h3>
                                @if($improvements[$key])
                                    <p class="text-xs text-silver-500">{{ $improvements[$key]['count'] }} logs tracked</p>
                                @endif
                            </div>
                        </div>

                        @if($improvements[$key])
                            <!-- Overall Mito-Age Improvement -->
                            <div class="mb-4 p-4 bg-{{ $window['color'] }}-900/20 rounded-lg border border-{{ $window['color'] }}-500/30">
                                <div class="text-xs text-silver-400 mb-1">Overall Improvement</div>
                                <div class="text-3xl font-bold {{ $improvements[$key]['mito_age_score'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $improvements[$key]['mito_age_score'] >= 0 ? '+' : '' }}{{ $improvements[$key]['mito_age_score'] }}%
                                </div>
                            </div>

                            <!-- Individual Metrics -->
                            <div class="space-y-2">
                                @foreach(['energy' => 'Energy', 'focus' => 'Focus', 'sleep' => 'Sleep', 'gut_health' => 'Gut', 'skin_glow' => 'Glow'] as $metric => $label)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-silver-400">{{ $label }}</span>
                                        <span class="font-semibold {{ $improvements[$key][$metric] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                            {{ $improvements[$key][$metric] >= 0 ? '+' : '' }}{{ $improvements[$key][$metric] }}%
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-silver-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm text-silver-500">No data for this period yet</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Mito-Age Score Comparison -->
        <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-2xl p-8 border border-[#2a2a2a]">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Mito-Age Score Progress</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-sm text-gray-500 mb-2">Baseline</div>
                    <div class="text-4xl font-bold text-gray-400">{{ number_format($comparisons['mito_age_score']['baseline'], 1) }}</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-500 mb-2">Current</div>
                    <div class="text-5xl font-bold text-silver-300">{{ number_format($comparisons['mito_age_score']['current'], 1) }}</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-500 mb-2">Change</div>
                    <div class="text-4xl font-bold {{ $comparisons['mito_age_score']['change'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $comparisons['mito_age_score']['change'] >= 0 ? '+' : '' }}{{ number_format($comparisons['mito_age_score']['change'], 1) }}
                    </div>
                    <div class="text-sm {{ $comparisons['mito_age_score']['change'] >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        {{ $comparisons['mito_age_score']['change'] >= 0 ? '+' : '' }}{{ number_format($comparisons['mito_age_score']['percentage'], 1) }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Metrics Comparison -->
        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
            <h3 class="text-xl font-semibold text-silver-300 mb-6">Detailed Metrics Comparison</h3>
            <div class="space-y-6">
                @foreach(['energy' => 'Energy Level', 'focus' => 'Mental Focus', 'sleep' => 'Sleep Quality', 'gut_health' => 'Gut Health', 'skin_glow' => 'Skin Glow'] as $key => $label)
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-silver-300 font-medium">{{ $label }}</span>
                            <div class="text-sm">
                                <span class="text-gray-500">{{ number_format($comparisons[$key]['baseline'], 1) }}</span>
                                <span class="mx-2 text-gray-600">→</span>
                                <span class="text-silver-300 font-semibold">{{ number_format($comparisons[$key]['current'], 1) }}</span>
                                <span class="ml-3 {{ $comparisons[$key]['change'] >= 0 ? 'text-green-400' : 'text-red-400' }} font-semibold">
                                    {{ $comparisons[$key]['change'] >= 0 ? '+' : '' }}{{ number_format($comparisons[$key]['percentage'], 1) }}%
                                </span>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="w-full bg-gray-800 rounded-full h-3 overflow-hidden">
                                <div class="absolute inset-0 flex">
                                    <!-- Baseline indicator -->
                                    <div style="width: {{ ($comparisons[$key]['baseline'] / 10) * 100 }}%"
                                         class="bg-gray-600 h-full"></div>
                                </div>
                                <!-- Current value bar -->
                                <div style="width: {{ ($comparisons[$key]['current'] / 10) * 100 }}%"
                                     class="h-full {{ $comparisons[$key]['change'] >= 0 ? 'bg-green-500' : 'bg-red-500' }} transition-all duration-500"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Mito-Age Score Chart -->
        @if(count($chartData['labels']) > 0)
            <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
                <h3 class="text-xl font-semibold text-silver-300 mb-6">Mito-Age Score Timeline</h3>
                <div class="h-80">
                    <canvas id="mitoAgeChart"></canvas>
                </div>
            </div>

            <!-- All Metrics Chart -->
            <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
                <h3 class="text-xl font-semibold text-silver-300 mb-6">All Metrics Over Time</h3>
                <div class="h-96">
                    <canvas id="metricsChart"></canvas>
                </div>
            </div>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Chart initialization started');

                    // Data for debugging
                    const labels = @json($chartData['labels']);
                    const mitoAgeData = @json($chartData['mito_age_score']);

                    console.log('Labels:', labels);
                    console.log('Mito-Age Data:', mitoAgeData);

                    // Check if functions exist
                    if (typeof window.initMitoAgeChart === 'function') {
                        console.log('Initializing Mito-Age Chart...');
                        initMitoAgeChart(labels, mitoAgeData);
                    } else {
                        console.error('initMitoAgeChart function not found!');
                    }

                    // Initialize All Metrics Chart
                    const metricsData = {
                        energy: @json($chartData['energy']),
                        focus: @json($chartData['focus']),
                        sleep: @json($chartData['sleep']),
                        gut_health: @json($chartData['gut_health']),
                        skin_glow: @json($chartData['skin_glow'])
                    };

                    console.log('Metrics Data:', metricsData);

                    if (typeof window.initMetricsChart === 'function') {
                        console.log('Initializing All Metrics Chart...');
                        initMetricsChart(labels, metricsData);
                    } else {
                        console.error('initMetricsChart function not found!');
                    }
                });
            </script>
            @endpush
        @endif
    @else
        <!-- No Data Yet -->
        <div class="bg-[#141414] rounded-xl p-12 border border-[#2a2a2a] text-center">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="text-xl font-semibold text-silver-300 mb-2">No Progress Data Yet</h3>
            <p class="text-gray-400 mb-6">Start tracking your metrics to see your transformation progress</p>
            <a href="{{ route('dashboard.tracker') }}" class="inline-block px-6 py-3 bg-silver-600 hover:bg-silver-500 text-white rounded-lg transition">
                Start Tracking
            </a>
        </div>
    @endif

    <!-- Milestones - All 8 Across 3 Stages -->
    <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
        <h3 class="text-xl font-semibold text-silver-300 mb-6">360-Day Milestones - All 3 Stages</h3>

        @php
            $stageGroups = [
                1 => ['name' => 'Stage 1: Foundation', 'days' => [30, 60, 90], 'color' => ['bg' => 'bg-green-900/10', 'border' => 'border-green-500/50', 'text' => 'text-green-400', 'badge' => 'from-green-500 to-green-600']],
                2 => ['name' => 'Stage 2: Expansion', 'days' => [120, 150, 180], 'color' => ['bg' => 'bg-blue-900/10', 'border' => 'border-blue-500/50', 'text' => 'text-blue-400', 'badge' => 'from-blue-500 to-blue-600']],
                3 => ['name' => 'Stage 3: Mastery', 'days' => [270, 360], 'color' => ['bg' => 'bg-yellow-900/10', 'border' => 'border-yellow-500/50', 'text' => 'text-yellow-400', 'badge' => 'from-yellow-500 to-yellow-600']],
            ];
            $currentDayVal = $enrollment ? $enrollment->getCurrentDay() : 0;
        @endphp

        @foreach($stageGroups as $stageNum => $stage)
            <div class="mb-8 last:mb-0">
                <h4 class="text-lg font-bold {{ $stage['color']['text'] }} mb-4 flex items-center">
                    <span class="px-3 py-1 {{ $stage['color']['bg'] }} {{ $stage['color']['border'] }} border rounded-full text-sm mr-3">
                        {{ $stage['name'] }}
                    </span>
                </h4>

                <div class="space-y-4">
                    @foreach($stage['days'] as $day)
                        @php
                            $milestone = $milestones->where('milestone_day', $day)->first();
                            $isUnlocked = $milestone && $milestone->unlocked_at;
                            $daysUntil = max(0, $day - $currentDayVal);
                        @endphp
                        <div class="relative flex items-start p-6 rounded-lg border {{ $isUnlocked ? $stage['color']['bg'] . ' ' . $stage['color']['border'] : 'bg-[#0f0f0f] border-[#2a2a2a]' }}">
                            <!-- Badge -->
                            <div class="flex-shrink-0 mr-6">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center {{ $isUnlocked ? 'bg-gradient-to-br ' . $stage['color']['badge'] : 'bg-gradient-to-br from-gray-700 to-gray-800' }} shadow-lg">
                                    @if($isUnlocked)
                                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-lg font-semibold {{ $isUnlocked ? $stage['color']['text'] : 'text-silver-300' }}">
                                        {{ $milestone->reward_title ?? "Day {$day} Milestone" }}
                                    </h4>
                                    @if($isUnlocked)
                                        <span class="px-3 py-1 {{ $stage['color']['bg'] }} {{ $stage['color']['text'] }} text-sm rounded-full">
                                            Unlocked {{ $milestone->unlocked_at->diffForHumans() }}
                                        </span>
                                    @elseif($daysUntil == 0)
                                        <span class="px-3 py-1 bg-yellow-900/30 text-yellow-400 text-sm rounded-full animate-pulse">
                                            Available Today!
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-900/30 text-gray-400 text-sm rounded-full">
                                            {{ $daysUntil }} days to go
                                        </span>
                                    @endif
                                </div>

                                <p class="text-gray-400 text-sm mb-3">
                                    {{ $milestone->reward_description ?? "Complete {$day} days of consistent tracking to unlock this milestone and earn your reward." }}
                                </p>

                                @if($isUnlocked && !$milestone->reward_claimed)
                                    <button class="px-4 py-2 bg-gradient-to-r {{ $stage['color']['badge'] }} hover:opacity-90 text-white text-sm rounded-lg transition">
                                        Claim Reward
                                    </button>
                                @elseif($isUnlocked && $milestone->reward_claimed)
                                    <div class="text-sm {{ $stage['color']['text'] }} flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Reward Claimed
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Progress Insights -->
    @if($baseline && $latestLog)
        <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-xl p-6 border border-[#2a2a2a]">
            <h3 class="text-lg font-semibold text-silver-300 mb-4">Progress Insights</h3>
            <div class="space-y-3 text-sm text-gray-400">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>You've improved your overall Mito-Age Score by <strong class="text-silver-300">{{ number_format(abs($comparisons['mito_age_score']['percentage']), 1) }}%</strong></span>
                </div>
                @php
                    $bestImprovement = collect($comparisons)->filter(fn($m, $key) => $key !== 'mito_age_score')->sortByDesc('percentage')->first();
                    $bestKey = collect($comparisons)->filter(fn($m, $key) => $key !== 'mito_age_score')->sortByDesc('percentage')->keys()->first();
                @endphp
                @if($bestImprovement && $bestImprovement['percentage'] > 0)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Your strongest improvement is in <strong class="text-silver-300">{{ ucwords(str_replace('_', ' ', $bestKey)) }}</strong> with a <strong class="text-green-400">+{{ number_format($bestImprovement['percentage'], 1) }}%</strong> increase</span>
                    </div>
                @endif
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-silver-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Keep logging daily to see even more dramatic transformations</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
