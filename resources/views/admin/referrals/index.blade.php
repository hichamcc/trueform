@extends('admin.layouts.admin')

@section('page-title', 'Referrals Management')
@section('page-subtitle', 'Manage all referrals and subscription tracking')

@section('content')
<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-purple-400 mb-1">{{ $stats['total'] }}</div>
            <div class="text-sm text-silver-500">Total Referrals</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-green-400 mb-1">{{ $stats['completed'] }}</div>
            <div class="text-sm text-silver-500">Completed</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-blue-400 mb-1">{{ $stats['active_subscriptions'] }}</div>
            <div class="text-sm text-silver-500">Active Subscriptions</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-green-400 mb-1">${{ number_format($stats['total_earned'], 2) }}</div>
            <div class="text-sm text-silver-500">Total Earned</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-blue-400 mb-1">${{ number_format($stats['total_paid'], 2) }}</div>
            <div class="text-sm text-silver-500">Total Paid</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-yellow-400 mb-1">${{ number_format($stats['unpaid_balance'], 2) }}</div>
            <div class="text-sm text-silver-500">Unpaid Balance</div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.referrals.monthly-rewards') }}" class="bg-gradient-to-br from-blue-600/20 to-blue-700/20 border border-blue-500/30 rounded-xl p-6 hover:border-blue-500/50 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-600/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-silver-100">Monthly Rewards</h3>
                    <p class="text-sm text-silver-400">Manage 10% monthly payments</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.referrals.free-months') }}" class="bg-gradient-to-br from-purple-600/20 to-purple-700/20 border border-purple-500/30 rounded-xl p-6 hover:border-purple-500/50 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-600/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-silver-100">Free Months</h3>
                    <p class="text-sm text-silver-400">Approve earned free months</p>
                </div>
            </div>
        </a>

        <form action="{{ route('admin.referrals.generate-monthly-rewards') }}" method="POST" class="bg-gradient-to-br from-green-600/20 to-green-700/20 border border-green-500/30 rounded-xl p-6">
            @csrf
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-600/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-silver-100">Generate Rewards</h3>
                    <p class="text-sm text-silver-400">Run monthly rewards generation</p>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                    Run
                </button>
            </div>
        </form>
    </div>

    <!-- Filters -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-silver-300 text-sm mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..."
                       class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="rewarded" {{ request('status') == 'rewarded' ? 'selected' : '' }}>Rewarded</option>
                </select>
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Subscription</label>
                <select name="subscription_status" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All</option>
                    <option value="active" {{ request('subscription_status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('subscription_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.referrals.index') }}" class="px-6 py-2 bg-silver-700 hover:bg-silver-600 text-white rounded-lg font-medium transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Referrals Table -->
    <div class="bg-[#1a1a2e] rounded-2xl border border-silver-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-silver-900/30">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Referrer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Referred</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Subscription</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Earned</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Paid</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Balance</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-silver-900/30">
                    @forelse($referrals as $referral)
                        <tr class="hover:bg-[#16213e] transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-silver-200 font-medium">{{ $referral->referrer->name }}</div>
                                <div class="text-silver-500 text-xs">{{ $referral->referrer->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($referral->referred)
                                    <div class="text-silver-200 font-medium">{{ $referral->referred->name }}</div>
                                    <div class="text-silver-500 text-xs">{{ $referral->referred->email }}</div>
                                @else
                                    <div class="text-silver-400 italic">{{ $referral->referred_email ?? 'Pending' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($referral->status === 'completed' || $referral->status === 'rewarded')
                                    <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">{{ ucfirst($referral->status) }}</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 text-xs rounded-full">{{ ucfirst($referral->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($referral->subscription_active)
                                    <span class="px-2 py-1 bg-blue-900/30 text-blue-400 text-xs rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-900/30 text-gray-400 text-xs rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-silver-200">${{ number_format($referral->total_earned, 2) }}</td>
                            <td class="px-6 py-4 text-silver-200">${{ number_format($referral->total_paid, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="text-yellow-400 font-semibold">${{ number_format($referral->unpaid_balance, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.referrals.show', $referral) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-silver-500">
                                No referrals found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($referrals->hasPages())
            <div class="px-6 py-4 border-t border-silver-900/30">
                {{ $referrals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
