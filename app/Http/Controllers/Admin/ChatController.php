<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Http\Requests\ChatRequest;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatRequest $request)
    {
        Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->input('message'),
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil terkirim.');
    }
}
