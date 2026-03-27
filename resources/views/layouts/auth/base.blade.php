<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    @include('layouts.partials.head')
</head>

<body class="kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
    @include('partials.theme-toggle')

    <!-- Page -->
    <!-- Main -->
    <div class="grid lg:grid-cols-5 grid-cols-1 min-h-screen">
        <div class="lg:col-span-2">
            @include('layouts.auth.sidebar')
        </div>

        <!-- Wrapper -->
        <div class="lg:col-span-3 flex items-center justify-center p-7 lg:p-10">
            <!-- Content -->
            <main id="content" role="content" class="w-full max-w-md">
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
