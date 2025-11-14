@extends('layouts.dashboard')

@section('title', 'Referral Program')
@section('page-title', 'Referral Program')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-purple-900/30 to-blue-900/30 rounded-2xl p-8 border border-purple-500/30 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600 rounded-full blur-3xl"></div>
        </div>

        <div class="relative">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-white">Earn Rewards. Share the Journey.</h2>
                    <p class="text-purple-200">Invite friends and get rewarded together</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="text-3xl">🎁</div>
                        <div>
                            <div class="text-white font-bold text-lg">Give 15% Off</div>
                            <div class="text-purple-200 text-sm">Your friends save on their first month</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="text-3xl">💰</div>
                        <div>
                            <div class="text-white font-bold text-lg">Get 10% Monthly</div>
                            <div class="text-purple-200 text-sm">Earn rewards for each successful referral</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Referral Link -->
    <div class="bg-[#141414] rounded-2xl p-6 border border-[#2a2a2a]">
        <h3 class="text-2xl font-bold text-silver-200 mb-4">Your Unique Referral Link</h3>

        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input
                    type="text"
                    id="referral-link"
                    value="{{ $referralLink }}"
                    readonly
                    class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-300 font-mono text-sm focus:outline-none focus:border-purple-500"
                />
            </div>
            <button
                onclick="copyReferralLink()"
                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-semibold rounded-lg transition-all flex items-center gap-2 justify-center"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Copy Link
            </button>
        </div>

        <div class="mt-4 flex items-center gap-2 text-sm text-silver-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Your referral code: <span class="font-mono font-bold text-purple-400">{{ $referralCode }}</span>
        </div>
    </div>

    <!-- Stats & Progress -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-purple-400 mb-1">{{ $stats['total'] }}</div>
            <div class="text-sm text-silver-500">Total Invites</div>
        </div>

        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-green-400 mb-1">{{ $stats['completed'] + $stats['rewarded'] }}</div>
            <div class="text-sm text-silver-500">Successful Referrals</div>
        </div>

        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-yellow-400 mb-1">{{ $stats['pending'] }}</div>
            <div class="text-sm text-silver-500">Pending</div>
        </div>

        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-blue-400 mb-1">{{ $stats['rewarded'] }}</div>
            <div class="text-sm text-silver-500">Rewards Earned</div>
        </div>
    </div>

    <!-- Progress to Next Reward -->
    <div class="bg-gradient-to-br from-[#16213e] to-[#1a1a2e] rounded-2xl p-6 border border-purple-500/30">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-silver-200">Progress to Next Reward</h3>
            <span class="px-3 py-1 bg-purple-600/20 text-purple-400 rounded-full text-sm font-semibold">
                {{ $completedReferrals }}/{{ $nextRewardAt }}
            </span>
        </div>

        <div class="relative w-full h-4 bg-[#0f0f0f] rounded-full overflow-hidden mb-3">
            <div class="absolute h-full bg-gradient-to-r from-purple-600 to-blue-600 rounded-full transition-all duration-500"
                 style="width: {{ $progressPercent }}%"></div>
        </div>

        <p class="text-sm text-silver-400">
            @if($completedReferrals >= $nextRewardAt)
                🎉 Congratulations! You've earned a free month!
            @else
                Invite {{ $nextRewardAt - $completedReferrals }} more {{ $nextRewardAt - $completedReferrals == 1 ? 'friend' : 'friends' }} to earn a free month
            @endif
        </p>
    </div>

    <!-- Send Invite Form -->
    <div class="bg-[#141414] rounded-2xl p-6 border border-[#2a2a2a]">
        <h3 class="text-2xl font-bold text-silver-200 mb-4">Send Invitation</h3>

        <form action="{{ route('dashboard.referral.send') }}" method="POST" class="flex flex-col md:flex-row gap-3">
            @csrf
            <div class="flex-1">
                <input
                    type="email"
                    name="email"
                    placeholder="friend@example.com"
                    required
                    class="w-full px-4 py-3 bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg text-silver-300 placeholder-silver-600 focus:outline-none focus:border-purple-500"
                />
            </div>
            <button
                type="submit"
                class="px-6 py-3 bg-silver-600 hover:bg-silver-500 text-white font-semibold rounded-lg transition-all flex items-center gap-2 justify-center"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Send Invite
            </button>
        </form>

        <p class="mt-3 text-xs text-silver-500">We'll send them an email invitation with your referral link</p>
    </div>

    <!-- Referral History -->
    @if($referrals->count() > 0)
        <div class="bg-[#141414] rounded-2xl p-6 border border-[#2a2a2a]">
            <h3 class="text-2xl font-bold text-silver-200 mb-6">Your Referrals</h3>

            <div class="space-y-3">
                @foreach($referrals as $referral)
                    <div class="flex items-center justify-between p-4 bg-[#0f0f0f] rounded-lg border border-[#2a2a2a]">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold">
                                {{ substr($referral->referred_email ?? $referral->referred->email ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-silver-200">
                                    {{ $referral->referred ? $referral->referred->name : $referral->referred_email }}
                                </div>
                                <div class="text-xs text-silver-500">
                                    Invited {{ $referral->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div>
                            @if($referral->status === 'rewarded')
                                <span class="px-3 py-1 bg-green-900/30 border border-green-500/50 text-green-400 rounded-full text-xs font-semibold">
                                    ✓ Rewarded
                                </span>
                            @elseif($referral->status === 'completed')
                                <span class="px-3 py-1 bg-blue-900/30 border border-blue-500/50 text-blue-400 rounded-full text-xs font-semibold">
                                    ✓ Joined
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-900/30 border border-yellow-500/50 text-yellow-400 rounded-full text-xs font-semibold">
                                    ⏳ Pending
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- How It Works -->
    <div class="bg-[#141414] rounded-2xl p-6 border border-[#2a2a2a]">
        <h3 class="text-2xl font-bold text-silver-200 mb-6">How It Works</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-purple-600/20 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">1️⃣</span>
                </div>
                <h4 class="font-bold text-silver-200 mb-2">Share Your Link</h4>
                <p class="text-sm text-silver-500">Send your unique referral link to friends via email or social media</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-purple-600/20 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">2️⃣</span>
                </div>
                <h4 class="font-bold text-silver-200 mb-2">They Sign Up</h4>
                <p class="text-sm text-silver-500">Your friend joins True Form Elite and gets 15% off their first month</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-purple-600/20 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">3️⃣</span>
                </div>
                <h4 class="font-bold text-silver-200 mb-2">You Both Win</h4>
                <p class="text-sm text-silver-500">Earn rewards when they complete their first 30 days</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyReferralLink() {
    const linkInput = document.getElementById('referral-link');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999); // For mobile devices

    navigator.clipboard.writeText(linkInput.value).then(() => {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;

        button.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Copied!
        `;

        button.classList.remove('from-purple-600', 'to-blue-600');
        button.classList.add('bg-green-600');

        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-green-600');
            button.classList.add('from-purple-600', 'to-blue-600');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}
</script>
@endpush
@endsection
