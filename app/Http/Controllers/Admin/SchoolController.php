<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function edit(): View
    {
        $school = Auth::user()->school;
        $testimonial = \App\Models\Testimonial::where('school_id', $school->id)->first();

        return view('admin.school.edit', compact('school', 'testimonial'));
    }

    public function update(Request $request): RedirectResponse
    {
        $school = $this->getSchoolFromUser($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => [
                'required',
                'string',
                'max:150',
                Rule::unique('schools', 'slug')->ignore($school->id),
            ],
            'education_level_code' => ['nullable', 'string', 'max:50'],
            'education_level_name' => ['required', 'string', 'max:100'],
            'is_custom_level' => ['required', 'boolean'],
            'npsn' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'is_registration_open' => ['required', 'boolean'],
            'timezone' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                Storage::disk('public')->delete($school->logo);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Remove the 'logo' key if no file was uploaded (avoid overwriting with null)
        if (!$request->hasFile('logo')) {
            unset($validated['logo']);
        }

        $school->update($validated);

        return redirect()->route('admin.school.edit')->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    public function destroyLogo(Request $request): RedirectResponse
    {
        $school = $this->getSchoolFromUser($request);

        if ($school->logo && Storage::disk('public')->exists($school->logo)) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->update(['logo' => null]);

        return redirect()->route('admin.school.edit')->with('success', 'Logo berhasil dihapus.');
    }

    private function getSchoolFromUser(Request $request): School
    {
        $school = $request->user()?->school;

        abort_if(!$school, 404, 'Data sekolah tidak ditemukan.');

        return $school;
    }
}