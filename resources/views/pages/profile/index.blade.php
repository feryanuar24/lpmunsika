@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Halaman Edit Profil
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <form id="delete-account-form" action="{{ route('profile') }}" method="POST">
                    @method('DELETE')

                    @csrf

                    <button type="submit" class="kt-btn kt-btn-destructive">
                        <i class="ki-filled ki-trash"></i>
                    </button>
                </form>
                <a class="kt-btn kt-btn-primary" href="{{ route('profile.edit') }}">
                    <i class="ki-filled ki-pencil"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm font-medium text-foreground">Nama</div>
                    <div class="text-sm text-muted-foreground">{{ $data['user']->name }}</div>
                </div>

                <div>
                    <div class="text-sm  font-medium text-foreground">Email</div>
                    <div class="text-sm  text-muted-foreground">{{ $data['user']->email }}</div>
                </div>

                <div>
                    <div class="text-sm font-medium text-foreground">Role</div>
                    <div class="mt-1 flex flex-wrap gap-2">
                        @foreach ($data['user']->roles as $role)
                            <span class="kt-badge kt-badge-sm kt-badge-inline kt-badge-primary">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('delete-account-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus akun saya',
                cancelButtonText: 'Tidak, batalkan',
                confirmButtonColor: '#ef4444', // Red-500
                cancelButtonColor: '#6b7280', // Gray-500
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Akun Anda sedang dihapus.',
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
            })
        });
    </script>
@endpush
