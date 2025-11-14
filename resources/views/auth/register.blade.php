<x-guest-layout>
    <!-- Page Title -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-silver-100 mb-2">Create Your Account</h2>
        <p class="text-silver-400 text-sm">Start your 90-day transformation journey today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

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
