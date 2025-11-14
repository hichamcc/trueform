<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserProgramEnrollment;
use Illuminate\Http\Request;

class AdminProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = UserProgramEnrollment::with(['user', 'user.baseline']);

        // Filter by program status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'completed') {
                $query->whereRaw('DATEDIFF(CURRENT_DATE, start_date) > 90');
            }
        }

        // Filter by day range
        if ($request->filled('day_range')) {
            switch ($request->day_range) {
                case '0-30':
                    $query->whereRaw('DATEDIFF(CURRENT_DATE, start_date) BETWEEN 0 AND 30');
                    break;
                case '31-60':
                    $query->whereRaw('DATEDIFF(CURRENT_DATE, start_date) BETWEEN 31 AND 60');
                    break;
                case '61-90':
                    $query->whereRaw('DATEDIFF(CURRENT_DATE, start_date) BETWEEN 61 AND 90');
                    break;
            }
        }

        // Filter by baseline completion
        if ($request->filled('baseline_completed')) {
            $query->where('baseline_completed', $request->baseline_completed === 'yes');
        }

        $enrollments = $query->orderBy('start_date', 'desc')->paginate(25);

        // Calculate stats
        $stats = [
            'total' => UserProgramEnrollment::count(),
            'active' => UserProgramEnrollment::where('is_active', true)->count(),
            'completed' => UserProgramEnrollment::whereRaw('DATEDIFF(CURRENT_DATE, start_date) > 90')->count(),
        ];

        return view('admin.programs.index', compact('enrollments', 'stats'));
    }

    public function show(UserProgramEnrollment $enrollment)
    {
        $enrollment->load([
            'user.baseline',
            'user.dailyLogs' => function($q) {
                $q->orderBy('log_date', 'desc');
            },
            'user.milestones'
        ]);

        return view('admin.programs.show', compact('enrollment'));
    }
}
