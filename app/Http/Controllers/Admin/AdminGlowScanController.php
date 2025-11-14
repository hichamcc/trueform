<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlowScan;
use Illuminate\Http\Request;

class AdminGlowScanController extends Controller
{
    public function index(Request $request)
    {
        $query = GlowScan::with('user');

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('scan_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('scan_date', '<=', $request->date_to);
        }

        // Search by user
        if ($request->filled('user_search')) {
            $search = $request->user_search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $scans = $query->orderBy('scan_date', 'desc')->paginate(25);

        $stats = [
            'total_scans' => GlowScan::count(),
            'scans_this_week' => GlowScan::whereBetween('scan_date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('admin.glow-scans.index', compact('scans', 'stats'));
    }

    public function show(GlowScan $scan)
    {
        $scan->load('user');

        return view('admin.glow-scans.show', compact('scan'));
    }
}
