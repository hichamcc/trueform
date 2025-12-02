<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserProgramEnrollment;
use App\Models\Milestone;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Generate referral code automatically
        if (!$user->referral_code) {
            $user->generateReferralCode();
        }

        // Create program enrollment automatically (unless admin)
        if (!$user->is_admin) {
            UserProgramEnrollment::create([
                'user_id' => $user->id,
                'start_date' => now()->toDateString(),
                'is_active' => true,
                'baseline_completed' => false,
            ]);

            // Create milestone placeholders
            $milestoneDays = [30, 60, 90, 120, 150, 180, 270, 360];
            foreach ($milestoneDays as $day) {
                Milestone::create([
                    'user_id' => $user->id,
                    'milestone_day' => $day,
                    'unlocked_at' => null,
                ]);
            }
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
