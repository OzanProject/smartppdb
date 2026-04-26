<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($school) ? 'PPDB ' . $school->name : ($landingSettings['app_name'] ?? 'PPDB PRO') }} | Auth</title>
    
    <!-- Favicon -->
    @if(!empty($landingSettings['app_favicon']))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $landingSettings['app_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 
                            400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 
                            800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                        },
                    }
                }
            }
        }
    </script>
    
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        }
        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body class="h-full font-sans antialiased bg-slate-50">
    <div class="flex min-h-full">
        <!-- Left Side: Visual/Branding -->
        <div class="hidden lg:flex lg:w-1/2 gradient-bg relative overflow-hidden items-center justify-center p-12">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>
            
            <div class="relative z-10 max-w-lg text-center lg:text-left">
                <a href="{{ isset($school) ? route('school.landing', $school->slug) : '/' }}" class="inline-flex items-center gap-3 mb-12">
                    @if(isset($school) && $school->logo)
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo {{ $school->name }}" class="h-12 w-auto bg-white p-2 rounded-xl shadow-lg">
                    @else
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-primary-600 shadow-xl">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                    @endif
                    <span class="text-3xl font-black text-white tracking-tighter">{{ isset($school) ? $school->name : ($landingSettings['app_name'] ?? 'PPDB PRO') }}</span>
                </a>
                
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                    Masa Depan <br> <span class="text-indigo-200">Pendaftaran Sekolah</span> <br> Mulai dari Sini.
                </h2>
                <p class="text-indigo-100 text-lg leading-relaxed mb-8 opacity-90">
                    Sistem pendaftaran online yang modern, aman, dan mempermudah administrasi sekolah Anda hanya dalam genggaman.
                </p>
                
                <div class="grid grid-cols-2 gap-6 mt-12">
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-[2rem] border border-white/10 shadow-xl">
                        <div class="text-2xl font-bold text-white mb-1">100%</div>
                        <div class="text-indigo-200 text-xs font-bold uppercase tracking-widest">Online & Paperless</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-[2rem] border border-white/10 shadow-xl">
                        <div class="text-2xl font-bold text-white mb-1">24/7</div>
                        <div class="text-indigo-200 text-xs font-bold uppercase tracking-widest">Akses Tanpa Batas</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="flex flex-col justify-center flex-1 px-8 py-12 lg:px-24 bg-white relative">
            <div class="max-w-sm mx-auto w-full">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex justify-center mb-10">
                    <a href="{{ isset($school) ? route('school.landing', $school->slug) : '/' }}" class="flex items-center gap-2">
                         @if(isset($school) && $school->logo)
                            <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo {{ $school->name }}" class="h-10 w-auto">
                        @else
                            <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        @endif
                        <span class="text-xl font-black tracking-tighter text-slate-900">{{ isset($school) ? $school->name : ($landingSettings['app_name'] ?? 'PPDB PRO') }}</span>
                    </a>
                </div>

                {{ $slot }}
                
                <div class="mt-10 text-center">
                    <p class="text-sm text-slate-500 font-medium italic">
                        &copy; {{ date('Y') }} {{ $landingSettings['app_name'] ?? 'PPDB PRO' }} Platform. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</html>
