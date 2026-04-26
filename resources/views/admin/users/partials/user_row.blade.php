<tr>
    <td class="text-center text-muted small">{{ $user->id }}</td>
    <td>
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-circle" style="width: 32px; height: 32px; object-fit: cover;">
        @else
            <div class="img-circle bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 12px; color: #666;">
                {{ substr($user->name, 0, 1) }}
            </div>
        @endif
    </td>
    <td>
        <span class="font-weight-bold d-block text-dark">{{ $user->name }}</span>
        @if($user->id === auth()->id())
            <span class="badge badge-info text-xs">SAYA</span>
        @endif
        @if($user->id === 1)
            <span class="badge badge-danger text-xs">ROOT ADMIN</span>
        @endif
    </td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone ?: '-' }}</td>
    <td>
        @php
            $roleClass = [
                'admin_school' => 'badge-primary',
                'staff' => 'badge-info',
                'applicant' => 'badge-light border'
            ][$user->role] ?? 'badge-secondary';
            
            $roleLabel = [
                'admin_school' => 'ADMIN SEKOLAH',
                'staff' => 'STAFF / PANITIA',
                'applicant' => 'PENDAFTAR'
            ][$user->role] ?? $user->role;
        @endphp
        <span class="badge {{ $roleClass }} px-2 py-1">{{ $roleLabel }}</span>
    </td>
    <td class="text-right pr-4">
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-warning shadow-none" 
                data-toggle="modal" 
                data-target="#modalEditUser{{ $user->id }}">
                <i class="fas fa-edit"></i>
            </button>
            
            @if($user->id !== 1 && $user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline ml-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger shadow-none" onclick="return confirm('Hapus pengguna ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @else
                <button class="btn btn-sm btn-outline-secondary shadow-none ml-1 disabled" title="Tidak dapat dihapus (Proteksi Sistem / Akun Sendiri)" disabled>
                    <i class="fas fa-trash"></i>
                </button>
            @endif
        </div>

        <!-- Modal Edit User -->
        <div class="modal fade text-left" id="modalEditUser{{ $user->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title font-weight-bold">Edit Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email (Username)</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon (WhatsApp)</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label>Role / Akses</label>
                            <select name="role" class="form-control" required>
                                <option value="admin_school" {{ $user->role == 'admin_school' ? 'selected' : '' }}>Admin Sekolah</option>
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff / Panitia</option>
                                @if($user->role == 'applicant')
                                <option value="applicant" selected>Pendaftar</option>
                                @endif
                            </select>
                            @if($user->role == 'applicant')
                                <small class="form-text text-danger"><i class="fas fa-exclamation-circle"></i> Akun pendaftar sebaiknya tidak diubah rolenya.</small>
                            @endif
                        </div>
                        <hr>
                        <div class="form-group mb-0">
                            <label>Ganti Password (Kosongkan jika tidak ingin diganti)</label>
                            <input type="password" name="password" class="form-control mb-2" placeholder="Password baru">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning font-weight-bold px-4 shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </td>
</tr>
