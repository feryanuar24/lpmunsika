@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Tambah Permission Role
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('permission-role.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="create-permission-role-form" action="{{ route('permission-role.store') }}" method="POST"
                class="space-y-5">
                @csrf

                <div>
                    <label for="permission_id" class="kt-label">Permission</label>
                    <span class="text-destructive">*</span>
                    <select name="permission_id" class="kt-select" data-kt-select="true"
                        data-kt-select-placeholder="Pilih Permission"
                        data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                        @foreach ($data['permissions'] as $permission)
                            <option value="{{ $permission->id }}" @selected(old('permission_id') == $permission->id)>
                                {{ $permission->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('permission_id')
                        <div class="text-destructive mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="role_id" class="kt-label">Role</label>
                    <span class="text-destructive">*</span>
                    <select name="role_id" class="kt-select" data-kt-select="true" data-kt-select-placeholder="Pilih Role"
                        data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                        @foreach ($data['roles'] as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="text-destructive mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="kt-btn kt-btn-primary mt-5">Buat</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('create-permission-role-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membuat permission role baru?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, buat',
                cancelButtonText: 'Tidak, batalkan',
                confirmButtonColor: '#3b82f6', // Blue-500
                cancelButtonColor: '#6b7280', // Gray-500
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Permission role baru sedang dibuat.',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        this.submit();
                    }, 300);
                }
            });
        })
    </script>
@endpush
