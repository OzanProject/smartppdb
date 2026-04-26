<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use App\Models\PricingPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    /**
     * Show subscription/plan overview for current school.
     */
    public function index(): View
    {
        $school = auth()->user()->school;
        $currentPlan = $school->pricingPlan;
        $plans = PricingPlan::orderBy('order_weight')->get();
        $subscriptions = Subscription::where('school_id', $school->id)
            ->with('pricingPlan')
            ->orderByDesc('created_at')
            ->get();
        $paymentSettings = PaymentSetting::getSettings();

        return view('admin.subscriptions.index', compact(
            'school', 'currentPlan', 'plans', 'subscriptions', 'paymentSettings'
        ));
    }

    /**
     * Show checkout / order form for a specific plan.
     */
    public function checkout(PricingPlan $plan): View
    {
        $school = auth()->user()->school;
        $paymentSettings = PaymentSetting::getSettings();

        return view('admin.subscriptions.checkout', compact('school', 'plan', 'paymentSettings'));
    }

    /**
     * Place order / create subscription.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pricing_plan_id' => 'required|exists:pricing_plans,id',
            'payment_method' => 'required|in:manual_transfer,payment_gateway',
            'notes' => 'nullable|string|max:500',
        ]);

        $school = auth()->user()->school;
        $plan = PricingPlan::findOrFail($request->pricing_plan_id);

        // Check if there's already a pending subscription for same plan
        $existing = Subscription::where('school_id', $school->id)
            ->where('pricing_plan_id', $plan->id)
            ->whereIn('status', ['pending_payment', 'paid'])
            ->first();

        if ($existing) {
            return redirect()->route('admin.subscriptions.index')
                ->with('error', 'Anda sudah memiliki pesanan aktif untuk paket ini. Silakan selesaikan pembayaran atau tunggu konfirmasi.');
        }

        // Parse price from display
        $amount = (float) preg_replace('/[^0-9]/', '', $plan->price_display);

        $subscription = Subscription::create([
            'invoice_number' => Subscription::generateInvoiceNumber(),
            'school_id' => $school->id,
            'pricing_plan_id' => $plan->id,
            'status' => 'pending_payment',
            'payment_method' => $request->payment_method,
            'amount' => $amount,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.subscriptions.invoice', $subscription)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Show invoice page.
     */
    public function invoice(Subscription $subscription): View
    {
        $this->authorizeSchool($subscription);

        $paymentSettings = PaymentSetting::getSettings();
        $subscription->load('pricingPlan', 'school');

        return view('admin.subscriptions.invoice', compact('subscription', 'paymentSettings'));
    }

    /**
     * Upload payment proof.
     */
    public function uploadProof(Request $request, Subscription $subscription): RedirectResponse
    {
        $this->authorizeSchool($subscription);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $subscription->update([
                'payment_proof' => $path,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('admin.subscriptions.invoice', $subscription)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu konfirmasi Super Admin.');
    }

    /**
     * Delete a subscription (only pending/cancelled).
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        $this->authorizeSchool($subscription);

        if (!in_array($subscription->status, ['pending_payment', 'cancelled'])) {
            return redirect()->route('admin.subscriptions.index')
                ->with('error', 'Hanya invoice dengan status Menunggu Pembayaran atau Dibatalkan yang bisa dihapus.');
        }

        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }

    /**
     * Print invoice as PDF-ready page.
     */
    public function printInvoice(Subscription $subscription): View
    {
        $this->authorizeSchool($subscription);

        $subscription->load('pricingPlan', 'school');
        $paymentSettings = PaymentSetting::getSettings();

        return view('admin.subscriptions.print', compact('subscription', 'paymentSettings'));
    }

    /**
     * Ensure subscription belongs to the current school.
     */
    private function authorizeSchool(Subscription $subscription): void
    {
        if ($subscription->school_id !== auth()->user()->school_id) {
            abort(403, 'Akses ditolak.');
        }
    }
}
