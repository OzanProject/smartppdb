<x-guest-layout :school="$school ?? null">
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Selamat Datang!</h1>
            <p class="text-slate-500 font-medium">Silakan masuk untuk mengelola pendaftaran Anda.</p>
        </div>

        <x-auth-session-status class="mb-4 text-green-600 bg-green-50 p-4 rounded-xl text-sm font-bold border border-green-100" :status="session('status')" />

        <form method="POST" action="{{ route('login', isset($school) ? ['school' => $school->slug] : []) }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Email Sekolah / Siswa</label>
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

            <div class="space-y-2">
                <div class="flex items-center justify-between ml-1">
                    <label for="password" class="text-sm font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request', isset($school) ? ['school' => $school->slug] : []) }}" class="text-xs font-bold text-primary-600 hover:text-primary-700">Lupa Sandi?</a>
                    @endif
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="••••••••" required>
                </div>
                @if($errors->has('password'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="w-5 h-5 text-primary-600 border-slate-300 rounded-lg focus:ring-primary-500 transition-all">
                <label for="remember" class="ml-3 text-sm font-semibold text-slate-600 select-none cursor-pointer">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl font-bold text-lg shadow-xl shadow-slate-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="pt-8 border-t border-slate-100">
             <p class="text-center text-slate-500 font-medium">
                @if(isset($school))
                    Belum punya akun siswa? <br>
                    <a href="{{ route('register', ['school' => $school->slug]) }}" class="inline-block mt-2 font-bold text-primary-600 hover:text-primary-700">Daftar di {{ $school->name }} &rarr;</a>
                @else
                    Ingin mendaftarkan sekolah Anda? <br>
                    <a href="{{ route('school.register') }}" class="inline-block mt-2 font-bold text-primary-600 hover:text-primary-700">Mulai Trial Gratis &rarr;</a>
                @endif
            </p>
        </div>
    </div>
</x-guest-layout>
