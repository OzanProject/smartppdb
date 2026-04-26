<x-guest-layout>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Reset Kata Sandi</h1>
            <p class="text-slate-500 font-medium">Buat kata sandi baru yang kuat untuk akun Anda.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Email Anda</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" name="email" id="email" class="block w-full pl-11 pr-4 py-4 bg-slate-100 border border-slate-200 rounded-2xl text-slate-500 font-medium cursor-not-allowed outline-none" value="{{ old('email', $email) }}" required readonly>
                </div>
                @if($errors->has('email'))
                    <p class="text-xs text-red-500 font-bold ml-1 mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Kata Sandi Baru</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary-600 transition-colors">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="••••••••" required autofocus autocomplete="new-password">
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
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 font-medium focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl font-bold text-lg shadow-xl shadow-slate-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                Simpan Kata Sandi Baru
            </button>
        </form>
    </div>
</x-guest-layout>
