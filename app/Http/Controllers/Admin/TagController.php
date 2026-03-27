<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        Tag::create($validated);

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): View
    {
        $data = [
            'tag' => $tag,
        ];

        return view('pages.tags.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag): View
    {
        $data = [
            'tag' => $tag,
        ];

        return view('pages.tags.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        $tag->update($validated);

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag berhasil dihapus.');
    }

    /**
     * Get paginated tags data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Tag::query();

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('slug', 'like', "%$search%");
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
        $tags = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $tags->map(function ($tag) {
            return [
                'name' => $tag->name,
                'slug' => $tag->slug,
                'actions' => [
                    'show' => route('tags.show', $tag->id),
                    'edit' => route('tags.edit', $tag->id),
                    'delete' => route('tags.destroy', $tag->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $tags->currentPage(),
            'totalPages' => $tags->lastPage(),
            'pageSize' => $tags->perPage(),
            'totalCount' => $tags->total(),
        ];

        return response()->json($response);
    }
}
