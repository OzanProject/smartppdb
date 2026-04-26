<section class="py-24 bg-indigo-600 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
        </svg>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative text-center">
        <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-12 tracking-tight">{{ $landingSettings['testimonial_title'] ?? 'Apa Kata Mereka?' }}</h2>
        
        <div class="bg-white/10 backdrop-blur-md p-10 lg:p-16 rounded-[3rem] border border-white/20 shadow-2xl relative">
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 w-16 h-16 bg-white rounded-full flex items-center justify-center text-indigo-600 shadow-xl">
                <span class="material-symbols-outlined text-3xl">format_quote</span>
            </div>
            
            <p class="text-xl lg:text-2xl font-medium text-white mb-8 leading-relaxed italic">
                “{{ $landingSettings['testimonial_quote'] ?? 'Sejak kami beralih ke PPDB Pro, proses pendaftaran siswa baru menjadi jauh lebih cepat, rapi, dan terukur. Orang tua siswa juga sangat terbantu karena bisa mendaftar dari rumah.' }}”
            </p>
            
            <div class="flex items-center justify-center gap-4">
                <div class="w-14 h-14 bg-indigo-400 rounded-full border-4 border-white/20 flex items-center justify-center text-white font-bold text-xl">
                    {{ substr($landingSettings['testimonial_author'] ?? 'PP', 0, 2) }}
                </div>
                <div class="text-left">
                    <div class="text-white font-bold text-lg">{{ $landingSettings['testimonial_author'] ?? 'Haji Syarifuddin' }}</div>
                    <div class="text-indigo-200 text-sm font-medium">{{ $landingSettings['testimonial_role'] ?? 'Kepala Sekolah, Islamic School Jakarta' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
