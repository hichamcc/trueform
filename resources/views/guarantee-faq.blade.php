@extends('layouts.dashboard')

@section('title', 'Guarantee & FAQ')
@section('page-title', 'Guarantee & FAQ')

@section('content')
<div class="space-y-8">
    <!-- Hero Section with 360-Day Guarantee -->
    <div class="bg-gradient-to-br from-green-900/30 to-green-800/20 rounded-2xl p-8 md:p-12 border-2 border-green-500/50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-green-400 to-green-600 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-green-500 to-green-400 rounded-full blur-2xl"></div>
        </div>

        <div class="relative">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-green-600/30 backdrop-blur-sm rounded-2xl flex items-center justify-center border-2 border-green-500/50">
                    <svg class="w-9 h-9 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-green-400 mb-2">360-Day Transformation Guarantee</h1>
                    <p class="text-green-200 text-lg">Your wellness journey, backed by our commitment</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!-- What's Guaranteed -->
                <div class="bg-[#0f0f0f]/50 backdrop-blur-sm rounded-xl p-6 border border-green-500/30">
                    <h3 class="text-2xl font-bold text-silver-200 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        What's Guaranteed
                    </h3>
                    <ul class="space-y-3 text-silver-300">
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Full access to your personalized wellness dashboard for 360 days</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Real-time tracking and analytics for all 5 wellness metrics</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Automatic milestone unlocking at 8 key checkpoints</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Personalized product recommendations based on your progress</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Access to exclusive community and resources</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Data privacy and security with industry-standard encryption</span>
                        </li>
                    </ul>
                </div>

                <!-- How to Claim -->
                <div class="bg-[#0f0f0f]/50 backdrop-blur-sm rounded-xl p-6 border border-green-500/30">
                    <h3 class="text-2xl font-bold text-silver-200 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Our Commitment
                    </h3>
                    <div class="space-y-4 text-silver-300">
                        <p class="leading-relaxed">
                            We're committed to your transformation success. If you complete at least 30 days of consistent tracking and feel the platform hasn't met your expectations, contact our support team within the first 60 days.
                        </p>
                        <p class="leading-relaxed">
                            <strong class="text-green-400">Money-Back Policy:</strong> We offer a full refund if you're not satisfied within the first 30 days of enrollment, no questions asked.
                        </p>
                        <p class="leading-relaxed">
                            <strong class="text-green-400">Lifetime Access:</strong> Complete the full 360-day journey, and your dashboard access continues indefinitely for tracking and reference.
                        </p>
                        <div class="mt-6 p-4 bg-green-900/20 rounded-lg border border-green-500/30">
                            <p class="text-sm text-green-200">
                                <strong>Questions?</strong> Email us at
                                <a href="mailto:support@trueform.com" class="text-green-400 hover:text-green-300 underline">support@trueform.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-[#141414] rounded-2xl p-8 border border-[#2a2a2a]">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-silver-200 mb-2">Frequently Asked Questions</h2>
            <p class="text-silver-400">Find answers to common questions about the True Form Elite Program</p>
        </div>

        <div class="space-y-8">
            @foreach($faqs as $category)
                <div>
                    <!-- Category Header -->
                    <div class="mb-4 pb-2 border-b border-silver-800">
                        <h3 class="text-xl font-bold text-silver-300">{{ $category['category'] }}</h3>
                    </div>

                    <!-- Questions in Category -->
                    <div class="space-y-4">
                        @foreach($category['questions'] as $index => $faq)
                            <div x-data="{ open: false }" class="bg-[#0f0f0f] rounded-xl border border-[#2a2a2a] overflow-hidden hover:border-silver-700 transition-all">
                                <!-- Question Button -->
                                <button
                                    @click="open = !open"
                                    class="w-full text-left p-5 flex items-center justify-between gap-4 group"
                                >
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-silver-600 to-silver-700 flex items-center justify-center flex-shrink-0 mt-1 group-hover:from-silver-500 group-hover:to-silver-600 transition">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <span class="text-lg font-semibold text-silver-200 group-hover:text-silver-100 transition">
                                            {{ $faq['question'] }}
                                        </span>
                                    </div>
                                    <svg
                                        class="w-5 h-5 text-silver-400 transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Answer Panel -->
                                <div
                                    x-show="open"
                                    x-collapse
                                    class="border-t border-[#2a2a2a]"
                                >
                                    <div class="p-5 pl-16">
                                        <p class="text-silver-400 leading-relaxed">{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Still Have Questions CTA -->
    <div class="bg-gradient-to-br from-blue-900/30 to-purple-900/20 rounded-2xl p-8 border border-blue-500/30 text-center">
        <div class="max-w-2xl mx-auto">
            <div class="w-16 h-16 bg-blue-600/30 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-silver-200 mb-3">Still Have Questions?</h3>
            <p class="text-silver-400 mb-6">
                Our support team is here to help you on your transformation journey.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="mailto:support@trueform.com" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Support
                </a>
                <a href="{{ route('dashboard.community') }}" class="px-6 py-3 bg-[#0f0f0f] hover:bg-[#1a1a1a] border border-silver-700 text-silver-300 hover:text-silver-200 rounded-lg transition font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Visit Community
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('dashboard') }}" class="group bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] hover:border-silver-700 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-silver-600 to-silver-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-silver-200 group-hover:text-silver-100 transition">Back to Dashboard</h4>
                    <p class="text-sm text-silver-500">View your progress</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.tracker') }}" class="group bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] hover:border-silver-700 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-silver-200 group-hover:text-silver-100 transition">Log Metrics</h4>
                    <p class="text-sm text-silver-500">Track your progress</p>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.progress') }}" class="group bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] hover:border-silver-700 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-silver-200 group-hover:text-silver-100 transition">View Progress</h4>
                    <p class="text-sm text-silver-500">See your transformation</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
