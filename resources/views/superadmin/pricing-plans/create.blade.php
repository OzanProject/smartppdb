@extends('superadmin.layouts.app')

@section('title', 'Tambah Paket')
@section('header', 'Buat Paket Harga Baru')

@section('content')
<div class="row">
    {{-- Form Column --}}
    <div class="col-md-8">
        <div class="card card-outline card-orange shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.pricing-plans.store') }}" method="POST">
                @csrf
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-tags mr-2 text-orange"></i> Detail Paket Baru</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Paket <span class="text-danger">*</span></label>
                                <input type="text" id="input-name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Starter, Pro, Enterprise" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Urutan Tampil <span class="text-danger">*</span></label>
                                <input type="number" name="order_weight" class="form-control" value="{{ old('order_weight', 0) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Display (Teks) <span class="text-danger">*</span></label>
                                <input type="text" id="input-price-display" name="price_display" class="form-control @error('price_display') is-invalid @enderror" value="{{ old('price_display') }}" placeholder="Contoh: Rp 299.000" required>
                                <small class="text-muted">Muncul di landing page dan panel sekolah.</small>
                                @error('price_display') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Asli (Angka) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text font-weight-bold">Rp</span>
                                    </div>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" required>
                                </div>
                                <small class="text-muted">Digunakan untuk perhitungan pembayaran invoice.</small>
                                @error('price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Siklus Tagihan <span class="text-danger">*</span></label>
                                <select name="billing_cycle" id="input-cycle" class="form-control" required>
                                    <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                                    <option value="custom" {{ old('billing_cycle') == 'custom' ? 'selected' : '' }}>Sekali Bayar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Trial (Hari) <span class="text-danger">*</span></label>
                                <input type="number" name="trial_days" class="form-control @error('trial_days') is-invalid @enderror" value="{{ old('trial_days', 0) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Teks Tombol CTA <span class="text-danger">*</span></label>
                                <input type="text" id="input-cta" name="cta_text" class="form-control" value="{{ old('cta_text', 'Pilih Paket Ini') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Slogan / Deskripsi Singkat</label>
                                <input type="text" id="input-desc" name="description" class="form-control" value="{{ old('description') }}" placeholder="Contoh: Cocok untuk sekolah skala kecil">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Limit Pendaftar (Kuota) <span class="text-danger">*</span></label>
                                <input type="number" name="max_quota" class="form-control" value="{{ old('max_quota', -1) }}" required>
                                <small class="text-muted">Isi -1 untuk Unlimited.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Daftar Fitur (Satu baris per fitur) <span class="text-danger">*</span></label>
                        <textarea id="input-features" name="features" class="form-control @error('features') is-invalid @enderror" rows="6" placeholder="Contoh:
Max 100 Pendaftar
Dashboard Standar
Export Excel" required>{{ old('features') }}</textarea>
                        @error('features') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <small class="text-muted">Gunakan baris baru (Enter) untuk memisahkan antar fitur.</small>
                    </div>

                    <div class="form-group mt-4 mb-4">
                        <label>Hak Akses Modul Sidebar (Untuk Sekolah)</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="moduleMaster" name="allowed_modules[]" value="master_data" checked>
                                    <label for="moduleMaster" class="custom-control-label">Data Master</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="modulePendaftaran" name="allowed_modules[]" value="pendaftaran" checked>
                                    <label for="modulePendaftaran" class="custom-control-label">Data Pendaftaran</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="modulePengaturan" name="allowed_modules[]" value="pengaturan" checked>
                                    <label for="modulePengaturan" class="custom-control-label">Pengaturan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Link Tombol CTA <span class="text-danger">*</span></label>
                                <input type="text" name="cta_link" class="form-control" value="{{ old('cta_link', '/register') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="isPopular" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label for="isPopular" class="custom-control-label font-weight-bold">Tandai sebagai "Terlaris / Populer"</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-orange btn-block py-3 shadow-sm font-weight-bold text-white" style="border-radius: 12px; background-color: #f97316;">
                        SIMPAN PAKET HARGA
                    </button>
                    <a href="{{ route('superadmin.pricing-plans.index') }}" class="btn btn-link btn-block text-muted">Batal & Kembali</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Live Preview Column --}}
    <div class="col-md-4">
        <h6 class="font-weight-bold text-muted mb-3 text-uppercase" style="letter-spacing: 1px;">Live Preview (Tampilan Admin Sekolah)</h6>
        <div class="card shadow border-0" id="preview-card" style="border-radius: 15px; position: relative;">
            <div id="preview-ribbon-wrapper" class="ribbon-wrapper ribbon-lg d-none">
                <div class="ribbon bg-primary text-white">Populer</div>
            </div>
            <div class="card-body p-4">
                <h5 class="font-weight-bold" id="preview-name">Nama Paket</h5>
                <h3 class="text-primary font-weight-bold my-3">
                    <span id="preview-price-display">Rp 0</span> 
                    <small class="text-muted font-weight-normal" id="preview-cycle" style="font-size: 14px;">/tahun</small>
                </h3>
                <p class="text-muted" id="preview-desc">Deskripsi paket akan tampil disini.</p>
                <hr>
                <ul class="list-unstyled mb-4" id="preview-features">
                    <li class="mb-2 text-muted"><i class="fas fa-check-circle text-success mr-2"></i>Fitur 1</li>
                    <li class="mb-2 text-muted"><i class="fas fa-check-circle text-success mr-2"></i>Fitur 2</li>
                    <li class="mb-2 text-muted"><i class="fas fa-check-circle text-success mr-2"></i>Fitur 3</li>
                </ul>
                <button class="btn btn-primary btn-block font-weight-bold" style="border-radius: 10px;">
                    <i class="fas fa-shopping-cart mr-1"></i> <span id="preview-cta">Pilih Paket Ini</span>
                </button>
            </div>
        </div>
        <div class="alert alert-info mt-3" style="border-radius: 12px;">
            <i class="fas fa-info-circle mr-2"></i> Ini adalah simulasi tampilan yang akan dilihat oleh Admin Sekolah di menu <strong>Langganan & Paket</strong>.
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = {
        name: document.getElementById('input-name'),
        priceDisplay: document.getElementById('input-price-display'),
        cycle: document.getElementById('input-cycle'),
        desc: document.getElementById('input-desc'),
        features: document.getElementById('input-features'),
        cta: document.getElementById('input-cta'),
        isPopular: document.getElementById('isPopular'),
    };

    const previews = {
        card: document.getElementById('preview-card'),
        ribbon: document.getElementById('preview-ribbon-wrapper'),
        name: document.getElementById('preview-name'),
        priceDisplay: document.getElementById('preview-price-display'),
        cycle: document.getElementById('preview-cycle'),
        desc: document.getElementById('preview-desc'),
        features: document.getElementById('preview-features'),
        cta: document.getElementById('preview-cta'),
    };

    function updatePreview() {
        previews.name.textContent = inputs.name.value || 'Nama Paket';
        previews.priceDisplay.textContent = inputs.priceDisplay.value || 'Rp 0';
        
        let cycleText = '';
        if (inputs.cycle.value === 'monthly') cycleText = '/bulan';
        else if (inputs.cycle.value === 'yearly') cycleText = '/tahun';
        previews.cycle.textContent = cycleText;

        previews.desc.textContent = inputs.desc.value || 'Deskripsi paket akan tampil disini.';
        previews.cta.textContent = inputs.cta.value || 'Pilih Paket Ini';

        // Update Features
        const featuresText = inputs.features.value;
        if (featuresText.trim() === '') {
            previews.features.innerHTML = `
                <li class="mb-2 text-muted"><i class="fas fa-check-circle text-success mr-2"></i>Fitur 1</li>
                <li class="mb-2 text-muted"><i class="fas fa-check-circle text-success mr-2"></i>Fitur 2</li>
            `;
        } else {
            const lines = featuresText.split('\n').filter(line => line.trim() !== '');
            previews.features.innerHTML = lines.map(line => 
                `<li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>${line.trim()}</li>`
            ).join('');
        }

        // Update Popular Status
        if (inputs.isPopular.checked) {
            previews.ribbon.classList.remove('d-none');
            previews.card.style.border = '2px solid #007bff';
        } else {
            previews.ribbon.classList.add('d-none');
            previews.card.style.border = 'none';
        }
    }

    // Attach listeners
    Object.values(inputs).forEach(input => {
        if (input.type === 'checkbox') {
            input.addEventListener('change', updatePreview);
        } else {
            input.addEventListener('input', updatePreview);
        }
    });

    // Initial render
    updatePreview();
});
</script>
@endpush
@endsection
