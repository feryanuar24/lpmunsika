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
            <form id="forgot-password-form" action="{{ route('password.email') }}" class="space-y-5" method="POST">
                @csrf

                <p class="font-normal text-foreground text-sm text-justify">
                    Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda.
                </p>

                <!-- Input Email -->
                <div>
                    <label class="kt-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="kt-input w-full"
                        value="{{ old('email') }}" placeholder="Masukkan alamat email" required>
                    @error('email')
                        <span class="text-destructive mt-1 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ReCAPTCHA v3 -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <button type="submit" class="kt-btn kt-btn-primary">Kirim</button>
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
                document.getElementById('g-recaptcha-response').value = token;
            });
        });

        document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Lanjutkan mengirim tautan pengaturan ulang kata sandi?',
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
                            text: 'Sedang mengirim tautan pengaturan ulang kata sandi',
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
