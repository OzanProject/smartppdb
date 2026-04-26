@extends('superadmin.layouts.app')

@section('title', 'Manajemen Langganan')
@section('header', 'Manajemen Langganan Sekolah')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" class="form-inline">
            <div class="input-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="Cari invoice / sekolah..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <select name="status" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Dibayar (Perlu Konfirmasi)</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </form>
    </div>
    <div class="col-md-4 text-right">
        <a href="{{ route('superadmin.payment-settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-cog mr-1"></i> Pengaturan Pembayaran
        </a>
    </div>
</div>

<div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Invoice</th>
                    <th>Sekolah</th>
                    <th>Paket</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $sub)
                <tr>
                    <td><code class="font-weight-bold">{{ $sub->invoice_number }}</code></td>
                    <td>{{ $sub->school->name ?? '-' }}</td>
                    <td><span class="badge badge-pill badge-light border">{{ $sub->pricingPlan->name ?? '-' }}</span></td>
                    <td>Rp {{ number_format($sub->amount, 0, ',', '.') }}</td>
                    <td>
                        @if($sub->payment_method == 'manual_transfer')
                            <span class="badge badge-secondary"><i class="fas fa-university mr-1"></i>Transfer</span>
                        @else
                            <span class="badge badge-info"><i class="fas fa-bolt mr-1"></i>Gateway</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $sub->status_color }}">{{ $sub->status_label }}</span></td>
                    <td><small>{{ $sub->created_at->format('d M Y H:i') }}</small></td>
                    <td class="text-center">
                        <a href="{{ route('superadmin.subscriptions.show', $sub) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('superadmin.subscriptions.print', $sub) }}" class="btn btn-sm btn-outline-info" title="Cetak Invoice" target="_blank">
                            <i class="fas fa-print"></i>
                        </a>
                        <form action="{{ route('superadmin.subscriptions.destroy', $sub) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data langganan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Belum ada data langganan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subscriptions->hasPages())
    <div class="card-footer bg-transparent">
        {{ $subscriptions->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
