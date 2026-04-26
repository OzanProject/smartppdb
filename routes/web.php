<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/fitur', [LandingController::class, 'fitur'])->name('public.fitur');
Route::get('/harga', [LandingController::class, 'harga'])->name('public.harga');
Route::get('/faq', [LandingController::class, 'faq'])->name('public.faq');
Route::get('/solusi', [LandingController::class, 'solusi'])->name('public.solusi');
Route::get('/tentang-kami', [LandingController::class, 'tentangKami'])->name('public.about');
Route::get('/kontak', [LandingController::class, 'kontak'])->name('public.contact');
Route::get('/kebijakan-privasi', [LandingController::class, 'kebijakanPrivasi'])->name('public.privacy');
Route::get('/syarat-ketentuan', [LandingController::class, 'syaratKetentuan'])->name('public.terms');
Route::get('/sitemap.xml', [\App\Http\Controllers\Public\SitemapController::class, 'index']);
Route::get('/robots.txt', [\App\Http\Controllers\Public\SitemapController::class, 'robots']);

// School Registration Flow
use App\Http\Controllers\Public\SchoolRegistrationController;
Route::get('/register-school', [SchoolRegistrationController::class, 'show'])->name('school.register');
Route::post('/register-school', [SchoolRegistrationController::class, 'store'])->name('school.register.store');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin_school', 'staff' => redirect()->route('admin.dashboard'),
        default => redirect()->route('applicant.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/{role}/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/{role}/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/{role}/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/{role}/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/applicant.php';
require __DIR__.'/superadmin.php';
require __DIR__.'/public.php';
