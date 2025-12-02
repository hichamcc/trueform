@extends('admin.layouts.admin')

@section('page-title', 'Monthly Rewards')
@section('page-subtitle', 'Manage 10% monthly reward payments')

@section('content')
<div class="space-y-6">
    <!-- Back Link -->
    <div>
        <a href="{{ route('admin.referrals.index') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
            ← Back to Referrals
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-purple-400 mb-1">{{ $stats['total_rewards'] }}</div>
            <div class="text-sm text-silver-500">Total Rewards</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-yellow-400 mb-1">{{ $stats['pending'] }}</div>
            <div class="text-sm text-silver-500">Pending</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-green-400 mb-1">{{ $stats['paid'] }}</div>
            <div class="text-sm text-silver-500">Paid</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-yellow-400 mb-1">${{ number_format($stats['pending_amount'], 2) }}</div>
            <div class="text-sm text-silver-500">Pending Amount</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-green-400 mb-1">${{ number_format($stats['paid_amount'], 2) }}</div>
            <div class="text-sm text-silver-500">Paid Amount</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-silver-300 text-sm mb-2">Search Referrer</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..."
                       class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Month</label>
                <select name="month" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All Months</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Year</label>
                <select name="year" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All Years</option>
                    @for($y = now()->year; $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.referrals.monthly-rewards') }}" class="px-6 py-2 bg-silver-700 hover:bg-silver-600 text-white rounded-lg font-medium transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Monthly Rewards Table -->
    <div class="bg-[#1a1a2e] rounded-2xl border border-silver-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-silver-900/30">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Referrer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Referred User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Period</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Subscription</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Reward (10%)</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-silver-900/30">
                    @forelse($rewards as $reward)
                        <tr class="hover:bg-[#16213e] transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-silver-200 font-medium">{{ $reward->referrer->name }}</div>
                                <div class="text-silver-500 text-xs">{{ $reward->referrer->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-silver-200 font-medium">{{ $reward->referred->name }}</div>
                                <div class="text-silver-500 text-xs">{{ $reward->referred->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-silver-200">{{ \Carbon\Carbon::create()->month($reward->month)->format('F') }} {{ $reward->year }}</div>
                            </td>
                            <td class="px-6 py-4 text-silver-200">${{ number_format($reward->subscription_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="text-green-400 font-semibold">${{ number_format($reward->reward_amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($reward->status === 'paid')
                                    <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Paid</span>
                                    @if($reward->paid_at)
                                        <div class="text-xs text-silver-500 mt-1">{{ $reward->paid_at->format('M d, Y') }}</div>
                                    @endif
                                @elseif($reward->status === 'failed')
                                    <span class="px-2 py-1 bg-red-900/30 text-red-400 text-xs rounded-full">Failed</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 text-xs rounded-full">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($reward->status === 'pending')
                                    <button onclick="showMarkPaidModal({{ $reward->id }})" class="text-green-400 hover:text-green-300 text-sm font-medium">
                                        Mark as Paid
                                    </button>
                                @else
                                    <span class="text-silver-600 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-silver-500">
                                No monthly rewards found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($rewards->hasPages())
            <div class="px-6 py-4 border-t border-silver-900/30">
                {{ $rewards->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Mark as Paid Modal -->
<div id="markPaidModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-[#1a1a2e] rounded-2xl p-8 max-w-md w-full mx-4 border border-silver-900/30">
        <h3 class="text-2xl font-bold text-silver-100 mb-4">Mark Reward as Paid</h3>
        <form id="markPaidForm" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
                <div>
                    <label class="block text-silver-300 text-sm mb-2">Payment Method</label>
                    <select name="payment_method" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                        <option value="">Select method...</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="manual">Manual Payment</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-silver-300 text-sm mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500" placeholder="Add any notes..."></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeMarkPaidModal()" class="flex-1 px-6 py-3 bg-silver-700 hover:bg-silver-600 text-white rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    Mark as Paid
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showMarkPaidModal(rewardId) {
    const modal = document.getElementById('markPaidModal');
    const form = document.getElementById('markPaidForm');
    form.action = `/admin/referrals/rewards/${rewardId}/mark-paid`;
    modal.classList.remove('hidden');
}

function closeMarkPaidModal() {
    const modal = document.getElementById('markPaidModal');
    modal.classList.add('hidden');
}

// Close modal on outside click
document.getElementById('markPaidModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMarkPaidModal();
    }
});
</script>
@endpush
@endsection
