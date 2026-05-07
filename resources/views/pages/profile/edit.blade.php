@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h1 class="kt-card-title">
                    Form Perbaharui Profil
                </h1>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('profile') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="edit-account-form" action="{{ route('profile') }}" method="POST" class="space-y-5">
                @method('PATCH')

                @csrf

                <div>
                    <label for="name" class="kt-label">Nama</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="name" class="kt-input w-full"
                        value="{{ old('name', $data['user']->name) }}" placeholder="Masukkan nama" required/>
                    @error('name')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="kt-label">Email</label>
                    <span class="text-destructive">*</span>
                    <input type="email" name="email" id="email" class="kt-input w-full"
                        value="{{ old('email', $data['user']->email) }}" placeholder="Masukkan alamat email" required/>
                    @error('email')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="kt-label" for="password">Kata Sandi Baru</label>
                    <span class="text-muted-foreground kt-label mb-2 lg:mb-0">(Biarkan kosong jika tidak ingin mengubah kata
                        sandi)</span>
                    <div class="relative" data-kt-toggle-password="true">
                        <input type="password" name="password" class="kt-input w-full pe-10"
                            placeholder="Masukkan kata sandi baru" /><button
                            class="kt-btn kt-btn-icon kt-btn-ghost size-6 absolute end-2 top-1/2 -translate-y-1/2"
                            data-kt-toggle-password-trigger="true" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-eye kt-toggle-password-active:hidden"
                                aria-hidden="true">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-eye-off hidden kt-toggle-password-active:block"
                                aria-hidden="true">
                                <path
                                    d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49">
                                </path>
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path>
                                <path
                                    d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143">
                                </path>
                                <path d="m2 2 20 20"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="kt-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative" data-kt-toggle-password="true">
                        <input type="password" name="password_confirmation" class="kt-input w-full pe-10"
                            placeholder="Masukkan konfirmasi kata sandi baru" /><button
                            class="kt-btn kt-btn-icon kt-btn-ghost size-6 absolute end-2 top-1/2 -translate-y-1/2"
                            data-kt-toggle-password-trigger="true" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-eye kt-toggle-password-active:hidden"
                                aria-hidden="true">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-eye-off hidden kt-toggle-password-active:block"
                                aria-hidden="true">
                                <path
                                    d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49">
                                </path>
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path>
                                <path
                                    d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143">
                                </path>
                                <path d="m2 2 20 20"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary mt-5">Edit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('edit-account-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin memperbarui profil Anda?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#3b82f6', // Blue-500
                cancelButtonColor: '#6b7280', // Gray-500
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Profil Anda sedang diperbarui.',
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
