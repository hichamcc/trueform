@extends('admin.layouts.admin')

@section('page-title', 'Add Product Recommendation')
@section('page-subtitle', 'Create a new product recommendation for a KPI metric')

@section('content')
<div class="max-w-3xl">
    <!-- Back Button -->
    <a href="{{ route('admin.recommendations.index') }}"
       class="inline-flex items-center gap-2 text-silver-400 hover:text-silver-200 transition-colors mb-6">
        <x-phosphor-arrow-left class="w-5 h-5" />
        Back to Recommendations
    </a>

    <!-- Form Card -->
    <div class="bg-[#1a1a2e] rounded-xl p-8 border border-silver-900/30">
        <form action="{{ route('admin.recommendations.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- KPI Selection -->
            <div>
                <label class="block text-sm font-medium text-silver-300 mb-2">Target KPI *</label>
                <select name="kpi" required
                        class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <option value="">Select KPI</option>
                    <option value="energy">Energy</option>
                    <option value="focus">Focus</option>
                    <option value="sleep">Sleep</option>
                    <option value="gut_health">Gut Health</option>
                </select>
                <p class="text-xs text-silver-500 mt-1">Which wellness metric does this product help with?</p>
            </div>

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium text-silver-300 mb-2">Product Name *</label>
                <input type="text" name="product_name" required maxlength="255"
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                       placeholder="e.g., True Form Energy Boost">
            </div>

            <!-- Product Link -->
            <div>
                <label class="block text-sm font-medium text-silver-300 mb-2">Product Link (Optional)</label>
                <input type="url" name="product_link" maxlength="500"
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                       placeholder="https://shop.trueform.com/product">
                <p class="text-xs text-silver-500 mt-1">Full URL to the product page</p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-silver-300 mb-2">Description (Optional)</label>
                <textarea name="description" rows="4" maxlength="1000"
                          class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                          placeholder="Brief description of the product and how it helps..."></textarea>
                <p class="text-xs text-silver-500 mt-1">Max 1000 characters</p>
            </div>

            <!-- Priority -->
            <div>
                <label class="block text-sm font-medium text-silver-300 mb-2">Priority (0-100)</label>
                <input type="number" name="priority" min="0" max="100" value="0"
                       class="w-full px-4 py-3 bg-[#0f0f0f] border border-silver-900/30 rounded-lg text-silver-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <p class="text-xs text-silver-500 mt-1">Higher priority recommendations are shown first (default: 0)</p>
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                       class="w-5 h-5 bg-[#0f0f0f] border-silver-900/30 rounded text-blue-600 focus:ring-2 focus:ring-blue-500/20">
                <label for="is_active" class="text-sm font-medium text-silver-300">Active (Show to users)</label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition-all">
                    Create Recommendation
                </button>
                <a href="{{ route('admin.recommendations.index') }}"
                   class="px-6 py-3 bg-silver-900/30 hover:bg-silver-900/50 text-silver-300 font-semibold rounded-xl transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
