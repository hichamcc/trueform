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
        Schema::create('referral_monthly_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade');
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade'); // User earning the reward
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade'); // User who is subscribed

            // Month and year this reward is for
            $table->integer('month'); // 1-12
            $table->integer('year'); // 2025, 2026, etc.

            // Reward amount (10% of subscription fee)
            $table->decimal('reward_amount', 10, 2);
            $table->decimal('subscription_amount', 10, 2); // Original subscription amount

            // Payment status
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_method')->nullable(); // e.g., 'bank_transfer', 'paypal', 'credit'
            $table->text('notes')->nullable(); // Admin notes

            $table->timestamps();

            // Indexes for performance
            $table->index(['referrer_id', 'status']);
            $table->index(['month', 'year']);
            $table->unique(['referral_id', 'month', 'year']); // One reward per referral per month
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_monthly_rewards');
    }
};
