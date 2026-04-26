<?php

namespace App\Imports;

use App\Models\FormSection;
use App\Models\FormField;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FormStructureImport implements ToCollection, WithHeadingRow
{
    protected $schoolId;

    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $currentSection = null;
        $orderWeightSection = FormSection::where('school_id', $this->schoolId)->max('order_weight') + 1;
        $orderWeightField = 1;

        foreach ($rows as $row) {
            // Skip empty rows
            if (empty($row['bagian']) && empty($row['label_kolom'])) {
                continue;
            }

            // Handle Section
            $sectionName = trim($row['bagian']);
            if (!empty($sectionName)) {
                // Find or create section for this school
                $currentSection = FormSection::firstOrCreate(
                    [
                        'school_id' => $this->schoolId,
                        'name' => $sectionName
                    ],
                    [
                        'order_weight' => $orderWeightSection++
                    ]
                );
                
                // If it was already there, we might want to get its last field order weight
                // but for simplicity we'll just increment from 1 per import session
            }

            if (!$currentSection) {
                continue; // No section to attach fields to
            }

            // Handle Field
            $label = trim($row['label_kolom']);
            if (!empty($label)) {
                $type = strtolower(trim($row['tipe'] ?? 'text'));
                $validTypes = ['text', 'number', 'date', 'select', 'textarea'];
                if (!in_array($type, $validTypes)) {
                    $type = 'text';
                }

                $options = null;
                if ($type === 'select' && !empty($row['opsi'])) {
                    $options = array_map('trim', explode(',', $row['opsi']));
                }

                $isRequired = strtolower(trim($row['wajib'] ?? 'y')) === 'y' ? 1 : 0;

                FormField::create([
                    'form_section_id' => $currentSection->id,
                    'label' => $label,
                    'help_text' => $row['keterangan'] ?? null,
                    'name' => Str::slug($label, '_'),
                    'type' => $type,
                    'options' => $options,
                    'is_required' => $isRequired,
                    'order_weight' => $orderWeightField++,
                    'is_active' => 1
                ]);
            }
        }
    }
}
