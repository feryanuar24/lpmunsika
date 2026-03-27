@extends('layouts.auth.base')

@section('content')
    <div class="kt-card">
        <div class="kt-card-heading">
            <div class="kt-card-header">
                <h2 class="kt-card-title">
                    Halaman Verifikasi Alamat Email
                </h2>
            </div>
        </div>

        <div class="kt-card-content">
            <form id="verify-email-form" action="{{ route('verification.send') }}" method="POST" class="space-y-5">
                @csrf

                <p class="font-normal text-foreground text-sm text-justify">Terima kasih telah mendaftar! Sebelum memulai, dapatkah Anda memverifikasi alamat email Anda dengan
                    mengklik tautan yang baru saja kami kirimkan ke email Anda? Jika Anda tidak menerima email tersebut,
                    kami dengan senang hati akan mengirimkan email lain untuk Anda.</p>

                <!-- ReCAPTCHA v3 -->
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <!-- Submit Button -->
                <button type="submit" class="kt-btn kt-btn-primary">Kirim</button>
            </form>
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
                action: 'verify_email'
            }).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });

        document.getElementById('verify-email-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Lanjutkan mengirim ulang tautan verifikasi email?',
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
                            text: 'Sedang mengirim ulang tautan verifikasi email',
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
