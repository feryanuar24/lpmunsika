@extends('layouts.error.base')

@section('content')
    <div class="flex flex-col items-center justify-center text-center space-y-5 min-h-[600px]">
        <img src="{{ asset('assets/media/illustrations/9.svg') }}" alt="Ilustrasi maintenance (503)" class="w-80">
        <h2 class="text-2xl font-semibold">Sedang Dalam Pemeliharaan</h2>
        <p class="text-mono w-[90%]">Maaf, saat ini situs sedang dalam proses pemeliharaan. Silakan kembali beberapa saat lagi. Terima kasih atas pengertiannya.</p>
    </div>
@endsection
