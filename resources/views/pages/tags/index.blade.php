@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <kt class="kt-card-title">
                    Daftar Tag
                </kt>
            </div>
            <div class="kt-card-toolbar">
                <a class="kt-btn kt-btn-primary" href="{{ route('tags.create') }}">
                    <i class="ki-filled ki-plus"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content p-5">
            <div class="grid w-full space-y-5">
                <div class="kt-card">
                    <div class="kt-card-header min-h-16">
                        <form action="{{ route('tags.index') }}" method="get">
                            <input type="text" value="{{ request('search') }}" name="search" placeholder="Cari..."
                                class="kt-input sm:w-48" />
                            <button type="submit" hidden></button>
                        </form>
                    </div>
                    <div id="kt_datatable_remote_source" class="kt-card-table" data-kt-datatable-page-size="5">
                        <div class="kt-table-wrapper kt-scrollable">
                            <table class="kt-table" data-kt-datatable-table="true">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-30" data-kt-datatable-column="name">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Nama</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-20" data-kt-datatable-column="slug">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Slug</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-20" data-kt-datatable-column="actions">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Aksi</span></span>
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

        var KTDatatableRemoteDataTags = (function() {
            // Track initialization state
            var isInitialized = false;
            var instance = null;

            // Main initialization function
            var init = function() {
                // Wait for KTDataTable to be available
                if (typeof window.KTDataTable === 'undefined') {
                    console.warn('KTDataTable is not loaded yet. Retrying...');
                    setTimeout(init, 100);
                    return null;
                }

                // Use window.KTDataTable for consistency
                var KTDataTable = window.KTDataTable;

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
                    apiEndpoint: '{{ route('tags.datatable') }}',
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
                        name: {
                            title: 'Nama',
                        },
                        slug: {
                            title: 'Slug',
                        },
                        actions: {
                            title: 'Aksi',
                            sortable: false,
                            render: function(value) {
                                return `
                                    <div class="flex items-center gap-2">
                                        <a href="${value.show}" class="kt-btn kt-btn-sm kt-btn-primary kt-btn-icon">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        <a href="${value.edit}" class="kt-btn kt-btn-sm kt-btn-secondary kt-btn-icon">
                                            <i class="ki-filled ki-pencil"></i>
                                        </a>
                                        <form action="${value.delete}" method="POST" class="delete-tag-form">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-destructive kt-btn-icon">
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

                    // Add callbacks for pagination events
                    callbacks: {
                        afterDraw: function() {
                            // Add any custom behavior after drawing the table
                        },
                    },
                });

                // Mark as initialized and store instance
                isInitialized = true;
                instance = datatable;

                return instance;
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

            var instance = KTDatatableRemoteDataTags.init();
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
                if (e.target && e.target.matches('.delete-tag-form')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menghapus tag ini?',
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
                                text: 'Tag sedang dihapus.',
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
