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
                    <h2 class="text-3xl font-bold text-white">Give 15% Off. Earn 10% Monthly.</h2>
                    <p class="text-purple-200">Invite friends to True Form Elite — they save on their first month, and you earn 10% monthly rewards for as long as they stay.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="text-3xl">🎁</div>
                        <div>
                            <div class="text-white font-bold text-lg">Give 15% Off</div>
                            <div class="text-purple-200 text-sm">Your friends get 15% off their first month when they join using your link.</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="text-3xl">💰</div>
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="text-white font-bold text-lg">Earn 10% Monthly</div>
                                <div class="relative group">
                                    <svg class="w-4 h-4 text-purple-300 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 p-3 bg-[#0f0f0f] border border-purple-500/50 rounded-lg text-xs text-silver-200 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                                        You earn 10% of your friend's monthly subscription fee deposited to your account each month they remain subscribed.
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-[#0f0f0f]"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-purple-200 text-sm">You earn 10% of their monthly subscription while they remain active.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Referral Link -->
    <div class="bg-[#141414] rounded-2xl p-6 border border-[#2a2a2a]">
        <h3 class="text-2xl font-bold text-silver-200 mb-2">Your Unique Referral Link</h3>
        <p class="text-silver-400 text-sm mb-4">Share this link with friends. They'll get 15% off their first month, and you'll earn 10% monthly while they stay subscribed.</p>

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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-purple-400 mb-1">{{ $stats['total'] }}</div>
            <div class="text-sm text-silver-500">Total Invites</div>
        </div>

        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-green-400 mb-1">{{ $stats['completed'] + $stats['rewarded'] }}</div>
            <div class="text-sm text-silver-500">Successful Referrals</div>
        </div>

        <div class="bg-[#141414] rounded-xl p-6 border border-[#2a2a2a] text-center">
            <div class="text-4xl font-bold text-blue-400 mb-1">${{ number_format($stats['total_earned'] ?? 0, 2) }} AUD</div>
            <div class="text-sm text-silver-500">Rewards Earned</div>
        </div>
    </div>

    <!-- Progress to Free Month -->
    @php
        $completedReferrals = $stats['completed'] + $stats['rewarded'];
        $nextFreeMonthAt = 3;
        $referralsToNextFreeMonth = max(0, $nextFreeMonthAt - ($completedReferrals % $nextFreeMonthAt));
        if ($referralsToNextFreeMonth === 0 && $completedReferrals > 0) {
            $referralsToNextFreeMonth = $nextFreeMonthAt;
        }
        $progressPercent = ($completedReferrals % $nextFreeMonthAt) / $nextFreeMonthAt * 100;
        if ($completedReferrals > 0 && $completedReferrals % $nextFreeMonthAt === 0) {
            $progressPercent = 100;
        }
        $freeMonthsEarned = floor($completedReferrals / $nextFreeMonthAt);
    @endphp
    <div class="bg-gradient-to-br from-[#16213e] to-[#1a1a2e] rounded-2xl p-6 border border-purple-500/30">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xl font-bold text-silver-200">Progress to Free Month</h3>
                @if($freeMonthsEarned > 0)
                    <p class="text-xs text-purple-300 mt-1">You've earned {{ $freeMonthsEarned }} free {{ $freeMonthsEarned == 1 ? 'month' : 'months' }} so far!</p>
                @endif
            </div>
            <span class="px-3 py-1 bg-purple-600/20 text-purple-400 rounded-full text-sm font-semibold">
                {{ $completedReferrals % $nextFreeMonthAt }}/{{ $nextFreeMonthAt }}
            </span>
        </div>

        <div class="relative w-full h-4 bg-[#0f0f0f] rounded-full overflow-hidden mb-3">
            <div class="absolute h-full bg-gradient-to-r from-purple-600 to-blue-600 rounded-full transition-all duration-500"
                 style="width: {{ $progressPercent }}%"></div>
        </div>

        <p class="text-sm text-silver-400">
            @if($completedReferrals === 0)
                🚀 Get 3 successful referrals to earn your first free month!
            @elseif($completedReferrals % $nextFreeMonthAt === 0 && $completedReferrals > 0)
                🎉 Congratulations! You've earned a free month! Keep going to earn more.
            @elseif($referralsToNextFreeMonth === 1)
                Just 1 more referral to earn your next free month!
            @else
                Invite {{ $referralsToNextFreeMonth }} more friends to earn your next free month
            @endif
        </p>
    </div>

    <!-- Send Invite Form -->
    <div class="bg-[#141414] rounded-2xl p-6 border border-[#2a2a2a]">
        <h3 class="text-2xl font-bold text-silver-200 mb-4">Send Invitation</h3>

        <form action="{{ route('dashboard.referral.send') }}" method="POST" class="space-y-4">
            @csrf
            <div class="flex flex-col md:flex-row gap-3">
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
            </div>

            <!-- Email Preview -->
            <div class="bg-[#0f0f0f] border border-[#2a2a2a] rounded-lg p-4">
                <p class="text-xs text-silver-500 mb-2">Email Preview:</p>
                <div class="space-y-2 text-sm">
                    <div class="text-silver-400">
                        <span class="text-silver-600">Subject:</span> <span class="text-silver-300">Transform Your Health with True Form Elite – Get 15% Off!</span>
                    </div>
                    <div class="text-silver-400 text-xs leading-relaxed">
                        <span class="text-silver-600">Body:</span><br/>
                        <div class="mt-2 pl-3 border-l-2 border-purple-500/30 text-silver-400">
                            Hey!<br/><br/>
                            I've been using True Form Elite to track my wellness journey, and it's been incredible. I thought you might be interested!<br/><br/>
                            Use my referral link to get <strong class="text-silver-300">15% off your first month</strong>:<br/>
                            <span class="text-purple-400 font-mono">{{ $referralLink }}</span><br/><br/>
                            It's a 360-day transformation program that helps you track energy, focus, sleep, gut health, and skin glow. If you're serious about improving your health, I think you'll love it.<br/><br/>
                            Let me know if you have any questions!<br/><br/>
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <p class="mt-3 text-xs text-silver-500">We'll send this email invitation with your referral link to your friend</p>
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
                <p class="text-sm text-silver-500">They get 15% off, and you earn 10% monthly while they stay subscribed. Every 3 referrals = 1 free month!</p>
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
