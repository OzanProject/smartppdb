<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdmissionBatchController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin_school,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    // Subscription & Billing (accessible to admin_school)
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}/invoice', [SubscriptionController::class, 'invoice'])->name('subscriptions.invoice');
    Route::get('/subscriptions/{subscription}/print', [SubscriptionController::class, 'printInvoice'])->name('subscriptions.print');
    Route::post('/subscriptions/{subscription}/upload-proof', [SubscriptionController::class, 'uploadProof'])->name('subscriptions.upload-proof');
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    // Shared Operational Routes (Staff & Admin)
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{registration}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::patch('/registrations/{registration}/status', [RegistrationController::class, 'updateStatus'])->name('registrations.status');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');

    // Admin Only - Critical Configuration Routes
    Route::middleware(['role:admin_school'])->group(function () {
        Route::resource('academic-years', AcademicYearController::class);
        Route::resource('batches', AdmissionBatchController::class);
        Route::resource('users', UserController::class);

        // Announcement Management
        Route::resource('announcements', AnnouncementController::class)->except(['show', 'create', 'edit']);
        
        // School Settings
        Route::get('school/edit', [SchoolController::class, 'edit'])->name('school.edit');
        Route::patch('school', [SchoolController::class, 'update'])->name('school.update');
        Route::post('school/testimonial', [TestimonialController::class, 'store'])->name('school.testimonial.store');
        Route::delete('school/logo', [SchoolController::class, 'destroyLogo'])->name('school.logo.destroy');

        // Form Builder
        Route::get('/form-builder', [FormBuilderController::class, 'index'])->name('form-builder.index');
        Route::post('/form-builder/sections', [FormBuilderController::class, 'storeSection'])->name('form-builder.sections.store');
        Route::post('/form-builder/sections/{section}/duplicate', [FormBuilderController::class, 'duplicateSection'])->name('form-builder.sections.duplicate');
        Route::put('/form-builder/sections/{section}', [FormBuilderController::class, 'updateSection'])->name('form-builder.sections.update');
        Route::delete('/form-builder/sections/{section}', [FormBuilderController::class, 'destroySection'])->name('form-builder.sections.destroy');
        
        Route::post('/form-builder/fields', [FormBuilderController::class, 'storeField'])->name('form-builder.fields.store');
        Route::put('/form-builder/fields/{field}', [FormBuilderController::class, 'updateField'])->name('form-builder.fields.update');
        Route::delete('/form-builder/fields/{field}', [FormBuilderController::class, 'destroyField'])->name('form-builder.fields.destroy');
        
        Route::post('/form-builder/import', [FormBuilderController::class, 'import'])->name('form-builder.import');
        Route::get('/form-builder/template', [FormBuilderController::class, 'downloadTemplate'])->name('form-builder.template');
        
        Route::post('/form-builder/requirements', [FormBuilderController::class, 'storeRequirement'])->name('form-builder.requirements.store');
        Route::put('/form-builder/requirements/{requirement}', [FormBuilderController::class, 'updateRequirement'])->name('form-builder.requirements.update');
        Route::delete('/form-builder/requirements/{requirement}', [FormBuilderController::class, 'destroyRequirement'])->name('form-builder.requirements.destroy');

        // Landing Page Management
        Route::get('landing-page', [LandingPageController::class, 'index'])->name('landing-page.index');
        Route::patch('landing-page/hero-stats', [LandingPageController::class, 'updateHeroStats'])->name('landing-page.hero-stats');
        Route::post('landing-page/contents', [LandingPageController::class, 'storeContent'])->name('landing-page.contents.store');
        Route::put('landing-page/contents/{content}', [LandingPageController::class, 'updateContent'])->name('landing-page.contents.update');
        Route::delete('landing-page/contents/{content}', [LandingPageController::class, 'destroyContent'])->name('landing-page.contents.destroy');
    });
});
