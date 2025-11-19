<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Requests\PlatformRequest;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'platforms' => Platform::all(),
        ];

        return view('pages.platforms.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlatformRequest $request)
    {
        Platform::create($request->validated());

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        $data = [
            'platform' => $platform,
        ];

        return view('pages.platforms.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        $data = [
            'platform' => $platform,
        ];

        return view('pages.platforms.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlatformRequest $request, Platform $platform)
    {
        $platform->update($request->validated());

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil dihapus.');
    }
}
