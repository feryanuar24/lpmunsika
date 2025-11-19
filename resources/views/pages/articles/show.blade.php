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
            @if ($data['article']->thumbnail_url)
                <img src="{{ $data['article']->thumbnail_url }}" alt="Thumbnail Artikel {{ $data['article']->title }}"
                    class="rounded-lg shadow-lg max-h-80 object-cover w-full max-w-xl" />
            @endif
            <div class="flex flex-wrap gap-4 text-gray-500 text-sm justify-center">
                <div class="flex items-center gap-1"><i class="ki-filled ki-user"></i>
                    {{ $data['article']->user->name }}
                </div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-category"></i>
                    {{ $data['article']->category->name }}</div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-calendar"></i>
                    {{ $data['article']->created_at->format('d M Y') }}</div>
                <div class="flex items-center gap-1"><i class="ki-filled ki-calendar-edit"></i>
                    {{ $data['article']->updated_at->format('d M Y') }}</div>
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
                    <span class="kt-badge kt-badge-info">{{ $tag->name ?? $tag }}</span>
                @endforeach
            </div>
            <div>{!! $data['article']->content !!}</div>
            <div class="flex flex-wrap gap-4 mt-4 justify-center">
                <span class="kt-badge {{ $data['article']->is_active ? 'kt-badge-success' : 'kt-badge-danger' }}">
                    {{ $data['article']->is_active ? 'Dipublikasikan' : 'Diarsipkan' }}
                </span>
                <span class="kt-badge {{ $data['article']->is_pinned ? 'kt-badge-warning' : 'kt-badge-secondary' }}">
                    {{ $data['article']->is_pinned ? 'Disematkan' : 'Tidak Disematkan' }}
                </span>
            </div>
            @if ($data['article']->comments->count() > 0)
                <div class="space-y-3">
                    @foreach ($data['article']->comments as $comment)
                        <div class="kt-card kt-card-bordered px-5 py-3">
                            <div class="kt-card-content flex items-center justify-between">
                                <div class="flex flex-col items-start gap-2">
                                    <!-- User Avatar -->
                                    <div class="flex items-center gap-2">
                                        <i class="ki-filled ki-profile-circle text-gray-500 text-xl"></i>
                                        <div>
                                            <span class="font-medium text-gray-800">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">•</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-800">{{ $comment->content }}</p>
                                </div>
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="kt-btn kt-btn-sm kt-btn-destructive"
                                        data-kt-modal-toggle="#modal-delete-comment-{{ $comment->id }}">
                                        <i class="ki-filled ki-trash"></i>
                                    </button>
                                    <div class="kt-modal z-40" data-kt-modal="true"
                                        id="modal-delete-comment-{{ $comment->id }}">
                                        <div
                                            class="kt-modal-content max-w-md w-[90%] fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6">
                                            <div class="kt-modal-header">
                                                <h3 class="kt-modal-title">Konfirmasi Hapus</h3>
                                                <button type="button" class="kt-modal-close" aria-label="Close modal"
                                                    data-kt-modal-dismiss="#modal-delete-comment-{{ $comment->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                                        <p class="font-medium">Anda menghapus komentar ini</p>
                                                        <p class="text-sm text-muted">Pastikan data sudah
                                                            dicadangkan sebelum melanjutkan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-modal-footer">
                                                <div></div>
                                                <div class="flex gap-4">
                                                    <button class="kt-btn kt-btn-secondary"
                                                        data-kt-modal-dismiss="#modal-delete-comment-{{ $comment->id }}"
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
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="ki-filled ki-message-text text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Belum ada komentar.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
