@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Detail Platform
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('platforms.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Nama: </span>
                <span class="text-muted-foreground">{{ $data['platform']->name }}</span>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">URL: </span>
                <a class="kt-link kt-link-primary" target="_blank"  href="{{ $data['platform']->url }}">{{ $data['platform']->url }}</a>
            </div>
            <div class="border-b border-border border-dashed py-2 flex items-center gap-2">
                <span class="text-foreground font-medium">Ikon: </span>
                <span class="kt-badge kt-badge-outline">
                    <i class="{{ $data['platform']->icon }} ki-filled"></i>
                </span>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Deskripsi: </span>
                <span class="text-muted-foreground">{{ $data['platform']->description }}</span>
            </div>
        </div>
    </div>
@endsection
