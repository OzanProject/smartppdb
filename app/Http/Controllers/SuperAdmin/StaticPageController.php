<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StaticPageController extends Controller
{
    /**
     * Display a listing of static pages.
     */
    public function index(): View
    {
        $settings = LandingSetting::where('group', 'Pages')->get()->pluck('value', 'key');
        $apiKey = LandingSetting::where('key', 'tinymce_api_key')->first();
        
        return view('superadmin.static-pages.index', [
            'about' => $settings['page_about_content'] ?? '',
            'privacy' => $settings['page_privacy_content'] ?? '',
            'terms' => $settings['page_terms_content'] ?? '',
            'tinymce_api_key' => $apiKey ? $apiKey->value : ''
        ]);
    }

    /**
     * Update the static pages.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->only([
            'page_about_content',
            'page_privacy_content',
            'page_terms_content',
            'tinymce_api_key'
        ]);

        foreach ($data as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => str_contains($key, 'tinymce') ? 'API' : 'Pages']
            );
        }

        return redirect()->back()->with('success', 'Halaman statis berhasil diperbarui!');
    }
}
