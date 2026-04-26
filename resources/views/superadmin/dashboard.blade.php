@extends('superadmin.layouts.app')

@section('title', 'SuperAdmin Dashboard')
@section('header', 'Statistik Global')

@section('content')
<div class="row">
    <!-- Stat Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border" style="border-radius: 15px; overflow: hidden;">
            <div class="inner p-4">
                <p class="text-muted text-uppercase text-xs font-weight-bold mb-1 tracking-widest">Total Sekolah</p>
                <h3 class="font-weight-bold mb-0">{{ number_format($stats['schools_count']) }}</h3>
            </div>
            <div class="icon text-primary opacity-25">
                <i class="fas fa-university fa-2x" style="top: 25px; right: 25px;"></i>
            </div>
            <a href="{{ route('superadmin.schools.index') }}" class="small-box-footer bg-light py-2 text-primary">Selengkapnya <i class="fas fa-arrow-circle-right ml-1"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border" style="border-radius: 15px; overflow: hidden;">
            <div class="inner p-4">
                <p class="text-muted text-uppercase text-xs font-weight-bold mb-1 tracking-widest">Pendaftar Global</p>
                <h3 class="font-weight-bold mb-0">{{ number_format($stats['total_registrations']) }}</h3>
            </div>
            <div class="icon text-success opacity-25">
                <i class="fas fa-user-graduate fa-2x" style="top: 25px; right: 25px;"></i>
            </div>
            <div class="small-box-footer bg-light py-2 text-success italic text-xs">Total Siswa Terdaftar</div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border" style="border-radius: 15px; overflow: hidden;">
            <div class="inner p-4">
                <p class="text-muted text-uppercase text-xs font-weight-bold mb-1 tracking-widest">Langganan Aktif</p>
                <h3 class="font-weight-bold mb-0">{{ number_format($stats['active_subscriptions']) }}</h3>
            </div>
            <div class="icon text-warning opacity-25">
                <i class="fas fa-crown fa-2x" style="top: 25px; right: 25px;"></i>
            </div>
            <a href="{{ route('superadmin.subscriptions.index') }}" class="small-box-footer bg-light py-2 text-warning">Invoice Management <i class="fas fa-arrow-circle-right ml-1"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border" style="border-radius: 15px; overflow: hidden;">
            <div class="inner p-4">
                <p class="text-muted text-uppercase text-xs font-weight-bold mb-1 tracking-widest">Total Pendapatan</p>
                <h3 class="font-weight-bold mb-0 text-success">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            </div>
            <div class="icon text-success opacity-25">
                <i class="fas fa-wallet fa-2x" style="top: 25px; right: 25px;"></i>
            </div>
            <div class="small-box-footer bg-light py-2 text-muted italic text-xs">Akumulasi Pembayaran</div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-8">
        <div class="card card-outline card-primary shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-chart-bar mr-2 text-primary"></i> Sekolah dengan Pendaftar Terbanyak</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="pl-4 py-3 text-xs font-weight-bold text-uppercase tracking-wider">Sekolah</th>
                                <th class="py-3 text-xs font-weight-bold text-uppercase tracking-wider text-center">Pendaftar</th>
                                <th class="py-3 text-xs font-weight-bold text-uppercase tracking-wider text-center">Admin</th>
                                <th class="pr-4 py-3 text-xs font-weight-bold text-uppercase tracking-wider text-right">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schoolStats as $school)
                                <tr>
                                    <td class="pl-4 py-3 font-weight-bold text-dark">{{ $school->name }}</td>
                                    <td class="py-3 text-center">
                                        <span class="badge badge-primary-soft px-3 py-1">{{ $school->registrations_count }} Siswa</span>
                                    </td>
                                    <td class="py-3 text-center text-muted text-sm">{{ $school->users_count }} Akun</td>
                                    <td class="pr-4 py-3 text-right">
                                        <div class="progress progress-xxs mb-0" style="width: 80px; display: inline-block;">
                                            <div class="progress-bar bg-primary" style="width: {{ min(100, $school->registrations_count > 0 ? 80 : 0) }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-outline card-info shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h3 class="card-title font-weight-bold"><i class="fas fa-history mr-2 text-info"></i> Sekolah Baru</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($recentSchools as $school)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-info-soft rounded-lg p-2 mr-3 text-info">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-weight-bold mb-0">{{ Str::limit($school->name, 25) }}</div>
                                    <div class="text-xs text-muted">{{ $school->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <a href="{{ route('superadmin.schools.index') }}" class="btn btn-xs btn-light rounded-circle shadow-sm">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 text-center pb-4 pt-0">
                <a href="{{ route('superadmin.schools.index') }}" class="text-xs font-weight-bold text-info uppercase tracking-widest">Lihat Semua Sekolah <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(0, 123, 255, 0.1); color: #007bff; }
    .bg-info-soft { background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .progress-xxs { height: 4px; }
    .rounded-xl { border-radius: 15px !important; }
</style>
@endsection
