<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AdmissionBatch;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdmissionBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $school = $request->user()->school;

        $batches = AdmissionBatch::query()
            ->where('school_id', $school->id)
            ->with('academicYear')
            ->orderBy('start_date', 'desc')
            ->get();

        $academicYears = AcademicYear::query()
            ->where('school_id', $school->id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.batches.index', compact('batches', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $school = $request->user()->school;

        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $validated['school_id'] = $school->id;

        AdmissionBatch::create($validated);

        return redirect()->back()->with('success', 'Gelombang pendaftaran berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdmissionBatch $batch): RedirectResponse
    {
        // Ensure user belongs to the same school
        if ($batch->school_id !== $request->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $batch->update($validated);

        return redirect()->back()->with('success', 'Gelombang pendaftaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AdmissionBatch $batch): RedirectResponse
    {
        // Ensure user belongs to the same school
        if ($batch->school_id !== $request->user()->school_id) {
            abort(403);
        }

        // Check if there are registrations
        if ($batch->registrations()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus gelombang yang sudah memiliki pendaftar.');
        }

        $batch->delete();

        return redirect()->back()->with('success', 'Gelombang pendaftaran berhasil dihapus.');
    }
}
