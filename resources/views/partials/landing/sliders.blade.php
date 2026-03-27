<section id="banner-slider" class="splide" aria-label="Banner Slider">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($data['sliders'] as $slider)
                <li class="splide__slide">
                    <img src="{{ route('files', $slider->banner) }}" alt="Banner slider {{ $slider->name }}" class="w-full h-auto object-cover rounded-lg" />
                </li>
            @endforeach
        </ul>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Splide('#banner-slider', {
                type: 'loop',
                autoplay: true,
                perPage: 1,
                pauseOnHover: true,
                breakpoints: {
                    768: {
                        perPage: 1,
                    },
                    1024: {
                        perPage: 1,
                    },
                },
            }).mount();
        });
    </script>
@endpush
