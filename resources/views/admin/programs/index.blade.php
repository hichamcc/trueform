@extends('admin.layouts.admin')

@section('page-title', 'Program Management')
@section('page-subtitle', 'Monitor all 90-day program enrollments')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Total Enrollments</p>
            <p class="text-3xl font-bold text-silver-100 mt-2">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Active Programs</p>
            <p class="text-3xl font-bold text-green-400 mt-2">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
            <p class="text-silver-500 text-sm">Completed</p>
            <p class="text-3xl font-bold text-blue-400 mt-2">{{ number_format($stats['completed']) }}</p>
        </div>
    </div>

    <!-- Enrollments Table -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">User</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Start Date</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Current Day</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Days Remaining</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Status</th>
                        <th class="text-right py-3 px-4 text-silver-400 font-medium text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-100">{{ $enrollment->user->name }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ \Carbon\Carbon::parse($enrollment->start_date)->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-silver-300">Day {{ $enrollment->getCurrentDay() }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $enrollment->getDaysRemaining() }} days</td>
                            <td class="py-3 px-4">
                                @if($enrollment->is_active)
                                    <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-xs font-medium">Active</span>
                                @else
                                    <span class="px-3 py-1 bg-red-600/20 text-red-400 rounded-lg text-xs font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.users.show', $enrollment->user) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                                    View User
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-silver-500">No enrollments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $enrollments->links() }}
        </div>
    </div>
</div>
@endsection
