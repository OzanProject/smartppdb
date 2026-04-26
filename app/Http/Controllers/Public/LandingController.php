<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    private function getMarketingData(): array
    {
        return [
            'settings' => LandingSetting::getSettings(),
            'plans' => PricingPlan::orderBy('order_weight')->get(),
            'stats' => [
                'total_schools' => \App\Models\School::count(),
                'total_applicants' => \App\Models\Registration::count(),
            ],
            'schools' => \App\Models\School::orderBy('created_at', 'desc')->take(10)->get(),
            'testimonials' => \App\Models\Testimonial::with(['school', 'user'])->where('is_published', true)->take(6)->get()
        ];
    }

    /**
     * Display the SaaS main landing page.
     */
    public function index(): mixed
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            return match ($role) {
                'superadmin' => redirect()->route('superadmin.dashboard'),
                'admin_school' => redirect()->route('admin.dashboard'),
                default => redirect()->route('applicant.dashboard'),
            };
        }

        return view('public.welcome', $this->getMarketingData());
    }

    /**
     * Display the Features page.
     */
    public function fitur(): View
    {
        return view('public.fitur', $this->getMarketingData());
    }

    /**
     * Display the Pricing page.
     */
    public function harga(): View
    {
        return view('public.harga', $this->getMarketingData());
    }

    /**
     * Display the FAQ page.
     */
    public function faq(): View
    {
        return view('public.faq', $this->getMarketingData());
    }

    public function solusi(): View
    {
        return view('public.solusi', $this->getMarketingData());
    }

    public function tentangKami(): View
    {
        return view('public.about', $this->getMarketingData());
    }

    public function kontak(): View
    {
        return view('public.contact', $this->getMarketingData());
    }

    public function kebijakanPrivasi(): View
    {
        return view('public.privacy', $this->getMarketingData());
    }

    public function syaratKetentuan(): View
    {
        return view('public.terms', $this->getMarketingData());
    }
}
