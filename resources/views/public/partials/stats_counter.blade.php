<section class="py-20 bg-slate-900 overflow-hidden relative">
    <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none">
        <div class="absolute w-[800px] h-[800px] bg-indigo-500 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid md:grid-cols-3 gap-12 text-center">
            <div class="flex flex-col items-center">
                <div class="text-5xl lg:text-7xl font-black text-white mb-2 tracking-tighter">{{ $stats['total_schools'] ?? 0 }}+</div>
                <div class="text-indigo-400 font-bold uppercase tracking-[0.2em] text-xs">Sekolah Terdaftar</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-5xl lg:text-7xl font-black text-white mb-2 tracking-tighter">{{ number_format(($stats['total_applicants'] ?? 0)) }}+</div>
                <div class="text-indigo-400 font-bold uppercase tracking-[0.2em] text-xs">Calon Siswa Terdata</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-5xl lg:text-7xl font-black text-white mb-2 tracking-tighter">99.9%</div>
                <div class="text-indigo-400 font-bold uppercase tracking-[0.2em] text-xs">Sistem Uptime</div>
            </div>
        </div>
    </div>
</section>
