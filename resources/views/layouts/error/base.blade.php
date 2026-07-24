<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    @include('layouts.partials.head')
</head>

<body class="kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    @include('partials.theme-toggle')

    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col">
            <!-- Content -->
            <main class="w-full max-w-2xl mx-auto flex-1 flex flex-col justify-center px-4 py-8" id="content"
                role="content">
                @yield('content')
            </main>
            <!-- End of Content -->
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    @include('layouts.partials.scripts')
</body>

</html>
