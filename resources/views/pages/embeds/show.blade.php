@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Detail Penyematan
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('embeds.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Judul: </span>
                <span class="text-muted-foreground">{{ $data['embed']->title }}</span>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Platform: </span>
                <span class="text-muted-foreground">{{ $data['embed']->platform->name }}</span>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Deskripsi: </span>
                <span class="text-muted-foreground">{{ $data['embed']->description }}</span>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <div class="embed-preview text-muted-foreground">{!! $data['embed']->embed_code !!}</div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .embed-preview {
            max-width: 100%;
            overflow-x: auto;
        }

        .embed-preview iframe,
        .embed-preview video,
        .embed-preview embed,
        .embed-preview object {
            max-width: 100%;
            width: 100%;
        }
    </style>
@endpush
