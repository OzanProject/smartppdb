@extends('admin.layouts.app')

@section('title', 'Daftar Pendaftar')
@section('header', 'Data Pendaftar')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Pendaftar</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header border-0">
        <h3 class="card-title">List Pendaftaran Calon Siswa</h3>
        <div class="card-tools">
          <form action="{{ route('admin.registrations.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
            <input type="text" name="search" class="form-control float-right" placeholder="Cari nama / No. Reg..." value="{{ request('search') }}">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-valign-middle">
            <thead>
              <tr>
                <th>No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                @foreach($featuredFields as $field)
                  <th>{{ $field->label }}</th>
                @endforeach
                <th>Gelombang</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th class="text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($registrations as $reg)
                <tr>
                  <td>
                    <span class="text-bold text-primary">{{ $reg->registration_number }}</span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="img-circle bg-light d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px; font-size: 12px; font-weight: bold;">
                        {{ substr($reg->applicant_name, 0, 1) }}
                      </div>
                      <span>{{ $reg->applicant_name }}</span>
                    </div>
                  </td>
                  @foreach($featuredFields as $field)
                    <td>
                        @php $val = ($reg->additional_data[$field->name] ?? '-'); @endphp
                        @if(is_array($val))
                            {{ implode(', ', $val) }}
                        @else
                            {{ Str::limit($val, 20) }}
                        @endif
                    </td>
                  @endforeach
                  <td>{{ $reg->admissionBatch->name ?? '-' }}</td>
                  <td>{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                  <td>
                    @php
                      $badgeClass = [
                        'pending' => 'badge-warning',
                        'verified' => 'badge-info',
                        'accepted' => 'badge-success',
                        'rejected' => 'badge-danger',
                      ][$reg->status] ?? 'badge-secondary';
                      
                      $statusLabel = [
                        'pending' => 'Menunggu',
                        'verified' => 'Terverifikasi',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                      ][$reg->status] ?? $reg->status;
                    @endphp
                    <span class="badge {{ $badgeClass }} px-2 py-1">{{ strtoupper($statusLabel) }}</span>
                  </td>
                  <td class="text-right">
                    <a href="{{ route('admin.registrations.show', $reg->id) }}" class="btn btn-primary btn-sm mr-1">
                      <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.registrations.destroy', $reg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                    <p>Tidak ada data pendaftaran ditemukan.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if($registrations->hasPages())
        <div class="card-footer clearfix">
          <div class="float-right">
            {{ $registrations->links() }}
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  /* Fix Bootstrap 4 pagination appearance with Tailwind-style links if necessary, 
     but AdminLTE uses standard BS4 pagination */
  .pagination { margin-bottom: 0; }
</style>
@endpush
