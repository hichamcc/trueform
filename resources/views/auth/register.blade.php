<x-guest-layout>
    <!-- Page Title -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-silver-100 mb-2">Create Your Account</h2>
        <p class="text-silver-400 text-sm">Start your 360-day transformation journey today</p>

        @if(isset($referralCode) && $referralCode)
            <div class="mt-4 p-4 bg-gradient-to-r from-purple-900/30 to-blue-900/30 border border-purple-500/30 rounded-lg">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                    <p class="text-purple-200 font-semibold text-sm">Special Offer Applied!</p>
                </div>
                <p class="text-purple-300 text-xs">You'll get <strong>15% off your first month</strong> with this referral link.</p>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Hidden Referral Code -->
        @if(isset($referralCode) && $referralCode)
            <input type="hidden" name="referral_code" value="{{ $referralCode }}" />
        @endif

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-silver-300 mb-2">
                Full Name
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="John Doe"
            />
            @if($errors->get('name'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-silver-300 mb-2">
                Email Address
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="you@example.com"
            />
            @if($errors->get('email'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-silver-300 mb-2">
                Password
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="At least 8 characters"
            />
            @if($errors->get('password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-silver-300 mb-2">
                Confirm Password
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="Confirm your password"
            />
            @if($errors->get('password_confirmation'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full px-6 py-3 text-base font-semibold text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 hover:from-silver-50 hover:to-silver-200 rounded-lg shadow-lg transition-all duration-300 hover:shadow-silver-500/20 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:ring-offset-2 focus:ring-offset-[#1a1a2e]"
        >
            Create Account
        </button>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-silver-900/30">
            <p class="text-sm text-silver-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-silver-300 hover:text-silver-100 transition-colors">
                    Log in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
