<section id="solution" class="py-32 relative bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">
                {!! str_replace('1 Sistem', '<span class="text-indigo-600">1 Sistem</span>', $landingSettings['features_title'] ?? 'Solusi Lengkap dalam 1 Sistem') !!}
            </h2>
            <p class="text-slate-500 text-lg leading-relaxed">
                {{ $landingSettings['features_subtitle'] ?? 'Kami menghadirkan fitur-fitur tercanggih untuk memastikan PPDB sekolah Anda berjalan tanpa hambatan.' }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="group bg-slate-50 p-10 rounded-[2rem] border border-transparent hover:border-indigo-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-indigo-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">language</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ $landingSettings['feature_1_title'] ?? 'Pendaftaran Online' }}</h3>
                <p class="text-slate-500 leading-relaxed text-sm">{{ $landingSettings['feature_1_desc'] ?? 'Siswa dapat mendaftar dari mana saja dan kapan saja. Dilengkapi dengan upload dokumen otomatis yang aman.' }}</p>
            </div>

            <div class="group bg-slate-50 p-10 rounded-[2rem] border border-transparent hover:border-orange-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-16 h-16 bg-orange-500 text-white rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-orange-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">dashboard_customize</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ $landingSettings['feature_2_title'] ?? 'Dashboard Admin' }}</h3>
                <p class="text-slate-500 leading-relaxed text-sm">{{ $landingSettings['feature_2_desc'] ?? 'Kelola pendaftar, verifikasi berkas, hingga publikasi hasil seleksi dalam satu tampilan yang intuitif.' }}</p>
            </div>

            <div class="group bg-slate-50 p-10 rounded-[2rem] border border-transparent hover:border-blue-100 hover:bg-white hover:shadow-2xl transition-all duration-500">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-blue-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">summarize</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ $landingSettings['feature_3_title'] ?? 'Laporan Otomatis' }}</h3>
                <p class="text-slate-500 leading-relaxed text-sm">{{ $landingSettings['feature_3_desc'] ?? 'Dapatkan laporan statistik pendaftaran dan data siswa yang siap cetak (PDF/Excel) kapan saja dibutuhkan.' }}</p>
            </div>
        </div>
    </div>
</section>

