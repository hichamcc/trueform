<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-silver-100">
            Update Password
        </h2>
        <p class="mt-2 text-sm text-silver-400">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-silver-300 mb-2">
                Current Password
            </label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="Enter your current password"
            />
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-silver-300 mb-2">
                New Password
            </label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="Enter your new password"
            />
            @if($errors->updatePassword->get('password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-silver-300 mb-2">
                Confirm Password
            </label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="w-full px-4 py-3 bg-[#0a0a0a] border border-silver-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:border-transparent transition-all"
                placeholder="Confirm your new password"
            />
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-6 py-3 text-sm font-semibold text-[#0a0a0a] bg-gradient-to-r from-silver-100 to-silver-300 hover:from-silver-50 hover:to-silver-200 rounded-lg shadow-lg transition-all duration-300 hover:shadow-silver-500/20 focus:outline-none focus:ring-2 focus:ring-silver-500 focus:ring-offset-2 focus:ring-offset-[#141414]"
            >
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400"
                >
                    Password updated successfully!
                </p>
            @endif
        </div>
    </form>
</section>
