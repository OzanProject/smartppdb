<x-guest-layout :school="$school ?? null">
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Lupa Kata Sandi?</h1>
            <p class="text-slate-500 font-medium">Jangan panik! Kami akan membantu Anda mendapatkan akses kembali.</p>
        </div>

        <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
            <p class="text-sm text-indigo-700 leading-relaxed font-medium">
                {{ __('Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset password agar Anda bisa memilih password baru.') }}
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-green-600 bg-green-50 p-4 rounded-xl text-sm font-bold border border-green-100" :status="session('status')" />

        <form method="POST" action="{{ route('password.email', isset($school) ? ['school' => $school->slug] : []) }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Email Terdaftar</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" name="email" id="email" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                </div>
                @if($errors->has('email'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl font-bold text-lg shadow-xl shadow-slate-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                Kirim Tautan Reset
            </button>
        </form>

        <div class="pt-8 border-t border-slate-100 text-center">
            <a href="{{ route('login', isset($school) ? ['school' => $school->slug] : []) }}" class="text-sm font-bold text-primary-600 hover:text-primary-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Login
            </a>
        </div>
    </div>
</x-guest-layout>
