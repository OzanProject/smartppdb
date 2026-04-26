<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $schools = School::withCount(['users', 'admissionBatches'])
            ->latest()
            ->paginate(10);

        return view('superadmin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pricingPlans = \App\Models\PricingPlan::orderBy('order_weight')->get();
        return view('superadmin.schools.create', compact('pricingPlans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'education_level_name' => 'required|string|max:100',
            'npsn' => 'nullable|string|max:20|unique:schools,npsn',
            'pricing_plan_id' => 'nullable|exists:pricing_plans,id',
            'timezone' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($request->name);
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (School::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $validated['trial_ends_at'] = now()->addDays(2);
        School::create($validated);

        return redirect()->route('superadmin.schools.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school): View
    {
        $pricingPlans = \App\Models\PricingPlan::orderBy('order_weight')->get();
        return view('superadmin.schools.edit', compact('school', 'pricingPlans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email,' . $school->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'education_level_name' => 'required|string|max:100',
            'npsn' => 'nullable|string|max:20|unique:schools,npsn,' . $school->id,
            'is_active' => 'boolean',
            'pricing_plan_id' => 'nullable|exists:pricing_plans,id',
            'timezone' => 'required|string',
        ]);

        if ($request->name !== $school->name) {
            $validated['slug'] = Str::slug($request->name);
            $originalSlug = $validated['slug'];
            $count = 1;
            while (School::where('slug', $validated['slug'])->where('id', '!=', $school->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $validated['is_active'] = $request->has('is_active');

        $school->update($validated);

        return redirect()->route('superadmin.schools.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school): RedirectResponse
    {
        // For safety, maybe just deactivate? But the user asked for full control.
        $school->delete();
        return redirect()->route('superadmin.schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(School $school): RedirectResponse
    {
        $school->update(['is_active' => !$school->is_active]);
        return redirect()->back()->with('success', 'Status sekolah berhasil diubah.');
    }
}
