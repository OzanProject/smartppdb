<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(): View
    {
        $testimonials = Testimonial::with(['school', 'user'])->latest()->get();
        return view('superadmin.testimonials.index', compact('testimonials'));
    }

    /**
     * Toggle the published status of a testimonial.
     */
    public function toggleStatus(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'is_published' => !$testimonial->is_published
        ]);

        return redirect()->back()->with('success', 'Status publikasi testimoni berhasil diperbarui!');
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimoni berhasil dihapus!');
    }
}
