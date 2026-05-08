<!-- External Scripts -->
<script src="{{ asset('assets/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/js/layouts/demo1.js') }}" data-navigate-once></script>

<!-- Compiled Scripts -->
@vite(['resources/js/app.js'])

<!-- Toast Sessions -->
@if (session('success'))
    <script>
        KTToast.show({
            variant: 'success',
            message: '{{ session('success') }}',
            beep: true,
            icon: '<i class="ki-filled ki-information-1"></i>',
            progress: true,
            pauseOnHover: true,
        });
    </script>
@endif
@if (session('error'))
    <script>
        KTToast.show({
            variant: 'destructive',
            message: '{{ session('error') }}',
            beep: true,
            icon: '<i class="ki-filled ki-information-1"></i>',
            progress: true,
            pauseOnHover: true,
        });
    </script>
@endif
@if (isset($errors) && $errors->any())
    @foreach ($errors->all() as $error)
        <script>
            KTToast.show({
                variant: 'destructive',
                message: '{{ $error }}',
                beep: true,
                icon: '<i class="ki-filled ki-information-1"></i>',
                progress: true,
                pauseOnHover: true,
            });
        </script>
    @endforeach
@endif

<!-- Stacked Scripts -->
@stack('scripts')
