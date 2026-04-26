@extends('admin.layouts.app')

@section('title', 'Detail Pendaftaran')
@section('header', 'Detail Pendaftaran: ' . $registration->registration_number)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.registrations.index') }}">Pendaftar</a></li>
  <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4">
    <!-- Profile Card -->
    <div class="card card-primary card-outline shadow-sm">
      <div class="card-body box-profile">
        <div class="text-center">
          <div class="img-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3 border" style="width: 100px; height: 100px; font-size: 40px; font-weight: bold; color: #adb5bd;">
            {{ substr($registration->applicant_name, 0, 1) }}
          </div>
        </div>

        <h3 class="profile-username text-center font-weight-bold">{{ $registration->applicant_name }}</h3>
        <p class="text-muted text-center small"><i class="fas fa-hashtag mr-1"></i> {{ $registration->registration_number }}</p>

        <ul class="list-group list-group-unbordered mb-3 mt-4">
          <li class="list-group-item">
            <b>Status</b> 
            @php
              $badgeClass = [
                'pending' => 'badge-warning',
                'verified' => 'badge-info',
                'accepted' => 'badge-success',
                'rejected' => 'badge-danger',
              ][$registration->status] ?? 'badge-secondary';
            @endphp
            <span class="float-right badge {{ $badgeClass }} px-3 py-2" style="font-size: 0.85rem;">{{ strtoupper($registration->status) }}</span>
          </li>
          <li class="list-group-item">
            <b>Gelombang</b> <span class="float-right font-weight-bold">{{ $registration->admissionBatch->name ?? '-' }}</span>
          </li>
          <li class="list-group-item">
            <b>Tanggal Daftar</b> <span class="float-right">{{ $registration->created_at->format('d M Y') }}</span>
          </li>
        </ul>

        <button type="button" class="btn btn-primary btn-block shadow-sm" data-toggle="modal" data-target="#modal-status">
          <i class="fas fa-user-check mr-1"></i> Update Status & Catatan
        </button>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="card card-secondary card-outline shadow-sm mt-4">
      <div class="card-header bg-white border-0 text-center">
        <h3 class="card-title font-weight-bold" style="float:none;">Kontak Pendaftar</h3>
      </div>
      <div class="card-body pt-0 text-center">
        <div class="mb-3">
            <small class="text-muted d-block uppercase tracking-wider">Email Utama</small>
            <span class="font-weight-500">{{ $registration->applicant_email }}</span>
        </div>
        <div>
            <small class="text-muted d-block uppercase tracking-wider">Mendaftar Pada</small>
            <span class="font-weight-500">{{ $registration->created_at->format('d/m/Y H:i') }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card card-primary card-outline card-tabs shadow-sm">
      <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs nav-fill" id="custom-tabs-three-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active font-weight-bold" id="tabs-biodata-tab" data-toggle="pill" href="#tabs-biodata" role="tab">Data Formulir</a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold" id="tabs-documents-tab" data-toggle="pill" href="#tabs-documents" role="tab">Dokumen Syarat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold" id="tabs-history-tab" data-toggle="pill" href="#tabs-history" role="tab">Log Admin</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-three-tabContent">
          <!-- Dynamic Biodata Tab -->
          <div class="tab-pane fade show active" id="tabs-biodata" role="tabpanel">
            @php
                $sections = $registration->school->formSections()->with('fields')->get();
                $allData = $registration->all_form_data;
            @endphp

            <div id="accordion-biodata">
            @forelse($sections as $section)
                <div class="card card-light shadow-none border mb-2">
                    <div class="card-header p-0" id="heading{{ $section->id }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left font-weight-bold text-dark py-3 px-4 d-flex justify-content-between align-items-center" 
                                    type="button" data-toggle="collapse" data-target="#collapse{{ $section->id }}" 
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                <span><i class="fas fa-layer-group mr-2 text-primary"></i> {{ $section->name }}</span>
                                <i class="fas fa-chevron-down transition-icon"></i>
                            </button>
                        </h2>
                    </div>

                    <div id="collapse{{ $section->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" data-parent="#accordion-biodata">
                        <div class="card-body bg-white">
                            <div class="row">
                                @forelse($section->fields as $field)
                                    <div class="col-sm-6 mb-4">
                                        <label class="mb-1 text-xs text-muted font-weight-normal uppercase tracking-wider">{{ $field->label }}</label>
                                        <div class="font-weight-bold mb-0 text-dark border-bottom pb-1">
                                            @php $val = $allData[$field->label] ?? ($allData[$field->name] ?? '-'); @endphp
                                            @if(is_array($val))
                                                {{ implode(', ', $val) }}
                                            @elseif(str_starts_with($val, 'documents/'))
                                                <div class="d-flex align-items-center mt-1">
                                                    @php $isImage = in_array(pathinfo($val, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']); @endphp
                                                    @if($isImage)
                                                        <a href="{{ asset('storage/' . $val) }}" target="_blank" class="mr-2 border rounded overflow-hidden shadow-sm d-inline-block" style="width: 50px; height: 50px;">
                                                            <img src="{{ asset('storage/' . $val) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </a>
                                                    @else
                                                        <i class="fas fa-file-pdf text-danger mr-2 fa-2x"></i>
                                                    @endif
                                                    <a href="{{ asset('storage/' . $val) }}" target="_blank" class="btn btn-xs btn-outline-primary">Lihat Berkas</a>
                                                </div>
                                            @else
                                                <p class="mb-0">{{ $val ?: '-' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 py-2 text-muted italic small font-weight-normal">Tidak ada kolom data di bagian ini.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 opacity-25"></i>
                    <p>Format formulir dinamis belum dikonfigurasi admin sekolah.</p>
                </div>
            @endforelse
            </div>
          </div>
          
          <!-- Dynamic Documents Tab -->
          <div class="tab-pane fade" id="tabs-documents" role="tabpanel">
            @php
                $requirements = $registration->school->documentRequirements()->orderBy('order_weight')->get();
                $uploadedDocs = $registration->documents->keyBy('type');
            @endphp
            <div class="row">
              @foreach($requirements as $req)
                @php 
                    $doc = $uploadedDocs->get($req->slug); 
                    $isUploaded = !!$doc;
                @endphp
                <div class="col-sm-4 mb-4">
                  <div class="card h-100 shadow-sm border {{ !$isUploaded ? 'bg-light opacity-75' : '' }}">
                    <div class="card-body p-2 text-center d-flex flex-column">
                      <div class="flex-grow-1 d-flex align-items-center justify-content-center bg-white rounded mb-2 overflow-hidden border" style="height: 140px; position: relative;">
                        @if($isUploaded)
                          @php
                            $isImage = in_array(pathinfo($doc->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']);
                          @endphp
                          @if($isImage)
                            <img src="{{ asset('storage/' . $doc->path) }}" class="img-fluid" style="object-fit: cover; height: 100%; width: 100%;" alt="{{ $req->name }}">
                          @else
                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                          @endif
                        @else
                          <div class="text-center">
                            <i class="fas fa-times-circle fa-3x text-danger opacity-50 mb-2"></i>
                            <p class="small text-danger font-weight-bold mb-0">BELUM UNGGAH</p>
                          </div>
                        @endif
                      </div>
                      <div>
                        <h6 class="text-xs font-weight-bold mb-1 text-truncate" title="{{ $req->name }}">
                            {{ strtoupper($req->name) }}
                            @if($req->is_required)
                                <span class="text-danger">*</span>
                            @endif
                        </h6>
                        <div class="d-flex gap-1">
                            @if($isUploaded)
                                <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="btn btn-xs btn-primary flex-grow-1 mr-1">
                                    <i class="fas fa-search"></i> Lihat
                                </a>
                            @else
                                <button class="btn btn-xs btn-outline-secondary flex-grow-1 disabled" disabled>
                                    <i class="fas fa-clock"></i> Belum Ada
                                </button>
                            @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
              
              @if($requirements->isEmpty())
                <div class="col-12 py-5 text-center text-muted">
                    <i class="fas fa-file-upload fa-3x mb-3 opacity-25"></i>
                    <p>Format persyaratan dokumen belum dikonfigurasi admin.</p>
                </div>
              @endif
            </div>
          </div>
          
          <!-- History/Notes Tab -->
          <div class="tab-pane fade" id="tabs-history" role="tabpanel">
            <div class="post">
              <div class="user-block mb-3 border-bottom pb-3">
                <div class="img-circle bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                  <i class="fas fa-user-shield"></i>
                </div>
                <span class="username">Petugas Pendaftaran</span>
                <span class="description">Status Terakhir - {{ $registration->updated_at->format('d M Y H:i') }}</span>
              </div>
              <div class="p-3 bg-light rounded border-left border-info">
                   <h6 class="font-weight-bold">Catatan Untuk Calon Siswa:</h6>
                   <p class="mb-0 text-dark">
                    {!! nl2br(e($registration->note ?? 'Belum ada catatan pendaftaran.')) !!}
                  </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="modal-status">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.registrations.status', $registration->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title font-weight-bold">Update Kelulusan / Status</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="status">Status Kelulusan</label>
            <select name="status" id="status" class="form-control form-control-lg font-weight-bold" required>
              <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>PENDING (Menunggu)</option>
              <option value="verified" {{ $registration->status == 'verified' ? 'selected' : '' }}>VERIFIED (Terverifikasi)</option>
              <option value="accepted" {{ $registration->status == 'accepted' ? 'selected' : '' }}>ACCEPTED (DITERIMA)</option>
              <option value="rejected" {{ $registration->status == 'rejected' ? 'selected' : '' }}>REJECTED (DITOLAK)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="admin_note">Catatan Admin (Dibaca oleh Calon Siswa)</label>
            <textarea name="note" id="admin_note" rows="4" class="form-control" placeholder="Contoh: Dokumen KK tidak terbaca, mohon upload ulang atau Selamat Anda diterima.">{{ old('note', $registration->note) }}</textarea>
          </div>
        </div>
        <div class="modal-footer justify-content-between bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
    .font-weight-500 { font-weight: 500; }
    .uppercase { text-transform: uppercase; }
    .tracking-wider { letter-spacing: 0.05em; }
    .nav-tabs .nav-link { color: #6c757d; }
    .nav-tabs .nav-link.active { color: #007bff !important; border-top: 3px solid #007bff !important; }
</style>
@endpush
