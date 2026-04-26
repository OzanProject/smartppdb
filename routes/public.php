<?php

use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

// Public Registration & Tracking
Route::get('/{school:slug}/pendaftaran', [PublicController::class, 'registrationForm'])->name('school.registration.form');
Route::post('/{school:slug}/pendaftaran', [PublicController::class, 'submitRegistration'])->name('school.registration.submit');
Route::get('/{school:slug}/cek-status', [PublicController::class, 'trackForm'])->name('school.registration.track');
Route::post('/{school:slug}/cek-status', [PublicController::class, 'trackStatusSubmit'])->name('school.registration.track.submit');

// Dynamic School Landing Pages (Catch-all) - MUST BE LAST
Route::get('/{school:slug}/{section?}', [PublicController::class, 'landing'])->name('school.landing');
