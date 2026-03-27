<div>
    <!-- Chat -->
    <button class="kt-btn kt-btn-ghost kt-btn-icon hover:bg-primary/10 hover:[&_i]:text-primary size-9 rounded-full"
        data-kt-drawer-toggle="#chat_drawer">
        <i class="ki-filled ki-messages text-lg">
        </i>
    </button>

    <!--Chat Drawer-->
    <div class="kt-drawer kt-drawer-end"
        data-kt-drawer="true" data-kt-drawer-container="body" id="chat_drawer">
        <div class="flex flex-col h-full">
            <div class="kt-drawer-header">
                <div class="kt-drawer-hading">
                    <h2 class="kt-drawer-title">
                        <div class="flex flex-wrap items-center gap-2">
                            <div
                                class="bg-accent/60 flex size-11 shrink-0 items-center justify-center rounded-full border border-border">
                                <img alt="Logo aplikasi" class="size-7"
                                    src="{{ asset('assets/media/app/apple-touch-icon.png') }}" />
                            </div>
                            <div class="flex flex-col">
                                <a class="hover:text-primary text-sm font-semibold text-mono" href="#">
                                    Diskusi
                                </a>
                                <span class="text-xs font-medium italic text-muted-foreground">
                                    Temuan bug dan fitur baru
                                </span>
                            </div>
                        </div>
                    </h2>
                </div>
                <div class="kt-drawer-toolbar">
                    <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-drawer-dismiss="true">
                        <i class="ki-filled ki-cross">
                        </i>
                    </button>
                </div>
            </div>

            <div class="kt-drawer-content flex-1 overflow-y-auto">
                <div class="flex flex-col gap-5 py-5 items-start">
                    @foreach ($chats as $chat)
                        <div class="flex items-end gap-3.5 px-5 w-full group">
                            <img alt="Ilustrasi avatar blank" class="size-9 rounded-full shrink-0"
                                src="{{ asset('assets/media/avatars/blank.png') }}" />
                            <div class="flex flex-col gap-1.5 flex-1">
                                <div class="flex items-start gap-2">
                                    <div
                                        class="kt-card bg-accent/60 rounded-bs-none text-2sm flex flex-col gap-2.5 p-3 shadow-none flex-1">
                                        {{ $chat->message }}
                                    </div>
                                    @if (auth()->id() === $chat->user_id || auth()->user()->hasRole('superadmin'))
                                        <form class="delete-chat-form shrink-0"
                                            action="{{ route('chats.destroy', $chat) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="kt-btn kt-btn-sm kt-btn-icon kt-btn-destructive"
                                                title="Hapus pesan">
                                                <i class="ki-filled ki-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <span class="text-xs font-medium text-muted-foreground">
                                    {{ $chat->user->name }} • {{ $chat->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="kt-drawer-footer">
                <form id="chat-form" action="{{ route('chats.store') }}" method="POST" class="w-full">
                    @csrf
                    <div class="flex items-center gap-3">
                        <img alt="Ilutrasi avatar blank"
                            class="ms-2.5 size-7.5 rounded-full"
                            src="{{ asset('assets/media/avatars/blank.png') }}" />
                        <textarea class="kt-textarea" placeholder="Tulis pesan..." type="text" name="message" required>{{ old('message') }}</textarea>
                        <button type="submit" class="kt-btn kt-btn-mono kt-btn-sm">
                            Kirim
                        </button>
                    </div>
                    @error('message')
                        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>
    <!--End of Chat Drawer-->
    <!-- End of Chat -->
</div>

@push('scripts')
    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Lanjutkan menambahkan pesan Anda?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#3b82f6', // Blue-500
                    cancelButtonColor: '#6b7280', // Gray-500
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Pesan Anda sedang ditambahkan.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            this.submit();
                        }, 300);
                    }
                });
        });

        document.querySelectorAll('.delete-chat-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                        title: 'Hapus Pesan',
                        text: 'Apakah Anda yakin ingin menghapus pesan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        confirmButtonColor: '#ef4444', // Red-500
                    cancelButtonColor: '#6b7280', // Gray-500
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Memproses...',
                                text: 'Pesan sedang dihapus.',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            setTimeout(() => {
                                this.submit();
                            }, 300);
                        }
                    });
            });
        });
    </script>
@endpush
