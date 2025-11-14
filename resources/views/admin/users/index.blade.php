@extends('admin.layouts.admin')

@section('page-title', 'User Management')
@section('page-subtitle', 'Manage all registered users')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-silver-400 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Name or email..."
                       class="w-full bg-[#16213e] border border-silver-900/30 rounded-xl px-4 py-2 text-silver-100 focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-silver-400 mb-2">Admin Status</label>
                <select name="admin_status" class="w-full bg-[#16213e] border border-silver-900/30 rounded-xl px-4 py-2 text-silver-100">
                    <option value="">All</option>
                    <option value="admin" {{ request('admin_status') === 'admin' ? 'selected' : '' }}>Admins</option>
                    <option value="user" {{ request('admin_status') === 'user' ? 'selected' : '' }}>Users</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-silver-400 mb-2">Program Status</label>
                <select name="program_status" class="w-full bg-[#16213e] border border-silver-900/30 rounded-xl px-4 py-2 text-silver-100">
                    <option value="">All</option>
                    <option value="active" {{ request('program_status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('program_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-silver-900/30 hover:bg-silver-900/50 text-silver-300 rounded-xl font-medium transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-[#1a1a2e] rounded-2xl p-6 border border-silver-900/30">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-silver-900/30">
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">ID</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Name</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Email</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Status</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Program</th>
                        <th class="text-left py-3 px-4 text-silver-400 font-medium text-sm">Registered</th>
                        <th class="text-right py-3 px-4 text-silver-400 font-medium text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-silver-900/30 hover:bg-[#16213e] transition-colors">
                            <td class="py-3 px-4 text-silver-300">{{ $user->id }}</td>
                            <td class="py-3 px-4 text-silver-100 font-medium">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-silver-300">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @if($user->is_admin)
                                    <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-lg text-xs font-medium">ADMIN</span>
                                @else
                                    <span class="px-3 py-1 bg-silver-900/30 text-silver-400 rounded-lg text-xs font-medium">USER</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->programEnrollment)
                                    @if($user->programEnrollment->is_active)
                                        <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg text-xs font-medium">Active</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-600/20 text-red-400 rounded-lg text-xs font-medium">Inactive</span>
                                    @endif
                                @else
                                    <span class="px-3 py-1 bg-silver-900/30 text-silver-500 rounded-lg text-xs font-medium">N/A</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-silver-300 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-silver-500">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
