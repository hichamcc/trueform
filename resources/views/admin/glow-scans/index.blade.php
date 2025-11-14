@extends('admin.layouts.admin')

@section('page-title', 'Glow Scans Management')
@section('page-subtitle', 'Manage AI skin analysis submissions')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Total Scans</p>
            <p class="text-3xl font-bold text-silver-100 mt-2">{{ number_format($stats['total_scans']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Scans This Week</p>
            <p class="text-3xl font-bold text-green-400 mt-2">{{ number_format($stats['scans_this_week']) }}</p>
        </div>
    </div>

    <!-- Scans Table -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <h3 class="text-xl font-bold text-silver-100 mb-4">All Glow Scans</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">User</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Scan Date</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scans as $scan)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-100">{{ $scan->user->name }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ \Carbon\Carbon::parse($scan->scan_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-silver-300 text-sm">{{ $scan->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 px-4 text-center text-silver-500">No glow scans submitted yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $scans->links() }}
        </div>
    </div>
</div>
@endsection
