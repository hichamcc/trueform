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
        Schema::create('baselines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('energy', 3, 1)->comment('Energy level 1-10');
            $table->decimal('focus', 3, 1)->comment('Focus level 1-10');
            $table->decimal('sleep', 3, 1)->comment('Sleep quality 1-10');
            $table->decimal('gut_health', 3, 1)->comment('Gut health 1-10');
            $table->decimal('skin_glow', 3, 1)->comment('Skin glow 1-10');
            $table->decimal('mito_age_score', 3, 1)->virtualAs('(energy + focus + sleep + gut_health + skin_glow) / 5')->comment('Average of all metrics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baselines');
    }
};
