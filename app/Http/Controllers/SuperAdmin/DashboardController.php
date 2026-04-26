<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Models\Registration;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $stats = [
            'schools_count' => School::count(),
            'users_count' => User::count(),
            'total_registrations' => Registration::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'total_revenue' => Subscription::where('status', 'active')->sum('amount'),
        ];

        $schoolStats = School::withCount(['registrations', 'users'])
            ->orderBy('registrations_count', 'desc')
            ->take(5)
            ->get();

        $recentSchools = School::latest()->take(5)->get();

        return view('superadmin.dashboard', compact('stats', 'schoolStats', 'recentSchools'));
    }
}
