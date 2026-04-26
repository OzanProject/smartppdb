<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class SchoolRegistrationController extends Controller
{
    /**
     * Show the school registration form.
     */
    public function show(Request $request)
    {
        $selectedPlanId = $request->query('plan');
        $plans = PricingPlan::orderBy('order_weight')->get();
        $selectedPlan = $selectedPlanId ? PricingPlan::find($selectedPlanId) : $plans->first();

        return view('auth.register_school', compact('plans', 'selectedPlan'));
    }

    /**
     * Handle school registration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:schools,npsn',
            'education_level' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'pricing_plan_id' => 'required|exists:pricing_plans,id',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Create School
            $plan = PricingPlan::find($request->pricing_plan_id);
            $trialDays = $plan ? $plan->trial_days : 14;

            $school = School::create([
                'name' => $request->school_name,
                'npsn' => $request->npsn,
                'education_level_name' => $request->education_level,
                'education_level_code' => Str::slug($request->education_level),
                'slug' => Str::slug($request->school_name) . '-' . rand(1000, 9999),
                'pricing_plan_id' => $request->pricing_plan_id,
                'trial_ends_at' => now()->addDays($trialDays),
                'is_active' => true,
            ]);

            // 2. Create Admin User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin_school',
                'school_id' => $school->id,
            ]);

            event(new Registered($user));

            // Send welcome email notification
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(
                    new \App\Mail\WelcomeRegistration(
                        $user->name,
                        $user->email,
                        $request->password,
                        'admin_school',
                        $school->name
                    )
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Welcome email failed: ' . $e->getMessage());
            }

            Auth::login($user);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat! Sekolah Anda berhasil terdaftar. Silakan lengkapi profil sekolah Anda.');
        });
    }
}
