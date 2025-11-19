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
            <form action="{{ route('embeds.store') }}" method="POST" class="space-y-5">
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
                            <option value="{{ $platform->id }}" {{ old('platform_id') == $platform->id ? 'selected' : '' }}>
                                {{ $platform->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="title" class="kt-label">Judul</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="title" class="kt-input w-full" value="{{ old('title') }}"
                        placeholder="Masukkan judul" />
                </div>

                <div>
                    <label for="embed_code" class="kt-label">Kode</label>
                    <span class="text-destructive">*</span>
                    <textarea name="embed_code" class="kt-textarea w-full" placeholder="Masukkan kode penyematan" rows="4">{{ old('embed_code') }}</textarea>
                </div>

                <div>
                    <label for="description" class="kt-label">Deskripsi</label>
                    <textarea name="description" class="kt-textarea w-full" rows="4" placeholder="Masukkan deskripsi">{{ old('description') }}</textarea>
                </div>

                <button type="button" class="kt-btn kt-btn-primary mt-5" data-kt-modal-toggle="#modal-create-embed">Buat</button>

                <div class="kt-modal z-40" data-kt-modal="true" id="modal-create-embed">
                    <div
                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                        <div class="kt-modal-header">
                            <h3 class="kt-modal-title">Konfirmasi Tambah</h3>
                            <button type="button" class="kt-modal-close" aria-label="Close modal"
                                data-kt-modal-dismiss="#modal-create-embed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="kt-modal-body">
                            <div class="flex items-center gap-4">
                                <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                <div>
                                    <p class="font-medium">Anda menambah penyematan dengan data ini.</p>
                                    <p class="text-sm text-muted">Pastikan data sudah benar sebelum
                                        melanjutkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="kt-modal-footer">
                            <div></div>
                            <div class="flex gap-4">
                                <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-create-embed"
                                    type="button">Tidak, Kembali</button>
                                <button class="kt-btn kt-btn-primary" type="submit">Ya, Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
