<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PricingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $plans = PricingPlan::orderBy('order_weight')->get();
        return view('superadmin.pricing-plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('superadmin.pricing-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_display' => 'required|string|max:255',
            'billing_cycle' => 'required|in:monthly,yearly,custom',
            'trial_days' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'order_weight' => 'required|integer',
            'cta_text' => 'required|string',
            'cta_link' => 'required|string',
            'allowed_modules' => 'nullable|array',
            'max_quota' => 'required|integer',
        ]);

        PricingPlan::create([
            'name' => $request->name,
            'price' => $request->price,
            'price_display' => $request->price_display,
            'billing_cycle' => $request->billing_cycle,
            'trial_days' => $request->trial_days,
            'description' => $request->description,
            'features' => $request->features,
            'is_popular' => $request->has('is_popular'),
            'order_weight' => $request->order_weight,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'allowed_modules' => $request->allowed_modules ?? [],
            'max_quota' => $request->max_quota,
        ]);

        return redirect()->route('superadmin.pricing-plans.index')->with('success', 'Paket harga berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PricingPlan $pricingPlan): View
    {
        return view('superadmin.pricing-plans.edit', compact('pricingPlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PricingPlan $pricingPlan): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_display' => 'required|string|max:255',
            'billing_cycle' => 'required|in:monthly,yearly,custom',
            'trial_days' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'order_weight' => 'required|integer',
            'cta_text' => 'required|string',
            'cta_link' => 'required|string',
            'allowed_modules' => 'nullable|array',
            'max_quota' => 'required|integer',
        ]);

        $pricingPlan->update([
            'name' => $request->name,
            'price' => $request->price,
            'price_display' => $request->price_display,
            'billing_cycle' => $request->billing_cycle,
            'trial_days' => $request->trial_days,
            'description' => $request->description,
            'features' => $request->features,
            'is_popular' => $request->has('is_popular'),
            'order_weight' => $request->order_weight,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'allowed_modules' => $request->allowed_modules ?? [],
            'max_quota' => $request->max_quota,
        ]);

        return redirect()->route('superadmin.pricing-plans.index')->with('success', 'Paket harga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PricingPlan $pricingPlan): RedirectResponse
    {
        $pricingPlan->delete();
        return redirect()->route('superadmin.pricing-plans.index')->with('success', 'Paket harga berhasil dihapus.');
    }
}
