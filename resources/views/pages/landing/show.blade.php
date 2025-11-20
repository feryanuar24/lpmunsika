@extends('layouts.public.base')

@section('content')
    <div class="kt-container-fixed space-y-5">
        <div class="kt-card px-1 lg:px-5">
            <!-- Article Header -->
            <div class="kt-card-header flex-col flex items-start space-y-5 py-10">
                <!-- Title -->
                <h1 class="text-lg lg:text-2xl font-semibold text-foreground">
                    {{ $data['article']->title }}
                </h1>

                <!-- Article Meta -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 text-muted-foreground text-sm">
                    <!-- Author -->
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-profile-circle"></i>
                        <span>{{ $data['article']->user->name }}</span>
                    </div>

                    <!-- Date -->
                    <div class="flex items-center gap-2">
                        <i class="ki-filled ki-calendar"></i>
                        <span>{{ $data['article']->created_at->format('d M Y') }}</span>
                    </div>

                    <!-- Category -->
                    <div>
                        @if ($data['article']->category)
                            <span class="kt-badge kt-badge-primary kt-badge-outline rounded-full">
                                {{ $data['article']->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Tags -->
                    @if ($data['article']->tags->count() > 0)
                        <div class="flex space-x-2">
                            @foreach ($data['article']->tags as $tag)
                                <span class="kt-badge kt-badge-outline kt-badge-secondary rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Thumbnail -->
                @if ($data['article']->thumbnail_url)
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ $data['article']->thumbnail_url }}"
                            alt="Thumbnail Artikel {{ $data['article']->title }}" class="w-full h-auto object-cover"
                            loading="lazy" decoding="async" />
                    </div>
                @endif
            </div>

            <!-- Article Content -->
            <div class="kt-card-content py-10">
                <div class="text-foreground">
                    {!! $data['article']->content !!}
                </div>
            </div>

            <!-- Interaction Section -->
            <div class="kt-card-footer flex flex-col items-start gap-5">
                <!-- Like -->
                <div class="">
                    <form action="{{ route('like', $data['article']->id) }}" method="post">
                        @csrf
                        <input type="text" name="slug" value="{{ $data['article']->slug }}" hidden />
                        <button type="submit" class="kt-btn kt-btn-destructive kt-btn-sm">
                            <i class="ki-filled ki-heart text-sm mr-2"></i>
                            {{ $data['article']->likes }} Suka
                        </button>
                    </form>
                </div>

                <!-- Comments -->
                <div class="w-full space-y-5">
                    <h3 class="text-lg font-semibold text-foreground">
                        Komentar ({{ $data['article']->comments->count() }})
                    </h3>

                    @if ($data['article']->comments->count() > 0)
                        <div class="space-y-3">
                            @foreach ($data['article']->comments as $comment)
                                <div class="kt-card kt-card-bordered px-5 py-3">
                                    <div class="kt-card-body">
                                        <div class="flex flex-col items-start gap-2">
                                            <!-- User Avatar -->
                                            <div class="flex items-center gap-2">
                                                <i class="ki-filled ki-profile-circle text-muted-foreground text-xl"></i>
                                                <div>
                                                    <span class="font-medium text-foreground">{{ $comment->user->name }}</span>
                                                    <span class="text-xs text-foreground">•</span>
                                                    <span
                                                        class="text-xs text-muted-foreground">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <p class="text-muted-foreground">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-muted-foreground space-y-3">
                            <i class="ki-filled ki-message-text text-3xl"></i>
                            <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endif

                    @auth
                        <form action="{{ route('comment') }}" method="post">
                            @csrf
                            <div class="flex items-center gap-2">
                                <input type="text" name="slug" value="{{ $data['article']->slug }}" hidden />
                                <input type="text" name="content" placeholder="Tulis komentar..." class="kt-input"
                                    required />
                                <button type="submit" class="kt-btn kt-btn-sm kt-btn-mono">
                                    <i class="ki-filled ki-paper-plane text-sm"></i>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <p class="text-foreground text-sm font-medium">Silakan <a href="{{ route('login') }}"
                                    class="kt-link">masuk</a> untuk
                                berkomentar.</p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
