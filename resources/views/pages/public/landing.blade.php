@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed space-y-5">
        <div class="space-y-5">
            @if ($data['sliders']->isNotEmpty())
                @include('partials.landing.sliders')
            @endif
            @include('partials.landing.search')
            @include('partials.landing.pinned')
            @include('partials.landing.berita')
        </div>
        <div class="space-y-5">
            <h2 class="text-3xl font-semibold mb-8 text-foreground border-b-2 border-border border-dashed pb-2 w-full">Produk</h2>
            @include('partials.landing.buletin')
            @include('partials.landing.majalah')
        </div>
        <div class="space-y-5">
            <h2 class="text-3xl font-semibold mb-8 text-foreground border-b-2 border-border border-dashed pb-2 w-full">Karya Mahasiswa</h2>
            @include('partials.landing.resensi-buku')
            @include('partials.landing.review-film')
            @include('partials.landing.review-lagu')
            @include('partials.landing.opini')
            @include('partials.landing.esai')
            @include('partials.landing.artikel')
            @include('partials.landing.puisi')
            @include('partials.landing.cerpen')
        </div>
        <div>
            @include('partials.landing.gaya-mahasiswa')
        </div>
    </div>
@endsection
