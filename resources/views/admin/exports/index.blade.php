@extends('admin.layouts.admin')

@section('page-title', 'Data Exports')
@section('page-subtitle', 'Bulk data export for analysis and research')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

        <!-- Complete Export -->
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <h3 class="text-lg font-bold text-silver-100 mb-2">Complete Data Package</h3>
            <p class="text-silver-500 text-sm mb-4">Download everything as JSON</p>
            <form method="POST" action="{{ route('admin.exports.complete') }}">
                @csrf
                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Export Complete Package
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
