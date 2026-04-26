<?php

namespace App\Exports;

use App\Models\Registration;
use App\Models\School;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $schoolId;
    protected $filters;

    public function __construct($schoolId, $filters = [])
    {
        $this->schoolId = $schoolId;
        $this->filters = $filters;
    }

    public function view(): View
    {
        $search = $this->filters['search'] ?? null;
        $batchId = $this->filters['batch_id'] ?? null;

        $school = School::find($this->schoolId);

        $students = Registration::query()
            ->where('school_id', $this->schoolId)
            ->where('status', 'accepted')
            ->when($search, function($q) use ($search) {
                $q->where(function($q) use ($search) {
                    $q->whereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    })->orWhere('registration_number', 'like', "%$search%");
                });
            })
            ->when($batchId, function($q) use ($batchId) {
                $q->where('admission_batch_id', $batchId);
            })
            ->with(['user', 'admissionBatch.academicYear'])
            ->latest()
            ->get();

        return view('admin.students.export', [
            'students' => $students,
            'school' => $school,
            'title' => 'DAFTAR SISWA LOLOS SELEKSI (ACCEPTED)'
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the title row
            1 => ['font' => ['bold' => true, 'size' => 16]],
            // Style the sub-title / school name
            2 => ['font' => ['bold' => true, 'size' => 14]],
            // Headings for the table
            7 => ['font' => ['bold' => true]],
        ];
    }
}
