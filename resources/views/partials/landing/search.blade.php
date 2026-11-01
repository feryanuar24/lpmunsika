<section class="public-panel" aria-labelledby="landing-search-heading">
    <div class="flex flex-col gap-1 mb-4">
        <p id="landing-search-heading" class="text-lg font-semibold text-foreground">
            Temukan informasi yang Anda butuhkan
        </p>
        <p class="text-sm text-muted-foreground">
            Cari berita, pengumuman, dan artikel terbaru dengan kata kunci.
        </p>
    </div>

    <form action="{{ route('search') }}" method="GET" class="public-search flex items-center gap-2" role="search">
        <i class="ki-filled ki-magnifier text-lg text-muted-foreground ps-3" aria-hidden="true"></i>
        <label for="landing-search-input" class="sr-only">Kata kunci pencarian</label>
        <input id="landing-search-input" type="search" name="query" class="kt-input grow"
            placeholder="Cari berita, topik, atau kata kunci..." autocomplete="off" required>
        <button type="submit" class="kt-btn kt-btn-primary shrink-0" aria-label="Cari artikel">
            <span class="hidden sm:inline">Cari</span>
            <i class="ki-filled ki-magnifier sm:hidden"></i>
        </button>
    </form>

    @if (!empty($categories) && $categories->isNotEmpty())
        <div class="mt-4 flex flex-wrap items-center gap-2">
            <span class="text-xs font-medium text-muted-foreground me-1">Topik populer:</span>
            @foreach ($categories->take(6) as $category)
                <a href="{{ route('category', $category->slug) }}" class="public-chip">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    @endif
</section>
