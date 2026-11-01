<section aria-labelledby="sorotan-heading">
    @include('partials.landing.section-header', [
        'id' => 'sorotan-heading',
        'title' => 'Sorotan',
        'subtitle' => 'Berita pilihan redaksi yang wajib Anda baca.',
    ])

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($data['pinned'] as $index => $article)
            @if ($index === 0)
                <!-- Featured / Headline -->
                <article class="md:col-span-2">
                    <a href="{{ route('detail', $article->slug) }}" class="kt-card public-featured overflow-hidden">
                        <div class="public-featured-media">
                            @if ($article->thumbnail)
                                <img src="{{ route('files', $article->thumbnail) }}"
                                    alt="Thumbnail artikel {{ $article->title }}" class="w-full h-full object-cover"
                                    fetchpriority="high" decoding="async" />
                            @else
                                <div class="public-thumb-placeholder h-full">
                                    <i class="ki-filled ki-picture text-5xl"></i>
                                </div>
                            @endif
                        </div>

                        <div class="public-featured-overlay">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="public-featured-label">
                                    <i class="ki-filled ki-star text-xs"></i>
                                    Headline
                                </span>
                                @if ($article->category)
                                    <span class="public-featured-chip">{{ $article->category->name }}</span>
                                @endif
                            </div>

                            <h3 class="mt-3 text-xl sm:text-2xl lg:text-3xl font-bold leading-tight text-white line-clamp-3">
                                {{ $article->title }}
                            </h3>

                            <p class="hidden sm:block mt-2 text-sm lg:text-base text-white/80 line-clamp-2 max-w-3xl">
                                {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 180) }}
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-white/75">
                                <span class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-profile-circle"></i>
                                    {{ $article->user->name ?? 'Redaksi' }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-calendar"></i>
                                    <time datetime="{{ $article->created_at->toDateString() }}">
                                        {{ $article->created_at->translatedFormat('d M Y') }}
                                    </time>
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
            @else
                @include('partials.landing.article-card', ['article' => $article])
            @endif
        @endforeach
    </div>
</section>
