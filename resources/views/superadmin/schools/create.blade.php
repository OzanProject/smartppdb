@extends('superadmin.layouts.app')

@section('title', 'Tambah Sekolah')
@section('header', 'Tambah Sekolah Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.schools.store') }}" method="POST">
                @csrf
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-university mr-2 text-primary"></i> Data Instansi Sekolah</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="form-group">
                        <label>Nama Lengkap Sekolah <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: SMP Negeri 4 Kediri" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenjang Pendidikan <span class="text-danger">*</span></label>
                                <input type="text" name="education_level_name" class="form-control @error('education_level_name') is-invalid @enderror" value="{{ old('education_level_name', 'SMP') }}" placeholder="Contoh: SMP" required>
                                @error('education_level_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NPSN</label>
                                <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror" value="{{ old('npsn') }}" placeholder="Masukkan NPSN">
                                @error('npsn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Sekolah <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@sekolah.sch.id" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon / WhatsApp</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Contoh: 08123456789">
                                @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap sekolah">{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Zona Waktu <span class="text-danger">*</span></label>
                        <select name="timezone" class="form-control" required>
                            <option value="Asia/Jakarta" {{ old('timezone', 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                            <option value="Asia/Makassar" {{ old('timezone') == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                            <option value="Asia/Jayapura" {{ old('timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                        </select>
                        <small class="text-muted">Akan menjadi acuan waktu untuk semua aktivitas (pendaftaran, absensi) di sekolah ini.</small>
                    </div>

                    <div class="alert alert-info border-0 shadow-none bg-light mt-4" style="border-radius: 12px;">
                        <i class="fas fa-info-circle mr-2"></i> <strong>Informasi:</strong> Akun Administrator untuk sekolah ini dapat dibuat di menu <strong>Manajemen Admin</strong> setelah sekolah berhasil didaftarkan. Sekolah otomatis akan mendapatkan <strong>Free Trial Akses Penuh selama 2 hari</strong>.
                    </div>

                    <div class="form-group mt-4 p-3 bg-light rounded shadow-none border-0" style="border-radius: 12px;">
                        <label>Pilih Paket Harga (Opsional, berlaku setelah masa Trial habis)</label>
                        <select name="pricing_plan_id" class="form-control">
                            <option value="">-- Pilih Paket Harga --</option>
                            @foreach($pricingPlans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->price_display }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-primary btn-block py-3 shadow-sm font-weight-bold" style="border-radius: 12px;">
                        DAFTARKAN SEKOLAH SEKARANG
                    </button>
                    <a href="{{ route('superadmin.schools.index') }}" class="btn btn-link btn-block text-muted">Batal & Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
