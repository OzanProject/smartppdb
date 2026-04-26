@extends('public.layouts.marketing')

@section('title', 'Daftar Sekolah Baru')

@section('content')
<div class="min-h-screen pt-32 pb-20 bg-slate-50 flex items-center justify-center relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-100 rounded-full blur-[120px] opacity-50"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-100 rounded-full blur-[120px] opacity-30"></div>

    <div class="max-w-6xl w-full px-6 relative flex flex-col lg:flex-row gap-12 items-start">
        <!-- Left Side: Info -->
        <div class="lg:w-1/2">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 text-sm font-bold mb-8">
                <span class="material-symbols-outlined text-sm">rocket_launch</span>
                Mulai Digitalisasi Sekarang
            </div>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-8 tracking-tight">
                Daftarkan Sekolah Anda di <span class="gradient-text">{{ $landingSettings['app_name'] ?? 'PPDB Pro' }}</span>
            </h1>
            
            <div class="space-y-6">
                <div class="flex gap-4 p-6 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-1">Setup Instan</h4>
                        <p class="text-slate-500 text-sm">Dashboard admin langsung aktif setelah registrasi selesai.</p>
                    </div>
                </div>
                
                <div class="flex gap-4 p-6 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-1">Keamanan Data Terjamin</h4>
                        <p class="text-slate-500 text-sm">Data pendaftar terenkripsi dan tersimpan di server cloud yang aman.</p>
                    </div>
                </div>

                <div class="flex gap-4 p-6 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-1">Free Trial 14 Hari</h4>
                        <p class="text-slate-500 text-sm">Coba semua fitur premium secara gratis tanpa biaya apapun.</p>
                    </div>
                </div>
            </div>

            <!-- Payment Logos -->
            <div class="mt-12 flex items-center gap-6 opacity-40">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dan_Nama_BCA.svg" alt="BCA" class="h-5">
                <img src="https://upload.wikimedia.org/wikipedia/id/f/fa/Bank_Mandiri_logo.svg" alt="Mandiri" class="h-5">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_Midtrans.png" alt="Midtrans" class="h-5">
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="lg:w-1/2 w-full">
            <div class="bg-white rounded-[2.5rem] p-10 lg:p-12 shadow-2xl border border-slate-100">
                <form method="POST" action="{{ route('school.register.store') }}">
                    @csrf
                    
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Buat Akun Sekolah</h3>
                        <p class="text-slate-500">Lengkapi data berikut untuk memulai.</p>
                    </div>

                    <!-- Selected Plan -->
                    <div class="mb-8 p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined">inventory_2</span>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Paket Terpilih</div>
                                <div class="font-bold text-slate-900" id="display_plan_name">{{ $selectedPlan->name ?? 'Pilih Paket' }}</div>
                            </div>
                        </div>
                        <button type="button" class="text-indigo-600 font-bold text-sm hover:underline" onclick="document.getElementById('plan_selector_modal').classList.remove('hidden')">Ganti</button>
                    </div>
                    <input type="hidden" name="pricing_plan_id" id="pricing_plan_id" value="{{ $selectedPlan->id ?? '' }}">

                    <div class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Nama Sekolah</label>
                                <input type="text" name="school_name" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Contoh: SMA Negeri 1 Jakarta" value="{{ old('school_name') }}" required>
                                @error('school_name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Jenjang Sekolah</label>
                                <select name="education_level" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                                    <option value="">Pilih Jenjang</option>
                                    <option value="SD/MI" {{ old('education_level') == 'SD/MI' ? 'selected' : '' }}>SD / MI</option>
                                    <option value="SMP/MTs" {{ old('education_level') == 'SMP/MTs' ? 'selected' : '' }}>SMP / MTs</option>
                                    <option value="SMA/MA" {{ old('education_level') == 'SMA/MA' ? 'selected' : '' }}>SMA / MA</option>
                                    <option value="SMK" {{ old('education_level') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    <option value="Perguruan Tinggi" {{ old('education_level') == 'Perguruan Tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                    <option value="Lainnya" {{ old('education_level') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('education_level') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">NPSN Sekolah</label>
                            <input type="text" name="npsn" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="8 digit angka" value="{{ old('npsn') }}" required>
                            @error('npsn') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Nama Admin</label>
                            <input type="text" name="name" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Nama lengkap pengelola" value="{{ old('name') }}" required>
                            @error('name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Email Admin</label>
                            <input type="email" name="email" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="email@sekolah.sch.id" value="{{ old('email') }}" required>
                            @error('email') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Password</label>
                                <input type="password" name="password" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="••••••••" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Konfirmasi</label>
                                <input type="password" name="password_confirmation" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="••••••••" required>
                            </div>
                            @error('password') <span class="text-red-500 text-xs ml-1 col-span-2">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="w-full py-5 rounded-2xl bg-indigo-600 text-white font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-[1.02] transition-all">
                            Daftarkan Sekarang
                        </button>
                        <p class="mt-6 text-center text-slate-400 text-sm">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Plan Selector Modal -->
<div id="plan_selector_modal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="bg-white rounded-[2.5rem] w-full max-w-2xl relative p-10 overflow-hidden">
        <h3 class="text-2xl font-bold text-slate-900 mb-6">Pilih Paket Langganan</h3>
        <div class="grid gap-4">
            @foreach($plans as $plan)
                <button type="button" class="flex items-center justify-between p-6 rounded-2xl border-2 {{ ($selectedPlan->id ?? null) == $plan->id ? 'border-indigo-600 bg-indigo-50' : 'border-slate-100 hover:border-indigo-200' }} transition-all text-left group" 
                        onclick="selectPlan('{{ $plan->id }}', '{{ $plan->name }}')">
                    <div>
                        <div class="font-bold text-slate-900 text-lg">{{ $plan->name }}</div>
                        <div class="text-slate-500 text-sm">{{ $plan->description }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-black text-indigo-600 text-xl">{{ $plan->price_display }}</div>
                        <div class="text-slate-400 text-xs">per bulan</div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    function selectPlan(id, name) {
        document.getElementById('pricing_plan_id').value = id;
        document.getElementById('display_plan_name').innerText = name;
        document.getElementById('plan_selector_modal').classList.add('hidden');
    }
</script>
@endpush

@endsection
