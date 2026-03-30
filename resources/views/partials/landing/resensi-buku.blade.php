<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($data['resensi_buku'] as $article)
            <a href="{{ route('detail', $article->slug) }}"
                class="kt-card overflow-hidden">

                <div>
                    @if ($article->thumbnail)
                        <img src="{{ route('files', $article->thumbnail) }}" alt="Thumbnail artikel {{ $article->title }}"
                            class="w-full h-48 object-cover" loading="lazy"
                            decoding="async" />
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

                </div>
            </a>
        @endforeach
    </div>
</div>
