<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $registration = $user->registrations()->with(['school', 'admissionBatch'])->latest()->first();

        $showAnnouncement = false;
        $announcement = null;

        if ($registration && $registration->admissionBatch) {
            $announcement = \App\Models\Announcement::where('admission_batch_id', $registration->admissionBatch->id)
                ->where('is_published', true)
                ->latest()
                ->first();

            if ($announcement) {
                $showAnnouncement = true;
            }
        }

        return view('applicant.dashboard', compact('registration', 'user', 'showAnnouncement', 'announcement'));
    }
}
