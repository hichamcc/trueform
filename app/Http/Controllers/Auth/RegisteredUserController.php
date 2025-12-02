<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // Get referral code from query parameter
        $referralCode = $request->query('ref');

        return view('auth.register', compact('referralCode'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
        ]);

        // Look up referrer if referral code provided
        $referrer = null;
        if ($request->filled('referral_code')) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referred_by' => $referrer ? $referrer->id : null,
        ]);

        // Handle referral tracking
        if ($referrer) {
            $this->processReferral($referrer, $user);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect to appropriate dashboard (admin or user)
        $redirectUrl = $user->is_admin
            ? route('admin.dashboard', absolute: false)
            : route('dashboard', absolute: false);

        return redirect($redirectUrl);
    }

    /**
     * Process referral when a new user signs up with a referral code
     */
    private function processReferral(User $referrer, User $newUser): void
    {
        // Check if there's a pending referral by email
        $existingReferral = Referral::where('referrer_id', $referrer->id)
            ->where('referred_email', $newUser->email)
            ->where('status', 'pending')
            ->first();

        if ($existingReferral) {
            // Update existing referral
            $existingReferral->markCompleted($newUser);
        } else {
            // Create new referral record
            $referral = Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $newUser->id,
                'referral_code' => $referrer->referral_code,
                'referred_email' => $newUser->email,
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }

        // Check if referrer has earned a free month (every 3 completed referrals)
        $completedReferrals = $referrer->referralsMade()
            ->whereIn('status', ['completed', 'rewarded'])
            ->count();

        $referrer->checkAndAwardFreeMonth($completedReferrals);
    }
}
