@php
    $role = auth()->user()->role;
    $layout = match($role) {
        'superadmin' => 'superadmin.layouts.app',
        'admin_school' => 'admin.layouts.app',
        default => 'applicant.layouts.app',
    };
    $dashboardRoute = match($role) {
        'superadmin' => route('superadmin.dashboard'),
        'admin_school' => route('admin.dashboard'),
        default => route('applicant.dashboard'),
    };
@endphp

@extends($layout)

@section('title', 'Profil Akun')
@section('header', 'Pengaturan Profil')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ $dashboardRoute }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
<div class="row">
    {{-- Left Column --}}
    <div class="col-lg-4">
        {{-- Profile Card --}}
        <div class="premium-card mb-4 text-center" style="border-top: 4px solid #4facfe !important;">
            <div class="card-body p-4">
                <div class="position-relative d-inline-block mb-3">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle elevation-2" alt="Avatar" style="width: 110px; height: 110px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;">
                    @else
                        <div class="img-circle elevation-2 bg-gradient-primary d-flex align-items-center justify-content-center text-white mx-auto" style="width: 110px; height: 110px; font-size: 36px; font-weight: 800; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h5 class="font-weight-bold mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted text-sm mb-2">{{ auth()->user()->email }}</p>
                @php
                    $roleLabel = match(auth()->user()->role) {
                        'superadmin' => 'Super Admin',
                        'admin_school' => 'Admin Sekolah',
                        'staff' => 'Staff',
                        'applicant' => 'Calon Siswa',
                        default => auth()->user()->role,
                    };
                    $roleColor = match(auth()->user()->role) {
                        'superadmin' => 'danger',
                        'admin_school' => 'primary',
                        'staff' => 'info',
                        'applicant' => 'success',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge badge-{{ $roleColor }} px-3 py-1">{{ $roleLabel }}</span>
            </div>
        </div>

        {{-- Account Info --}}
        <div class="premium-card mb-4" style="border-top: 4px solid #a78bfa !important;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-info-circle mr-2 text-purple"></i> Informasi Akun</h6>
            </div>
            <div class="card-body px-4 pb-4 pt-3">
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Role Akun</small>
                    <span class="font-weight-bold">{{ $roleLabel }}</span>
                </div>
                @if(auth()->user()->school)
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Sekolah</small>
                    <span class="font-weight-bold">{{ auth()->user()->school->name }}</span>
                </div>
                @endif
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Bergabung Sejak</small>
                    <span class="font-weight-bold">{{ auth()->user()->created_at->format('d F Y') }}</span>
                </div>
                <div>
                    <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Update Terakhir</small>
                    <span class="font-weight-bold">{{ auth()->user()->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-lg-8">
        {{-- Update Profile --}}
        <div class="premium-card mb-4" style="border-top: 4px solid #4facfe !important;">
            <div class="card-header bg-transparent border-0 py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 42px; height: 42px; border-radius: 12px;">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Informasi Profil</h5>
                        <small class="text-muted">Perbarui nama, email, dan foto profil Anda</small>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('profile.update', ['role' => auth()->user()->role]) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card-body bg-transparent px-4 pb-4 pt-0">
                    <div class="d-flex align-items-center mb-4 p-3 rounded-lg" style="background: #f8fafc; border: 1px dashed #e2e8f0;">
                        <div class="mr-3 flex-shrink-0 position-relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle" alt="Avatar" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e2e8f0;" id="avatarPreview">
                            @else
                                <div class="img-circle bg-gradient-primary d-flex align-items-center justify-content-center text-white" style="width: 60px; height: 60px; font-size: 22px; font-weight: 700;" id="avatarPlaceholder">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <label for="avatar" class="btn btn-sm btn-outline-primary mb-0 mr-2" style="border-radius: 8px; cursor: pointer;">
                                <i class="fas fa-camera mr-1"></i> Ganti Foto
                            </label>
                            <input type="file" name="avatar" id="avatar" class="d-none" accept="image/jpeg,image/png,image/jpg" onchange="previewAvatar(this)">
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.7rem;">Format: JPG, PNG. Maks 2MB</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="name" class="premium-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control premium-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="invalid-feedback d-block font-weight-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="email" class="premium-label">Alamat Email</label>
                                <input type="email" name="email" id="email" class="form-control premium-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="invalid-feedback d-block font-weight-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-4 py-3 text-right">
                    <button type="submit" class="btn premium-btn text-white px-5 py-2 shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="premium-card mb-4" style="border-top: 4px solid #f59e0b !important;">
            <div class="card-header bg-transparent border-0 py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-warning text-white d-inline-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 42px; height: 42px; border-radius: 12px;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Ubah Password</h5>
                        <small class="text-muted">Pastikan menggunakan password yang kuat dan unik</small>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('profile.password', ['role' => auth()->user()->role]) }}">
                @csrf
                <div class="card-body bg-transparent px-4 pb-4 pt-0">
                    <div class="form-group mb-4">
                        <label class="premium-label">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control premium-input @error('current_password') is-invalid @enderror" placeholder="Masukkan password saat ini">
                            @error('current_password') <span class="invalid-feedback d-block font-weight-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="premium-label">Password Baru</label>
                                <input type="password" name="password" class="form-control premium-input @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                                @error('password') <span class="invalid-feedback d-block font-weight-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="premium-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control premium-input" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-4 py-3 text-right">
                    <button type="submit" class="btn btn-warning text-white px-5 py-2 shadow-sm font-weight-bold" style="border-radius: 12px;">
                        <i class="fas fa-key mr-1"></i> Perbarui Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        @if(auth()->user()->role === 'applicant')
        <div class="premium-card mb-4" style="border-top: 4px solid #ef4444 !important;">
            <div class="card-header bg-transparent border-0 py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-danger text-white d-inline-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 42px; height: 42px; border-radius: 12px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Zona Bahaya</h5>
                        <small class="text-muted">Tindakan ini bersifat permanen dan tidak dapat dibatalkan</small>
                    </div>
                </div>
            </div>
            <div class="card-body bg-transparent px-4 pb-4 pt-0">
                <div class="p-3 rounded-lg" style="background: #fef2f2; border: 1px solid #fecaca;">
                    <p class="text-sm text-dark mb-3">Menghapus akun akan menghapus <strong>semua data pendaftaran</strong> dan dokumen Anda secara permanen.</p>
                    <button type="button" class="btn btn-danger font-weight-bold shadow-sm" style="border-radius: 12px;" data-toggle="modal" data-target="#modal-delete-account">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus Akun Saya
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="modal-delete-account">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form method="post" action="{{ route('profile.destroy', ['role' => auth()->user()->role]) }}">
                @csrf
                @method('delete')
                <div class="modal-header bg-danger border-0" style="border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title text-white font-weight-bold"><i class="fas fa-exclamation-circle mr-2"></i> Konfirmasi Penghapusan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-dark mb-4">Apakah Anda yakin? Masukkan password untuk mengonfirmasi.</p>
                    <div class="form-group">
                        <label class="premium-label">Password Anda</label>
                        <input type="password" name="password" class="form-control premium-input" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 justify-content-between" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-light font-weight-bold shadow-sm px-4" data-dismiss="modal" style="border-radius: 12px;">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold shadow-sm px-4" style="border-radius: 12px;">Ya, Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Base Typography Updates */
    body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
    
    /* Premium Cards */
    .premium-card {
        background: #ffffff;
        border: none !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0,0,0,0.02) !important;
        transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .premium-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0,0,0,0.03) !important;
    }

    /* Input & Label Styling */
    .premium-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #718096;
        display: block;
        margin-bottom: 8px;
    }
    
    .premium-input {
        background-color: #f8fafc !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 0.75rem 1.25rem !important;
        font-size: 0.95rem !important;
        color: #4a5568 !important;
        transition: all 0.25s ease !important;
        height: auto !important;
    }
    
    .premium-input:focus {
        background-color: #ffffff !important;
        border-color: #4facfe !important;
        box-shadow: 0 0 0 4px rgba(79, 172, 254, 0.15) !important;
    }

    /* Premium Button */
    .premium-btn {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3) !important;
        background: linear-gradient(135deg, #3dbdfc 0%, #00d2ff 100%);
    }
</style>
@endpush

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            // Find the image element or create it if it doesn't exist
            let imgContainer = input.parentElement;
            let img = imgContainer.querySelector('img');
            
            if (img) {
                img.src = e.target.result;
            } else {
                // Remove the text placeholder
                let placeholder = imgContainer.querySelector('.bg-gradient-primary');
                if (placeholder) {
                    let newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'img-circle elevation-2';
                    newImg.style.cssText = 'width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;';
                    imgContainer.insertBefore(newImg, placeholder);
                    placeholder.remove();
                }
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
