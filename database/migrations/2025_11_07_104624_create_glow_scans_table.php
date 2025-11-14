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
        Schema::create('glow_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('scan_date');
            $table->decimal('glow_score', 4, 1)->comment('0-100 scale');
            $table->string('image_path')->nullable();
            $table->json('api_response')->nullable()->comment('Full API response data');
            $table->timestamps();

            $table->index(['user_id', 'scan_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glow_scans');
    }
};
