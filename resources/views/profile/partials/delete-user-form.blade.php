<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-xl font-bold text-red-400">
            Delete Account
        </h2>
        <p class="mt-2 text-sm text-silver-400">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-[#141414]"
    >
        Delete Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div
        x-data="{ show: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }"
        x-on:open-modal.window="$event.detail === 'confirm-user-deletion' ? show = true : null"
        x-on:close-modal.window="show = false"
        x-show="show"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <!-- Backdrop -->
        <div
            class="fixed inset-0 bg-black/80 transition-opacity"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-on:click="show = false"
        ></div>

        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative bg-[#141414] border border-red-900/50 rounded-2xl p-8 shadow-2xl max-w-md w-full"
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                x-on:click.stop
            >
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <h2 class="text-xl font-bold text-red-400 mb-4">
                        Are you sure you want to delete your account?
                    </h2>

                    <p class="text-sm text-silver-400 mb-6">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <div class="mb-6">
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Enter your password"
                            class="w-full px-4 py-3 bg-[#0a0a0a] border border-red-900/50 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        />
                        @if($errors->userDeletion->get('password'))
                            <p class="mt-2 text-sm text-red-400">{{ $errors->userDeletion->first('password') }}</p>
                        @endif
                    </div>

                    <div class="flex justify-end gap-4">
                        <button
                            type="button"
                            x-on:click="show = false"
                            class="px-6 py-3 text-sm font-medium text-silver-300 hover:text-silver-100 border border-silver-700 hover:border-silver-500 rounded-lg transition-all"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-[#141414]"
                        >
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    [x-cloak] { display: none !important; }
</style>
