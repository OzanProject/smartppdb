@extends('public.layouts.marketing')

@section('title', 'Beranda')

@section('content')
    @include('public.partials.hero')
    @include('public.partials.stats_counter')

    <!-- Trust Section -->
    <section class="py-20 border-b border-slate-100 bg-white/40 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center mb-10">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Dipercaya oleh berbagai institusi pendidikan</p>
        </div>
        
        <div class="marquee-container">
            <div class="marquee-content flex gap-12 lg:gap-20 opacity-40 grayscale hover:grayscale-0 transition-all font-black italic text-2xl lg:text-3xl tracking-tighter text-slate-900">
                @if($schools->count() > 0)
                    @foreach($schools as $school)
                        <span>{{ $school->name }}</span>
                    @endforeach
                    <!-- Duplicate for Infinite Effect -->
                    @foreach($schools as $school)
                        <span>{{ $school->name }}</span>
                    @endforeach
                @else
                    <span>SMA Negeri</span>
                    <span>SMK Digital</span>
                    <span>Islamic School</span>
                    <span>Boarding School</span>
                    <span>Global Academy</span>
                    <!-- Duplicate -->
                    <span>SMA Negeri</span>
                    <span>SMK Digital</span>
                    <span>Islamic School</span>
                    <span>Boarding School</span>
                    <span>Global Academy</span>
                @endif
            </div>
        </div>
    </section>

    @include('public.partials.problem')
    @include('public.partials.how_it_works')
    @include('public.partials.features')
    @include('public.partials.pricing')
    @include('public.partials.testimonial')
    @include('public.partials.faq')
@endsection
