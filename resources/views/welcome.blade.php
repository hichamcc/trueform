<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>True Form Elite - 90 Day Transformation</title>
    <meta name="description" content="Transform your wellness in 90 days. Track energy, focus, sleep, gut health, and skin glow with our premium dashboard.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#0a0a0a] text-silver-100">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0a0a0a]/80 backdrop-blur-lg border-b border-silver-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <x-logo width="160" height="48" />
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 text-silver-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Desktop Auth Links -->
                @if (Route::has('login'))
                    <div class="hidden lg:flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-silver-100 hover:text-white transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-medium text-silver-300 hover:text-white transition-colors">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-semibold text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 hover:from-silver-50 hover:to-silver-200 rounded-lg shadow-lg transition-all duration-300 hover:shadow-silver-500/20">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        <!-- Mobile Menu -->
        @if (Route::has('login'))
            <div id="mobile-menu" class="hidden lg:hidden border-t border-silver-900/30 bg-[#0a0a0a]">
                <div class="px-4 py-4 space-y-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2.5 text-sm font-medium text-silver-100 hover:bg-silver-900/20 rounded-lg transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm font-medium text-silver-300 hover:bg-silver-900/20 rounded-lg transition-colors">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm font-semibold text-center text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 rounded-lg">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        @endif
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16 lg:pt-20">
        <!-- Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#1a1a2e]/50 via-[#0a0a0a] to-[#16213e]/30"></div>

        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-64 lg:w-96 h-64 lg:h-96 bg-silver-600/5 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 lg:w-96 h-64 lg:h-96 bg-silver-500/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 mb-8 bg-silver-900/30 border border-silver-800/50 rounded-full">
                <span class="text-sm font-medium text-silver-300">Elite Performance Tracking System</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight px-4">
                <span class="bg-gradient-to-r from-silver-50 via-silver-200 to-silver-50 bg-clip-text text-transparent">
                    Your Complete
                </span>
                <br>
                <span class="bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent">
                    Transformation System
                </span>
            </h1>

            <!-- Subheadline -->
            <p class="text-lg sm:text-xl md:text-2xl text-silver-400 mb-8 lg:mb-12 max-w-3xl mx-auto leading-relaxed px-4">
                A premium, data-driven platform designed for elite performers. Track, measure, and optimize your Energy, Focus, Sleep, Gut Health, and Glow with precision analytics.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12 lg:mb-16 px-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-center text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 hover:from-silver-50 hover:to-silver-200 rounded-xl shadow-2xl transition-all duration-300 hover:shadow-silver-500/30 hover:scale-105">
                        Begin Elite Transformation
                    </a>
                @endif
                <a href="#how-it-works" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-center text-silver-100 border-2 border-silver-700 hover:border-silver-500 rounded-xl transition-all duration-300 hover:bg-silver-900/20">
                    See How It Works
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="bg-[#1a1a2e]/50 border border-silver-900/30 rounded-2xl p-6 backdrop-blur-sm">
                    <div class="text-4xl font-bold bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent mb-2">360</div>
                    <div class="text-silver-400 font-medium">Day Elite Journey</div>
                </div>
                <div class="bg-[#1a1a2e]/50 border border-silver-900/30 rounded-2xl p-6 backdrop-blur-sm">
                    <div class="text-4xl font-bold bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent mb-2">3</div>
                    <div class="text-silver-400 font-medium">Progressive Stages</div>
                </div>
                <div class="bg-[#1a1a2e]/50 border border-silver-900/30 rounded-2xl p-6 backdrop-blur-sm">
                    <div class="text-4xl font-bold bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent mb-2">8</div>
                    <div class="text-silver-400 font-medium">Achievement Milestones</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Three-Stage Elite System Section -->
    <section id="how-it-works" class="py-20 bg-gradient-to-b from-[#0a0a0a] to-[#1a1a2e]/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent">
                        Three-Stage Elite System
                    </span>
                </h2>
                <p class="text-xl text-silver-400 max-w-2xl mx-auto">
                    From Foundation to Mastery — a progressive transformation system designed for long-term excellence
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Stage 1: Foundation -->
                    <div class="relative">
                        <div class="bg-[#1a1a2e] border border-green-600/30 rounded-2xl p-8 h-full">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mb-6 text-[#0a0a0a] font-bold text-xl">
                                1
                            </div>
                            <h3 class="text-xl font-bold text-silver-100 mb-3">Foundation</h3>
                            <p class="text-sm text-green-400 mb-2">Days 0-90</p>
                            <p class="text-silver-400">Build your baseline. Track daily metrics and unlock milestones at Day 30, 60, and 90.</p>
                        </div>
                    </div>

                    <!-- Stage 2: Expansion -->
                    <div class="relative">
                        <div class="bg-[#1a1a2e] border border-blue-600/30 rounded-2xl p-8 h-full">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-6 text-[#0a0a0a] font-bold text-xl">
                                2
                            </div>
                            <h3 class="text-xl font-bold text-silver-100 mb-3">Expansion</h3>
                            <p class="text-sm text-blue-400 mb-2">Days 90-180</p>
                            <p class="text-silver-400">Elite Life Program unlocks. Achieve sustained excellence with Day 120, 150, 180 milestones.</p>
                        </div>
                    </div>

                    <!-- Stage 3: Mastery -->
                    <div class="relative">
                        <div class="bg-[#1a1a2e] border border-yellow-600/30 rounded-2xl p-8 h-full">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mb-6 text-[#0a0a0a] font-bold text-xl">
                                3
                            </div>
                            <h3 class="text-xl font-bold text-silver-100 mb-3">Mastery</h3>
                            <p class="text-sm text-yellow-400 mb-2">Days 180-360</p>
                            <p class="text-silver-400">Elite Life 360 activates. Complete transformation with Day 270 and 360 gold-tier achievements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Track Section -->
    <section class="py-20 bg-gradient-to-b from-[#1a1a2e]/20 to-[#0a0a0a]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent">
                        Five Performance Metrics
                    </span>
                </h2>
                <p class="text-xl text-silver-400 max-w-2xl mx-auto">
                    Elite-level tracking of the metrics that drive peak performance and longevity
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Energy -->
                <div class="group bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8 hover:border-silver-700/50 transition-all duration-300 hover:shadow-xl hover:shadow-silver-900/20 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-silver-100 mb-3">Energy Levels</h3>
                    <p class="text-silver-400">Track your daily vitality and physical stamina throughout the day.</p>
                </div>

                <!-- Focus -->
                <div class="group bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8 hover:border-silver-700/50 transition-all duration-300 hover:shadow-xl hover:shadow-silver-900/20 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-silver-100 mb-3">Mental Focus</h3>
                    <p class="text-silver-400">Monitor your concentration and mental clarity for peak performance.</p>
                </div>

                <!-- Sleep -->
                <div class="group bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8 hover:border-silver-700/50 transition-all duration-300 hover:shadow-xl hover:shadow-silver-900/20 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500/20 to-blue-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-silver-100 mb-3">Sleep Quality</h3>
                    <p class="text-silver-400">Measure your rest and recovery for optimal wellness.</p>
                </div>

                <!-- Gut Health -->
                <div class="group bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8 hover:border-silver-700/50 transition-all duration-300 hover:shadow-xl hover:shadow-silver-900/20 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-silver-100 mb-3">Gut Health</h3>
                    <p class="text-silver-400">Track your digestive wellness and microbiome balance.</p>
                </div>

                <!-- Skin Glow -->
                <div class="group bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8 hover:border-silver-700/50 transition-all duration-300 hover:shadow-xl hover:shadow-silver-900/20 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-silver-100 mb-3">Skin Glow</h3>
                    <p class="text-silver-400">Monitor your skin health and natural radiance over time.</p>
                </div>

                <!-- Mito-Age Score -->
                <div class="group bg-gradient-to-br from-[#1a1a2e] to-[#16213e] border border-silver-800/50 rounded-2xl p-8 hover:border-silver-600/50 transition-all duration-300 hover:shadow-xl hover:shadow-silver-900/30 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-gradient-to-br from-silver-400/20 to-silver-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-silver-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-silver-100 mb-3">Mito-Age Score</h3>
                    <p class="text-silver-400">Your comprehensive wellness score calculated from all five metrics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-[#0a0a0a]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent">
                        Premium Dashboard Features
                    </span>
                </h2>
                <p class="text-xl text-silver-400 max-w-2xl mx-auto">
                    Everything you need to track and visualize your transformation
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Real-Time Progress -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-10">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-9 h-9 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-silver-100 mb-3">Real-Time Progress</h3>
                            <p class="text-silver-400 leading-relaxed">Watch your Mito-Age Score evolve with color-coded charts showing percentage improvements across all metrics.</p>
                        </div>
                    </div>
                </div>

                <!-- Milestone Rewards -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-10">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-9 h-9 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-silver-100 mb-3">Milestone Rewards</h3>
                            <p class="text-silver-400 leading-relaxed">Automatically unlock achievement badges and rewards at Day 30, 60, and 90 milestones.</p>
                        </div>
                    </div>
                </div>

                <!-- Visual Analytics -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-10">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-9 h-9 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-silver-100 mb-3">Visual Analytics</h3>
                            <p class="text-silver-400 leading-relaxed">Beautiful charts and graphs show your baseline vs. current metrics with intelligent insights.</p>
                        </div>
                    </div>
                </div>

                <!-- Daily Tracking -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-10">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-9 h-9 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-silver-100 mb-3">Daily Tracking</h3>
                            <p class="text-silver-400 leading-relaxed">Quick and easy daily logging with optional notes to capture your journey in detail.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gradient-to-b from-[#0a0a0a] to-[#1a1a2e]/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent">
                        Transformation Stories
                    </span>
                </h2>
                <p class="text-xl text-silver-400 max-w-2xl mx-auto">
                    See what True Form Elite members are achieving
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-silver-300 mb-6 leading-relaxed">"The Mito-Age Score changed everything. Seeing my progress in real numbers kept me motivated through the entire 90 days."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-silver-300 to-silver-500 rounded-full flex items-center justify-center text-[#0a0a0a] font-bold">
                            SM
                        </div>
                        <div>
                            <div class="font-semibold text-silver-100">Sarah M.</div>
                            <div class="text-sm text-silver-500">Day 90 Graduate</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-silver-300 mb-6 leading-relaxed">"Finally, a wellness tracker that understands what really matters. The dashboard is beautiful and incredibly intuitive."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-silver-300 to-silver-500 rounded-full flex items-center justify-center text-[#0a0a0a] font-bold">
                            JD
                        </div>
                        <div>
                            <div class="font-semibold text-silver-100">James D.</div>
                            <div class="text-sm text-silver-500">Active Member</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-[#1a1a2e] border border-silver-900/30 rounded-2xl p-8">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-silver-300 mb-6 leading-relaxed">"My energy levels went from 4 to 9 in just 60 days. The milestone rewards kept me engaged and celebrating wins."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-silver-300 to-silver-500 rounded-full flex items-center justify-center text-[#0a0a0a] font-bold">
                            ML
                        </div>
                        <div>
                            <div class="font-semibold text-silver-100">Maria L.</div>
                            <div class="text-sm text-silver-500">Day 60 Achiever</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 bg-gradient-to-b from-[#1a1a2e]/20 to-[#0a0a0a]">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] border border-silver-800/50 rounded-3xl p-12 lg:p-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span class="bg-gradient-to-r from-silver-50 to-silver-300 bg-clip-text text-transparent">
                        Ready to Transform?
                    </span>
                </h2>
                <p class="text-xl text-silver-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Join the elite. Begin your journey from Foundation to Mastery. Track, measure, and optimize your way to peak performance over 360 transformative days.
                </p>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-block px-10 py-5 text-lg font-bold text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 hover:from-silver-50 hover:to-silver-200 rounded-xl shadow-2xl transition-all duration-300 hover:shadow-silver-500/30 hover:scale-105">
                        Join True Form Elite
                    </a>
                @endif

                <p class="mt-8 text-sm text-silver-500">
                    Elite performance tracking • Data-driven insights • Progressive 3-stage system
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-[#0a0a0a] border-t border-silver-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <x-logo width="180" height="54" class="mb-2 mx-auto md:mx-0" />
                    <p class="text-silver-500 text-sm">Your premium wellness transformation platform</p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-8 text-sm text-silver-500">
                    <a href="mailto:support@trueform.com" class="hover:text-silver-300 transition-colors">Support</a>
                    <span class="hidden sm:inline">•</span>
                    <span>&copy; {{ date('Y') }} True Form Elite</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton?.contains(e.target) && !mobileMenu?.contains(e.target)) {
                mobileMenu?.classList.add('hidden');
            }
        });

        // Close mobile menu on navigation
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu?.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
