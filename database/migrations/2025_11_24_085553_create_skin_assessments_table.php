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
        Schema::create('skin_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('milestone_day'); // 0, 30, 60, 90, 180, 270, 360
            $table->integer('day_in_program'); // Actual day when assessment was taken
            $table->date('assessment_date');

            // 7 assessment sliders (1-10 scale)
            $table->decimal('radiance', 3, 1); // How radiant and glowing
            $table->decimal('smoothness', 3, 1); // How smooth texture feels
            $table->decimal('calmness', 3, 1); // How calm (redness/inflammation)
            $table->decimal('clarity', 3, 1); // How clear (breakouts/acne)
            $table->decimal('hydration', 3, 1); // How hydrated
            $table->decimal('firmness', 3, 1); // How firm and youthful (fine lines)
            $table->decimal('evenness', 3, 1); // How even overall tone

            // Calculated average score
            $table->decimal('skin_score', 3, 1)->storedAs(
                '(radiance + smoothness + calmness + clarity + hydration + firmness + evenness) / 7'
            );

            // Optional fields
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Unique constraint: one assessment per user per milestone
            $table->unique(['user_id', 'milestone_day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skin_assessments');
    }
};
