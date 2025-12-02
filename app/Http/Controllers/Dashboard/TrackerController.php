<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baseline;
use App\Models\DailyLog;
use App\Models\Milestone;
use App\Models\UserProgramEnrollment;
use Carbon\Carbon;

class TrackerController extends Controller
{
    /**
     * Display the tracker interface for baseline setup and daily logging
     * Supports 360-day program with 3 stages and 5 wellness metrics
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $baseline = $user->baseline;
        $enrollment = $user->programEnrollment;

        // Get current stage information (1=Foundation, 2=Expansion, 3=Mastery)
        $currentStage = $enrollment ? $enrollment->getCurrentStage() : 1;
        $stageName = $enrollment ? $enrollment->getStageName() : 'Foundation';
        $stageTheme = $enrollment ? $enrollment->getStageTheme() : [];

        // Check if user has already logged today
        $todayLog = $user->dailyLogs()
            ->whereDate('log_date', Carbon::today())
            ->first();

        return view('dashboard.tracker', compact(
            'baseline',
            'enrollment',
            'todayLog',
            'currentStage',
            'stageName',
            'stageTheme'
        ));
    }

    /**
     * Store or update user's baseline metrics (starting point for 360-day journey)
     * Metrics: Energy, Focus, Sleep, Gut Health, Skin Glow (scale 1-10)
     */
    public function storeBaseline(Request $request)
    {
        $validated = $request->validate([
            'energy' => 'required|numeric|min:1|max:10',
            'focus' => 'required|numeric|min:1|max:10',
            'sleep' => 'required|numeric|min:1|max:10',
            'gut_health' => 'required|numeric|min:1|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            // Skin assessment fields (optional)
            'radiance' => 'nullable|numeric|min:1|max:10',
            'smoothness' => 'nullable|numeric|min:1|max:10',
            'calmness' => 'nullable|numeric|min:1|max:10',
            'clarity' => 'nullable|numeric|min:1|max:10',
            'hydration' => 'nullable|numeric|min:1|max:10',
            'firmness' => 'nullable|numeric|min:1|max:10',
            'evenness' => 'nullable|numeric|min:1|max:10',
            'skin_notes' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        // Handle image upload if present (legacy field)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'baseline_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('baselines', $filename, 'public');
            $validated['image'] = $path;
        }

        // Handle photo upload if present (before photo)
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'baseline_photo_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('baselines', $filename, 'public');
            $validated['photo'] = $path;
        }

        // Create or update baseline (Mito-Age Score auto-calculated in database)
        $baselineData = [
            'energy' => $validated['energy'],
            'focus' => $validated['focus'],
            'sleep' => $validated['sleep'],
            'gut_health' => $validated['gut_health'],
        ];

        if (isset($validated['image'])) {
            $baselineData['image'] = $validated['image'];
        }

        if (isset($validated['photo'])) {
            $baselineData['photo'] = $validated['photo'];
        }

        Baseline::updateOrCreate(
            ['user_id' => $user->id],
            $baselineData
        );

        // Create baseline skin assessment if skin data is provided
        if ($request->filled('radiance')) {
            $skinAssessmentData = [
                'milestone_day' => 0, // Baseline
                'day_in_program' => 0,
                'assessment_date' => now(),
                'radiance' => $validated['radiance'],
                'smoothness' => $validated['smoothness'],
                'calmness' => $validated['calmness'],
                'clarity' => $validated['clarity'],
                'hydration' => $validated['hydration'],
                'firmness' => $validated['firmness'],
                'evenness' => $validated['evenness'],
                'notes' => $validated['skin_notes'] ?? null,
            ];

            // Use the same photo for skin assessment if uploaded
            if (isset($validated['photo'])) {
                $skinAssessmentData['photo'] = $validated['photo'];
            }

            $user->skinAssessments()->updateOrCreate(
                ['user_id' => $user->id, 'milestone_day' => 0],
                $skinAssessmentData
            );
        }

        // Mark baseline as completed in enrollment
        $enrollment = $user->programEnrollment;
        if ($enrollment) {
            $enrollment->update(['baseline_completed' => true]);
        }

        $message = 'Baseline metrics saved successfully!';
        if ($request->filled('radiance')) {
            $message .= ' Your baseline skin assessment has also been recorded.';
        }

        return redirect()->route('dashboard.tracker')
            ->with('success', $message);
    }

    /**
     * Store or update today's daily log
     * Automatically handles:
     * - Streak counter updates (consecutive days)
     * - Stage progression (Foundation→Expansion→Mastery)
     * - Milestone unlocking (8 milestones across 360 days)
     */
    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'energy' => 'required|numeric|min:1|max:10',
            'focus' => 'required|numeric|min:1|max:10',
            'sleep' => 'required|numeric|min:1|max:10',
            'gut_health' => 'required|numeric|min:1|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        // Save daily log (Mito-Age Score auto-calculated in database)
        DailyLog::updateOrCreate(
            [
                'user_id' => $user->id,
                'log_date' => Carbon::today()
            ],
            $validated
        );

        // Update streak counter (consecutive days logged)
        $enrollment = $user->programEnrollment;
        if ($enrollment) {
            $enrollment->updateStreak();
        }

        // Check and update stage progression (days 1-90, 91-180, 181-360)
        $this->updateStageProgression($user);

        // Check and unlock milestones (days 30, 60, 90, 120, 150, 180, 270, 360)
        $this->checkAndUnlockMilestones($user);

        return redirect()->route('dashboard.tracker')
            ->with('success', 'Daily log saved successfully!');
    }

    /**
     * Automatically update user's current stage based on their day count
     *
     * Stage Progression Logic:
     * - Stage 1 (Foundation): Days 1-90 (Building healthy habits)
     * - Stage 2 (Expansion): Days 91-180 (Deepening practice)
     * - Stage 3 (Mastery): Days 181-360 (Long-term transformation)
     *
     * Stage transitions happen automatically when user logs metrics
     */
    private function updateStageProgression($user)
    {
        $enrollment = $user->programEnrollment;
        if (!$enrollment) return;

        $calculatedStage = $enrollment->getCurrentStage();

        // Only update database if stage has changed (prevents unnecessary writes)
        if ($enrollment->current_stage !== $calculatedStage) {
            $enrollment->update(['current_stage' => $calculatedStage]);
        }
    }

    /**
     * Automatically check and unlock milestones across the 360-day journey
     *
     * Milestone Schedule:
     * - Stage 1 (Foundation): Day 30, 60, 90
     * - Stage 2 (Expansion): Day 120, 150, 180
     * - Stage 3 (Mastery): Day 270, 360
     *
     * Total: 8 milestones with stage-specific rewards
     *
     * Milestones unlock automatically when user reaches or passes the milestone day
     * Each milestone includes a title, description, and optional reward
     */
    private function checkAndUnlockMilestones($user)
    {
        $enrollment = $user->programEnrollment;
        if (!$enrollment) return;

        $currentDay = $enrollment->getCurrentDay();

        // Iterate through all 8 milestone days (defined in Milestone model)
        foreach (Milestone::VALID_MILESTONE_DAYS as $milestoneDay) {
            // Unlock milestone if user has reached or passed this day
            if ($currentDay >= $milestoneDay) {
                // Get default reward configuration from Milestone model
                $milestone = new Milestone(['milestone_day' => $milestoneDay]);
                $reward = $milestone->getDefaultReward();

                // Create or update milestone (idempotent - safe to run multiple times)
                $user->milestones()->updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'milestone_day' => $milestoneDay
                    ],
                    [
                        'unlocked_at' => Carbon::now(),
                        'reward_title' => $reward['title'],
                        'reward_description' => $reward['description']
                    ]
                );
            }
        }
    }

    /**
     * Update user's current photo (for before/after comparison)
     */
    public function updateCurrentPhoto(Request $request)
    {
        $validated = $request->validate([
            'current_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $user = $request->user();

        // Handle current photo upload
        if ($request->hasFile('current_photo')) {
            $photo = $request->file('current_photo');
            $filename = 'current_photo_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('current_photos', $filename, 'public');

            // Update user's current photo
            $user->update(['current_photo' => $path]);
        }

        return redirect()->route('dashboard.my-profile')
            ->with('success', 'Current photo updated successfully!');
    }
}
