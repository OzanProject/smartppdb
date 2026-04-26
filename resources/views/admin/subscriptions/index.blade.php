@extends('admin.layouts.app')

@section('title', 'Langganan & Paket')
@section('header', 'Langganan & Paket')

@section('breadcrumb')
  <li class="breadcrumb-item active">Langganan</li>
@endsection

@section('content')

{{-- Current Plan Info --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-gradient-primary text-white shadow border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="font-weight-bold mb-1"><i class="fas fa-crown mr-2"></i>Paket Aktif Anda</h4>
                        <h2 class="font-weight-bold mb-2">{{ $currentPlan->name ?? 'Belum Ada Paket' }}</h2>
                        <p class="mb-0 opacity-75">{{ $currentPlan->description ?? 'Silakan pilih paket untuk mengaktifkan fitur lengkap.' }}</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <h3 class="font-weight-bold">{{ $currentPlan->price_display ?? '-' }}</h3>
                        <small class="opacity-75">/ tahun</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Available Plans --}}
<h5 class="font-weight-bold mb-3"><i class="fas fa-tags mr-2 text-warning"></i>Pilih Paket Langganan</h5>
<div class="row mb-4">
    @foreach($plans as $plan)
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100 {{ $currentPlan && $currentPlan->id == $plan->id ? 'border-left border-primary' : '' }}" style="border-radius: 15px; {{ $plan->is_popular ? 'border: 2px solid #007bff;' : '' }}">
            @if($plan->is_popular)
            <div class="ribbon-wrapper ribbon-lg">
                <div class="ribbon bg-primary">Populer</div>
            </div>
            @endif
            <div class="card-body p-4">
                <h5 class="font-weight-bold">{{ $plan->name }}</h5>
                <h3 class="text-primary font-weight-bold my-3">
                    {{ $plan->price_display }} 
                    <small class="text-muted font-weight-normal" style="font-size: 14px;">
                        @if($plan->billing_cycle == 'monthly') /bulan 
                        @elseif($plan->billing_cycle == 'yearly') /tahun 
                        @endif
                    </small>
                </h3>
                <p class="text-muted">{{ $plan->description }}</p>
                <hr>
                <ul class="list-unstyled mb-4">
                    @foreach($plan->features_list as $feature)
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>{{ $feature }}</li>
                    @endforeach
                </ul>

                @if($currentPlan && $currentPlan->id == $plan->id)
                    <button class="btn btn-secondary btn-block" disabled style="border-radius: 10px;">
                        <i class="fas fa-check mr-1"></i> Paket Aktif Anda
                    </button>
                @elseif($plan->price_display == 'Gratis')
                    <button class="btn btn-outline-secondary btn-block" disabled style="border-radius: 10px;">
                        Paket Gratis
                    </button>
                @else
                    <a href="{{ route('admin.subscriptions.checkout', $plan) }}" class="btn btn-primary btn-block font-weight-bold" style="border-radius: 10px;">
                        <i class="fas fa-shopping-cart mr-1"></i> Pilih Paket Ini
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Subscription History --}}
<h5 class="font-weight-bold mb-3"><i class="fas fa-history mr-2 text-info"></i>Riwayat Langganan</h5>
<div class="card card-outline card-info shadow-sm border-0" style="border-radius: 15px;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Invoice</th>
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
                    <td>{{ $sub->pricingPlan->name ?? '-' }}</td>
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
                        <a href="{{ route('admin.subscriptions.invoice', $sub) }}" class="btn btn-sm btn-outline-primary" title="Lihat Invoice">
                            <i class="fas fa-file-invoice"></i>
                        </a>
                        <a href="{{ route('admin.subscriptions.print', $sub) }}" class="btn btn-sm btn-outline-info" title="Cetak Invoice" target="_blank">
                            <i class="fas fa-print"></i>
                        </a>
                        @if(in_array($sub->status, ['pending_payment', 'cancelled']))
                        <form action="{{ route('admin.subscriptions.destroy', $sub) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Belum ada riwayat langganan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
