<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    @include('layouts.partials.head')
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
        <!-- End of Wrapper -->

        <!-- Modals -->
        @include('partials.modals.search')
        @include('partials.modals.notification')
        <!-- End of Modals -->
    </div>
    <!-- End of Main -->
    <!-- End of Page -->

    @include('layouts.partials.scripts')
</body>

</html>
