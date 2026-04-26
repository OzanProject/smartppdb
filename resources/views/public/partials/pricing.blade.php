<section class="py-32 bg-slate-900 text-white rounded-[4rem] mx-4 lg:mx-10 my-10 overflow-hidden relative shadow-3xl">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-orange-600 blur-[150px] opacity-10 -translate-y-1/2 translate-x-1/2"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-extrabold mb-6 tracking-tight">
                @php
                    $pTitle = $landingSettings['pricing_title'] ?? 'Investasi Terbaik';
                    $pWords = explode(' ', $pTitle);
                    $pLast = array_pop($pWords);
                    $pMain = implode(' ', $pWords);
                @endphp
                {{ $pMain }} <span class="text-orange-400">{{ $pLast }}</span>
            </h2>
            <p class="text-slate-400 text-lg">{{ $landingSettings['pricing_subtitle'] ?? 'Pilih paket yang paling sesuai dengan kapasitas sekolah Anda.' }}</p>
        </div>

        <div class="grid lg:grid-cols-{{ $plans->count() }} gap-8 items-center">
            @foreach($plans as $plan)
                @if($plan->is_popular)
                    <!-- Popular Plan -->
                    <div class="p-12 bg-white text-slate-900 rounded-[3rem] shadow-2xl relative scale-105 z-10">
                        <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-orange-500 text-white px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-lg shadow-orange-200">Terlaris</div>
                        <h3 class="text-2xl font-bold mb-2 text-slate-900">{{ $plan->name }}</h3>
                        <p class="text-slate-500 mb-8">{{ $plan->description }}</p>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-5xl font-black italic">{{ $plan->price_display }}</span>
                            @if($plan->price > 0)
                                <span class="text-slate-500">/ {{ $plan->billing_cycle == 'yearly' ? 'tahun' : ($plan->billing_cycle == 'monthly' ? 'bulan' : 'paket') }}</span>
                            @endif
                        </div>
                        <ul class="space-y-5 mb-12 text-slate-600 font-semibold">
                            @foreach($plan->features_list as $feature)
                                <li class="flex items-center gap-3"><span class="material-symbols-outlined text-orange-500">check_circle</span> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('school.register', ['plan' => $plan->id]) }}" class="block text-center w-full py-5 rounded-2xl bg-orange-500 text-white font-bold text-lg shadow-xl shadow-orange-200 hover:scale-105 transition-all">
                            {{ $plan->cta_text }}
                        </a>
                    </div>
                @else
                    <!-- Regular Plan -->
                    <div class="p-10 bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-[2.5rem] transition-all hover:border-slate-600">
                        <h3 class="text-xl font-bold mb-2">{{ $plan->name }}</h3>
                        <p class="text-slate-400 mb-8">{{ $plan->description }}</p>
                        <div class="flex items-baseline gap-1 mb-8">
                            <span class="text-4xl font-black italic">
                                {{ $plan->price_display }}
                            </span>
                            @if($plan->price > 0)
                                <span class="text-slate-500">/ {{ $plan->billing_cycle == 'yearly' ? 'tahun' : ($plan->billing_cycle == 'monthly' ? 'bulan' : 'paket') }}</span>
                            @endif
                        </div>
                        <ul class="space-y-4 mb-10 text-slate-400 text-sm font-medium">
                            @foreach($plan->features_list as $feature)
                                <li class="flex items-center gap-3"><span class="material-symbols-outlined text-orange-400 text-sm">check_circle</span> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('school.register', ['plan' => $plan->id]) }}" class="block text-center w-full py-4 rounded-2xl border border-slate-600 font-bold hover:bg-slate-700 transition-colors">
                            {{ $plan->cta_text }}
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
