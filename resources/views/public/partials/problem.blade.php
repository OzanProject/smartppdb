<section class="py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
                {{ $landingSettings['problem_title'] ?? 'Masalah yang Sering Terjadi' }}
            </h2>
            <p class="text-slate-500 font-medium">
                {{ $landingSettings['problem_subtitle'] ?? 'PPDB manual hanya akan menghambat pertumbuhan institusi Anda.' }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-red-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined">folder_off</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $landingSettings['problem_1_title'] ?? 'Data Tercecer' }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $landingSettings['problem_1_desc'] ?? 'Formulir kertas menumpuk, rawan hilang, dan sulit dicari saat dibutuhkan mendesak.' }}</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-red-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined">person_pin_circle</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $landingSettings['problem_2_title'] ?? 'Pendaftaran Sulit' }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $landingSettings['problem_2_desc'] ?? 'Calon siswa harus datang ke sekolah berkali-kali hanya untuk urusan administrasi dasar.' }}</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-red-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined">running_with_errors</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $landingSettings['problem_3_title'] ?? 'Rawan Kesalahan' }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $landingSettings['problem_3_desc'] ?? 'Input data manual berisiko tinggi salah ketik dan duplikasi data yang membingungkan.' }}</p>
            </div>
        </div>

    </div>
</section>

