<div class="kt-modal" data-kt-modal="true" id="search_modal">
    <div class="kt-modal-content w-[90%] top-[15%]">
        <form action="{{ route('menus.index') }}" method="get">
            <div class="kt-modal-header py-4 px-5">
                <i class="ki-filled ki-magnifier text-muted-foreground text-xl">
                </i>
                <input class="kt-input kt-input-ghost" name="search" placeholder="Klik untuk memulai pencarian..." type="text" value="" />
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                    <i class="ki-filled ki-cross">
                    </i>
                </button>
                <button type="submit" class="hidden"></button>
            </div>
        </form>
    </div>
</div>
