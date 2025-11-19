<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Embed;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Requests\EmbedRequest;

class EmbedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'embeds' => Embed::all(),
        ];

        return view('pages.embeds.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'platforms' => Platform::all(),
        ];

        return view('pages.embeds.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmbedRequest $request)
    {
        Embed::create($request->validated());

        return redirect()->route('embeds.index')->with('success', 'Embed berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Embed $embed)
    {
        $data = [
            'embed' => $embed->load('platform'),
        ];

        return view('pages.embeds.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Embed $embed)
    {
        $data = [
            'platforms' => Platform::all(),
            'embed' => $embed,
        ];

        return view('pages.embeds.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmbedRequest $request, Embed $embed)
    {
        $embed->update($request->validated());

        return redirect()->route('embeds.index')->with('success', 'Embed berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Embed $embed)
    {
        $embed->delete();

        return redirect()->route('embeds.index')->with('success', 'Embed berhasil dihapus.');
    }
}
