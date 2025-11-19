@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-semibold text-mon mb-2 border-b-4 inline-block pb-2">
                <i class="ki-filled ki-category text-mono mr-3"></i>
                Kategori: {{ $data['category']->name }}
            </h1>
            @if($data['category']->description)
                <p class="text-mono mt-4">
                    {{ $data['category']->description }}
                </p>
            @endif
            <p class="text-mono text-sm mt-2">
                Ditemukan {{ $data['articles']->total() }} artikel dalam kategori ini
            </p>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-col-1 lg:grid-cols-2 gap-6">
            @forelse ($data['articles'] as $article)
                <article class="kt-card overflow-hidden">
                    <a href="{{ route('detail', $article->slug) }}" class="block">
                        <!-- Article Image -->
                        @if ($article->thumbnail_url)
                            <div class="kt-card-media">
                                <img src="{{ $article->thumbnail_url }}"
                                     alt="Thumbnail Artikel {{ $article->title }}"
                                     class="w-full h-48 object-cover"
                                     loading="lazy"
                                     decoding="async">
                            </div>
                        @endif

                        <!-- Article Content -->
                        <div class="kt-card-body p-5">
                            <!-- Title -->
                            <h2 class="text-xl font-semibold text-mono mb-3 line-clamp-2 hover:text-primary-600 transition-colors">
                                {{ $article->title }}
                            </h2>

                            <!-- Category -->
                            @if ($article->category)
                                <div class="mb-3">
                                    <span class="kt-badge kt-badge-primary kt-badge-sm">
                                        <i class="ki-filled ki-category text-xs mr-1"></i>
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Tags -->
                            @if ($article->tags->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach ($article->tags as $tag)
                                        <a href="{{ route('tag', $tag->slug) }}"
                                           class="kt-badge kt-badge-outline kt-badge-sm hover:kt-badge-primary transition-colors">
                                            <i class="ki-filled ki-tag text-xs mr-1"></i>
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Excerpt -->
                            <p class="text-mono mt-3 line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 150) }}
                            </p>

                            <!-- Article Meta -->
                            <div class="flex items-center justify-between text-xs text-mono border-t border-mono pt-3">
                                <div class="flex items-center gap-2">
                                    <i class="ki-filled ki-profile-circle"></i>
                                    <span>{{ $article->user->name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ki-filled ki-calendar"></i>
                                    <span>{{ $article->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="kt-card text-center py-16">
                        <div class="kt-card-body">
                            <i class="ki-filled ki-file-search text-6xl text-mono mb-4"></i>
                            <h3 class="text-xl font-semibold text-mono mb-2">
                                Belum Ada Artikel
                            </h3>
                            <p class="text-mono">
                                Belum ada artikel yang dipublikasikan dalam kategori "{{ $data['category']->name }}" saat ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($data['articles']->hasPages())
            <div class="mt-7">
                <!-- Pagination Info -->
                <div class="text-center text-sm text-mono mb-4">
                    Menampilkan {{ $data['articles']->firstItem() }} - {{ $data['articles']->lastItem() }}
                    dari {{ $data['articles']->total() }} artikel
                </div>
                <!-- Pagination Links -->
                <div class="flex justify-center">
                    {{ $data['articles']->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
