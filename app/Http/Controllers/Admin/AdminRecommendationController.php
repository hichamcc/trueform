<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class AdminRecommendationController extends Controller
{
    /**
     * Display a listing of recommendations
     */
    public function index()
    {
        $recommendations = Recommendation::orderBy('kpi')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.recommendations.index', compact('recommendations'));
    }

    /**
     * Show the form for creating a new recommendation
     */
    public function create()
    {
        return view('admin.recommendations.create');
    }

    /**
     * Store a newly created recommendation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kpi' => 'required|in:energy,focus,sleep,gut_health',
            'product_name' => 'required|string|max:255',
            'product_link' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'priority' => 'integer|min:0|max:100',
        ]);

        Recommendation::create($validated);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation created successfully!');
    }

    /**
     * Show the form for editing a recommendation
     */
    public function edit(Recommendation $recommendation)
    {
        return view('admin.recommendations.edit', compact('recommendation'));
    }

    /**
     * Update the specified recommendation
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        $validated = $request->validate([
            'kpi' => 'required|in:energy,focus,sleep,gut_health',
            'product_name' => 'required|string|max:255',
            'product_link' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'priority' => 'integer|min:0|max:100',
        ]);

        $recommendation->update($validated);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation updated successfully!');
    }

    /**
     * Remove the specified recommendation
     */
    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Recommendation $recommendation)
    {
        $recommendation->update(['is_active' => !$recommendation->is_active]);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation status updated!');
    }
}
