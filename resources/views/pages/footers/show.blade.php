@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header ">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Detail Footer
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('footers.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Nama: </span>
                <span class="text-muted-foreground">{{ $data['footer']->name }}</span>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">URL: </span>
                <a href="{{ $data['footer']->url }}" target="_blank" class="kt-link kt-link-primary">{{ $data['footer']->url }}</a>
            </div>
            <div class="border-b border-border border-dashed py-2">
                <span class="text-foreground font-medium">Deskripsi: </span>
                <span class="text-muted-foreground">{{ $data['footer']->description }}</span>
            </div>
        </div>
    </div>
@endsection
