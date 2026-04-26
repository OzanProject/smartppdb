<?php

namespace App\Mail;

use App\Models\LandingSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class WelcomeRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public string $userName;
    public string $userEmail;
    public ?string $userPassword;
    public string $role;
    public string $appName;
    public ?string $appLogo;
    public string $loginUrl;
    public ?string $schoolName;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $userName,
        string $userEmail,
        ?string $userPassword,
        string $role,
        ?string $schoolName = null
    ) {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->role = $role;
        $this->schoolName = $schoolName;
        $this->appName = LandingSetting::where('key', 'app_name')->value('value') ?? 'PPDB Pro';
        $this->appLogo = LandingSetting::where('key', 'app_logo')->value('value');
        $this->loginUrl = route('login');

        // Dynamically configure SMTP from database
        self::configureSMTP();
    }

    /**
     * Configure SMTP mailer from database settings.
     */
    public static function configureSMTP(): void
    {
        $smtp = LandingSetting::where('group', 'SMTP')
            ->get()
            ->pluck('value', 'key');

        if ($smtp->isEmpty()) {
            return;
        }

        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', $smtp['smtp_host'] ?? 'smtp.gmail.com');
        Config::set('mail.mailers.smtp.port', intval($smtp['smtp_port'] ?? 587));
        Config::set('mail.mailers.smtp.encryption', ($smtp['smtp_encryption'] ?? 'tls') === 'none' ? null : ($smtp['smtp_encryption'] ?? 'tls'));
        Config::set('mail.mailers.smtp.username', $smtp['smtp_username'] ?? '');
        Config::set('mail.mailers.smtp.password', $smtp['smtp_password'] ?? '');
        Config::set('mail.from.address', $smtp['smtp_from_email'] ?? 'noreply@ppdbpro.test');
        Config::set('mail.from.name', $smtp['smtp_from_name'] ?? 'PPDB Pro');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $roleLabel = match ($this->role) {
            'superadmin'   => 'Super Admin',
            'admin_school' => 'Admin Sekolah',
            'applicant'    => 'Pendaftar',
            default        => 'Pengguna',
        };

        return new Envelope(
            subject: "✅ Selamat Datang di {$this->appName} - Akun {$roleLabel} Anda Berhasil Dibuat",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome-registration',
        );
    }
}
