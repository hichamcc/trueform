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
        // Add baseline photo to baselines table
        Schema::table('baselines', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('skin_glow');
        });

        // Add current photo to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('current_photo')->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baselines', function (Blueprint $table) {
            $table->dropColumn('photo');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('current_photo');
        });
    }
};
