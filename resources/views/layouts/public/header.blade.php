<header class="bg-gray-100 dark:bg-background/70 py-5">
    <div class="kt-container-fixed flex items-center justify-between">
        <!-- Logo -->
        <div>
            <a href="{{ route('landing') }}">
                <img src="{{ asset('assets/media/app/default-logo.png') }}" alt="Logo aplikasi"
                    class="h-8 lg:h-10 dark:hidden">
                <img src="{{ asset('assets/media/app/default-logo-dark.png') }}" alt="Logo aplikasi"
                    class="h-8 lg:h-10 hidden dark:block">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:block">
            <ul class="kt-menu gap-5">
                @forelse($navCategories as $category)
                    @if($category->children->count() > 0)
                        <li class="inline-flex" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                            <button class="kt-link kt-link-mono text-sm" data-kt-dropdown-toggle="true">
                                {{ $category->name }}
                            </button>
                            <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('category', $child->slug) }}"
                                            class="kt-link kt-link-mono text-sm">{{ $child->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ route('category', $category->slug) }}"
                                class="kt-link kt-link-mono text-sm">{{ $category->name }}</a></li>
                    @endif
                @empty
                    <li><span class="text-sm text-muted-foreground">Tidak ada kategori</span></li>
                @endforelse
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
                @forelse($navCategories as $category)
                    @if($category->children->count() > 0)
                        <div class="kt-dropdown-item" data-kt-dropdown="true" data-kt-dropdown-trigger="click">
                            <button class="kt-link kt-link-mono text-sm w-full text-left"
                                data-kt-dropdown-toggle="true">{{ $category->name }}</button>
                            <div class="kt-dropdown w-full max-w-56 p-3 text-sm" data-kt-dropdown-menu="true">
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('category', $child->slug) }}"
                                            class="kt-link kt-link-mono text-sm">{{ $child->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="kt-dropdown-item">
                            <a href="{{ route('category', $category->slug) }}"
                                class="kt-link kt-link-mono text-sm">{{ $category->name }}</a>
                        </div>
                    @endif
                @empty
                    <div class="kt-dropdown-item">
                        <span class="text-sm text-muted-foreground">Tidak ada kategori</span>
                    </div>
                @endforelse
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
