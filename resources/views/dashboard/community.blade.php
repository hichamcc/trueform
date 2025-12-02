@extends('layouts.dashboard')

@section('title', 'Community & Support')
@section('page-title', 'Community & Support')

@section('content')
<div class="space-y-6">
    <!-- Stage Indicator -->
    @if($enrollment)
        <div class="bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-xl p-4 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-semibold">
                        Stage {{ $currentStage }} - {{ $stageName }}
                    </span>
                    <span class="text-white/90 text-sm">Day {{ $enrollment->getCurrentDay() }} of 360</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-2xl p-8 border border-[#2a2a2a]">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-silver-200 to-silver-400 bg-clip-text text-transparent mb-3">
            You're Not Alone on This Journey
        </h2>
        <p class="text-gray-400 text-lg">Connect, share, and grow with the True Form community</p>
    </div>

    <!-- Community Link Card -->
    <div class="max-w-2xl mx-auto">
        @foreach($resources as $resource)
            <a href="{{ $resource['url'] }}"
               class="block group relative overflow-hidden rounded-2xl border transition-all duration-300
                      {{ $resource['type'] === 'primary' ? 'bg-gradient-to-br from-silver-600 to-silver-700 border-silver-500 hover:from-silver-500 hover:to-silver-600 shadow-xl' : ($resource['type'] === 'accent' ? 'bg-gradient-to-br from-purple-900 to-purple-800 border-purple-700 hover:from-purple-800 hover:to-purple-700' : 'bg-[#141414] border-[#2a2a2a] hover:border-silver-700') }}">
                <div class="p-10 text-center">
                    <!-- Icon -->
                    <div class="mb-6 flex justify-center">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center
                                    {{ $resource['type'] === 'primary' ? 'bg-white/20' : ($resource['type'] === 'accent' ? 'bg-purple-700/50' : 'bg-silver-900/30') }}">
                            @if($resource['icon'] === 'sparkles')
                                <svg class="w-8 h-8 {{ $resource['type'] === 'primary' || $resource['type'] === 'accent' ? 'text-white' : 'text-silver-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            @elseif($resource['icon'] === 'document-text')
                                <svg class="w-8 h-8 {{ $resource['type'] === 'primary' || $resource['type'] === 'accent' ? 'text-white' : 'text-silver-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif($resource['icon'] === 'users')
                                <svg class="w-10 h-10 {{ $resource['type'] === 'primary' || $resource['type'] === 'accent' ? 'text-white' : 'text-silver-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            @elseif($resource['icon'] === 'gift')
                                <svg class="w-8 h-8 {{ $resource['type'] === 'primary' || $resource['type'] === 'accent' ? 'text-white' : 'text-silver-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <h3 class="text-2xl font-bold mb-3 {{ $resource['type'] === 'primary' || $resource['type'] === 'accent' ? 'text-white' : 'text-silver-200' }}">
                        {{ $resource['title'] }}
                    </h3>
                    <p class="{{ $resource['type'] === 'primary' ? 'text-silver-100' : ($resource['type'] === 'accent' ? 'text-purple-200' : 'text-gray-400') }}">
                        {{ $resource['description'] }}
                    </p>

                    <!-- Arrow -->
                    <div class="mt-6 flex items-center justify-center {{ $resource['type'] === 'primary' || $resource['type'] === 'accent' ? 'text-white' : 'text-silver-400' }} group-hover:translate-x-2 transition-transform">
                        <span class="mr-2 font-semibold text-lg">Join Now</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>

                <!-- Decorative gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            </a>
        @endforeach
    </div>

    <!-- Inside the TrueForm Elite Community -->
    <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-2xl p-8 border border-[#2a2a2a]">
        <h3 class="text-2xl font-bold bg-gradient-to-r from-silver-200 to-silver-400 bg-clip-text text-transparent mb-6">
            Inside the TrueForm Elite Community
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Item 1 -->
            <div class="flex items-start space-x-4 p-4 bg-[#16213e] rounded-xl hover:bg-[#1a1a2e] transition">
                <div class="w-12 h-12 bg-green-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-silver-200 mb-1">Early Access to New Programs</h4>
                    <p class="text-sm text-gray-400">Be the first to access new programs & product drops</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex items-start space-x-4 p-4 bg-[#16213e] rounded-xl hover:bg-[#1a1a2e] transition">
                <div class="w-12 h-12 bg-blue-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-silver-200 mb-1">Member-Exclusive Wellness Tips</h4>
                    <p class="text-sm text-gray-400">Expert insights and wellness strategies for elite members</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex items-start space-x-4 p-4 bg-[#16213e] rounded-xl hover:bg-[#1a1a2e] transition">
                <div class="w-12 h-12 bg-purple-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-silver-200 mb-1">Progress Inspiration</h4>
                    <p class="text-sm text-gray-400">Connect with and get inspired by other members' journeys</p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex items-start space-x-4 p-4 bg-[#16213e] rounded-xl hover:bg-[#1a1a2e] transition">
                <div class="w-12 h-12 bg-yellow-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-silver-200 mb-1">Exclusive Giveaways & Rewards</h4>
                    <p class="text-sm text-gray-400">Access milestone rewards and member-only giveaways</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
        <h3 class="text-xl font-semibold text-silver-300 mb-6">Frequently Asked Questions</h3>
        <div class="space-y-4">
            <details class="group">
                <summary class="flex items-center justify-between cursor-pointer p-4 bg-[#16213e] rounded-lg hover:bg-[#141414] transition">
                    <span class="text-silver-300 font-medium">Can I connect with other members?</span>
                    <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="p-4 text-gray-400 text-sm">
                    Absolutely! Join our private community forum by clicking "Join Community" above. Share tips, ask questions, find accountability partners, and celebrate wins together. The community is a key part of your success!
                </div>
            </details>
        </div>
    </div>

    <!-- Support Contact -->
    <div class="bg-gradient-to-br from-[#16213e] to-[#1a1a2e] rounded-xl p-8 border border-silver-900/20">
        <div class="flex items-start">
            <div class="flex-shrink-0 mr-6">
                <div class="w-16 h-16 rounded-full bg-silver-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-silver-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-silver-300 mb-2">Need Help?</h3>
                <p class="text-gray-400 mb-4">Our support team is here to help you succeed on your wellness journey.</p>
                <a href="mailto:{{ $supportEmail }}" class="inline-flex items-center px-6 py-3 bg-silver-600 hover:bg-silver-500 text-white rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
