<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Formulir Pendaftaran - {{ $school->name }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Manrope', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.82); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.4); }
        input, select, textarea { 
            background: rgba(248, 250, 252, 0.5) !important;
            transition: all 0.3s ease;
        }
        input:focus, select:focus, textarea:focus {
            background: white !important;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-[#f0f4f8] min-h-screen antialiased text-[#1e293b]">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-md border-b border-white py-4 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="{{ route('school.landing', $school->slug) }}" class="flex items-center gap-2 text-blue-900 font-bold text-xl font-headline">
                @if($school->logo)
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="h-8 w-auto">
                @endif
                {{ $school->name }}
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('school.registration.track', $school->slug) }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-100 transition-all">Cek Status</a>
                <a href="{{ route('school.landing', $school->slug) }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Batal</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-16">
        <div class="mb-12 text-center">
            <span class="inline-block px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-full mb-4 tracking-widest uppercase">OFFICIAL PPDB PORTAL</span>
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Formulir Pendaftaran Siswa</h1>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto">Silakan lengkapi data calon siswa baru sesuai dengan dokumen asli yang sah.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-3xl mb-10 flex items-start gap-4">
                <span class="material-symbols-outlined mt-0.5">error</span>
                <div class="text-sm">
                    <p class="font-bold mb-1 text-red-700 uppercase tracking-wide">Terjadi Kesalahan Input:</p>
                    <ul class="list-disc list-inside opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('school.registration.submit', $school->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <!-- Default Section: Jalur & Batch -->
            <div class="glass-card rounded-[40px] p-8 md:p-12 shadow-2xl shadow-blue-900/5">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined">event_available</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Gelombang Akademik</h2>
                        <p class="text-xs text-slate-400 font-medium">Pilih periode pendaftaran aktif</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Pilih Jalur / Gelombang</label>
                        <select name="admission_batch_id" class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 py-4 px-6 text-slate-700 font-medium shadow-sm transition-all" required>
                            @foreach($activeBatches as $batch)
                                <option value="{{ $batch->id }}" {{ old('admission_batch_id') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }} (Tahun Ajaran {{ $batch->academicYear->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Dynamic Sections -->
            @php 
                $icons = ['person', 'family_restroom', 'school', 'description', 'assignment_ind', 'contact_emergency'];
            @endphp

            @foreach($sections as $index => $section)
            <div class="glass-card rounded-[40px] p-8 md:p-12 shadow-2xl shadow-blue-900/5 transition-all hover:shadow-blue-900/10">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined">{{ $icons[$index % count($icons)] }}</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">{{ $section->name }}</h2>
                        <p class="text-xs text-slate-400 font-medium">Lengkapi bagian data ini dengan teliti</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    @foreach($section->fields as $field)
                    <div class="{{ $field->type == 'textarea' ? 'md:col-span-2' : '' }}">
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-3">
                            {{ $field->label }} 
                            @if($field->is_required) <span class="text-red-500 ml-1 opacity-70">*</span> @endif
                        </label>

                        @if($field->type == 'select')
                            <select name="field_{{ $field->id }}" 
                                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 py-4 px-6 text-slate-700 font-medium shadow-sm transition-all"
                                {{ $field->is_required ? 'required' : '' }}>
                                <option value="">Pilih {{ $field->label }}...</option>
                                @foreach($field->options as $option)
                                    <option value="{{ $option }}" {{ old('field_'.$field->id) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        @elseif($field->type == 'textarea')
                            <textarea name="field_{{ $field->id }}" rows="4"
                                placeholder="{{ $field->help_text ?? 'Masukkan data...' }}"
                                class="w-full rounded-[24px] border-slate-200 focus:border-blue-500 focus:ring-blue-500 py-4 px-6 text-slate-700 font-medium shadow-sm transition-all"
                                {{ $field->is_required ? 'required' : '' }}>{{ old('field_'.$field->id) }}</textarea>
                        @elseif($field->type == 'file')
                            <div class="relative group">
                                <input type="file" name="field_{{ $field->id }}" 
                                    class="w-full rounded-2xl border-2 border-dashed border-slate-200 file:mr-4 file:py-4 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer py-2 px-2"
                                    {{ $field->is_required ? 'required' : '' }}>
                                <div class="mt-2 flex items-center gap-2 text-slate-400 text-[10px] font-bold px-2">
                                    <span class="material-symbols-outlined text-sm">info</span>
                                    FORMAT: JPG, PNG, PDF (MAX 2MB)
                                </div>
                            </div>
                        @else
                            <input type="{{ $field->type }}" name="field_{{ $field->id }}" 
                                value="{{ old('field_'.$field->id) }}"
                                placeholder="{{ $field->help_text ?? 'Contoh data...' }}"
                                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 py-4 px-6 text-slate-700 font-medium shadow-sm transition-all"
                                {{ $field->is_required ? 'required' : '' }}>
                        @endif
                        
                        @if($field->help_text && $field->type != 'textarea')
                            <p class="mt-2 text-[10px] text-slate-400 italic ml-2">{{ $field->help_text }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Submit Action -->
            <div class="pt-10">
                <button type="submit" class="group w-full bg-blue-600 text-white py-6 rounded-[32px] font-bold text-xl hover:bg-blue-700 transition-all shadow-2xl shadow-blue-600/40 transform hover:-translate-y-1 overflow-hidden relative">
                    <span class="relative z-10 flex items-center justify-center gap-3">
                        Kirim Pendaftaran
                        <span class="material-symbols-outlined group-hover:translate-x-2 transition-transform">arrow_forward</span>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </button>
                <div class="mt-8 flex items-center justify-center gap-10 opacity-40">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-green-600">verified_user</span>
                        <span class="text-[10px] font-bold">DATA TERINKRIPSI</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-blue-600">cloud_done</span>
                        <span class="text-[10px] font-bold">SERVER AMAN</span>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <footer class="bg-white/50 py-12 text-center text-slate-400 text-xs mt-24 border-t border-slate-100">
        <p>© {{ date('Y') }} {{ $school->name }}. Portal PPDB Resmi dikembangkan dengan teknologi PPDB Pro.</p>
    </footer>
</body>
</html>
