@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Tambah Permission
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('permissions.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="create-permission-form" action="{{ route('permissions.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="kt-label">Nama</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="name" class="kt-input w-full" value="{{ old('name') }}"
                        placeholder="Masukkan nama" required/>
                    @error('name')
                        <p class="text-destructive text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="display_name" class="kt-label">Nama Tampilan</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="display_name" class="kt-input w-full" value="{{ old('display_name') }}"
                        placeholder="Masukkan nama tampilan" required/>
                    @error('display_name')
                        <p class="text-destructive text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="kt-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" class="kt-textarea" placeholder="Masukkan deskripsi">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-destructive text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="kt-btn kt-btn-primary mt-5">Buat</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('create-permission-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membuat permission baru?',
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
                        text: 'Permission baru sedang dibuat.',
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
