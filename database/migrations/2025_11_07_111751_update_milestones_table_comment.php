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
        Schema::table('milestones', function (Blueprint $table) {
            $table->integer('milestone_day')
                ->comment('Stage 1: 30/60/90, Stage 2: 120/150/180, Stage 3: 270/360')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('milestones', function (Blueprint $table) {
            $table->integer('milestone_day')
                ->comment('Day 30, 60, or 90')
                ->change();
        });
    }
};
