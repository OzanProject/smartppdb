@extends('superadmin.layouts.app')

@section('title', 'Konfigurasi SMTP Email')
@section('header', 'Pengaturan Email Server (SMTP)')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card card-outline card-danger shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.smtp-settings.update') }}" method="POST">
                @csrf
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-server mr-2 text-danger"></i> Konfigurasi SMTP</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <p class="text-muted mb-4">Pengaturan ini digunakan untuk mengirim email notifikasi ke pengguna (pendaftaran akun, reset password, dll).</p>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="text-sm font-weight-bold"><i class="fas fa-globe mr-1 text-muted"></i> SMTP Host</label>
                                <input type="text" name="smtp_host" class="form-control @error('smtp_host') is-invalid @enderror" value="{{ old('smtp_host', $settings['smtp_host'] ?? 'smtp.gmail.com') }}" placeholder="smtp.gmail.com">
                                @error('smtp_host')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Contoh: smtp.gmail.com, smtp.zoho.com, mail.namadomain.com</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-sm font-weight-bold"><i class="fas fa-hashtag mr-1 text-muted"></i> Port</label>
                                <input type="number" name="smtp_port" class="form-control @error('smtp_port') is-invalid @enderror" value="{{ old('smtp_port', $settings['smtp_port'] ?? '587') }}" placeholder="587">
                                @error('smtp_port')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-sm font-weight-bold"><i class="fas fa-lock mr-1 text-muted"></i> Enkripsi</label>
                        <select name="smtp_encryption" class="form-control @error('smtp_encryption') is-invalid @enderror">
                            <option value="tls" {{ old('smtp_encryption', $settings['smtp_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS (Rekomendasi - Port 587)</option>
                            <option value="ssl" {{ old('smtp_encryption', $settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                            <option value="none" {{ old('smtp_encryption', $settings['smtp_encryption'] ?? '') == 'none' ? 'selected' : '' }}>Tanpa Enkripsi</option>
                        </select>
                        @error('smtp_encryption')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="font-weight-bold mb-3"><i class="fas fa-key mr-1 text-primary"></i> Autentikasi</h6>

                    <div class="form-group">
                        <label class="text-sm font-weight-bold"><i class="fas fa-user mr-1 text-muted"></i> Username / Email</label>
                        <input type="text" name="smtp_username" class="form-control @error('smtp_username') is-invalid @enderror" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}" placeholder="admin@namadomain.com">
                        @error('smtp_username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Untuk Gmail, gunakan alamat email lengkap Anda dan <a href="https://myaccount.google.com/apppasswords" target="_blank">App Password</a>.</small>
                    </div>

                    <div class="form-group">
                        <label class="text-sm font-weight-bold"><i class="fas fa-key mr-1 text-muted"></i> Password</label>
                        <div class="input-group">
                            <input type="password" name="smtp_password" id="smtpPassword" class="form-control @error('smtp_password') is-invalid @enderror" value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}" placeholder="••••••••">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('smtp_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="font-weight-bold mb-3"><i class="fas fa-envelope mr-1 text-success"></i> Pengirim Email</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sm font-weight-bold">Email Pengirim</label>
                                <input type="email" name="smtp_from_email" class="form-control @error('smtp_from_email') is-invalid @enderror" value="{{ old('smtp_from_email', $settings['smtp_from_email'] ?? '') }}" placeholder="noreply@namadomain.com">
                                @error('smtp_from_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sm font-weight-bold">Nama Pengirim</label>
                                <input type="text" name="smtp_from_name" class="form-control @error('smtp_from_name') is-invalid @enderror" value="{{ old('smtp_from_name', $settings['smtp_from_name'] ?? '') }}" placeholder="PPDB Pro">
                                @error('smtp_from_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-top-0 px-4 py-3 text-right" style="border-radius: 0 0 15px 15px;">
                    <button type="submit" class="btn btn-danger px-5 shadow-sm btn-submit" style="border-radius: 50px; font-weight: bold;">
                        <i class="fas fa-save mr-1"></i> SIMPAN KONFIGURASI
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Test Email -->
        <div class="card card-outline card-info shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-paper-plane mr-2 text-info"></i> Kirim Email Tes</h3>
            </div>
            <div class="card-body px-4 pb-4">
                <p class="text-muted text-sm mb-3">Kirim email percobaan untuk memverifikasi bahwa konfigurasi SMTP Anda sudah benar.</p>
                <form action="{{ route('superadmin.smtp-settings.test') }}" method="POST" class="form-test">
                    @csrf
                    <div class="form-group">
                        <label class="text-sm font-weight-bold">Email Tujuan Tes</label>
                        <input type="email" name="test_email" class="form-control @error('test_email') is-invalid @enderror" placeholder="email-anda@gmail.com" required>
                        @error('test_email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-info btn-block shadow-sm btn-test" style="border-radius: 50px; font-weight: bold;">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Email Tes
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Box -->
        <div class="card shadow-sm border-0" style="border-radius: 15px; background: linear-gradient(135deg, #1e3a5f 0%, #111827 100%);">
            <div class="card-body text-white p-4">
                <h6 class="font-weight-bold mb-3"><i class="fas fa-lightbulb text-warning mr-1"></i> Tips Konfigurasi</h6>
                <ul class="text-sm pl-3 mb-0" style="line-height: 1.8;">
                    <li><strong>Gmail:</strong> Host <code>smtp.gmail.com</code>, Port <code>587</code>, TLS. Wajib gunakan <a href="https://myaccount.google.com/apppasswords" target="_blank" class="text-info">App Password</a>.</li>
                    <li><strong>Zoho:</strong> Host <code>smtp.zoho.com</code>, Port <code>465</code>, SSL.</li>
                    <li><strong>CPanel:</strong> Gunakan Host <code>mail.domain.com</code>, Port <code>465</code> (SSL) atau <code>587</code> (TLS).</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('smtpPassword');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Loading states for buttons
    $('.form-test').on('submit', function() {
        $('.btn-test').attr('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengirim...');
    });

    $('form:not(.form-test)').on('submit', function() {
        $('.btn-submit').attr('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
    });
</script>
@endpush
