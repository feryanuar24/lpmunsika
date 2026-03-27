@extends('layouts.error.base')

@section('content')
    <div class="flex flex-col items-center justify-center text-center space-y-5 min-h-[600px]">
        <img src="{{ asset('assets/media/illustrations/7.svg') }}" alt="Ilustrasi halaman tidak ditemukan (404)" class="w-80">
        <h2 class="text-2xl font-semibold">Halaman Tidak Ditemukan</h2>
        <p class="text-mono w-[90%]">Maaf, halaman yang Anda cari tidak ditemukan atau
            sudah dipindahkan. Silakan kembali ke halaman utama atau hubungi administrator jika masalah berlanjut.</p>
        <button class="kt-btn kt-btn-primary">
            <a href="/">Kembali ke Beranda</a>
        </button>
    </div>
@endsection
