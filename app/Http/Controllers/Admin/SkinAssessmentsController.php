<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkinAssessment;
use App\Models\User;
use Illuminate\Http\Request;

class SkinAssessmentsController extends Controller
{
    /**
     * Display a listing of all skin assessments with filters
     */
    public function index(Request $request)
    {
        $query = SkinAssessment::with('user');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by milestone
        if ($request->filled('milestone_day')) {
            $query->where('milestone_day', $request->milestone_day);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('assessment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('assessment_date', '<=', $request->date_to);
        }

        // Order by most recent first
        $assessments = $query->orderBy('assessment_date', 'desc')->paginate(20);

        // Get all users who have submitted assessments for the filter dropdown
        $users = User::whereHas('skinAssessments')->orderBy('name')->get();

        // Milestone options for filter
        $milestones = [0, 30, 60, 90, 180, 270, 360];

        return view('admin.skin-assessments.index', compact('assessments', 'users', 'milestones'));
    }

    /**
     * Display a specific assessment
     */
    public function show(SkinAssessment $assessment)
    {
        $assessment->load('user');

        return view('admin.skin-assessments.show', compact('assessment'));
    }
}
