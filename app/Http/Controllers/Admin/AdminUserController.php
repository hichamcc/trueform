<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'glowScans'
        ]);

        return view('admin.users.show', compact('user'));
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
