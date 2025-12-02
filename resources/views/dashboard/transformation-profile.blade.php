@extends('layouts.dashboard')

@section('title', 'My Transformation Profile')
@section('page-title', 'My Transformation Profile')

@section('content')
<div class="space-y-4">
    <!-- Hero Section with Tier Badge and Tagline -->
    <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-lg p-5 border border-[#2a2a2a] relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-full blur-3xl"></div>
        </div>

        <div class="relative">
            <!-- Tier Badge -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
                <div class="text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r {{ $tierBadge['gradient'] }} rounded-lg shadow-lg mb-3">
                        <span class="text-2xl">{{ $tierBadge['icon'] }}</span>
                        <div>
                            <div class="text-white font-bold text-base">{{ $tierBadge['name'] }}</div>
                            <div class="text-white/80 text-xs">Day {{ $currentDay }} of 360</div>
                        </div>
                    </div>

                    <!-- Dynamic Tagline -->
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent mb-1">
                        {{ $user->name }}
                    </h2>
                    <p class="text-lg {{ $overallImprovement > 0 ? 'text-green-400' : ($overallImprovement < 0 ? 'text-yellow-400' : 'text-silver-400') }} font-semibold">
                        {{ $dynamicTagline }}
                    </p>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-[#1a1a2e] rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-silver-200">{{ $totalLogs }}</div>
                        <div class="text-xs text-silver-500 mt-1">Total Logs</div>
                    </div>
                    <div class="bg-[#1a1a2e] rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-orange-400">{{ $currentStreak }}</div>
                        <div class="text-xs text-silver-500 mt-1">Day Streak</div>
                    </div>
                    <div class="bg-[#1a1a2e] rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-green-400">{{ $milestones->count() }}</div>
                        <div class="text-xs text-silver-500 mt-1">Unlocked</div>
                    </div>
                    <div class="bg-[#1a1a2e] rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-silver-300">{{ $daysRemaining }}</div>
                        <div class="text-xs text-silver-500 mt-1">Days Left</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mito-Age Score Comparison -->
    @if($baseline && $currentAverages)
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a]">
            <h3 class="text-lg font-bold text-silver-200 mb-4">Mito-Age Score Evolution</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Baseline -->
                <div class="text-center p-4 bg-[#0f0f0f] rounded-lg border border-[#2a2a2a]">
                    <p class="text-xs text-silver-500 mb-1">Baseline (Start)</p>
                    <div class="text-4xl font-bold text-silver-400 mb-1">{{ number_format($baseline->mito_age_score, 1) }}</div>
                    <p class="text-xs text-silver-600">Starting Point</p>
                </div>

                <!-- Current -->
                <div class="text-center p-4 bg-gradient-to-br from-[#16213e] to-[#1a1a2e] rounded-lg border {{ $overallImprovement > 0 ? 'border-green-500/50' : 'border-silver-900/30' }}">
                    <p class="text-xs text-silver-300 mb-1">Current (Last 7 Days)</p>
                    <div class="text-4xl font-bold {{ $overallImprovement > 0 ? 'text-green-400' : 'text-silver-300' }} mb-1">
                        {{ number_format($currentAverages['mito_age_score'], 1) }}
                    </div>
                    <p class="text-xs {{ $overallImprovement > 0 ? 'text-green-400' : 'text-silver-600' }}">
                        {{ $overallImprovement > 0 ? '+' : '' }}{{ $overallImprovement }}% vs Baseline
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Metric Breakdown -->
    @if($baseline && $currentAverages)
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a]">
            <h3 class="text-lg font-bold text-silver-200 mb-4">Metric Breakdown (7-Day Average)</h3>

            <div class="space-y-3">
                @foreach(['energy' => 'Energy', 'focus' => 'Focus', 'sleep' => 'Sleep', 'gut_health' => 'Gut Health'] as $key => $label)
                    @php
                        $baselineVal = $baseline->$key;
                        $currentVal = $currentAverages[$key];
                        $change = (($currentVal - $baselineVal) / $baselineVal) * 100;
                        $isStrongest = $key === $strongestMetric;
                        $isWeakest = $key === $weakestMetric;
                    @endphp

                    <div class="p-3 rounded-lg {{ $isStrongest ? 'bg-green-900/20 border border-green-500/30' : ($isWeakest ? 'bg-red-900/20 border border-red-500/30' : 'bg-[#0f0f0f] border border-[#2a2a2a]') }}">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-silver-200">{{ $label }}</span>
                                @if($isStrongest)
                                    <span class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">STRONGEST</span>
                                @endif
                                @if($isWeakest)
                                    <span class="px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded">FOCUS AREA</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold {{ $change > 0 ? 'text-green-400' : ($change < 0 ? 'text-red-400' : 'text-silver-400') }}">
                                    {{ number_format($currentVal, 1) }}
                                </div>
                                <div class="text-xs text-silver-500">from {{ number_format($baselineVal, 1) }}</div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="relative w-full h-1.5 bg-[#2a2a2a] rounded-full overflow-hidden">
                            <div class="absolute h-full {{ $change > 0 ? 'bg-green-500' : ($change < 0 ? 'bg-red-500' : 'bg-silver-500') }} rounded-full transition-all"
                                 style="width: {{ min(100, ($currentVal / 10) * 100) }}%"></div>
                        </div>

                        <div class="mt-1 text-right">
                            <span class="text-xs {{ $change > 0 ? 'text-green-400' : ($change < 0 ? 'text-red-400' : 'text-silver-500') }}">
                                {{ $change > 0 ? '+' : '' }}{{ number_format($change, 1) }}%
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Before/After Photo Comparison -->
    @if($baseline)
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a]">
            <h3 class="text-lg font-bold text-silver-200 mb-4">Transformation Photos</h3>

            @if(($baseline->photo || $baseline->image) && $user->current_photo)
                <!-- Before/After Slider Comparison -->
                <div class="mb-4">
                    <div class="relative w-full aspect-square max-w-2xl mx-auto rounded-lg overflow-hidden border border-[#2a2a2a] shadow-lg select-none" id="comparison-slider">
                        <!-- After Image (Background - Right Side) -->
                        <img src="{{ asset('storage/' . $user->current_photo) }}"
                             alt="Current Photo"
                             class="absolute inset-0 w-full h-full object-cover">

                        <!-- Before Image (Overlay - Left Side) -->
                        <div class="absolute inset-0 w-full h-full overflow-hidden" id="before-image-container" style="clip-path: inset(0 50% 0 0);">
                            <img src="{{ asset('storage/' . ($baseline->photo ?? $baseline->image)) }}"
                                 alt="Before Photo"
                                 class="absolute inset-0 w-full h-full object-cover">
                        </div>

                        <!-- Labels -->
                        <div class="absolute top-3 left-3 px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded shadow-lg pointer-events-none z-10">
                            Day 1 - Before
                        </div>
                        <div class="absolute top-3 right-3 px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded shadow-lg pointer-events-none z-10">
                            Day {{ $currentDay }} - After
                        </div>

                        <!-- Slider Handle -->
                        <div class="absolute top-0 bottom-0 w-1 bg-white cursor-ew-resize z-20" id="slider-handle" style="left: 50%;">
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Drag the slider left or right to compare • Day 1 (left) vs Day {{ $currentDay }} (right)</p>
                </div>

                <!-- Progress Indicator -->
                <div class="p-3 bg-green-900/20 border border-green-500/30 rounded-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-xs text-green-300 font-semibold">Visual transformation tracked!</p>
                            <p class="text-xs text-green-400/80">Compare your progress from Day 1 to Day {{ $currentDay }}</p>
                        </div>
                    </div>
                </div>

                <!-- Upload Current Photo Form (Update) -->
                <form action="{{ route('dashboard.tracker.current-photo') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-2 bg-[#0f0f0f] rounded-lg p-3 border border-[#2a2a2a]">
                    @csrf
                    <div>
                        <label for="current_photo" class="block text-xs font-medium text-silver-300 mb-1">
                            Update Current Photo
                        </label>
                        <input type="file"
                               id="current_photo"
                               name="current_photo"
                               accept="image/*"
                               class="w-full px-3 py-1.5 bg-[#0a0a0a] border border-[#2a2a2a] rounded text-silver-300 text-xs focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @error('current_photo')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white rounded transition font-semibold text-xs">
                        Update Photo
                    </button>
                </form>
            @else
                <!-- Missing Photos - Upload Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Before Photo Upload -->
                    @if(!($baseline->photo || $baseline->image))
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-silver-300">Before Photo</h4>
                            <div class="w-full h-64 bg-[#0f0f0f] rounded-lg border-2 border-dashed border-[#2a2a2a] flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 text-xs mb-2">No baseline photo uploaded</p>
                                <a href="{{ route('dashboard.tracker') }}" class="text-blue-400 hover:text-blue-300 text-xs">
                                    Upload in Tracker →
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-silver-300">Before Photo</h4>
                            <div class="relative">
                                <img src="{{ asset('storage/' . ($baseline->photo ?? $baseline->image)) }}"
                                     alt="Before Photo"
                                     class="w-full h-64 object-cover rounded-lg border border-[#2a2a2a] shadow-lg">
                                <div class="absolute top-2 left-2 px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded">
                                    Day 1 - Before
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- After Photo Upload -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-semibold text-silver-300">Current Photo</h4>
                        @if(!$user->current_photo)
                            <div class="w-full h-64 bg-[#0f0f0f] rounded-lg border-2 border-dashed border-[#2a2a2a] flex flex-col items-center justify-center mb-3">
                                <svg class="w-12 h-12 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 text-xs mb-3">No current photo uploaded</p>
                            </div>
                        @endif

                        <!-- Upload Form -->
                        <form action="{{ route('dashboard.tracker.current-photo') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <div>
                                <label for="current_photo" class="block text-xs font-medium text-silver-300 mb-1">
                                    {{ $user->current_photo ? 'Update' : 'Upload' }} Current Photo
                                </label>
                                <input type="file"
                                       id="current_photo"
                                       name="current_photo"
                                       accept="image/*"
                                       class="w-full px-3 py-1.5 bg-[#0f0f0f] border border-[#2a2a2a] rounded text-silver-300 text-xs focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('current_photo')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="w-full px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white rounded transition font-semibold text-xs">
                                {{ $user->current_photo ? 'Update Photo' : 'Upload Photo' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Slider JavaScript -->
        @if(($baseline->photo || $baseline->image) && $user->current_photo)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.getElementById('comparison-slider');
                const handle = document.getElementById('slider-handle');
                const beforeImageContainer = document.getElementById('before-image-container');

                let isDragging = false;

                function updateSlider(x) {
                    const rect = slider.getBoundingClientRect();
                    const position = Math.max(0, Math.min(x - rect.left, rect.width));
                    const percentage = (position / rect.width) * 100;

                    handle.style.left = percentage + '%';
                    // Clip before image from the right to show only the left portion
                    beforeImageContainer.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
                }

                // Mouse events
                handle.addEventListener('mousedown', function(e) {
                    isDragging = true;
                    e.preventDefault();
                });

                document.addEventListener('mousemove', function(e) {
                    if (!isDragging) return;
                    updateSlider(e.clientX);
                });

                document.addEventListener('mouseup', function() {
                    isDragging = false;
                });

                // Click anywhere on slider to move handle
                slider.addEventListener('click', function(e) {
                    if (e.target === handle || handle.contains(e.target)) return;
                    updateSlider(e.clientX);
                });

                // Touch events for mobile
                handle.addEventListener('touchstart', function(e) {
                    isDragging = true;
                    e.preventDefault();
                });

                document.addEventListener('touchmove', function(e) {
                    if (!isDragging) return;
                    const touch = e.touches[0];
                    updateSlider(touch.clientX);
                });

                document.addEventListener('touchend', function() {
                    isDragging = false;
                });
            });
        </script>
        @endif
    @endif

    <!-- Product Recommendations (Based on Weakest Metric) -->
    @if($weakestMetric)
        <div class="bg-gradient-to-br from-[#16213e] to-[#1a1a2e] rounded-lg p-4 border border-silver-900/30">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-full bg-blue-600/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-silver-200">Recommended Products</h3>
                    <p class="text-xs text-silver-400">For improving your <strong>{{ ucwords(str_replace('_', ' ', $weakestMetric)) }}</strong></p>
                </div>
            </div>

            @if($recommendations->count() > 0)
                <div class="space-y-3">
                    @foreach($recommendations as $recommendation)
                        <div class="bg-[#0f0f0f] rounded-lg p-3 border border-silver-900/30 hover:border-blue-500/30 transition-all">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-silver-200 mb-1">{{ $recommendation->product_name }}</h4>
                                    @if($recommendation->description)
                                        <p class="text-xs text-silver-400 mb-2">{{ $recommendation->description }}</p>
                                    @endif
                                </div>
                                @if($recommendation->product_link)
                                    <a href="{{ $recommendation->product_link }}"
                                       target="_blank"
                                       class="flex-shrink-0 px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded transition-all flex items-center gap-1">
                                        View
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-[#0f0f0f] rounded-lg p-4 border border-silver-900/30 text-center">
                    <svg class="w-10 h-10 text-silver-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-silver-400 text-xs">
                        No specific product recommendations available yet for <strong>{{ ucwords(str_replace('_', ' ', $weakestMetric)) }}</strong>.
                    </p>
                    <a href="{{ route('dashboard.community') }}" class="inline-flex items-center mt-3 px-3 py-1.5 bg-silver-600 hover:bg-silver-500 text-white rounded transition text-xs">
                        Explore Resources →
                    </a>
                </div>
            @endif
        </div>
    @endif

    <!-- Upgrade/Extend Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Extend 30 Days -->
        <a href="#" class="block group bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-lg p-4 border border-silver-900/30 hover:border-silver-700 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-8 h-8 rounded-lg bg-green-600/20 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <span class="px-2 py-0.5 bg-green-600/20 text-green-400 rounded-full text-xs font-semibold">EXTEND</span>
            </div>
            <h3 class="text-base font-bold text-silver-200 mb-1">Extend 30 Days</h3>
            <p class="text-silver-400 text-xs mb-3">Continue your transformation journey with another month of tracking and optimization.</p>
            <div class="text-green-400 text-xs font-semibold flex items-center">
                Learn More →
            </div>
        </a>

        <!-- Upgrade to Elite Life -->
        <a href="#" class="block group bg-gradient-to-br from-blue-900/30 to-purple-900/30 rounded-lg p-4 border border-blue-500/30 hover:border-blue-400 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="px-2 py-0.5 bg-blue-600/20 text-blue-400 rounded-full text-xs font-semibold">PREMIUM</span>
            </div>
            <h3 class="text-base font-bold text-silver-200 mb-1">Upgrade to Elite Life</h3>
            <p class="text-silver-400 text-xs mb-3">Unlock the full 360-day Elite Life Program with advanced tracking and exclusive rewards.</p>
            <div class="text-blue-400 text-xs font-semibold flex items-center">
                Upgrade Now →
            </div>
        </a>
    </div>

    <!-- Recent Milestones -->
    @if($milestones->count() > 0)
        <div class="bg-[#141414] rounded-lg p-4 border border-[#2a2a2a]">
            <h3 class="text-lg font-bold text-silver-200 mb-4">Achievement History</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($milestones as $milestone)
                    <div class="text-center p-3 bg-[#0f0f0f] rounded-lg border border-silver-900/30">
                        <div class="text-2xl mb-1">🏆</div>
                        <div class="text-sm font-bold text-silver-200">Day {{ $milestone->milestone_day }}</div>
                        <div class="text-xs text-silver-500 mt-1">{{ $milestone->unlocked_at->format('M d, Y') }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
