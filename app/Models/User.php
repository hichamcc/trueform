<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'referral_code',
        'referred_by',
        'current_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function baseline()
    {
        return $this->hasOne(Baseline::class);
    }

    public function dailyLogs()
    {
        return $this->hasMany(DailyLog::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function programEnrollment()
    {
        return $this->hasOne(UserProgramEnrollment::class);
    }

    public function glowScans()
    {
        return $this->hasMany(GlowScan::class);
    }

    /**
     * Get referrals made by this user (people they referred)
     */
    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * Get the referral record where this user was referred
     */
    public function referralReceived()
    {
        return $this->hasOne(Referral::class, 'referred_id');
    }

    /**
     * Get the user who referred this user
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get users referred by this user
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Generate a unique referral code for the user
     */
    public function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr($this->name, 0, 3) . rand(1000, 9999));
        } while (User::where('referral_code', $code)->exists());

        $this->update(['referral_code' => $code]);

        return $code;
    }

    /**
     * Get or create referral code
     */
    public function getReferralCode(): string
    {
        return $this->referral_code ?? $this->generateReferralCode();
    }

    /**
     * Get referral stats
     */
    public function getReferralStats(): array
    {
        $total = $this->referralsMade()->count();
        $completed = $this->referralsMade()->where('status', 'completed')->count();
        $rewarded = $this->referralsMade()->where('status', 'rewarded')->count();
        $pending = $this->referralsMade()->where('status', 'pending')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'rewarded' => $rewarded,
            'pending' => $pending,
        ];
    }
}
