<footer class="bg-white py-20 border-t border-slate-100">
    <!-- Final CTA -->
    <div class="max-w-7xl mx-auto px-6 mb-32">
        <div class="bg-slate-900 rounded-[3rem] p-12 lg:p-24 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-orange-600 blur-[120px] opacity-20 -translate-x-1/2 translate-y-1/2"></div>
            
            <h2 class="text-4xl lg:text-6xl font-extrabold text-white mb-8 tracking-tight leading-tight relative">
                {!! str_replace('Sekolah Anda', '<span class="text-orange-400">Sekolah Anda</span>', $landingSettings['cta_title'] ?? 'Siap Digitalisasi PPDB Sekolah Anda?') !!}
            </h2>
            <p class="text-slate-400 text-xl mb-12 max-w-2xl mx-auto relative">{{ $landingSettings['cta_subtitle'] ?? 'Mulai sekarang sebelum gelombang pendaftaran dimulai. Berikan pengalaman terbaik bagi calon siswa Anda.' }}</p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center relative">
                <a href="{{ route('school.register') }}" class="bg-orange-500 text-white px-12 py-5 rounded-2xl font-bold text-xl shadow-xl shadow-orange-900/20 hover:scale-105 transition-all">{{ $landingSettings['cta_button_text'] ?? '🚀 Mulai Sekarang' }}</a>
                <p class="text-sm font-bold text-slate-500 tracking-widest uppercase italic">Tanpa biaya pendaftaran • Coba gratis 14 hari</p>
            </div>
        </div>
    </div>

    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-24">
        <!-- Column 1: Brand -->
        <div class="space-y-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if(!empty($landingSettings['app_logo']))
                    <img src="{{ asset('storage/' . $landingSettings['app_logo']) }}" alt="Logo" class="h-10 object-contain">
                @else
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined font-bold">school</span>
                    </div>
                @endif
                <span class="text-2xl font-black tracking-tighter text-slate-900">{{ $landingSettings['app_name'] ?? 'PPDB Pro' }}</span>
            </a>
            <p class="text-slate-500 text-sm leading-relaxed max-w-xs">
                {{ $landingSettings['hero_description'] ?? 'Platform SaaS pendaftaran sekolah terdepan di Indonesia. Kami membantu sekolah mendigitalisasi proses PPDB dengan teknologi modern.' }}
            </p>
            <div class="flex gap-3">
                @if(!empty($landingSettings['app_facebook']))
                    <a href="{{ $landingSettings['app_facebook'] }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                @endif
                @if(!empty($landingSettings['app_instagram']))
                    <a href="{{ $landingSettings['app_instagram'] }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-pink-600 hover:text-white transition-all duration-300 shadow-sm" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
                @if(!empty($landingSettings['app_youtube']))
                    <a href="{{ $landingSettings['app_youtube'] }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                @endif
                @if(!empty($landingSettings['app_x']))
                    <a href="{{ $landingSettings['app_x'] }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-900 hover:text-white transition-all duration-300 shadow-sm" target="_blank">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                @endif
                @if(!empty($landingSettings['app_tiktok']))
                    <a href="{{ $landingSettings['app_tiktok'] }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-black hover:text-white transition-all duration-300 shadow-sm" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                @endif
                @if(!empty($landingSettings['app_linkedin']))
                    <a href="{{ $landingSettings['app_linkedin'] }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-700 hover:text-white transition-all duration-300 shadow-sm" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Column 2: Solusi -->
        <div>
            <h4 class="text-slate-900 font-bold uppercase tracking-widest text-xs mb-8">{{ $landingSettings['footer_solusi_title'] ?? 'Solusi' }}</h4>
            <ul class="space-y-4">
                <li><a href="{{ route('public.solusi') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Landing Page Sekolah</a></li>
                <li><a href="{{ route('public.solusi') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Pendaftaran Online</a></li>
                <li><a href="{{ route('public.solusi') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Sistem Verifikasi</a></li>
                <li><a href="{{ route('public.solusi') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Analisis Data</a></li>
            </ul>
        </div>

        <!-- Column 3: Perusahaan -->
        <div>
            <h4 class="text-slate-900 font-bold uppercase tracking-widest text-xs mb-8">{{ $landingSettings['footer_perusahaan_title'] ?? 'Perusahaan' }}</h4>
            <ul class="space-y-4">
                <li><a href="{{ route('public.about') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Tentang Kami</a></li>
                <li><a href="{{ route('public.contact') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Kontak</a></li>
                <li><a href="{{ route('public.privacy') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Kebijakan Privasi</a></li>
                <li><a href="{{ route('public.terms') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-medium transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-slate-200 rounded-full group-hover:bg-indigo-600 transition-colors"></span> Syarat & Ketentuan</a></li>
            </ul>
        </div>

        <!-- Column 4: Kontak -->
        <div>
            <h4 class="text-slate-900 font-bold uppercase tracking-widest text-xs mb-8">Hubungi Kami</h4>
            <div class="space-y-6">
                @if(!empty($landingSettings['app_address']))
                    <div class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $landingSettings['app_address'] }}</p>
                    </div>
                @endif
                @if(!empty($landingSettings['app_phone']))
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <i class="fas fa-phone"></i>
                        </div>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $landingSettings['app_phone']) }}" class="text-slate-500 text-sm font-bold hover:text-indigo-600 transition-colors">{{ $landingSettings['app_phone'] }}</a>
                    </div>
                @endif
                @if(!empty($landingSettings['app_email']))
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <p class="text-slate-500 text-sm font-medium">{{ $landingSettings['app_email'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="max-w-7xl mx-auto px-6 pt-10 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex flex-col md:flex-row items-center gap-2 md:gap-6">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                {{ $landingSettings['footer_text'] ?? '© ' . date('Y') . ' ' . ($landingSettings['app_name'] ?? 'PPDB Pro') . ' Platform. All rights reserved.' }}
            </p>
            <span class="hidden md:block w-1 h-1 bg-slate-300 rounded-full"></span>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                Developed by <a href="https://ozanproject.site" target="_blank" class="text-indigo-600 hover:text-indigo-700 underline decoration-indigo-200 underline-offset-4">ozanproject.site</a>
            </p>
        </div>
        <div class="flex gap-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
            <a href="{{ route('public.privacy') }}" class="hover:text-indigo-600 transition-colors">Privacy</a>
            <a href="{{ route('public.terms') }}" class="hover:text-indigo-600 transition-colors">Terms</a>
        </div>
    </div>
</footer>
