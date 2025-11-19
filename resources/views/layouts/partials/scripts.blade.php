<!-- Scripts -->
<script src="{{ asset('assets/js/core.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/vendors/ktui/ktui.min.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/js/layouts/demo1.js') }}" data-navigate-once></script>

<!-- Compiled App Scripts -->
@vite(['resources/js/app.js'])

<!-- Toast Notifications -->
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            KTToast.show({
                variant: 'success',
                message: '{{ session('success') }}',
                beep: true,
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            KTToast.show({
                variant: 'destructive',
                message: '{{ session('error') }}',
                beep: true,
            });
        });
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                KTToast.show({
                    variant: 'destructive',
                    message: '{{ $error }}',
                    beep: true,
                });
            });
        </script>
    @endforeach
@endif

@stack('scripts')

<!-- End of Scripts -->
