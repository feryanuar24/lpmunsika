<div>
    <!-- Chat -->
    <button class="kt-btn kt-btn-ghost kt-btn-icon hover:bg-primary/10 hover:[&_i]:text-primary size-9 rounded-full"
        data-kt-drawer-toggle="#chat_drawer">
        <i class="ki-filled ki-messages text-lg">
        </i>
    </button>
    <!--Chat Drawer-->
    <div class="kt-drawer kt-drawer-end card bottom-5 end-5 top-5 hidden w-[450px] max-w-[90%] flex-col rounded-xl border border-border"
        data-kt-drawer="true" data-kt-drawer-container="body" id="chat_drawer">
        <div>
            <div class="flex items-center justify-between gap-2.5 px-5 py-3.5 text-sm font-semibold text-mono">
                Obrolan
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-drawer-dismiss="true">
                    <i class="ki-filled ki-cross">
                    </i>
                </button>
            </div>
            <div class="border-b border-b-border">
            </div>
            <div class="border-b border-border py-2.5">
                <div class="flex flex-wrap items-center justify-between gap-2 px-5">
                    <div class="flex flex-wrap items-center gap-2">
                        <div
                            class="bg-accent/60 flex size-11 shrink-0 items-center justify-center rounded-full border border-border">
                            <img alt="" class="size-7" src="{{ asset('assets/media/app/apple-touch-icon.png') }}" />
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
                </div>
            </div>
        </div>
        <div class="kt-scrollable-y-auto grow" data-kt-scrollable="true" data-kt-scrollable-dependencies="#header"
            data-kt-scrollable-max-height="auto" data-kt-scrollable-offset="600px">
            <div class="flex flex-col gap-5 py-5">
                @foreach ($chats as $chat)
                    <div class="flex items-end {{ $chat->user_id == Auth::id() ? 'justify-end' : '' }} gap-3.5 px-5">
                        <img alt="" class="size-9 rounded-full" src="{{ $chat->user->avatar }}" />
                        <div class="flex flex-col gap-1.5">
                            <div
                                class="kt-card bg-accent/60 rounded-bs-none text-2sm flex flex-col gap-2.5 p-3 shadow-none">
                                {{ $chat->message }}
                            </div>
                            <span class="text-xs font-medium text-muted-foreground">
                                {{ $chat->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--Chat Footer-->
        <div class="mx-5">
            <form action="{{ route('chats.store') }}" method="POST" class="relative grow">
                @csrf
                <img alt="Avatar pengguna"
                    class="absolute start-0 top-2/4 ms-2.5 size-[30px] -translate-y-2/4 rounded-full"
                    src="{{ Auth::user()->avatar }}" />
                <input class="kt-input h-auto bg-transparent py-4 ps-12" placeholder="Tulis pesan..." type="text"
                    name="message" value="{{ old('message') }}" />
                <div class="absolute end-3 top-1/2 flex -translate-y-1/2 items-center gap-2.5">
                    <button class="kt-btn kt-btn-mono kt-btn-sm">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
        <!--End of Chat Footer-->
    </div>
    <!--End of Chat Drawer-->
    <!-- End of Chat -->
</div>
