@extends('superadmin.layouts.app')

@section('title', 'Manajemen Testimoni')
@section('header', 'Ulasan Sekolah & Pengguna')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-danger shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-comments mr-2 text-danger"></i> Daftar Testimoni Sekolah</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4 py-3 text-xs font-weight-bold text-uppercase tracking-wider">Sekolah</th>
                                <th class="py-3 text-xs font-weight-bold text-uppercase tracking-wider">Pengirim</th>
                                <th class="py-3 text-xs font-weight-bold text-uppercase tracking-wider">Isi Testimoni</th>
                                <th class="py-3 text-xs font-weight-bold text-uppercase tracking-wider text-center">Rating</th>
                                <th class="py-3 text-xs font-weight-bold text-uppercase tracking-wider text-center">Status</th>
                                <th class="pr-4 py-3 text-xs font-weight-bold text-uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $t)
                                <tr>
                                    <td class="pl-4 py-4">
                                        <div class="d-flex align-items-center">
                                            @if($t->school->logo)
                                                <img src="{{ asset('storage/' . $t->school->logo) }}" class="rounded-circle mr-3 border" style="width: 40px; height: 40px; object-fit: contain; background: white;">
                                            @else
                                                <div class="rounded-circle mr-3 bg-light d-flex align-items-center justify-content-center text-danger font-weight-bold" style="width: 40px; height: 40px;">
                                                    {{ substr($t->school->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $t->school->name }}</div>
                                                <div class="text-xs text-muted">ID: {{ $t->school->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="font-weight-bold">{{ $t->user->name }}</div>
                                        <div class="text-xs text-muted">{{ $t->user->email }}</div>
                                    </td>
                                    <td class="py-4">
                                        <p class="mb-0 text-sm italic" style="max-width: 300px; white-space: normal;">"{{ $t->content }}"</p>
                                    </td>
                                    <td class="py-4 text-center">
                                        <div class="text-warning">
                                            @for($i=0; $i<$t->rating; $i++) <i class="fas fa-star text-xs"></i> @endfor
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @if($t->is_published)
                                            <span class="badge badge-success px-3 py-2" style="border-radius: 50px;">DIPUBLIKASIKAN</span>
                                        @else
                                            <span class="badge badge-secondary px-3 py-2" style="border-radius: 50px;">DRAFT</span>
                                        @endif
                                    </td>
                                    <td class="pr-4 py-4 text-right">
                                        <div class="btn-group shadow-sm" style="border-radius: 50px; overflow: hidden;">
                                            <form action="{{ route('superadmin.testimonials.toggle', $t) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $t->is_published ? 'btn-outline-warning' : 'btn-outline-success' }} px-3" title="{{ $t->is_published ? 'Kembalikan ke Draft' : 'Publikasikan' }}">
                                                    <i class="fas {{ $t->is_published ? 'fa-eye-slash' : 'fa-check-circle' }} mr-1"></i> {{ $t->is_published ? 'Draft' : 'Publish' }}
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-outline-danger px-3" onclick="confirmDelete('{{ route('superadmin.testimonials.destroy', $t) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted italic">Belum ada testimoni yang masuk dari sekolah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Hapus Testimoni?',
            text: "Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-form').attr('action', url).submit();
            }
        })
    }
</script>
@endpush
