<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $school = $request->user()->school;

        $academicYears = AcademicYear::query()
            ->where('school_id', $school->id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.academic-years.index', compact('academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $school = $request->user()->school;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        if ($validated['is_active']) {
            AcademicYear::where('school_id', $school->id)->update(['is_active' => false]);
        }

        AcademicYear::create([
            'school_id' => $school->id,
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicYear $academicYear): RedirectResponse
    {
        if ($academicYear->school_id !== $request->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        if ($validated['is_active']) {
            AcademicYear::where('school_id', $academicYear->school_id)
                ->where('id', '!=', $academicYear->id)
                ->update(['is_active' => false]);
        }

        $academicYear->update($validated);

        return redirect()->back()->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AcademicYear $academicYear): RedirectResponse
    {
        if ($academicYear->school_id !== $request->user()->school_id) {
            abort(403);
        }

        if ($academicYear->is_active) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif.');
        }

        // Check for dependencies (batches)
        if (\App\Models\AdmissionBatch::where('academic_year_id', $academicYear->id)->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus tahun ajaran yang sudah memiliki gelombang.');
        }

        $academicYear->delete();

        return redirect()->back()->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
