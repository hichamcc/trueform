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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, url, email, textarea
            $table->string('label')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'glow_scan_url',
                'value' => '#',
                'type' => 'url',
                'label' => 'Glow Scan URL',
                'description' => 'Link to the AI-powered skin analysis tool',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'case_study_url',
                'value' => '#',
                'type' => 'url',
                'label' => 'Case Study Submission URL',
                'description' => 'Google Form link for transformation case studies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'community_url',
                'value' => '#',
                'type' => 'url',
                'label' => 'Community Platform URL',
                'description' => 'Link to Discord, Slack, or Forum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referral_url',
                'value' => '#',
                'type' => 'url',
                'label' => 'Referral Program URL',
                'description' => 'Link to referral platform',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'support_email',
                'value' => 'support@trueform.com',
                'type' => 'email',
                'label' => 'Support Email',
                'description' => 'Email address for customer support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
