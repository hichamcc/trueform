<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'True Form Elite') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-silver-100">
    <div class="flex min-h-screen">
        <!-- Mobile Menu Overlay -->
        <div id="admin-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="admin-sidebar" class="fixed lg:static w-64 bg-gradient-to-b from-[#1a1a2e] to-[#16213e] border-r border-silver-900/30 flex flex-col h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo / Brand -->
            <div class="p-3 lg:p-6 border-b border-silver-900/30">
                <div class="flex items-center gap-2 lg:gap-3 mb-2">
                    <x-logo-icon size="28" class="lg:w-8 lg:h-8" />
                    <div>
                        <h1 class="text-base lg:text-lg font-bold bg-gradient-to-r from-silver-200 to-silver-400 bg-clip-text text-transparent">
                            Admin Panel
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-silver-500">True Form Elite</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-2 lg:px-4 py-4 lg:py-6 space-y-1 lg:space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-chart-bar class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-users class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Users</span>
                </a>

                <a href="{{ route('admin.programs.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.programs.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-calendar class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Programs</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.analytics.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-chart-line class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Analytics</span>
                </a>

                <a href="{{ route('admin.logs.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.logs.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-clipboard class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Daily Logs</span>
                </a>

                <a href="{{ route('admin.milestones.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.milestones.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-trophy class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Milestones</span>
                </a>

                {{-- Glow Scans - Hidden for now --}}
                {{-- <a href="{{ route('admin.glow-scans.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.glow-scans.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-sparkle class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Glow Scans</span>
                </a> --}}

                <a href="{{ route('admin.exports.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.exports.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-download class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Exports</span>
                </a>

                <a href="{{ route('admin.referrals.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.referrals.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-share-network class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Referrals</span>
                </a>

                <a href="{{ route('admin.recommendations.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.recommendations.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-package class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Product Recommendations</span>
                </a>

                <a href="{{ route('admin.settings.index') }}"
                   class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2 lg:py-3 rounded-lg lg:rounded-xl transition-all text-sm lg:text-base {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white' : 'text-silver-300 hover:bg-silver-900/30' }}">
                    <x-phosphor-gear class="w-4 h-4 lg:w-5 lg:h-5" />
                    <span class="font-medium">Settings & Links</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-[#1a1a2e] border-b border-silver-900/30 px-4 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Menu Button -->
                        <button id="admin-menu-btn" class="lg:hidden p-2 text-silver-400 hover:text-silver-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold text-silver-100">@yield('page-title', 'Admin Panel')</h2>
                            <p class="text-xs lg:text-sm text-silver-500 mt-1">@yield('page-subtitle', '')</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 lg:gap-4">
                        <!-- Admin Badge -->
                        <div class="px-3 py-1 bg-blue-600 rounded-lg">
                            <span class="text-xs font-semibold text-white">ADMIN</span>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-medium text-silver-100">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-silver-500">{{ Auth::user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs lg:text-sm text-silver-400 hover:text-white transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-900/30 border border-green-600/50 rounded-xl text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-900/30 border border-red-600/50 rounded-xl text-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <!-- Mobile Menu Toggle Script -->
    <script>
        const adminSidebar = document.getElementById('admin-sidebar');
        const adminOverlay = document.getElementById('admin-overlay');
        const adminMenuBtn = document.getElementById('admin-menu-btn');

        function toggleAdminMenu() {
            adminSidebar.classList.toggle('-translate-x-full');
            adminOverlay.classList.toggle('hidden');
        }

        adminMenuBtn?.addEventListener('click', toggleAdminMenu);
        adminOverlay?.addEventListener('click', toggleAdminMenu);

        // Close menu on navigation (mobile only)
        if (window.innerWidth < 1024) {
            document.querySelectorAll('#admin-sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    adminSidebar.classList.add('-translate-x-full');
                    adminOverlay.classList.add('hidden');
                });
            });
        }
    </script>
</body>
</html>
