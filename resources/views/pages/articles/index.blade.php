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
        </div>
        <div class="kt-card-content p-5">
            <div class="grid w-full space-y-5">
                <div class="kt-card">
                    <div class="kt-card-header min-h-16">
                        <form action="{{ route('articles.index') }}" method="get">
                            <input type="text" value="{{ request('search') }}" name="search" placeholder="Cari..."
                                class="kt-input sm:w-48" />
                            <button type="submit" hidden></button>
                        </form>
                    </div>
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
                                        <th scope="col" class="w-20" data-kt-datatable-column="user_name">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Pengguna</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="category_name">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Kategori</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="tag_names">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Tag</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="is_active">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Status
                                                    Aktif</span><span class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="is_pinned">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Status
                                                    Pin</span><span class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="created_at">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Tanggal
                                                    Dibuat</span><span class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="updated_at">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Tanggal
                                                    Diperbaharui</span><span class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-20" data-kt-datatable-column="updated_at">
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

                const urlParams = new URLSearchParams(window.location.search);
                const search = urlParams.get('search');

                // Initialize datatable with remote data source
                var datatable = new KTDataTable(datatableEl, {
                    apiEndpoint: '{{ route('articles.datatable') }}',
                    requestMethod: 'GET',
                    requestHeaders: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    mapRequest: function(params) {
                        if (search) {
                            params.set('search', search);
                        }

                        return params;
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
                        user_name: {
                            title: 'Pengguna',
                        },
                        category_name: {
                            render: function(value) {
                                if (value) {
                                    return `<span class="kt-badge kt-badge-primary">${value}</span>`;
                                } else {
                                    return '<span class="kt-badge kt-badge-outline kt-badge-primary">Tidak ada kategori</span>';
                                }
                            },
                        },
                        tag_names: {
                            render: function(value) {
                                if (value.length > 0) {
                                    return value
                                        .map(
                                            (tag) =>
                                            `<span class="kt-badge kt-badge-secondary">${tag}</span>`
                                        )
                                        .join('');
                                } else {
                                    return '<span class="kt-badge kt-badge-outline kt-badge-secondary">Tidak ada tag</span>';
                                }
                            },
                        },
                        is_active: {
                            render: function(value) {
                                if (value === 'Aktif') {
                                    return `<span class="kt-badge kt-badge-success">${value}</span>`;
                                } else {
                                    return `<span class="kt-badge kt-badge-destructive">${value}</span>`;
                                }
                            },
                        },
                        is_pinned: {
                            render: function(value) {
                                if (value === 'Disematkan') {
                                    return `<span class="kt-badge kt-badge-success">${value}</span>`;
                                } else {
                                    return `<span class="kt-badge kt-badge-destructive">${value}</span>`;
                                }
                            },
                        },
                        created_at: {
                            title: 'Tanggal Dibuat',
                        },
                        updated_at: {
                            title: 'Tanggal Diperbaharui',
                        },
                        actions: {
                            render: function(value, row) {
                                return `
                                    <div class="flex items-center gap-2">
                                        <a href="${row.actions.show}" class="kt-btn kt-btn-icon kt-btn-primary kt-btn-sm" title="Lihat">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        <a href="${row.actions.edit}" class="kt-btn kt-btn-icon kt-btn-secondary kt-btn-sm" title="Edit">
                                            <i class="ki-filled ki-pencil"></i>
                                        </a>
                                        <form class="delete-article-form" action="${row.actions.delete}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-icon kt-btn-destructive kt-btn-sm" title="Hapus">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
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

        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('submit', function(e) {
                if (e.target && e.target.matches('.delete-article-form')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menghapus artikel ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Tidak, batalkan',
                        confirmButtonColor: '#ef4444', // Red-500
                        cancelButtonColor: '#6b7280', // Gray-500
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Memproses...',
                                text: 'Artikel sedang dihapus.',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            setTimeout(() => {
                                e.target.submit();
                            }, 300);
                        }
                    });
                }
            });
        });
    </script>
@endpush
