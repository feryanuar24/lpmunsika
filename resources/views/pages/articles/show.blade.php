@extends('layouts.admin.base')

@section('content')
    <div class="kt-card mx-7.5">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h3 class="kt-card-title">Detail Artikel</h3>
            </div>
            <div class="kt-card-toolbar">
                <a href="{{ route('articles.index') }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-black-left"></i>
                </a>
            </div>
        </div>
        <div class="kt-card-content space-y-5">
            @if ($data['article']->thumbnail)
                <img src="{{ route('files', $data['article']->thumbnail) }}"
                    alt="Thumbnail artikel {{ $data['article']->title }}"
                    class="rounded-lg shadow-lg max-h-80 object-cover w-full max-w-xl" />
            @endif
            <div class="flex flex-wrap gap-4 text-gray-500 text-sm justify-center">
                <div class="flex items-center gap-1"><i class="ki-filled ki-user"></i>
                    {{ $data['article']->user->name }}
                </div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-category"></i>
                    {{ $data['article']->category->name }}</div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-calendar"></i>
                    {{ $data['article']->created_at->translatedFormat('d M Y') }}</div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-calendar-edit"></i>
                    {{ $data['article']->updated_at->translatedFormat('d M Y') }}</div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-eye"></i>
                    {{ $data['article']->views ?? 0 }} views
                </div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-heart"></i>
                    {{ $data['article']->likes ?? 0 }} likes
                </div>
            </div>
            <div class="text-3xl font-semibold text-center">{{ $data['article']->title }}</div>
            <div class="flex flex-wrap gap-2 justify-center mb-2">
                @foreach ($data['article']->tags as $tag)
                    <span class="kt-badge kt-badge-secondary">{{ $tag->name ?? $tag }}</span>
                @endforeach
            </div>
            <div class="text-justify leading-relaxed text-foreground">{!! $data['article']->content !!}</div>
            <div class="flex flex-wrap gap-4 mt-4 justify-center">
                <span class="kt-badge {{ $data['article']->is_active ? 'kt-badge-success' : 'kt-badge-destructive' }}">
                    {{ $data['article']->is_active ? 'Dipublikasikan' : 'Diarsipkan' }}
                </span>
                <span class="kt-badge {{ $data['article']->is_pinned ? 'kt-badge-success' : 'kt-badge-destructive' }}">
                    {{ $data['article']->is_pinned ? 'Disematkan' : 'Tidak Disematkan' }}
                </span>
            </div>
            @if ($data['article']->comments->count() > 0)
                <div class="space-y-3">
                    @foreach ($data['article']->comments as $comment)
                        <div class="kt-card kt-card-bordered px-5 py-3">
                            <div class="kt-card-content flex flex-col lg:flex-row items-center justify-between">
                                <div class="flex flex-col items-start gap-2">
                                    <!-- User Avatar -->
                                    <div class="flex items-center gap-2">
                                        <i class="ki-filled ki-profile-circle text-muted-foreground text-xl"></i>
                                        <div>
                                            <span class="font-medium text-foreground">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-muted-foreground">•</span>
                                            <span
                                                class="text-xs text-muted-foreground">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <p class="text-foreground">{{ $comment->content }}</p>
                                </div>
                                <form class="delete-comment-form" action="{{ route('articles.delete-comment', $comment->id) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="SUBMIT" class="kt-btn kt-btn-sm kt-btn-destructive">
                                        <i class="ki-filled ki-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="ki-filled ki-message-text text-4xl text-gray-300 mb-2"></i>
                    <p class="text-muted-foreground">Belum ada komentar.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.body.addEventListener('submit', function(e) {
            if (e.target && e.target.matches('.delete-comment-form')) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus komentar ini?',
                    icon: 'question',
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
                            text: 'Komentar sedang dihapus.',
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
    </script>
@endpush
