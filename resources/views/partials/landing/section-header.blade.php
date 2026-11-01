{{-- Judul section landing dengan tautan "Lihat semua" opsional --}}
<div class="flex items-end justify-between gap-4 mb-5">
    <div class="min-w-0">
        <h2 id="{{ $id ?? '' }}" class="text-2xl lg:text-3xl font-semibold text-foreground mb-0">
            {{ $title }}
        </h2>
        @if (!empty($subtitle))
            <p class="mt-2 text-sm text-muted-foreground">{{ $subtitle }}</p>
        @endif
    </div>
    @if (!empty($url))
        <a href="{{ $url }}" class="public-see-all shrink-0">
            Lihat semua
            <i class="ki-filled ki-arrow-right text-xs"></i>
        </a>
    @endif
</div>

