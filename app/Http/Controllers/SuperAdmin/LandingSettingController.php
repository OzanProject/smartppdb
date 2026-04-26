<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LandingSettingController extends Controller
{
    public function index(): View
    {
        LandingSetting::firstOrCreate(
            ['key' => 'app_timezone'],
            ['group' => 'System', 'value' => 'Asia/Jakarta']
        );

        $settings = LandingSetting::whereNotIn('group', ['Pages', 'API', 'Testimonial', 'SMTP'])
            ->orderBy('group')
            ->orderBy('key')
            ->get();
        return view('superadmin.landing-settings.index', compact('settings'));
    }

    public function updateAll(Request $request): RedirectResponse
    {
        $settings = $request->input('settings', []);
        
        // Handle normal text settings
        foreach ($settings as $key => $value) {
            LandingSetting::where('key', $key)->update(['value' => $value]);
        }

        // Handle file deletions
        if ($request->has('delete_app_logo')) {
            $setting = LandingSetting::where('key', 'app_logo')->first();
            if ($setting && $setting->value) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->value);
                $setting->update(['value' => null]);
            }
        }

        if ($request->has('delete_app_favicon')) {
            $setting = LandingSetting::where('key', 'app_favicon')->first();
            if ($setting && $setting->value) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->value);
                $setting->update(['value' => null]);
            }
        }

        if ($request->has('delete_seo_og_image')) {
            $setting = LandingSetting::where('key', 'seo_og_image')->first();
            if ($setting && $setting->value) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->value);
                $setting->update(['value' => null]);
            }
        }

        // Handle file uploads (logo, favicon, og_image)
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('landing', 'public');
            LandingSetting::where('key', 'app_logo')->update(['value' => $path]);
        }

        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('landing', 'public');
            LandingSetting::where('key', 'app_favicon')->update(['value' => $path]);
        }

        if ($request->hasFile('seo_og_image')) {
            $path = $request->file('seo_og_image')->store('landing', 'public');
            LandingSetting::where('key', 'seo_og_image')->update(['value' => $path]);
        }

        return redirect()->back()->with('success', 'Landing page settings updated successfully!');
    }
}
