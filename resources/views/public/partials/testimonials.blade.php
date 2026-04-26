<?php
/********************************************************************************
 * testimonials.blade.php
 * Testimonials partial for the landing page.
 * Content is dynamic and configurable via the Super Admin panel.
 ********************************************************************************/
?>
<section id="testimonials" class="py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-slate-900 mb-4">
                {{ $settings['testimonial_title'] ?? 'Apa Kata Mereka?' }}
            </h2>
            <p class="text-slate-500 max-w-2xl mx-auto">
                {{ $settings['testimonial_subtitle'] ?? 'Dengarkan pengalaman langsung dari kepala sekolah dan panitia PPDB yang telah menggunakan sistem kami.' }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @if(isset($testimonials) && $testimonials->count() > 0)
                @foreach($testimonials as $t)
                    <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex gap-1 mb-6 text-orange-400">
                            @for($i=0; $i<$t->rating; $i++)
                                <span class="material-symbols-outlined text-sm filled">star</span>
                            @endfor
                        </div>
                        <p class="text-slate-600 mb-8 italic leading-relaxed">
                            "{{ $t->content }}"
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center border border-slate-100 overflow-hidden shadow-sm">
                                @if($t->school->logo)
                                    <img src="{{ asset('storage/' . $t->school->logo) }}" class="w-full h-full object-contain p-1">
                                @else
                                    <span class="text-indigo-600 font-bold">{{ substr($t->school->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 line-clamp-1">{{ $t->user->name }}</div>
                                <div class="text-xs text-slate-500 font-medium">{{ $t->school->name }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback static content if no real testimonials yet -->
                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex gap-1 mb-6 text-orange-400">
                        @for($i=0; $i<5; $i++)
                            <span class="material-symbols-outlined text-sm filled">star</span>
                        @endfor
                    </div>
                    <p class="text-slate-600 mb-8 italic leading-relaxed">
                        "Sistem ini sangat membantu panitia kami dalam menyeleksi ribuan pendaftar setiap tahunnya."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">A</div>
                        <div>
                            <div class="font-bold text-slate-900">H. Ahmad Syukri</div>
                            <div class="text-xs text-slate-500 font-medium">Kepala Sekolah SMAN 1</div>
                        </div>
                    </div>
                </div>
                <!-- ... other fallbacks ... -->
                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex gap-1 mb-6 text-orange-400">@for($i=0; $i<5; $i++) <span class="material-symbols-outlined text-sm filled">star</span> @endfor</div>
                    <p class="text-slate-600 mb-8 italic leading-relaxed">"Proses pendaftaran jadi jauh lebih cepat. Orang tua siswa tidak perlu lagi antre panjang."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">S</div>
                        <div>
                            <div class="font-bold text-slate-900">Ibu Siti Aminah</div>
                            <div class="text-xs text-slate-500 font-medium">Panitia PPDB SMPN 2</div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex gap-1 mb-6 text-orange-400">@for($i=0; $i<5; $i++) <span class="material-symbols-outlined text-sm filled">star</span> @endfor</div>
                    <p class="text-slate-600 mb-8 italic leading-relaxed">"Fitur laporan otomatisnya sangat membantu kami saat rapat evaluasi dengan dinas pendidikan."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">P</div>
                        <div>
                            <div class="font-bold text-slate-900">Bpk. Putu Gede</div>
                            <div class="text-xs text-slate-500 font-medium">Operator Yayasan</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .material-symbols-outlined.filled {
        font-variation-settings: 'FILL' 1;
    }
</style>
