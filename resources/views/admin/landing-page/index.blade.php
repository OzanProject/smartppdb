@extends('admin.layouts.app')

@section('title', 'Desain Landing Page')
@section('header', 'Pengaturan Tampilan Halaman Depan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Desain Landing</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible shadow-sm border-0 mb-4">
                <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5 class="font-weight-bold mb-1"><i class="icon fas fa-ban mr-2"></i> Terjadi Kesalahan!</h5>
                <ul class="mb-0 pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary card-outline card-outline-tabs shadow-sm">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="landingTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="hero-tab" data-toggle="pill" href="#hero" role="tab"><i class="fas fa-desktop mr-1"></i> Hero & Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="programs-tab" data-toggle="pill" href="#programs" role="tab"><i class="fas fa-star mr-1"></i> Program Unggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="testimonials-tab" data-toggle="pill" href="#testimonials" role="tab"><i class="fas fa-comments mr-1"></i> Testimoni Alumni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="faq-tab" data-toggle="pill" href="#faq" role="tab"><i class="fas fa-question-circle mr-1"></i> FAQ</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="landingTabContent">
                    <!-- Tab Hero & Stats -->
                    <div class="tab-pane fade show active" id="hero" role="tabpanel">
                        <form action="{{ route('admin.landing-page.hero-stats') }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold mb-3 text-primary border-bottom pb-2">Bagian Hero (Pembuka)</h5>
                                    <div class="form-group">
                                        <label>Judul Utama (Hero Title)</label>
                                        <input type="text" name="hero_title" class="form-control" value="{{ $school->hero_title }}" placeholder="Contoh: Penerimaan Peserta Didik Baru">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Singkat</label>
                                        <textarea name="hero_description" class="form-control" rows="4" placeholder="Ceritakan sedikit tentang sekolah Anda...">{{ $school->hero_description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar Latar Hero (Background)</label>
                                        <div class="custom-file">
                                            <input type="file" name="hero_image" class="custom-file-input" id="heroImageInput">
                                            <label class="custom-file-label" for="heroImageInput">Pilih gambar background...</label>
                                        </div>
                                        <small class="text-muted">Rekomendasi: 1920x1080px. Kosongkan untuk menggunakan gambar default.</small>
                                        @if($school->hero_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $school->hero_image) }}" class="img-thumbnail" style="height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold mb-3 text-primary border-bottom pb-2">Bagian Statistik (Angka)</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Statistik 1 (Label)</label>
                                                <input type="text" name="stats_acc_label" class="form-control" value="{{ $school->stats_acc_label }}" placeholder="E.g. Akreditasi">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Statistik 1 (Nilai)</label>
                                                <input type="text" name="stats_acc_value" class="form-control" value="{{ $school->stats_acc_value }}" placeholder="E.g. A">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Statistik 2 (Label)</label>
                                                <input type="text" name="stats_count_label" class="form-control" value="{{ $school->stats_count_label }}" placeholder="E.g. Siswa Baru">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Statistik 2 (Nilai)</label>
                                                <input type="text" name="stats_count_value" class="form-control" value="{{ $school->stats_count_value }}" placeholder="E.g. 500+">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Statistik 3 (Label)</label>
                                                <input type="text" name="stats_grad_label" class="form-control" value="{{ $school->stats_grad_label }}" placeholder="E.g. Lulusan Terbaik">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Statistik 3 (Nilai)</label>
                                                <input type="text" name="stats_grad_value" class="form-control" value="{{ $school->stats_grad_value }}" placeholder="E.g. 100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary px-5 shadow-sm font-weight-bold">Simpan Perubahan Hero & Statistik</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab Program Unggulan -->
                    <div class="tab-pane fade" id="programs" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold text-primary mb-0">Daftar Program / Keunggulan</h5>
                            <button class="btn btn-sm btn-primary px-3 shadow-none" data-toggle="modal" data-target="#modalAddProgram">
                                <i class="fas fa-plus mr-1"></i> Tambah Program
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-valign-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">Ikon</th>
                                        <th>Nama Program</th>
                                        <th>Deskripsi Singkat</th>
                                        <th style="width: 100px" class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($programs as $program)
                                        <tr>
                                            <td>
                                                @if($program->image)
                                                    <img src="{{ asset('storage/' . $program->image) }}" alt="Icon" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="font-weight-bold">{{ $program->title }}</td>
                                            <td class="text-muted small">{{ \Illuminate\Support\Str::limit($program->content, 100) }}</td>
                                            <td class="text-right">
                                                <button class="btn btn-xs btn-outline-warning" data-toggle="modal" data-target="#modalEditContent{{ $program->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.landing-page.contents.destroy', $program) }}" method="POST" class="d-inline ml-1">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-outline-danger" onclick="return confirm('Hapus program ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">Belum ada program unggulan ditambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Testimonials -->
                    <div class="tab-pane fade" id="testimonials" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold text-primary mb-0">Testimoni Alumni / Siswa</h5>
                            <button class="btn btn-sm btn-primary px-3 shadow-none" data-toggle="modal" data-target="#modalAddTestimonial">
                                <i class="fas fa-plus mr-1"></i> Tambah Testimoni
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-valign-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">Foto</th>
                                        <th>Nama Alumni</th>
                                        <th>Role / Angkatan</th>
                                        <th>Pesan / Quote</th>
                                        <th style="width: 100px" class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($testimonials as $testi)
                                        <tr>
                                            <td>
                                                @if($testi->image)
                                                    <img src="{{ asset('storage/' . $testi->image) }}" alt="Foto" class="img-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center border rounded-circle" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="font-weight-bold">{{ $testi->title }}</td>
                                            <td><span class="badge badge-light border">{{ $testi->subtitle }}</span></td>
                                            <td class="text-muted small italic">"{{ \Illuminate\Support\Str::limit($testi->content, 100) }}"</td>
                                            <td class="text-right">
                                                <button class="btn btn-xs btn-outline-warning" data-toggle="modal" data-target="#modalEditContent{{ $testi->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.landing-page.contents.destroy', $testi) }}" method="POST" class="d-inline ml-1">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-outline-danger" onclick="return confirm('Hapus testimoni ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Belum ada testimoni ditambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab FAQ -->
                    <div class="tab-pane fade" id="faq" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-weight-bold text-primary mb-0">Pertanyaan yang Sering Diajukan (FAQ)</h5>
                            <button class="btn btn-sm btn-primary px-3 shadow-none" data-toggle="modal" data-target="#modalAddFaq">
                                <i class="fas fa-plus mr-1"></i> Tambah FAQ
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                        <th style="width: 100px" class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($faqs as $faq)
                                        <tr>
                                            <td class="font-weight-bold">{{ $faq->title }}</td>
                                            <td class="text-muted small">{{ \Illuminate\Support\Str::limit($faq->content, 150) }}</td>
                                            <td class="text-right">
                                                <button class="btn btn-xs btn-outline-warning" data-toggle="modal" data-target="#modalEditContent{{ $faq->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.landing-page.contents.destroy', $faq) }}" method="POST" class="d-inline ml-1">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-outline-danger" onclick="return confirm('Hapus FAQ ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted">Belum ada FAQ ditambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals Add --}}
@include('admin.landing-page.partials.modal-add', ['type' => 'program', 'id' => 'modalAddProgram', 'title' => 'Tambah Program Unggulan', 'imageLabel' => 'Ikon Program'])
@include('admin.landing-page.partials.modal-add', ['type' => 'testimonial', 'id' => 'modalAddTestimonial', 'title' => 'Tambah Testimoni Alumni', 'imageLabel' => 'Foto Alumni', 'subtitleLabel' => 'Role / Angkatan'])
@include('admin.landing-page.partials.modal-add', ['type' => 'faq', 'id' => 'modalAddFaq', 'title' => 'Tambah FAQ', 'hideImage' => true])

{{-- Modals Edit --}}
@foreach($programs as $program)
    @include('admin.landing-page.partials.modal-edit', ['content' => $program])
@endforeach
@foreach($testimonials as $testi)
    @include('admin.landing-page.partials.modal-edit', ['content' => $testi])
@endforeach
@foreach($faqs as $faq)
    @include('admin.landing-page.partials.modal-edit', ['content' => $faq])
@endforeach

@endsection

@push('styles')
<style>
    .nav-tabs .nav-link.active { border-top: 3px solid #007bff !important; }
    .img-circle { border-radius: 50% !important; }
    .table-valign-middle td { vertical-align: middle !important; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // 1. Retain active tab on page reload
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeLandingTab', $(e.target).attr('href'));
        });

        let activeTab = localStorage.getItem('activeLandingTab');
        if (activeTab) {
            $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
        }

        // 2. Track changes in Hero form to prevent accidental data loss
        let heroFormChanged = false;
        $('#hero form input, #hero form textarea').on('change input', function() {
            heroFormChanged = true;
        });

        $('#hero form').on('submit', function() {
            heroFormChanged = false;
        });

        // Warn before switching tabs if Hero form is unsaved
        $('a[data-toggle="pill"]').on('hide.bs.tab', function (e) {
            if ($(e.target).attr('href') === '#hero' && heroFormChanged) {
                if (!confirm('Anda memiliki perubahan di "Hero & Statistik" yang belum disimpan. Yakin ingin pindah tab tanpa menyimpan?')) {
                    e.preventDefault();
                }
            }
        });
    });
</script>
@endpush
