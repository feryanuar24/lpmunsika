@extends('layouts.public.base')

@section('content')
    <div class="space-y-10 lg:space-y-12">
        <!-- Hero: Slider & Pencarian -->
        <div class="space-y-5">
            @if ($data['sliders']->isNotEmpty())
                @include('partials.landing.sliders')
            @endif
            @include('partials.landing.search')
        </div>

        <!-- Sorotan -->
        @if ($data['pinned']->isNotEmpty())
            @include('partials.landing.pinned')
        @endif

        <!-- Dynamically render categories -->
        @forelse($data['categories'] as $categoryName => $categoryInfo)
            @if ($categoryInfo['type'] === 'standalone')
                <!-- Standalone category (no children) -->
                @if ($categoryInfo['articles']->isNotEmpty())
                    <section aria-labelledby="category-{{ $categoryInfo['slug'] }}">
                        @include('partials.landing.section-header', [
                            'id' => 'category-' . $categoryInfo['slug'],
                            'title' => $categoryName,
                            'url' => route('category', $categoryInfo['slug']),
                        ])
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($categoryInfo['articles'] as $article)
                                @include('partials.landing.article-card', ['article' => $article])
                            @endforeach
                        </div>
                    </section>
                @endif
            @else
                <!-- Parent category with children -->
                @php
                    $filledChildren = collect($categoryInfo['children'])->filter(
                        fn($child) => $child['articles']->isNotEmpty(),
                    );
                @endphp
                @if ($filledChildren->isNotEmpty())
                    <section aria-labelledby="category-{{ $categoryInfo['slug'] }}">
                        @include('partials.landing.section-header', [
                            'id' => 'category-' . $categoryInfo['slug'],
                            'title' => $categoryName,
                        ])
                        <div class="space-y-8">
                            @foreach ($filledChildren as $childName => $child)
                                <div>
                                    <div class="flex items-center justify-between gap-4 mb-4">
                                        <h3 class="public-subheading">{{ $childName }}</h3>
                                        <a href="{{ route('category', $child['slug']) }}" class="public-see-all shrink-0">
                                            Lihat semua
                                            <i class="ki-filled ki-arrow-right text-xs"></i>
                                        </a>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach ($child['articles'] as $article)
                                            @include('partials.landing.article-card', ['article' => $article])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endif
        @empty
            <div class="public-panel text-center py-10">
                <i class="ki-filled ki-document text-4xl text-muted-foreground"></i>
                <p class="mt-3 text-muted-foreground">Belum ada kategori berita yang tersedia.</p>
            </div>
        @endforelse
    </div>
@endsection
