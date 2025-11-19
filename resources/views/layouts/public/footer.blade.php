<footer class="bg-gray-100 dark:bg-background/70">
    <div class="kt-container-fixed py-10">
        <div class="grid grid-cols-2 gap-8">
            <!-- About Section -->
            <div class="col-span-2 lg:col-span-1">
                <h3 class="text-xl font-semibold mb-4">{{ config('app.name') }}</h3>
                <p class="mb-4">
                    Lembaga Pers Mahasiswa Unsika merupakan unit kegiatan mahasiswa
                    yang berperan sebagai wadah untuk
                    menyalurkan bakat dan hobi dalam bidang
                    jurnalistik.
                </p>
                <div class="flex flex-nowrap overflow-x-auto -mx-2">
                    @foreach ($platforms as $platform)
                    <a href="{{ $platform->url }}" class="kt-btn kt-btn-outline px-2">
                        <i class="ki-filled {{ $platform->icon }} text-lg"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-5 lg:gap-y-0">
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-1">
                        @foreach ($footers as $footer)
                            <li>
                                <a href="{{ $footer->url }}" class="kt-link kt-link-mono">{{ $footer->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="w-56">
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="ki-filled ki-geolocation text-lg mr-1"></i>
                            <a href="https://maps.app.goo.gl/knLR6F9KTrQLqgNH7" class="kt-link kt-link-mono">Jl. HS.
                                Ronggowaluyo, Karawang</a>
                        </div>
                        <div class="flex items-center">
                            <i class="ki-filled ki-sms text-lg mr-1"></i>
                            <a href="mailto:lpmunsika@gmail.com" class="kt-link kt-link-mono">
                                lpmunsika@gmail.com
                            </a>
                        </div>
                        <div class="flex items-center">
                            <i class="ki-filled ki-phone text-lg mr-1"></i>
                            <a href="tel:+6282135315586" class="kt-link kt-link-mono">
                                (0821) 3531-5586
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-300 my-7.5"></div>

        <!-- Bottom Footer -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-5 lg:gap-y-0">
            <div class="text-sm">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak cipta dilindungi undang-undang.
            </div>
        </div>
    </div>
</footer>
