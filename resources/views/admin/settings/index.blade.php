@extends('admin.layouts.admin')

@section('page-title', 'Admin Settings')
@section('page-subtitle', 'Manage admin panel configuration')

@section('content')
<div class="space-y-6">
    <!-- External Links & Support Settings -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-silver-100">External Links & Support</h3>
                <p class="text-sm text-silver-500 mt-1">Configure community links and support email</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($settings as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-silver-300 mb-2">
                            {{ $setting->label }}
                            @if($setting->description)
                                <span class="block text-xs text-silver-500 mt-1">{{ $setting->description }}</span>
                            @endif
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea
                                id="setting_{{ $setting->key }}"
                                name="settings[{{ $loop->index }}][value]"
                                rows="3"
                                class="w-full px-4 py-2 bg-[#16213e] border border-silver-900/30 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:border-blue-500 transition"
                                placeholder="Enter {{ strtolower($setting->label) }}"
                            >{{ $setting->value }}</textarea>
                        @else
                            <input
                                type="{{ $setting->type === 'email' ? 'email' : 'text' }}"
                                id="setting_{{ $setting->key }}"
                                name="settings[{{ $loop->index }}][value]"
                                value="{{ $setting->value }}"
                                class="w-full px-4 py-2 bg-[#16213e] border border-silver-900/30 rounded-lg text-silver-100 placeholder-silver-600 focus:outline-none focus:border-blue-500 transition"
                                placeholder="Enter {{ strtolower($setting->label) }}"
                            >
                        @endif
                        <input type="hidden" name="settings[{{ $loop->index }}][key]" value="{{ $setting->key }}">
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-silver-900/30">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Settings
                    </div>
                </button>
            </div>
        </form>
    </div>

    <!-- Admin Users -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Admin Users</h3>
        <div class="space-y-3">
            @forelse($adminUsers as $admin)
                <div class="flex items-center justify-between p-4 bg-[#16213e] rounded-xl">
                    <div>
                        <p class="font-medium text-silver-100">{{ $admin->name }}</p>
                        <p class="text-sm text-silver-500">{{ $admin->email }}</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-lg text-xs font-medium">ADMIN</span>
                </div>
            @empty
                <p class="text-silver-500 text-sm">No admin users found</p>
            @endforelse
        </div>
    </div>

    <!-- Settings Info -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">System Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-silver-500 text-sm">Laravel Version</p>
                <p class="text-silver-100 font-medium mt-1">{{ app()->version() }}</p>
            </div>
            <div>
                <p class="text-silver-500 text-sm">PHP Version</p>
                <p class="text-silver-100 font-medium mt-1">{{ PHP_VERSION }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
