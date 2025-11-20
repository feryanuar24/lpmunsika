<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($data['puisi'] as $article)
            <a href="{{ route('detail', $article->slug) }}"
                class="kt-card overflow-hidden">

                <div>
                    @if ($article->thumbnail_url)
                        <img src="{{ $article->thumbnail_url }}" alt="Thumbnail Artikel {{ $article->title }}"
                            class="w-full h-48 object-cover" loading="lazy"
                            decoding="async" />
                    @endif
                </div>

                <div class="p-5 space-y-3">
                    <h3 class="text-lg font-semibold text-foreground">
                        {{ $article->title }}
                    </h3>

                    <div class="kt-badge kt-badge-outline kt-badge-primary rounded-full">
                        {{ $article->category->name }}
                    </div>

                    <div class="flex space-x-2">
                        @foreach ($article->tags as $tag)
                            <span class="kt-badge kt-badge-outline kt-badge-secondary rounded-full">
                                {{ $tag->name ?? $tag }}
                            </span>
                        @endforeach
                    </div>

                    <p class="text-sm text-muted-foreground">
                        {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 120, '...') }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
