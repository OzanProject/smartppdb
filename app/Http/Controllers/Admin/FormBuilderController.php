<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSection;
use App\Models\FormField;
use App\Models\DocumentRequirement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Imports\FormStructureImport;
use App\Exports\FormTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class FormBuilderController extends Controller
{
    public function index(Request $request): View
    {
        $school = $request->user()->school;
        $sections = $school->formSections()->with('fields')->orderBy('order_weight')->get();
        $requirements = $school->documentRequirements()->orderBy('order_weight')->get();

        return view('admin.form-builder.index', compact('sections', 'requirements'));
    }

    /**
     * Section Management
     */
    public function storeSection(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:100']);
        
        $request->user()->school->formSections()->create([
            'name' => $request->name,
            'order_weight' => FormSection::where('school_id', $request->user()->school->id)->max('order_weight') + 1
        ]);

        return back()->with('success', 'Bagian formulir berhasil ditambahkan.');
    }

    public function updateSection(Request $request, FormSection $section): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'order_weight' => 'required|integer',
        ]);

        $section->update([
            'name' => $validated['name'],
            'order_weight' => $validated['order_weight'],
            'is_active' => $request->has('is_active')
        ]);

        return back()->with('success', 'Bagian formulir berhasil diperbarui.');
    }

    /**
     * Duplicate an existing section along with its fields.
     */
    public function duplicateSection(FormSection $section): RedirectResponse
    {
        // Duplicate the section
        $newSection = $section->replicate();
        $newSection->name = $section->name . ' (Copy)';
        $newSection->order_weight = $section->order_weight + 1;
        $newSection->save();

        // Duplicate all fields
        foreach ($section->fields as $field) {
            $newField = $field->replicate();
            $newField->form_section_id = $newSection->id;
            $newField->save();
        }

        return back()->with('success', 'Bagian formulir berhasil digandakan.');
    }

    /**
     * Import form structure from Excel.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new FormStructureImport(auth()->user()->school_id), $request->file('file'));
            return back()->with('success', 'Struktur formulir berhasil diimpor dari Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }

    /**
     * Download Excel template for form structure.
     */
    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = 'template-form-ppdb-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new FormTemplateExport, $filename);
    }

    public function destroySection(FormSection $section): RedirectResponse
    {
        $section->delete();
        return back()->with('success', 'Bagian formulir berhasil dihapus.');
    }

    /**
     * Field Management
     */
    public function storeField(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'form_section_id' => 'required|exists:form_sections,id',
            'label' => 'required|string|max:100',
            'help_text' => 'nullable|string',
            'type' => 'required|string|in:text,number,date,select,textarea',
            'options' => 'nullable|string',
            'is_required' => 'nullable',
        ]);

        $options = null;
        if (!empty($validated['options'])) {
            $options = array_map('trim', explode(',', $validated['options']));
        }

        FormField::create([
            'form_section_id' => $validated['form_section_id'],
            'label' => $validated['label'],
            'help_text' => $validated['help_text'],
            'name' => Str::slug($validated['label'], '_'),
            'type' => $validated['type'],
            'options' => $options,
            'is_required' => $request->has('is_required'),
            'is_featured' => $request->has('is_featured'),
            'order_weight' => FormField::where('form_section_id', $validated['form_section_id'])->max('order_weight') + 1
        ]);

        return back()->with('success', 'Kolom data berhasil ditambahkan.');
    }

    public function updateField(Request $request, FormField $field): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'help_text' => 'nullable|string',
            'type' => 'required|string|in:text,number,date,select,textarea',
            'options' => 'nullable|string',
            'order_weight' => 'required|integer',
        ]);

        $options = null;
        if (!empty($validated['options'])) {
            $options = is_array($validated['options']) ? $validated['options'] : array_map('trim', explode(',', $validated['options']));
        }

        $field->update([
            'label' => $validated['label'],
            'help_text' => $validated['help_text'],
            'name' => Str::slug($validated['label'], '_'),
            'type' => $validated['type'],
            'options' => $options,
            'is_required' => $request->has('is_required'),
            'is_featured' => $request->has('is_featured'),
            'order_weight' => $validated['order_weight'],
            'is_active' => $request->has('is_active')
        ]);

        return back()->with('success', 'Kolom data berhasil diperbarui.');
    }

    public function destroyField(FormField $field): RedirectResponse
    {
        $field->delete();
        return back()->with('success', 'Kolom data berhasil dihapus.');
    }

    /**
     * Document Requirement Management
     */
    public function storeRequirement(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string']);
        
        $user = $request->user();
        $names = array_map('trim', explode(',', $request->name));
        $count = 0;

        foreach ($names as $name) {
            if (empty($name)) continue;

            $user->school->documentRequirements()->create([
                'name' => $name,
                'slug' => Str::slug($name, '_'),
                'is_required' => $request->has('is_required'),
                'order_weight' => DocumentRequirement::where('school_id', $user->school->id)->max('order_weight') + 1
            ]);
            $count++;
        }

        $message = $count > 1 ? "$count syarat dokumen berhasil ditambahkan." : "Syarat dokumen berhasil ditambahkan.";
        return back()->with('success', $message);
    }

    public function updateRequirement(Request $request, DocumentRequirement $requirement): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'order_weight' => 'required|integer'
        ]);

        $requirement->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'is_required' => $request->has('is_required'),
            'order_weight' => $request->order_weight
        ]);

        return back()->with('success', 'Syarat dokumen berhasil diperbarui.');
    }

    public function destroyRequirement(DocumentRequirement $requirement): RedirectResponse
    {
        $requirement->delete();
        return back()->with('success', 'Syarat dokumen berhasil dihapus.');
    }
}
