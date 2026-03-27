@extends('layouts.error.base')

@section('content')
    <div class="flex flex-col items-center justify-center text-center space-y-5 min-h-[600px]">
        <img src="{{ asset('assets/media/illustrations/8.svg') }}" alt="Ilustrasi server error (500)" class="w-80">
        <h2 class="text-2xl font-semibold">Terjadi Kesalahan Server</h2>
        <p class="text-mono w-[90%]">Maaf, terjadi kesalahan pada server kami. Silakan coba beberapa saat lagi
            atau hubungi administrator jika masalah terus berlanjut.</p>
        <button class="kt-btn kt-btn-primary">
            <a href="/">Kembali ke Beranda</a>
        </button>
    </div>
@endsection
