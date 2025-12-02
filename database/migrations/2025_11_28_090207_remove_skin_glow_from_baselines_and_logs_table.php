<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop mito_age_score first (it depends on skin_glow)
        DB::statement('ALTER TABLE baselines DROP COLUMN mito_age_score');

        // Remove skin_glow from baselines
        Schema::table('baselines', function (Blueprint $table) {
            $table->dropColumn('skin_glow');
        });

        // Recreate mito_age_score calculation to use 4 metrics instead of 5
        DB::statement('ALTER TABLE baselines ADD COLUMN mito_age_score DECIMAL(3,1) GENERATED ALWAYS AS ((energy + focus + sleep + gut_health) / 4) STORED');

        // Drop mito_age_score first (it depends on skin_glow)
        DB::statement('ALTER TABLE daily_logs DROP COLUMN mito_age_score');

        // Remove skin_glow from daily_logs
        Schema::table('daily_logs', function (Blueprint $table) {
            $table->dropColumn('skin_glow');
        });

        // Recreate mito_age_score calculation to use 4 metrics instead of 5
        DB::statement('ALTER TABLE daily_logs ADD COLUMN mito_age_score DECIMAL(3,1) GENERATED ALWAYS AS ((energy + focus + sleep + gut_health) / 4) STORED');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop mito_age_score first
        DB::statement('ALTER TABLE baselines DROP COLUMN mito_age_score');

        // Restore skin_glow to baselines
        Schema::table('baselines', function (Blueprint $table) {
            $table->decimal('skin_glow', 3, 1)->after('gut_health');
        });

        // Restore original mito_age_score calculation with 5 metrics
        DB::statement('ALTER TABLE baselines ADD COLUMN mito_age_score DECIMAL(3,1) GENERATED ALWAYS AS ((energy + focus + sleep + gut_health + skin_glow) / 5) STORED');

        // Drop mito_age_score first
        DB::statement('ALTER TABLE daily_logs DROP COLUMN mito_age_score');

        // Restore skin_glow to daily_logs
        Schema::table('daily_logs', function (Blueprint $table) {
            $table->decimal('skin_glow', 3, 1)->after('gut_health');
        });

        // Restore original mito_age_score calculation with 5 metrics
        DB::statement('ALTER TABLE daily_logs ADD COLUMN mito_age_score DECIMAL(3,1) GENERATED ALWAYS AS ((energy + focus + sleep + gut_health + skin_glow) / 5) STORED');
    }
};
