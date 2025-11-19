<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use App\Http\Requests\FooterRequest;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'footers' => Footer::all(),
        ];

        return view('pages.footers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.footers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterRequest $request)
    {
        Footer::create($request->validated());

        return redirect()
            ->route('footers.index')
            ->with('success', 'Footer berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Footer $footer)
    {
        $data = [
            'footer' => $footer,
        ];

        return view('pages.footers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $footer)
    {
        $data = [
            'footer' => $footer,
        ];

        return view('pages.footers.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FooterRequest $request, Footer $footer)
    {
        $footer->update($request->validated());

        return redirect()
            ->route('footers.index')
            ->with('success', 'Footer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Footer $footer)
    {
        $footer->delete();

        return redirect()
            ->route('footers.index')
            ->with('success', 'Footer berhasil dihapus.');
    }
}
