<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>True Form Elite Logo Preview</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0a] text-silver-100 p-8">
    <div class="max-w-6xl mx-auto space-y-12">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-silver-100 to-silver-400 bg-clip-text text-transparent mb-4">
                True Form Elite Logo System
            </h1>
            <p class="text-silver-400">SVG logo components for the True Form Elite brand</p>
        </div>

        <!-- Full Logo Variations -->
        <section class="bg-[#141414] rounded-2xl p-8 border border-[#2a2a2a]">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Full Logo</h2>
            <div class="space-y-8">
                <div>
                    <p class="text-sm text-silver-500 mb-4">Default Size (200x60)</p>
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo />
                    </div>
                    <code class="block mt-2 text-xs text-silver-600">&lt;x-logo /&gt;</code>
                </div>

                <div>
                    <p class="text-sm text-silver-500 mb-4">Large Size (300x90)</p>
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo width="300" height="90" />
                    </div>
                    <code class="block mt-2 text-xs text-silver-600">&lt;x-logo width="300" height="90" /&gt;</code>
                </div>

                <div>
                    <p class="text-sm text-silver-500 mb-4">Compact Size (160x48)</p>
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo width="160" height="48" />
                    </div>
                    <code class="block mt-2 text-xs text-silver-600">&lt;x-logo width="160" height="48" /&gt;</code>
                </div>
            </div>
        </section>

        <!-- Icon Only Variations -->
        <section class="bg-[#141414] rounded-2xl p-8 border border-[#2a2a2a]">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Icon Only</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo-icon size="32" />
                    </div>
                    <p class="text-xs text-silver-600 mt-2">32x32</p>
                    <code class="text-xs text-silver-600">size="32"</code>
                </div>

                <div class="text-center">
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo-icon size="48" />
                    </div>
                    <p class="text-xs text-silver-600 mt-2">48x48 (Default)</p>
                    <code class="text-xs text-silver-600">size="48"</code>
                </div>

                <div class="text-center">
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo-icon size="64" />
                    </div>
                    <p class="text-xs text-silver-600 mt-2">64x64</p>
                    <code class="text-xs text-silver-600">size="64"</code>
                </div>

                <div class="text-center">
                    <div class="bg-[#0a0a0a] rounded-xl p-6 inline-block">
                        <x-logo-icon size="96" />
                    </div>
                    <p class="text-xs text-silver-600 mt-2">96x96</p>
                    <code class="text-xs text-silver-600">size="96"</code>
                </div>
            </div>
        </section>

        <!-- Text Only Variations -->
        <section class="bg-[#141414] rounded-2xl p-8 border border-[#2a2a2a]">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Text Only</h2>
            <div class="space-y-6">
                <div class="flex items-center gap-6">
                    <div class="bg-[#0a0a0a] rounded-xl p-6">
                        <x-logo-text size="xs" />
                    </div>
                    <code class="text-xs text-silver-600">&lt;x-logo-text size="xs" /&gt;</code>
                </div>

                <div class="flex items-center gap-6">
                    <div class="bg-[#0a0a0a] rounded-xl p-6">
                        <x-logo-text size="sm" />
                    </div>
                    <code class="text-xs text-silver-600">&lt;x-logo-text size="sm" /&gt;</code>
                </div>

                <div class="flex items-center gap-6">
                    <div class="bg-[#0a0a0a] rounded-xl p-6">
                        <x-logo-text size="base" />
                    </div>
                    <code class="text-xs text-silver-600">&lt;x-logo-text size="base" /&gt;</code>
                </div>

                <div class="flex items-center gap-6">
                    <div class="bg-[#0a0a0a] rounded-xl p-6">
                        <x-logo-text size="lg" />
                    </div>
                    <code class="text-xs text-silver-600">&lt;x-logo-text size="lg" /&gt;</code>
                </div>

                <div class="flex items-center gap-6">
                    <div class="bg-[#0a0a0a] rounded-xl p-6">
                        <x-logo-text size="xl" />
                    </div>
                    <code class="text-xs text-silver-600">&lt;x-logo-text size="xl" /&gt;</code>
                </div>

                <div class="flex items-center gap-6">
                    <div class="bg-[#0a0a0a] rounded-xl p-6">
                        <x-logo-text size="2xl" />
                    </div>
                    <code class="text-xs text-silver-600">&lt;x-logo-text size="2xl" /&gt;</code>
                </div>
            </div>
        </section>

        <!-- Combined Usage Examples -->
        <section class="bg-[#141414] rounded-2xl p-8 border border-[#2a2a2a]">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Combined Usage Examples</h2>

            <!-- Navigation Bar -->
            <div class="mb-8">
                <p class="text-sm text-silver-500 mb-4">Navigation Bar</p>
                <div class="bg-[#0a0a0a]/80 backdrop-blur-lg border border-silver-900/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <x-logo width="160" height="48" />
                        <div class="flex gap-4">
                            <button class="px-4 py-2 text-silver-300 hover:text-white">Login</button>
                            <button class="px-6 py-2 bg-silver-600 hover:bg-silver-500 text-white rounded-lg">Get Started</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="mb-8">
                <p class="text-sm text-silver-500 mb-4">Sidebar Header</p>
                <div class="bg-gradient-to-b from-[#141414] to-[#0f0f0f] border border-[#2a2a2a] rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <x-logo-icon size="40" />
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-silver-400 to-silver-200 bg-clip-text text-transparent">
                                True Form Elite
                            </h1>
                            <p class="text-xs text-gray-400">360-Day Journey</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Header -->
            <div>
                <p class="text-sm text-silver-500 mb-4">Mobile Header (Icon Only)</p>
                <div class="bg-[#0a0a0a] border border-silver-900/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <x-logo-icon size="32" />
                        <button class="text-silver-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Logo Design Elements -->
        <section class="bg-[#141414] rounded-2xl p-8 border border-[#2a2a2a]">
            <h2 class="text-2xl font-bold text-silver-200 mb-6">Design Elements</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-silver-300 mb-3">Symbol Meaning</h3>
                    <ul class="space-y-2 text-sm text-silver-400">
                        <li><strong class="text-silver-200">Outer Circle:</strong> 360-day transformation journey</li>
                        <li><strong class="text-silver-200">Upward Triangle:</strong> Growth and progress</li>
                        <li><strong class="text-silver-200">Central Diamond:</strong> Core strength and balance</li>
                        <li><strong class="text-silver-200">Animated Pulse:</strong> Energy and vitality</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-silver-300 mb-3">Color Palette</h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-gradient-to-r from-[#f0f0f0] to-[#e4e4e4]"></div>
                            <span class="text-sm text-silver-400">Silver Light: #f0f0f0 → #e4e4e4</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-gradient-to-r from-[#d1d1d1] to-[#b4b4b4]"></div>
                            <span class="text-sm text-silver-400">Silver Medium: #d1d1d1 → #b4b4b4</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-gradient-to-r from-[#b4b4b4] to-[#9a9a9a]"></div>
                            <span class="text-sm text-silver-400">Silver Dark: #b4b4b4 → #9a9a9a</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <div class="text-center text-silver-500 text-sm border-t border-[#2a2a2a] pt-8">
            <p>True Form Elite Logo System • Created 2025-11-08</p>
            <p class="mt-2">View <a href="/LOGO_USAGE.md" class="text-silver-300 hover:text-silver-100">LOGO_USAGE.md</a> for implementation guide</p>
        </div>
    </div>
</body>
</html>
