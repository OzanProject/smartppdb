@extends('public.layouts.marketing')

@section('title', 'Solusi Digital PPDB')

@section('content')
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-6 relative text-center">
        <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mb-8 tracking-tight">Solusi End-to-End <br> <span class="gradient-text">Digitalisasi Sekolah</span></h1>
        <p class="text-slate-500 text-lg lg:text-xl leading-relaxed max-w-3xl mx-auto mb-20">
            Kami menyediakan ekosistem digital yang dirancang khusus untuk memenuhi kebutuhan administrasi sekolah modern di Indonesia.
        </p>

        <div class="grid md:grid-cols-2 gap-8 text-left">
            <!-- Solusi 1 -->
            <div class="group p-10 lg:p-16 rounded-[3rem] bg-slate-50 border border-transparent hover:border-indigo-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center text-white mb-10 shadow-xl shadow-indigo-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-4xl">web</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 mb-6">Landing Page Sekolah</h3>
                <p class="text-slate-500 text-lg leading-relaxed mb-8">
                    Hadirkan citra profesional sekolah Anda dengan landing page khusus yang menampilkan profil, keunggulan, dan informasi pendaftaran yang terintegrasi.
                </p>
                <ul class="space-y-4 text-slate-600 font-semibold">
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Domain Khusus Sekolah</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Desain Responsif & Modern</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Galeri Kegiatan & Fasilitas</li>
                </ul>
            </div>

            <!-- Solusi 2 -->
            <div class="group p-10 lg:p-16 rounded-[3rem] bg-slate-50 border border-transparent hover:border-orange-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center text-white mb-10 shadow-xl shadow-orange-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-4xl">app_registration</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 mb-6">Pendaftaran Online</h3>
                <p class="text-slate-500 text-lg leading-relaxed mb-8">
                    Proses pendaftaran yang sangat mudah bagi calon siswa. Orang tua dapat mengisi data dan mengunggah berkas syarat pendaftaran langsung dari smartphone.
                </p>
                <ul class="space-y-4 text-slate-600 font-semibold">
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Formulir Dinamis</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Upload Dokumen PDF/Gambar</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Cetak Invoice & Kartu Ujian</li>
                </ul>
            </div>

            <!-- Solusi 3 -->
            <div class="group p-10 lg:p-16 rounded-[3rem] bg-slate-50 border border-transparent hover:border-blue-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-20 h-20 bg-blue-600 rounded-3xl flex items-center justify-center text-white mb-10 shadow-xl shadow-blue-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-4xl">verified</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 mb-6">Sistem Verifikasi</h3>
                <p class="text-slate-500 text-lg leading-relaxed mb-8">
                    Mudahkan panitia PPDB dalam memverifikasi berkas pendaftar. Tidak perlu lagi bertatap muka, semua verifikasi dilakukan secara digital di dashboard admin.
                </p>
                <ul class="space-y-4 text-slate-600 font-semibold">
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Review Berkas Sekali Klik</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Notifikasi Status via Email/WA</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Pengelolaan Kelulusan Kolektif</li>
                </ul>
            </div>

            <!-- Solusi 4 -->
            <div class="group p-10 lg:p-16 rounded-[3rem] bg-slate-50 border border-transparent hover:border-purple-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-20 h-20 bg-purple-600 rounded-3xl flex items-center justify-center text-white mb-10 shadow-xl shadow-purple-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-4xl">analytics</span>
                </div>
                <h3 class="text-3xl font-bold text-slate-900 mb-6">Analisis Data</h3>
                <p class="text-slate-500 text-lg leading-relaxed mb-8">
                    Pantau statistik pendaftaran secara real-time. Dapatkan laporan lengkap untuk kebutuhan evaluasi dan pelaporan ke dinas terkait secara instan.
                </p>
                <ul class="space-y-4 text-slate-600 font-semibold">
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Grafik Pertumbuhan Pendaftar</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Export Excel & PDF Laporan</li>
                    <li class="flex items-center gap-3"><i class="fas fa-check-circle text-green-500"></i> Database Terstruktur & Aman</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@include('public.partials.pricing')
@endsection
