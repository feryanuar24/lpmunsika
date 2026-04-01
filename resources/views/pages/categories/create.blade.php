@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Tambah Kategori
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('categories.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="create-category-form" action="{{ route('categories.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="parent_id" class="kt-label">Induk Kategori</label>
                    <span class="text-muted text-xs">(Opsional, pilih induk kategori jika ini adalah subkategori)</span>
                    <select name="parent_id" id="parent_id" class="kt-select" data-kt-select="true"
                        data-kt-select-placeholder="Pilih induk kategori (opsional)"
                        data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                        <option value="">Tidak ada induk (kategori utama)</option>
                        @foreach ($data['parent_categories'] as $category)
                            <option value="{{ $category->id }}" @selected(old('parent_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="kt-label">Nama</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="name" class="kt-input w-full" value="{{ old('name') }}"
                        placeholder="Masukkan nama" required />
                    @error('name')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="kt-label">Deskripsi</label>
                    <textarea name="description" class="kt-textarea w-full" rows="4" placeholder="Masukkan deskripsi">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="kt-btn kt-btn-primary mt-5">Buat</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('create-category-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membuat kategori baru?',
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
                        text: 'Kategori baru sedang dibuat.',
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
