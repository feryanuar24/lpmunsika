<!-- User -->
<div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px" data-kt-dropdown-offset-rtl="-20px, 10px"
    data-kt-dropdown-placement="bottom-end" data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
    <div class="shrink-0 cursor-pointer" data-kt-dropdown-toggle="true">
        <img alt="Ilustrasi avatar blank" class="size-9 shrink-0 rounded-full border-2 border-green-500"
            src="{{ asset('assets/media/avatars/blank.png') }}" />
    </div>
    <div class="kt-dropdown-menu w-[250px]" data-kt-dropdown-menu="true">
        <div class="flex flex-col gap-1.5 px-2.5 py-1.5">
            <div class="flex items-center gap-2">
                <img alt="Ilustrasi avatar blank" class="size-9 shrink-0 rounded-full border-2 border-green-500"
                    src="{{ asset('assets/media/avatars/blank.png') }}" />
                <div class="flex flex-col gap-1.5">
                    <span class="text-sm font-semibold leading-none text-foreground">
                        {{ Auth::user()->name }}
                    </span>
                    <a class="hover:text-primary text-xs font-medium leading-none text-secondary-foreground"
                        href="mailto:{{ Auth::user()->email }}">
                        {{ Auth::user()->email }}
                    </a>
                </div>
            </div>
            <span class="kt-badge kt-badge-sm kt-badge-primary kt-badge-outline">
                {{ Auth::user()->roles[0]->name }}
            </span>
        </div>
        <ul class="kt-dropdown-menu-sub">
            <li>
                <div class="kt-dropdown-menu-separator">
                </div>
            </li>
            <li>
                <a class="kt-dropdown-menu-link" href="{{ route('profile') }}">
                    <i class="ki-filled ki-profile-circle">
                    </i>
                    Profil Saya
                </a>
            </li>
            <li>
                <div class="kt-dropdown-menu-separator">
                </div>
            </li>
        </ul>
        <div class="mb-2.5 flex flex-col gap-3.5 px-2.5 pt-1.5">
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
            <form id="logout-user-form" action="{{ route('logout') }}" method="POST">
                @method('DELETE')

                @csrf

                <button type="submit" class="kt-btn kt-btn-outline w-full justify-center">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
<!-- End of User -->

@push('scripts')
    <script>
        document.getElementById('logout-user-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Tidak, tetap di sini',
                confirmButtonColor: '#ef4444', // Red-500
                cancelButtonColor: '#6b7280', // Gray-500
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Anda sedang keluar.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                            this.submit();
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
