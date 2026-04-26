<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of accepted students.
     */
    public function index(Request $request): View
    {
        $schoolId = auth()->user()->school_id;
        $search = $request->input('search');
        $batchId = $request->input('batch_id');

        if (!$schoolId) {
            abort(403, 'Akun Anda belum terhubung dengan data sekolah.');
        }

        $students = Registration::query()
            ->where('school_id', $schoolId)
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
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        $batches = \App\Models\AdmissionBatch::where('school_id', $schoolId)->get();

        return view('admin.students.index', compact('students', 'batches'));
    }

    /**
     * Export students to Excel or PDF.
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'excel'); // excel or pdf
        $schoolId = auth()->user()->school_id;
        $school = \App\Models\School::find($schoolId);
        $filename = 'data_siswa_diterima_' . date('YmdHis');

        $search = $request->input('search');
        $batchId = $request->input('batch_id');

        $students = Registration::query()
            ->where('school_id', $schoolId)
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

        if ($type === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.students.pdf', [
                'students' => $students,
                'school' => $school,
                'title' => 'DAFTAR SISWA LOLOS SELEKSI (ACCEPTED)'
            ])->setPaper('a4', 'landscape');
            
            return $pdf->download($filename . '.pdf');
        }

        $export = new \App\Exports\StudentsExport($schoolId, $request->all());
        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename . '.xlsx');
    }
}
