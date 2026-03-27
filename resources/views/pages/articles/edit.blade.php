@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h3 class="kt-card-title">Edit Artikel</h3>
            </div>
            <div class="kt-card-toolbar">
                <a href="{{ route('articles.index') }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <form id="edit-article-form" action="{{ route('articles.update', $data['article']) }}" method="POST"
                enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="title" class="kt-label">Judul</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="title" class="kt-input w-full" placeholder="Masukkan judul"
                        value="{{ old('title', $data['article']->title) }}" required />
                    @error('title')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content_texteditor" class="kt-label">Konten</label>
                    <span class="text-destructive">*</span>
                    <textarea id="content_texteditor" name="content" class="w-full" rows="10" placeholder="Masukkan konten">{{ old('content', $data['article']->content) }}</textarea>
                    @error('content')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div id="embed-section" class="hidden">
                    <label for="embed" class="kt-label">Penyematan</label>
                    <textarea class="kt-textarea" name="embed" id="embed" cols="30" rows="10" placeholder="Masukkan kode">{{ old('embed', $data['article']->embed ?? '') }}</textarea>
                    @error('embed')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="kt-label">Kategori</label>
                    <span class="text-destructive">*</span>
                    <select name="category_id" id="category_id" class="kt-select" data-kt-select="true"
                        data-kt-select-placeholder="Pilih kategori"
                        data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                        @foreach ($data['categories'] as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $data['article']->category->id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tags" class="kt-label">Tag</label>
                    <select multiple name="tags[]" class="kt-select" data-kt-select="true"
                        data-kt-select-placeholder="Pilih tag"
                        data-kt-select-config='{
                            "multiple": true,
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                        @foreach ($data['tags'] as $tag)
                            <option value="{{ $tag->id }}" @selected(collect(old('tags', $data['article']->tags->pluck('id')->toArray()))->contains($tag->id))>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tags')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3">
                    <div class="flex">
                        <label for="thumbnail" class="kt-label mr-1">Thumbnail</label>
                    </div>

                    @if ($data['article']->thumbnail)
                        <img src="{{ route('files', $data['article']->thumbnail) }}"
                            alt="Thumbnail artikel {{ $data['article']->title }}"
                            class="w-32 h-32 object-cover rounded border border-border">
                    @endif

                    <input type="file" name="thumbnail" class="kt-input w-full" accept="image/*" required />
                    <span class="text-xs text-muted-foreground">Ukuran maksimal 5MB. Format gambar. Jika Anda mengunggah
                        gambar baru, gambar lama akan digantikan.</span>
                    @error('thumbnail')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_active" class="kt-label mb-3">Status Aktif</label>
                    <span class="text-destructive">*</span>
                    <div class="grid gap-2.5">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="is_active_true" name="is_active" value="1"
                                @checked(old('is_active', $data['article']->is_active ? '1' : '0') == '1') />
                            <label class="kt-label" for="is_active_true">Aktif</label>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="is_active_false" name="is_active" value="0"
                                @checked(old('is_active', $data['article']->is_active ? '1' : '0') == '0') />
                            <label class="kt-label" for="is_active_false">Tidak Aktif</label>
                        </div>
                    </div>
                    @error('is_active')
                        <p class="text-destructive mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_pinned" class="kt-label mb-3">Status Pin</label>
                    <span class="text-destructive">*</span>
                    <div class="grid gap-2.5">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="is_active_true" name="is_pinned" value="1"
                                @checked(old('is_pinned', $data['article']->is_pinned ? '1' : '0') == '1') />
                            <label class="kt-label" for="is_active_true">Disematkan</label>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="is_active_false" name="is_pinned" value="0"
                                @checked(old('is_pinned', $data['article']->is_pinned ? '1' : '0') == '0') />
                            <label class="kt-label" for="is_active_false">Tidak Disematkan</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="kt-btn kt-btn-primary mt-5">Edit</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .ck-content {
            color: #000000 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }

            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('articles.upload-image') }}', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const errorMessage = `Terjadi kesalahan saat mengunggah gambar: ${file.name}.`;

                xhr.addEventListener('error', () => reject(errorMessage));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || xhr.status !== 200) {
                        return reject(errorMessage);
                    }

                    resolve({
                        default: response.url
                    });
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();
                data.append('upload', file);
                this.xhr.send(data);
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        document.getElementById('category_id').addEventListener('change', function() {
            const categoryId = document.getElementById('category_id');
            const categoryName = categoryId.options[categoryId.selectedIndex].text.toLowerCase();
            const embedSection = document.getElementById('embed-section');
            if (categoryName === 'buletin' || categoryName === 'majalah') {
                embedSection.classList.remove('hidden');
            } else {
                embedSection.classList.add('hidden');
            }
        });

        document.getElementById('edit-article-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: "Pastikan semua data sudah benar sebelum diedit.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6', // Blue-500
                cancelButtonColor: '#6b7280', // Gray-500
                confirmButtonText: 'Ya, edit!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Artikel sedang diedit. Mohon tunggu.',
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
        });

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.getElementById('content_texteditor'), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'imageUpload',
                            'blockQuote',
                            'insertTable',
                            '|',
                            'undo',
                            'redo'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    },
                    extraPlugins: [MyCustomUploadAdapterPlugin]
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
