@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Edit Slider
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('sliders.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="edit-slider-form" action="{{ route('sliders.update', $data['slider']->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @method('PATCH')

                @csrf

                <div>
                    <label for="name" class="kt-label">Nama</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="name" class="kt-input w-full"
                        value="{{ old('name', $data['slider']->name) }}" placeholder="Masukkan nama" required/>
                    @error('name')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="banner" class="kt-label">Banner Baru</label>
                    <input type="file" name="banner" id="banner" class="kt-input w-full"/>
                    @error('banner')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <img src="{{ route('files', $data['slider']->banner) }}" alt="Banner slider {{ $data['slider']->name }}" class="mt-4 w-full">
                </div>

                <div>
                    <label for="description" class="kt-label">Deskripsi</label>
                    <textarea name="description" class="kt-textarea w-full" rows="4" placeholder="Masukkan deskripsi">{{ old('description', $data['slider']->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="kt-btn kt-btn-primary mt-5">Edit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('edit-slider-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengedit slider ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, edit',
                cancelButtonText: 'Tidak, batalkan',
                confirmButtonColor: '#3b82f6', // Blue-500
                cancelButtonColor: '#6b7280', // Gray-500
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sldier ini sedang diedit.',
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
