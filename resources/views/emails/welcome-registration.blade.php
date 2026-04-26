<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - {{ $appName }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f1f5f9;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: 0 auto; max-width: 600px;">
                    
                    {{-- Header with Logo --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 40px 40px 30px 40px; text-align: center; border-radius: 20px 20px 0 0;">
                            @if($appLogo)
                                <img src="{{ asset('storage/' . $appLogo) }}" alt="{{ $appName }}" style="height: 50px; margin-bottom: 12px; object-fit: contain;">
                            @else
                                <div style="display: inline-block; background: rgba(255,255,255,0.2); border-radius: 16px; padding: 12px 20px; margin-bottom: 12px;">
                                    <span style="font-size: 24px; font-weight: 900; color: #ffffff; letter-spacing: -1px;">{{ $appName }}</span>
                                </div>
                            @endif
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; line-height: 1.3;">
                                🎉 Selamat Datang, {{ $userName }}!
                            </h1>
                            <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.8); font-size: 14px;">
                                Akun Anda telah berhasil dibuat di platform {{ $appName }}
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background-color: #ffffff; padding: 40px;">
                            
                            {{-- Role Badge --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="padding-bottom: 24px;">
                                        @php
                                            $roleLabel = match ($role) {
                                                'superadmin'   => 'Super Admin',
                                                'admin_school' => 'Admin Sekolah',
                                                'applicant'    => 'Calon Siswa',
                                                default        => 'Pengguna',
                                            };
                                            $roleColor = match ($role) {
                                                'superadmin'   => '#dc2626',
                                                'admin_school' => '#2563eb',
                                                'applicant'    => '#059669',
                                                default        => '#6b7280',
                                            };
                                        @endphp
                                        <span style="display: inline-block; background-color: {{ $roleColor }}15; color: {{ $roleColor }}; font-size: 12px; font-weight: 800; padding: 6px 16px; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid {{ $roleColor }}30;">
                                            {{ $roleLabel }}
                                        </span>

                                        @if($schoolName)
                                            <span style="display: inline-block; background-color: #f0f9ff; color: #0369a1; font-size: 12px; font-weight: 600; padding: 6px 16px; border-radius: 50px; margin-left: 8px; border: 1px solid #bae6fd;">
                                                🏫 {{ $schoolName }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #334155; font-size: 15px; line-height: 1.7; margin: 0 0 24px 0;">
                                Halo <strong>{{ $userName }}</strong>,<br><br>
                                Terima kasih telah mendaftar di <strong>{{ $appName }}</strong>. Berikut adalah informasi akun Anda:
                            </p>

                            {{-- Credentials Card --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0; border-radius: 16px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 24px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <span style="color: #94a3b8; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">📧 Email / Username</span><br>
                                                    <span style="color: #1e293b; font-size: 16px; font-weight: 700;">{{ $userEmail }}</span>
                                                </td>
                                            </tr>
                                            @if($userPassword)
                                            <tr>
                                                <td style="padding: 12px 0 8px 0; border-top: 1px dashed #e2e8f0;">
                                                    <span style="color: #94a3b8; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">🔑 Password</span><br>
                                                    <span style="color: #1e293b; font-size: 16px; font-weight: 700; font-family: 'Courier New', monospace; background: #fef3c7; padding: 4px 12px; border-radius: 6px; border: 1px solid #fcd34d;">{{ $userPassword }}</span>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if($userPassword)
                            <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                                <p style="margin: 0; color: #991b1b; font-size: 13px; font-weight: 600;">
                                    ⚠️ <strong>Penting:</strong> Demi keamanan akun Anda, segera ubah password setelah login pertama kali.
                                </p>
                            </div>
                            @endif

                            {{-- CTA Button --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: center; padding: 8px 0 16px 0;">
                                        <a href="{{ $loginUrl }}" style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 16px 48px; border-radius: 14px; font-size: 16px; font-weight: 800; letter-spacing: 0.5px; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);">
                                            🚀 Login Sekarang
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #94a3b8; font-size: 13px; text-align: center; margin: 0;">
                                Atau kunjungi: <a href="{{ $loginUrl }}" style="color: #4f46e5; text-decoration: none;">{{ $loginUrl }}</a>
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #1e293b; padding: 30px 40px; text-align: center; border-radius: 0 0 20px 20px;">
                            <p style="color: #94a3b8; font-size: 12px; margin: 0 0 8px 0; line-height: 1.6;">
                                Email ini dikirim otomatis oleh sistem <strong style="color: #e2e8f0;">{{ $appName }}</strong>.<br>
                                Jika Anda merasa tidak mendaftar, abaikan email ini.
                            </p>
                            <p style="color: #475569; font-size: 11px; margin: 0; font-weight: 600;">
                                © {{ date('Y') }} {{ $appName }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
