<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AdmissionBatch;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $school = $user->school;

        $activeAdmissionBatches = collect();
        $activeAcademicYear = null;
        $stats = [
            'registrations_count' => 0,
            'pending_count' => 0,
            'verified_count' => 0,
            'accepted_count' => 0,
        ];

        if ($school) {
            $activeAcademicYear = AcademicYear::query()
                ->where('school_id', $school->id)
                ->where('is_active', true)
                ->first();

            $activeAdmissionBatches = AdmissionBatch::query()
                ->where('school_id', $school->id)
                ->where('is_active', true)
                ->with('academicYear')
                ->get();

            $stats = [
                'registrations_count' => Registration::where('school_id', $school->id)->count(),
                'pending_count' => Registration::where('school_id', $school->id)->where('status', 'pending')->count(),
                'verified_count' => Registration::where('school_id', $school->id)->where('status', 'verified')->count(),
                'accepted_count' => Registration::where('school_id', $school->id)->where('status', 'accepted')->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'user',
            'school',
            'activeAcademicYear',
            'activeAdmissionBatches',
            'stats'
        ));
    }
}