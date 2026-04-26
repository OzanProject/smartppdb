@extends('applicant.layouts.app')

@section('title', 'Formulir Pendaftaran')
@section('header', 'Formulir Pendaftaran Online')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('applicant.registration.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="school_id" value="{{ $school->id }}">
            <input type="hidden" name="admission_batch_id" value="{{ $batch->id }}">

            <!-- Header Banner -->
            <div class="premium-card mb-5 overflow-hidden position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #f3f8ff 100%) !important; border-left: 5px solid #4facfe !important;">
                <div class="card-body p-4 p-md-5 position-relative">
                    <div class="position-absolute" style="top: -20px; right: -20px; opacity: 0.04;">
                        <i class="fas fa-graduation-cap" style="font-size: 180px;"></i>
                    </div>
                    <div class="row align-items-center position-relative z-index-1">
                        <div class="col-md-8">
                            <div class="badge px-3 py-2 mb-3" style="background: rgba(79, 172, 254, 0.1); color: #4facfe; border-radius: 10px; font-weight: 700; letter-spacing: 1px;">
                                <i class="fas fa-satellite-dish mr-1 pulse-icon"></i> PENDAFTARAN DIBUKA
                            </div>
                            <h2 class="font-weight-extrabold mb-1" style="color: #1a202c; letter-spacing: -0.5px;">{{ $batch->name }}</h2>
                            <p class="text-muted h6 font-weight-normal mb-0" style="letter-spacing: 0.5px;">Tahun Ajaran {{ $batch->academicYear->name }}</p>
                        </div>
                        <div class="col-md-4 text-md-right mt-4 mt-md-0 d-none d-md-block">
                            <div class="bg-white d-inline-flex p-3 shadow-sm" style="border-radius: 20px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Icon" width="70" class="opacity-75">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php $sectionCount = 1; @endphp
            @foreach($sections as $section)
                @if($section->is_active)
                    <div class="premium-card mb-4" id="section-{{ $section->id }}">
                        <div class="card-header bg-transparent border-0 py-4 px-4 px-md-5">
                            <div class="d-flex align-items-center">
                                <div class="premium-number-badge mr-3 shadow-sm">
                                    {{ $sectionCount++ }}
                                </div>
                                <h3 class="mb-0 premium-section-header">{{ $section->name }}</h3>
                            </div>
                        </div>
                        <div class="card-body bg-transparent px-4 px-md-5 pb-4 pt-0">
                             <div class="row">
                                @forelse($section->fields as $field)
                                    @if($field->is_active)
                                        <div class="col-md-{{ $field->type == 'textarea' ? '12' : '6' }} mb-4">
                                            <div class="form-group mb-0 position-relative">
                                                <label class="premium-label">
                                                    {{ $field->label }}
                                                    @if($field->is_required) <span class="text-danger">*</span> @endif
                                                </label>
                                                
                                                @if($field->type == 'select')
                                                    <select name="field_{{ $field->id }}" class="form-control premium-input @error('field_'.$field->id) is-invalid @enderror" {{ $field->is_required ? 'required' : '' }}>
                                                        <option value="">Pilih {{ $field->label }}...</option>
                                                        @foreach($field->options ?? [] as $option)
                                                            <option value="{{ $option }}" {{ old('field_'.$field->id) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($field->type == 'textarea')
                                                    <textarea name="field_{{ $field->id }}" class="form-control premium-input @error('field_'.$field->id) is-invalid @enderror" rows="4" {{ $field->is_required ? 'required' : '' }} placeholder="{{ $field->help_text }}">{{ old('field_'.$field->id) }}</textarea>
                                                @elseif($field->type == 'file')
                                                    <div class="custom-file premium-file">
                                                        <input type="file" name="field_{{ $field->id }}" class="custom-file-input @error('field_'.$field->id) is-invalid @enderror" id="file_{{ $field->id }}" {{ $field->is_required ? 'required' : '' }}>
                                                        <label class="custom-file-label premium-input text-muted" for="file_{{ $field->id }}" style="line-height: 1.8;">Pilih berkas...</label>
                                                    </div>
                                                @else
                                                    <input type="{{ $field->type }}" 
                                                           name="field_{{ $field->id }}" 
                                                           value="{{ old('field_'.$field->id) }}"
                                                           class="form-control premium-input @error('field_'.$field->id) is-invalid @enderror" 
                                                           {{ $field->is_required ? 'required' : '' }}
                                                           placeholder="{{ $field->help_text ?: 'Masukkan '.$field->label }}">
                                                @endif

                                                @error('field_'.$field->id)
                                                    <span class="error invalid-feedback mt-2 d-block font-weight-bold">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="col-12 text-center py-4 text-muted">
                                        <div class="p-4 rounded" style="background: rgba(0,0,0,0.02);">
                                            <i class="fas fa-info-circle mr-1 opacity-50 mb-2 fa-2x"></i>
                                            <p class="mb-0 small">Data kolom belum diatur oleh admin.</p>
                                        </div>
                                    </div>
                                @endforelse
                             </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Syarat Dokumen -->
            @if($requirements->count() > 0)
            <div class="premium-card mb-5">
                <div class="card-header bg-transparent border-0 py-4 px-4 px-md-5">
                    <div class="d-flex align-items-center">
                        <div class="premium-number-badge bg-gradient-info text-white mr-3 shadow-sm">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <h3 class="mb-0 premium-section-header">Persyaratan Dokumen</h3>
                    </div>
                </div>
                <div class="card-body bg-transparent px-4 px-md-5 pb-4 pt-0">
                    <div class="row">
                        @foreach($requirements as $req)
                            <div class="col-md-6 mb-4">
                                <div class="form-group mb-0 position-relative p-3 rounded" style="background: rgba(0,0,0,0.01); border: 1px dashed rgba(0,0,0,0.1);">
                                    <label class="premium-label mb-3 text-dark">
                                        {{ $req->name }}
                                        @if($req->is_required) <span class="text-danger ml-1">*</span> @endif
                                    </label>
                                    <div class="custom-file premium-file">
                                        <input type="file" name="req_{{ $req->id }}" class="custom-file-input @error('req_'.$req->id) is-invalid @enderror" id="req_{{ $req->id }}" {{ $req->is_required ? 'required' : '' }} accept=".jpg,.jpeg,.png,.pdf">
                                        <label class="custom-file-label premium-input text-muted" for="req_{{ $req->id }}" style="line-height: 1.8;"><i class="fas fa-cloud-upload-alt mr-2"></i> Pilih berkas (Maks 2MB)...</label>
                                    </div>
                                    @if($req->description)
                                    <small class="form-text text-muted mt-2"><i class="fas fa-info-circle mr-1"></i>{{ $req->description }}</small>
                                    @endif
                                    
                                    @error('req_'.$req->id)
                                        <span class="error invalid-feedback d-block mt-2 font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="premium-card mb-5 text-center overflow-hidden position-relative" style="background: linear-gradient(135deg, #fffbeb 0%, #fff5d1 100%) !important; border: 1px solid rgba(255, 193, 7, 0.3) !important;">
                <div class="position-absolute" style="top: -20px; left: -20px; opacity: 0.05;">
                    <i class="fas fa-check-double" style="font-size: 150px;"></i>
                </div>
                <div class="card-body p-4 p-md-5 position-relative z-index-1">
                    <div class="bg-white text-warning rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-4 pulse-icon" style="width: 70px; height: 70px; font-size: 28px;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="font-weight-extrabold text-dark mb-3" style="letter-spacing: -0.5px;">Konfirmasi Pengiriman</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 600px; line-height: 1.7;">
                        Pastikan semua data dan dokumen yang Anda masukkan sudah benar dan valid. Setelah dikirim, perubahan data mungkin memerlukan persetujuan khusus dari pihak admin sekolah.
                    </p>
                    <button type="submit" class="btn premium-btn text-white btn-lg px-5 py-3 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i> KIRIM FORMULIR PENDAFTARAN
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        // Change file input label when file selected
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            if(fileName) {
                $(this).next('.custom-file-label').addClass("selected text-primary font-weight-bold").html('<i class="fas fa-check mr-2"></i>' + fileName);
                $(this).closest('.form-group').css('border-color', '#4facfe');
            } else {
                $(this).next('.custom-file-label').removeClass("selected text-primary font-weight-bold").html('<i class="fas fa-cloud-upload-alt mr-2"></i> Pilih berkas (Maks 2MB)...');
            }
        });

        // Add subtle animation to inputs on focus
        $('.premium-input').on('focus', function() {
            $(this).closest('.form-group').addClass('input-focused');
        }).on('blur', function() {
            $(this).closest('.form-group').removeClass('input-focused');
        });
    });
</script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Base Typography Updates */
    body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
    .font-weight-extrabold { font-weight: 800; }
    
    /* Premium Cards (Glassmorphism inspired) */
    .premium-card {
        background: #ffffff;
        border: none !important;
        border-radius: 24px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0,0,0,0.02) !important;
        transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .premium-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0,0,0,0.03) !important;
    }

    /* Section Headers */
    .premium-section-header {
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #2d3748;
    }
    
    .premium-number-badge {
        width: 45px; 
        height: 45px; 
        border-radius: 14px; 
        font-size: 18px; 
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Input & Label Styling */
    .premium-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #718096;
        display: block;
    }
    
    .premium-input {
        background-color: #f8fafc !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 14px !important;
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
        border-radius: 16px;
        font-weight: 800;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    .premium-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(79, 172, 254, 0.4) !important;
        background: linear-gradient(135deg, #3dbdfc 0%, #00d2ff 100%);
    }
    
    .premium-btn:active {
        transform: translateY(0);
    }

    /* Animations */
    .pulse-icon {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    /* Utilities */
    .z-index-1 { z-index: 1; }
    
    /* Custom File Input Hack */
    .premium-file .custom-file-label::after {
        content: "Telusuri";
        background: #edf2f7;
        border-radius: 0 12px 12px 0;
        height: 100%;
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #4a5568;
    }
</style>
@endpush
