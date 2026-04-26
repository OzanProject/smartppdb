@extends('public.layouts.marketing')

@section('title', 'Fitur & Solusi')

@section('content')
    <div class="pt-20">
        @include('public.partials.features')
    </div>
    @include('public.partials.problem')
@endsection
