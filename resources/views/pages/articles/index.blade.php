@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header py-5">
            <div class="kt-card-heading">
                <h3 class="kt-card-title">Data Artikel</h3>
            </div>
            <div class="kt-card-toolbar">
                <a href="{{ route('articles.create') }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-plus"></i>
                </a>
            </div>
            <input type="text" placeholder="Cari..." class="kt-input sm:w-48" data-kt-datatable-search="true" />
        </div>
        <div class="kt-card-content">
            <div id="kt_datatable_remote_source" class="kt-card-table" data-kt-datatable-page-size="5"
                data-kt-datatable-state-save="true">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-30" data-kt-datatable-column="title">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Judul</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-24" data-kt-datatable-column="category">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Kategori</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-24" data-kt-datatable-column="tags">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Tag</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-24" data-kt-datatable-column="is_active">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Aktif</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-24" data-kt-datatable-column="is_pinned">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Sorotan</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-24" data-kt-datatable-column="created_at">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Tanggal
                                            Publikasi</span><span class="kt-table-col-sort"></span></span>
                                </th>
                                <th scope="col" class="w-30" data-kt-datatable-column="actions">
                                    <span class="kt-table-col"><span class="kt-table-col-label">Aksi</span><span
                                            class="kt-table-col-sort"></span></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!--begin:pagination-->
                <div class="kt-datatable-toolbar">
                    <div class="kt-datatable-length">
                        Show<select class="kt-select kt-select-sm w-16" name="perpage"
                            data-kt-datatable-size="true"></select>per page
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

@push('scripts')
    <script>
        'use strict';

        /**
         * Remote Data Source Example
         *
         * This example demonstrates how to initialize a KTDataTable with a remote API data source.
         */
        var KTDatatableRemoteDataDemo = (function() {
            // Track initialization state
            var isInitialized = false;
            var instance = null;

            // Main initialization function
            var init = function() {
                // Prevent multiple initializations
                if (isInitialized && instance) {
                    return instance;
                }

                // Get the datatable element
                var datatableEl = document.getElementById('kt_datatable_remote_source');
                if (!datatableEl) {
                    return null;
                }

                // Clean up any previous instances
                if (datatableEl.hasAttribute('data-kt-datatable-initialized')) {
                    if (
                        typeof KTDataTable !== 'undefined' &&
                        typeof KTDataTable.getInstance === 'function'
                    ) {
                        var oldInstance = KTDataTable.getInstance(datatableEl);
                        if (oldInstance && typeof oldInstance.dispose === 'function') {
                            oldInstance.dispose();
                        }
                    }

                    datatableEl.removeAttribute('data-kt-datatable-initialized');
                    if (datatableEl.instance) {
                        delete datatableEl.instance;
                    }
                }

                // Initialize datatable with remote data source
                var datatable = new KTDataTable(datatableEl, {
                    apiEndpoint: '{{ route('articles.datatable') }}',
                    requestMethod: 'GET',
                    requestHeaders: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },

                    // Format the API response, ensuring pagination data is properly mapped
                    mapResponse: function(response) {
                        if (response && response.data) {
                            return {
                                data: response.data,
                                totalCount: response.totalCount,
                                // Include pagination data from the API response
                                page: response.page || 1,
                                pageSize: response.pageSize || 5,
                                totalPages: response.totalPages ||
                                    Math.ceil(response.totalCount / (response.pageSize || 5)),
                            };
                        } else if (Array.isArray(response)) {
                            return {
                                data: response,
                                totalCount: response.length,
                                page: 1,
                                pageSize: 5,
                                totalPages: Math.ceil(response.length / 5),
                            };
                        } else {
                            return {
                                data: [],
                                totalCount: 0,
                                page: 1,
                                pageSize: 5,
                                totalPages: 1,
                            };
                        }
                    },

                    // Custom templates for column rendering
                    columns: {
                        title: {
                            title: 'Judul',
                        },
                        category: {
                            render: function(value) {
                                if (value) {
                                    return `<span class="kt-badge kt-badge-primary">${value}</span>`;
                                } else {
                                    return '<span class="kt-badge kt-badge-outline kt-badge-primary">Tidak ada kategori</span>';
                                }
                            },
                        },
                        tags: {
                            render: function(value) {
                                if (Array.isArray(value) && value.length > 0) {
                                    return value
                                        .map(
                                            (tag) =>
                                            `<span class="kt-badge kt-badge-secondary mr-1 mb-1">${tag}</span>`
                                        )
                                        .join('');
                                } else {
                                    return '<span class="kt-badge kt-badge-outline kt-badge-secondary">Tidak ada tag</span>';
                                }
                            },
                        },
                        is_active: {
                            render: function(value) {
                                if (value) {
                                    return '<span class="kt-badge kt-badge-success">Ya</span>';
                                } else {
                                    return '<span class="kt-badge kt-badge-destructive">Tidak</span>';
                                }
                            },
                        },
                        is_pinned: {
                            render: function(value) {
                                if (value) {
                                    return '<span class="kt-badge kt-badge-success">Ya</span>';
                                } else {
                                    return '<span class="kt-badge kt-badge-destructive">Tidak</span>';
                                }
                            },
                        },
                        created_at: {
                            title: 'Tanggal Publikasi',
                        },
                        actions: {
                            render: function(value, row) {
                                return `
                                    <div class="flex items-center">
                                        <a href="${row.actions.show}" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm mr-2" title="Lihat">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        <a href="${row.actions.edit}" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm mr-2" title="Edit">
                                            <i class="ki-filled ki-pencil"></i>
                                        </a>
                                        <form action="${row.actions.delete}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="kt-btn kt-btn-icon kt-btn-outline kt-btn-sm" title="Hapus" data-kt-modal-toggle="#modal-delete-article-${row.id}">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
                                            <div class="kt-modal z-40" data-kt-modal="true" id="modal-delete-article-${row.id}">
                                                <div
                                                    class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                                                    <div class="kt-modal-header">
                                                        <h3 class="kt-modal-title">Konfirmasi Hapus</h3>
                                                        <button type="button" class="kt-modal-close"
                                                            aria-label="Close modal"
                                                            data-kt-modal-dismiss="#modal-delete-article-${row.id}">
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
                                                                <p class="font-medium">Anda menghapus artikel:
                                                                    <strong>${row.title}</strong></p>
                                                                <p class="text-sm text-muted">Pastikan data sudah
                                                                    dicadangkan sebelum melanjutkan.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="kt-modal-footer">
                                                        <div></div>
                                                        <div class="flex gap-4">
                                                            <button class="kt-btn kt-btn-secondary"
                                                                data-kt-modal-dismiss="#modal-delete-article-${row.id}" type="button">Tidak,
                                                                Kembali</button>
                                                            <button class="kt-btn kt-btn-primary" type="submit">Ya,
                                                                Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                `;
                            },
                        },
                    },

                    // Core configuration
                    pageSize: 5,
                    stateSave: true,

                    // Add callbacks for pagination events
                    callbacks: {
                        afterDraw: function(datatable) {
                            // Add any custom behavior after drawing the table
                        },
                    },
                });

                // Mark as initialized and store instance
                isInitialized = true;
                instance = datatable;

                return datatable;
            };

            // Public API
            return {
                init: function() {
                    return init();
                },
            };
        })();

        /**
         * Initialize the datatable when the page loads
         */
        // Function to safely initialize only once
        function safeInitialize() {
            var element = document.getElementById('kt_datatable_remote_source');
            if (!element) {
                return;
            }

            var instance = KTDatatableRemoteDataDemo.init();
            if (instance) {
                window.datatableInstance = instance;
            }
        }

        // Only attach the event listener once
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', safeInitialize, {
                once: true
            });
        } else {
            // DOM is already loaded, initialize immediately
            setTimeout(safeInitialize, 1);
        }
    </script>
@endpush
