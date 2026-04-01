@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed py-8">
        <!-- Page Header -->
        <div class="mb-8 space-y-3">
            <h1 class="text-3xl font-semibold text-foreground border-b-2 border-border border-dashed pb-2">
                Kategori: {{ $data['category']->name }}
            </h1>
            @if ($data['category']->description)
                <p class="text-muted-foreground">
                    {{ $data['category']->description }}
                </p>
            @endif
            <p class="text-muted-foreground">
                Ditemukan {{ $data['articles']->total() }} artikel dalam kategori ini
            </p>
        </div>

        <!-- Articles Grid -->
        @if ($data['articles']->count() > 0)
            <div class="grid grid-col-1 lg:grid-cols-2 gap-6">
                @foreach ($data['articles'] as $article)
                    <article>
                        <a href="{{ route('detail', $article->slug) }}" class="kt-card overflow-hidden">
                            <!-- Article Image -->
                            <div>
                                @if ($article->thumbnail)
                                    <img src="{{ route('files', $article->thumbnail) }}"
                                        alt="Thumbnail artikel {{ $article->title }}" class="w-full h-48 object-cover"
                                        loading="lazy" decoding="async">
                                @endif
                            </div>

                            <div class="p-5 flex flex-col h-full">

                                <!-- Judul -->
                                <h3 class="text-lg font-semibold text-foreground line-clamp-2 min-h-14">
                                    {{ $article->title }}
                                </h3>

                                <!-- Category & Tags -->
                                <div class="mt-2 space-x-2">
                                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary rounded-full">
                                        {{ $article->category->name }}
                                    </span>
                                    @foreach ($article->tags as $tag)
                                        <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-secondary rounded-full">
                                            {{ $tag->name ?? $tag }}
                                        </span>
                                    @endforeach
                                </div>

                                <!-- Spacer biar deskripsi selalu di bawah -->
                                <div class="grow"></div>

                                <!-- Deskripsi -->
                                <p class="text-sm text-muted-foreground text-justify mt-3 line-clamp-2">
                                    {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 120) }}
                                </p>

                                <!-- Article Meta -->
                                <div
                                    class="mt-3 flex items-center justify-between text-xs text-muted-foreground border-t border-border border-dashed pt-3">
                                    <div class="flex items-center space-x-2">
                                        <i class="ki-filled ki-profile-circle"></i>
                                        <span>{{ $article->user->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="ki-filled ki-calendar"></i>
                                        <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
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
                <p class="text-muted-foreground">Tidak ada artikel dalam kategori ini.</p>
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
                    {{ $data['articles']->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
