<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::whereIn('role', ['admin_school', 'staff'])
            ->with('school')
            ->latest()
            ->paginate(10);

        return view('superadmin.admin-users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $schools = School::where('is_active', true)->get();
        return view('superadmin.admin-users.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin_school,staff',
            'school_id' => 'required|exists:schools,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'school_id' => $request->school_id,
        ]);

        // Send welcome email notification
        try {
            $school = School::find($request->school_id);
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\WelcomeRegistration(
                    $user->name,
                    $user->email,
                    $request->password,
                    $request->role,
                    $school?->name
                )
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Welcome email failed: ' . $e->getMessage());
        }

        return redirect()->route('superadmin.admin-users.index')->with('success', 'Akun Admin/Staff berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Only allow editing admin_school/staff
        if (!in_array($user->role, ['admin_school', 'staff'])) {
            abort(403);
        }

        $schools = School::all();
        return view('superadmin.admin-users.edit', compact('user', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if (!in_array($user->role, ['admin_school', 'staff'])) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin_school,staff',
            'school_id' => 'required|exists:schools,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'school_id' => $request->school_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.admin-users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->role === 'superadmin' || $user->id === auth()->id()) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('superadmin.admin-users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
