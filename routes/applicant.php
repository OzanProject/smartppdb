<?php

use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:applicant'])->prefix('applicant')->name('applicant.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    
    // Registration Flow
    Route::get('/registration', [RegistrationController::class, 'create'])->name('registration.create');
    Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
    Route::get('/registration/{registration}/print', [RegistrationController::class, 'print'])->name('registration.print');
});
