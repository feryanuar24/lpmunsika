@extends('layouts.auth.base')

@section('content')
    <div class="kt-card">
        <div class="kt-card-heading">
            <div class="kt-card-header">
                <h2 class="kt-card-title">Halaman Registrasi</h2>
            </div>
        </div>

        <div class="kt-card-content">
            <form id="register-form" action="{{ route('register') }}" class="grid grid-cols-2 gap-5" method="POST">
                @csrf

                <!-- Input Name -->
                <div>
                    <label for="name" class="kt-label">Nama</label>
                    <input type="text" name="name" id="name" class="kt-input w-full"
                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Email -->
                <div>
                    <label class="kt-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="kt-input w-full"
                        value="{{ old('email') }}" placeholder="Masukkan alamat email" required>
                    @error('email')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="col-span-2">
                    <label class="kt-label" for="password">Kata Sandi</label>
                    <div class="relative" data-kt-toggle-password="true">
                        <input type="password" name="password" class="kt-input w-full pe-10"
                            placeholder="Masukkan kata sandi" required/><button
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

                <!-- Input Password Confirmation -->
                <div class="col-span-2">
                    <label class="kt-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="relative" data-kt-toggle-password="true">
                        <input type="password" name="password_confirmation" class="kt-input w-full pe-10"
                            placeholder="Masukkan konfirmasi kata sandi" required/><button
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

                <!-- ReCaptcha -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <button type="submit" class="kt-btn kt-btn-primary col-span-2">Daftar</button>
            </form>
        </div>

        <div class="kt-card-footer">
            <a href="{{ route('login') }}" class="kt-link-underlined kt-link col-span-2">Sudah punya akun? Masuk
                sekarang</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script
        src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key', env('RECAPTCHA_SITE_KEY')) }}">
    </script>

    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('services.recaptcha.site_key', env('RECAPTCHA_SITE_KEY')) }}', {
                action: 'register'
            }).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });

        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah data yang Anda masukkan sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#3b82f6', // Blue-500
                    cancelButtonColor: '#6b7280', // Gray-500
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu sementara kami memproses data Anda.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
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
