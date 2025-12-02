@extends('admin.layouts.admin')

@section('page-title', 'Free Months')
@section('page-subtitle', 'Manage earned free months from referrals')

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
            <div class="text-3xl font-bold text-purple-400 mb-1">{{ $stats['total'] }}</div>
            <div class="text-sm text-silver-500">Total Free Months</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-blue-400 mb-1">{{ $stats['unclaimed'] }}</div>
            <div class="text-sm text-silver-500">Unclaimed</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-green-400 mb-1">{{ $stats['claimed'] }}</div>
            <div class="text-sm text-silver-500">Claimed</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-yellow-400 mb-1">{{ $stats['pending_approval'] }}</div>
            <div class="text-sm text-silver-500">Pending Approval</div>
        </div>

        <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30">
            <div class="text-3xl font-bold text-green-400 mb-1">{{ $stats['approved'] }}</div>
            <div class="text-sm text-silver-500">Approved</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-silver-300 text-sm mb-2">Search User</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..."
                       class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Claimed</label>
                <select name="claimed" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All</option>
                    <option value="yes" {{ request('claimed') == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ request('claimed') == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div>
                <label class="block text-silver-300 text-sm mb-2">Approved</label>
                <select name="approved" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
                    <option value="">All</option>
                    <option value="yes" {{ request('approved') == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ request('approved') == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.referrals.free-months') }}" class="px-6 py-2 bg-silver-700 hover:bg-silver-600 text-white rounded-lg font-medium transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Free Months Table -->
    <div class="bg-[#1a1a2e] rounded-2xl border border-silver-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-silver-900/30">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Milestone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Earned</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Claimed</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Applied To</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-silver-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-silver-900/30">
                    @forelse($freeMonths as $freeMonth)
                        <tr class="hover:bg-[#16213e] transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-silver-200 font-medium">{{ $freeMonth->user->name }}</div>
                                <div class="text-silver-500 text-xs">{{ $freeMonth->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-silver-200">{{ $freeMonth->referral_milestone }} referrals</div>
                                <div class="text-silver-500 text-xs">Milestone reached</div>
                            </td>
                            <td class="px-6 py-4 text-silver-200">{{ $freeMonth->earned_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @if($freeMonth->is_claimed)
                                    <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Claimed</span>
                                    @if($freeMonth->claimed_at)
                                        <div class="text-xs text-silver-500 mt-1">{{ $freeMonth->claimed_at->format('M d, Y') }}</div>
                                    @endif
                                @else
                                    <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 text-xs rounded-full">Unclaimed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($freeMonth->applied_month && $freeMonth->applied_year)
                                    <div class="text-silver-200">
                                        {{ \Carbon\Carbon::create()->month($freeMonth->applied_month)->format('F') }} {{ $freeMonth->applied_year }}
                                    </div>
                                @else
                                    <span class="text-silver-600">Not applied</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($freeMonth->admin_approved)
                                    <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Approved</span>
                                    @if($freeMonth->approvedBy)
                                        <div class="text-xs text-silver-500 mt-1">by {{ $freeMonth->approvedBy->name }}</div>
                                    @endif
                                @else
                                    <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 text-xs rounded-full">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if(!$freeMonth->admin_approved)
                                    <button onclick="showApproveModal({{ $freeMonth->id }})" class="text-green-400 hover:text-green-300 text-sm font-medium">
                                        Approve
                                    </button>
                                @else
                                    <span class="text-silver-600 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-silver-500">
                                No free months found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($freeMonths->hasPages())
            <div class="px-6 py-4 border-t border-silver-900/30">
                {{ $freeMonths->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-[#1a1a2e] rounded-2xl p-8 max-w-md w-full mx-4 border border-silver-900/30">
        <h3 class="text-2xl font-bold text-silver-100 mb-4">Approve Free Month</h3>
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-4">
                <div>
                    <label class="block text-silver-300 text-sm mb-2">Admin Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500" placeholder="Add any notes about this approval..."></textarea>
                </div>

                <div class="bg-blue-900/20 border border-blue-500/30 rounded-lg p-4">
                    <p class="text-silver-300 text-sm">
                        Approving this free month will allow the user to apply it to their subscription for one month without charge.
                    </p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeApproveModal()" class="flex-1 px-6 py-3 bg-silver-700 hover:bg-silver-600 text-white rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    Approve
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showApproveModal(freeMonthId) {
    const modal = document.getElementById('approveModal');
    const form = document.getElementById('approveForm');
    form.action = `/admin/referrals/free-months/${freeMonthId}/approve`;
    modal.classList.remove('hidden');
}

function closeApproveModal() {
    const modal = document.getElementById('approveModal');
    modal.classList.add('hidden');
}

// Close modal on outside click
document.getElementById('approveModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeApproveModal();
    }
});
</script>
@endpush
@endsection
