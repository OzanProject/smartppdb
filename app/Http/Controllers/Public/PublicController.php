<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\AdmissionBatch;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Display the dynamic school landing page.
     */
    public function landing(School $school, $section = null): View
    {
        // Get active admission batches for this school
        $activeBatches = AdmissionBatch::query()
            ->where('school_id', $school->id)
            ->where('is_active', true)
            ->with('academicYear')
            ->get();

        // Get landing page contents
        $landingContents = \App\Models\LandingContent::where('school_id', $school->id)
            ->where('is_active', true)
            ->orderBy('order_weight')
            ->get();

        $programs = $landingContents->where('type', 'program');
        $testimonials = $landingContents->where('type', 'testimonial');
        $faqs = $landingContents->where('type', 'faq');

        return view('public.school_landing', compact('school', 'activeBatches', 'programs', 'testimonials', 'faqs', 'section'));
    }

    /**
     * Show public registration form.
     */
    public function registrationForm(School $school): View
    {
        $activeBatches = \App\Models\AdmissionBatch::where('school_id', $school->id)
            ->where('is_active', true)
            ->with('academicYear')
            ->get();

        $sections = \App\Models\FormSection::where('school_id', $school->id)
            ->where('is_active', true)
            ->with(['fields' => function($q) {
                $q->where('is_active', true)->orderBy('order_weight');
            }])
            ->orderBy('order_weight')
            ->get();

        return view('public.registration_form', compact('school', 'activeBatches', 'sections'));
    }

    /**
     * Show tracking form or result.
     */
    public function trackForm(School $school): View
    {
        return view('public.track_status', compact('school'));
    }

    /**
     * Process tracking request.
     */
    public function trackStatusSubmit(Request $request, $slug)
    {
        $school = School::where('slug', $slug)->firstOrFail();
        
        $request->validate([
            'registration_number' => 'required|string',
        ]);

        $registration = Registration::where('school_id', $school->id)
            ->where('registration_number', $request->registration_number)
            ->with(['admissionBatch'])
            ->first();

        if (!$registration) {
            return view('public.track_status', [
                'school' => $school,
                'error' => 'Nomor pendaftaran tidak ditemukan atau tidak sesuai data kami.',
                'searched' => true
            ]);
        }

        return view('public.track_status', [
            'school' => $school,
            'registration' => $registration,
            'searched' => true
        ]);
    }

    /**
     * Handle direct registration submission with dynamic fields.
     */
    public function submitRegistration(Request $request, School $school)
    {
        if (!$school->hasAvailableQuota()) {
            return back()->with('error', 'Mohon maaf, sistem pendaftaran online sekolah ini telah mencapai batas kuota maksimal. Silakan hubungi panitia sekolah.');
        }

        // 1. Load active sections and fields to build dynamic validation
        $sections = \App\Models\FormSection::where('school_id', $school->id)
            ->where('is_active', true)
            ->with(['fields' => function($q) {
                $q->where('is_active', true);
            }])
            ->get();

        $rules = [
            'admission_batch_id' => 'required|exists:admission_batches,id',
        ];

        $fieldMap = []; // To keep track of which field belongs to which section
        
        foreach ($sections as $section) {
            foreach ($section->fields as $field) {
                $fieldName = 'field_' . $field->id;
                $rule = $field->is_required ? 'required' : 'nullable';
                
                if ($field->type == 'number') $rule .= '|numeric';
                if ($field->type == 'date') $rule .= '|date';
                if ($field->type == 'file') $rule .= '|file|mimes:jpg,jpeg,png,pdf|max:2048';
                
                $rules[$fieldName] = $rule;
                $fieldMap[$fieldName] = [
                    'id' => $field->id,
                    'label' => $field->label,
                    'type' => $field->type,
                    'section' => $section->name
                ];
            }
        }

        $validated = $request->validate($rules);

        // 2. Prepare Data & Handle File Uploads
        $data = [
            'personal_data' => [],
            'parent_data' => [],
            'previous_school_data' => [],
            'additional_data' => []
        ];

        $uploadedFiles = [];

        foreach ($fieldMap as $fieldName => $info) {
            $value = $validated[$fieldName] ?? null;
            
            // Handle Files
            if ($info['type'] == 'file' && $request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $path = $file->store('documents', 'public');
                $value = $path; // Store path in JSON for visibility in form data tab
                
                $uploadedFiles[] = [
                    'label' => $info['label'],
                    'path' => $path
                ];
            }

            $sectionName = strtolower($info['section']);
            
            $targetColumn = 'additional_data';
            if (str_contains($sectionName, 'pribadi') || str_contains($sectionName, 'siswa')) {
                $targetColumn = 'personal_data';
            } elseif (str_contains($sectionName, 'orang tua') || str_contains($sectionName, 'wali')) {
                $targetColumn = 'parent_data';
            } elseif (str_contains($sectionName, 'asal') || str_contains($sectionName, 'sekolah')) {
                $targetColumn = 'previous_school_data';
            }

            // Find NIK for primary identification if it exists
            if (str_contains(strtolower($info['label']), 'nik')) {
                $data['personal_data']['nik'] = $value;
            }
            
            // Still save full name for display in personal_data if it sounds like name
            if (str_contains(strtolower($info['label']), 'nama lengkap')) {
                $data['personal_data']['full_name'] = $value;
            }

            $data[$targetColumn][$info['label']] = $value;
        }

        // 3. Generate Registration Number & Create Registration
        $registrationNumber = 'REG-' . $school->id . '-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        // 4. Save to Database
        $registration = \App\Models\Registration::create(array_merge($data, [
            'registration_number' => $registrationNumber,
            'school_id' => $school->id,
            'admission_batch_id' => $validated['admission_batch_id'],
            'status' => 'pending',
        ]));

        // 5. Create Document records from uploaded files
        foreach ($uploadedFiles as $fileInfo) {
            // Try to find a matching requirement slug based on label
            $slug = \Illuminate\Support\Str::slug($fileInfo['label']);
            $requirement = \App\Models\DocumentRequirement::where('school_id', $school->id)
                ->where('slug', $slug)
                ->first();

            \App\Models\Document::create([
                'registration_id' => $registration->id,
                'name' => $fileInfo['label'],
                'type' => $requirement ? $requirement->slug : $slug,
                'path' => $fileInfo['path'],
            ]);
        }

        return redirect()->route('school.registration.track', $school->slug)
            ->with('success', 'Pendaftaran berhasil! Simpan Nomor Pendaftaran Anda: ' . $registrationNumber);
    }
}
