@extends('superadmin.layouts.app')

@section('title', 'Buat Akun Admin')
@section('header', 'Tambah Akun Admin/Staff Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-outline card-success shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.admin-users.store') }}" method="POST">
                @csrf
                <div class="card-header bg-transparent border-0 pt-4 px-4 text-center">
                    <div class="bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; border-radius: 20px;">
                        <i class="fas fa-user-shield fa-2x text-success"></i>
                    </div>
                    <h3 class="card-title d-block w-100 font-weight-bold">Informasi Akun Baru</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Email Utama <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@example.com" required>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="admin_school" {{ old('role') == 'admin_school' ? 'selected' : '' }}>Admin Sekolah (Full)</option>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff / Panitia (Terbatas)</option>
                                </select>
                                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Assign ke Sekolah <span class="text-danger">*</span></label>
                                <select name="school_id" class="form-control @error('school_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Sekolah --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 karakter" required>
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-success btn-block py-3 shadow-sm font-weight-bold" style="border-radius: 12px;">
                        SIMPAN & AKTIFKAN AKUN
                    </button>
                    <a href="{{ route('superadmin.admin-users.index') }}" class="btn btn-link btn-block text-muted">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
