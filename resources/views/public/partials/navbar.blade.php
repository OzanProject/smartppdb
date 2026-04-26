<nav class="fixed top-0 w-full z-50 glass border-b border-slate-200/50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        
        <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-50">
            @if(!empty($landingSettings['app_logo']))
                <img src="{{ asset('storage/' . $landingSettings['app_logo']) }}" alt="Logo" style="height: 40px !important; width: auto !important; max-width: 150px !important; object-fit: contain;">
            @else
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <span class="material-symbols-outlined font-bold">school</span>
                </div>
            @endif
            <div class="text-xl lg:text-2xl font-black tracking-tighter text-slate-900 leading-none">
                {{ $landingSettings['app_name'] ?? 'PPDB Pro' }}
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex gap-10 text-[15px] font-semibold text-slate-600">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">Beranda</a>
            <a href="{{ route('public.fitur') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('public.fitur') ? 'text-indigo-600' : '' }}">Fitur</a>
            <a href="{{ route('public.harga') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('public.harga') ? 'text-indigo-600' : '' }}">Harga</a>
            <a href="{{ route('public.faq') }}" class="hover:text-indigo-600 transition-colors {{ request()->routeIs('public.faq') ? 'text-indigo-600' : '' }}">Bantuan</a>
        </div>

        <div class="flex items-center gap-4 relative z-50">
            @auth
                <a href="{{ route('dashboard') }}" class="text-[15px] font-semibold text-indigo-600 hover:text-indigo-700">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hidden md:block text-[15px] font-semibold text-slate-600 hover:text-indigo-600">Login</a>
                <a href="{{ route('school.register') }}" class="hidden md:flex btn-premium text-white px-6 py-2.5 rounded-xl text-[14px] font-bold tracking-wide">
                    Get Started
                </a>
            @endauth

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-900 focus:outline-none">
                <span class="material-symbols-outlined text-3xl" x-show="!mobileMenuOpen">menu</span>
                <span class="material-symbols-outlined text-3xl" x-show="mobileMenuOpen" x-cloak>close</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-full"
         class="lg:hidden absolute top-0 left-0 w-full bg-white/95 backdrop-blur-xl shadow-2xl border-b border-slate-100 pt-24 pb-12 px-6 z-40"
         x-cloak>
        <div class="flex flex-col gap-6 text-center">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="text-xl font-bold text-slate-900 py-2 border-b border-slate-50">Beranda</a>
            <a href="{{ route('public.fitur') }}" @click="mobileMenuOpen = false" class="text-xl font-bold text-slate-900 py-2 border-b border-slate-50">Fitur</a>
            <a href="{{ route('public.harga') }}" @click="mobileMenuOpen = false" class="text-xl font-bold text-slate-900 py-2 border-b border-slate-50">Harga</a>
            <a href="{{ route('public.faq') }}" @click="mobileMenuOpen = false" class="text-xl font-bold text-slate-900 py-2 border-b border-slate-50">Bantuan</a>
            <div class="pt-6 flex flex-col gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-lg font-bold text-slate-600">Login</a>
                @endguest
                <a href="{{ route('school.register') }}" class="btn-premium text-white py-4 rounded-2xl font-bold text-lg">Mulai Sekarang</a>
            </div>
        </div>
    </div>
</nav>
