<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): \Illuminate\View\View
    {
        $schoolSlug = $request->query('school');
        $school = $schoolSlug ? \App\Models\School::where('slug', $schoolSlug)->first() : null;
        
        return view('auth.register', compact('school'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'applicant',
            'school_id' => $request->school_id,
        ]);

        event(new Registered($user));

        // Send welcome email notification
        try {
            $school = $request->school_id ? \App\Models\School::find($request->school_id) : null;
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\WelcomeRegistration(
                    $user->name,
                    $user->email,
                    $request->password,
                    'applicant',
                    $school?->name
                )
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Welcome email failed: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
