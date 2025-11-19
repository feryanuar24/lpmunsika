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
                <form action="{{ route('profile') }}" method="POST">
                    @method('DELETE')

                    @csrf

                    <button type="button" class="kt-btn kt-btn-destructive" data-kt-modal-toggle="#modal-delete-profile">
                        <i class="ki-filled ki-trash"></i>
                    </button>

                    <div class="kt-modal z-40" data-kt-modal="true" id="modal-delete-profile">
                        <div
                            class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                            <div class="kt-modal-header">
                                <h3 class="kt-modal-title">Konfirmasi Hapus</h3>
                                <button type="button" class="kt-modal-close" aria-label="Close modal"
                                    data-kt-modal-dismiss="#modal-delete-profile">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"
                                        aria-hidden="true">
                                        <path d="M18 6 6 18"></path>
                                        <path d="m6 6 12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="kt-modal-body">
                                <div class="flex items-center gap-4">
                                    <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                    <div>
                                        <p class="font-medium">Anda menghapus akun ini.</p>
                                        <p class="text-sm text-muted">Pastikan data sudah dicadangkan sebelum
                                            melanjutkan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-modal-footer">
                                <div></div>
                                <div class="flex gap-4">
                                    <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-delete-profile"
                                        type="button">Tidak,
                                        Kembali</button>
                                    <button class="kt-btn kt-btn-primary" type="submit">Ya, Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <a class="kt-btn kt-btn-primary" href="{{ route('profile.edit') }}">
                    <i class="ki-filled ki-pencil"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content p-5">
            <div class="flex items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{  $data['user']->avatar }}" alt="Avatar" class="w-20 h-20 rounded-full">
                    <div>
                        <h2 class="text-lg font-semibold text-foreground">{{ $data['user']->name }}</h2>
                        <p class="font-medium text-muted-foreground">{{ $data['user']->email }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
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
