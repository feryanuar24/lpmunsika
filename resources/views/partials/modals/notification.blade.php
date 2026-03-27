<div class="kt-modal" data-kt-modal="true" id="modal-notification">
    <div class="kt-modal-content max-w-[420px] top-[10%]">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title">Notifikasi</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal"
                data-kt-modal-dismiss="#modal-notification">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body flex flex-col gap-2.5 max-h-[65vh] overflow-y-auto p-4">
            <form action="{{ route('users.read-all-notifications') }}" method="post">
                @csrf
                <button type="submit" class="kt-btn kt-btn-sm kt-btn-ghost mb-2 self-end">
                    Tandai semua sudah dibaca
                </button>
            </form>

            @forelse($notifications as $notif)
                <form title="Tandai sudah dibaca" id="notification-form" action="{{ route('users.read-notification') }}" method="post">
                    @csrf
                    <input type="hidden" name="notification_id" value="{{ $notif->id }}">
                    <div class="kt-card shadow-none p-3.5 rounded-lg {{ $notif->read_at ? 'bg-muted/70' : 'bg-primary/5 border border-primary/20' }} cursor-pointer transition-colors hover:bg-accent"
                        data-id="{{ $notif->id }}" data-url="{{ $notif->data['url'] ?? '#' }}">
                        <div class="flex items-start gap-3">
                            <span
                                class="flex size-9 shrink-0 items-center justify-center rounded-full {{ $notif->read_at ? 'bg-muted text-muted-foreground' : 'bg-primary/10 text-primary' }}">
                                <i class="ki-filled ki-notification-status text-lg"></i>
                            </span>
                            <div class="flex flex-col gap-0.5 flex-1 min-w-0">
                                <span class="text-sm font-semibold text-mono leading-snug">
                                    {{ $notif->data['title'] ?? 'Notifikasi' }}
                                </span>
                                <span class="text-xs text-secondary-foreground line-clamp-2">
                                    {{ $notif->data['message'] ?? '' }}
                                </span>
                                <span class="text-xs text-muted-foreground mt-0.5">
                                    {{ $notif->created_at->diffForHumans() }}
                                </span>
                            </div>
                            @unless ($notif->read_at)
                                <span class="size-2 rounded-full bg-primary shrink-0 mt-1.5"></span>
                            @endunless
                        </div>
                    </div>
                </form>
            @empty
                <div class="flex flex-col items-center justify-center py-10 gap-3 text-muted-foreground">
                    <span class="flex size-14 items-center justify-center rounded-full bg-muted">
                        <i class="ki-filled ki-notification-status text-2xl"></i>
                    </span>
                    <p class="text-sm">Belum ada notifikasi</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.querySelectorAll('#notification-form').forEach(form => {
            form.addEventListener('click', function() {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Tandai notifikasi ini sebagai sudah dibaca?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    confirmButtonColor: '#3b82f6', // Blue-500
                    cancelButtonColor: '#6b7280', // Gray-500
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Menandai notifikasi sebagai sudah dibaca.',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        })

                        setTimeout(() => {
                            form.submit();
                        }, 300);
                    }
                });
            });
        });
    </script>
@endpush
