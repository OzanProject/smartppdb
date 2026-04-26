@extends('admin.layouts.app')

@section('title', 'Gelombang Pendaftaran')
@section('header', 'Manajemen Gelombang')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Gelombang</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">Daftar Gelombang Pendaftaran</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
            <i class="fas fa-plus mr-1"></i> Tambah Gelombang
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>Nama Gelombang</th>
              <th>Tahun Ajaran</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th class="text-center">Status</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($batches as $batch)
              <tr>
                <td class="font-weight-bold">{{ $batch->name }}</td>
                <td>{{ $batch->academicYear->name }}</td>
                <td>{{ $batch->start_date->format('d M Y') }}</td>
                <td>{{ $batch->end_date->format('d M Y') }}</td>
                <td class="text-center">
                  @if($batch->is_active)
                    <span class="badge badge-success px-2 py-1">Aktif</span>
                  @else
                    <span class="badge badge-secondary px-2 py-1">Tidak Aktif</span>
                  @endif
                </td>
                <td class="text-right">
                  <button type="button" class="btn btn-info btn-xs btn-edit" 
                    data-id="{{ $batch->id }}"
                    data-year_id="{{ $batch->academic_year_id }}"
                    data-name="{{ $batch->name }}"
                    data-start="{{ $batch->start_date->format('Y-m-d') }}"
                    data-end="{{ $batch->end_date->format('Y-m-d') }}"
                    data-active="{{ $batch->is_active }}"
                    data-url="{{ route('admin.batches.update', $batch->id) }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-xs" onclick="deleteBatch('{{ route('admin.batches.destroy', $batch->id) }}')">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Belum ada data gelombang pendaftaran.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal-add">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.batches.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Tambah Gelombang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="add-academic-year">Pilih Tahun Ajaran</label>
            <select name="academic_year_id" id="add-academic-year" class="form-control" required>
              <option value="">-- Pilih Tahun Ajaran --</option>
              @foreach($academicYears as $year)
                <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>{{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="add-name">Nama Gelombang</label>
            <input type="text" name="name" id="add-name" class="form-control" placeholder="Contoh: Gelombang 1" required>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="add-start">Tanggal Mulai</label>
                <input type="date" name="start_date" id="add-start" class="form-control" required>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="add-end">Tanggal Selesai</label>
                <input type="date" name="end_date" id="add-end" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="add-active" checked>
              <label class="custom-control-label" for="add-active">Set sebagai gelombang aktif</label>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div id="modal-edit" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-edit" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-header">
          <h4 class="modal-title">Edit Gelombang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-academic-year">Pilih Tahun Ajaran</label>
            <select name="academic_year_id" id="edit-academic-year" class="form-control" required>
              <option value="">-- Pilih Tahun Ajaran --</option>
              @foreach($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="edit-name">Nama Gelombang</label>
            <input type="text" name="name" id="edit-name" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="edit-start">Tanggal Mulai</label>
                <input type="date" name="start_date" id="edit-start" class="form-control" required>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="edit-end">Tanggal Selesai</label>
                <input type="date" name="end_date" id="edit-end" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="edit-active">
              <label class="custom-control-label" for="edit-active">Set sebagai gelombang aktif</label>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<form id="form-delete" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
  $(function() {
    $('.btn-edit').on('click', function() {
      let id = $(this).data('id');
      let year_id = $(this).data('year_id');
      let name = $(this).data('name');
      let start = $(this).data('start');
      let end = $(this).data('end');
      let active = $(this).data('active');
      let url = $(this).data('url');

      $('#edit-academic-year').val(year_id);
      $('#edit-name').val(name);
      $('#edit-start').val(start);
      $('#edit-end').val(end);
      $('#edit-active').prop('checked', active == 1);
      $('#form-edit').attr('action', url);
      $('#modal-edit').modal('show');
    });
  });

  function deleteBatch(url) {
    Swal.fire({
      title: 'Hapus Gelombang?',
      text: "Data gelombang yang sudah memiliki pendaftar tidak dapat dihapus!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        let form = document.getElementById('form-delete');
        form.action = url;
        form.submit();
      }
    })
  }
</script>
@endpush
