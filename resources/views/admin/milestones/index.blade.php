@extends('admin.layouts.admin')

@section('page-title', 'Milestones Management')
@section('page-subtitle', 'Track milestone achievements')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Day 30 Unlocks</p>
            <p class="text-3xl font-bold text-yellow-400 mt-2">{{ number_format($stats['day_30_count']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Day 60 Unlocks</p>
            <p class="text-3xl font-bold text-yellow-400 mt-2">{{ number_format($stats['day_60_count']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Day 90 Unlocks</p>
            <p class="text-3xl font-bold text-yellow-400 mt-2">{{ number_format($stats['day_90_count']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Rewards Claimed</p>
            <p class="text-3xl font-bold text-green-400 mt-2">{{ number_format($stats['rewards_claimed']) }}</p>
        </div>
    </div>

    <!-- Milestones Table -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">Recent Milestone Unlocks</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">User</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Milestone</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Unlocked At</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Reward</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($milestones as $milestone)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-100">{{ $milestone->user->name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 rounded-lg text-xs font-medium">
                                    Day {{ $milestone->milestone_day }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-silver-300">{{ $milestone->unlocked_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $milestone->reward_title ?? 'N/A' }}</td>
                            <td class="py-3 px-4">
                                @if($milestone->reward_claimed)
                                    <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-xs font-medium">Claimed</span>
                                @else
                                    <span class="px-3 py-1 bg-silver-900/30 text-silver-400 rounded-lg text-xs font-medium">Unclaimed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-silver-500">No milestones unlocked yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $milestones->links() }}
        </div>
    </div>
</div>
@endsection
