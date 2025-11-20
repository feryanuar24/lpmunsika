@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed py-8">
        <!-- Page Header -->
        <div class="mb-8 space-y-3">
            <h1 class="text-3xl font-semibold text-foreground border-b-2 border-border border-dashed pb-2">
                Hasil Pencarian
            </h1>
            @if ($data['query'])
                <p class="text-muted-foreground">
                    Menampilkan hasil pencarian untuk: <span
                        class="font-medium text-foreground">"{{ $data['query'] }}"</span>
                </p>
                <p class="text-muted-foreground">
                    Ditemukan {{ $data['articles']->total() }} artikel
                </p>
            @else
                <p class="text-muted-foreground">Silakan masukkan kata kunci untuk mencari artikel</p>
            @endif
        </div>

        <!-- Search Form -->
        <div class="mb-8">
            <form action="{{ route('search') }}" method="GET" class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="q" value="{{ $data['query'] }}"
                        placeholder="Cari artikel, kategori, tag, atau penulis..." class="kt-input w-full" autofocus>
                </div>
                <button type="submit" class="kt-btn kt-btn-mono">
                    <i class="ki-filled ki-magnifier mr-2"></i>
                </button>
            </form>
        </div>

        <!-- Articles Grid -->
        @if ($data['articles']->count() > 0)
            <div class="grid grid-col-1 lg:grid-cols-2 gap-6">
                @foreach ($data['articles'] as $article)
                    <article>
                        <a href="{{ route('detail', $article->slug) }}" class="kt-card overflow-hidden">
                            <!-- Article Image -->
                            <div>
                                @if ($article->thumbnail_url)
                                    <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                                        class="w-full h-48 object-cover" loading="lazy" decoding="async">
                                @endif
                            </div>

                            <!-- Article Content -->
                            <div class="space-y-3 p-5">
                                <!-- Title -->
                                <h2 class="text-lg font-semibold text-foreground">
                                    {{ $article->title }}
                                </h2>

                                <!-- Category -->
                                @if ($article->category)
                                    <span class="kt-badge kt-badge-primary kt-badge-outline rounded-full">
                                        {{ $article->category->name }}
                                    </span>
                                @endif

                                <!-- Tags -->
                                @if ($article->tags->count() > 0)
                                    <div class="flex space-x-2">
                                        @foreach ($article->tags as $tag)
                                            <span class="kt-badge kt-badge-secondary kt-badge-outline rounded-full">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Content Excerpt -->
                                <p class="text-sm text-muted-foreground">
                                    {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 120, '...') }}
                                </p>

                                <!-- Article Meta -->
                                <div
                                    class="flex items-center justify-between text-xs text-muted-foreground border-t border-border border-dashed pt-3">
                                    <div class="flex items-center space-x-2">
                                        <i class="ki-filled ki-profile-circle"></i>
                                        <span>{{ $article->user->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="ki-filled ki-calendar"></i>
                                        <span>{{ $article->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="flex justify-center w-full">
                <p class="text-muted-foreground">Tidak ada artikel yang ditemukan.</p>
            </div>
        @endif

        <!-- Pagination -->
        @if ($data['articles']->hasPages())
            <div class="mt-7">
                <!-- Pagination Info -->
                <div class="text-center text-sm text-muted-foreground mb-4">
                    Menampilkan {{ $data['articles']->firstItem() }} - {{ $data['articles']->lastItem() }}
                    dari {{ $data['articles']->total() }} artikel
                </div>
                <!-- Pagination Links -->
                <div class="flex justify-center">
                    {{ $data['articles']->appends(['q' => $data['query']])->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
