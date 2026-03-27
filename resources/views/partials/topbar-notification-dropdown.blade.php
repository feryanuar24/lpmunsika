<div class="flex items-center gap-1.5">
    <!-- Notifications -->
    <button class="kt-btn kt-btn-ghost kt-btn-icon size-8 hover:bg-background hover:[&amp;_i]:text-primary"
        data-kt-modal-toggle="#modal-notification">
        <i class="ki-filled ki-notification-status text-lg">
        </i>
    </button>

    <!--Notifications Drawer-->

    <!--End of Notifications Drawer-->
    <!-- End of Notifications -->
    <form id="logout-icon-form" action="{{ route('logout') }}" method="POST">
        @method('DELETE')

        @csrf

        <button type="submit"
            class="kt-btn kt-btn-ghost kt-btn-icon size-8 hover:bg-background hover:[&amp;_i]:text-primary">
            <i class="ki-filled ki-exit-right">
            </i>
        </button>
    </form>
</div>

@push('scripts')
    <script>
        document.getElementById('logout-icon-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#ef4444', // Red-500
                cancelButtonColor: '#6b7280', // Gray-500
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Anda sedang keluar.',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        this.submit();
                    }, 300);
                }
            });
        });
    </script>
@endpush
