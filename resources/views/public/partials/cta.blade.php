<?php
/********************************************************************************
 * cta.blade.php
 * Call to Action partial for the landing page.
 * Content is dynamic and configurable via the Super Admin panel.
 ********************************************************************************/
?>
<section id="cta" class="py-24 bg-indigo-600 overflow-hidden relative">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[60%] bg-white rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[60%] bg-indigo-400 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight tracking-tight">
            {{ $settings['cta_title'] ?? 'Siap Digitalkan PPDB Sekolah Anda?' }}
        </h2>
        
        <p class="text-xl text-indigo-100 mb-10 leading-relaxed font-medium">
            {{ $settings['cta_subtitle'] ?? 'Bergabunglah dengan ratusan sekolah lainnya dan rasakan kemudahan pengelolaan pendaftaran.' }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $settings['cta_link'] ?? '/register' }}" 
               class="w-full sm:w-auto px-10 py-5 bg-white text-indigo-600 rounded-2xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl hover:shadow-2xl active:scale-[0.98]">
                {{ $settings['cta_button'] ?? 'Daftar Sekarang' }}
            </a>
            
            <a href="#" class="w-full sm:w-auto px-10 py-5 border-2 border-indigo-400 text-white rounded-2xl font-bold text-lg hover:bg-indigo-500 transition active:scale-[0.98]">
                Konsultasi Gratis
            </a>
        </div>

        <p class="mt-8 text-indigo-200 text-sm flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm">verified</span>
            Tanpa kontrak mengikat, aktifkan kapan saja
        </p>
    </div>
</section>
