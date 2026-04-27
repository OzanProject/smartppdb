<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\LandingSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        if (Schema::hasTable('landing_settings')) {
            // Share settings to all views
            $settings = LandingSetting::all()->pluck('value', 'key');
            View::share('landingSettings', $settings);
            
            // Optional: Define a global constant or config if needed
            config(['app.name' => $settings['app_name'] ?? config('app.name')]);
            
            // Set global timezone
            if (isset($settings['app_timezone'])) {
                config(['app.timezone' => $settings['app_timezone']]);
                date_default_timezone_set($settings['app_timezone']);
            }

            // Global SMTP Configuration
            $smtp = LandingSetting::where('group', 'SMTP')->pluck('value', 'key');
            if ($smtp->isNotEmpty() && !empty($smtp['smtp_host'])) {
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.host' => $smtp['smtp_host'],
                    'mail.mailers.smtp.port' => (int) ($smtp['smtp_port'] ?? 587),
                    'mail.mailers.smtp.encryption' => ($smtp['smtp_encryption'] ?? 'tls') === 'none' ? null : ($smtp['smtp_encryption'] ?? 'tls'),
                    'mail.mailers.smtp.username' => $smtp['smtp_username'],
                    'mail.mailers.smtp.password' => $smtp['smtp_password'],
                    'mail.from.address' => $smtp['smtp_from_email'] ?? config('mail.from.address'),
                    'mail.from.name' => $smtp['smtp_from_name'] ?? config('mail.from.name'),
                ]);
            }
        }
    }
}
