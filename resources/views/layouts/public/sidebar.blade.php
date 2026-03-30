<div class="kt-container-fixed space-y-5">
    <!-- Related Articles -->
    @if (!empty($data['related'] ?? null))
        <div>
            <h2
                class="text-3xl font-semibold mb-8 text-foreground border-border border-dashed border-b-2 pb-2 w-full">
                Lainnya</h2>
            <div class="space-y-5">
                @foreach ($data['related'] as $article)
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

                                <!-- Category -->
                                <div class="mt-2">
                                    <span class="kt-badge kt-badge-outline kt-badge-primary rounded-full">
                                        {{ $article->category->name }}
                                    </span>
                                </div>

                                <!-- Tags -->
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($article->tags as $tag)
                                        <span class="kt-badge kt-badge-outline kt-badge-secondary rounded-full">
                                            {{ $tag->name ?? $tag }}
                                        </span>
                                    @endforeach
                                </div>

                                <!-- Spacer biar deskripsi selalu di bawah -->
                                <div class="grow"></div>

                                <!-- Deskripsi -->
                                <p class="text-sm text-muted-foreground text-justify mt-3 line-clamp-3">
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
                                        <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- YouTube Embed -->
    <div>
        <h2
            class="text-3xl font-semibold mb-8 text-foreground border-border border-dashed border-b-2 pb-2 w-full">
            LPM Channel</h2>
        <div class="space-y-5">
            @foreach ($youtube as $embed)
                <div class="kt-card overflow-hidden">
                    <div
                        class="w-full embed-preview">
                        {!! $embed->embed_code !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Spotify Embed -->
    <div>
        <h2
            class="text-3xl font-semibold mb-8 text-foreground border-border border-dashed border-b-2 pb-2 w-full">
            Podcast NOL SKS</h2>
        <div class="space-y-5">
            @foreach ($spotify as $embed)
                <div class="kt-card overflow-hidden">
                    <div
                        class="w-full embed-preview">
                        {!! $embed->embed_code !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Categories -->
    <div>
        <h2
            class="text-3xl font-semibold mb-8 text-foreground border-border border-dashed border-b-2 pb-2 w-full">
            Kategori</h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <a href="{{ route('category', $category->slug) }}"
                    class="kt-badge kt-badge-primary kt-badge-outline rounded-full">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Tags -->
    <div>
        <h2
            class="text-3xl font-semibold mb-8 text-foreground border-border border-dashed border-b-2 pb-2 w-full">
            Tag</h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($tags as $tag)
                <a href="{{ route('tag', $tag->slug) }}"
                    class="kt-badge kt-badge-secondary kt-badge-outline rounded-full">{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
</div>

@push('styles')
    <style>
        .embed-preview {
            max-width: 100%;
            overflow-x: auto;
        }

        .embed-preview iframe,
        .embed-preview video,
        .embed-preview embed,
        .embed-preview object {
            max-width: 100%;
            width: 100%;
        }
    </style>
@endpush
