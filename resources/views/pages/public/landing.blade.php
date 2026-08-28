@extends('layouts.public.base')

@section('content')
    <div class="space-y-5">
        <div class="space-y-5">
            @if ($data['sliders']->isNotEmpty())
                @include('partials.landing.sliders')
            @endif
            @include('partials.landing.search')
            @include('partials.landing.pinned')

            <!-- Dynamically render categories -->
            @forelse($data['categories'] as $categoryName => $categoryInfo)
                @if ($categoryInfo['type'] === 'standalone')
                    <!-- Standalone category (no children) -->
                    <div class="space-y-3">
                        <h2
                            class="text-3xl font-semibold mb-8 text-foreground border-b-2 border-border border-dashed pb-2 w-full">
                            {{ $categoryName }}
                        </h2>
                        @if ($categoryInfo['articles']->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($categoryInfo['articles'] as $article)
                                    <div class="kt-card overflow-hidden">
                                        <a href="{{ route('detail', $article->slug) }}" class="block">
                                            @if ($article->thumbnail)
                                                <img src="{{ route('files', $article->thumbnail) }}"
                                                    alt="{{ $article->title }}" class="w-full h-48 object-cover">
                                            @else
                                                <div class="w-full h-48 bg-muted"></div>
                                            @endif
                                        </a>
                                        <div class="p-4 flex flex-col justify-between h-full">
                                            <h3 class="font-semibold text-lg line-clamp-2">
                                                <a href="{{ route('detail', $article->slug) }}" class="hover:text-primary">
                                                    {{ $article->title }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-muted-foreground mt-2 line-clamp-3 text-left">
                                                {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 120) }}
                                            </p>
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
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Parent category with children -->
                    <div class="space-y-5">
                        <h2
                            class="text-3xl font-semibold mb-8 text-foreground border-b-2 border-border border-dashed pb-2 w-full">
                            {{ $categoryName }}
                        </h2>
                        @forelse($categoryInfo['children'] as $childName => $articles)
                            <div class="space-y-3">
                                <h3 class="text-xl font-semibold text-foreground">{{ $childName }}</h3>
                                @if ($articles->isNotEmpty())
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($articles as $article)
                                            <div class="kt-card overflow-hidden">
                                                <a href="{{ route('detail', $article->slug) }}" class="block">
                                                    @if ($article->thumbnail)
                                                        <img src="{{ route('files', $article->thumbnail) }}"
                                                            alt="{{ $article->title }}" class="w-full h-40 object-cover">
                                                    @else
                                                        <div class="w-full h-40 bg-muted"></div>
                                                    @endif
                                                </a>
                                                <div class="p-4 flex flex-col justify-between h-full">
                                                    <h4 class="font-semibold text-lg line-clamp-2">
                                                        <a href="{{ route('detail', $article->slug) }}"
                                                            class="hover:text-primary">
                                                            {{ $article->title }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-sm text-muted-foreground mt-2 line-clamp-3 text-left">
                                                        {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 120) }}
                                                    </p>
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
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-muted-foreground">Belum ada artikel</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-muted-foreground">Belum ada sub-kategori</p>
                        @endforelse
                    </div>
                @endif
            @empty
                <p class="text-center py-8 text-muted-foreground">Belum ada kategori</p>
            @endforelse
        </div>
    </div>
@endsection
