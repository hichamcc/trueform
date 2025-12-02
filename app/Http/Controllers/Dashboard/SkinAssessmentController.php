<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SkinAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkinAssessmentController extends Controller
{
    /**
     * Display the Skin Glow Assessment page with milestone cards
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $enrollment = $user->programEnrollment;

        if (!$enrollment) {
            return redirect()->route('dashboard')->with('error', 'Please complete your program enrollment first.');
        }

        $currentDay = $enrollment->getCurrentDay();

        // Get all assessments for this user
        $assessments = $user->skinAssessments()->orderBy('milestone_day')->get()->keyBy('milestone_day');

        // Define all milestones
        $milestones = [0, 30, 60, 90, 180, 270, 360];

        // Build milestone data
        $milestoneData = collect($milestones)->map(function ($day) use ($assessments, $currentDay) {
            $assessment = $assessments->get($day);
            $isAvailable = $currentDay >= $day;

            return [
                'day' => $day,
                'label' => $day === 0 ? 'Baseline' : "Day {$day}",
                'is_completed' => $assessment !== null,
                'is_available' => $isAvailable,
                'assessment' => $assessment,
            ];
        });

        // Get current and baseline scores for comparison
        $latestAssessment = $user->skinAssessments()->latest('assessment_date')->first();
        $baselineAssessment = $assessments->get(0);

        $currentScore = $latestAssessment?->skin_score;
        $baselineScore = $baselineAssessment?->skin_score;
        $changeVsBaseline = null;

        if ($currentScore && $baselineScore) {
            $changeVsBaseline = $currentScore - $baselineScore;
        }

        return view('dashboard.skin-assessment.index', compact(
            'milestoneData',
            'currentDay',
            'latestAssessment',
            'baselineAssessment',
            'currentScore',
            'baselineScore',
            'changeVsBaseline'
        ));
    }

    /**
     * Show the form for a specific milestone
     */
    public function create(Request $request, $milestoneDay)
    {
        $user = $request->user();
        $enrollment = $user->programEnrollment;

        if (!$enrollment) {
            return redirect()->route('dashboard')->with('error', 'Please complete your program enrollment first.');
        }

        $currentDay = $enrollment->getCurrentDay();

        // Check if milestone is available
        if ($currentDay < $milestoneDay) {
            return redirect()->route('dashboard.skin-assessment.index')
                ->with('error', "This assessment will be available on Day {$milestoneDay}.");
        }

        // Check if already completed
        $existingAssessment = $user->skinAssessments()->where('milestone_day', $milestoneDay)->first();
        if ($existingAssessment) {
            return redirect()->route('dashboard.skin-assessment.show', $existingAssessment->id);
        }

        $milestoneLabel = $milestoneDay === 0 ? 'Baseline' : "Day {$milestoneDay}";

        return view('dashboard.skin-assessment.create', compact('milestoneDay', 'milestoneLabel', 'currentDay'));
    }

    /**
     * Store a new assessment
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $enrollment = $user->programEnrollment;

        if (!$enrollment) {
            return redirect()->route('dashboard')->with('error', 'Please complete your program enrollment first.');
        }

        $currentDay = $enrollment->getCurrentDay();

        $validated = $request->validate([
            'milestone_day' => 'required|integer|in:0,30,60,90,180,270,360',
            'radiance' => 'required|numeric|min:1|max:10',
            'smoothness' => 'required|numeric|min:1|max:10',
            'calmness' => 'required|numeric|min:1|max:10',
            'clarity' => 'required|numeric|min:1|max:10',
            'hydration' => 'required|numeric|min:1|max:10',
            'firmness' => 'required|numeric|min:1|max:10',
            'evenness' => 'required|numeric|min:1|max:10',
            'photo' => 'nullable|image|max:5120', // 5MB max
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if milestone is available
        if ($currentDay < $validated['milestone_day']) {
            return back()->with('error', "This assessment is not yet available.");
        }

        // Check if already exists
        $existing = $user->skinAssessments()->where('milestone_day', $validated['milestone_day'])->first();
        if ($existing) {
            return redirect()->route('dashboard.skin-assessment.show', $existing->id)
                ->with('error', 'You have already completed this assessment.');
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('skin-assessments', 'public');
        }

        // Create assessment
        $assessment = $user->skinAssessments()->create([
            ...$validated,
            'day_in_program' => $currentDay,
            'assessment_date' => now(),
        ]);

        return redirect()->route('dashboard.skin-assessment.index')
            ->with('success', 'Your Skin Glow Assessment has been saved and your Skin Score has been updated.');
    }

    /**
     * Display a specific assessment
     */
    public function show(Request $request, SkinAssessment $assessment)
    {
        // Ensure user can only view their own assessments
        if ($assessment->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('dashboard.skin-assessment.show', compact('assessment'));
    }
}
