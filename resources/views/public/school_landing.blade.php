<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>PPDB {{ $school->name }} - Penerimaan Peserta Didik Baru</title>
    @if(!empty($landingSettings['app_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $landingSettings['app_favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#0d47a1",
                        "surface-container": "#eceef1",
                        "on-surface": "#191c1e",
                        "inverse-surface": "#2d3133",
                        "primary": "#003178",
                        "on-error-container": "#93000a",
                        "tertiary": "#003d36",
                        "surface-dim": "#d8dadd",
                        "outline-variant": "#c3c6d4",
                        "error": "#ba1a1a",
                        "on-primary-fixed-variant": "#00429c",
                        "on-secondary-fixed-variant": "#773200",
                        "outline": "#737783",
                        "surface-variant": "#e0e3e6",
                        "primary-fixed": "#d9e2ff",
                        "surface-bright": "#f7f9fc",
                        "secondary-fixed": "#ffdbca",
                        "surface": "#f7f9fc",
                        "tertiary-container": "#00564d",
                        "inverse-on-surface": "#eff1f4",
                        "on-tertiary-fixed-variant": "#005048",
                        "on-secondary": "#ffffff",
                        "secondary": "#9c4400",
                        "inverse-primary": "#b0c6ff",
                        "surface-tint": "#2b5bb5",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#5ccfbf",
                        "primary-fixed-dim": "#b0c6ff",
                        "tertiary-fixed-dim": "#67d9c9",
                        "background": "#f7f9fc",
                        "on-primary-container": "#a1bbff",
                        "surface-container-high": "#e6e8eb",
                        "on-error": "#ffffff",
                        "secondary-container": "#fd7613",
                        "surface-container-low": "#f2f4f7",
                        "secondary-fixed-dim": "#ffb68f",
                        "surface-container-highest": "#e0e3e6",
                        "error-container": "#ffdad6",
                        "tertiary-fixed": "#85f6e5",
                        "on-primary": "#ffffff",
                        "on-primary-fixed": "#001945",
                        "on-tertiary-fixed": "#00201c",
                        "on-secondary-container": "#5b2500",
                        "on-background": "#191c1e",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#434652",
                        "on-secondary-fixed": "#331200"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-background text-on-background font-body antialiased">
    <!-- TopNavBar -->
    <nav class="fixed top-0 w-full z-[100] bg-white/70 backdrop-blur-xl shadow-sm border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <!-- Brand -->
            <a href="{{ route('school.landing', $school->slug) }}" class="flex items-center gap-3 group">
                @if($school->logo)
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center overflow-hidden group-hover:scale-110 transition-transform">
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                @elseif(!empty($landingSettings['app_logo']))
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center overflow-hidden group-hover:scale-110 transition-transform">
                        <img src="{{ asset('storage/' . $landingSettings['app_logo']) }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                @endif
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 font-headline leading-tight">{{ $school->name }}</span>
                    <span class="text-[10px] font-bold text-blue-600 tracking-[0.2em] uppercase leading-none">OFFICIAL PPDB</span>
                </div>
            </a>
            
            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-1">
                @php 
                    $navItems = [
                        ['label' => 'Beranda', 'slug' => ''],
                        ['label' => 'Jadwal', 'slug' => 'jadwal'],
                        ['label' => 'Keunggulan', 'slug' => 'keunggulan'],
                        ['label' => 'FAQ', 'slug' => 'faqs'],
                    ];
                @endphp
                @foreach($navItems as $item)
                <a href="{{ $item['slug'] ? route('school.landing', [$school->slug, $item['slug']]) : route('school.landing', $school->slug) }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ ($section == $item['slug'] || (!$section && !$item['slug'])) ? 'text-blue-600 bg-blue-50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    {{ $item['label'] }}
                </a>
                @endforeach
            </div>

            <!-- Actions -->
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('school.registration.track', $school->slug) }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors border-r border-slate-200 pr-6 mr-2">
                    Cek Status
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('login', ['school' => $school->slug]) }}" class="px-5 py-2.5 rounded-full text-xs font-extrabold text-slate-700 hover:bg-slate-50 transition-all border border-slate-100 uppercase tracking-widest">MASUK</a>
                    @if($school->is_registration_open && $activeBatches->count() > 0)
                        <a href="{{ route('register', ['school' => $school->slug]) }}" class="bg-blue-600 text-white px-7 py-2.5 rounded-full font-bold text-xs tracking-widest uppercase hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                            DAFTAR SEKARANG
                        </a>
                    @else
                        <span class="bg-slate-100 text-slate-400 px-6 py-2.5 rounded-full font-bold text-xs">TUTUP</span>
                    @endif
                </div>
            </div>

            <!-- Mobile Trigger -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="p-2 rounded-xl bg-slate-50 text-slate-600 border border-slate-200">
                    <span class="material-symbols-outlined text-2xl block" id="menu-icon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl shadow-2xl border-t border-slate-100 flex-col p-6 space-y-6 md:hidden animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="grid grid-cols-2 gap-3">
                @foreach($navItems as $item)
                    <a class="flex items-center justify-center p-4 rounded-2xl border border-slate-100 text-sm font-bold {{ ($section == $item['slug'] || (!$section && !$item['slug'])) ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-600/20' : 'bg-slate-50 text-slate-600' }}" 
                       href="{{ $item['slug'] ? route('school.landing', [$school->slug, $item['slug']]) : route('school.landing', $school->slug) }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            
            <div class="pt-4 border-t border-slate-100 space-y-4">
                <a href="{{ route('school.registration.track', $school->slug) }}" class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl bg-white border border-slate-200 text-slate-600 font-bold text-sm">
                    <span class="material-symbols-outlined text-sm">search</span> Cek Status Pendaftaran
                </a>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login', ['school' => $school->slug]) }}" class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl bg-slate-100 text-slate-700 font-bold text-sm uppercase tracking-widest">
                         Masuk
                    </a>
                    @if($school->is_registration_open && $activeBatches->count() > 0)
                        <a href="{{ route('register', ['school' => $school->slug]) }}" class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-600/20 uppercase tracking-widest">
                            Daftar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="pt-32 pb-24 lg:pt-48 lg:pb-36 bg-blue-900 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-20"></div>
            <div class="absolute top-1/2 -left-24 w-72 h-72 bg-blue-400 rounded-full blur-[100px] opacity-10"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-3xl lg:text-5xl font-headline font-extrabold text-white tracking-tight leading-tight mb-6">
                    {{ $school->hero_title ?: 'Penerimaan Peserta Didik Baru' }}
                </h1>
                <p class="text-lg lg:text-xl text-blue-100 font-body font-light mb-10 max-w-lg leading-relaxed">
                    {{ $school->hero_description ?: 'Bergabunglah bersama kami untuk masa depan yang lebih cerah. Pendaftaran tahun ajaran baru telah dibuka.' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($school->is_registration_open && $activeBatches->count() > 0)
                        <a href="{{ route('register', ['school' => $school->slug]) }}" class="bg-secondary text-white text-center px-10 py-4 rounded-2xl font-bold tracking-widest uppercase hover:bg-secondary-container transition-all shadow-xl shadow-black/20 transform hover:-translate-y-1">
                            Mulai Daftar Sekarang
                        </a>
                    @endif
                    <a href="#jadwal" class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-center px-10 py-4 rounded-2xl font-bold tracking-widest uppercase hover:bg-white/20 transition-all">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <div class="absolute inset-0 bg-secondary blur-[100px] opacity-30 rounded-full"></div>
                <img alt="Students" class="relative rounded-2xl shadow-2xl shadow-black/20 object-cover h-[500px] w-full border-4 border-white/10" src="{{ $school->hero_image ? asset('storage/'.$school->hero_image) : 'https://images.unsplash.com/photo-1523240915679-7f2171db6b0c?q=80&w=2070&auto=format&fit=crop' }}"/>
            </div>
        </div>
    </header>

    <!-- Stats Section -->
    <section class="py-16 bg-white border-b border-surface-variant">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-outline-variant/30">
                <div class="text-center px-4">
                    <span class="material-symbols-outlined text-4xl text-primary mb-2 block">verified_user</span>
                    <h3 class="text-3xl font-headline font-bold text-on-surface">{{ $school->stats_acc_value ?: 'A' }}</h3>
                    <p class="text-sm font-label text-on-surface-variant mt-1">{{ $school->stats_acc_label ?: 'Akreditasi' }}</p>
                </div>
                <div class="text-center px-4">
                    <span class="material-symbols-outlined text-4xl text-primary mb-2 block">diversity_3</span>
                    <h3 class="text-3xl font-headline font-bold text-on-surface">{{ $school->stats_count_value ?: '1000+' }}</h3>
                    <p class="text-sm font-label text-on-surface-variant mt-1">{{ $school->stats_count_label ?: 'Siswa & Alumni' }}</p>
                </div>
                <div class="text-center px-4">
                    <span class="material-symbols-outlined text-4xl text-primary mb-2 block">event_available</span>
                    <h3 class="text-3xl font-headline font-bold text-on-surface">
                        @if($activeBatches->count() > 0)
                            {{ $activeBatches->first()->academicYear->name }}
                        @else
                            {{ date('Y') }}/{{ date('Y')+1 }}
                        @endif
                    </h3>
                    <p class="text-sm font-label text-on-surface-variant mt-1">Tahun Ajaran</p>
                </div>
                <div class="text-center px-4">
                    <span class="material-symbols-outlined text-4xl text-primary mb-2 block">workspace_premium</span>
                    <h3 class="text-3xl font-headline font-bold text-on-surface">{{ $school->stats_grad_value ?: '100%' }}</h3>
                    <p class="text-sm font-label text-on-surface-variant mt-1">{{ $school->stats_grad_label ?: 'Lulusan' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-24 bg-surface-container-lowest">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-headline font-bold text-on-surface mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-lg text-on-surface-variant max-w-2xl mx-auto">Kami memberikan layanan pendidikan terbaik dengan mengedepankan kualitas dan karakter siswa.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @forelse($programs as $program)
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-surface-variant hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-primary-fixed rounded-xl flex items-center justify-center mb-6 shadow-inner overflow-hidden">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="Icon" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-3xl text-primary">school</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-headline font-bold text-on-surface mb-3">{{ $program->title }}</h3>
                        <p class="text-on-surface-variant leading-relaxed text-sm">
                            {{ $program->content }}
                        </p>
                    </div>
                @empty
                    {{-- Fallback content if empty --}}
                    @foreach(['Kurikulum Unggul', 'Fasilitas Modern', 'Pembinaan Karakter'] as $item)
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-surface-variant opacity-50">
                            <h3 class="text-xl font-headline font-bold text-on-surface mb-3">{{ $item }}</h3>
                            <p class="text-on-surface-variant leading-relaxed text-sm italic">Konten belum diatur di dashboard admin.</p>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- Timeline Jadwal Section -->
    <section id="jadwal" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-headline font-bold text-on-surface mb-4">Jadwal Pendaftaran</h2>
                <p class="text-lg text-on-surface-variant">Ikuti setiap tahapan pendaftaran sesuai dengan jadwal berikut.</p>
            </div>
            
            <div class="relative">
                <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 h-full w-1 bg-surface-variant rounded-full"></div>
                
                @forelse($activeBatches as $index => $batch)
                    <div class="mb-12 relative flex items-center {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }} w-full">
                        <div class="hidden md:block w-[45%] {{ $index % 2 == 0 ? 'text-left pl-8' : 'text-right pr-8' }}">
                            <h4 class="text-xl font-bold text-primary">{{ $batch->name }}</h4>
                            <p class="text-on-surface-variant mt-2">Pendaftaran dibuka secara online melalui website resmi.</p>
                        </div>
                        
                        <div class="absolute left-2 md:left-1/2 transform -translate-x-1/2 w-6 h-6 rounded-full border-4 border-white shadow-md {{ $index == 0 ? 'bg-secondary' : 'bg-primary' }}"></div>
                        
                        <div class="ml-12 md:ml-0 w-full md:w-[45%] {{ $index % 2 == 0 ? 'md:text-right pr-8' : 'md:text-left pl-8' }}">
                            <span class="inline-block px-4 py-1 rounded-full text-xs font-bold bg-primary-fixed text-primary mb-2">
                                {{ $batch->start_date->format('d M') }} - {{ $batch->end_date->format('d M Y') }}
                            </span>
                            <h4 class="md:hidden text-xl font-bold text-primary">{{ $batch->name }}</h4>
                            <p class="text-on-surface-variant mt-2 text-sm">Tahun Ajaran: {{ $batch->academicYear->name }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-5xl text-slate-300 mb-4 block">event_busy</span>
                        <p class="text-slate-500 font-medium">Belum ada jadwal pendaftaran aktif saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimoni Alumni -->
    <section id="alumni" class="py-24 bg-primary text-white overflow-hidden rounded-[50px] mx-4 md:mx-8 mb-24 pb-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-headline font-bold mb-4">Kata Alumni Kami</h2>
                <p class="text-lg opacity-70 max-w-2xl mx-auto">Kisah sukses para lulusan kami yang telah menempuh pendidikan di {{ $school->name }}.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @forelse($testimonials as $testi)
                    <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/20 relative group hover:bg-white/20 transition-all">
                        <div class="absolute -top-6 left-8">
                            @if($testi->image)
                                <img src="{{ asset('storage/' . $testi->image) }}" alt="Alumni" class="w-12 h-12 rounded-full border-2 border-white shadow-lg">
                            @else
                                <div class="w-12 h-12 rounded-full bg-secondary border-2 border-white flex items-center justify-center">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <h4 class="font-bold text-lg mb-1">{{ $testi->title }}</h4>
                            <p class="text-xs opacity-60 mb-4">{{ $testi->subtitle }}</p>
                            <p class="text-sm italic leading-relaxed opacity-90">
                                "{{ $testi->content }}"
                            </p>
                        </div>
                    </div>
                @empty
                     <div class="text-center col-span-3 opacity-30 italic py-10">Data testimoni belum diatur.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faqs" class="py-24 bg-surface-container-low mt-[-100px] pt-48">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-headline font-bold text-on-surface mb-4">Tanya Jawab (FAQ)</h2>
                <p class="text-lg text-on-surface-variant">Informasi lengkap seputar pendaftaran yang sering ditanyakan.</p>
            </div>
            <div class="space-y-4">
                @forelse($faqs as $faq)
                    <details class="group bg-white rounded-2xl border border-surface-variant overflow-hidden [&_summary::-webkit-details-marker]:hidden transition-all">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-on-surface hover:bg-slate-50 transition-colors">
                            <h3 class="font-bold">{{ $faq->title }}</h3>
                            <span class="material-symbols-outlined transition duration-300 group-open:-rotate-180">expand_more</span>
                        </summary>
                        <div class="px-6 pb-6 text-on-surface-variant leading-relaxed text-sm">
                            {{ $faq->content }}
                        </div>
                    </details>
                @empty
                    <div class="text-center opacity-30 italic py-5">FAQ belum diatur.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-primary text-white pt-24 pb-12 rounded-t-[50px]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <div>
                    <div class="text-2xl font-bold font-headline mb-6">{{ $school->name }}</div>
                    <p class="text-primary-fixed opacity-60 leading-relaxed mb-8 text-sm">
                        Membangun generasi cerdas, berkarakter, dan siap menghadapi tantangan masa depan melalui pendidikan berkualitas tinggi.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-secondary transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6 border-b border-white/10 pb-2">Navigasi Cepat</h4>
                    <ul class="space-y-4 text-primary-fixed opacity-70 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#jadwal" class="hover:text-white transition-colors">Jadwal Pendaftaran</a></li>
                        <li><a href="{{ route('login', ['school' => $school->slug]) }}" class="hover:text-white transition-colors">Login Pendaftar</a></li>
                        <li><a href="{{ route('register', ['school' => $school->slug]) }}" class="hover:text-white transition-colors">Pendaftaran Baru</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6 border-b border-white/10 pb-2">Hubungi Kami</h4>
                    <ul class="space-y-4 text-primary-fixed">
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span class="opacity-70 text-xs italic">{{ $school->address ?: 'Alamat belum diatur' }}</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-sm">call</span>
                            <span class="opacity-70 text-sm">{{ $school->phone ?: '-' }}</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-sm">mail</span>
                            <span class="opacity-70 text-xs">{{ $school->email ?: '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] opacity-40">
                <p>© {{ date('Y') }} {{ $school->name }}. All Rights Reserved. Powered by {{ $landingSettings['app_name'] ?? 'PPDB PRO' }}.</p>
                <div class="flex gap-8">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        $(document).ready(function() {
            const activeSection = "{{ $section }}";
            
            if (activeSection) {
                const target = $("#" + activeSection);
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80 // Offset for fixed header
                    }, 800);
                }
            }

            // Mobile menu toggle
            $('#mobile-menu-button').click(function() {
                $('#mobile-menu').toggleClass('hidden').toggleClass('flex');
            });
        });
    </script>
</body>
</html>
