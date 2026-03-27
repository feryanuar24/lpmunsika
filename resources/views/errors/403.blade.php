@extends('layouts.error.base')

@section('content')
    <div class="flex flex-col items-center justify-center text-center space-y-5 min-h-[600px]">
        <img src="{{ asset('assets/media/illustrations/5.svg') }}" alt="Ilustrasi akses ditolak (403)" class="w-80">
        <h2 class="text-2xl font-semibold">Akses Ditolak</h2>
        <p class="text-mono w-[90%]">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan
            kembali ke halaman utama atau hubungi administrator jika Anda membutuhkan akses.</p>
        <button class="kt-btn kt-btn-primary">
            <a href="/">Kembali ke Beranda</a>
        </button>
    </div>
@endsection
