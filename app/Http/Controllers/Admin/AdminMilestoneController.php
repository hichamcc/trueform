<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;

class AdminMilestoneController extends Controller
{
    public function index(Request $request)
    {
        $query = Milestone::with('user');

        // Filter by milestone day
        if ($request->filled('milestone_day')) {
            $query->where('milestone_day', $request->milestone_day);
        }

        // Filter by reward claimed status
        if ($request->filled('reward_claimed')) {
            $query->where('reward_claimed', $request->reward_claimed === 'yes');
        }

        // Filter by unlock date range
        if ($request->filled('unlocked_from')) {
            $query->where('unlocked_at', '>=', $request->unlocked_from);
        }
        if ($request->filled('unlocked_to')) {
            $query->where('unlocked_at', '<=', $request->unlocked_to);
        }

        // Only show unlocked milestones
        $query->whereNotNull('unlocked_at');

        $milestones = $query->orderBy('unlocked_at', 'desc')->paginate(25);

        // Calculate stats
        $stats = [
            'day_30_count' => Milestone::where('milestone_day', 30)->whereNotNull('unlocked_at')->count(),
            'day_60_count' => Milestone::where('milestone_day', 60)->whereNotNull('unlocked_at')->count(),
            'day_90_count' => Milestone::where('milestone_day', 90)->whereNotNull('unlocked_at')->count(),
            'rewards_claimed' => Milestone::where('reward_claimed', true)->count(),
            'total_unlocked' => Milestone::whereNotNull('unlocked_at')->count(),
        ];

        return view('admin.milestones.index', compact('milestones', 'stats'));
    }

    public function markClaimed(Milestone $milestone)
    {
        $milestone->reward_claimed = true;
        $milestone->save();

        return redirect()->back()
            ->with('success', 'Milestone reward marked as claimed.');
    }
}
