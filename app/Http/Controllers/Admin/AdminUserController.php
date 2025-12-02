<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['programEnrollment', 'baseline']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by admin status
        if ($request->filled('admin_status')) {
            $query->where('is_admin', $request->admin_status === 'admin');
        }

        // Filter by program status
        if ($request->filled('program_status')) {
            if ($request->program_status === 'active') {
                $query->whereHas('programEnrollment', function($q) {
                    $q->where('is_active', true);
                });
            } elseif ($request->program_status === 'inactive') {
                $query->whereHas('programEnrollment', function($q) {
                    $q->where('is_active', false);
                });
            }
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'baseline',
            'dailyLogs' => function($q) {
                $q->orderBy('log_date', 'desc');
            },
            'milestones',
            'programEnrollment',
            'glowScans',
            'skinAssessments' => function($q) {
                $q->orderBy('milestone_day', 'asc');
            }
        ]);

        // Calculate improvement summary (7-day rolling average vs baseline)
        $improvementSummary = $this->calculateUserImprovementSummary($user);

        // Calculate adherence stats
        $adherenceStats = $this->calculateUserAdherenceStats($user);

        // Calculate current streak
        $currentStreak = $this->calculateUserStreak($user);

        // Milestone markers for timeline
        $milestoneMarkers = $user->milestones->where('unlocked_at', '!=', null)->map(function($milestone) {
            return [
                'day' => $milestone->milestone_day,
                'date' => $milestone->unlocked_at->format('Y-m-d'),
                'title' => "Day {$milestone->milestone_day}"
            ];
        });

        return view('admin.users.show', compact(
            'user',
            'improvementSummary',
            'adherenceStats',
            'currentStreak',
            'milestoneMarkers'
        ));
    }

    /**
     * Calculate 7-day rolling average improvement vs baseline
     */
    private function calculateUserImprovementSummary(User $user)
    {
        if (!$user->baseline || $user->dailyLogs->isEmpty()) {
            return [
                'energy' => 0,
                'focus' => 0,
                'sleep' => 0,
                'gut_health' => 0,
                'mito_age_score' => 0,
            ];
        }

        // Get last 7 logs
        $last7Logs = $user->dailyLogs->take(7);

        if ($last7Logs->isEmpty()) {
            return [
                'energy' => 0,
                'focus' => 0,
                'sleep' => 0,
                'gut_health' => 0,
                'mito_age_score' => 0,
            ];
        }

        $baseline = $user->baseline;

        // Calculate rolling average
        $avg = [
            'energy' => $last7Logs->avg('energy'),
            'focus' => $last7Logs->avg('focus'),
            'sleep' => $last7Logs->avg('sleep'),
            'gut_health' => $last7Logs->avg('gut_health'),
            'mito_age_score' => $last7Logs->avg('mito_age_score'),
        ];

        // Calculate % change
        $improvements = [];
        foreach ($avg as $key => $value) {
            if (isset($baseline->{$key}) && $baseline->{$key} > 0) {
                $percentChange = (($value - $baseline->{$key}) / $baseline->{$key}) * 100;
                $improvements[$key] = round($percentChange, 1);
            } else {
                $improvements[$key] = 0;
            }
        }

        return $improvements;
    }

    /**
     * Calculate user adherence statistics
     */
    private function calculateUserAdherenceStats(User $user)
    {
        $enrollment = $user->programEnrollment;

        if (!$enrollment) {
            return [
                'days_logged' => 0,
                'days_since_start' => 0,
                'adherence_percent' => 0,
            ];
        }

        $daysSinceStart = $enrollment->getCurrentDay();
        $daysLogged = $user->dailyLogs->count();
        $adherencePercent = $daysSinceStart > 0 ? round(($daysLogged / $daysSinceStart) * 100, 1) : 0;

        return [
            'days_logged' => $daysLogged,
            'days_since_start' => $daysSinceStart,
            'adherence_percent' => $adherencePercent,
        ];
    }

    /**
     * Calculate user's current streak (consecutive days logged)
     */
    private function calculateUserStreak(User $user)
    {
        $logs = $user->dailyLogs()->orderBy('log_date', 'desc')->take(90)->get();

        if ($logs->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $expectedDate = Carbon::today();

        foreach ($logs as $log) {
            $logDate = Carbon::parse($log->log_date);
            if ($logDate->isSameDay($expectedDate)) {
                $streak++;
                $expectedDate = $expectedDate->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    public function toggleAdmin(User $user)
    {
        // Prevent users from demoting themselves
        if ($user->id === auth()->id() && $user->is_admin) {
            return redirect()->back()
                ->with('error', 'You cannot demote yourself.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $status = $user->is_admin ? 'promoted to admin' : 'demoted from admin';

        return redirect()->back()
            ->with('success', "User {$status} successfully.");
    }

    public function toggleActive(User $user)
    {
        if ($user->programEnrollment) {
            $user->programEnrollment->is_active = !$user->programEnrollment->is_active;
            $user->programEnrollment->save();

            $status = $user->programEnrollment->is_active ? 'activated' : 'deactivated';

            return redirect()->back()
                ->with('success', "User program {$status} successfully.");
        }

        return redirect()->back()
            ->with('error', 'User has no program enrollment.');
    }

    public function export(User $user)
    {
        $data = [
            'user' => $user,
            'baseline' => $user->baseline,
            'daily_logs' => $user->dailyLogs,
            'milestones' => $user->milestones,
            'program_enrollment' => $user->programEnrollment,
        ];

        $filename = "user_{$user->id}_data_" . now()->format('Y-m-d') . ".json";

        return response()->json($data)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
