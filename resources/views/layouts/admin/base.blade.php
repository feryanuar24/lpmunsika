<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    @include('layouts.partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    @include('partials.theme-toggle')

    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        @include('layouts.admin.sidebar')

        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            @include('layouts.admin.header')

            <!-- Content -->
            <main class="grow pt-5" id="content" role="content">
                @yield('content')
            </main>
            <!-- End of Content -->

            @include('layouts.admin.footer')
        </div>

        <div class="kt-modal" data-kt-modal="true" id="modal-logout">
            <div class="kt-modal-content max-w-md w-[90%] fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">Konfirmasi Keluar</h3>
                    <button type="button" class="kt-modal-close" aria-label="Close modal"
                        data-kt-modal-dismiss="#modal-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="kt-modal-body">
                    <div class="flex items-center gap-4">
                        <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                        <div>
                            <p class="font-medium">Anda akan keluar dari akun ini.</p>
                            <p class="text-sm text-muted">Pastikan semua pekerjaan Anda sudah tersimpan sebelum keluar.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="kt-modal-footer">
                    <div></div>
                    <div class="flex gap-4">
                        <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-logout" type="button">Tidak,
                            Kembali</button>
                        <button class="kt-btn kt-btn-primary" type="submit" id="submit-button">Ya, Keluar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-modal" data-kt-modal="true" id="modal-search">
            <div class="kt-modal-content max-w-md w-[90%] fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                <form action="{{ route('menus') }}" method="GET">
                    <div class="kt-modal-header">
                        <h3 class="kt-modal-title">Cari Menu</h3>
                        <button type="button" class="kt-modal-close" aria-label="Close modal"
                            data-kt-modal-dismiss="#modal-search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="kt-modal-body">
                        <input type="text" name="q" id="q" class="kt-input w-full"
                            placeholder="Masukkan nama atau deskripsi...">
                    </div>
                    <div class="kt-modal-footer">
                        <div></div>
                        <div class="flex gap-4">
                            <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-search"
                                type="button">Kembali</button>
                            <button class="kt-btn kt-btn-primary" type="submit" id="submit-button">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="kt-modal" data-kt-modal="true" id="modal-notification">
            <div class="kt-modal-content max-w-md w-[90%] h-[280px] fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">Notifikasi</h3>
                    <button type="button" class="kt-modal-close" aria-label="Close modal"
                        data-kt-modal-dismiss="#modal-notification">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="kt-modal-body kt-scrollable max-h-96 overflow-y-auto">
                    @foreach ($notifications as $notification)
                        <div class="p-4 mb-4 border border-border rounded-lg hover:bg-muted">
                            <p class="font-medium">{{ $notification->title }}</p>
                            <p class="text-sm text-muted">{{ $notification->message }}</p>
                            <p class="text-xs text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="kt-modal-footer">
                    <div></div>
                    <div class="flex gap-4">
                        <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-notification"
                            type="button">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('submit-button').addEventListener('click', function() {
                document.querySelector('form').submit();
            });
        </script>

        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    @include('layouts.partials.scripts')
</body>

</html>
