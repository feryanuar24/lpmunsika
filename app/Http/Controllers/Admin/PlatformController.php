<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlatformRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.platforms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlatformRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Platform::create($validated);

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform): View
    {
        $data = [
            'platform' => $platform,
        ];

        return view('pages.platforms.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform): View
    {
        $data = [
            'platform' => $platform,
        ];

        return view('pages.platforms.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePlatformRequest $request, Platform $platform): RedirectResponse
    {
        $validated = $request->validated();

        $platform->update($validated);

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform): RedirectResponse
    {
        $platform->delete();

        return redirect()
            ->route('platforms.index')
            ->with('success', 'Platform berhasil dihapus.');
    }

    /**
     * Get paginated platforms data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Platform::query();

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('url', 'like', "%$search%")
                    ->orWhere('icon', 'like', "%$search%");
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
        $platforms = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $platforms->map(function ($platform) {
            return [
                'name' => $platform->name,
                'url' => $platform->url,
                'icon' => $platform->icon,
                'actions' => [
                    'show' => route('platforms.show', $platform->id),
                    'edit' => route('platforms.edit', $platform->id),
                    'delete' => route('platforms.destroy', $platform->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $platforms->currentPage(),
            'totalPages' => $platforms->lastPage(),
            'pageSize' => $platforms->perPage(),
            'totalCount' => $platforms->total(),
        ];

        return response()->json($response);
    }
}
