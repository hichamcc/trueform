@extends('admin.layouts.admin')

@section('page-title', 'Skin Assessments')
@section('page-subtitle', 'View and manage user skin glow assessments')

@section('content')
<div class="space-y-4">
    <!-- Filters -->
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl p-4 border border-silver-900/30">
        <h3 class="text-sm font-semibold text-silver-300 mb-3">Filters</h3>

        <form method="GET" action="{{ route('admin.skin-assessments.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <!-- User Filter -->
            <div>
                <label for="user_id" class="block text-xs text-gray-400 mb-1">User</label>
                <select name="user_id" id="user_id"
                        class="w-full px-3 py-2 bg-[#0a0a0a] border border-silver-900/30 rounded-lg text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Milestone Filter -->
            <div>
                <label for="milestone_day" class="block text-xs text-gray-400 mb-1">Milestone</label>
                <select name="milestone_day" id="milestone_day"
                        class="w-full px-3 py-2 bg-[#0a0a0a] border border-silver-900/30 rounded-lg text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="">All Milestones</option>
                    @foreach($milestones as $milestone)
                        <option value="{{ $milestone }}" {{ request('milestone_day') == $milestone ? 'selected' : '' }}>
                            {{ $milestone === 0 ? 'Baseline' : "Day {$milestone}" }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label for="date_from" class="block text-xs text-gray-400 mb-1">From Date</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                       class="w-full px-3 py-2 bg-[#0a0a0a] border border-silver-900/30 rounded-lg text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Date To -->
            <div>
                <label for="date_to" class="block text-xs text-gray-400 mb-1">To Date</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                       class="w-full px-3 py-2 bg-[#0a0a0a] border border-silver-900/30 rounded-lg text-sm text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Filter Buttons -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-lg transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.skin-assessments.index') }}"
                   class="px-4 py-2 bg-gray-600/20 hover:bg-gray-600/30 border border-gray-600/30 text-gray-300 text-sm font-semibold rounded-lg transition">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Assessments Table -->
    <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-xl border border-silver-900/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Milestone</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Day in Program</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Assessment Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Skin Score</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Photo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-silver-900/30">
                    @forelse($assessments as $assessment)
                        <tr class="hover:bg-[#0a0a0a]/50 transition">
                            <td class="px-4 py-3 text-sm text-silver-300">
                                {{ $assessment->user->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-silver-300">
                                <span class="px-2 py-1 bg-blue-600/20 border border-blue-600/30 rounded text-xs text-blue-400 font-semibold">
                                    {{ $assessment->getMilestoneLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-400">
                                Day {{ $assessment->day_in_program }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-400">
                                {{ $assessment->assessment_date->format('M j, Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="text-lg font-bold text-green-400">{{ number_format($assessment->skin_score, 1) }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($assessment->photo)
                                    <img src="{{ asset('storage/' . $assessment->photo) }}"
                                         alt="Assessment photo"
                                         class="w-12 h-12 object-cover rounded-lg border border-[#2a2a3e]">
                                @else
                                    <span class="text-xs text-gray-500">No photo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.skin-assessments.show', $assessment->id) }}"
                                   class="px-3 py-1.5 bg-silver-600/20 hover:bg-silver-600/30 border border-silver-600/30 text-silver-300 text-xs font-semibold rounded transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>No assessments found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($assessments->hasPages())
            <div class="px-4 py-3 border-t border-silver-900/30">
                {{ $assessments->links() }}
            </div>
        @endif
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-lg p-4 border border-silver-900/30">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Assessments</p>
            <p class="text-2xl font-bold text-silver-300">{{ $assessments->total() }}</p>
        </div>

        <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-lg p-4 border border-silver-900/30">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Active Users</p>
            <p class="text-2xl font-bold text-silver-300">{{ $users->count() }}</p>
        </div>

        <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-lg p-4 border border-silver-900/30">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">With Photos</p>
            <p class="text-2xl font-bold text-silver-300">
                {{ \App\Models\SkinAssessment::whereNotNull('photo')->count() }}
            </p>
        </div>

        <div class="bg-gradient-to-b from-[#1a1a2e] to-[#16213e] rounded-lg p-4 border border-silver-900/30">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Avg Skin Score</p>
            <p class="text-2xl font-bold text-green-400">
                {{ number_format(\App\Models\SkinAssessment::avg('skin_score'), 1) }}
            </p>
        </div>
    </div>
</div>
@endsection
