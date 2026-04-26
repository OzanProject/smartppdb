@extends('superadmin.layouts.app')

@section('title', 'Pengaturan Landing Page')
@section('header', 'Pengaturan Platform')

@push('styles')
<style>
    :root {
        --primary-color: #ef4444;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
    }

    .settings-container {
        display: flex;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        min-height: 700px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .settings-sidebar {
        width: 280px;
        background: var(--bg-light);
        border-right: 1px solid var(--border-color);
        padding: 20px 0;
    }

    .settings-nav-link {
        display: flex;
        align-items: center;
        padding: 12px 25px;
        color: #64748b;
        font-weight: 600;
        transition: all 0.3s;
        border-left: 4px solid transparent;
        margin-bottom: 5px;
    }

    .settings-nav-link:hover {
        background: #f1f5f9;
        color: var(--primary-color);
    }

    .settings-nav-link.active {
        background: #fff;
        color: var(--primary-color);
        border-left-color: var(--primary-color);
        box-shadow: 5px 0 15px rgba(0,0,0,0.02);
    }

    .settings-nav-link i {
        width: 24px;
        font-size: 1.1rem;
        margin-right: 12px;
    }

    .settings-content {
        flex: 1;
        padding: 40px;
        background: #fff;
    }

    .section-header {
        margin-bottom: 30px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 20px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .section-desc {
        color: #64748b;
        font-size: 0.9rem;
    }

    .form-group label {
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        display: block;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        background: #fdfdfd;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        background: #fff;
    }

    .input-group-text {
        border-radius: 12px 0 0 12px;
        background: #f1f5f9;
        border-color: var(--border-color);
        color: #64748b;
    }

    .input-group .form-control {
        border-radius: 0 12px 12px 0;
    }

    .btn-save {
        background: var(--primary-color);
        color: #fff;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        color: #fff;
    }

    .upload-preview {
        width: 80px;
        height: 80px;
        border-radius: 15px;
        object-fit: contain;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        margin-right: 15px;
    }

    .group-badge {
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 5px;
        background: #fee2e2;
        color: #ef4444;
        font-weight: 800;
        margin-left: auto;
    }
</style>
@endpush

@section('content')
<form action="{{ route('superadmin.landing-settings.update-all') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="settings-container">
        <!-- Sidebar Navigation -->
        <div class="settings-sidebar">
            <div class="px-4 mb-4">
                <h5 class="font-weight-bold text-dark m-0">Pengaturan</h5>
                <small class="text-muted">Konfigurasi Landing Page</small>
            </div>
            
            <div class="nav flex-column nav-pills" id="settings-tab" role="tablist" aria-orientation="vertical">
                @php
                    $groupedSettings = $settings->groupBy('group');
                    $firstGroup = 'Branding';
                    if (!$groupedSettings->has($firstGroup)) {
                        $firstGroup = $groupedSettings->keys()->first();
                    }
                @endphp

                @foreach($groupedSettings as $group => $items)
                    <a class="settings-nav-link {{ $group === $firstGroup ? 'active' : '' }}" 
                       id="tab-{{ Str::slug($group) }}" 
                       data-toggle="pill" 
                       href="#content-{{ Str::slug($group) }}" 
                       role="tab">
                        @if($group == 'Branding') <i class="fas fa-certificate"></i> @endif
                        @if($group == 'Contact') <i class="fas fa-headset"></i> @endif
                        @if($group == 'Social' || $group == 'Sosmed') <i class="fas fa-share-alt"></i> @endif
                        @if($group == 'Hero') <i class="fas fa-rocket"></i> @endif
                        @if($group == 'Pricing') <i class="fas fa-tags"></i> @endif
                        @if($group == 'Problem') <i class="fas fa-exclamation-triangle"></i> @endif
                        @if($group == 'Feature') <i class="fas fa-star"></i> @endif
                        @if($group == 'FAQ') <i class="fas fa-question-circle"></i> @endif
                        @if($group == 'Footer') <i class="fas fa-shoe-prints"></i> @endif
                        @if($group == 'SEO') <i class="fas fa-search"></i> @endif
                        @if($group == 'System') <i class="fas fa-cog"></i> @endif
                        
                        <span>{{ $group }}</span>
                        <span class="group-badge">{{ $items->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Content Area -->
        <div class="settings-content">
            <div class="d-flex justify-content-between align-items-start mb-4 border-bottom pb-4">
                <div>
                    <h2 class="section-title">Landing Page Settings</h2>
                    <p class="section-desc m-0">Sesuaikan branding, konten, dan konfigurasi teknis halaman depan Anda.</p>
                </div>
                <button type="submit" class="btn btn-save shadow-sm px-5">
                    <i class="fas fa-save mr-2"></i> SIMPAN PERUBAHAN
                </button>
            </div>

            <div class="tab-content" id="settings-tabContent">
                @foreach($groupedSettings as $group => $items)
                    <div class="tab-pane fade {{ $group === $firstGroup ? 'show active' : '' }}" 
                         id="content-{{ Str::slug($group) }}" 
                         role="tabpanel">
                        
                        <div class="mb-4">
                            <h4 class="font-weight-bold text-dark"><i class="fas fa-info-circle mr-2 text-primary opacity-50"></i> Kelola {{ $group }}</h4>
                        </div>

                        <div class="row">
                            @foreach($items as $setting)
                                <div class="col-md-12 mb-4">
                                    <div class="form-group mb-0">
                                        <label>{{ str_replace(['app_', '_'], ['', ' '], $setting->key) }}</label>
                                        
                                        @if($setting->key == 'app_logo')
                                            <div class="d-flex align-items-center bg-light p-3 rounded-xl border">
                                                @if($setting->value)
                                                    <img src="{{ asset('storage/' . $setting->value) }}" class="upload-preview">
                                                    <div class="custom-control custom-checkbox mr-4">
                                                        <input type="checkbox" class="custom-control-input" id="deleteLogo" name="delete_app_logo" value="1">
                                                        <label class="custom-control-label text-danger font-weight-bold" for="deleteLogo" style="text-transform: none; letter-spacing: 0;">Hapus Logo</label>
                                                    </div>
                                                @endif
                                                <div class="custom-file flex-1">
                                                    <input type="file" name="app_logo" class="custom-file-input" id="logoFile">
                                                    <label class="custom-file-label" for="logoFile">Upload Logo Baru...</label>
                                                </div>
                                            </div>

                                        @elseif($setting->key == 'app_favicon')
                                            <div class="d-flex align-items-center bg-light p-3 rounded-xl border">
                                                @if($setting->value)
                                                    <img src="{{ asset('storage/' . $setting->value) }}" class="upload-preview" style="width: 50px; height: 50px;">
                                                    <div class="custom-control custom-checkbox mr-4">
                                                        <input type="checkbox" class="custom-control-input" id="deleteFavicon" name="delete_app_favicon" value="1">
                                                        <label class="custom-control-label text-danger font-weight-bold" for="deleteFavicon" style="text-transform: none; letter-spacing: 0;">Hapus Favicon</label>
                                                    </div>
                                                @endif
                                                <div class="custom-file flex-1">
                                                    <input type="file" name="app_favicon" class="custom-file-input" id="faviconFile">
                                                    <label class="custom-file-label" for="faviconFile">Upload Favicon Baru...</label>
                                                </div>
                                            </div>

                                        @elseif($setting->key == 'seo_og_image')
                                            <div class="d-flex align-items-center bg-light p-3 rounded-xl border">
                                                @if($setting->value)
                                                    <img src="{{ asset('storage/' . $setting->value) }}" class="upload-preview" style="width: 120px; height: 60px; object-fit: cover;">
                                                    <div class="custom-control custom-checkbox mr-4">
                                                        <input type="checkbox" class="custom-control-input" id="deleteOgImage" name="delete_seo_og_image" value="1">
                                                        <label class="custom-control-label text-danger font-weight-bold" for="deleteOgImage" style="text-transform: none; letter-spacing: 0;">Hapus Gambar</label>
                                                    </div>
                                                @endif
                                                <div class="custom-file flex-1">
                                                    <input type="file" name="seo_og_image" class="custom-file-input" id="ogImageFile">
                                                    <label class="custom-file-label" for="ogImageFile">Upload Social Share Image (1200x630)...</label>
                                                </div>
                                            </div>

                                        @elseif(Str::contains($setting->key, ['content', 'description', 'address', 'quote', 'desc', 'footer_text', 'instructions']))
                                            <textarea name="settings[{{ $setting->key }}]" class="form-control" rows="4" placeholder="Masukkan {{ str_replace('_', ' ', $setting->key) }}...">{{ $setting->value }}</textarea>

                                        @elseif($setting->key == 'app_timezone')
                                            <select name="settings[{{ $setting->key }}]" class="form-control">
                                                <option value="Asia/Jakarta" {{ $setting->value == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                                                <option value="Asia/Makassar" {{ $setting->value == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                                                <option value="Asia/Jayapura" {{ $setting->value == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                                            </select>

                                        @else
                                            <div class="input-group">
                                                @if(Str::contains($setting->key, 'facebook')) <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-facebook text-primary"></i></span></div> @endif
                                                @if(Str::contains($setting->key, 'instagram')) <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-instagram text-danger"></i></span></div> @endif
                                                @if(Str::contains($setting->key, 'youtube')) <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-youtube text-red"></i></span></div> @endif
                                                @if(Str::contains($setting->key, 'phone')) <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div> @endif
                                                @if(Str::contains($setting->key, 'email')) <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div> @endif
                                                
                                                <input type="text" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}" placeholder="Masukkan {{ str_replace('_', ' ', $setting->key) }}...">
                                                
                                                @if(Str::contains($setting->key, 'phone'))
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-white text-xs"><i class="fab fa-whatsapp text-success mr-1"></i> Auto-format</span>
                                                    </div>
                                                @endif
                                            </div>
                                            @if(Str::contains($setting->key, 'phone'))
                                                <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle mr-1"></i> Contoh: 08123456789. Link WhatsApp akan diformat otomatis.</small>
                                            @endif
                                        @endif
                                        <div class="mt-2 text-right">
                                            <code class="text-[10px] opacity-50">{{ $setting->key }}</code>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Update filename in custom-file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Smooth scroll to top when changing tabs
        $('.settings-nav-link').on('shown.bs.tab', function (e) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
@endpush
