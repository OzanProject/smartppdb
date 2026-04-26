@extends('public.layouts.marketing')

@section('title', 'Kontak Kami')

@section('content')
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid lg:grid-cols-2 gap-20 items-start">
            <div>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mb-8 tracking-tight">Hubungi <span class="gradient-text">Tim Kami</span></h1>
                <p class="text-slate-500 text-lg lg:text-xl leading-relaxed mb-12">
                    Punya pertanyaan atau butuh demo khusus untuk sekolah Anda? Tim kami siap melayani Anda kapan saja.
                </p>

                <div class="space-y-8">
                    @if(!empty($landingSettings['app_address']))
                    <div class="flex items-start gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div>
                            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Alamat Kantor</div>
                            <div class="text-slate-900 text-lg font-bold">{{ $landingSettings['app_address'] }}</div>
                        </div>
                    </div>
                    @endif

                    @if(!empty($landingSettings['app_phone']))
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                        <div>
                            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">WhatsApp / Telepon</div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $landingSettings['app_phone']) }}" class="text-slate-900 text-lg font-bold hover:text-indigo-600 transition-colors">{{ $landingSettings['app_phone'] }}</a>
                        </div>
                    </div>
                    @endif

                    @if(!empty($landingSettings['app_email']))
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Email Support</div>
                            <div class="text-slate-900 text-lg font-bold">{{ $landingSettings['app_email'] }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-12 rounded-[3rem] shadow-2xl border border-slate-100 relative">
                <div class="absolute -top-12 -left-12 w-32 h-32 bg-orange-100 blur-[80px] rounded-full opacity-50"></div>
                <h2 class="text-3xl font-bold text-slate-900 mb-8">Kirim Pesan</h2>
                <form action="#" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                            <input type="text" placeholder="John Doe" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-600 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Nama Sekolah</label>
                            <input type="text" placeholder="SMA Negeri 1" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-600 transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Email Aktif</label>
                        <input type="email" placeholder="john@example.com" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-600 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Pesan Anda</label>
                        <textarea rows="4" placeholder="Bagaimana kami bisa membantu Anda?" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-600 transition-all"></textarea>
                    </div>
                    <button type="submit" class="w-full btn-premium text-white py-5 rounded-2xl font-bold text-lg shadow-xl shadow-indigo-100">
                        Kirim Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
