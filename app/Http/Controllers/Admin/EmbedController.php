<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Embed;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmbedRequest;
use App\Http\Requests\UpdateEmbedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmbedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.embeds.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'platforms' => Platform::whereIn('name', ['YouTube', 'Spotify'])->get(),
        ];

        return view('pages.embeds.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmbedRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Embed::create($validated);

        return redirect()->route('embeds.index')->with('success', 'Embed berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Embed $embed): View
    {
        $data = [
            'embed' => $embed,
        ];

        return view('pages.embeds.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Embed $embed): View
    {
        $data = [
            'platforms' => Platform::whereIn('name', ['YouTube', 'Spotify'])->get(),
            'embed' => $embed,
        ];

        return view('pages.embeds.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmbedRequest $request, Embed $embed): RedirectResponse
    {
        $validated = $request->validated();

        $embed->update($validated);

        return redirect()->route('embeds.index')->with('success', 'Embed berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Embed $embed): RedirectResponse
    {
        $embed->delete();

        return redirect()->route('embeds.index')->with('success', 'Embed berhasil dihapus.');
    }

    /**
     * Get paginated embeds data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Embed::query()->with('platform');

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('platform', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        // Handle sorting
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder');
        if (!empty($sortOrder) && !empty($sortField)) {
            if ($sortField === 'platform_name') {
                $query->join('platforms', 'embeds.platform_id', '=', 'platforms.id')
                    ->orderBy('platforms.name', $sortOrder)
                    ->select('embeds.*');
            } else {
                $query->orderBy($sortField, $sortOrder);
            }
        } else {
            $query->orderBy('title', 'asc');
        }

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);
        $embeds = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $embeds->map(function ($embed) {
            return [
                'title' => $embed->title,
                'platform_name' => $embed->platform->name,
                'actions' => [
                    'show' => route('embeds.show', $embed->id),
                    'edit' => route('embeds.edit', $embed->id),
                    'delete' => route('embeds.destroy', $embed->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $embeds->currentPage(),
            'totalPages' => $embeds->lastPage(),
            'pageSize' => $embeds->perPage(),
            'totalCount' => $embeds->total(),
        ];

        return response()->json($response);
    }
}
