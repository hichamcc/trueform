<x-guest-layout>
    <!-- Page Title -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-silver-100 mb-2">Welcome Back</h2>
        <p class="text-silver-400 text-sm">Log in to continue your transformation journey</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

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
                autofocus
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
                autocomplete="current-password"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="Enter your password"
            />
            @if($errors->get('password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 rounded border-silver-700 bg-[#0a0a0a] text-silver-500 focus:ring-2 focus:ring-silver-500 focus:ring-offset-0"
                />
                <span class="ml-2 text-sm text-silver-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-silver-400 hover:text-silver-300 transition-colors">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full px-6 py-3 text-base font-semibold text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 hover:from-silver-50 hover:to-silver-200 rounded-lg shadow-lg transition-all duration-300 hover:shadow-silver-500/20 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:ring-offset-2 focus:ring-offset-[#1a1a2e]"
        >
            Log In
        </button>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="text-center pt-4 border-t border-silver-900/30">
                <p class="text-sm text-silver-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-silver-300 hover:text-silver-100 transition-colors">
                        Sign up now
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
