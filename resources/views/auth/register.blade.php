<x-guest-layout :school="$school ?? null">
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Daftar Akun Baru</h1>
            <p class="text-slate-500 font-medium">Lengkapi data di bawah ini untuk mulai mendaftar PPDB.</p>
        </div>

        <form method="POST" action="{{ route('register', isset($school) ? ['school' => $school->slug] : []) }}" class="space-y-5">
            <input type="hidden" name="school_id" value="{{ isset($school) ? $school->id : '' }}">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Nama Lengkap</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" name="name" id="name" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required autofocus autocomplete="name">
                </div>
                @if($errors->has('name'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Email Aktif</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" name="email" id="email" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
                </div>
                @if($errors->has('email'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                </div>
                @if($errors->has('password'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Konfirmasi Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="Ketik ulang kata sandi" required autocomplete="new-password">
                </div>
                @if($errors->has('password_confirmation'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>

            <button type="submit" class="w-full py-4 mt-2 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl font-bold text-lg shadow-xl shadow-slate-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                Daftar Akun Sekarang
            </button>
        </form>

        <div class="pt-8 border-t border-slate-100">
             <p class="text-center text-slate-500 font-medium">
                Sudah punya akun? <br>
                <a href="{{ route('login', isset($school) ? ['school' => $school->slug] : []) }}" class="inline-block mt-2 font-bold text-primary-600 hover:text-primary-700">Silakan Masuk di Sini &rarr;</a>
            </p>
        </div>
    </div>
</x-guest-layout>
