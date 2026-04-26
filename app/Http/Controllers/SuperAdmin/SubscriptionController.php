<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use App\Models\Subscription;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    /**
     * Display all subscriptions.
     */
    public function index(Request $request): View
    {
        $query = Subscription::with(['school', 'pricingPlan', 'confirmedBy'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('school', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        $subscriptions = $query->paginate(15);

        return view('superadmin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show subscription detail.
     */
    public function show(Subscription $subscription): View
    {
        $subscription->load(['school', 'pricingPlan', 'confirmedBy']);
        return view('superadmin.subscriptions.show', compact('subscription'));
    }

    /**
     * Confirm payment and activate subscription.
     */
    public function confirm(Request $request, Subscription $subscription): RedirectResponse
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $subscription->update([
            'status' => 'active',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
            'starts_at' => now(),
            'ends_at' => now()->addYear(),
            'admin_notes' => $request->admin_notes,
        ]);

        // Activate the plan on the school
        $subscription->school->update([
            'pricing_plan_id' => $subscription->pricing_plan_id,
        ]);

        return redirect()->route('superadmin.subscriptions.index')
            ->with('success', 'Langganan berhasil dikonfirmasi dan diaktifkan untuk ' . $subscription->school->name);
    }

    /**
     * Reject payment.
     */
    public function reject(Request $request, Subscription $subscription): RedirectResponse
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $subscription->update([
            'status' => 'cancelled',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('superadmin.subscriptions.index')
            ->with('success', 'Langganan ditolak.');
    }

    /**
     * Show payment settings management page.
     */
    public function paymentSettings(): View
    {
        $settings = PaymentSetting::getSettings();
        return view('superadmin.subscriptions.payment-settings', compact('settings'));
    }

    /**
     * Update payment settings.
     */
    public function updatePaymentSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
            'payment_instructions' => 'nullable|string',
            'enable_gateway' => 'nullable|string',
            'gateway_provider' => 'nullable|string|max:50',
            'gateway_server_key' => 'nullable|string|max:255',
            'gateway_client_key' => 'nullable|string|max:255',
            'gateway_mode' => 'nullable|string|in:sandbox,production',
        ]);

        PaymentSetting::setValue('bank_name', $request->bank_name);
        PaymentSetting::setValue('bank_account_number', $request->bank_account_number);
        PaymentSetting::setValue('bank_account_name', $request->bank_account_name);
        PaymentSetting::setValue('payment_instructions', $request->payment_instructions);
        PaymentSetting::setValue('enable_gateway', $request->has('enable_gateway') ? '1' : '0');
        PaymentSetting::setValue('gateway_provider', $request->gateway_provider);
        PaymentSetting::setValue('gateway_server_key', $request->gateway_server_key);
        PaymentSetting::setValue('gateway_client_key', $request->gateway_client_key);
        PaymentSetting::setValue('gateway_mode', $request->gateway_mode ?? 'sandbox');

        return back()->with('success', 'Pengaturan pembayaran berhasil disimpan.');
    }

    /**
     * Delete a subscription.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('superadmin.subscriptions.index')
            ->with('success', 'Data langganan berhasil dihapus.');
    }

    /**
     * Print invoice as PDF-ready page.
     */
    public function printInvoice(Subscription $subscription): View
    {
        $subscription->load('pricingPlan', 'school');
        $paymentSettings = PaymentSetting::getSettings();

        return view('admin.subscriptions.print', compact('subscription', 'paymentSettings'));
    }
}
