@extends('admin.layouts.app')

@section('title', 'Checkout Paket')
@section('header', 'Checkout: ' . $plan->name)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions.index') }}">Langganan</a></li>
  <li class="breadcrumb-item active">Checkout</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
            <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pricing_plan_id" value="{{ $plan->id }}">

                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-shopping-cart mr-2 text-primary"></i>Ringkasan Pesanan</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    {{-- Order Summary --}}
                    <div class="callout callout-info">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="font-weight-bold mb-1">{{ $plan->name }}</h5>
                                <p class="text-muted mb-0">{{ $plan->description }}</p>
                                <ul class="list-unstyled mt-2 mb-0">
                                    @foreach($plan->features_list as $feature)
                                    <li><i class="fas fa-check text-success mr-1"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4 text-right">
                                <h3 class="font-weight-bold text-primary mb-0">{{ $plan->price_display }}</h3>
                                <small class="text-muted">
                                    @if($plan->billing_cycle == 'monthly') /bulan 
                                    @elseif($plan->billing_cycle == 'yearly') /tahun 
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <h6 class="font-weight-bold mb-3"><i class="fas fa-credit-card mr-2"></i>Pilih Metode Pembayaran</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card border shadow-sm mb-0" style="border-radius: 12px; cursor: pointer;" onclick="document.getElementById('methodTransfer').checked = true;">
                                <div class="card-body p-3 text-center">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="payment_method" id="methodTransfer" value="manual_transfer" checked>
                                        <label class="custom-control-label w-100" for="methodTransfer">
                                            <i class="fas fa-university fa-2x text-primary mb-2 d-block"></i>
                                            <strong>Transfer Bank</strong>
                                            <br><small class="text-muted">Transfer manual & upload bukti</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border shadow-sm mb-0" style="border-radius: 12px; {{ ($paymentSettings['enable_gateway'] ?? '0') != '1' ? 'opacity: 0.5; pointer-events: none;' : 'cursor: pointer;' }}" onclick="{{ ($paymentSettings['enable_gateway'] ?? '0') == '1' ? 'document.getElementById(\'methodGateway\').checked = true;' : '' }}">
                                <div class="card-body p-3 text-center">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="payment_method" id="methodGateway" value="payment_gateway" {{ ($paymentSettings['enable_gateway'] ?? '0') != '1' ? 'disabled' : '' }}>
                                        <label class="custom-control-label w-100" for="methodGateway">
                                            <i class="fas fa-bolt fa-2x text-warning mb-2 d-block"></i>
                                            <strong>Payment Gateway</strong>
                                            <br><small class="text-muted">{{ ($paymentSettings['enable_gateway'] ?? '0') != '1' ? 'Segera hadir' : 'Bayar otomatis' }}</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Informasi tambahan untuk admin...">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-primary btn-block py-3 shadow-sm font-weight-bold" style="border-radius: 12px;">
                        <i class="fas fa-paper-plane mr-1"></i> BUAT PESANAN
                    </button>
                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-link btn-block text-muted">Batal & Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
