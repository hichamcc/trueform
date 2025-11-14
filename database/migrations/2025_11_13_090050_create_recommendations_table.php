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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->enum('kpi', ['energy', 'focus', 'sleep', 'gut_health', 'skin_glow'])->comment('Which KPI this recommendation targets');
            $table->string('product_name')->comment('Name of the recommended product');
            $table->string('product_link')->nullable()->comment('URL link to the product');
            $table->text('description')->nullable()->comment('Brief description of the product');
            $table->boolean('is_active')->default(true)->comment('Whether this recommendation is active');
            $table->integer('priority')->default(0)->comment('Display priority (higher = shown first)');
            $table->timestamps();

            // Index for faster queries
            $table->index(['kpi', 'is_active', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
