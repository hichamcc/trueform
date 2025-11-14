<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: #e0e0e0;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen">
    <div class="flex h-screen bg-[#0a0a0a]">
        <!-- Mobile Menu Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static w-64 bg-gradient-to-b from-[#141414] to-[#0f0f0f] border-r border-[#2a2a2a] h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-3">
                    <x-logo-icon size="40" />
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-silver-400 to-silver-200 bg-clip-text text-transparent">
                            True Form Elite
                        </h1>
                        <p class="text-xs text-gray-400">360-Day Journey</p>
                    </div>
                </div>
                @if(auth()->user()->programEnrollment)
                    @php
                        $enrollment = auth()->user()->programEnrollment;
                        $currentStageNum = $enrollment->getCurrentStage();
                        $stageInfo = $enrollment->getStageTheme();
                    @endphp
                    <div class="mt-3 px-3 py-2 rounded-lg {{ $currentStageNum == 1 ? 'glass-green' : ($currentStageNum == 2 ? 'glass-blue' : 'glass-gold') }}">
                        <div class="text-xs {{ $stageInfo['text'] ?? 'text-green-400' }} font-semibold">
                            Stage {{ $currentStageNum }}: {{ $enrollment->getStageName() }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            Day {{ $enrollment->getCurrentDay() }} of 360
                        </div>
                    </div>
                @endif
            </div>

            <nav class="px-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('dashboard.my-profile') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard.my-profile') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    My Transformation
                </a>

                <a href="{{ route('dashboard.tracker') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard.tracker') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Tracker
                </a>

                <a href="{{ route('dashboard.progress') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard.progress') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Progress & Milestones
                </a>

                <a href="{{ route('dashboard.community') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard.community') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Community & Support
                </a>

                <a href="{{ route('dashboard.guarantee-faq') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard.guarantee-faq') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Guarantee & FAQ
                </a>

                <div class="mt-6 pt-4 border-t border-[#2a2a3e]">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Personal</p>
                    <a href="{{ route('dashboard.referral') }}"
                       class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard.referral') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                        Referral Program
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center px-4 py-3 rounded-lg transition-all {{ request()->routeIs('profile.edit') ? 'bg-silver-900/20 text-silver-300 border-l-4 border-silver-400' : 'text-gray-400 hover:bg-gray-800/50 hover:text-silver-300' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </div>
            </nav>

            <!-- User Section -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-[#2a2a3e]">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-silver-400 to-silver-600 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-300">{{ auth()->user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-gray-500 hover:text-silver-400 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-[#141414]/80 backdrop-blur-sm border-b border-[#2a2a2a] sticky top-0 z-10">
                <div class="px-4 lg:px-8 py-4 flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 text-silver-400 hover:text-silver-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl font-semibold text-silver-200">@yield('page-title', 'Dashboard')</h2>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-900/20 border border-green-500/50 rounded-lg text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-900/20 border border-red-500/50 rounded-lg text-red-300">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')

    <!-- Mobile Menu Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        const menuBtn = document.getElementById('mobile-menu-btn');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        menuBtn?.addEventListener('click', toggleMenu);
        overlay?.addEventListener('click', toggleMenu);

        // Close menu on navigation (mobile only)
        if (window.innerWidth < 1024) {
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            });
        }
    </script>
</body>
</html>
