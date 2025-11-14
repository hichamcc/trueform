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
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('milestone_day')->comment('Day 30, 60, or 90');
            $table->timestamp('unlocked_at')->nullable();
            $table->boolean('reward_claimed')->default(false);
            $table->string('reward_title')->nullable();
            $table->text('reward_description')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'milestone_day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
