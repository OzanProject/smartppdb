<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Cek Status Pendaftaran - {{ $school->name }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-[#f7f9fc] text-[#191c1e] antialiased">
    <!-- Simple Header -->
    <nav class="bg-white border-b border-gray-100 py-4 mb-12">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ route('school.landing', $school->slug) }}" class="flex items-center gap-2 text-primary font-bold text-xl">
                 @if($school->logo)
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="h-8 w-auto">
                @endif
                {{ $school->name }}
            </a>
            <a href="{{ route('school.landing', $school->slug) }}" class="text-sm font-semibold text-gray-500 hover:text-primary">Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-6 pb-24">
        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold mb-4">STATUS TRACKER</span>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Cek Status Pendaftaran</h1>
            <p class="mt-4 text-gray-500 text-sm">Pantau proses pendaftaran Anda secara real-time dengan memasukkan data di bawah ini.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-8 flex items-start gap-3">
                <span class="material-symbols-outlined text-green-500">check_circle</span>
                <div>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(isset($error))
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl mb-8 flex items-start gap-3">
                <span class="material-symbols-outlined text-red-500">error</span>
                <p class="text-sm font-medium">{{ $error }}</p>
            </div>
        @endif

        <!-- Search Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <form action="{{ route('school.registration.track.submit', $school->slug) }}" method="POST" class="p-8">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor Pendaftaran</label>
                        <input type="text" name="registration_number" value="{{ old('registration_number', request('registration_number')) }}" placeholder="Contoh: REG-1-20260421-XXXX" class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 py-3 px-4" required>
                        <p class="mt-2 text-[10px] text-gray-400 italic">Masukkan nomor pendaftaran yang Anda dapatkan setelah mengirim formulir.</p>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-4 font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                        Cek Status Sekarang
                    </button>
                </div>
            </form>
        </div>

        @if(isset($registration))
            <!-- Result Section -->
            <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
                <div class="bg-blue-600 rounded-3xl p-8 text-white shadow-xl">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-1">Nama Pendaftar</p>
                            <h2 class="text-2xl font-bold">{{ $registration->personal_data['full_name'] ?? 'Data tidak terbaca' }}</h2>
                        </div>
                        <div class="bg-white/20 backdrop-blur-md rounded-xl px-4 py-2 text-center">
                            <p class="text-[10px] uppercase font-bold opacity-70">Status</p>
                            <p class="text-sm font-bold uppercase tracking-wide">{{ $registration->status }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-white/10 mt-6">
                        <div>
                            <p class="text-blue-100 text-[10px] font-bold uppercase tracking-wider">No. Pendaftaran</p>
                            <p class="font-mono text-sm">{{ $registration->registration_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-100 text-[10px] font-bold uppercase tracking-wider">Gelombang</p>
                            <p class="text-sm font-semibold">{{ $registration->admissionBatch->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-8 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">timeline</span>
                        Riwayat Pendaftaran
                    </h3>
                    
                    <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-blue-500 before:via-gray-100 before:to-transparent">
                        <!-- Step 1: Submited -->
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="absolute left-0 w-10 h-10 flex items-center justify-center bg-blue-600 rounded-full shadow-md text-white">
                                    <span class="material-symbols-outlined text-sm">check</span>
                                </div>
                                <div class="ml-14">
                                    <h4 class="font-bold text-sm text-gray-900">Formulir Terkirim</h4>
                                    <p class="text-xs text-gray-500 mt-1">Data Anda telah berhasil masuk ke sistem kami.</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-gray-300 uppercase">{{ $registration->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <!-- Step 2: Verification -->
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="absolute left-0 w-10 h-10 flex items-center justify-center {{ $registration->status != 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400' }} rounded-full border-4 border-white shadow-sm">
                                    <span class="material-symbols-outlined text-sm">{{ $registration->status != 'pending' ? 'check' : 'hourglass_top' }}</span>
                                </div>
                                <div class="ml-14">
                                    <h4 class="font-bold text-sm {{ $registration->status != 'pending' ? 'text-gray-900' : 'text-gray-400' }}">Verifikasi Berkas</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if($registration->status == 'pending')
                                            Petugas sedang dalam proses meninjau dokumen pendaftaran Anda.
                                        @else
                                            Berkas pendaftaran telah diverifikasi oleh petugas admin.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Selection/Accepted -->
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="absolute left-0 w-10 h-10 flex items-center justify-center {{ in_array($registration->status, ['accepted', 'rejected']) ? ($registration->status == 'accepted' ? 'bg-green-500' : 'bg-red-500') . ' text-white' : 'bg-gray-50 text-gray-200' }} rounded-full border-4 border-white shadow-sm">
                                    <span class="material-symbols-outlined text-sm">
                                        @if($registration->status == 'accepted') task_alt 
                                        @elseif($registration->status == 'rejected') cancel
                                        @else flag @endif
                                    </span>
                                </div>
                                <div class="ml-14">
                                    <h4 class="font-bold text-sm {{ in_array($registration->status, ['accepted', 'rejected']) ? 'text-gray-900' : 'text-gray-300' }}">Hasil Akhir</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if($registration->status == 'accepted')
                                            Selamat! Anda dinyatakan <span class="text-green-600 font-bold uppercase">DITERIMA</span> di {{ $school->name }}.
                                        @elseif($registration->status == 'rejected')
                                            Mohon maaf, Anda dinyatakan <span class="text-red-600 font-bold uppercase">BELUM LOLOS</span> seleksi tahun ini.
                                        @else
                                            Hasil seleksi akan diumumkan setelah proses verifikasi selesai.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($registration->note)
                        <div class="mt-10 p-4 bg-orange-50 rounded-2xl border border-orange-100">
                            <p class="text-[10px] font-bold text-orange-600 uppercase mb-2">Catatan dari Admin:</p>
                            <p class="text-sm text-orange-900 italic">"{{ $registration->note }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        @elseif(isset($searched))
             <div class="text-center py-10 opacity-30 italic">Pencarian baru saja dilakukan.</div>
        @endif
    </main>

    <footer class="text-center py-10 text-gray-400 text-xs mt-12">
        <p>© {{ date('Y') }} {{ $school->name }}. Sistem {{ $landingSettings['app_name'] ?? 'PPDB PRO' }}.</p>
    </footer>
</body>
</html>
