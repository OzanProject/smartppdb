@extends('superadmin.layouts.app')

@section('title', 'Pengaturan Pembayaran')
@section('header', 'Pengaturan Metode Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.payment-settings.update') }}" method="POST">
                @csrf
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-university mr-2 text-primary"></i>Informasi Rekening Transfer Manual</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Bank <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" value="{{ $settings['bank_name'] ?? '' }}" placeholder="Contoh: BCA, BNI, Mandiri" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" name="bank_account_number" class="form-control" value="{{ $settings['bank_account_number'] ?? '' }}" placeholder="1234567890" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Atas Nama <span class="text-danger">*</span></label>
                        <input type="text" name="bank_account_name" class="form-control" value="{{ $settings['bank_account_name'] ?? '' }}" placeholder="PT PPDB Pro Indonesia" required>
                    </div>
                    <div class="form-group">
                        <label>Instruksi Pembayaran</label>
                        <textarea name="payment_instructions" class="form-control" rows="4" placeholder="Tuliskan instruksi pembayaran yang akan ditampilkan ke sekolah...">{{ $settings['payment_instructions'] ?? '' }}</textarea>
                        <small class="text-muted">Instruksi ini akan ditampilkan di halaman invoice sekolah.</small>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold mb-3"><i class="fas fa-bolt mr-1 text-warning"></i> Payment Gateway (Opsional)</h6>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="enableGateway" name="enable_gateway" value="1" {{ ($settings['enable_gateway'] ?? '0') == '1' ? 'checked' : '' }} onchange="document.getElementById('gatewayConfig').style.display = this.checked ? 'block' : 'none'">
                        <label class="custom-control-label" for="enableGateway">Aktifkan Payment Gateway</label>
                    </div>

                    <div id="gatewayConfig" style="display: {{ ($settings['enable_gateway'] ?? '0') == '1' ? 'block' : 'none' }};">
                        <div class="card bg-light border-0 p-3 mb-3" style="border-radius: 12px;">
                            <div class="form-group mb-3">
                                <label>Provider Gateway</label>
                                <select name="gateway_provider" class="form-control">
                                    <option value="midtrans" {{ ($settings['gateway_provider'] ?? '') == 'midtrans' ? 'selected' : '' }}>Midtrans</option>
                                    <option value="xendit" {{ ($settings['gateway_provider'] ?? '') == 'xendit' ? 'selected' : '' }}>Xendit</option>
                                    <option value="tripay" {{ ($settings['gateway_provider'] ?? '') == 'tripay' ? 'selected' : '' }}>Tripay</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Server Key / API Key</label>
                                        <input type="text" name="gateway_server_key" class="form-control" value="{{ $settings['gateway_server_key'] ?? '' }}" placeholder="SB-Mid-server-xxxxx">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Client Key / Public Key</label>
                                        <input type="text" name="gateway_client_key" class="form-control" value="{{ $settings['gateway_client_key'] ?? '' }}" placeholder="SB-Mid-client-xxxxx">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Mode</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="modeSandbox" name="gateway_mode" value="sandbox" {{ ($settings['gateway_mode'] ?? 'sandbox') == 'sandbox' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="modeSandbox">🧪 Sandbox (Testing)</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="modeProduction" name="gateway_mode" value="production" {{ ($settings['gateway_mode'] ?? '') == 'production' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="modeProduction">🚀 Production (Live)</label>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning border-0">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <small><strong>Penting:</strong> Pastikan API Key sudah benar sebelum mengaktifkan mode Production. Transaksi di mode Sandbox tidak akan menagih uang asli.</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-primary btn-block py-3 shadow-sm font-weight-bold" style="border-radius: 12px;">
                        SIMPAN PENGATURAN PEMBAYARAN
                    </button>
                    <a href="{{ route('superadmin.subscriptions.index') }}" class="btn btn-link btn-block text-muted">Kembali ke Daftar Langganan</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
