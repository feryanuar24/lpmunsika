@extends('layouts.auth.base')

@section('content')
    <div class="kt-card">
        <div class="kt-card-heading">
            <div class="kt-card-header">
                <h2 class="kt-card-title">Halaman Registrasi</h2>
            </div>
        </div>
        <div class="kt-card-content">
            <form action="{{ route('register') }}" class="grid grid-cols-2 gap-5" method="POST">
                @csrf

                <div>
                    <label for="name" class="kt-label">Nama</label>
                    <input type="text" name="name" id="name" required class="kt-input w-full"
                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label class="kt-label" for="email">Email</label>
                    <input type="email" name="email" id="email" required class="kt-input w-full"
                        value="{{ old('email') }}" placeholder="Masukkan alamat email">
                </div>

                <div>
                    <label class="kt-label" for="password">Kata Sandi</label>
                    <div class="relative max-w-72" data-kt-toggle-password="true">
                        <input type="text" name="password" class="kt-input w-full pe-10"
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

                <div>
                    <label class="kt-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="relative max-w-72" data-kt-toggle-password="true">
                        <input type="text" name="password_confirmation" class="kt-input w-full pe-10"
                            placeholder="Masukkan konfirmasi kata sandi" /><button
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

                <div class="col-span-2">
                    <label class="kt-label">Pilih Avatar</label>
                    <div class="kt-scrollable overflow-y-auto h-40 rounded-lg border border-border grid grid-cols-4 gap-4">
                        @for ($i = 1; $i <= 34; $i++)
                            <div class="flex items-center justify-center">
                                <input class="kt-checkbox me-3" type="radio" name="avatar"
                                    value="assets/media/avatars/300-{{ $i }}.png"
                                    {{ $i == 1 ? 'checked' : '' }}>
                                <img src="{{ asset('assets/media/avatars/300-' . $i . '.png') }}"
                                    alt="Avatar {{ $i }}"
                                    class="w-16 h-16 rounded-full border-2 border-gray-200">
                            </div>
                        @endfor
                    </div>
                </div>

                <input type="hidden" name="g-recaptcha-response" id="recaptcha">

                <button type="submit" class="kt-btn kt-btn-primary col-span-2"
                    data-kt-modal-toggle="#modal-register">Daftar</button>

                <div class="kt-modal z-40" data-kt-modal="true" id="modal-register">
                    <div
                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                        <div class="kt-modal-header">
                            <h3 class="kt-modal-title">Konfirmasi Daftar</h3>
                            <button type="button" class="kt-modal-close" aria-label="Close modal"
                                data-kt-modal-dismiss="#modal-register">
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
                                    <p class="font-medium">Anda mendaftar menggunakan data ini.</p>
                                    <p class="text-sm text-muted">Pastikan nama, email, dan kata sandi sudah benar sebelum
                                        melanjutkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="kt-modal-footer">
                            <div></div>
                            <div class="flex gap-4">
                                <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-register"
                                    type="button">Tidak, Kembali</button>
                                <button class="kt-btn kt-btn-primary" type="submit">Ya, Daftar</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                document.getElementById('recaptcha').value = token;
            });
        });
    </script>
@endpush
