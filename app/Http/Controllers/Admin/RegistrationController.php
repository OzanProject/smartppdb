<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Display a listing of registrations.
     */
    public function index(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        
        if (!$schoolId) {
            abort(403, 'Akun Anda belum terhubung dengan data sekolah.');
        }

        $registrations = Registration::where('school_id', $schoolId)
            ->with(['user', 'admissionBatch'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $featuredFields = \App\Models\FormField::whereHas('section', function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })->where('is_featured', true)->orderBy('order_weight')->get();

        return view('admin.registrations.index', compact('registrations', 'featuredFields'));
    }

    /**
     * Display the specific registration.
     */
    public function show(Registration $registration): View
    {
        // Ensure user belongs to same school
        if ($registration->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $registration->load(['user', 'school', 'admissionBatch', 'documents']);
        
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update the registration status.
     */
    public function updateStatus(Request $request, Registration $registration): RedirectResponse
    {
        // Ensure user belongs to same school
        if ($registration->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected',
            'note' => 'nullable|string',
        ]);

        $registration->update($validated);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Delete the registration.
     */
    public function destroy(Registration $registration): RedirectResponse
    {
        // Ensure user belongs to same school
        if ($registration->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
