@extends('layouts.auth.base')

@section('content')
    <div class="kt-card">
        <div class="kt-card-heading">
            <div class="kt-card-header">
                <h2 class="kt-card-title">
                    Halaman Lupa Kata Sandi
                </h2>
            </div>
        </div>
        <div class="kt-card-content">
            <form action="{{ route('password.email') }}" class="space-y-5" method="POST">
                @csrf

                <div>
                    <label class="kt-label" for="email">Email</label>
                    <input type="email" name="email" id="email" required class="kt-input w-full"
                        value="{{ old('email') }}" placeholder="Masukkan alamat email">
                </div>

                <input type="hidden" name="g-recaptcha-response" id="recaptcha">

                <button type="button" data-kt-modal-toggle="#modal-forgot-password" class="kt-btn kt-btn-primary">Kirim</button>

                <div class="kt-modal z-40" data-kt-modal="true" id="modal-forgot-password">
                    <div
                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                        <div class="kt-modal-header">
                            <h3 class="kt-modal-title">Konfirmasi Permintaan Reset Kata Sandi</h3>
                            <button type="button" class="kt-modal-close" aria-label="Close modal"
                                data-kt-modal-dismiss="#modal-forgot-password">
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
                                    <p class="font-medium">Kami akan mengirimkan tautan untuk mereset kata sandi ke alamat
                                        email
                                        ini.</p>
                                    <p class="text-sm text-muted">Periksa kotak masuk dan folder spam. Ikuti instruksi pada
                                        email
                                        untuk mereset kata sandi Anda.</p>
                                </div>
                            </div>
                        </div>
                        <div class="kt-modal-footer">
                            <div></div>
                            <div class="flex gap-4">
                                <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-forgot-password"
                                    type="button">Tidak, Kembali</button>
                                <button class="kt-btn kt-btn-primary" type="submit">Ya, Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="kt-card-footer">
            <a href="{{ route('login') }}" class="kt-link-underlined kt-link">Sudah ingat kata sandi? Masuk
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
                action: 'forgot_password'
            }).then(function(token) {
                document.getElementById('recaptcha').value = token;
            });
        });
    </script>
@endpush
