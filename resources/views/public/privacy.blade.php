@extends('public.layouts.marketing')

@section('title', 'Kebijakan Privasi')

@section('content')
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-slate-50">
    <div class="max-w-4xl mx-auto px-6 relative">
        <div class="bg-white p-12 lg:p-20 rounded-[3rem] shadow-2xl border border-slate-100">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-10 tracking-tight">Kebijakan <span class="text-indigo-600">Privasi</span></h1>
            
            <div class="prose prose-lg prose-slate max-w-none">
                {!! $landingSettings['page_privacy_content'] ?? '<p>Konten belum diatur.</p>' !!}
                
                <div class="mt-16 p-8 bg-indigo-50 rounded-3xl border border-indigo-100 italic text-indigo-700 text-sm">
                    Kebijakan ini diperbarui terakhir pada: {{ date('d M Y') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
