@extends('layouts.dashboard')

@section('title', 'Tracker')
@section('page-title', 'Wellness Tracker')

@section('content')
<div class="space-y-6">
    <!-- Stage Indicator -->
    @if($enrollment)
        <div class="bg-gradient-to-r {{ $stageTheme['gradient'] ?? 'from-green-600 to-green-500' }} rounded-xl p-4 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 glass-light rounded-full text-white text-xs font-semibold">
                        Stage {{ $currentStage }} - {{ $stageName }}
                    </span>
                    <span class="text-white/90 text-sm">Day {{ $enrollment->getCurrentDay() }} of 360</span>
                </div>
            </div>
        </div>
    @endif

    @if(!$baseline)
        <!-- Baseline Setup -->
        <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-2xl p-8 border border-[#2a2a2a]">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-silver-200 mb-2">Set Your Baseline</h2>
                <p class="text-gray-400">Before you begin your 90-day journey, let's record your starting metrics. Rate each category from 1-10.</p>
            </div>

            <form action="{{ route('dashboard.tracker.baseline') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ energy: 5, focus: 5, sleep: 5, gut_health: 5, skin_glow: 5, imagePreview: null }">
                @csrf

                <!-- Optional Baseline Photo -->
                <div class="bg-[#0f0f0f] rounded-xl p-6 border border-[#2a2a2a]">
                    <h3 class="text-lg font-semibold text-silver-300 mb-3">Baseline Photo (Optional)</h3>
                    <p class="text-sm text-gray-400 mb-4">Upload a photo to track your visual transformation. This is completely optional.</p>

                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <!-- Image Preview -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 rounded-xl border-2 border-dashed border-[#2a2a2a] flex items-center justify-center overflow-hidden bg-[#0a0a0a]"
                                 x-show="!imagePreview">
                                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="w-32 h-32 rounded-xl border-2 border-purple-500/50 overflow-hidden"
                                 x-show="imagePreview"
                                 x-cloak>
                                <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <div class="flex-1">
                            <input type="file"
                                   name="image"
                                   id="baseline-image"
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="hidden"
                                   @change="
                                       const file = $event.target.files[0];
                                       if (file) {
                                           const reader = new FileReader();
                                           reader.onload = (e) => imagePreview = e.target.result;
                                           reader.readAsDataURL(file);
                                       }
                                   ">
                            <label for="baseline-image" class="inline-flex items-center px-6 py-3 bg-silver-600 hover:bg-silver-500 text-white font-medium rounded-lg cursor-pointer transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Choose Photo
                            </label>
                            <button type="button"
                                    class="ml-3 text-sm text-red-400 hover:text-red-300"
                                    x-show="imagePreview"
                                    x-cloak
                                    @click="imagePreview = null; document.getElementById('baseline-image').value = ''">
                                Remove
                            </button>
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max 5MB.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Energy -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Energy Level</span>
                            <span class="text-2xl font-bold text-green-400" x-text="energy.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="energy" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-green">
                        <input type="number" name="energy" x-model.number="energy" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                        <p class="text-xs text-gray-500">How energized do you feel throughout the day?</p>
                    </div>

                    <!-- Focus -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Mental Focus</span>
                            <span class="text-2xl font-bold text-blue-400" x-text="focus.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="focus" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-blue">
                        <input type="number" name="focus" x-model.number="focus" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                        <p class="text-xs text-gray-500">How sharp and clear is your mental clarity?</p>
                    </div>

                    <!-- Sleep -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Sleep Quality</span>
                            <span class="text-2xl font-bold text-purple-400" x-text="sleep.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="sleep" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-purple">
                        <input type="number" name="sleep" x-model.number="sleep" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                        <p class="text-xs text-gray-500">How restful and rejuvenating is your sleep?</p>
                    </div>

                    <!-- Gut Health -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Gut Health</span>
                            <span class="text-2xl font-bold text-orange-400" x-text="gut_health.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="gut_health" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-orange">
                        <input type="number" name="gut_health" x-model.number="gut_health" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                        <p class="text-xs text-gray-500">How comfortable is your digestive system?</p>
                    </div>

                    <!-- Skin Glow -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Skin Glow</span>
                            <span class="text-2xl font-bold text-pink-400" x-text="skin_glow.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="skin_glow" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-pink">
                        <input type="number" name="skin_glow" x-model.number="skin_glow" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                        <p class="text-xs text-gray-500">How radiant and healthy is your skin?</p>
                    </div>
                </div>

                <button type="submit" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-silver-600 to-silver-500 hover:from-silver-500 hover:to-silver-400 text-white font-semibold rounded-lg transition-all shadow-lg">
                    Save Baseline & Start Journey
                </button>
            </form>
        </div>
    @else
        <!-- Baseline Summary -->
        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-silver-300">Your Baseline</h3>
                <span class="px-3 py-1 bg-green-900/30 text-green-400 text-sm rounded-full">Set</span>
            </div>

            @if($baseline->photo || $baseline->image)
                <div class="mb-6 flex justify-center">
                    <div class="relative group">
                        <img src="{{ asset('storage/' . ($baseline->photo ?? $baseline->image)) }}"
                             alt="Baseline Photo"
                             class="w-48 h-48 rounded-xl object-cover border-2 border-purple-500/50 shadow-lg">
                        <div class="absolute inset-0 bg-black/50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-sm font-medium">Baseline Photo</span>
                        </div>
                    </div>
                </div>
            @else
                <!-- Upload Baseline Photo Form -->
                <div class="mb-6 bg-[#0f0f0f] rounded-xl p-4 border border-[#2a2a2a]">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-silver-300">Add Baseline Photo</h4>
                            <p class="text-xs text-gray-400">Track your visual transformation (optional)</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.tracker.baseline') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <!-- Hidden fields to preserve existing baseline values -->
                        <input type="hidden" name="energy" value="{{ $baseline->energy }}">
                        <input type="hidden" name="focus" value="{{ $baseline->focus }}">
                        <input type="hidden" name="sleep" value="{{ $baseline->sleep }}">
                        <input type="hidden" name="gut_health" value="{{ $baseline->gut_health }}">
                        <input type="hidden" name="skin_glow" value="{{ $baseline->skin_glow }}">

                        <div>
                            <input type="file"
                                   name="photo"
                                   id="baseline-photo-upload"
                                   accept="image/*"
                                   required
                                   class="w-full px-3 py-2 bg-[#0a0a0a] border border-[#2a2a2a] rounded-lg text-silver-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('photo')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max 5MB.</p>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-lg transition">
                            Upload Baseline Photo
                        </button>
                    </form>
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-silver-300">{{ $baseline->energy }}</div>
                    <div class="text-xs text-gray-500 mt-1">Energy</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-silver-300">{{ $baseline->focus }}</div>
                    <div class="text-xs text-gray-500 mt-1">Focus</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-silver-300">{{ $baseline->sleep }}</div>
                    <div class="text-xs text-gray-500 mt-1">Sleep</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-silver-300">{{ $baseline->gut_health }}</div>
                    <div class="text-xs text-gray-500 mt-1">Gut</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-silver-300">{{ $baseline->skin_glow }}</div>
                    <div class="text-xs text-gray-500 mt-1">Skin</div>
                </div>
                <div class="text-center border-l border-silver-900/30">
                    <div class="text-2xl font-bold text-silver-400">{{ number_format($baseline->mito_age_score, 1) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Mito-Age</div>
                </div>
            </div>
        </div>

        <!-- Streak Motivation -->
        @if($enrollment && $enrollment->current_streak > 0)
        <div class="bg-gradient-to-r from-orange-900/20 to-red-900/20 rounded-xl p-4 border border-orange-500/30">
            <div class="flex items-center space-x-3">
                <div class="text-3xl">🔥</div>
                <div>
                    <h3 class="text-orange-400 font-semibold">{{ $enrollment->getStreakMessage() }}</h3>
                    <p class="text-sm text-gray-400">{{ $enrollment->current_streak }} day streak • Best: {{ $enrollment->longest_streak }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Daily Log Form -->
        <div class="bg-gradient-to-br from-[#141414] to-[#0f0f0f] rounded-2xl p-8 border border-[#2a2a2a]">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-silver-200 mb-2">
                    @if($todayLog)
                        Update Today's Log
                    @else
                        Log Today's Metrics
                    @endif
                </h2>
                <p class="text-gray-400">How are you feeling today? Rate each metric from 1-10.</p>
            </div>

            <form action="{{ route('dashboard.tracker.log') }}" method="POST" class="space-y-6"
                  x-data="{
                      energy: {{ $todayLog->energy ?? 5 }},
                      focus: {{ $todayLog->focus ?? 5 }},
                      sleep: {{ $todayLog->sleep ?? 5 }},
                      gut_health: {{ $todayLog->gut_health ?? 5 }},
                      skin_glow: {{ $todayLog->skin_glow ?? 5 }}
                  }">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Energy -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Energy Level</span>
                            <span class="text-2xl font-bold text-green-400" x-text="energy.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="energy" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-green">
                        <input type="number" name="energy" x-model.number="energy" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                    </div>

                    <!-- Focus -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Mental Focus</span>
                            <span class="text-2xl font-bold text-blue-400" x-text="focus.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="focus" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-blue">
                        <input type="number" name="focus" x-model.number="focus" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                    </div>

                    <!-- Sleep -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Sleep Quality</span>
                            <span class="text-2xl font-bold text-purple-400" x-text="sleep.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="sleep" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-purple">
                        <input type="number" name="sleep" x-model.number="sleep" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                    </div>

                    <!-- Gut Health -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Gut Health</span>
                            <span class="text-2xl font-bold text-orange-400" x-text="gut_health.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="gut_health" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-orange">
                        <input type="number" name="gut_health" x-model.number="gut_health" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                    </div>

                    <!-- Skin Glow -->
                    <div class="space-y-3">
                        <label class="block text-silver-300 font-medium flex items-center justify-between">
                            <span>Skin Glow</span>
                            <span class="text-2xl font-bold text-pink-400" x-text="skin_glow.toFixed(1)"></span>
                        </label>
                        <input type="range" x-model.number="skin_glow" min="1" max="10" step="0.1"
                               class="w-full bg-transparent rounded-lg appearance-none cursor-pointer slider-pink">
                        <input type="number" name="skin_glow" x-model.number="skin_glow" min="1" max="10" step="0.1" required
                               class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                               placeholder="1-10">
                    </div>
                </div>

                <!-- Notes -->
                <div class="space-y-3">
                    <label class="block text-silver-300 font-medium">Notes (Optional)</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-200 focus:border-silver-500 focus:ring-2 focus:ring-silver-500/20"
                              placeholder="Any observations or thoughts about your wellness today...">{{ $todayLog->notes ?? '' }}</textarea>
                </div>

                <div class="flex items-center space-x-4">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-green-500 to-green-400 hover:from-green-400 hover:to-green-300 text-white font-semibold rounded-lg transition-all shadow-lg">
                        {{ $todayLog ? 'Update Log' : 'Save Today\'s Log' }}
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-4 text-gray-400 hover:text-silver-300 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    @endif

    <!-- Quick Tips -->
    <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a]">
        <h3 class="text-lg font-semibold text-silver-300 mb-4">Tracking Tips</h3>
        <ul class="space-y-2 text-gray-400 text-sm">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-silver-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Log your metrics at the same time each day for consistency
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-silver-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Be honest with your ratings - this helps track real progress
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-silver-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Use the notes field to record what's working or needs adjustment
            </li>
        </ul>
    </div>
</div>
@endsection
