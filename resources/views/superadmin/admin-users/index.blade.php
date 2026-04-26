@extends('superadmin.layouts.app')

@section('title', 'Manajemen Admin')
@section('header', 'Pengaturan Akun Admin Sekolah')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Daftar Admin & Staff Sekolah</h3>
                <div class="card-tools">
                    <a href="{{ route('superadmin.admin-users.create') }}" class="btn btn-success px-4 shadow-sm" style="border-radius: 50px;">
                        <i class="fas fa-user-plus mr-1"></i> Buat Akun Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-valign-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4">Nama Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Sekolah Tugas</th>
                                <th class="text-right px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="img-circle bg-gradient-success d-flex align-items-center justify-content-center mr-3 text-white shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span class="font-weight-bold text-dark">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin_school')
                                            <span class="badge badge-primary px-3 py-2" style="border-radius: 8px;">ADMIN SEKOLAH</span>
                                        @else
                                            <span class="badge badge-info px-3 py-2" style="border-radius: 8px;">STAFF / PANITIA</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark font-weight-bold">{{ $user->school->name ?? 'Tidak Ada' }}</span>
                                            <small class="text-muted"><i class="fas fa-university mr-1"></i> {{ $user->school->npsn ?? '-' }}</small>
                                        </div>
                                    </td>
                                    <td class="text-right px-4">
                                        <div class="btn-group">
                                            <a href="{{ route('superadmin.admin-users.edit', $user->id) }}" class="btn btn-light btn-sm shadow-sm border mr-2" style="border-radius: 50px;">
                                                <i class="fas fa-key mr-1 text-primary"></i> Edit
                                            </a>
                                            <form action="{{ route('superadmin.admin-users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?')">
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
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada akun admin/staff.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
            <div class="card-footer bg-white">
                <div class="float-right">
                    {{ $users->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
