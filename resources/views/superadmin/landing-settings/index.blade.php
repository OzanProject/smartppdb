@extends('superadmin.layouts.app')

@section('title', 'Pengaturan Landing Page')
@section('header', 'Konfigurasi Halaman Depan Utama')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-danger shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('superadmin.landing-settings.update-all') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-globe mr-2 text-danger"></i> Global Branding & Landing Settings</h3>
                    <div class="card-tools">
                        <button type="submit" class="btn btn-danger px-4 shadow-sm" style="border-radius: 50px;">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <p class="text-muted mb-4">Pengaturan ini akan berdampak pada tampilan halaman depan utama, logo di dashboard sekolah, dan identitas aplikasi secara keseluruhan.</p>

                    @php
                        $groupedSettings = $settings->groupBy('group');
                        $firstGroup = 'Branding'; // Force branding as first group if exists
                        if (!$groupedSettings->has($firstGroup)) {
                            $firstGroup = $groupedSettings->keys()->first();
                        }
                    @endphp

                    <div class="card card-danger card-tabs shadow-none border">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="landing-settings-tabs" role="tablist">
                                @foreach($groupedSettings as $group => $items)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $group === $firstGroup ? 'active' : '' }}" 
                                           id="tab-{{ Str::slug($group) }}" 
                                           data-toggle="pill" 
                                           href="#content-{{ Str::slug($group) }}" 
                                           role="tab" 
                                           aria-controls="content-{{ Str::slug($group) }}" 
                                           aria-selected="{{ $group === $firstGroup ? 'true' : 'false' }}">
                                            @if($group == 'Branding') <i class="fas fa-certificate mr-1"></i> @endif
                                            @if($group == 'Contact') <i class="fas fa-headset mr-1"></i> @endif
                                            @if($group == 'Social') <i class="fas fa-share-alt mr-1"></i> @endif
                                            @if($group == 'Hero') <i class="fas fa-rocket mr-1"></i> @endif
                                            @if($group == 'Pricing') <i class="fas fa-tags mr-1"></i> @endif
                                            @if($group == 'Problem') <i class="fas fa-exclamation-triangle mr-1"></i> @endif
                                            @if($group == 'Feature') <i class="fas fa-star mr-1"></i> @endif
                                            @if($group == 'FAQ') <i class="fas fa-question-circle mr-1"></i> @endif
                                            @if($group == 'Footer') <i class="fas fa-shoe-prints mr-1"></i> @endif
                                            @if($group == 'SEO') <i class="fas fa-search mr-1"></i> @endif
                                            @if($group == 'System') <i class="fas fa-cog mr-1"></i> @endif
                                            {{ strtoupper($group) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="landing-settings-tabsContent">
                                @foreach($groupedSettings as $group => $items)
                                    <div class="tab-pane fade {{ $group === $firstGroup ? 'show active' : '' }}" 
                                         id="content-{{ Str::slug($group) }}" 
                                         role="tabpanel" 
                                         aria-labelledby="tab-{{ Str::slug($group) }}">
                                        
                                        <div class="row">
                                            @foreach($items as $setting)
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="text-sm font-weight-bold">{{ str_replace(['app_', '_'], ['', ' '], $setting->key) }}</label>
                                                        
                                                        @if($setting->key == 'app_logo')
                                                            <div class="d-flex align-items-center">
                                                                @if($setting->value)
                                                                    <img src="{{ asset('storage/' . $setting->value) }}" class="img-thumbnail mr-3" style="height: 60px; object-fit: contain;">
                                                                    <div class="custom-control custom-checkbox mr-3">
                                                                        <input type="checkbox" class="custom-control-input" id="deleteLogo" name="delete_app_logo" value="1">
                                                                        <label class="custom-control-label text-danger" for="deleteLogo">Hapus</label>
                                                                    </div>
                                                                @else
                                                                    <div class="bg-light mr-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 8px;">
                                                                        <i class="fas fa-image text-muted"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="custom-file">
                                                                    <input type="file" name="app_logo" class="custom-file-input" id="logoFile">
                                                                    <label class="custom-file-label" for="logoFile">Pilih Logo Baru</label>
                                                                </div>
                                                            </div>
                                                        @elseif($setting->key == 'app_favicon')
                                                            <div class="d-flex align-items-center">
                                                                @if($setting->value)
                                                                    <img src="{{ asset('storage/' . $setting->value) }}" class="img-thumbnail mr-3" style="height: 40px; width: 40px; object-fit: contain;">
                                                                    <div class="custom-control custom-checkbox mr-3">
                                                                        <input type="checkbox" class="custom-control-input" id="deleteFavicon" name="delete_app_favicon" value="1">
                                                                        <label class="custom-control-label text-danger" for="deleteFavicon">Hapus</label>
                                                                    </div>
                                                                @else
                                                                    <div class="bg-light mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 8px;">
                                                                        <i class="fas fa-icons text-muted"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="custom-file">
                                                                    <input type="file" name="app_favicon" class="custom-file-input" id="faviconFile">
                                                                    <label class="custom-file-label" for="faviconFile">Pilih Favicon Baru</label>
                                                                </div>
                                                            </div>
                                                        @elseif(Str::contains($setting->key, ['content', 'description', 'address', 'quote', 'desc', 'footer_text', 'instructions']))
                                                            <textarea name="settings[{{ $setting->key }}]" class="form-control" rows="3" placeholder="Masukkan {{ str_replace('_', ' ', $setting->key) }}...">{{ $setting->value }}</textarea>
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
                                                            </div>
                                                        @endif
                                                        <small class="text-muted font-italic">Key: <code>{{ $setting->key }}</code></small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-top-0 px-4 py-3 text-right">
                    <button type="submit" class="btn btn-danger px-5 shadow-sm" style="border-radius: 50px; font-weight: bold;">
                        <i class="fas fa-check-circle mr-1"></i> SIMPAN SEMUA PENGATURAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update filename in custom-file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush
