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
        Schema::table('referrals', function (Blueprint $table) {
            // Track if referred user's subscription is active
            $table->boolean('subscription_active')->default(false)->after('status');

            // Track subscription start and end dates
            $table->timestamp('subscription_started_at')->nullable()->after('subscription_active');
            $table->timestamp('subscription_ended_at')->nullable()->after('subscription_started_at');

            // Track total rewards earned and paid
            $table->decimal('total_earned', 10, 2)->default(0)->after('subscription_ended_at');
            $table->decimal('total_paid', 10, 2)->default(0)->after('total_earned');

            // Track discount given to referred user
            $table->decimal('discount_percentage', 5, 2)->default(15.00)->after('total_paid');
            $table->decimal('discount_amount', 10, 2)->nullable()->after('discount_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_active',
                'subscription_started_at',
                'subscription_ended_at',
                'total_earned',
                'total_paid',
                'discount_percentage',
                'discount_amount',
            ]);
        });
    }
};
