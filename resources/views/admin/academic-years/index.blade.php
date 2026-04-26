@extends('admin.layouts.app')

@section('title', 'Tahun Ajaran')
@section('header', 'Manajemen Tahun Ajaran')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Tahun Ajaran</li>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">Daftar Tahun Ajaran</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
            <i class="fas fa-plus mr-1"></i> Tambah Tahun Ajaran
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th class="text-center">Status</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($academicYears as $year)
              <tr>
                <td>{{ $year->name }}</td>
                <td>{{ $year->start_date->format('d M Y') }}</td>
                <td>{{ $year->end_date->format('d M Y') }}</td>
                <td class="text-center">
                  @if($year->is_active)
                    <span class="badge badge-success">Aktif</span>
                  @else
                    <span class="badge badge-secondary">Tidak Aktif</span>
                  @endif
                </td>
                <td class="text-right">
                  <button type="button" class="btn btn-info btn-xs btn-edit" 
                    data-id="{{ $year->id }}"
                    data-name="{{ $year->name }}"
                    data-start="{{ $year->start_date->format('Y-m-d') }}"
                    data-end="{{ $year->end_date->format('Y-m-d') }}"
                    data-active="{{ $year->is_active }}"
                    data-url="{{ route('admin.academic-years.update', $year->id) }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-xs" onclick="deleteYear('{{ route('admin.academic-years.destroy', $year->id) }}', {{ $year->is_active ? 'true' : 'false' }})">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">Belum ada data tahun ajaran.</td>
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
      <form action="{{ route('admin.academic-years.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Tambah Tahun Ajaran</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="add-name">Nama Tahun Ajaran</label>
            <input type="text" name="name" id="add-name" class="form-control" placeholder="Contoh: 2024/2025" required>
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
              <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="add-active">
              <label class="custom-control-label" for="add-active">Set sebagai tahun ajaran aktif</label>
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
          <h4 class="modal-title">Edit Tahun Ajaran</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-name">Nama Tahun Ajaran</label>
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
              <label class="custom-control-label" for="edit-active">Set sebagai tahun ajaran aktif</label>
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
      let name = $(this).data('name');
      let start = $(this).data('start');
      let end = $(this).data('end');
      let active = $(this).data('active');
      let url = $(this).data('url');

      $('#edit-name').val(name);
      $('#edit-start').val(start);
      $('#edit-end').val(end);
      $('#edit-active').prop('checked', active == 1);
      $('#form-edit').attr('action', url);
      $('#modal-edit').modal('show');
    });
  });

  function deleteYear(url, isActive) {
    if (isActive) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Tidak dapat menghapus tahun ajaran yang sedang aktif.'
      });
      return;
    }

    Swal.fire({
      title: 'Hapus Tahun Ajaran?',
      text: "Data yang dihapus tidak dapat dikembalikan!",
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
