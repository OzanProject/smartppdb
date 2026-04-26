@extends('superadmin.layouts.app')

@section('title', 'Manajemen Harga')
@section('header', 'Pengaturan Paket & Fitur')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-orange shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold">Daftar Paket Harga</h3>
                <div class="card-tools">
                    <a href="{{ route('superadmin.pricing-plans.create') }}" class="btn btn-orange px-4 shadow-sm text-white" style="border-radius: 50px; background-color: #f97316;">
                        <i class="fas fa-plus mr-1"></i> Tambah Paket Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-valign-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4" style="width: 50px;">Urutan</th>
                                <th>Nama Paket</th>
                                <th>Harga Display</th>
                                <th>Fitur Utama</th>
                                <th class="text-center">Status</th>
                                <th class="text-right px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plans as $plan)
                                <tr>
                                    <td class="px-4 text-center">
                                        <span class="badge badge-secondary">{{ $plan->order_weight }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold text-dark">{{ $plan->name }}</span>
                                            <small class="text-muted">{{ $plan->description }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="h6 mb-0 font-weight-bold text-orange" style="color: #f97316;">{{ $plan->price_display }}</span>
                                            <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">
                                                @if($plan->billing_cycle == 'monthly') BULANAN 
                                                @elseif($plan->billing_cycle == 'yearly') TAHUNAN 
                                                @else SEKALI BAYAR 
                                                @endif
                                            </small>
                                            @if($plan->trial_days > 0)
                                                <span class="badge badge-success text-xs mt-1" style="font-size: 10px;">Free Trial {{ $plan->trial_days }} Hari</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ count($plan->features_list) }} Fitur Terdaftar
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if($plan->is_popular)
                                            <span class="badge badge-warning text-white shadow-sm" style="background-color: #f59e0b;">TERLARIS</span>
                                        @else
                                            <span class="badge badge-light border">Reguler</span>
                                        @endif
                                    </td>
                                    <td class="text-right px-4">
                                        <div class="btn-group">
                                            <a href="{{ route('superadmin.pricing-plans.edit', $plan->id) }}" class="btn btn-light btn-sm shadow-sm border mr-2" style="border-radius: 50px;">
                                                <i class="fas fa-edit mr-1 text-primary"></i> Edit
                                            </a>
                                            <form action="{{ route('superadmin.pricing-plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
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
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada paket harga. Klik "Tambah Paket Baru" untuk memulai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
