@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('header', 'Manajemen Pengguna Sekolah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @php
            $staffs = $users->filter(fn($user) => in_array($user->role, ['admin_school', 'staff', 'superadmin']));
            $applicants = $users->filter(fn($user) => $user->role === 'applicant');
        @endphp

        <div class="card card-primary card-outline card-outline-tabs shadow-sm">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="user-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="tab-staff-link" data-toggle="pill" href="#tab-staff" role="tab">
                            <i class="fas fa-user-tie mr-1"></i> Staff / Panitia
                            <span class="badge badge-primary ml-1">{{ $staffs->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="tab-applicant-link" data-toggle="pill" href="#tab-applicant" role="tab">
                            <i class="fas fa-users mr-1"></i> Akun Pendaftar
                            <span class="badge badge-secondary ml-1">{{ $applicants->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item ml-auto pr-3 pt-2 pb-2">
                        <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalAddUser">
                            <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="user-tabs-content">
                    
                    <!-- TAB PANITIA / STAFF -->
                    <div class="tab-pane fade show active" id="tab-staff" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-valign-middle m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px" class="text-center">ID</th>
                                        <th style="width: 40px"></th>
                                        <th>Nama Lengkap</th>
                                        <th>Email / Akun</th>
                                        <th>Telepon</th>
                                        <th>Role</th>
                                        <th class="text-right pr-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($staffs as $user)
                                        @include('admin.users.partials.user_row', ['user' => $user])
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-user-tie fa-3x mb-3 opacity-25"></i>
                                                <p>Belum ada staff tambahan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB PENDAFTAR -->
                    <div class="tab-pane fade" id="tab-applicant" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped table-valign-middle m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px" class="text-center">ID</th>
                                        <th style="width: 40px"></th>
                                        <th>Nama Lengkap</th>
                                        <th>Email / Akun</th>
                                        <th>Telepon</th>
                                        <th>Role</th>
                                        <th class="text-right pr-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($applicants as $user)
                                        @include('admin.users.partials.user_row', ['user' => $user])
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                                <p>Belum ada pendaftar yang memiliki akun.</p>
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
    </div>
</div>

<!-- Modal Add User -->
<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label>Email (Username)</label>
                    <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon (WhatsApp)</label>
                    <input type="text" name="phone" class="form-control" placeholder="Contoh: 081234xxx">
                </div>
                <div class="form-group">
                    <label>Role / Akses</label>
                    <select name="role" class="form-control" required>
                        <option value="admin_school">Admin Sekolah</option>
                        <option value="staff" selected>Staff / Panitia</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
