@extends('applicant.layouts.app')

@section('title', 'Detail Pendaftaran')
@section('header', 'Detail Pendaftaran Saya')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="premium-card mb-5 overflow-hidden position-relative" style="border-top: 4px solid #4facfe !important;">
            <div class="card-header bg-transparent border-0 py-4 px-4 px-md-5 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title font-weight-bold text-dark mb-0 d-flex align-items-center">
                    <div class="bg-gradient-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 40px; height: 40px; border-radius: 12px; font-size: 16px;">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    No. Registrasi: <span class="text-primary ml-2">{{ $registration->registration_number }}</span>
                </h3>
                <div class="card-tools mt-3 mt-md-0">
                    @php
                      $statusInfo = [
                        'pending' => ['bg' => 'linear-gradient(135deg, #f6d365 0%, #fda085 100%)', 'label' => 'PENDING'],
                        'verified' => ['bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'label' => 'TERVERIFIKASI'],
                        'accepted' => ['bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'label' => 'DITERIMA'],
                        'rejected' => ['bg' => 'linear-gradient(135deg, #ff0844 0%, #ffb199 100%)', 'label' => 'DITOLAK'],
                      ][$registration->status] ?? ['bg' => '#6c757d', 'label' => 'UNKNOWN'];
                    @endphp
                    <span class="badge text-white px-4 py-2 shadow-sm" style="background: {{ $statusInfo['bg'] }}; border-radius: 12px; font-size: 0.9rem; letter-spacing: 1px;">
                        {{ $statusInfo['label'] }}
                    </span>
                </div>
            </div>
            
            <div class="card-body bg-transparent px-4 px-md-5 pb-5 pt-0">
                <div class="row">
                    <!-- Data Pribadi -->
                    @if(!empty($registration->personal_data))
                    <div class="col-md-6 mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px dashed #e2e8f0;">
                            <i class="fas fa-user text-primary mb-0 mr-2" style="font-size: 1.5rem;"></i>
                            <h5 class="text-dark font-weight-bold mb-0">I. Data Pribadi</h5>
                        </div>
                        <table class="table table-sm table-borderless premium-table">
                            @foreach($registration->personal_data as $key => $value)
                                <tr>
                                    <td width="40%" class="text-muted font-weight-medium">{{ strlen($key) <= 4 ? strtoupper($key) : ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="font-weight-bold text-dark">
                                        @if(is_string($value) && str_starts_with($value, 'documents/'))
                                            <a href="{{ asset('storage/' . $value) }}" target="_blank" class="btn btn-xs btn-outline-primary"><i class="fas fa-paperclip"></i> Lihat File</a>
                                        @else
                                            : {{ $value ?: '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    <!-- Asal Sekolah -->
                    @if(!empty($registration->previous_school_data))
                    <div class="col-md-6 mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px dashed #e2e8f0;">
                            <i class="fas fa-university text-info mb-0 mr-2" style="font-size: 1.5rem;"></i>
                            <h5 class="text-dark font-weight-bold mb-0">II. Asal Sekolah</h5>
                        </div>
                        <table class="table table-sm table-borderless premium-table">
                            @foreach($registration->previous_school_data as $key => $value)
                                <tr>
                                    <td width="40%" class="text-muted font-weight-medium">{{ strlen($key) <= 4 ? strtoupper($key) : ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="font-weight-bold text-dark">
                                        @if(is_string($value) && str_starts_with($value, 'documents/'))
                                            <a href="{{ asset('storage/' . $value) }}" target="_blank" class="btn btn-xs btn-outline-info"><i class="fas fa-paperclip"></i> Lihat File</a>
                                        @else
                                            : {{ $value ?: '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    <!-- Data Orang Tua / Wali -->
                    @if(!empty($registration->parent_data))
                    <div class="col-md-6 mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px dashed #e2e8f0;">
                            <i class="fas fa-users text-success mb-0 mr-2" style="font-size: 1.5rem;"></i>
                            <h5 class="text-dark font-weight-bold mb-0">III. Data Orang Tua / Wali</h5>
                        </div>
                        <table class="table table-sm table-borderless premium-table">
                            @foreach($registration->parent_data as $key => $value)
                                <tr>
                                    <td width="40%" class="text-muted font-weight-medium">{{ strlen($key) <= 4 ? strtoupper($key) : ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="font-weight-bold text-dark">
                                        @if(is_string($value) && str_starts_with($value, 'documents/'))
                                            <a href="{{ asset('storage/' . $value) }}" target="_blank" class="btn btn-xs btn-outline-success"><i class="fas fa-paperclip"></i> Lihat File</a>
                                        @else
                                            : {{ $value ?: '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    <!-- Data Tambahan -->
                    @if(!empty($registration->additional_data))
                    <div class="col-md-6 mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px dashed #e2e8f0;">
                            <i class="fas fa-list-alt text-warning mb-0 mr-2" style="font-size: 1.5rem;"></i>
                            <h5 class="text-dark font-weight-bold mb-0">Data Registrasi</h5>
                        </div>
                        <table class="table table-sm table-borderless premium-table">
                            @foreach($registration->additional_data as $key => $value)
                                <tr>
                                    <td width="40%" class="text-muted font-weight-medium">{{ strlen($key) <= 4 ? strtoupper($key) : ucwords(str_replace('_', ' ', $key)) }}</td>
                                    <td class="font-weight-bold text-dark">
                                        @if(is_string($value) && str_starts_with($value, 'documents/'))
                                            <a href="{{ asset('storage/' . $value) }}" target="_blank" class="btn btn-xs btn-outline-warning"><i class="fas fa-paperclip"></i> Lihat File</a>
                                        @else
                                            : {{ $value ?: '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    <!-- Persyaratan Berkas -->
                    @if($registration->documents && $registration->documents->count() > 0)
                    <div class="col-md-12 mb-5">
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 2px dashed #e2e8f0;">
                            <i class="fas fa-folder-open text-danger mb-0 mr-2" style="font-size: 1.5rem;"></i>
                            <h5 class="text-dark font-weight-bold mb-0">V. Persyaratan Berkas</h5>
                        </div>
                        <div class="row">
                            @foreach($registration->documents as $doc)
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                    <div class="d-flex align-items-center" style="overflow: hidden;">
                                        <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mr-3" style="width: 45px; height: 45px; flex-shrink: 0;">
                                            <i class="fas fa-file-alt text-danger" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div class="text-truncate mr-2">
                                            <h6 class="mb-1 font-weight-bold text-dark text-truncate" title="{{ $doc->name }}">{{ $doc->name }}</h6>
                                            <small class="text-muted d-block text-truncate">Berkas Tersimpan</small>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm" style="border-radius: 8px; flex-shrink: 0; min-width: 80px;">
                                        <i class="fas fa-external-link-alt mr-1"></i> Buka
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                @if($registration->admin_note || $registration->note)
                    <div class="p-4 mt-2 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fffbeb 0%, #fefcbf 100%); border-radius: 16px; border: 1px solid rgba(236, 201, 75, 0.3);">
                        <div class="position-absolute" style="top: -10px; right: -10px; opacity: 0.1; font-size: 80px; color: #d69e2e;">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <h6 class="font-weight-extrabold text-warning mb-2" style="color: #d69e2e !important;"><i class="fas fa-exclamation-circle mr-2"></i> Catatan Admin:</h6>
                        <p class="mb-0 text-dark font-weight-medium" style="line-height: 1.6; font-size: 0.95rem;">"{{ $registration->admin_note ?? $registration->note }}"</p>
                    </div>
                @endif
            </div>
            
            <div class="card-footer bg-light border-top-0 py-4 px-4 px-md-5 d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('applicant.dashboard') }}" class="btn btn-outline-secondary font-weight-bold shadow-sm px-4 mb-2 mb-md-0" style="border-radius: 10px;">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
                
                @if($registration->status === 'accepted')
                <a href="{{ route('applicant.registration.print', $registration->id) }}" target="_blank" class="btn text-white font-weight-bold shadow-sm px-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 10px;">
                    <i class="fas fa-print mr-2"></i> Cetak Bukti Kelulusan
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Base Typography */
    body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
    .font-weight-extrabold { font-weight: 800; }
    .font-weight-medium { font-weight: 500; }
    
    /* Premium Cards */
    .premium-card {
        background: #ffffff;
        border: none !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0,0,0,0.02) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    /* Premium Table */
    .premium-table td {
        padding: 0.5rem 0.2rem;
        vertical-align: middle;
    }
</style>
@endpush
