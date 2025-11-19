@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">
                    Daftar Footer
                </h2>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('footers.create') }}">
                    <i class="ki-filled ki-plus"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content">
            <div class="kt-card-table" data-kt-datatable="true" data-kt-datatable-page-size="5"
                data-kt-datatable-state-save="true">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-20" data-kt-datatable-column="name">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Nama</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="url">
                                    <span class="kt-table-col"><span class="kt-table-col-label">URL</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="actions">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['footers'] as $footer)
                                <tr>
                                    <td>{{ $footer->name }}</td>
                                    <td>
                                        <a href="{{ $footer->url }}" target="_blank"
                                            class="kt-link">{{ $footer->url }}</a>
                                    </td>
                                    <td>
                                        <div class="flex justify-start gap-2">
                                            <a href="{{ route('footers.show', $footer->id) }}"
                                                class="kt-btn kt-btn-icon kt-btn-outline size-6">
                                                <i class="ki-filled ki-eye"></i>
                                            </a>
                                            <a href="{{ route('footers.edit', $footer->id) }}"
                                                class="kt-btn kt-btn-icon kt-btn-outline size-6">
                                                <i class="ki-filled ki-pencil"></i>
                                            </a>
                                            <form action="{{ route('footers.destroy', $footer->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button"
                                                    data-kt-modal-toggle="#modal-delete-footer-{{ $footer->id }}"
                                                    class="kt-btn kt-btn-icon kt-btn-outline size-6">
                                                    <i class="ki-filled ki-trash"></i>
                                                </button>
                                                <div class="kt-modal z-40" data-kt-modal="true"
                                                    id="modal-delete-footer-{{ $footer->id }}">
                                                    <div
                                                        class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                                                        <div class="kt-modal-header">
                                                            <h3 class="kt-modal-title">Konfirmasi Hapus</h3>
                                                            <button type="button" class="kt-modal-close"
                                                                aria-label="Close modal"
                                                                data-kt-modal-dismiss="#modal-delete-footer-{{ $footer->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="lucide lucide-x" aria-hidden="true">
                                                                    <path d="M18 6 6 18"></path>
                                                                    <path d="m6 6 12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="kt-modal-body">
                                                            <div class="flex items-center gap-4">
                                                                <i class="ki-filled ki-lock text-4xl text-blue-600"></i>
                                                                <div>
                                                                    <p class="font-medium">Anda menghapus footer ini.
                                                                    </p>
                                                                    <p class="text-sm text-muted">Pastikan data sudah
                                                                        dicadangkan sebelum
                                                                        melanjutkan.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="kt-modal-footer">
                                                            <div></div>
                                                            <div class="flex gap-4">
                                                                <button class="kt-btn kt-btn-secondary"
                                                                    data-kt-modal-dismiss="#modal-delete-footer-{{ $footer->id }}"
                                                                    type="button">Tidak,
                                                                    Kembali</button>
                                                                <button class="kt-btn kt-btn-primary" type="submit">Ya,
                                                                    Hapus</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--begin:pagination-->
                <div class="kt-datatable-toolbar">
                    <div class="kt-datatable-length">
                        Tampil<select class="kt-select kt-select-sm w-16" name="perpage"
                            data-kt-datatable-size="true"></select>per halaman
                    </div>
                    <div class="kt-datatable-info">
                        <span data-kt-datatable-info="true"></span>
                        <div class="kt-datatable-pagination" data-kt-datatable-pagination="true"></div>
                    </div>
                </div>
                <!--end:pagination-->
            </div>
        </div>
    </div>
@endsection
