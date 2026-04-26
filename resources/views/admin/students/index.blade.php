@extends('admin.layouts.app')

@section('title', 'Data Siswa')
@section('header', 'Data Siswa Diterima')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Data Siswa</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-success">
      <div class="card-header border-bottom">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title text-success font-weight-bold mb-2 mb-md-0">
                <i class="fas fa-user-graduate mr-2"></i> Daftar Siswa Lolos Seleksi
            </h3>
            <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                <form action="{{ route('admin.students.index') }}" method="GET" class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                    <select name="batch_id" class="form-control form-control-sm shadow-sm" style="min-width: 150px; border-radius: 8px;" onchange="this.form.submit()">
                        <option value="">Semua Gelombang</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control" style="border-radius: 8px 0 0 8px;" placeholder="Cari nama atau no. reg..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success" style="border-radius: 0 8px 8px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="btn-group shadow-sm">
                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle font-weight-bold px-3" style="border-radius: 8px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-export mr-1"></i> Export Data
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-lg border-0">
                        <a class="dropdown-item py-2" href="{{ route('admin.students.export', array_merge(request()->all(), ['type' => 'excel'])) }}">
                            <i class="far fa-file-excel mr-2 text-success"></i> Export ke Excel (.xlsx)
                        </a>
                        <a class="dropdown-item py-2" href="{{ route('admin.students.export', array_merge(request()->all(), ['type' => 'pdf'])) }}">
                            <i class="far fa-file-pdf mr-2 text-danger"></i> Export ke PDF (.pdf)
                        </a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
              <tr>
                <th class="py-3 px-4" style="width: 180px;">NISN</th>
                <th class="py-3">Nama Siswa</th>
                <th class="py-3">Gelombang / Tahun</th>
                <th class="py-3">Tanggal Diterima</th>
                <th class="py-3 text-right px-4">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($students as $student)
                <tr>
                  <td class="px-4">
                    <span class="badge badge-light border px-2 py-1 text-monospace" style="font-size: 13px;">{{ $student->nisn ?? 'KOSONG' }}</span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="img-circle bg-gradient-success d-flex align-items-center justify-content-center mr-3 text-white shadow-sm" style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                        {{ substr($student->user->name, 0, 1) }}
                      </div>
                      <div class="d-flex flex-column">
                        <span class="font-weight-bold text-dark">{{ $student->user->name }}</span>
                        <small class="text-muted"><i class="fas fa-id-card mr-1"></i> {{ $student->registration_number }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="text-dark">{{ $student->admissionBatch->name ?? '-' }}</span>
                    <br>
                    <small class="badge badge-info text-xs">{{ $student->admissionBatch->academicYear->name ?? '-' }}</small>
                  </td>
                  <td>
                    <span class="text-muted"><i class="far fa-calendar-check mr-1"></i> {{ $student->updated_at->translatedFormat('d M Y') }}</span>
                  </td>
                  <td class="text-right px-4">
                    <a href="{{ route('admin.registrations.show', $student->id) }}" class="btn btn-light btn-sm shadow-sm border px-3" style="border-radius: 50px; transition: all 0.2s;">
                       <i class="fas fa-external-link-alt mr-1 text-primary"></i> Detail
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <div class="py-4">
                        <i class="fas fa-user-slash fa-4x mb-3 opacity-25"></i>
                        <p class="h5">Belum ada data siswa ditemukan.</p>
                        <p class="small">Pastikan status pendaftaran sudah 'Accepted' atau coba kata kunci pencarian lain.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6 text-muted small">
                Menampilkan {{ $students->firstItem() ?? 0 }} sampai {{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} data siswa.
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
