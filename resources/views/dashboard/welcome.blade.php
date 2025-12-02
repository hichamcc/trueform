@extends('layouts.dashboard')

@section('title', 'Welcome')
@section('page-title', 'Welcome to True Form Elite')

@section('content')
<div class="space-y-4">
    <!-- Merged Hero & Stage Card -->
    <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-5 border {{ $stageTheme['border'] ?? 'border-[#2a2a2a]' }} shadow-lg animate-fade-in relative overflow-hidden">
        <!-- Stage Theme Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-full blur-3xl"></div>
        </div>

        <div class="relative">
            <!-- Header Row: Greeting + Stage Badge -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-silver-200 to-silver-400 bg-clip-text text-transparent mb-1">
                        Hello, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-gray-400 text-sm">Your 360-Day Transformation Journey</p>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-lg shadow-md">
                        <span class="text-white font-bold text-sm">Stage {{ $currentStage }}/3</span>
                        <span class="text-white/90 text-xs">{{ $stageName }}</span>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold {{ $stageTheme['text'] ?? 'text-silver-300' }}">Day {{ $currentDay }}</div>
                        <div class="text-xs text-gray-500">{{ $daysRemaining }} days remaining</div>
                    </div>
                </div>
            </div>

            <!-- Elite Progress Bar (360-Day Journey) -->
            <div class="mt-3">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-sm text-silver-400">Elite Progress</p>
                        <p class="text-xs text-gray-500">Your 360-Day Transformation Journey</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold {{ $stageTheme['text'] ?? 'text-silver-300' }}">
                            {{ number_format(($currentDay / 360) * 100, 0) }}%
                        </p>
                        <p class="text-xs text-gray-500">Complete</p>
                    </div>
                </div>

                <div class="w-full bg-gray-800 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-silver-500 to-silver-300' }} h-full rounded-full transition-all duration-500"
                         style="width: {{ ($currentDay / 360) * 100 }}%"></div>
                </div>

                <!-- Stage Milestones -->
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <div class="flex flex-col items-center {{ $currentDay >= 1 ? 'text-green-400' : '' }}">
                        <span class="font-semibold">Start</span>
                    </div>
                    <div class="flex flex-col items-center {{ $currentDay >= 90 ? 'text-green-400' : '' }}">
                        <span class="font-semibold">Day 90</span>
                        @if($currentDay >= 90)
                            <span class="text-xs">✓</span>
                        @endif
                    </div>
                    <div class="flex flex-col items-center {{ $currentDay >= 180 ? 'text-blue-400' : '' }}">
                        <span class="font-semibold">Day 180</span>
                        @if($currentDay >= 180)
                            <span class="text-xs">✓</span>
                        @endif
                    </div>
                    <div class="flex flex-col items-center {{ $currentDay >= 360 ? 'text-yellow-400' : '' }}">
                        <span class="font-semibold">Day 360</span>
                        @if($currentDay >= 360)
                            <span class="text-xs">✓</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animated Transformation Glow Bar -->
    <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] shadow-lg animate-fade-in delay-50 relative overflow-hidden">
        <!-- Background Glow Effect -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-purple-600 to-blue-600' }} rounded-full blur-3xl animate-pulse"></div>
        </div>

        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="text-lg font-bold text-silver-200 mb-1">Transformation Glow</h3>
                    <p class="text-gray-400 text-xs">Your overall wellness evolution</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-purple-400 to-blue-400' }} bg-clip-text text-transparent">
                        {{ number_format($transformationPercentage, 0) }}%
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Glow Score</div>
                </div>
            </div>

            <!-- Animated Progress Bar -->
            <div class="relative w-full h-6 bg-[#0f0f0f] rounded-full overflow-hidden border border-[#2a2a2a]">
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-30">
                    <div class="h-full w-full bg-gradient-to-r from-transparent via-white to-transparent animate-shimmer"></div>
                </div>

                <!-- Main Progress Bar -->
                <div
                    class="absolute h-full bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-purple-600 via-blue-600 to-purple-600' }} rounded-full transition-all duration-1000 ease-out shadow-lg"
                    style="width: {{ $transformationPercentage }}%"
                >
                    <!-- Inner Shine Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-40 animate-slide"></div>

                    <!-- Pulsing Glow -->
                    <div class="absolute inset-0 bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-purple-400 to-blue-400' }} rounded-full blur-md opacity-60 animate-pulse"></div>
                </div>
            </div>

            <!-- Progress Labels -->
            <div class="flex justify-between text-xs text-gray-500 mt-3">
                <span>Beginning</span>
                <span>25%</span>
                <span>50%</span>
                <span>75%</span>
                <span>Peak Form</span>
            </div>

            @if($transformationPercentage > 0)
                <div class="mt-3 p-2 bg-{{ $transformationPercentage >= 50 ? 'green' : 'blue' }}-900/20 border border-{{ $transformationPercentage >= 50 ? 'green' : 'blue' }}-500/30 rounded-lg">
                    <p class="text-xs text-{{ $transformationPercentage >= 50 ? 'green' : 'blue' }}-300">
                        @if($transformationPercentage >= 75)
                            <strong>Outstanding!</strong> You're radiating peak wellness energy. Keep shining!
                        @elseif($transformationPercentage >= 50)
                            <strong>Great progress!</strong> Your transformation is clearly visible. Stay consistent!
                        @elseif($transformationPercentage >= 25)
                            <strong>Building momentum!</strong> Your wellness journey is taking shape. Keep going!
                        @else
                            <strong>Just getting started!</strong> Every step forward counts. Stay committed!
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Log Today CTA - Show only if not completed -->
    @if(!$todayLog)
        <div class="bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-lg p-4 shadow-lg animate-fade-in delay-100 relative overflow-hidden">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-48 h-48 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white rounded-full blur-2xl"></div>
            </div>

            <div class="relative flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <h3 class="text-lg font-bold text-white mb-1">Ready to Log Day {{ $currentDay }}?</h3>
                        <p class="text-white/90 text-xs">Track your metrics and maintain your streak</p>
                    </div>
                </div>
                <a href="{{ route('dashboard.tracker') }}" class="px-6 py-2 bg-white text-gray-900 font-bold rounded-lg hover:bg-gray-100 transition-all shadow-lg whitespace-nowrap text-sm">
                    Log Now →
                </a>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 animate-fade-in delay-200">
        <!-- Streak Counter -->
        @if($enrollment)
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] hover-glow transition-smooth">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-silver-300">Streak</h3>
                <div class="text-2xl">🔥</div>
            </div>
            <div class="text-3xl font-bold text-orange-400 mb-1">{{ $enrollment->current_streak }}</div>
            <p class="text-xs text-gray-500 mb-2">{{ $enrollment->current_streak == 1 ? 'Day' : 'Days' }} in a row</p>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500">Best:</span>
                <span class="text-silver-400 font-semibold">{{ $enrollment->longest_streak }} days</span>
            </div>
        </div>
        @endif

        <!-- Mito-Age Score -->
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] hover-glow transition-smooth">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-silver-300">Mito-Age Score</h3>
                <svg class="w-6 h-6 text-silver-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            @if($currentMitoAge)
                <div class="text-3xl font-bold text-silver-200">{{ number_format($currentMitoAge, 1) }}</div>
                <p class="text-xs text-gray-500 mt-1">out of 10.0</p>
            @else
                <div class="text-gray-500 text-xs">Complete your baseline to see your score</div>
            @endif
        </div>

        <!-- Today's Log Status -->
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] hover-glow transition-smooth">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-silver-300">Today's Log</h3>
                <svg class="w-6 h-6 text-silver-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            @if($todayLog)
                <div class="text-xl font-bold text-green-400">Completed</div>
                <p class="text-xs text-gray-500 mt-1">Great job staying on track!</p>
            @else
                <div class="text-xl font-bold text-yellow-400">Pending</div>
                <a href="{{ route('dashboard.tracker') }}" class="inline-block mt-2 text-xs text-silver-400 hover:text-silver-300 transition-smooth">
                    Log your metrics →
                </a>
            @endif
        </div>

        <!-- Baseline Status -->
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] hover-glow transition-smooth">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-silver-300">Baseline</h3>
                <svg class="w-6 h-6 text-silver-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            @if($baseline)
                <div class="text-xl font-bold text-green-400">Set</div>
                <p class="text-xs text-gray-500 mt-1">Initial metrics recorded</p>
            @else
                <div class="text-xl font-bold text-red-400">Not Set</div>
                <a href="{{ route('dashboard.tracker') }}" class="inline-block mt-2 text-xs text-silver-400 hover:text-silver-300">
                    Set baseline →
                </a>
            @endif
        </div>
    </div>

    <!-- KPI Cards - Five Metrics (PROMINENT) -->
    @if($todayLog || $recentLogs->count() > 0)
        @php
            // Get the most recent log for displaying current metrics
            $latestLog = $todayLog ?? $recentLogs->first();

            // Function to determine color based on value (1-10 scale)
            $getColorClass = function($value) {
                if ($value >= 8) {
                    return [
                        'bg' => 'bg-green-900/30',
                        'border' => 'border-green-500/50',
                        'text' => 'text-green-400',
                        'ring' => 'ring-green-500/50',
                        'gradient' => 'from-green-600 to-green-500',
                        'glow' => 'shadow-green-500/20'
                    ];
                } elseif ($value >= 5) {
                    return [
                        'bg' => 'bg-yellow-900/30',
                        'border' => 'border-yellow-500/50',
                        'text' => 'text-yellow-400',
                        'ring' => 'ring-yellow-500/50',
                        'gradient' => 'from-yellow-600 to-yellow-500',
                        'glow' => 'shadow-yellow-500/20'
                    ];
                } else {
                    return [
                        'bg' => 'bg-red-900/30',
                        'border' => 'border-red-500/50',
                        'text' => 'text-red-400',
                        'ring' => 'ring-red-500/50',
                        'gradient' => 'from-red-600 to-red-500',
                        'glow' => 'shadow-red-500/20'
                    ];
                }
            };

            // Get baseline for comparison
            $hasBaseline = $baseline ? true : false;
        @endphp

        <div class="animate-fade-in delay-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-silver-200">Your Wellness Metrics</h2>
                    <p class="text-silver-400 mt-1 text-xs">Real-time snapshot of your transformation</p>
                </div>
                <a href="{{ route('dashboard.progress') }}" class="px-3 py-2 bg-silver-600 hover:bg-silver-500 text-white rounded-lg transition text-xs font-medium">
                    View Detailed Progress →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @if($latestLog)
                    <!-- Energy Card -->
                    @php $energyColor = $getColorClass($latestLog->energy); @endphp
                    <div class="group bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-4 border {{ $energyColor['border'] }} {{ $energyColor['bg'] }} hover:ring-2 {{ $energyColor['ring'] }} transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl {{ $energyColor['glow'] }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $energyColor['gradient'] }} flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold {{ $energyColor['text'] }} mb-2">{{ number_format($latestLog->energy, 1) }}</div>
                        <div class="text-sm font-semibold text-silver-200 mb-2">Energy</div>
                        @if($hasBaseline)
                            @php
                                $change = $latestLog->energy - $baseline->energy;
                                $changePercent = $baseline->energy > 0 ? (($change / $baseline->energy) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-1 text-xs font-semibold {{ $change >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                <span>{{ $change >= 0 ? '↗' : '↘' }}</span>
                                <span>{{ $change >= 0 ? '+' : '' }}{{ number_format($changePercent, 0) }}%</span>
                            </div>
                        @endif
                    </div>

                    <!-- Focus Card -->
                    @php $focusColor = $getColorClass($latestLog->focus); @endphp
                    <div class="group bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-4 border {{ $focusColor['border'] }} {{ $focusColor['bg'] }} hover:ring-2 {{ $focusColor['ring'] }} transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl {{ $focusColor['glow'] }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $focusColor['gradient'] }} flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold {{ $focusColor['text'] }} mb-2">{{ number_format($latestLog->focus, 1) }}</div>
                        <div class="text-sm font-semibold text-silver-200 mb-2">Focus</div>
                        @if($hasBaseline)
                            @php
                                $change = $latestLog->focus - $baseline->focus;
                                $changePercent = $baseline->focus > 0 ? (($change / $baseline->focus) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-1 text-xs font-semibold {{ $change >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                <span>{{ $change >= 0 ? '↗' : '↘' }}</span>
                                <span>{{ $change >= 0 ? '+' : '' }}{{ number_format($changePercent, 0) }}%</span>
                            </div>
                        @endif
                    </div>

                    <!-- Sleep Card -->
                    @php $sleepColor = $getColorClass($latestLog->sleep); @endphp
                    <div class="group bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-4 border {{ $sleepColor['border'] }} {{ $sleepColor['bg'] }} hover:ring-2 {{ $sleepColor['ring'] }} transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl {{ $sleepColor['glow'] }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $sleepColor['gradient'] }} flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold {{ $sleepColor['text'] }} mb-2">{{ number_format($latestLog->sleep, 1) }}</div>
                        <div class="text-sm font-semibold text-silver-200 mb-2">Sleep</div>
                        @if($hasBaseline)
                            @php
                                $change = $latestLog->sleep - $baseline->sleep;
                                $changePercent = $baseline->sleep > 0 ? (($change / $baseline->sleep) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-1 text-xs font-semibold {{ $change >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                <span>{{ $change >= 0 ? '↗' : '↘' }}</span>
                                <span>{{ $change >= 0 ? '+' : '' }}{{ number_format($changePercent, 0) }}%</span>
                            </div>
                        @endif
                    </div>

                    <!-- Gut Health Card -->
                    @php $gutColor = $getColorClass($latestLog->gut_health); @endphp
                    <div class="group bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-4 border {{ $gutColor['border'] }} {{ $gutColor['bg'] }} hover:ring-2 {{ $gutColor['ring'] }} transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl {{ $gutColor['glow'] }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $gutColor['gradient'] }} flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-bold {{ $gutColor['text'] }} mb-2">{{ number_format($latestLog->gut_health, 1) }}</div>
                        <div class="text-sm font-semibold text-silver-200 mb-2">Gut Health</div>
                        @if($hasBaseline)
                            @php
                                $change = $latestLog->gut_health - $baseline->gut_health;
                                $changePercent = $baseline->gut_health > 0 ? (($change / $baseline->gut_health) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-1 text-xs font-semibold {{ $change >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                <span>{{ $change >= 0 ? '↗' : '↘' }}</span>
                                <span>{{ $change >= 0 ? '+' : '' }}{{ number_format($changePercent, 0) }}%</span>
                            </div>
                        @endif
                    </div>

                    <!-- Skin Score Card (Read-Only from Assessments) -->
                    @php
                        $skinColor = $currentSkinScore ? $getColorClass($currentSkinScore) : [
                            'bg' => 'bg-gray-900/30',
                            'border' => 'border-gray-500/50',
                            'text' => 'text-gray-400',
                            'ring' => 'ring-gray-500/50',
                            'gradient' => 'from-gray-600 to-gray-500',
                            'glow' => 'shadow-gray-500/20'
                        ];
                    @endphp
                    <div class="group bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-4 border {{ $skinColor['border'] }} {{ $skinColor['bg'] }} transition-all duration-300 shadow-lg relative">
                        <!-- Read-Only Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 bg-blue-600/20 border border-blue-600/30 rounded text-xs text-blue-400 font-semibold">
                                📊 Assessment
                            </span>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $skinColor['gradient'] }} flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                        </div>

                        @if($currentSkinScore)
                            <div class="text-3xl font-bold {{ $skinColor['text'] }} mb-2">{{ number_format($currentSkinScore, 1) }}</div>
                            <div class="text-sm font-semibold text-silver-200 mb-2">Skin Score</div>

                            @if($skinScoreChange !== null)
                                @php
                                    $changePercent = $baselineSkinScore > 0 ? (($skinScoreChange / $baselineSkinScore) * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-1 text-xs font-semibold {{ $skinScoreChange >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    <span>{{ $skinScoreChange >= 0 ? '↗' : '↘' }}</span>
                                    <span>{{ $skinScoreChange >= 0 ? '+' : '' }}{{ number_format($changePercent, 0) }}%</span>
                                </div>
                            @else
                                <div class="text-xs text-gray-500">
                                    @if($latestSkinAssessment)
                                        Last: {{ $latestSkinAssessment->assessment_date->format('M j') }}
                                    @endif
                                </div>
                            @endif

                            <!-- Link to Assessment -->
                            <div class="mt-3 pt-3 border-t border-[#2a2a3e]">
                                <p class="text-xs text-gray-400 mb-2">Tracked via Skin Glow Assessment every 30 days</p>
                                <a href="{{ route('dashboard.skin-assessment.index') }}"
                                   class="block text-center px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/30 border border-blue-600/30 text-blue-400 text-xs font-semibold rounded transition">
                                    Open Assessment
                                </a>
                            </div>
                        @else
                            <div class="text-xl font-bold text-gray-400 mb-2">--</div>
                            <div class="text-sm font-semibold text-silver-200 mb-2">Skin Score</div>
                            <div class="text-xs text-gray-500 mb-3">Complete your baseline assessment</div>

                            <!-- Link to Assessment -->
                            <div class="mt-2">
                                <a href="{{ route('dashboard.skin-assessment.index') }}"
                                   class="block text-center px-3 py-1.5 bg-blue-600/20 hover:bg-blue-600/30 border border-blue-600/30 text-blue-400 text-xs font-semibold rounded transition">
                                    Take Assessment
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Recent Activity -->
    <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] animate-fade-in delay-300">
        <h3 class="text-lg font-semibold text-silver-300 mb-3">Recent Activity</h3>
        @if($recentLogs->count() > 0)
            <div class="space-y-2">
                @foreach($recentLogs as $log)
                    <div class="flex items-center justify-between p-3 bg-[#0f0f0f] rounded-lg border border-[#2a2a2a]">
                        <div>
                            <div class="text-xs font-medium text-silver-300">{{ $log->log_date->format('M j, Y') }}</div>
                            <div class="text-xs text-gray-500 mt-1">Score: {{ number_format($log->mito_age_score, 1) }}</div>
                        </div>
                        <div class="flex space-x-1">
                            <span class="px-2 py-1 text-xs bg-blue-900/30 text-blue-300 rounded">E: {{ $log->energy }}</span>
                            <span class="px-2 py-1 text-xs bg-purple-900/30 text-purple-300 rounded">F: {{ $log->focus }}</span>
                            <span class="px-2 py-1 text-xs bg-green-900/30 text-green-300 rounded">S: {{ $log->sleep }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                <svg class="w-10 h-10 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-sm">No logs yet. Start tracking your progress!</p>
                <a href="{{ route('dashboard.tracker') }}" class="inline-block mt-2 px-3 py-2 bg-silver-600 hover:bg-silver-500 text-white rounded-lg transition text-xs">
                    Log Your First Entry
                </a>
            </div>
        @endif
    </div>

    <!-- Milestones Preview -->
    <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a] animate-fade-in delay-400">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-silver-300">Current Stage Milestones - {{ $stageName }}</h3>
            <a href="{{ route('dashboard.progress') }}" class="text-xs text-silver-400 hover:text-silver-300">View All 8 →</a>
        </div>
        @php
            // Define milestone days per stage
            $stageMilestones = [
                1 => [30, 60, 90],      // Foundation (Green)
                2 => [120, 150, 180],   // Expansion (Blue)
                3 => [270, 360],        // Mastery (Gold)
            ];
            $currentStageMilestones = $stageMilestones[$currentStage] ?? [30, 60, 90];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach($currentStageMilestones as $day)
                @php
                    $milestone = $milestones->where('milestone_day', $day)->first();
                    $isUnlocked = $milestone && $milestone->unlocked_at;
                    $daysUntil = max(0, $day - $currentDay);

                    // Stage-based colors
                    $stageColor = match($currentStage) {
                        1 => ['bg' => 'bg-green-900/20', 'border' => 'border-green-500/50', 'text' => 'text-green-400'],
                        2 => ['bg' => 'bg-blue-900/20', 'border' => 'border-blue-500/50', 'text' => 'text-blue-400'],
                        3 => ['bg' => 'bg-yellow-900/20', 'border' => 'border-yellow-500/50', 'text' => 'text-yellow-400'],
                        default => ['bg' => 'bg-green-900/20', 'border' => 'border-green-500/50', 'text' => 'text-green-400'],
                    };
                @endphp
                <div class="p-3 rounded-lg border {{ $isUnlocked ? $stageColor['bg'] . ' ' . $stageColor['border'] : 'bg-[#0f0f0f] border-[#2a2a2a]' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xl font-bold {{ $isUnlocked ? $stageColor['text'] : 'text-silver-400' }}">Day {{ $day }}</span>
                        @if($isUnlocked)
                            <svg class="w-5 h-5 {{ $stageColor['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400">
                        @if($isUnlocked)
                            Unlocked!
                        @elseif($daysUntil == 0)
                            Available Today!
                        @else
                            {{ $daysUntil }} days to go
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @if(!$todayLog)
            <a href="{{ route('dashboard.tracker') }}" class="block p-4 bg-gradient-to-br from-silver-600 to-silver-700 rounded-lg hover:from-silver-500 hover:to-silver-600 transition-all shadow-md hover-glow animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <div>
                        <div class="text-white font-semibold text-sm">Log Metrics</div>
                        <div class="text-silver-200 text-xs">Track today's progress</div>
                    </div>
                </div>
            </a>
        @endif

        <a href="{{ route('dashboard.progress') }}" class="block p-4 bg-gradient-to-br from-[#0f0f0f] to-[#141414] border border-[#2a2a2a] rounded-lg hover:border-silver-700 transition-all hover-glow animate-fade-in {{ $todayLog ? '' : 'delay-100' }}">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-silver-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <div>
                    <div class="text-silver-300 font-semibold text-sm">View Progress</div>
                    <div class="text-gray-400 text-xs">See your transformation</div>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.community') }}" class="block p-4 bg-gradient-to-br from-[#0f0f0f] to-[#141414] border border-[#2a2a2a] rounded-lg hover:border-silver-700 transition-all hover-glow animate-fade-in delay-200">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-silver-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div>
                    <div class="text-silver-300 font-semibold text-sm">Community</div>
                    <div class="text-gray-400 text-xs">Resources & support</div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
