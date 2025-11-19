@extends('layouts.auth.base')

@section('content')
    <div class="kt-card">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">Halaman Login</h2>
            </div>
        </div>
        <div class="kt-card-content">
            <form action="{{ route('login') }}" class="space-y-5" method="POST">
                @csrf

                <div>
                    <label class="kt-label" for="email">Email</label>
                    <input type="email" name="email" id="email" required class="kt-input w-full"
                        value="{{ old('email') }}" placeholder="Masukkan alamat email">
                </div>

                <div>
                    <label class="kt-label" for="password">Password</label>
                    <div class="relative max-w-72" data-kt-toggle-password="true">
                        <input type="text" name="password" id="password" class="kt-input w-full pe-10"
                            placeholder="Masukkan kata sandi" /><button
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

                <div class="flex items-center gap-2">
                    <input type="checkbox" class="kt-checkbox" id="remember_me" name="remember_me" value="1" />
                    <label class="kt-label" for="remember_me">Ingat Saya</label>
                </div>

                <input type="hidden" name="g-recaptcha-response" id="recaptcha">

                <button type="button" data-kt-modal-toggle="#modal-login" class="kt-btn kt-btn-primary">Masuk</button>

                <div class="kt-modal z-40" data-kt-modal="true" id="modal-login">
                    <div
                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                        <div class="kt-modal-header">
                            <h3 class="kt-modal-title">Konfirmasi Masuk</h3>
                            <button type="button" class="kt-modal-close" aria-label="Close modal"
                                data-kt-modal-dismiss="#modal-login">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="kt-modal-body">
                            <div class="flex items-center gap-4">
                                <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                <div>
                                    <p class="font-medium">Anda akan masuk menggunakan akun ini.</p>
                                    <p class="text-sm text-muted">Pastikan email dan kata sandi sudah benar sebelum
                                        melanjutkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="kt-modal-footer">
                            <div></div>
                            <div class="flex gap-4">
                                <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-login"
                                    type="button">Tidak, Kembali</button>
                                <button class="kt-btn kt-btn-primary" type="submit">Ya, Masuk</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="kt-card-footer">
            <div class="space-y-5 flex flex-col">
                <a href="{{ route('register') }}" class="kt-link-underlined kt-link">Belum punya akun? Daftar
                    sekarang</a>
                <a href="{{ route('password.request') }}" class="kt-link-underlined kt-link">Lupa kata sandi? Ubah kata sandi</a>
            </div>
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
                action: 'login'
            }).then(function(token) {
                document.getElementById('recaptcha').value = token;
            });
        });
    </script>
@endpush
