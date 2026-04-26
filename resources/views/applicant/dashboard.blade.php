@extends('applicant.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Selamat Datang, ' . auth()->user()->name)

@section('content')
<div class="row">
  <div class="col-md-12">
    @if($registration)
      <!-- Premium Registration Status Card -->
      <div class="premium-card mb-5 overflow-hidden position-relative" style="border-left: 5px solid {{ $registration->status == 'accepted' ? '#38c172' : ($registration->status == 'rejected' ? '#e3342f' : '#f6993f') }} !important;">
        <div class="card-header bg-transparent border-0 py-4 px-4 px-md-5">
            <h3 class="card-title font-weight-bold text-dark" style="letter-spacing: -0.5px;">
                <div class="bg-gradient-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm mr-2" style="width: 40px; height: 40px; border-radius: 12px; font-size: 16px;">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                Status Pendaftaran Anda
            </h3>
        </div>
        <div class="card-body bg-transparent px-4 px-md-5 pb-4 pt-0">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h5 class="mb-2 text-muted">No. Registrasi: <span class="text-primary font-weight-extrabold" style="font-size: 1.2rem; letter-spacing: 1px;">{{ $registration->registration_number }}</span></h5>
              <p class="text-dark font-weight-bold h5 mb-4">{{ $registration->school->name }} <span class="text-muted font-weight-normal ml-2">| {{ $registration->admissionBatch->name }}</span></p>
              
              <div class="d-flex flex-wrap align-items-center mb-4 p-3 rounded" style="background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.05);">
                <div class="mr-4">
                    @php
                      $statusInfo = [
                        'pending' => ['bg' => 'linear-gradient(135deg, #f6d365 0%, #fda085 100%)', 'label' => 'MENUNGGU VERIFIKASI', 'icon' => 'fas fa-clock fa-spin-hover'],
                        'verified' => ['bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'label' => 'TERVERIFIKASI', 'icon' => 'fas fa-check-double'],
                        'accepted' => ['bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'label' => 'DITERIMA', 'icon' => 'fas fa-graduation-cap pulse-icon'],
                        'rejected' => ['bg' => 'linear-gradient(135deg, #ff0844 0%, #ffb199 100%)', 'label' => 'DITOLAK / PERLU PERBAIKAN', 'icon' => 'fas fa-times-circle'],
                      ][$registration->status] ?? ['bg' => '#6c757d', 'label' => 'UNKNOWN', 'icon' => 'fas fa-question'];
                    @endphp
                    <span class="badge text-white px-4 py-2 shadow-sm" style="background: {{ $statusInfo['bg'] }}; border-radius: 12px; font-size: 0.9rem; letter-spacing: 0.5px;">
                        <i class="{{ $statusInfo['icon'] }} mr-1"></i> {{ $statusInfo['label'] }}
                    </span>
                </div>
                <div class="text-sm font-weight-bold mt-3 mt-md-0" style="color: #a0aec0;">
                    <i class="far fa-calendar-alt mr-1"></i> Update: {{ $registration->updated_at->format('d M Y, H:i') }}
                </div>
              </div>

              @if($registration->note)
                <div class="p-4 mt-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fffbeb 0%, #fefcbf 100%); border-radius: 16px; border: 1px solid rgba(236, 201, 75, 0.3);">
                  <div class="position-absolute" style="top: -10px; right: -10px; opacity: 0.1; font-size: 80px; color: #d69e2e;">
                    <i class="fas fa-comment-dots"></i>
                  </div>
                  <h6 class="font-weight-extrabold text-warning mb-2" style="color: #d69e2e !important;"><i class="fas fa-exclamation-circle mr-2"></i>Catatan dari Admin:</h6>
                  <p class="mb-0 text-dark font-weight-medium" style="line-height: 1.6; font-size: 0.95rem;">"{{ $registration->note }}"</p>
                </div>
              @endif
            </div>

            <div class="col-md-4 text-center d-none d-md-flex justify-content-center align-items-center" style="min-height: 200px;">
                @if($registration->status == 'accepted')
                    <div class="status-icon-container" style="background: rgba(67, 233, 123, 0.1); color: #38c172;">
                        <i class="fas fa-graduation-cap pulse-icon"></i>
                    </div>
                @elseif($registration->status == 'rejected')
                    <div class="status-icon-container" style="background: rgba(227, 52, 47, 0.1); color: #e3342f;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                @elseif($registration->status == 'verified')
                    <div class="status-icon-container" style="background: rgba(79, 172, 254, 0.1); color: #4facfe;">
                        <i class="fas fa-check-double"></i>
                    </div>
                @else
                    <div class="status-icon-container" style="background: rgba(246, 211, 101, 0.1); color: #f6993f;">
                        <i class="fas fa-user-clock"></i>
                    </div>
                @endif
            </div>
          </div>
        </div>
        <div class="card-footer bg-light border-top-0 py-4 px-4 px-md-5">
          <div class="d-flex flex-wrap justify-content-between align-items-center">
              <a href="{{ route('applicant.registration.create') }}" class="btn btn-outline-primary btn-lg shadow-sm px-4 mb-2 mb-md-0" style="border-radius: 12px; font-weight: 600;">
                <i class="fas fa-eye mr-2"></i> Preview Data Saya
              </a>
              @if($registration->status == 'rejected' || $registration->status == 'pending')
                <a href="{{ route('applicant.registration.create') }}?edit=true" class="btn premium-btn text-white btn-lg shadow-lg px-4" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                    <i class="fas fa-edit mr-2"></i> Perbaiki / Update Data
                </a>
              @endif
          </div>
        </div>
      </div>
    @else
      <!-- Empty State / Registration Prompt -->
      <div class="premium-card mb-5 overflow-hidden text-center position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%) !important;">
        <div class="position-absolute" style="top: -50px; left: -50px; opacity: 0.03; font-size: 250px; color: #4facfe;">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="card-body p-5 z-index-1 position-relative">
            <div class="mb-4 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px; border-radius: 24px; background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%); color: white; font-size: 40px;">
                <i class="fas fa-user-edit"></i>
            </div>
            <h2 class="font-weight-extrabold text-dark mb-3" style="letter-spacing: -0.5px;">Anda belum melakukan pendaftaran</h2>
            <p class="text-muted mx-auto mb-5" style="max-width: 600px; line-height: 1.8; font-size: 1.1rem;">
                Selamat datang di portal PPDB Online. Silakan lengkapi formulir biodata dan unggah dokumen persyaratan Anda untuk memulai proses pendaftaran di sekolah yang Anda tuju.
            </p>
            <a href="{{ route('applicant.registration.create') }}" class="btn premium-btn btn-lg text-white shadow-lg px-5 py-3 pulse-button">
                <i class="fas fa-rocket mr-2"></i> MULAI PENDAFTARAN SEKARANG
            </a>
        </div>
      </div>
    @endif
  </div>
</div>

@if($showAnnouncement && $registration && in_array($registration->status, ['accepted', 'rejected']))
    <!-- Graduation Announcement Modal -->
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content overflow-hidden" style="border: none; border-radius: 25px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                @if($registration->status == 'accepted')
                    <div class="modal-header border-0 text-center flex-column p-0">
                        <div class="w-100 py-5 bg-gradient-success position-relative overflow-hidden" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <div class="confetti-icon" style="font-size: 80px; color: rgba(255,255,255,0.9);">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body text-center p-5">
                        <h2 class="font-weight-extrabold text-success mb-3" style="font-size: 2rem;">{{ $announcement->title ?? 'SELAMAT!' }}</h2>
                        <h4 class="mb-4 text-dark">Status: <strong>LULUS SELEKSI</strong></h4>
                        <div class="text-muted mb-4" style="line-height: 1.8;">
                            @if($announcement && $announcement->content_success)
                                {!! nl2br(e($announcement->content_success)) !!}
                            @else
                                Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru pada <strong>{{ $registration->school->name }}</strong>, Anda dinyatakan lolos dan diterima sebagai siswa baru.
                            @endif
                        </div>
                        <div class="p-3 mb-4 rounded-lg" style="background: #f0fff4; border: 1px dashed #38c172;">
                            <span class="text-success font-weight-bold">Silakan lakukan pendaftaran ulang sesuai dengan instruksi yang tersedia.</span>
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block shadow-sm py-3" data-dismiss="modal" style="border-radius: 15px; font-weight: bold;">
                            SAYA MENGERTI
                        </button>
                    </div>
                @else
                    <div class="modal-header border-0 text-center flex-column p-0">
                        <div class="w-100 py-5 bg-gradient-danger" style="background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);">
                            <div style="font-size: 80px; color: rgba(255,255,255,0.9);">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body text-center p-5">
                        <h2 class="font-weight-extrabold text-danger mb-3" style="font-size: 1.8rem;">{{ $announcement->title ?? 'TETAP SEMANGAT!' }}</h2>
                        <h4 class="mb-4 text-dark">Status: <strong>BELUM LULUS</strong></h4>
                        <div class="text-muted mb-4" style="line-height: 1.8;">
                            @if($announcement && $announcement->content_failure)
                                {!! nl2br(e($announcement->content_failure)) !!}
                            @else
                                Mohon maaf, berdasarkan hasil seleksi saat ini Anda belum dapat bergabung dengan <strong>{{ $registration->school->name }}</strong>. Jangan berkecil hati, tetap semangat!
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary btn-lg btn-block shadow-sm py-3" data-dismiss="modal" style="border-radius: 15px; font-weight: bold;">
                            TUTUP
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        @if($showAnnouncement)
            $('#announcementModal').modal('show');
        @endif
    });
</script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Base Typography Updates */
    body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
    .font-weight-extrabold { font-weight: 800; }
    .font-weight-medium { font-weight: 500; }
    
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
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3) !important;
        background: linear-gradient(135deg, #3dbdfc 0%, #00d2ff 100%);
    }

    /* Status Icon Container */
    .status-icon-container {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        box-shadow: inset 0 0 20px rgba(255,255,255,0.5);
    }

    /* Animations */
    .pulse-icon {
        animation: pulse 2s infinite;
    }
    
    .pulse-button {
        animation: pulse-shadow 2s infinite;
    }

    .fa-spin-hover:hover {
        animation: spin 2s linear infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    @keyframes pulse-shadow {
        0% { box-shadow: 0 0 0 0 rgba(79, 172, 254, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(79, 172, 254, 0); }
        100% { box-shadow: 0 0 0 0 rgba(79, 172, 254, 0); }
    }
    
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
    
    /* Utilities */
    .z-index-1 { z-index: 1; }
</style>
@endpush
