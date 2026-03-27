@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Detail Pengguna
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('users.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-foreground font-medium">Nama</div>
                    <div class="text-muted-foreground text-sm">{{ $data['user']->name }}</div>
                </div>

                <div>
                    <div class="text-sm text-foreground font-medium">Email</div>
                    <div class="text-muted-foreground text-sm">{{ $data['user']->email }}</div>
                </div>

                <div>
                    <div class="text-sm text-foreground font-medium">Role</div>
                    <div class="mt-1 flex flex-wrap gap-2">
                        @foreach ($data['user']->roles as $role)
                            <span class="kt-badge kt-badge-sm kt-badge-inline kt-badge-primary">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
