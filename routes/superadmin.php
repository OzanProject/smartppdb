<?php

use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\LandingSettingController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\AdminUserController;
use App\Http\Controllers\SuperAdmin\PricingPlanController;
use App\Http\Controllers\SuperAdmin\SubscriptionController;
use App\Http\Controllers\SuperAdmin\StaticPageController;
use App\Http\Controllers\SuperAdmin\TestimonialController as SuperAdminTestimonialController;
use App\Http\Controllers\SuperAdmin\SmtpSettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // School Management
    Route::resource('schools', SchoolController::class);
    Route::post('schools/{school}/toggle-status', [SchoolController::class, 'toggleStatus'])->name('schools.toggle-status');

    // Admin User Management
    Route::resource('admin-users', AdminUserController::class);

    // Pricing & Features Management
    Route::resource('pricing-plans', PricingPlanController::class);

    // Landing Page Settings
    Route::get('/landing-settings', [LandingSettingController::class, 'index'])->name('landing-settings.index');
    Route::post('/landing-settings/update-all', [LandingSettingController::class, 'updateAll'])->name('landing-settings.update-all');
    
    // Static Pages Management
    Route::get('/static-pages', [StaticPageController::class, 'index'])->name('static-pages.index');
    Route::post('/static-pages', [StaticPageController::class, 'update'])->name('static-pages.update');

    // Testimonials Management
    Route::get('/testimonials', [SuperAdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/{testimonial}/toggle', [SuperAdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle');
    Route::delete('/testimonials/{testimonial}', [SuperAdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Subscription & Payment Management
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::post('/subscriptions/{subscription}/confirm', [SubscriptionController::class, 'confirm'])->name('subscriptions.confirm');
    Route::post('/subscriptions/{subscription}/reject', [SubscriptionController::class, 'reject'])->name('subscriptions.reject');
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    Route::get('/subscriptions/{subscription}/print', [SubscriptionController::class, 'printInvoice'])->name('subscriptions.print');
    Route::get('/payment-settings', [SubscriptionController::class, 'paymentSettings'])->name('payment-settings.index');
    Route::post('/payment-settings', [SubscriptionController::class, 'updatePaymentSettings'])->name('payment-settings.update');

    // SMTP Email Settings
    Route::get('/smtp-settings', [SmtpSettingController::class, 'index'])->name('smtp-settings.index');
    Route::post('/smtp-settings', [SmtpSettingController::class, 'update'])->name('smtp-settings.update');
    Route::post('/smtp-settings/test', [SmtpSettingController::class, 'testEmail'])->name('smtp-settings.test');
});
