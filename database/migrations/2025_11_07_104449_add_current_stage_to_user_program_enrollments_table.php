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
        Schema::table('user_program_enrollments', function (Blueprint $table) {
            $table->integer('current_stage')->default(1)->after('start_date')
                ->comment('1=Foundation, 2=Expansion, 3=Mastery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_program_enrollments', function (Blueprint $table) {
            $table->dropColumn('current_stage');
        });
    }
};
