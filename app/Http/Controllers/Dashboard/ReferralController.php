<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Mail\ReferralInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Ensure user has a referral code
        $referralCode = $user->getReferralCode();

        // Get referral stats
        $stats = $user->getReferralStats();

        // Get referral list with details
        $referrals = $user->referralsMade()
            ->with('referred')
            ->orderBy('created_at', 'desc')
            ->get();

        // Generate referral link
        $referralLink = url('/register?ref=' . $referralCode);

        // Calculate progress towards rewards
        $completedReferrals = $stats['completed'] + $stats['rewarded'];
        $nextRewardAt = 3; // 3 referrals for first reward
        $progressPercent = min(100, ($completedReferrals / $nextRewardAt) * 100);

        return view('dashboard.referral', compact(
            'user',
            'referralCode',
            'referralLink',
            'stats',
            'referrals',
            'completedReferrals',
            'nextRewardAt',
            'progressPercent'
        ));
    }

    public function sendInvite(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = $request->user();
        $referralCode = $user->getReferralCode();

        // Check if already invited
        $existing = Referral::where('referrer_id', $user->id)
            ->where('referred_email', $validated['email'])
            ->first();

        if ($existing) {
            return redirect()->route('dashboard.referral')
                ->with('error', 'You have already invited this email address.');
        }

        // Create referral record
        Referral::create([
            'referrer_id' => $user->id,
            'referral_code' => $referralCode,
            'referred_email' => $validated['email'],
            'status' => 'pending',
        ]);

        // Send invitation email
        try {
            Mail::to($validated['email'])->send(new ReferralInvitation($user, $referralCode));
            $message = 'Invitation sent successfully!';
        } catch (\Exception $e) {
            // Log error but still show success to user
            \Log::error('Failed to send referral email: ' . $e->getMessage());
            $message = 'Referral tracked! (Email sending is not configured yet)';
        }

        return redirect()->route('dashboard.referral')
            ->with('success', $message);
    }

    public function copyLink(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Referral link copied to clipboard!'
        ]);
    }
}
