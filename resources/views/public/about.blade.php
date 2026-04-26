@extends('public.layouts.marketing')

@section('title', 'Tentang Kami')

@section('content')
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mb-8 tracking-tight">Tentang <span class="gradient-text">Kami</span></h1>
            <p class="text-slate-500 text-lg lg:text-xl leading-relaxed">
                Kami adalah platform SaaS PPDB terdepan yang berkomitmen untuk memodernisasi ekosistem pendidikan di Indonesia melalui teknologi digital yang inklusif dan efisien.
            </p>
        </div>

        <div class="bg-white p-10 lg:p-20 rounded-[2.5rem] shadow-2xl border border-slate-100">
            <div class="prose prose-lg prose-indigo max-w-none">
                {!! $landingSettings['page_about_content'] ?? '<p>Konten belum diatur.</p>' !!}
            </div>
        </div>
    </div>
</section>
@endsection
