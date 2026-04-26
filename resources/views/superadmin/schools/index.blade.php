@extends('superadmin.layouts.app')

@section('title', 'Manajemen Sekolah')
@section('header', 'Daftar Seluruh Sekolah')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Total: {{ $schools->total() }} Sekolah</h3>
                <div class="card-tools">
                    <a href="{{ route('superadmin.schools.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius: 50px;">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Sekolah Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-valign-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4">Sekolah</th>
                                <th>Info Kontak</th>
                                <th>NPSN</th>
                                <th class="text-center">Admin / Batch</th>
                                <th class="text-center">Status</th>
                                <th class="text-right px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schools as $school)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            @if($school->logo)
                                                <img src="{{ asset('storage/' . $school->logo) }}" class="img-circle border shadow-sm mr-3" style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="img-circle bg-indigo d-flex align-items-center justify-content-center mr-3 text-white shadow-sm" style="width: 45px; height: 45px; font-weight: bold;">
                                                    {{ substr($school->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-bold text-dark">{{ $school->name }}</span>
                                                <small class="text-muted"><i class="fas fa-link mr-1"></i> /{{ $school->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <i class="fas fa-envelope mr-1 text-muted"></i> {{ $school->email }}
                                            <br>
                                            <i class="fas fa-phone mr-1 text-muted"></i> {{ $school->phone ?? '-' }}
                                        </div>
                                    </td>
                                    <td><span class="badge badge-light border">{{ $school->npsn ?? '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ $school->users_count }} Admins</span>
                                        <br>
                                        <span class="badge badge-secondary">{{ $school->admission_batches_count }} Batches</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('superadmin.schools.toggle-status', $school->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $school->is_active ? 'btn-success' : 'btn-danger' }} px-3 shadow-none" style="border-radius: 50px; font-size: 11px; font-weight: bold;">
                                                {{ $school->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-right px-4">
                                        <div class="btn-group">
                                            <a href="{{ route('superadmin.schools.edit', $school->id) }}" class="btn btn-light btn-sm shadow-sm border mr-2" style="border-radius: 50px;">
                                                <i class="fas fa-edit mr-1 text-primary"></i> Edit
                                            </a>
                                            <form action="{{ route('superadmin.schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Hapus sekolah ini? Data terkait juga akan hilang!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm shadow-sm border" style="border-radius: 50px;">
                                                    <i class="fas fa-trash mr-1 text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada sekolah terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($schools->hasPages())
            <div class="card-footer bg-white border-top-0">
                <div class="float-right">
                    {{ $schools->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
