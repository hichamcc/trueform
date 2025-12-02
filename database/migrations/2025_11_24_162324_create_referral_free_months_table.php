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
        Schema::create('referral_free_months', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User who earned the free month

            // Earned at (when they hit 3/6/9 referrals)
            $table->timestamp('earned_at');
            $table->integer('referral_milestone'); // 3, 6, 9, etc. (which multiple of 3)

            // Claimed status
            $table->boolean('is_claimed')->default(false);
            $table->timestamp('claimed_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // Free months might expire if not used within X months

            // Which month the free subscription applies to
            $table->integer('applied_month')->nullable(); // 1-12
            $table->integer('applied_year')->nullable(); // 2025, 2026, etc.

            // Admin tracking
            $table->boolean('admin_approved')->default(false);
            $table->timestamp('admin_approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'is_claimed']);
            $table->index(['earned_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_free_months');
    }
};
