<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBatch;
use App\Models\Registration;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        
        // Check if user already has a registration
        $existingRegistration = $user->registrations()->with(['school', 'admissionBatch', 'documents'])->latest()->first();
        
        if ($existingRegistration && !$request->has('edit')) {
            return view('applicant.registration.show', ['registration' => $existingRegistration]);
        }
        
        // If editing, but already accepted, don't allow edit
        if ($existingRegistration && $existingRegistration->status == 'accepted' && $request->has('edit')) {
            return redirect()->route('applicant.dashboard')->with('error', 'Pendaftaran yang sudah diterima tidak dapat diubah.');
        }

        // Get the school the user registered for
        $school = null;
        if ($user->school_id) {
            $school = School::where('id', $user->school_id)
                ->where('is_registration_open', true)
                ->with(['formSections.fields', 'documentRequirements'])
                ->first();
        }

        // Fallback for older accounts or global signups without a specific school
        if (!$school) {
            $school = School::where('is_registration_open', true)
                ->with(['formSections.fields', 'documentRequirements'])
                ->first();
        }

        if (!$school) {
            abort(404, 'Maaf, pendaftaran saat ini sedang ditutup atau Anda belum memilih sekolah.');
        }

        $batch = $school->admissionBatches()->where('is_active', true)->first();
        if (!$batch) {
            abort(404, 'Maaf, belum ada gelombang pendaftaran yang dibuka.');
        }

        return view('applicant.registration.create', [
            'school' => $school,
            'batch' => $batch,
            'sections' => $school->formSections,
            'requirements' => $school->documentRequirements
        ]);
    }

    /**
     * Store the registration.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Ensure user doesn't already have a registration for this batch
        if ($user->registrations()->where('admission_batch_id', $request->admission_batch_id)->exists()) {
            return redirect()->route('applicant.dashboard')->with('error', 'Anda sudah melakukan pendaftaran di gelombang ini.');
        }

        $school = School::findOrFail($request->school_id);

        if (!$school->hasAvailableQuota()) {
            return redirect()->route('applicant.dashboard')->with('error', 'Mohon maaf, sistem pendaftaran online sekolah ini telah mencapai batas kuota maksimal. Silakan hubungi panitia sekolah.');
        }
        
        // 1. Setup Validation based on Form Builder
        $sections = $school->formSections()->where('is_active', true)
            ->with(['fields' => function($q) {
                $q->where('is_active', true);
            }])
            ->get();

        $rules = [
            'school_id' => 'required|exists:schools,id',
            'admission_batch_id' => 'required|exists:admission_batches,id',
        ];

        $fieldMap = [];
        
        foreach ($sections as $section) {
            foreach ($section->fields as $field) {
                $fieldName = 'field_' . $field->id;
                $rule = $field->is_required ? 'required' : 'nullable';
                
                if ($field->type == 'number') $rule .= '|numeric';
                if ($field->type == 'date') $rule .= '|date';
                if ($field->type == 'file') $rule .= '|file|mimes:jpg,jpeg,png,pdf|max:2048';
                
                $rules[$fieldName] = $rule;
                $fieldMap[$fieldName] = [
                    'label' => $field->label,
                    'type' => $field->type,
                    'section' => $section->name
                ];
            }
        }

        // Requirements Validation
        $requirements = $school->documentRequirements()->orderBy('order_weight')->get();
        foreach ($requirements as $req) {
            $reqName = 'req_' . $req->id;
            $rule = $req->is_required ? 'required' : 'nullable';
            $rule .= '|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules[$reqName] = $rule;
        }

        $validated = $request->validate($rules);

        // 2. Prepare Data & Handle File Uploads for Sections
        $data = [
            'personal_data' => [],
            'parent_data' => [],
            'previous_school_data' => [],
            'additional_data' => []
        ];

        $uploadedFiles = [];

        foreach ($fieldMap as $fieldName => $info) {
            $value = $validated[$fieldName] ?? null;
            
            // Handle Files from form sections
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

        // 3. Generate Registration Number
        $registrationNumber = 'REG-' . $school->id . '-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        // 4. Create Registration
        $registration = Registration::create(array_merge($data, [
            'registration_number' => $registrationNumber,
            'user_id' => $user->id,
            'school_id' => $school->id,
            'admission_batch_id' => $validated['admission_batch_id'],
            'status' => 'pending',
        ]));

        // 5. Create Document records from section uploads
        foreach ($uploadedFiles as $fileInfo) {
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

        // 6. Handle Explicit Document Requirements Uploads
        foreach ($requirements as $req) {
            $reqName = 'req_' . $req->id;
            if ($request->hasFile($reqName)) {
                $file = $request->file($reqName);
                $path = $file->store('documents', 'public');
                
                \App\Models\Document::create([
                    'registration_id' => $registration->id,
                    'name' => $req->name,
                    'type' => $req->slug,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('applicant.dashboard')->with('success', 'Pendaftaran Anda berhasil dikirim! Nomor Pendaftaran Anda: ' . $registrationNumber);
    }

    /**
     * Print the registration proof.
     */
    public function print(Registration $registration)
    {
        // Ensure the registration belongs to the current user
        if ($registration->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        // Ensure the registration is accepted
        if ($registration->status !== 'accepted') {
            return redirect()->route('applicant.registration.create')
                ->with('error', 'Cetak bukti pendaftaran hanya tersedia untuk pendaftaran yang telah diterima.');
        }

        return view('applicant.registration.print', compact('registration'));
    }
}
