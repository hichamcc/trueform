@extends('admin.layouts.admin')

@section('page-title', 'Data Exports')
@section('page-subtitle', 'Bulk data export for analysis and research')

@section('content')
<div class="space-y-6">
    <!-- Date Range Export -->
    <div class="bg-gradient-to-br from-[#1a1a2e] to-[#16213e] rounded-2xl p-8 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-2">Date Range Export</h3>
        <p class="text-silver-500 text-sm mb-6">Export user data with 7-day rolling averages for a specific date range</p>
        <form method="POST" action="{{ route('admin.exports.date-range') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-silver-300 text-sm mb-2">Start Date</label>
                <input type="date" name="start_date" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-silver-300 text-sm mb-2">End Date</label>
                <input type="date" name="end_date" required
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Date Range CSV
                </button>
            </div>
        </form>
    </div>

    <!-- Standard Exports Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Export Users -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export Users</h3>
            <p class="text-silver-500 text-sm mb-4">Download all user data as CSV</p>
            <form method="POST" action="{{ route('admin.exports.users') }}">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Users CSV
                </button>
            </form>
        </div>

        <!-- Export Logs -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export Daily Logs</h3>
            <p class="text-silver-500 text-sm mb-4">Download all daily logs as CSV</p>
            <form method="POST" action="{{ route('admin.exports.logs') }}">
                @csrf
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Logs CSV
                </button>
            </form>
        </div>

        <!-- Export Baselines -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export Baselines</h3>
            <p class="text-silver-500 text-sm mb-4">Download all baseline metrics as CSV</p>
            <form method="POST" action="{{ route('admin.exports.baselines') }}">
                @csrf
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Baselines CSV
                </button>
            </form>
        </div>

        <!-- Export User Improvements -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export User Improvements</h3>
            <p class="text-silver-500 text-sm mb-4">7-day rolling average vs baseline for all users</p>
            <form method="POST" action="{{ route('admin.exports.improvements') }}">
                @csrf
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Improvements CSV
                </button>
            </form>
        </div>

        <!-- Export Skin Assessments -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export Skin Assessments</h3>
            <p class="text-silver-500 text-sm mb-4">Download all skin glow assessments as CSV</p>
            <form method="POST" action="{{ route('admin.exports.skin-assessments') }}">
                @csrf
                <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Assessments CSV
                </button>
            </form>
        </div>

        <!-- Export Milestones -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export Milestones</h3>
            <p class="text-silver-500 text-sm mb-4">Download all milestone achievements as CSV</p>
            <form method="POST" action="{{ route('admin.exports.milestones') }}">
                @csrf
                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Milestones CSV
                </button>
            </form>
        </div>

        <!-- Export Programs -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Export Program Enrollments</h3>
            <p class="text-silver-500 text-sm mb-4">Download all program enrollment data as CSV</p>
            <form method="POST" action="{{ route('admin.exports.programs') }}">
                @csrf
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Programs CSV
                </button>
            </form>
        </div>

        <!-- Complete Export -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Complete Data Package</h3>
            <p class="text-silver-500 text-sm mb-4">Download everything as JSON</p>
            <form method="POST" action="{{ route('admin.exports.complete') }}">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Complete Package
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
