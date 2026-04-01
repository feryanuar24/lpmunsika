<div>
    <h2 class="text-3xl font-semibold mb-8 text-foreground border-b-2 border-border border-dashed pb-2 w-full">Sorotan
    </h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($data['pinned'] as $index => $article)
            <a href="{{ route('detail', $article->slug) }}"
                class="kt-card overflow-hidden {{ $index === 0 ? 'col-span-1 lg:col-span-2' : '' }}">

                <div>
                    @if ($article->thumbnail)
                        <img src="{{ route('files', $article->thumbnail) }}" alt="Thumbnail artikel {{ $article->title }}"
                            class="w-full {{ $index === 0 ? 'h-full' : 'h-48' }} object-cover" loading="lazy"
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
                    <p class="text-sm text-muted-foreground text-justify mt-3 line-clamp-2">
                        {{ Str::limit(str_replace(['&nbsp;', '&#160;'], ' ', strip_tags($article->content)), 120, '...') }}
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
        @endforeach
    </div>
</div>
