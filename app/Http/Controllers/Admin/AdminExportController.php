<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailyLog;
use App\Models\Baseline;
use App\Models\Milestone;
use Illuminate\Http\Request;

class AdminExportController extends Controller
{
    public function index()
    {
        return view('admin.exports.index');
    }

    public function users(Request $request)
    {
        $users = User::with(['baseline', 'programEnrollment'])->get();

        $csvData = [];
        $csvData[] = ['ID', 'Name', 'Email', 'Is Admin', 'Registered', 'Baseline Completed', 'Program Active'];

        foreach ($users as $user) {
            $csvData[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->is_admin ? 'Yes' : 'No',
                $user->created_at->format('Y-m-d'),
                $user->programEnrollment && $user->programEnrollment->baseline_completed ? 'Yes' : 'No',
                $user->programEnrollment && $user->programEnrollment->is_active ? 'Yes' : 'No',
            ];
        }

        return $this->generateCsv($csvData, 'users_export_' . now()->format('Y-m-d') . '.csv');
    }

    public function logs(Request $request)
    {
        $logs = DailyLog::with('user')->orderBy('log_date', 'desc')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'User Name', 'Email', 'Log Date', 'Energy', 'Focus', 'Sleep', 'Gut Health', 'Skin Glow', 'Mito-Age Score', 'Notes'];

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
                $log->skin_glow,
                $log->mito_age_score,
                $log->notes ?? '',
            ];
        }

        return $this->generateCsv($csvData, 'daily_logs_export_' . now()->format('Y-m-d') . '.csv');
    }

    public function baselines(Request $request)
    {
        $baselines = Baseline::with('user')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'User Name', 'Email', 'Energy', 'Focus', 'Sleep', 'Gut Health', 'Skin Glow', 'Mito-Age Score', 'Created At'];

        foreach ($baselines as $baseline) {
            $csvData[] = [
                $baseline->user_id,
                $baseline->user->name,
                $baseline->user->email,
                $baseline->energy,
                $baseline->focus,
                $baseline->sleep,
                $baseline->gut_health,
                $baseline->skin_glow,
                $baseline->mito_age_score,
                $baseline->created_at->format('Y-m-d'),
            ];
        }

        return $this->generateCsv($csvData, 'baselines_export_' . now()->format('Y-m-d') . '.csv');
    }

    public function complete(Request $request)
    {
        // Generate a complete data package as JSON
        $data = [
            'users' => User::with(['baseline', 'programEnrollment'])->get(),
            'daily_logs' => DailyLog::with('user')->get(),
            'baselines' => Baseline::with('user')->get(),
            'milestones' => Milestone::with('user')->get(),
            'exported_at' => now()->toDateTimeString(),
        ];

        $filename = "complete_data_export_" . now()->format('Y-m-d') . ".json";

        return response()->json($data)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }

    private function generateCsv(array $data, string $filename)
    {
        $handle = fopen('php://temp', 'r+');
        foreach ($data as $row) {
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
