@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

@php
  $planName = $school->pricingPlan->name ?? 'Free Basic (Tanpa Paket)';
  $trialActive = $school->hasActiveTrial();
@endphp

<div class="row mb-3 align-items-center">
    <div class="col-12 text-right">
        <span class="badge badge-light px-3 py-2 shadow-sm border" style="font-size: 14px; color: #333;">
            <i class="fas fa-clock text-primary mr-1"></i> Waktu Sistem Sekolah ({{ config('app.timezone') }}): 
            <strong id="server-clock-live" class="text-primary">{{ now()->format('d M Y H:i:s') }}</strong>
        </span>
    </div>
</div>

@if($trialActive)
<div class="alert alert-success alert-dismissible shadow-sm border-0" style="border-radius: 12px;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-gift"></i> <strong>Akses Penuh (Free Trial) Aktif!</strong></h5>
    Sekolah Anda sedang menikmati masa uji coba akses penuh yang akan berakhir pada <strong>{{ $school->trial_ends_at->format('d M Y H:i') }}</strong>. <br>
    Setelah trial berakhir, Anda akan dialihkan ke paket: <strong>{{ $planName }}</strong>.
</div>
@elseif($school->trial_ends_at && !$trialActive)
<div class="alert alert-warning alert-dismissible shadow-sm border-0" style="border-radius: 12px;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-exclamation-triangle"></i> <strong>Masa Free Trial Berakhir</strong></h5>
    Masa uji coba gratis Anda telah berakhir. Saat ini Anda menggunakan paket <strong>{{ $planName }}</strong> dengan akses modul terbatas.
</div>
@else
<div class="alert alert-info alert-dismissible shadow-sm border-0" style="border-radius: 12px;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info-circle"></i> <strong>Info Paket Langganan</strong></h5>
    Saat ini Anda berlangganan paket <strong>{{ $planName }}</strong>.
</div>
@endif

@php $quotaStatus = $school->getQuotaStatus(); @endphp
@if($quotaStatus['is_limited'])
    @if($quotaStatus['remaining'] <= 0)
    <div class="alert alert-danger alert-dismissible shadow-sm border-0" style="border-radius: 12px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> <strong>Kuota Pendaftaran Habis!</strong></h5>
        Batas maksimal pendaftar ({{ $quotaStatus['max'] }} pendaftar) untuk paket Anda telah tercapai. Calon pendaftar baru tidak akan bisa mendaftar. <strong>Upgrade paket Anda sekarang!</strong>
    </div>
    @elseif($quotaStatus['remaining'] <= 5)
    <div class="alert alert-warning alert-dismissible shadow-sm border-0" style="border-radius: 12px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-circle"></i> <strong>Peringatan Kuota Hampir Habis!</strong></h5>
        Kuota pendaftar Anda tersisa <strong>{{ $quotaStatus['remaining'] }}</strong> slot lagi ({{ $quotaStatus['current'] }}/{{ $quotaStatus['max'] }}). Segera upgrade paket agar pendaftar tidak ditolak oleh sistem.
    </div>
    @endif
@endif

<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $stats['registrations_count'] }}</h3>
        <p>Total Pendaftar</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="{{ route('admin.registrations.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $stats['pending_count'] }}</h3>
        <p>Menunggu Verifikasi</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
      <a href="{{ route('admin.registrations.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ $stats['verified_count'] }}</h3>
        <p>Terverifikasi</p>
      </div>
      <div class="icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <a href="{{ route('admin.registrations.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $stats['accepted_count'] }}</h3>
        <p>Diterima</p>
      </div>
      <div class="icon">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <a href="{{ route('admin.students.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
      <div class="card-header bg-transparent border-0 pt-4 px-4">
        <h3 class="card-title font-weight-bold"><i class="fas fa-link mr-2 text-primary"></i> Link Publik Sekolah</h3>
      </div>
      <div class="card-body px-4 pb-4">
        <p class="text-muted small mb-4">Gunakan link di bawah ini untuk dibagikan kepada calon pendaftar melalui WhatsApp atau Media Sosial.</p>
        
        <div class="form-group">
          <label class="text-sm">Link Landing Page (Website Sekolah)</label>
          <div class="input-group shadow-sm">
            <input type="text" class="form-control bg-light" id="urlLanding" value="{{ route('school.landing', $school->slug) }}" readonly>
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('urlLanding')"><i class="fas fa-copy"></i></button>
              <a href="{{ route('school.landing', $school->slug) }}" target="_blank" class="btn btn-primary"><i class="fas fa-external-link-alt"></i></a>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="text-sm">Link Pendaftaran Online</label>
          <div class="input-group shadow-sm">
            <input type="text" class="form-control bg-light" id="urlReg" value="{{ route('school.registration.form', $school->slug) }}" readonly>
            <div class="input-group-append">
              <button class="btn btn-outline-success" type="button" onclick="copyToClipboard('urlReg')"><i class="fas fa-copy"></i></button>
              <a href="{{ route('school.registration.form', $school->slug) }}" target="_blank" class="btn btn-success"><i class="fas fa-external-link-alt"></i></a>
            </div>
          </div>
        </div>

        <div class="form-group mb-0">
          <label class="text-sm">Link Cek Status Pendaftaran</label>
          <div class="input-group shadow-sm">
            <input type="text" class="form-control bg-light" id="urlTrack" value="{{ route('school.registration.track', $school->slug) }}" readonly>
            <div class="input-group-append">
              <button class="btn btn-outline-info" type="button" onclick="copyToClipboard('urlTrack')"><i class="fas fa-copy"></i></button>
              <a href="{{ route('school.registration.track', $school->slug) }}" target="_blank" class="btn btn-info"><i class="fas fa-external-link-alt"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
      <div class="card-header bg-transparent border-0 pt-4 px-4">
        <h3 class="card-title font-weight-bold"><i class="fas fa-school mr-1 text-primary"></i> Informasi Sekolah</h3>
      </div>
      <div class="card-body px-4 pb-4">
        <div class="row mb-4">
          <div class="col-sm-6 mb-3">
            <strong class="text-xs text-uppercase text-muted d-block">NPSN</strong>
            <span class="text-dark font-weight-bold">{{ $school->npsn ?? '-' }}</span>
          </div>
          <div class="col-sm-6 mb-3">
            <strong class="text-xs text-uppercase text-muted d-block">Jenjang</strong>
            <span class="text-dark font-weight-bold">{{ $school->education_level_name ?? '-' }}</span>
          </div>
          <div class="col-sm-6">
            <strong class="text-xs text-uppercase text-muted d-block">Email</strong>
            <span class="text-dark font-weight-bold">{{ $school->email ?? '-' }}</span>
          </div>
          <div class="col-sm-6">
            <strong class="text-xs text-uppercase text-muted d-block">Telepon</strong>
            <span class="text-dark font-weight-bold">{{ $school->phone ?? '-' }}</span>
          </div>
        </div>

        <div class="bg-light p-3 rounded-xl mb-4">
          <h6 class="font-weight-bold mb-3"><i class="fas fa-credit-card mr-1 text-primary"></i> Layanan & Langganan</h6>
          <div class="row">
            <div class="col-sm-6 mb-2">
              <strong class="text-xs text-muted d-block">Paket Aktif</strong>
              <span class="badge badge-primary">{{ $school->pricingPlan->name ?? 'Free' }}</span>
            </div>
            <div class="col-sm-6 mb-2">
              <strong class="text-xs text-muted d-block">Siklus</strong>
              <span class="text-sm text-capitalize font-weight-bold">{{ $school->pricingPlan->billing_cycle ?? 'Custom' }}</span>
            </div>
            <div class="col-sm-12 mt-2">
                @if($trialActive)
                  <div class="badge badge-success p-2 w-100 text-left">
                      <i class="fas fa-gift mr-1"></i> Free Trial s/d {{ $school->trial_ends_at->format('d M Y') }}
                  </div>
                @endif
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-6">
            <a href="{{ route('admin.school.edit') }}" class="btn btn-outline-primary btn-block" style="border-radius: 10px;"><b>Edit Profil</b></a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-primary btn-block shadow-sm" style="border-radius: 10px;"><b>Upgrade</b></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-outline card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cog mr-1"></i> Konfigurasi PPDB</h3>
      </div>
      <div class="card-body">
        <div class="info-box bg-light">
          <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tahun Ajaran Aktif</span>
            <span class="info-box-number text-primary">{{ $activeAcademicYear->name ?? 'Belum Diatur' }}</span>
          </div>
        </div>

        <h6>Gelombang Aktif:</h6>
        @if($activeAdmissionBatches->count() > 0)
          @foreach($activeAdmissionBatches as $batch)
            <div class="callout callout-success py-2 mb-2">
              <h6 class="font-weight-bold mb-1">{{ $batch->name }}</h6>
              <p class="text-sm mb-0">{{ $batch->start_date->format('d M Y') }} - {{ $batch->end_date->format('d M Y') }}</p>
            </div>
          @endforeach
        @else
          <div class="alert alert-light border">
            <i class="icon fas fa-info"></i> Tidak ada gelombang pendaftaran yang aktif saat ini.
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Link berhasil disalin ke clipboard.',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Live Server Clock
    $(function() {
        // Init timestamp from server (seconds since epoch)
        let serverTime = {{ now()->timestamp }};
        
        // Month array in Indonesian
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        setInterval(function() {
            serverTime++; // tick one second
            
            // Create a Date object in local browser time BUT shifted to match server elapsed time
            // Since we just format it manually, we can parse it cleanly.
            let d = new Date(serverTime * 1000);
            
            // We want to format it as: d M Y H:i:s
            // Wait, new Date(timestamp) will output in browser's local timezone.
            // Better approach: Let's use Intl.DateTimeFormat to force the timezone to app timezone!
            try {
                let options = {
                    timeZone: '{{ config('app.timezone') }}',
                    day: '2-digit', month: 'short', year: 'numeric',
                    hour: '2-digit', minute: '2-digit', second: '2-digit',
                    hour12: false
                };
                let formatter = new Intl.DateTimeFormat('id-ID', options);
                let parts = formatter.formatToParts(d);
                
                // Parts: day, month, year, hour, minute, second
                let day = parts.find(p => p.type === 'day').value;
                let month = parts.find(p => p.type === 'month').value;
                let year = parts.find(p => p.type === 'year').value;
                let hour = parts.find(p => p.type === 'hour').value;
                let minute = parts.find(p => p.type === 'minute').value;
                let second = parts.find(p => p.type === 'second').value;
                
                // Format: 25 Apr 2026 12:00:00
                $('#server-clock-live').text(`${day} ${month} ${year} ${hour}:${minute}:${second}`);
            } catch(e) {
                // Fallback if browser doesn't support Intl timeZone
                console.log(e);
            }
        }, 1000);
    });
</script>
@endpush
