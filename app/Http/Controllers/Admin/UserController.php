<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // PROTECTION: Only fetch admin_school and staff roles belonging to the current admin's school
        $users = User::where('school_id', auth()->user()->school_id)
            ->whereIn('role', ['admin_school', 'staff'])
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin_school,staff',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'school_id' => auth()->user()->school_id,
            'password' => Hash::make($validated['password']),
        ]);

        // Send welcome email notification
        try {
            $school = \App\Models\School::find(auth()->user()->school_id);
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\WelcomeRegistration(
                    $user->name,
                    $user->email,
                    $validated['password'],
                    $validated['role'],
                    $school?->name
                )
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Welcome email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // PROTECTION: Ensure the user belongs to the same school and is a staff/admin
        if ($user->school_id !== auth()->user()->school_id || !in_array($user->role, ['admin_school', 'staff'])) {
            abort(403, 'Anda tidak diizinkan mengubah pengguna ini.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin_school,staff',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        // PROTECTION: Ensure the user belongs to the same school
        if ($user->school_id !== auth()->user()->school_id || !in_array($user->role, ['admin_school', 'staff'])) {
            abort(403, 'Anda tidak diizinkan menghapus pengguna ini.');
        }
        
        // PROTECTION: Cannot delete self
        if ($user->id === $request->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
