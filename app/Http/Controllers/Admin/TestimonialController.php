<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Store or update the school's testimonial.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|min:20|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $schoolId = Auth::user()->school_id;
        $userId = Auth::id();

        Testimonial::updateOrCreate(
            ['school_id' => $schoolId],
            [
                'user_id' => $userId,
                'content' => $request->input('content'),
                'rating' => $request->input('rating'),
                // We keep is_published as is, or reset if changed? 
                // Let's keep it false until SuperAdmin approves, or just auto-publish for now if requested.
                // The user said "tampung datanya juga di bagian testimoni", usually implies it should show up.
                'is_published' => true, 
            ]
        );

        return redirect()->back()->with('success', 'Terima kasih! Testimoni Anda telah berhasil disimpan.');
    }
}
