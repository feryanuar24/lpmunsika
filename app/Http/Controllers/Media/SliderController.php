<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SliderRequest;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'sliders' => Slider::all(),
        ];

        return view('pages.sliders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $data = $request->validated();
        unset($data['banner']);

        if ($request->hasFile('banner')) {
            $path = Storage::put('sliders', $request->file('banner'));
            $data['banner'] = $path;
        }

        Slider::create($data);

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        $data = [
            'slider' => $slider,
        ];

        return view('pages.sliders.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $data = [
            'slider' => $slider,
        ];

        return view('pages.sliders.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $data = $request->validated();
        unset($data['banner']);

        if ($request->hasFile('banner')) {
            $data['banner'] = Storage::put('sliders', $request->file('banner'));
        }

        $slider->update($data);

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
