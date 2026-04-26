<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
    <!-- Background Decorations -->
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-[500px] h-[500px] bg-orange-50 rounded-full blur-3xl opacity-60"></div>

    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 text-orange-600 text-sm font-bold mb-8">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-600"></span>
                    </span>
                    {{ $landingSettings['hero_badge'] ?? 'Solusi PPDB Sekolah Modern' }}
                </div>
 
                <h1 class="text-5xl lg:text-7xl font-extrabold leading-[1.1] text-slate-900 mb-8 tracking-tight">
                    @php
                        $title = $landingSettings['hero_title'] ?? 'Masih Ribet Urus PPDB Manual?';
                        $words = explode(' ', $title);
                        $lastWord = array_pop($words);
                        $mainTitle = implode(' ', $words);
                    @endphp
                    {{ $mainTitle }} <br>
                    <span class="gradient-text">{{ $lastWord }}</span>
                </h1>
 
                <p class="text-slate-500 text-lg lg:text-xl mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    {{ $landingSettings['hero_description'] ?? 'Form kertas hilang, data berantakan, atau calon siswa bingung daftar? Saatnya upgrade ke sistem PPDB online yang rapi, cepat, dan profesional.' }}
                </p>
 
                <ul class="mb-10 space-y-3 text-slate-600 font-medium text-left inline-block lg:block">
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-green-500 font-bold">check_circle</span> Pendaftaran 100% Online</li>
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-green-500 font-bold">check_circle</span> Data Otomatis Tersimpan & Aman</li>
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-green-500 font-bold">check_circle</span> Calon Siswa Bisa Daftar dari Rumah</li>
                </ul>
 
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('school.register') }}" class="btn-premium text-white px-10 py-5 rounded-2xl font-bold text-lg soft-shadow flex items-center justify-center gap-2 group">
                        {{ $landingSettings['hero_cta'] ?? '🚀 Mulai Digital Sekarang' }}
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                    <a href="{{ $landingSettings['hero_video_url'] ?? '#' }}" target="_blank" class="bg-white border border-slate-200 text-slate-700 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-slate-50 transition-colors flex items-center justify-center gap-2">
                        <i class="fab fa-youtube text-red-600"></i> Lihat Demo
                    </a>
                </div>

                <p class="mt-8 text-sm font-bold text-slate-400 flex items-center justify-center lg:justify-start gap-2 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-indigo-500">timer</span>
                    Setup cepat hanya 1 hari • Tanpa ribet
                </p>
            </div>

            <div class="relative group">
                <div class="absolute -top-12 -right-12 w-64 h-64 hero-blob blur-[100px] rounded-full opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-white/50 backdrop-blur-sm p-4 rounded-[2.5rem] soft-shadow border border-white/50 float-animation">
                    <img src="{{ asset('saas_hero_dashboard_1776911874930.png') }}" alt="Platform Dashboard" class="rounded-[2rem] w-full shadow-2xl border border-slate-100">
                    
                    <div class="absolute -bottom-6 -left-6 bg-white p-5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                            <span class="material-symbols-outlined">bolt</span>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Efisiensi Kerja</div>
                            <div class="text-xl font-black text-slate-900">Naik 10x Lipat</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
