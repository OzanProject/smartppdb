@extends('admin.layouts.app')

@section('title', 'Pengaturan Sekolah')
@section('header', 'Profil & Konfigurasi Instansi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('admin.school.update') }}" method="POST" enctype="multipart/form-data" id="school-form">
            @csrf
            @method('PATCH')
            
            <!-- Identitas Card -->
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-university mr-2 text-primary"></i> Identitas Sekolah
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-sm text-secondary">Nama Resmi Sekolah</label>
                                <input type="text" name="name" id="school_name_input" class="form-control form-control-lg border-primary-soft @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $school->name) }}" placeholder="Contoh: SMA Negeri 1 Perdana" required>
                                @error('name') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sm text-secondary">Slug / Identitas URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light text-muted">{{ request()->getSchemeAndHttpHost() }}/</span>
                                    </div>
                                    <input type="text" name="slug" id="school_slug_input" class="form-control @error('slug') is-invalid @enderror" 
                                           value="{{ old('slug', $school->slug) }}" required>
                                    @error('slug') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sm text-secondary">NPSN</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                    </div>
                                    <input type="text" name="npsn" class="form-control" value="{{ old('npsn', $school->npsn) }}" placeholder="Nomor Pokok Sekolah Nasional">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-sm text-secondary">Jenjang Pendidikan</label>
                                <input type="text" name="education_level_name" class="form-control" 
                                       value="{{ old('education_level_name', $school->education_level_name) }}" placeholder="Contoh: Sekolah Menengah Atas (SMA)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak Card -->
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-address-book mr-2 text-info"></i> Informasi Kontak & Alamat
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sm text-secondary">Email Instansi</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $school->email) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sm text-secondary">No. Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-whatsapp font-weight-bold"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $school->phone) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-sm text-secondary">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Tuliskan alamat lengkap instansi...">{{ old('address', $school->address) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-sm text-secondary">Zona Waktu (Timezone) <span class="text-danger">*</span></label>
                                <select name="timezone" class="form-control" required>
                                    <option value="Asia/Jakarta" {{ old('timezone', $school->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                                    <option value="Asia/Makassar" {{ old('timezone', $school->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                                    <option value="Asia/Jayapura" {{ old('timezone', $school->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                                </select>
                                <small class="text-muted">Acuan waktu untuk sistem sekolah Anda.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-right">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>

            <input type="hidden" name="is_custom_level" value="{{ $school->is_custom_level ? '1' : '0' }}">
            <input type="hidden" name="is_registration_open" id="reg_open_hidden" value="{{ $school->is_registration_open ? '1' : '0' }}">
        </form>

        <!-- Testimonial Card -->
        <div class="card card-outline card-warning shadow-sm mt-4">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-star mr-2 text-warning"></i> Apa Kata Anda tentang Platform Kami?
                </h3>
            </div>
            <form action="{{ route('admin.school.testimonial.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <p class="text-sm text-muted mb-4">Bagikan pengalaman Anda menggunakan PPDB PRO. Testimoni Anda akan ditampilkan di halaman depan utama platform.</p>
                    
                    <div class="form-group">
                        <label class="text-sm text-secondary">Rating Kepuasan</label>
                        <div class="rating-css">
                            <div class="star-icon">
                                @for($i=1; $i<=5; $i++)
                                    <input type="radio" value="{{ $i }}" name="rating" id="rating{{ $i }}" {{ ($testimonial && $testimonial->rating == $i) || (!$testimonial && $i == 5) ? 'checked' : '' }}>
                                    <label for="rating{{ $i }}" class="fas fa-star"></label>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-sm text-secondary">Isi Testimoni</label>
                        <textarea name="content" rows="4" class="form-control @error('content') is-invalid @enderror" 
                                    placeholder="Contoh: Platform ini sangat memudahkan proses pendaftaran di sekolah kami, sangat user-friendly!">{{ old('content', $testimonial->content ?? '') }}</textarea>
                        @error('content') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                        <small class="text-muted mt-2 d-block italic">Minimal 20 karakter, maksimal 500 karakter.</small>
                    </div>

                    @if($testimonial && $testimonial->is_published)
                        <div class="alert alert-success py-2 px-3 text-sm mb-0">
                            <i class="fas fa-check-circle mr-1"></i> Testimoni Anda sedang ditampilkan di halaman utama.
                        </div>
                    @elseif($testimonial)
                        <div class="alert alert-info py-2 px-3 text-sm mb-0">
                            <i class="fas fa-clock mr-1"></i> Testimoni Anda sudah tersimpan dan akan segera dipublikasikan.
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light text-right">
                    <button type="submit" class="btn btn-warning px-4 font-weight-bold">
                        <i class="fas fa-paper-plane mr-1"></i> Simpan Testimoni
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Logo Card -->
        <div class="card card-outline card-secondary shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-image mr-2"></i> Logo Sekolah</h3>
            </div>
            <div class="card-body text-center">
                <div class="logo-preview-container mb-4">
                    @if($school->logo)
                        <img src="{{ asset('storage/' . $school->logo) }}" id="logo-preview" class="img-thumbnail shadow-sm p-3" style="max-height: 180px; width: auto; border: 2px dashed #dee2e6;">
                    @else
                        <div id="logo-placeholder" class="d-flex align-items-center justify-content-center bg-light rounded shadow-inner mx-auto" style="height: 180px; width: 180px; border: 2px dashed #dee2e6;">
                            <div class="text-muted">
                                <i class="fas fa-university fa-4x mb-2 opacity-25"></i>
                                <p class="mb-0 small">Belum ada logo</p>
                            </div>
                        </div>
                        <img src="" id="logo-preview" class="img-thumbnail shadow-sm p-3 d-none" style="max-height: 180px; width: auto; border: 2px dashed #dee2e6;">
                    @endif
                </div>

                <div class="form-group mb-0 text-left">
                    <label class="text-xs text-uppercase tracking-wider text-muted font-weight-bold mb-2">Ganti Logo Baru</label>
                    <div class="custom-file">
                        <input type="file" form="school-form" name="logo" class="custom-file-input" id="logo-input" accept="image/*">
                        <label class="custom-file-label" for="logo-input">Pilih file...</label>
                    </div>
                    <p class="text-xs text-muted mt-2 mb-0 italic">Format: JPG, PNG, WebP (Max 2MB)</p>
                </div>

                @if($school->logo)
                    <button type="button" class="btn btn-outline-danger btn-sm btn-block mt-3" onclick="confirmDeleteLogo()">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus Logo Saat Ini
                    </button>
                @endif
            </div>
        </div>

        <div class="card {{ $school->is_registration_open ? 'card-success' : 'card-danger' }} shadow-sm transition-all" id="status-card">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-toggle-on mr-2"></i> Kontrol Registrasi
                </h3>
            </div>
            <div class="card-body text-center p-4">
                <div class="status-indicator">
                    <div class="h5 text-muted mb-1 text-uppercase tracking-widest">Status Saat Ini</div>
                    <div class="display-4 font-weight-bold {{ $school->is_registration_open ? 'text-success' : 'text-danger' }} py-3" id="status-text" style="text-shadow: 0 1px 2px rgba(0,0,0,0.05)">
                        {{ $school->is_registration_open ? 'OPEN' : 'CLOSED' }}
                    </div>
                </div>
                
                <hr class="my-4">

                <div class="custom-control custom-switch custom-switch-xl">
                    <input type="checkbox" class="custom-control-input" id="reg_open_toggle" {{ $school->is_registration_open ? 'checked' : '' }}>
                    <label class="custom-control-label text-secondary cursor-pointer" for="reg_open_toggle">Ubah Status Pendaftaran</label>
                </div>
            </div>
            @if($school->slug)
                <div class="card-footer bg-light p-0">
                    <a href="{{ url($school->slug) }}" target="_blank" class="btn btn-link btn-block text-info">
                        <i class="fas fa-external-link-alt mr-1"></i> Lihat Halaman Publik
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<form id="delete-logo-form" action="{{ route('admin.school.logo.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .border-primary-soft { border-color: #3f6791; border-width: 1px; }
    .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
    .transition-all { transition: all 0.3s ease; }
    
    /* Custom Switch XL */
    .custom-switch-xl .custom-control-label::before {
        height: 1.75rem;
        width: 3rem;
        border-radius: 2rem;
    }
    .custom-switch-xl .custom-control-label::after {
        width: calc(1.75rem - 4px);
        height: calc(1.75rem - 4px);
        border-radius: 2rem;
    }
    .custom-switch-xl .custom-control-input:checked ~ .custom-control-label::after {
        transform: translateX(1.25rem);
    }
    .custom-control-label { padding-top: 2px; }
    .cursor-pointer { cursor: pointer; }

    /* Rating Stars */
    .rating-css div {
        color: #ffe400;
        font-size: 30px;
        font-family: sans-serif;
        font-weight: 800;
        text-align: left;
        text-transform: uppercase;
        padding: 5px 0;
    }
    .rating-css input {
        display: none;
    }
    .rating-css input + label {
        text-shadow: 1px 1px 0 #8f8420;
        cursor: pointer;
    }
    .rating-css input:checked ~ label {
        color: #b4afaf;
    }
    .rating-css label:active {
        transform: scale(0.8);
        transition: 0.3s ease;
    }
    .star-icon {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .star-icon input:checked ~ label {
        color: #ffe400;
    }
    .star-icon label {
        color: #ccc;
        margin-right: 5px;
    }
    .star-icon label:hover,
    .star-icon label:hover ~ label {
        color: #ffe400;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function() {
        // Auto-generate slug from name
        $('#school_name_input').on('input', function() {
            let name = $(this).val();
            let slug = name.toLowerCase()
                .replace(/[^\w ]+/g, '') // Remove non-alphanumeric except space
                .replace(/ +/g, '-')     // Replace spaces with -
                .replace(/^-+|-+$/g, ''); // Trim leading/trailing hyphens
            
            $('#school_slug_input').val(slug);
        });

        // Handle file preview
        $('#logo-input').on('change', function(e) {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);

            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo-placeholder').addClass('d-none');
                    $('#logo-preview').attr('src', e.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle toggle synchronization
        $('#reg_open_toggle').on('change', function() {
            const isOpen = this.checked;
            $('#reg_open_hidden').val(isOpen ? '1' : '0');
            $('#status-text').text(isOpen ? 'OPEN' : 'CLOSED');
            
            const card = $('#status-card');
            const text = $('#status-text');
            if (isOpen) {
                card.removeClass('card-danger').addClass('card-success');
                text.removeClass('text-danger').addClass('text-success');
            } else {
                card.removeClass('card-success').addClass('card-danger');
                text.removeClass('text-success').addClass('text-danger');
            }
        });
    });

    function confirmDeleteLogo() {
        Swal.fire({
            title: 'Hapus Logo?',
            text: "Logo akan dikembalikan ke default sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-logo-form').submit();
            }
        })
    }
</script>
@endpush
