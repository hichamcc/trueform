<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyLog::with('user');

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('log_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('log_date', '<=', $request->date_to);
        }

        // Search by user
        if ($request->filled('user_search')) {
            $search = $request->user_search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by has notes
        if ($request->filled('has_notes')) {
            if ($request->has_notes === 'yes') {
                $query->whereNotNull('notes');
            } else {
                $query->whereNull('notes');
            }
        }

        $logs = $query->orderBy('log_date', 'desc')->paginate(50);

        // Calculate stats
        $stats = [
            'total_logs' => DailyLog::count(),
            'logs_today' => DailyLog::whereDate('log_date', today())->count(),
            'avg_mito_score' => round(DailyLog::avg('mito_age_score'), 1),
        ];

        return view('admin.logs.index', compact('logs', 'stats'));
    }

    public function show(DailyLog $log)
    {
        $log->load('user', 'user.baseline');

        return view('admin.logs.show', compact('log'));
    }

    public function export(Request $request)
    {
        $query = DailyLog::with('user');

        // Apply same filters as index
        if ($request->filled('date_from')) {
            $query->where('log_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('log_date', '<=', $request->date_to);
        }

        $logs = $query->orderBy('log_date', 'desc')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'User Name', 'Email', 'Log Date', 'Energy', 'Focus', 'Sleep', 'Gut Health', 'Mito-Age Score', 'Notes'];

        foreach ($logs as $log) {
            $csvData[] = [
                $log->user_id,
                $log->user->name,
                $log->user->email,
                $log->log_date,
                $log->energy,
                $log->focus,
                $log->sleep,
                $log->gut_health,
                $log->mito_age_score,
                $log->notes ?? '',
            ];
        }

        $filename = "daily_logs_export_" . now()->format('Y-m-d') . ".csv";

        $handle = fopen('php://temp', 'r+');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
