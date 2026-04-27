<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SmtpSettingController extends Controller
{
    /**
     * SMTP configuration keys and their defaults.
     */
    private array $smtpKeys = [
        'smtp_host'       => 'smtp.gmail.com',
        'smtp_port'       => '587',
        'smtp_encryption' => 'tls',
        'smtp_username'   => '',
        'smtp_password'   => '',
        'smtp_from_email' => '',
        'smtp_from_name'  => '',
    ];

    /**
     * Display the SMTP settings form.
     */
    public function index(): View
    {
        // Ensure all SMTP keys exist in the database
        foreach ($this->smtpKeys as $key => $default) {
            LandingSetting::firstOrCreate(
                ['key' => $key],
                ['group' => 'SMTP', 'value' => $default]
            );
        }

        $settings = LandingSetting::where('group', 'SMTP')
            ->orderBy('key')
            ->get()
            ->pluck('value', 'key');

        return view('superadmin.smtp-settings.index', compact('settings'));
    }

    /**
     * Update all SMTP settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'smtp_host'       => 'required|string',
            'smtp_port'       => 'required|numeric',
            'smtp_encryption' => 'required|in:tls,ssl,none',
            'smtp_username'   => 'nullable|string',
            'smtp_password'   => 'nullable|string',
            'smtp_from_email' => 'required|email',
            'smtp_from_name'  => 'required|string',
        ]);

        $settings = $request->only(array_keys($this->smtpKeys));

        foreach ($settings as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['group' => 'SMTP', 'value' => $value ?? '']
            );
        }

        return redirect()->back()->with('success', 'Konfigurasi SMTP berhasil disimpan!');
    }

    /**
     * Send a test email using the current SMTP settings.
     */
    public function testEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        // Load SMTP settings from database
        $smtp = LandingSetting::where('group', 'SMTP')
            ->get()
            ->pluck('value', 'key');

        // Dynamically configure mail
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', $smtp['smtp_host'] ?? 'smtp.gmail.com');
        Config::set('mail.mailers.smtp.port', intval($smtp['smtp_port'] ?? 587));
        Config::set('mail.mailers.smtp.encryption', ($smtp['smtp_encryption'] ?? 'tls') === 'none' ? null : $smtp['smtp_encryption']);
        Config::set('mail.mailers.smtp.username', $smtp['smtp_username'] ?? '');
        Config::set('mail.mailers.smtp.password', $smtp['smtp_password'] ?? '');
        Config::set('mail.from.address', $smtp['smtp_from_email'] ?? 'noreply@ppdbpro.test');
        Config::set('mail.from.name', $smtp['smtp_from_name'] ?? 'PPDB Pro');

        // Purge SMTP mailer to apply new config
        Mail::purge('smtp');

        try {
            $appName = LandingSetting::where('key', 'app_name')->value('value') ?? 'PPDB Pro';

            Mail::raw("Ini adalah email percobaan dari {$appName}. Jika Anda menerima email ini, maka konfigurasi SMTP Anda sudah benar!", function ($message) use ($request, $smtp, $appName) {
                $message->to($request->test_email)
                    ->subject("✅ Test SMTP - {$appName}");
            });

            return redirect()->back()->with('success', 'Email percobaan berhasil dikirim ke ' . $request->test_email . '!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
