<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailyLog;
use App\Models\Baseline;
use App\Models\Milestone;
use App\Models\SkinAssessment;
use App\Models\UserProgramEnrollment;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        return $this->generateCsv($csvData, 'daily_logs_export_' . now()->format('Y-m-d') . '.csv');
    }

    public function baselines(Request $request)
    {
        $baselines = Baseline::with('user')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'User Name', 'Email', 'Energy', 'Focus', 'Sleep', 'Gut Health', 'Mito-Age Score', 'Created At'];

        foreach ($baselines as $baseline) {
            $csvData[] = [
                $baseline->user_id,
                $baseline->user->name,
                $baseline->user->email,
                $baseline->energy,
                $baseline->focus,
                $baseline->sleep,
                $baseline->gut_health,
                $baseline->mito_age_score,
                $baseline->created_at->format('Y-m-d'),
            ];
        }

        return $this->generateCsv($csvData, 'baselines_export_' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Export all user improvements (7-day rolling average vs baseline)
     */
    public function improvements(Request $request)
    {
        $users = User::with(['baseline', 'dailyLogs' => function($query) {
            $query->orderBy('log_date', 'desc')->take(7);
        }, 'programEnrollment'])->whereHas('baseline')->whereHas('dailyLogs')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'Name', 'Email', 'Start Date', 'Current Day', 'Energy Baseline', 'Energy Current', 'Energy Change %',
                      'Focus Baseline', 'Focus Current', 'Focus Change %', 'Sleep Baseline', 'Sleep Current', 'Sleep Change %',
                      'Gut Health Baseline', 'Gut Health Current', 'Gut Health Change %',
                      'Mito-Age Baseline', 'Mito-Age Current', 'Mito-Age Change %'];

        foreach ($users as $user) {
            if ($user->dailyLogs->isEmpty()) continue;

            $baseline = $user->baseline;
            $enrollment = $user->programEnrollment;

            // Calculate 7-day rolling average
            $avg = [
                'energy' => $user->dailyLogs->avg('energy'),
                'focus' => $user->dailyLogs->avg('focus'),
                'sleep' => $user->dailyLogs->avg('sleep'),
                'gut_health' => $user->dailyLogs->avg('gut_health'),
                'mito_age_score' => $user->dailyLogs->avg('mito_age_score'),
            ];

            $csvData[] = [
                $user->id,
                $user->name,
                $user->email,
                $enrollment ? $enrollment->start_date : 'N/A',
                $enrollment ? $enrollment->getCurrentDay() : 'N/A',
                round($baseline->energy, 1),
                round($avg['energy'], 1),
                $baseline->energy > 0 ? round((($avg['energy'] - $baseline->energy) / $baseline->energy) * 100, 1) : 0,
                round($baseline->focus, 1),
                round($avg['focus'], 1),
                $baseline->focus > 0 ? round((($avg['focus'] - $baseline->focus) / $baseline->focus) * 100, 1) : 0,
                round($baseline->sleep, 1),
                round($avg['sleep'], 1),
                $baseline->sleep > 0 ? round((($avg['sleep'] - $baseline->sleep) / $baseline->sleep) * 100, 1) : 0,
                round($baseline->gut_health, 1),
                round($avg['gut_health'], 1),
                $baseline->gut_health > 0 ? round((($avg['gut_health'] - $baseline->gut_health) / $baseline->gut_health) * 100, 1) : 0,
                round($baseline->mito_age_score, 1),
                round($avg['mito_age_score'], 1),
                $baseline->mito_age_score > 0 ? round((($avg['mito_age_score'] - $baseline->mito_age_score) / $baseline->mito_age_score) * 100, 1) : 0,
            ];
        }

        return $this->generateCsv($csvData, 'user_improvements_export_' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Export all skin assessments
     */
    public function skinAssessments(Request $request)
    {
        $assessments = SkinAssessment::with('user')->orderBy('created_at', 'desc')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'Name', 'Email', 'Milestone Day', 'Date', 'Radiance', 'Smoothness', 'Calmness',
                      'Clarity', 'Hydration', 'Firmness', 'Evenness', 'Average Score', 'Notes'];

        foreach ($assessments as $assessment) {
            $avgScore = ($assessment->radiance + $assessment->smoothness + $assessment->calmness +
                        $assessment->clarity + $assessment->hydration + $assessment->firmness +
                        $assessment->evenness) / 7;

            $csvData[] = [
                $assessment->user_id,
                $assessment->user->name,
                $assessment->user->email,
                $assessment->milestone_day,
                $assessment->created_at->format('Y-m-d'),
                $assessment->radiance,
                $assessment->smoothness,
                $assessment->calmness,
                $assessment->clarity,
                $assessment->hydration,
                $assessment->firmness,
                $assessment->evenness,
                round($avgScore, 1),
                $assessment->notes ?? '',
            ];
        }

        return $this->generateCsv($csvData, 'skin_assessments_export_' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Export all milestone achievements
     */
    public function milestones(Request $request)
    {
        $milestones = Milestone::with('user')->whereNotNull('unlocked_at')->orderBy('unlocked_at', 'desc')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'Name', 'Email', 'Milestone Day', 'Unlocked At', 'Reward Claimed', 'Reward Title'];

        foreach ($milestones as $milestone) {
            $csvData[] = [
                $milestone->user_id,
                $milestone->user->name,
                $milestone->user->email,
                $milestone->milestone_day,
                $milestone->unlocked_at->format('Y-m-d H:i:s'),
                $milestone->reward_claimed ? 'Yes' : 'No',
                $milestone->reward_title ?? '',
            ];
        }

        return $this->generateCsv($csvData, 'milestones_export_' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Export all program enrollments
     */
    public function programs(Request $request)
    {
        $enrollments = UserProgramEnrollment::with('user')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'Name', 'Email', 'Start Date', 'Current Day', 'Days Remaining', 'Is Active', 'Baseline Completed'];

        foreach ($enrollments as $enrollment) {
            $csvData[] = [
                $enrollment->user_id,
                $enrollment->user->name,
                $enrollment->user->email,
                $enrollment->start_date,
                $enrollment->getCurrentDay(),
                $enrollment->getDaysRemaining(),
                $enrollment->is_active ? 'Yes' : 'No',
                $enrollment->baseline_completed ? 'Yes' : 'No',
            ];
        }

        return $this->generateCsv($csvData, 'programs_export_' . now()->format('Y-m-d') . '.csv');
    }

    /**
     * Export with date range - comprehensive user data
     */
    public function dateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $users = User::with(['baseline', 'programEnrollment', 'dailyLogs' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('log_date', [$startDate, $endDate])->orderBy('log_date', 'desc');
        }])->whereHas('baseline')->get();

        $csvData = [];
        $csvData[] = ['User ID', 'Email', 'Start Date', 'Baseline Energy', 'Baseline Focus', 'Baseline Sleep',
                      'Baseline Gut', 'Baseline Mito-Age', 'Latest 7-Day Avg Energy',
                      'Latest 7-Day Avg Focus', 'Latest 7-Day Avg Sleep', 'Latest 7-Day Avg Gut',
                      'Latest 7-Day Avg Mito-Age', 'Energy Change %', 'Focus Change %',
                      'Sleep Change %', 'Gut Change %', 'Mito-Age Change %', 'Logs Count',
                      'Days In Period', 'Adherence %'];

        foreach ($users as $user) {
            if (!$user->programEnrollment) continue;

            $baseline = $user->baseline;
            $enrollment = $user->programEnrollment;
            $logsInPeriod = $user->dailyLogs->take(7);

            if ($logsInPeriod->isEmpty()) continue;

            $daysInPeriod = $startDate->diffInDays($endDate) + 1;
            $logsCount = $user->dailyLogs->count();
            $adherencePercent = $daysInPeriod > 0 ? round(($logsCount / $daysInPeriod) * 100, 1) : 0;

            // Calculate 7-day rolling average
            $avg = [
                'energy' => $logsInPeriod->avg('energy'),
                'focus' => $logsInPeriod->avg('focus'),
                'sleep' => $logsInPeriod->avg('sleep'),
                'gut_health' => $logsInPeriod->avg('gut_health'),
                'mito_age_score' => $logsInPeriod->avg('mito_age_score'),
            ];

            $csvData[] = [
                $user->id,
                $user->email,
                $enrollment->start_date,
                round($baseline->energy, 1),
                round($baseline->focus, 1),
                round($baseline->sleep, 1),
                round($baseline->gut_health, 1),
                round($baseline->mito_age_score, 1),
                round($avg['energy'], 1),
                round($avg['focus'], 1),
                round($avg['sleep'], 1),
                round($avg['gut_health'], 1),
                round($avg['mito_age_score'], 1),
                $baseline->energy > 0 ? round((($avg['energy'] - $baseline->energy) / $baseline->energy) * 100, 1) : 0,
                $baseline->focus > 0 ? round((($avg['focus'] - $baseline->focus) / $baseline->focus) * 100, 1) : 0,
                $baseline->sleep > 0 ? round((($avg['sleep'] - $baseline->sleep) / $baseline->sleep) * 100, 1) : 0,
                $baseline->gut_health > 0 ? round((($avg['gut_health'] - $baseline->gut_health) / $baseline->gut_health) * 100, 1) : 0,
                $baseline->mito_age_score > 0 ? round((($avg['mito_age_score'] - $baseline->mito_age_score) / $baseline->mito_age_score) * 100, 1) : 0,
                $logsCount,
                $daysInPeriod,
                $adherencePercent,
            ];
        }

        $filename = 'date_range_export_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        return $this->generateCsv($csvData, $filename);
    }

    public function complete(Request $request)
    {
        // Generate a complete data package as JSON
        $data = [
            'users' => User::with(['baseline', 'programEnrollment'])->get(),
            'daily_logs' => DailyLog::with('user')->get(),
            'baselines' => Baseline::with('user')->get(),
            'milestones' => Milestone::with('user')->get(),
            'skin_assessments' => SkinAssessment::with('user')->get(),
            'program_enrollments' => UserProgramEnrollment::with('user')->get(),
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
