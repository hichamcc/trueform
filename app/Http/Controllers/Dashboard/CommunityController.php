<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display community resources, support tools, and external integrations
     *
     * Features:
     * - Glow Scan (AI skin analysis) - Configurable via admin settings
     * - Case Study submission (Google Form) - Configurable via admin settings
     * - Community platform access (Discord/Forum) - Configurable via admin settings
     * - Referral program - Configurable via admin settings
     * - FAQ section
     * - Support contact information - Configurable via admin settings
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $enrollment = $user->programEnrollment;

        // Get current stage information (1=Foundation, 2=Expansion, 3=Mastery)
        $currentStage = $enrollment ? $enrollment->getCurrentStage() : 1;
        $stageName = $enrollment ? $enrollment->getStageName() : 'Foundation';
        $stageTheme = $enrollment ? $enrollment->getStageTheme() : [];

        // External resources and integrations (pulled from database settings)
        $resources = [
            [
                'title' => 'Submit Case Study',
                'description' => 'Share your 360-day transformation journey and inspire others',
                'icon' => 'document-text',
                'url' => Setting::get('case_study_url', '#'),
                'type' => 'primary'
            ],
            [
                'title' => 'Join Community',
                'description' => 'Connect with others on their wellness journey',
                'icon' => 'users',
                'url' => Setting::get('community_url', '#'),
                'type' => 'secondary'
            ],
        ];

        $supportEmail = Setting::get('support_email', 'support@trueform.com');

        return view('dashboard.community', compact(
            'resources',
            'enrollment',
            'currentStage',
            'stageName',
            'stageTheme',
            'supportEmail'
        ));
    }
}
