<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralMonthlyReward;
use App\Models\ReferralFreeMonth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReferralController extends Controller
{
    /**
     * Display all referrals
     */
    public function index(Request $request)
    {
        $query = Referral::with(['referrer', 'referred']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by subscription status
        if ($request->filled('subscription_status')) {
            if ($request->subscription_status === 'active') {
                $query->where('subscription_active', true);
            } elseif ($request->subscription_status === 'inactive') {
                $query->where('subscription_active', false);
            }
        }

        // Search by referrer or referred email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('referrer', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('referred', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('referred_email', 'like', "%{$search}%");
            });
        }

        $referrals = $query->orderBy('created_at', 'desc')->paginate(25);

        // Summary stats
        $stats = [
            'total' => Referral::count(),
            'completed' => Referral::where('status', 'completed')->orWhere('status', 'rewarded')->count(),
            'active_subscriptions' => Referral::where('subscription_active', true)->count(),
            'total_earned' => Referral::sum('total_earned'),
            'total_paid' => Referral::sum('total_paid'),
            'unpaid_balance' => Referral::sum('total_earned') - Referral::sum('total_paid'),
        ];

        return view('admin.referrals.index', compact('referrals', 'stats'));
    }

    /**
     * Display monthly rewards
     */
    public function monthlyRewards(Request $request)
    {
        $query = ReferralMonthlyReward::with(['referrer', 'referred', 'referral']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by month/year
        if ($request->filled('month') && $request->filled('year')) {
            $query->where('month', $request->month)->where('year', $request->year);
        }

        // Search by referrer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('referrer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $rewards = $query->orderBy('created_at', 'desc')->paginate(25);

        // Summary stats
        $stats = [
            'total_rewards' => ReferralMonthlyReward::count(),
            'pending' => ReferralMonthlyReward::where('status', 'pending')->count(),
            'paid' => ReferralMonthlyReward::where('status', 'paid')->count(),
            'pending_amount' => ReferralMonthlyReward::where('status', 'pending')->sum('reward_amount'),
            'paid_amount' => ReferralMonthlyReward::where('status', 'paid')->sum('reward_amount'),
        ];

        return view('admin.referrals.monthly-rewards', compact('rewards', 'stats'));
    }

    /**
     * Mark a monthly reward as paid
     */
    public function markRewardPaid(Request $request, ReferralMonthlyReward $reward)
    {
        $validated = $request->validate([
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $reward->markPaid(
            $validated['payment_method'] ?? null,
            $validated['notes'] ?? null
        );

        return redirect()->back()->with('success', 'Reward marked as paid successfully.');
    }

    /**
     * Display free months
     */
    public function freeMonths(Request $request)
    {
        $query = ReferralFreeMonth::with(['user', 'approvedBy']);

        // Filter by claimed status
        if ($request->filled('claimed')) {
            if ($request->claimed === 'yes') {
                $query->where('is_claimed', true);
            } elseif ($request->claimed === 'no') {
                $query->where('is_claimed', false);
            }
        }

        // Filter by approval status
        if ($request->filled('approved')) {
            if ($request->approved === 'yes') {
                $query->where('admin_approved', true);
            } elseif ($request->approved === 'no') {
                $query->where('admin_approved', false);
            }
        }

        // Search by user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $freeMonths = $query->orderBy('earned_at', 'desc')->paginate(25);

        // Summary stats
        $stats = [
            'total' => ReferralFreeMonth::count(),
            'unclaimed' => ReferralFreeMonth::where('is_claimed', false)->count(),
            'claimed' => ReferralFreeMonth::where('is_claimed', true)->count(),
            'pending_approval' => ReferralFreeMonth::where('admin_approved', false)->count(),
            'approved' => ReferralFreeMonth::where('admin_approved', true)->count(),
        ];

        return view('admin.referrals.free-months', compact('freeMonths', 'stats'));
    }

    /**
     * Approve a free month
     */
    public function approveFreeMonth(Request $request, ReferralFreeMonth $freeMonth)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $freeMonth->approve(auth()->user(), $validated['notes'] ?? null);

        return redirect()->back()->with('success', 'Free month approved successfully.');
    }

    /**
     * Show referral details
     */
    public function show(Referral $referral)
    {
        $referral->load(['referrer', 'referred', 'monthlyRewards' => function($q) {
            $q->orderBy('year', 'desc')->orderBy('month', 'desc');
        }]);

        return view('admin.referrals.show', compact('referral'));
    }

    /**
     * Update subscription status manually
     */
    public function updateSubscriptionStatus(Request $request, Referral $referral)
    {
        $validated = $request->validate([
            'subscription_active' => 'required|boolean',
            'subscription_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validated['subscription_active']) {
            $referral->activateSubscription($validated['subscription_amount'] ?? 0);
        } else {
            $referral->deactivateSubscription();
        }

        return redirect()->back()->with('success', 'Subscription status updated successfully.');
    }

    /**
     * Generate monthly rewards (cron job endpoint)
     * This should be called monthly to generate rewards for all active subscriptions
     */
    public function generateMonthlyRewards(Request $request)
    {
        // Verify this is being called by a trusted source (e.g., cron job, admin)
        // You might want to add authentication/authorization here

        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get all active subscriptions
        $activeReferrals = Referral::where('subscription_active', true)
            ->whereNotNull('referred_id')
            ->with(['referrer', 'referred'])
            ->get();

        $created = 0;

        foreach ($activeReferrals as $referral) {
            // Check if reward already exists for this month
            $exists = ReferralMonthlyReward::where('referral_id', $referral->id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->exists();

            if (!$exists) {
                // Assume subscription amount (you'd get this from your payment system)
                $subscriptionAmount = 100.00; // Default, should come from actual subscription data

                $rewardAmount = $subscriptionAmount * 0.10; // 10% of subscription

                ReferralMonthlyReward::create([
                    'referral_id' => $referral->id,
                    'referrer_id' => $referral->referrer_id,
                    'referred_id' => $referral->referred_id,
                    'month' => $currentMonth,
                    'year' => $currentYear,
                    'reward_amount' => $rewardAmount,
                    'subscription_amount' => $subscriptionAmount,
                    'status' => 'pending',
                ]);

                // Update referral total earned
                $referral->addEarned($rewardAmount);

                $created++;
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Generated {$created} monthly rewards for {$currentMonth}/{$currentYear}",
                'created' => $created,
            ]);
        }

        return redirect()->back()->with('success', "Generated {$created} monthly rewards successfully.");
    }
}
