<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSliderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('banner')) {
            $path = Storage::put('sliders', $request->file('banner'));
            $validated['banner'] = $path;
        }

        Slider::create($validated);

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider): View
    {
        $data = [
            'slider' => $slider,
        ];

        return view('pages.sliders.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider): View
    {
        $data = [
            'slider' => $slider,
        ];

        return view('pages.sliders.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSliderRequest $request, Slider $slider): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('banner')) {
            if (Storage::exists($slider->banner)) {
                Storage::delete($slider->banner);
            }

            $path = Storage::put('sliders', $request->file('banner'));

            $validated['banner'] = $path;
        }

        $slider->update($validated);

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        $slider->delete();

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }

    /**
     * Get paginated sliders data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Slider::query();

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        // Handle sorting
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder');
        if (!empty($sortOrder) && !empty($sortField)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);
        $sliders = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $sliders->map(function ($slider) {
            return [
                'name' => $slider->name,
                'actions' => [
                    'show' => route('sliders.show', $slider->id),
                    'edit' => route('sliders.edit', $slider->id),
                    'delete' => route('sliders.destroy', $slider->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $sliders->currentPage(),
            'totalPages' => $sliders->lastPage(),
            'pageSize' => $sliders->perPage(),
            'totalCount' => $sliders->total(),
        ];

        return response()->json($response);
    }
}
