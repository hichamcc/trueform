@extends('admin.layouts.admin')

@section('page-title', 'Product Recommendations')
@section('page-subtitle', 'Manage product recommendations based on KPI metrics')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-silver-200">All Recommendations</h3>
            <p class="text-sm text-silver-500 mt-1">{{ $recommendations->count() }} total recommendations</p>
        </div>
        <a href="{{ route('admin.recommendations.create') }}"
           class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
            <x-phosphor-plus class="w-5 h-5" />
            Add Recommendation
        </a>
    </div>

    <!-- Recommendations List -->
    @if($recommendations->count() > 0)
        <div class="grid grid-cols-1 gap-4">
            @foreach($recommendations as $recommendation)
                <div class="bg-[#1a1a2e] rounded-xl p-6 border border-silver-900/30 hover:border-blue-500/30 transition-all">
                    <div class="flex items-start justify-between gap-4">
                        <!-- Main Info -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <!-- KPI Badge -->
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold
                                    @if($recommendation->kpi === 'energy') bg-green-900/30 text-green-400 border border-green-500/30
                                    @elseif($recommendation->kpi === 'focus') bg-blue-900/30 text-blue-400 border border-blue-500/30
                                    @elseif($recommendation->kpi === 'sleep') bg-purple-900/30 text-purple-400 border border-purple-500/30
                                    @elseif($recommendation->kpi === 'gut_health') bg-orange-900/30 text-orange-400 border border-orange-500/30
                                    @elseif($recommendation->kpi === 'skin_glow') bg-pink-900/30 text-pink-400 border border-pink-500/30
                                    @endif">
                                    {{ $recommendation->getKpiDisplayName() }}
                                </span>

                                <!-- Active Status -->
                                @if($recommendation->is_active)
                                    <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full border border-green-500/30">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-900/30 text-gray-400 text-xs rounded-full border border-gray-500/30">Inactive</span>
                                @endif

                                <!-- Priority Badge -->
                                @if($recommendation->priority > 0)
                                    <span class="px-2 py-1 bg-yellow-900/30 text-yellow-400 text-xs rounded-full border border-yellow-500/30">
                                        Priority: {{ $recommendation->priority }}
                                    </span>
                                @endif
                            </div>

                            <h4 class="text-lg font-bold text-silver-200 mb-2">{{ $recommendation->product_name }}</h4>

                            @if($recommendation->description)
                                <p class="text-sm text-silver-400 mb-3">{{ $recommendation->description }}</p>
                            @endif

                            @if($recommendation->product_link)
                                <a href="{{ $recommendation->product_link }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                    <x-phosphor-link class="w-4 h-4" />
                                    {{ $recommendation->product_link }}
                                </a>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <!-- Toggle Active -->
                            <form action="{{ route('admin.recommendations.toggle-active', $recommendation) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="p-2 rounded-lg transition-all {{ $recommendation->is_active ? 'bg-green-900/30 text-green-400 hover:bg-green-900/50' : 'bg-gray-900/30 text-gray-400 hover:bg-gray-900/50' }}"
                                        title="{{ $recommendation->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($recommendation->is_active)
                                        <x-phosphor-eye class="w-5 h-5" />
                                    @else
                                        <x-phosphor-eye-slash class="w-5 h-5" />
                                    @endif
                                </button>
                            </form>

                            <!-- Edit -->
                            <a href="{{ route('admin.recommendations.edit', $recommendation) }}"
                               class="p-2 bg-blue-900/30 text-blue-400 hover:bg-blue-900/50 rounded-lg transition-all"
                               title="Edit">
                                <x-phosphor-pencil class="w-5 h-5" />
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('admin.recommendations.destroy', $recommendation) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this recommendation?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 bg-red-900/30 text-red-400 hover:bg-red-900/50 rounded-lg transition-all"
                                        title="Delete">
                                    <x-phosphor-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-[#1a1a2e] rounded-xl p-12 border border-silver-900/30 text-center">
            <x-phosphor-package class="w-16 h-16 text-silver-600 mx-auto mb-4" />
            <h3 class="text-lg font-semibold text-silver-300 mb-2">No Recommendations Yet</h3>
            <p class="text-sm text-silver-500 mb-6">Start by adding product recommendations for different KPI metrics.</p>
            <a href="{{ route('admin.recommendations.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition-all">
                <x-phosphor-plus class="w-5 h-5" />
                Add First Recommendation
            </a>
        </div>
    @endif
</div>
@endsection
