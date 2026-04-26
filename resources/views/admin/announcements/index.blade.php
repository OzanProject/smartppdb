@extends('admin.layouts.app')

@section('title', 'Manajemen Pengumuman')
@section('header', 'Manajemen Pengumuman Kelulusan')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Manajemen Pengumuman</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
      <div class="card-header bg-transparent border-0 pt-4 px-4">
        <h3 class="card-title font-weight-bold"><i class="fas fa-bullhorn mr-2 text-primary"></i> Daftar Pengumuman</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-primary px-4 shadow-sm" style="border-radius: 50px;" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus-circle mr-1"></i> Buat Pengumuman Baru
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-valign-middle mb-0">
            <thead class="bg-light">
              <tr>
                <th class="px-4">Judul Pengumuman</th>
                <th>Gelombang</th>
                <th class="text-center">Tanggal Buka</th>
                <th class="text-center">Status</th>
                <th class="text-right px-4">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($announcements as $announcement)
                <tr>
                  <td class="px-4">
                    <div class="d-flex flex-column">
                        <span class="font-weight-bold text-dark">{{ $announcement->title }}</span>
                        <small class="text-muted">Dibuat: {{ $announcement->created_at->format('d M Y') }}</small>
                    </div>
                  </td>
                  <td>{{ $announcement->admissionBatch->name }}</td>
                  <td class="text-center">
                    {{ $announcement->announcement_date ? $announcement->announcement_date->format('d/m/Y') : '-' }}
                  </td>
                  <td class="text-center">
                    @if($announcement->is_published)
                        <span class="badge badge-success px-3 py-2" style="border-radius: 8px;">PUBLISHED</span>
                    @else
                        <span class="badge badge-secondary px-3 py-2" style="border-radius: 8px;">DRAFT</span>
                    @endif
                  </td>
                  <td class="text-right px-4">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light btn-sm shadow-sm border mr-2" style="border-radius: 50px;" data-toggle="modal" data-target="#modal-edit-{{ $announcement->id }}">
                            <i class="fas fa-edit mr-1 text-primary"></i> Edit
                        </button>
                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm shadow-sm border" style="border-radius: 50px;">
                                <i class="fas fa-trash mr-1 text-danger"></i> Hapus
                            </button>
                        </form>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modal-edit-{{ $announcement->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg text-left" role="document">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title font-weight-bold">Edit Pengumuman</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pilih Gelombang <span class="text-danger">*</span></label>
                                                    <select name="admission_batch_id" class="form-control" required>
                                                        @foreach($batches as $batch)
                                                            <option value="{{ $batch->id }}" {{ $announcement->admission_batch_id == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Pengumuman</label>
                                                    <input type="date" name="announcement_date" class="form-control" value="{{ $announcement->announcement_date ? $announcement->announcement_date->format('Y-m-d') : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Judul Tampilan <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" value="{{ $announcement->title }}" placeholder="Contoh: Pengumuman Hasil Seleksi Tahap 1" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Pesan Untuk Yang LULUS</label>
                                            <textarea name="content_success" class="form-control" rows="3" placeholder="Masukkan kata-kata selamat untuk pendaftar yang diterima...">{{ $announcement->content_success }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-danger font-weight-bold"><i class="fas fa-times-circle mr-1"></i> Pesan Untuk Yang TIDAK LULUS</label>
                                            <textarea name="content_failure" class="form-control" rows="3" placeholder="Masukkan kata-kata penyemangat untuk pendaftar yang belum diterima...">{{ $announcement->content_failure }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-success">
                                                <input type="checkbox" name="is_published" value="1" class="custom-control-input" id="switch-edit-{{ $announcement->id }}" {{ $announcement->is_published ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="switch-edit-{{ $announcement->id }}">Publikasikan ke Pendaftar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light px-4" data-dismiss="modal" style="border-radius: 50px;">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 50px;">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <i class="fas fa-bullhorn fa-3x mb-3 opacity-25"></i>
                    <p>Belum ada pengumuman yang dibuat.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Buat Pengumuman Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Gelombang <span class="text-danger">*</span></label>
                                <select name="admission_batch_id" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Gelombang --</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Pengumuman</label>
                                <input type="date" name="announcement_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Judul Tampilan <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Pengumuman Hasil Seleksi Tahap 1" required>
                    </div>
                    <div class="form-group">
                        <label class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Pesan Untuk Yang LULUS</label>
                        <textarea name="content_success" class="form-control" rows="3" placeholder="Masukkan kata-kata selamat untuk pendaftar yang diterima..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="text-danger font-weight-bold"><i class="fas fa-times-circle mr-1"></i> Pesan Untuk Yang TIDAK LULUS</label>
                        <textarea name="content_failure" class="form-control" rows="3" placeholder="Masukkan kata-kata penyemangat untuk pendaftar yang belum diterima..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-on-success">
                            <input type="checkbox" name="is_published" value="1" class="custom-control-input" id="switch-create">
                            <label class="custom-control-label" for="switch-create">Langsung Publikasikan</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal" style="border-radius: 50px;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 50px;">Buat Pengumuman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
