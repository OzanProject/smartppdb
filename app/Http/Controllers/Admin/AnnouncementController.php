<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AdmissionBatch;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $schoolId = auth()->user()->school_id;
        
        $announcements = Announcement::where('school_id', $schoolId)
            ->with('admissionBatch')
            ->latest()
            ->get();

        $batches = AdmissionBatch::where('school_id', $schoolId)->get();

        return view('admin.announcements.index', compact('announcements', 'batches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'admission_batch_id' => 'required|exists:admission_batches,id',
            'title' => 'required|string|max:255',
            'content_success' => 'nullable|string',
            'content_failure' => 'nullable|string',
            'announcement_date' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['school_id'] = auth()->user()->school_id;
        $validated['is_published'] = $request->has('is_published');

        Announcement::create($validated);

        return redirect()->back()->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        if ($announcement->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'admission_batch_id' => 'required|exists:admission_batches,id',
            'title' => 'required|string|max:255',
            'content_success' => 'nullable|string',
            'content_failure' => 'nullable|string',
            'announcement_date' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $announcement->update($validated);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if ($announcement->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $announcement->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
