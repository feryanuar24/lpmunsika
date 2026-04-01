@extends('layouts.admin.base')

@section('content')
    <!-- Head Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Dashboard Analitik
                </h1>
                <p class="text-sm text-gray-600">Overview statistik sistem dan aktivitas</p>
            </div>
        </div>
    </div>
    <!-- End of Head Container -->

    <!-- Body Container -->
    <div class="kt-container-fixed">
        @permission('dashboard-management')
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-7.5">
                <!-- Total Users -->
                <div class="kt-card p-5 col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-50 rounded-lg">
                            <i class="ki-filled ki-people text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Pengguna</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['total_users']) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Articles -->
                <div class="kt-card p-5 col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-50 rounded-lg">
                            <i class="ki-filled ki-document text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Artikel</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['total_articles']) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Comments -->
                <div class="kt-card p-5 col-span-2">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-violet-50 rounded-lg">
                            <i class="ki-filled ki-eye text-violet-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Artikel Dilihat</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['total_views']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Grouping -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-7.5">
                <!-- Articles by Status -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Artikel Berdasarkan Status</h3>
                    <div id="articles-status-chart" style="height: 300px;"></div>
                </div>

                <!-- Articles by Category -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Artikel Berdasarkan Kategori</h3>
                    <div id="articles-category-chart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Data Trends -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-7.5">
                <!-- User Registration Trend -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Tren Registrasi Pengguna</h3>
                    <div id="user-trend-chart" style="height: 300px;"></div>
                </div>

                <!-- Article Publishing Trend -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Tren Publikasi Artikel</h3>
                    <div id="article-trend-chart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Viewer Data -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-7.5">
                <!-- Most Viewed Articles -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Artikel Teratas</h3>
                    <div class="space-y-3">
                        @foreach ($data['most_viewed_articles'] as $article)
                            <div class="p-3 kt-card">
                                <h4 class="font-medium text-sm line-clamp-2 mb-2">
                                    <a href="{{ route('articles.show', $article['id']) }}"
                                        class="hover:text-primary transition-colors">
                                        {{ $article['title'] }}
                                    </a>
                                </h4>
                                <div class="flex items-center justify-between text-mono text-xs">
                                    <span class="kt-badge kt-badge-primary">{{ $article['category'] }}</span>
                                    <span class="kt-badge kt-badge-info">{{ number_format($article['views']) }}
                                        pengunjung</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Views Distribution -->
                <div class="kt-card p-5 mb-7.5">
                    <h3 class="text-lg font-semibold mb-4">Distribusi Jumlah Pembaca</h3>
                    <div id="views-distribution-chart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="kt-card p-5 mb-7.5">
                <h3 class="text-lg font-semibold mb-4">Komentar Terbaru</h3>
                <div class="space-y-4">
                    @foreach ($data['recent_comments'] as $comment)
                        <div class="kt-card p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-sm">
                                    <a href="{{ route('articles.show', $comment->article->id) }}"
                                        class="hover:text-primary transition-colors">
                                        {{ $comment->article->title }}
                                    </a>
                                </h4>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-mono text-sm">
                                    {{ $comment->content }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between text-mono text-xs mt-2">
                                <div class="text-xs text-mono">{{ $comment->created_at->diffForHumans() }}</div>
                                <div class="kt-badge kt-badge-secondary kt-badge-sm">
                                    <i class="ki-filled ki-profile-circle text-xs mr-1"></i>
                                    {{ $comment->user->name }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div>
                <!-- Personal Comment Analytics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-7.5">
                    <!-- Total Comments -->
                    <div class="kt-card p-5">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg">
                                <i class="ki-filled ki-message-text text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Komentar</p>
                                <h3 class="text-2xl font-bold">{{ $data['total_comments'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Articles Commented On -->
                    <div class="kt-card p-5">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                <i class="ki-filled ki-document text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Artikel</p>
                                <h3 class="text-2xl font-bold">{{ $data['total_articles'] }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments per Month -->
                <div class="kt-card p-5 mb-7.5">
                    <h3 class="text-lg font-semibold mb-4">Komentar per Bulan</h3>
                    <div id="comments-per-month-chart" style="height: 300px;"></div>
                </div>

                <!-- Recent Comments Table -->
                <div class="kt-card p-5 mb-7.5">
                    <h3 class="text-lg font-semibold mb-4">Komentar Terbaru</h3>
                    <div class="space-y-3">
                        @foreach ($data['comments'] as $comment)
                            <div class="p-3 kt-card mb-3">
                                <h4 class="font-medium text-sm line-clamp-2 mb-2">
                                    <a href="{{ route('detail', $comment->article->slug) }}"
                                        class="hover:text-primary transition-colors">
                                        {{ $comment->article->title }}
                                    </a>
                                </h4>
                                <p class="text-mono text-sm mb-2">
                                    {{ $comment->content }}
                                </p>
                                <div class="flex items-center justify-between text-mono text-xs">
                                    <span
                                        class="kt-badge kt-badge-secondary">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endpermission
    </div>
    <!-- End of Body Container -->
@endsection

@push('scripts')
    <script>
        @permission('dashboard-management')
            const statusChart = new ApexCharts(document.getElementById("articles-status-chart"), {
                series: [{{ $data['articles_by_status']['published'] }},
                    {{ $data['articles_by_status']['draft'] }}
                ],
                chart: {
                    type: 'donut',
                    height: 300,
                    fontFamily: 'Inter, sans-serif'
                },
                labels: ['Diterbitkan', 'Diarsipkan'],
                colors: ['#10B981', '#F59E0B'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return Math.round(val) + "%"
                    }
                }
            });
            statusChart.render();

            const categoryChart = new ApexCharts(document.getElementById("articles-category-chart"), {
                series: [{
                    name: 'Artikel',
                    data: {!! $data['articles_by_category']->pluck('count')->toJson() !!}
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#3B82F6'],
                xaxis: {
                    categories: {!! $data['articles_by_category']->pluck('name')->toJson() !!}
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '70%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                }
            });
            categoryChart.render();

            const userTrendChart = new ApexCharts(document.getElementById("user-trend-chart"), {
                series: [{
                    name: 'Pengguna Baru',
                    data: {!! $data['user_registration_trend']->pluck('count')->toJson() !!}
                }],
                chart: {
                    type: 'line',
                    height: 300,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#8B5CF6'],
                stroke: {
                    width: 3,
                    curve: 'smooth'
                },
                xaxis: {
                    categories: {!! $data['user_registration_trend']->pluck('month')->toJson() !!}
                },
                markers: {
                    size: 6,
                    hover: {
                        size: 8
                    }
                },
                grid: {
                    borderColor: '#e7e7e7'
                }
            });
            userTrendChart.render();

            const articleTrendChart = new ApexCharts(document.getElementById("article-trend-chart"), {
                series: [{
                    name: 'Artikel Dipublikasikan',
                    data: {!! $data['article_publishing_trend']->pluck('count')->toJson() !!}
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#06B6D4'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                    }
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                xaxis: {
                    categories: {!! $data['article_publishing_trend']->pluck('month')->toJson() !!}
                },
                grid: {
                    borderColor: '#e7e7e7'
                }
            });
            articleTrendChart.render();

            const viewsDistributionChart = new ApexCharts(document.getElementById("views-distribution-chart"), {
                series: [
                    {{ round(($data['views_distribution']['low'] / max($data['stats']['total_articles'], 1)) * 100) }},
                    {{ round(($data['views_distribution']['medium'] / max($data['stats']['total_articles'], 1)) * 100) }},
                    {{ round(($data['views_distribution']['high'] / max($data['stats']['total_articles'], 1)) * 100) }}
                ],
                chart: {
                    type: 'radialBar',
                    height: 300,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#EF4444', '#F59E0B', '#10B981'],
                labels: ['Sedikit (<100)', 'Sedang (100-1K)', 'Banyak (>1K)'],
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '12px',
                            },
                            value: {
                                fontSize: '14px',
                                formatter: function(val) {
                                    return val + "%"
                                }
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                }
            });
            viewsDistributionChart.render();
        @else
            const commentPerMonthChart = new ApexCharts(document.getElementById("comments-per-month-chart"), {
                series: [{
                    name: 'Komentar',
                    data: {!! $data['comments_per_month']->pluck('count')->toJson() !!}
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#FF6B6B'],
                xaxis: {
                    categories: {!! $data['comments_per_month']->pluck('month')->toJson() !!}
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '70%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                }
            });
            commentPerMonthChart.render();
        @endpermission
    </script>
@endpush
