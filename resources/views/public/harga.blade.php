@extends('public.layouts.marketing')

@section('title', 'Paket Harga')

@section('content')
    <!-- Pricing Hero -->
    <section class="pt-48 pb-40 bg-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-100 rounded-full blur-[100px] opacity-50 translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-100 rounded-full blur-[80px] opacity-30 -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative text-center">
            <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mb-8 tracking-tighter leading-none">
                Pilih Paket <span class="gradient-text">Terbaik</span> <br> Untuk Sekolah Anda
            </h1>
            <p class="text-slate-500 text-xl max-w-2xl mx-auto leading-relaxed mb-16 font-medium">
                Investasi cerdas untuk mendigitalisasi proses PPDB sekolah Anda. <br>
                Setup cepat, fitur lengkap, dan dukungan teknis 24/7.
            </p>
            
            <!-- Payment Methods Badge -->
            <div class="inline-flex flex-col items-center">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Metode Pembayaran Terintegrasi</span>
                <div class="flex flex-wrap justify-center items-center gap-8 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dan_Nama_BCA.svg" alt="BCA" class="h-5 lg:h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/id/f/fa/Bank_Mandiri_logo.svg" alt="Mandiri" class="h-5 lg:h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_Midtrans.png" alt="Midtrans" class="h-5 lg:h-6">
                    <img src="https://tripay.co.id/images/logo.png" alt="Tripay" class="h-5 lg:h-6">
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="pb-32 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-6 -mt-24">
            <div class="grid lg:grid-cols-3 gap-8 items-stretch">
                @foreach($plans as $plan)
                    @php
                        $isLite = Str::contains(Str::lower($plan->name), 'lite');
                        $isPro = Str::contains(Str::lower($plan->name), 'pro') || $plan->is_popular;
                        $isEnterprise = Str::contains(Str::lower($plan->name), 'enterprise');
                    @endphp
                    
                    <div class="relative group h-full">
                        @if($plan->is_popular)
                            <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-orange-500 text-white px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-lg z-20 animate-bounce">Rekomendasi</div>
                        @endif
                        
                        <div class="h-full bg-white rounded-[3rem] p-12 border {{ $plan->is_popular ? 'border-indigo-600 shadow-2xl scale-105' : 'border-slate-100 shadow-xl' }} flex flex-col hover:border-indigo-400 transition-all duration-500">
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $plan->name }}</h3>
                                <p class="text-slate-500 text-sm leading-relaxed">{{ $plan->description }}</p>
                            </div>
                            
                            <div class="mb-10">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-5xl font-black text-slate-900 italic tracking-tighter">
                                        {{ $plan->price_display }}
                                    </span>
                                    @if($plan->price > 0)
                                        <span class="text-slate-400 font-bold ml-1">/ {{ $plan->billing_cycle == 'yearly' ? 'tahun' : ($plan->billing_cycle == 'monthly' ? 'bulan' : 'paket') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <ul class="space-y-4 mb-12 flex-grow text-slate-600 font-medium">
                                @foreach($plan->features_list as $feature)
                                    <li class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-green-500 font-bold shrink-0">check_circle</span>
                                        <span class="text-sm">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <a href="{{ route('school.register') }}?plan={{ $plan->id }}" class="block text-center w-full py-5 rounded-2xl {{ $plan->is_popular ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-slate-50 text-slate-900' }} font-bold text-lg shadow-xl hover:scale-105 transition-all">
                                {{ $plan->cta_text ?? 'Pilih Paket Ini' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Detailed Comparison -->
    <section class="py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">Perbandingan Fitur Detail</h2>
                <p class="text-slate-500">Bandingkan fitur antar paket untuk menemukan yang terbaik.</p>
            </div>
            
            <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-slate-100">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="p-8 text-sm font-bold text-slate-400 uppercase tracking-widest">Fitur Utama</th>
                            @foreach($plans as $plan)
                                <th class="p-8 text-center text-lg font-bold text-slate-900">{{ $plan->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <tr>
                            <td class="p-8 font-bold">Kuota Pendaftar</td>
                            @foreach($plans as $plan)
                                <td class="p-8 text-center font-semibold">
                                    {{ $plan->max_quota == -1 ? 'Tidak Terbatas' : $plan->max_quota . ' Calon Siswa' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-8 font-bold">Form Builder Kustom</td>
                            @foreach($plans as $plan)
                                <td class="p-8 text-center">
                                    <span class="material-symbols-outlined {{ in_array('pendaftaran', $plan->allowed_modules ?? []) ? 'text-green-500' : 'text-slate-200' }} font-bold">
                                        {{ in_array('pendaftaran', $plan->allowed_modules ?? []) ? 'check_circle' : 'cancel' }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-8 font-bold">Cetak Invoice PDF</td>
                            @foreach($plans as $plan)
                                <td class="p-8 text-center">
                                    <span class="material-symbols-outlined text-green-500 font-bold">check_circle</span>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-8 font-bold">Dukungan Payment Gateway</td>
                            @foreach($plans as $plan)
                                <td class="p-8 text-center">
                                    <span class="material-symbols-outlined {{ !Str::contains(Str::lower($plan->name), 'lite') ? 'text-green-500' : 'text-slate-200' }} font-bold">
                                        {{ !Str::contains(Str::lower($plan->name), 'lite') ? 'check_circle' : 'cancel' }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="p-8 font-bold">Priority Support</td>
                            @foreach($plans as $plan)
                                <td class="p-8 text-center">
                                    <span class="material-symbols-outlined {{ Str::contains(Str::lower($plan->name), 'enterprise') ? 'text-green-500' : 'text-slate-200' }} font-bold">
                                        {{ Str::contains(Str::lower($plan->name), 'enterprise') ? 'check_circle' : 'cancel' }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @include('public.partials.faq')
@endsection
