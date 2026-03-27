<header class="bg-gray-100 dark:bg-background/70 py-5">
    <div class="kt-container-fixed flex items-center justify-between">
        <!-- Logo -->
        <div>
            <a href="{{ route('landing') }}">
                <img src="{{ asset('assets/media/app/default-logo.png') }}" alt="Logo aplikasi" class="h-8 lg:h-10 dark:hidden">
                <img src="{{ asset('assets/media/app/default-logo-dark.png') }}" alt="Logo aplikasi"
                    class="h-8 lg:h-10 hidden dark:block">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:block">
            <ul class="kt-menu gap-5">
                <li><a href="{{ route('category', 'berita') }}" class="kt-link kt-link-mono text-sm">Berita</a></li>
                <li class="inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-sm" data-kt-dropdown-toggle="true">Produk</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('category', 'buletin') }}"
                                class="kt-link kt-link-mono text-sm">Buletin</a>
                            <a href="{{ route('category', 'majalah') }}"
                                class="kt-link kt-link-mono text-sm">Majalah</a>
                        </div>
                    </div>
                </li>
                <li class="inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-sm" data-kt-dropdown-toggle="true">Karya
                        Mahasiswa</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('category', 'resensi-buku') }}"
                                class="kt-link kt-link-mono text-sm">Resensi Buku</a>
                            <a href="{{ route('category', 'review-film') }}" class="kt-link kt-link-mono text-sm">Review
                                Film</a>
                            <a href="{{ route('category', 'opini') }}" class="kt-link kt-link-mono text-sm">Opini</a>
                            <a href="{{ route('category', 'esai') }}" class="kt-link kt-link-mono text-sm">Esai</a>
                            <a href="{{ route('category', 'artikel') }}"
                                class="kt-link kt-link-mono text-sm">Artikel</a>
                            <a href="{{ route('category', 'puisi') }}" class="kt-link kt-link-mono text-sm">Puisi</a>
                            <a href="{{ route('category', 'cerpen') }}" class="kt-link kt-link-mono text-sm">Cerpen</a>
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('category', 'gaya-mahasiswa') }}" class="kt-link kt-link-mono text-sm">Gaya
                        Mahasiswa</a></li>
            </ul>
        </nav>

        <!-- Desktop Action -->
        <div class="flex gap-x-4">
            @guest
                <div class="space-x-2 hidden lg:block">
                    <a href="{{ route('login') }}" class="kt-btn kt-btn-mono">Masuk</a>
                    <a href="{{ route('register') }}" class="kt-btn kt-btn-outline">Daftar</a>
                </div>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="kt-btn kt-btn-mono hidden lg:flex items-center">Dashboard</a>
            @endauth

            <div class="items-center hidden lg:flex" data-kt-toggle="true" data-kt-toggle-state="active">
                <i class="ki-filled ki-moon text-base text-muted-foreground mr-1"></i>
                <input class="kt-switch" data-kt-theme-switch-state="dark" data-kt-theme-switch-toggle="true"
                    name="check" type="checkbox" value="1" />
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="inline-flex lg:hidden" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
            <button type="button" class="kt-btn kt-btn-icon kt-btn-outline" data-kt-dropdown-toggle="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-menu" aria-hidden="true">
                    <line x1="4" y1="8" x2="20" y2="8" />
                    <line x1="4" y1="16" x2="20" y2="16" />
                </svg>
            </button>

            <div class="kt-dropdown p-3 text-sm space-y-3" data-kt-dropdown-menu="true">
                <div class="kt-dropdown-item">
                    <a href="{{ route('category', 'berita') }}" class="kt-link kt-link-mono text-sm">Berita</a>
                </div>

                <div class="kt-dropdown-item" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-sm w-full text-left"
                        data-kt-dropdown-toggle="true">Produk</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('category', 'buletin') }}"
                                class="kt-link kt-link-mono text-sm">Buletin</a>
                            <a href="{{ route('category', 'majalah') }}"
                                class="kt-link kt-link-mono text-sm">Majalah</a>
                        </div>
                    </div>
                </div>

                <div class="kt-dropdown-item" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                    <button class="kt-link kt-link-mono text-sm w-full text-left" data-kt-dropdown-toggle="true">Karya
                        Mahasiswa</button>
                    <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('category', 'resensi-buku') }}"
                                class="kt-link kt-link-mono text-sm">Resensi Buku</a>
                            <a href="{{ route('category', 'review-film') }}"
                                class="kt-link kt-link-mono text-sm">Review Film</a>
                            <a href="{{ route('category', 'opini') }}" class="kt-link kt-link-mono text-sm">Opini</a>
                            <a href="{{ route('category', 'esai') }}" class="kt-link kt-link-mono text-sm">Esai</a>
                            <a href="{{ route('category', 'artikel') }}"
                                class="kt-link kt-link-mono text-sm">Artikel</a>
                            <a href="{{ route('category', 'puisi') }}" class="kt-link kt-link-mono text-sm">Puisi</a>
                            <a href="{{ route('category', 'cerpen') }}"
                                class="kt-link kt-link-mono text-sm">Cerpen</a>
                        </div>
                    </div>
                </div>
                <div class="kt-dropdown-item">
                    <a href="{{ route('category', 'gaya-mahasiswa') }}" class="kt-link kt-link-mono text-sm">Gaya
                        Mahasiswa</a>
                </div>
                @guest
                    <div class="kt-dropdown-item">
                        <a href="{{ route('login') }}" class="kt-btn kt-btn-mono w-full text-center">Masuk</a>
                    </div>
                    <div class="kt-dropdown-item">
                        <a href="{{ route('register') }}" class="kt-btn kt-btn-outline w-full text-center">Daftar</a>
                    </div>
                @endguest
                @auth
                    <div class="kt-dropdown-item">
                        <a href="{{ route('dashboard') }}" class="kt-btn kt-btn-mono w-full text-center">Dashboard</a>
                    </div>
                @endauth
                <div class="flex items-center justify-between gap-2">
                    <span class="flex items-center gap-2">
                        <i class="ki-filled ki-moon text-base text-muted-foreground">
                        </i>
                        <span class="text-2sm font-medium">
                            Mode Gelap
                        </span>
                    </span>
                    <input class="kt-switch" data-kt-theme-switch-state="dark" data-kt-theme-switch-toggle="true"
                        name="check" type="checkbox" value="1" />
                </div>
            </div>
        </div>
    </div>
</header>
