@extends('superadmin.layouts.app')

@section('title', 'Edit Sekolah')
@section('header', 'Edit Data Sekolah')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-warning shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.schools.update', $school->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-2 text-warning"></i> Profil Sekolah: {{ $school->name }}</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="form-group">
                        <label>Nama Lengkap Sekolah <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $school->name) }}" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <small class="text-muted">Slug saat ini: <code>/{{ $school->slug }}</code> (Otomatis terupdate jika nama berubah)</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenjang Pendidikan <span class="text-danger">*</span></label>
                                <input type="text" name="education_level_name" class="form-control @error('education_level_name') is-invalid @enderror" value="{{ old('education_level_name', $school->education_level_name) }}" required>
                                @error('education_level_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NPSN</label>
                                <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror" value="{{ old('npsn', $school->npsn) }}">
                                @error('npsn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Sekolah <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $school->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon / WhatsApp</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $school->phone) }}">
                                @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $school->address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Zona Waktu <span class="text-danger">*</span></label>
                        <select name="timezone" class="form-control" required>
                            <option value="Asia/Jakarta" {{ old('timezone', $school->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                            <option value="Asia/Makassar" {{ old('timezone', $school->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                            <option value="Asia/Jayapura" {{ old('timezone', $school->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                        </select>
                        <small class="text-muted">Akan menjadi acuan waktu untuk semua aktivitas (pendaftaran, absensi) di sekolah ini.</small>
                    </div>

                    <div class="form-group mt-4 p-3 bg-light rounded shadow-none border-0" style="border-radius: 12px;">
                        <div class="custom-control custom-switch custom-switch-on-success">
                            <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="isActiveSwitch" {{ $school->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="isActiveSwitch">Status Akses Sekolah (AKTIF)</label>
                        </div>
                        <p class="small text-muted mb-0 mt-1">Jika dinonaktifkan, pendaftar tidak dapat mengakses halaman landing sekolah ini.</p>
                        
                        <hr>

                        <label class="mt-2">Pilih Paket Harga (Berlaku setelah masa Trial habis)</label>
                        <select name="pricing_plan_id" class="form-control">
                            <option value="">-- Tanpa Paket / Tidak Memilih --</option>
                            @foreach($pricingPlans as $plan)
                                <option value="{{ $plan->id }}" {{ $school->pricing_plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }} ({{ $plan->price_display }})</option>
                            @endforeach
                        </select>
                        @if($school->trial_ends_at && $school->trial_ends_at->isFuture())
                            <p class="small text-success mt-2 mb-0"><i class="fas fa-clock"></i> Free Trial Aktif hingga: {{ $school->trial_ends_at->format('d M Y H:i') }}</p>
                        @elseif($school->trial_ends_at)
                            <p class="small text-danger mt-2 mb-0"><i class="fas fa-times-circle"></i> Free Trial Berakhir pada: {{ $school->trial_ends_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-warning btn-block py-3 shadow-sm font-weight-bold" style="border-radius: 12px;">
                        SIMPAN PERUBAHAN DATA
                    </button>
                    <a href="{{ route('superadmin.schools.index') }}" class="btn btn-link btn-block text-muted">Batal & Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
