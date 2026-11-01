{{-- Kartu artikel standar (konsisten dengan halaman kategori, tag, dan pencarian) --}}
<article class="h-full">
    <a href="{{ route('detail', $article->slug) }}" class="kt-card overflow-hidden h-full">
        <!-- Article Image -->
        <div class="relative">
            @if ($article->thumbnail)
                <img src="{{ route('files', $article->thumbnail) }}" alt="Thumbnail artikel {{ $article->title }}"
                    class="w-full h-48 object-cover" loading="lazy" decoding="async">
            @else
                <div class="public-thumb-placeholder h-48">
                    <i class="ki-filled ki-picture text-3xl"></i>
                </div>
            @endif
        </div>

        <div class="p-5 flex flex-col grow">
            <!-- Category & Tags -->
            <div class="flex flex-wrap gap-2">
                @if ($article->category)
                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-primary rounded-full">
                        {{ $article->category->name }}
                    </span>
                @endif
                @foreach ($article->tags->take(2) as $tag)
                    <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-secondary rounded-full">
                        {{ $tag->name ?? $tag }}
                    </span>
                @endforeach
            </div>

            <!-- Judul -->
            <h3 class="mt-3 text-lg font-semibold leading-snug text-foreground line-clamp-2 min-h-14">
                {{ $article->title }}
            </h3>

            <!-- Deskripsi -->
            <p class="text-sm text-muted-foreground text-left mt-2 line-clamp-3">
                {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 140) }}
            </p>

            <!-- Spacer biar meta selalu di bawah -->
            <div class="grow"></div>

            <!-- Article Meta -->
            <div
                class="mt-4 flex items-center justify-between gap-3 text-xs text-muted-foreground border-t border-border border-dashed pt-3">
                <div class="flex items-center gap-1.5 min-w-0">
                    <i class="ki-filled ki-profile-circle"></i>
                    <span class="truncate">{{ $article->user->name ?? 'Redaksi' }}</span>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <i class="ki-filled ki-calendar"></i>
                    <time datetime="{{ $article->created_at->toDateString() }}">
                        {{ $article->created_at->translatedFormat('d M Y') }}
                    </time>
                </div>
            </div>
        </div>
    </a>
</article>

