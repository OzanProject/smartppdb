@extends('admin.layouts.app')

@section('title', 'Invoice ' . $subscription->invoice_number)
@section('header', 'Invoice: ' . $subscription->invoice_number)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions.index') }}">Langganan</a></li>
  <li class="breadcrumb-item active">Invoice</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        {{-- Invoice Card --}}
        <div class="card shadow-sm border-0" style="border-radius: 15px;" id="invoiceCard">
            <div class="card-body p-4">
                {{-- Header --}}
                <div class="row mb-4">
                    <div class="col-6">
                        <h4 class="font-weight-bold text-primary mb-0">INVOICE</h4>
                        <code class="font-weight-bold">{{ $subscription->invoice_number }}</code>
                    </div>
                    <div class="col-6 text-right">
                        <span class="badge badge-{{ $subscription->status_color }} px-3 py-2" style="font-size: 14px;">{{ $subscription->status_label }}</span>
                    </div>
                </div>
                <hr>

                {{-- Billing Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Ditagihkan Kepada:</h6>
                        <strong>{{ $subscription->school->name }}</strong><br>
                        <small class="text-muted">{{ $subscription->school->email }}<br>{{ $subscription->school->phone }}</small>
                    </div>
                    <div class="col-md-6 text-right">
                        <h6 class="text-muted mb-2">Tanggal Invoice:</h6>
                        <strong>{{ $subscription->created_at->format('d M Y') }}</strong>
                    </div>
                </div>

                {{-- Items --}}
                <table class="table table-bordered mb-4">
                    <thead class="bg-light">
                        <tr>
                            <th>Deskripsi</th>
                            <th class="text-center">Periode</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Paket {{ $subscription->pricingPlan->name }}</strong><br>
                                <small class="text-muted">{{ $subscription->pricingPlan->description }}</small>
                            </td>
                            <td class="text-center">
                                @if($subscription->pricingPlan->billing_cycle == 'monthly') 1 Bulan
                                @elseif($subscription->pricingPlan->billing_cycle == 'yearly') 1 Tahun
                                @else Sekali Bayar
                                @endif
                            </td>
                            <td class="text-right font-weight-bold">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <td colspan="2" class="text-right font-weight-bold">TOTAL</td>
                            <td class="text-right font-weight-bold text-primary" style="font-size: 18px;">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Bank Info (for manual transfer) --}}
                @if($subscription->payment_method == 'manual_transfer' && in_array($subscription->status, ['pending_payment']))
                <div class="callout callout-warning">
                    <h6 class="font-weight-bold"><i class="fas fa-university mr-1"></i> Informasi Rekening Transfer</h6>
                    <table class="table table-sm table-borderless mb-2">
                        <tr><td width="130"><strong>Bank</strong></td><td>: {{ $paymentSettings['bank_name'] ?? '-' }}</td></tr>
                        <tr><td><strong>No. Rekening</strong></td><td>: <code class="font-weight-bold" style="font-size: 16px;">{{ $paymentSettings['bank_account_number'] ?? '-' }}</code></td></tr>
                        <tr><td><strong>Atas Nama</strong></td><td>: {{ $paymentSettings['bank_account_name'] ?? '-' }}</td></tr>
                    </table>
                    @if(!empty($paymentSettings['payment_instructions']))
                    <hr>
                    <small class="text-muted">{!! nl2br(e($paymentSettings['payment_instructions'])) !!}</small>
                    @endif
                </div>
                @endif

                {{-- Admin Notes --}}
                @if($subscription->admin_notes)
                <div class="callout callout-{{ $subscription->status == 'cancelled' ? 'danger' : 'info' }}">
                    <h6 class="font-weight-bold">Catatan dari Admin:</h6>
                    <p class="mb-0">{{ $subscription->admin_notes }}</p>
                </div>
                @endif

                {{-- Active Period --}}
                @if($subscription->status == 'active')
                <div class="callout callout-success">
                    <h6 class="font-weight-bold">Periode Aktif</h6>
                    <p class="mb-0">{{ $subscription->starts_at?->format('d M Y') }} — {{ $subscription->ends_at?->format('d M Y') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Upload Payment Proof --}}
        @if(in_array($subscription->status, ['pending_payment', 'paid']))
        <div class="card card-outline card-success shadow-sm border-0 mt-3" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-upload mr-2 text-success"></i>Unggah Bukti Pembayaran</h3>
            </div>
            <div class="card-body px-4 pb-4">
                @if($subscription->payment_proof)
                <div class="text-center mb-3">
                    <p class="text-muted mb-2">Bukti pembayaran yang sudah diunggah:</p>
                    <img src="{{ asset('storage/' . $subscription->payment_proof) }}" alt="Bukti" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                </div>
                @endif

                <form action="{{ route('admin.subscriptions.upload-proof', $subscription) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ $subscription->payment_proof ? 'Ganti Bukti Pembayaran' : 'Pilih File Bukti Pembayaran' }} <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('payment_proof') is-invalid @enderror" id="paymentProof" name="payment_proof" accept="image/*" required>
                            <label class="custom-file-label" for="paymentProof">Pilih file (JPG/PNG, max 2MB)</label>
                            @error('payment_proof') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block font-weight-bold py-3" style="border-radius: 12px;">
                        <i class="fas fa-paper-plane mr-1"></i> KIRIM BUKTI PEMBAYARAN
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-link text-muted"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Langganan</a>
            <a href="{{ route('admin.subscriptions.print', $subscription) }}" class="btn btn-info" target="_blank"><i class="fas fa-print mr-1"></i> Cetak Invoice</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelector('.custom-file-input')?.addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || 'Pilih file';
        e.target.nextElementSibling.textContent = fileName;
    });
</script>
@endpush
