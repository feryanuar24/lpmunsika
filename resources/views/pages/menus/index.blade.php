@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <kt class="kt-card-title">
                    Daftar Menu
                </kt>
            </div>
        </div>
        <div class="kt-card-content p-5">
            <div class="grid w-full space-y-5">
                <div class="kt-card">
                    <div class="kt-card-header min-h-16">
                        <form action="{{ route('menus.index') }}" method="get">
                            <input type="text" value="{{ request('search') }}" name="search" placeholder="Cari..."
                                class="kt-input sm:w-48" />
                            <button type="submit" hidden></button>
                        </form>
                    </div>
                    <div id="kt_datatable_remote_source" class="kt-card-table" data-kt-datatable-page-size="5" data-kt-datatable-state-save="false">
                        <div class="kt-table-wrapper kt-scrollable">
                            <table class="kt-table" data-kt-datatable-table="true">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-30" data-kt-datatable-column="name">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Nama</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-24" data-kt-datatable-column="url">
                                            <span class="kt-table-col"><span class="kt-table-col-label">URL</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-20" data-kt-datatable-column="icon">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Ikon</span><span
                                                    class="kt-table-col-sort"></span></span>
                                        </th>
                                        <th scope="col" class="w-20" data-kt-datatable-column="parent_name">
                                            <span class="kt-table-col"><span class="kt-table-col-label">Parent</span><span
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

        var KTDatatableRemoteDataMenus = (function() {
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
                    apiEndpoint: '{{ route('menus.datatable') }}',
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
                        url: {
                            render: function(value) {
                                return value ?
                                    `<span class="kt-badge kt-badge--primary kt-badge--inline">${value}</span>` :
                                    '-';
                            },
                        },
                        icon: {
                            render: function(value) {
                                return value ?
                                    `<i class="ki-filled ${value}"></i>` :
                                    '-';
                            },
                        },
                        parent_name: {
                            render: function(value) {
                                return value || '-';
                            },
                        },
                        actions: {
                            title: 'Aksi',
                            sortable: false,
                            render: function(value) {
                                return value.redirect ?
                                    `<a href="${value.redirect}" class="btn btn-sm btn-icon"><i class="ki-filled ki-paper-plane"></i></a>` :
                                    '-';
                            },
                        },
                    },

                    // Core configuration
                    pageSize: 5,
                    stateSave: false,

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

            var instance = KTDatatableRemoteDataMenus.init();
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
