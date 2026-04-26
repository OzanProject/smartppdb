@extends('superadmin.layouts.app')

@section('title', 'Manajemen Halaman Statis')
@section('header', 'Kustomisasi Konten Halaman')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('superadmin.static-pages.update') }}" method="POST">
            @csrf
            
            <!-- API Key Settings -->
            <div class="card card-outline card-info shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-key mr-2 text-info"></i> Integrasi TinyMCE API</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="form-group mb-0">
                        <label>TinyMCE API Key</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-plug text-info"></i></span>
                            </div>
                            <input type="text" name="tinymce_api_key" class="form-control" value="{{ $tinymce_api_key }}" placeholder="Masukkan API Key dari tiny.cloud">
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Dapatkan API Key gratis di <a href="https://www.tiny.cloud/" target="_blank" class="text-info font-weight-bold">tiny.cloud</a> untuk menghilangkan peringatan "no-api-key".
                        </small>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-danger shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-file-signature mr-2 text-danger"></i> Editor Konten Halaman</h3>
                    <button type="submit" class="btn btn-danger px-4 shadow-sm" style="border-radius: 50px;">
                        <i class="fas fa-save mr-1"></i> Simpan Semua Halaman
                    </button>
                </div>
                
                <div class="card-body px-4 pb-4">
                    <div class="card card-danger card-tabs shadow-none border">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="page-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-about" data-toggle="pill" href="#content-about" role="tab"><i class="fas fa-info-circle mr-1"></i> Tentang Kami</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-privacy" data-toggle="pill" href="#content-privacy" role="tab"><i class="fas fa-user-shield mr-1"></i> Kebijakan Privasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-terms" data-toggle="pill" href="#content-terms" role="tab"><i class="fas fa-file-contract mr-1"></i> Syarat & Ketentuan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Tentang Kami -->
                                <div class="tab-pane fade show active" id="content-about" role="tabpanel">
                                    <div class="form-group">
                                        <label class="font-weight-bold mb-3">Konten Halaman Tentang Kami</label>
                                        <textarea name="page_about_content" class="rich-editor">{{ $about }}</textarea>
                                    </div>
                                </div>
                                <!-- Kebijakan Privasi -->
                                <div class="tab-pane fade" id="content-privacy" role="tabpanel">
                                    <div class="form-group">
                                        <label class="font-weight-bold mb-3">Konten Halaman Kebijakan Privasi</label>
                                        <textarea name="page_privacy_content" class="rich-editor">{{ $privacy }}</textarea>
                                    </div>
                                </div>
                                <!-- Syarat & Ketentuan -->
                                <div class="tab-pane fade" id="content-terms" role="tabpanel">
                                    <div class="form-group">
                                        <label class="font-weight-bold mb-3">Konten Halaman Syarat & Ketentuan</label>
                                        <textarea name="page_terms_content" class="rich-editor">{{ $terms }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/{{ $tinymce_api_key ?: 'no-api-key' }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.rich-editor',
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media table emoticons help',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
        height: 600,
        branding: false,
        promotion: false,
        image_advtab: true,
        image_class_list: [
            {title: 'None', value: ''},
            {title: 'Responsive', value: 'img-fluid'},
            {title: 'Rounded', value: 'rounded'}
        ],
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>
@endpush
