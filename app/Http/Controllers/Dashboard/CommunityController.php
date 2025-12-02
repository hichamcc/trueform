<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display community resources and support tools
     *
     * Features:
     * - Community platform access (Discord/Forum) - Configurable via admin settings
     * - Community benefits showcase
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
                'title' => 'Join Community',
                'description' => 'Connect with others on their wellness journey',
                'icon' => 'users',
                'url' => Setting::get('community_url', '#'),
                'type' => 'primary'
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
