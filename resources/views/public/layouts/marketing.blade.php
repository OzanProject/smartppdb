<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landingSettings['seo_meta_description'] ?? 'Platform SaaS pendaftaran sekolah online terbaik di Indonesia.' }}">
    <meta name="keywords" content="{{ $landingSettings['seo_meta_keywords'] ?? 'PPDB Online, Pendaftaran Sekolah, PPDB PRO' }}">
    <meta name="author" content="{{ $landingSettings['app_name'] ?? 'PPDB PRO' }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $landingSettings['seo_og_title'] ?? ($landingSettings['app_name'] ?? 'PPDB PRO') }}">
    <meta property="og:description" content="{{ $landingSettings['seo_og_description'] ?? 'Solusi digital pendaftaran sekolah Anda.' }}">
    <meta property="og:image" content="{{ !empty($landingSettings['app_logo']) ? asset('storage/' . $landingSettings['app_logo']) : asset('logo_placeholder.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $landingSettings['seo_og_title'] ?? ($landingSettings['app_name'] ?? 'PPDB PRO') }}">
    <meta property="twitter:description" content="{{ $landingSettings['seo_og_description'] ?? 'Solusi digital pendaftaran sekolah Anda.' }}">
    <meta property="twitter:image" content="{{ !empty($landingSettings['app_logo']) ? asset('storage/' . $landingSettings['app_logo']) : asset('logo_placeholder.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <title>@yield('title') | {{ $landingSettings['app_name'] ?? 'PPDB PRO' }}</title>

    <!-- Meta Tags for SEO & Social Sharing -->
    <meta name="description" content="{{ $landingSettings['seo_description'] ?? ($landingSettings['app_slogan'] ?? 'Platform PPDB Digital Terpadu') }}">
    <meta property="og:title" content="{{ $landingSettings['app_name'] ?? 'PPDB PRO' }} - {{ $landingSettings['app_slogan'] ?? 'Platform PPDB Digital Terpadu' }}">
    <meta property="og:description" content="{{ $landingSettings['seo_description'] ?? 'Kelola pendaftaran siswa baru lebih mudah, cepat, dan profesional.' }}">
    <meta property="og:image" content="{{ isset($landingSettings['app_logo']) && $landingSettings['app_logo'] ? asset('storage/' . $landingSettings['app_logo']) : asset('saas_hero_dashboard_1776911874930.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ $landingSettings['app_name'] ?? 'PPDB PRO' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ !empty($landingSettings['app_logo']) ? asset('storage/' . $landingSettings['app_logo']) : asset('logo_placeholder.png') }}",
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "{{ $landingSettings['app_phone'] ?? '' }}",
        "contactType": "customer service"
      }
    }
    </script>
    @if(!empty($landingSettings['app_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $landingSettings['app_favicon']) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Plus Jakarta Sans', sans-serif; }

        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.7);
        }

        [x-cloak] { display: none !important; }

        .soft-shadow {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-premium {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .hero-blob {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }

        @@keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float-animation {
            animation: float 5s ease-in-out infinite;
        }

        .shadow-3xl {
            box-shadow: 0 30px 100px -10px rgba(0, 0, 0, 0.3);
        }

        @@keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .marquee-content {
            display: inline-block;
            animation: marquee 40s linear infinite;
        }

        .marquee-content:hover {
            animation-play-state: paused;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#fcfdfe] text-slate-900 overflow-x-hidden">

    @include('public.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('public.partials.footer')

    @if(!empty($landingSettings['app_phone']))
        <!-- Floating Action Buttons -->
        <div class="fixed bottom-8 right-8 z-[99] flex flex-col gap-4 items-end" x-data="{ showScrollTop: false }" @scroll.window="showScrollTop = (window.pageYOffset > 500)">
            
            <!-- Scroll to Top Button -->
            <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" 
                    x-show="showScrollTop"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-10"
                    class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center shadow-2xl border border-slate-100 hover:bg-slate-50 hover:scale-110 transition-all duration-300 group"
                    x-cloak>
                <span class="material-symbols-outlined group-hover:-translate-y-1 transition-transform">arrow_upward</span>
            </button>

            <!-- Floating Customer Service (WhatsApp) -->
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $landingSettings['app_phone']) }}?text=Halo%20Admin%20PPDB%20PRO,%20saya%20ingin%20bertanya..." 
               target="_blank"
               class="group flex items-center gap-3">
                
                <!-- Tooltip -->
                <div class="bg-white px-5 py-3 rounded-2xl shadow-2xl border border-slate-100 text-slate-900 text-sm font-bold opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500 pointer-events-none hidden md:block">
                    Ada pertanyaan? Hubungi Kami
                </div>

                <!-- Button -->
                <div class="w-16 h-16 bg-[#25D366] text-white rounded-full flex items-center justify-center shadow-2xl shadow-green-200 hover:scale-110 transition-transform duration-500 relative">
                    <i class="fab fa-whatsapp text-3xl"></i>
                    <!-- Pulse Effect -->
                    <div class="absolute inset-0 rounded-full bg-[#25D366] opacity-30 animate-ping -z-10"></div>
                </div>
            </a>
        </div>
    @endif

    @stack('scripts')
</body>
</html>
