<section id="faq" class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 relative">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">
                {{ $landingSettings['faq_title'] ?? 'Pertanyaan Umum' }}
            </h2>
            <p class="text-slate-500 text-lg leading-relaxed">
                {{ $landingSettings['faq_subtitle'] ?? 'Masih punya pertanyaan? Kami siap membantu menjawab keraguan Anda.' }}
            </p>
        </div>

        <div class="space-y-6">
            @for($i = 1; $i <= 4; $i++)
                @if(!empty($landingSettings['faq_'.$i.'_q']))
                <div class="group bg-slate-50 rounded-3xl p-8 border border-transparent hover:border-indigo-100 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-start gap-4">
                        <span class="w-8 h-8 bg-indigo-600 text-white rounded-lg flex-shrink-0 flex items-center justify-center text-sm font-black italic">Q</span>
                        {{ $landingSettings['faq_'.$i.'_q'] }}
                    </h3>
                    <div class="pl-12">
                        <p class="text-slate-500 leading-relaxed">
                            {{ $landingSettings['faq_'.$i.'_a'] }}
                        </p>
                    </div>
                </div>
                @endif
            @endfor
        </div>
    </div>
</section>
