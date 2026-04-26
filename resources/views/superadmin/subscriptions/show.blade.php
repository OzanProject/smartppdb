@extends('superadmin.layouts.app')

@section('title', 'Detail Langganan')
@section('header', 'Detail Langganan: ' . $subscription->invoice_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-file-invoice mr-2 text-primary"></i>Informasi Invoice</h3>
            </div>
            <div class="card-body px-4">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th class="text-muted" width="40%">Invoice</th><td><code class="font-weight-bold">{{ $subscription->invoice_number }}</code></td></tr>
                            <tr><th class="text-muted">Sekolah</th><td>{{ $subscription->school->name }}</td></tr>
                            <tr><th class="text-muted">Paket</th><td><span class="badge badge-light border">{{ $subscription->pricingPlan->name }}</span></td></tr>
                            <tr><th class="text-muted">Nominal</th><td class="font-weight-bold text-success">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr><th class="text-muted" width="40%">Metode</th><td>{{ $subscription->payment_method == 'manual_transfer' ? 'Transfer Manual' : 'Payment Gateway' }}</td></tr>
                            <tr><th class="text-muted">Status</th><td><span class="badge badge-{{ $subscription->status_color }} px-3 py-2">{{ $subscription->status_label }}</span></td></tr>
                            <tr><th class="text-muted">Tanggal Order</th><td>{{ $subscription->created_at->format('d M Y H:i') }}</td></tr>
                            @if($subscription->paid_at)
                            <tr><th class="text-muted">Tanggal Bayar</th><td>{{ $subscription->paid_at->format('d M Y H:i') }}</td></tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($subscription->notes)
                <div class="callout callout-info">
                    <h6 class="font-weight-bold">Catatan Sekolah:</h6>
                    <p class="mb-0">{{ $subscription->notes }}</p>
                </div>
                @endif

                @if($subscription->admin_notes)
                <div class="callout callout-warning">
                    <h6 class="font-weight-bold">Catatan Admin:</h6>
                    <p class="mb-0">{{ $subscription->admin_notes }}</p>
                </div>
                @endif

                @if($subscription->status == 'active')
                <div class="callout callout-success">
                    <h6 class="font-weight-bold mb-1">Periode Aktif</h6>
                    <p class="mb-0">{{ $subscription->starts_at?->format('d M Y') }} — {{ $subscription->ends_at?->format('d M Y') }}</p>
                    <small class="text-muted">Dikonfirmasi oleh: {{ $subscription->confirmedBy->name ?? '-' }} pada {{ $subscription->confirmed_at?->format('d M Y H:i') }}</small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Payment Proof --}}
        @if($subscription->payment_proof)
        <div class="card card-outline card-info shadow-sm border-0 mb-3" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-receipt mr-2 text-info"></i>Bukti Pembayaran</h3>
            </div>
            <div class="card-body px-4 text-center">
                <a href="{{ asset('storage/' . $subscription->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/' . $subscription->payment_proof) }}" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </a>
                <p class="text-muted mt-2 mb-0"><small>Klik gambar untuk memperbesar</small></p>
            </div>
        </div>
        @endif

        {{-- Action Buttons --}}
        @if(in_array($subscription->status, ['paid', 'pending_payment']))
        <div class="card card-outline card-success shadow-sm border-0 mb-3" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-gavel mr-2 text-success"></i>Tindakan</h3>
            </div>
            <div class="card-body px-4">
                {{-- Confirm --}}
                <form action="{{ route('superadmin.subscriptions.confirm', $subscription) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="form-group">
                        <label>Catatan Admin (Opsional)</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Pembayaran diterima via BCA..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-block font-weight-bold" onclick="return confirm('Yakin ingin mengkonfirmasi dan mengaktifkan langganan ini?')">
                        <i class="fas fa-check mr-1"></i> Konfirmasi & Aktifkan
                    </button>
                </form>
                <hr>
                {{-- Reject --}}
                <form action="{{ route('superadmin.subscriptions.reject', $subscription) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Bukti transfer tidak valid..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold" onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                        <i class="fas fa-times mr-1"></i> Tolak
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <a href="{{ route('superadmin.subscriptions.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Langganan</a>
    <a href="{{ route('superadmin.subscriptions.print', $subscription) }}" class="btn btn-info" target="_blank"><i class="fas fa-print mr-1"></i> Cetak Invoice</a>
</div>
@endsection
