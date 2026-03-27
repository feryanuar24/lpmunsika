@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">

        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Tambah Penyematan
                </h2>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-primary" href="{{ route('embeds.index') }}">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="create-embed-form" action="{{ route('embeds.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="platform_id" class="kt-label">Platform</label>
                    <span class="text-destructive">*</span>
                    <select name="platform_id" class="kt-select" data-kt-select="true"
                        data-kt-select-placeholder="Pilih platform"
                        data-kt-select-config='{
                        "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                    }'>
                        @foreach ($data['platforms'] as $platform)
                            <option value="{{ $platform->id }}" @selected(old('platform_id') == $platform->id)>
                                {{ $platform->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('platform_id')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="kt-label">Judul</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="title" class="kt-input w-full" value="{{ old('title') }}"
                        placeholder="Masukkan judul" required />
                    @error('title')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="embed_code" class="kt-label">Kode</label>
                    <span class="text-destructive">*</span>
                    <textarea name="embed_code" class="kt-textarea w-full" placeholder="Masukkan kode penyematan" rows="4">{{ old('embed_code') }}</textarea>
                    <span class="text-xs text-muted-foreground block mt-1">Ganti atribut <code>width=""</code> pada kode embed dengan <code>class="w-full"</code> agar responsif.</span>
                    @error('embed_code')
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
        document.getElementById('create-embed-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membuat penyematan baru?',
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
                        text: 'Penyematan baru sedang dibuat.',
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
