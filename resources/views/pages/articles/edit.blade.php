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
            <form action="{{ route('articles.update', $data['article']) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="title" class="kt-label">Judul</label>
                    <span class="text-destructive">*</span>
                    <input type="text" name="title" class="kt-input w-full" placeholder="Masukkan judul"
                        value="{{ old('title', $data['article']->title) }}" />
                </div>

                <div>
                    <label for="content" class="kt-label">Konten</label>
                    <span class="text-destructive">*</span>
                    <textarea id="content_texteditor" name="content" class="w-full" rows="10" placeholder="Masukkan konten">{{ old('content', $data['article']->content) }}</textarea>
                </div>

                <div id="embed-section" class="hidden">
                    <label for="embed" class="kt-label">Penyematan</label>
                    <textarea class="kt-textarea" name="embed" id="embed" cols="30" rows="10" placeholder="Masukkan kode">{{ old('embed', $data['article']->embed ?? '') }}</textarea>
                </div>

                <div>
                    <label for="category_id" class="kt-label">Kategori</label>
                    <span class="text-destructive">*</span>
                    <select name="category_id" id="category_select" class="kt-select" data-kt-select="true"
                        data-kt-select-placeholder="Pilih kategori"
                        data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                        @foreach ($data['categories'] as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $data['article']->category->id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
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
                            <option value="{{ $tag->name }}"
                                {{ collect(old('tags', $data['article']->tags->pluck('name')))->contains($tag->name) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="flex">
                        <label for="thumbnail" class="kt-label mr-1">Thumbnail</label>
                        <span class="kt-label text-muted-foreground">(Upload gambar baru untuk mengganti atau klik x untuk menghapus gambar)</span>
                    </div>

                    @if ($data['article']->thumbnail_url)
                        <div class="mb-3" id="current-thumbnail">
                            <div class="flex items-center w-full justify-start gap-4">
                                <img src="{{ $data['article']->thumbnail_url }}" alt="Current thumbnail"
                                    class="w-32 h-32 object-cover rounded border border-border">
                                <button onclick="removeThumbnail()" type="button"
                                    class="kt-btn-icon kt-btn-destructive rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"
                                        aria-hidden="true">
                                        <path d="M18 6 6 18"></path>
                                        <path d="m6 6 12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" name="remove_thumbnail" id="remove_thumbnail" value="0">
                        </div>
                    @endif

                    <input type="file" name="thumbnail" class="kt-input w-full" accept="image/*" />
                </div>

                <script>
                    function removeThumbnail() {
                        document.getElementById('remove_thumbnail').value = '1';
                        document.getElementById('current-thumbnail').style.display = 'none';
                    }
                </script>

                <div>
                    <label for="is_active" class="kt-label mb-3">Publikasikan</label>
                    <span class="text-destructive">*</span>
                    <div class="grid gap-2.5">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="published" name="is_active" value="1"
                                {{ old('is_active', $data['article']->is_active) == 1 ? 'checked' : '' }} />
                            <label class="kt-label" for="published">Ya</label>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="unpublished" name="is_active" value="0"
                                {{ old('is_active', $data['article']->is_active) == 0 ? 'checked' : '' }} />
                            <label class="kt-label" for="unpublished">Tidak</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="is_pinned" class="kt-label mb-3">Sorotkan</label>
                    <span class="text-destructive">*</span>
                    <div class="grid gap-2.5">
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="pinned" name="is_pinned" value="1"
                                {{ old('is_pinned', $data['article']->is_pinned) == 1 ? 'checked' : '' }} />
                            <label class="kt-label" for="pinned">Ya</label>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <input type="radio" class="kt-radio" id="unpinned" name="is_pinned" value="0"
                                {{ old('is_pinned', $data['article']->is_pinned) == 0 ? 'checked' : '' }} />
                            <label class="kt-label" for="unpinned">Tidak</label>
                        </div>
                    </div>
                </div>

                <button type="button" class="kt-btn kt-btn-primary mt-5"
                    data-kt-modal-toggle="#modal-edit-article">Edit</button>

                <div class="kt-modal z-40" data-kt-modal="true" id="modal-edit-article">
                    <div
                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                        <div class="kt-modal-header">
                            <h3 class="kt-modal-title">Konfirmasi Update</h3>
                            <button type="button" class="kt-modal-close" aria-label="Close modal"
                                data-kt-modal-dismiss="#modal-edit-article">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"
                                    aria-hidden="true">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="kt-modal-body">
                            <div class="flex items-center gap-4">
                                <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                <div>
                                    <p class="font-medium">Anda mengupdate artikel dengan data ini.</p>
                                    <p class="text-sm text-muted">Pastikan data sudah benar sebelum
                                        melanjutkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="kt-modal-footer">
                            <div></div>
                            <div class="flex gap-4">
                                <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal-edit-article"
                                    type="button">Tidak,
                                    Kembali</button>
                                <button class="kt-btn kt-btn-primary" type="submit">Ya, Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Custom Upload Adapter
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
                xhr.open('POST', '{{ route('ckeditor.upload') }}', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${file.name}.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || xhr.status !== 200) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
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

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content_texteditor'), {
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

            // Handle category change to show/hide embed section
            const categorySelect = document.getElementById('category_select');
            const embedSection = document.getElementById('embed-section');

            function toggleEmbedSection() {
                const selectedValue = categorySelect.value;
                if (selectedValue == '2') {
                    embedSection.classList.remove('hidden');
                } else {
                    embedSection.classList.add('hidden');
                }
            }

            // Listen for change event
            categorySelect.addEventListener('change', toggleEmbedSection);

            // Check initial state (for old input values)
            toggleEmbedSection();
        });
    </script>
@endpush
