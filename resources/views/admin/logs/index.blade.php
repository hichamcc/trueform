@extends('admin.layouts.admin')

@section('page-title', 'Daily Logs Management')
@section('page-subtitle', 'View and analyze all daily logs')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Total Logs</p>
            <p class="text-3xl font-bold text-silver-100 mt-2">{{ number_format($stats['total_logs']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Logs Today</p>
            <p class="text-3xl font-bold text-green-400 mt-2">{{ number_format($stats['logs_today']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Avg Mito-Age Score</p>
            <p class="text-3xl font-bold text-blue-400 mt-2">{{ $stats['avg_mito_score'] }}</p>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-silver-100">All Daily Logs</h3>
            <a href="{{ route('admin.logs.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-medium transition-colors text-sm">
                Export CSV
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">User</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Log Date</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Energy</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Focus</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Sleep</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Mito-Age</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-100">{{ $log->user->name }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ \Carbon\Carbon::parse($log->log_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->energy }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->focus }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $log->sleep }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-sm font-medium">
                                    {{ number_format($log->mito_age_score, 1) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-silver-500">No logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
