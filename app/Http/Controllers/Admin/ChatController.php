<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        Chat::create($validated);

        return redirect()->back()->with('success', 'Pesan berhasil terkirim.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat): RedirectResponse
    {
        $chat->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
}
