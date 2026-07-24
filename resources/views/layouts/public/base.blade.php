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
            @include('layouts.public.header')

            <!-- Content -->
            <main class="kt-container-fixed py-5 grid grid-cols-1 lg:grid-cols-3" id="content" role="content">
                <div class="col-span-1 lg:col-span-2">
                    @yield('content')
                </div>
                <div class="mt-7 lg:mt-0 col-span-1">
                    @include('layouts.public.sidebar')
                </div>
            </main>
            <!-- End of Content -->

            @include('layouts.public.footer')
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    @include('layouts.partials.scripts')
</body>

</html>
