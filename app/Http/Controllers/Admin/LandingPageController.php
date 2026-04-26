<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingContent;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Display the landing page management dashboard.
     */
    public function index(Request $request): View
    {
        $school = $request->user()->school;
        
        $contents = LandingContent::where('school_id', $school->id)
            ->orderBy('order_weight')
            ->get();
            
        $programs = $contents->where('type', 'program');
        $testimonials = $contents->where('type', 'testimonial');
        $faqs = $contents->where('type', 'faq');

        return view('admin.landing-page.index', compact('school', 'programs', 'testimonials', 'faqs'));
    }

    /**
     * Update the Hero & Stats singleton data.
     */
    public function updateHeroStats(Request $request): RedirectResponse
    {
        $school = $request->user()->school;

        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|image|max:3072', // Max 3MB
            'stats_acc_label' => 'nullable|string|max:100',
            'stats_acc_value' => 'nullable|string|max:50',
            'stats_count_label' => 'nullable|string|max:100',
            'stats_count_value' => 'nullable|string|max:50',
            'stats_grad_label' => 'nullable|string|max:100',
            'stats_grad_value' => 'nullable|string|max:50',
        ]);

        $data = $validated;
        if ($request->hasFile('hero_image')) {
            // Delete old hero image
            if ($school->hero_image) {
                Storage::disk('public')->delete($school->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('landing', 'public');
        }

        $school->update($data);

        return redirect()->back()->with('success', 'Pengaturan Hero & Statistik berhasil diperbarui.');
    }

    /**
     * Store a newly created LandingContent (Program, Testimonial, FAQ).
     */
    public function storeContent(Request $request): RedirectResponse
    {
        $school = $request->user()->school;

        $validated = $request->validate([
            'type' => 'required|in:program,testimonial,faq',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'order_weight' => 'nullable|integer',
        ]);

        $data = $validated;
        $data['school_id'] = $school->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('landing', 'public');
        }

        LandingContent::create($data);

        return redirect()->back()->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Update the specified LandingContent.
     */
    public function updateContent(Request $request, LandingContent $content): RedirectResponse
    {
        // Security check
        if ($content->school_id !== $request->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'order_weight' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $request->file('image')->store('landing', 'public');
        }

        $content->update($data);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified LandingContent.
     */
    public function destroyContent(Request $request, LandingContent $content): RedirectResponse
    {
        // Security check
        if ($content->school_id !== $request->user()->school_id) {
            abort(403);
        }

        // Delete image
        if ($content->image) {
            Storage::disk('public')->delete($content->image);
        }

        $content->delete();

        return redirect()->back()->with('success', 'Konten berhasil dihapus.');
    }
}
