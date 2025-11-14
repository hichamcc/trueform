<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade'); // User who is referring
            $table->foreignId('referred_id')->nullable()->constrained('users')->onDelete('set null'); // User who was referred
            $table->string('referral_code')->unique(); // Unique referral code for the referrer
            $table->string('referred_email')->nullable(); // Email of referred person (before they sign up)
            $table->enum('status', ['pending', 'completed', 'rewarded'])->default('pending');
            // pending: invited but not signed up, completed: signed up, rewarded: reward given
            $table->timestamp('completed_at')->nullable(); // When the referred user signed up
            $table->timestamp('rewarded_at')->nullable(); // When the reward was given
            $table->string('reward_type')->nullable(); // Type of reward (free_month, discount, etc.)
            $table->timestamps();

            // Indexes for performance
            $table->index('referral_code');
            $table->index('status');
        });

        // Add referral_code column to users table if it doesn't exist
        if (!Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('referral_code')->unique()->nullable()->after('email');
                $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');

        // Remove columns from users table
        if (Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['referred_by']);
                $table->dropColumn(['referral_code', 'referred_by']);
            });
        }
    }
};
