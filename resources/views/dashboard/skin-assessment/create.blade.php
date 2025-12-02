@extends('layouts.dashboard')

@section('page-title', 'Complete Skin Assessment')

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
            {{ $milestoneLabel }} Skin Assessment
        </h1>
        <p class="text-sm lg:text-base text-gray-400">
            Complete this check-in to track changes in your skin. Take your time and be honest with your ratings.
        </p>
    </div>

    <!-- Assessment Form -->
    <form action="{{ route('dashboard.skin-assessment.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 lg:p-6 border border-[#2a2a3e]"
          x-data="{ radiance: 5, smoothness: 5, calmness: 5, clarity: 5, hydration: 5, firmness: 5, evenness: 5 }">
        @csrf
        <input type="hidden" name="milestone_day" value="{{ $milestoneDay }}">

        <!-- 7 Assessment Sliders -->
        <div class="space-y-6 mb-6">
            <!-- 1. Radiance -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How radiant and glowing does your skin look today?
                    </label>
                    <span class="text-2xl font-bold text-pink-400" x-text="radiance.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="radiance" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-pink">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="radiance" x-model.number="radiance" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>

            <!-- 2. Smoothness -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How smooth does your skin texture feel today?
                    </label>
                    <span class="text-2xl font-bold text-blue-400" x-text="smoothness.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="smoothness" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-blue">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="smoothness" x-model.number="smoothness" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>

            <!-- 3. Calmness -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How calm is your skin (redness / inflammation)?
                    </label>
                    <span class="text-2xl font-bold text-green-400" x-text="calmness.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="calmness" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-green">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="calmness" x-model.number="calmness" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>

            <!-- 4. Clarity -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How clear is your skin (breakouts/acne)?
                    </label>
                    <span class="text-2xl font-bold text-purple-400" x-text="clarity.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="clarity" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-purple">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="clarity" x-model.number="clarity" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>

            <!-- 5. Hydration -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How hydrated does your skin feel?
                    </label>
                    <span class="text-2xl font-bold text-blue-400" x-text="hydration.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="hydration" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-blue">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="hydration" x-model.number="hydration" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>

            <!-- 6. Firmness -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How firm and youthful does your skin look (fine lines)?
                    </label>
                    <span class="text-2xl font-bold text-orange-400" x-text="firmness.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="firmness" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-orange">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="firmness" x-model.number="firmness" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>

            <!-- 7. Evenness -->
            <div class="space-y-3">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-silver-300 font-medium text-base">
                        How even is your overall skin tone?
                    </label>
                    <span class="text-2xl font-bold text-pink-400" x-text="evenness.toFixed(1)"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Very poor</span>
                    <input type="range" x-model.number="evenness" min="1" max="10" step="0.1"
                           class="flex-1 bg-transparent rounded-lg appearance-none cursor-pointer slider-pink">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Excellent</span>
                </div>
                <input type="number" name="evenness" x-model.number="evenness" min="1" max="10" step="0.1" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                       placeholder="1-10">
            </div>
        </div>

        <!-- Photo Upload -->
        <div class="mb-6 p-4 bg-[#0a0a0a]/50 rounded-lg border border-[#2a2a3e]">
            <label for="photo" class="block text-sm font-semibold text-silver-300 mb-2">
                Upload your skin check-in photo (optional but encouraged)
            </label>
            <input type="file" name="photo" id="photo" accept="image/*"
                   class="w-full px-3 py-2 bg-[#0f0f0f] border border-[#2a2a3e] rounded-lg text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <p class="text-xs text-gray-500 mt-2">
                Optional but highly recommended. This helps you visually track your glow over time. (Max 5MB)
            </p>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <label for="notes" class="block text-sm font-semibold text-silver-300 mb-2">
                Notes (optional)
            </label>
            <textarea name="notes" id="notes" rows="4"
                      class="w-full px-3 py-2 bg-[#0f0f0f] border border-[#2a2a3e] rounded-lg text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600"
                      placeholder="Any changes you've noticed? Breakouts, redness, smoothness, compliments, etc."></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-400 hover:from-green-400 hover:to-green-300 text-white font-semibold rounded-lg transition-all shadow-lg">
                Save Assessment
            </button>
            <a href="{{ route('dashboard.skin-assessment.index') }}"
               class="px-6 py-3 bg-gray-600/20 hover:bg-gray-600/30 border border-gray-600/30 text-gray-300 font-semibold rounded-lg transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
