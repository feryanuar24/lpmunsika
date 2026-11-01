<section id="banner-slider" class="splide public-slider" aria-label="Banner Slider">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($data['sliders'] as $slider)
                <li class="splide__slide public-slider-slide">
                    <img src="{{ route('files', $slider->banner) }}" alt="Banner slider {{ $slider->name }}"
                        class="w-full h-full object-cover" @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                        decoding="async" />
                </li>
            @endforeach
        </ul>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const total = {{ $data['sliders']->count() }};
            new Splide('#banner-slider', {
                type: total > 1 ? 'loop' : 'slide',
                autoplay: total > 1,
                interval: 5000,
                perPage: 1,
                gap: '1rem',
                pauseOnHover: true,
                arrows: total > 1,
                pagination: total > 1,
                drag: total > 1,
                i18n: {
                    prev: 'Slide sebelumnya',
                    next: 'Slide berikutnya',
                    first: 'Ke slide pertama',
                    last: 'Ke slide terakhir',
                    slideX: 'Ke slide %s',
                    pageX: 'Ke halaman %s',
                    play: 'Putar otomatis',
                    pause: 'Jeda otomatis',
                },
            }).mount();
        });
    </script>
@endpush
