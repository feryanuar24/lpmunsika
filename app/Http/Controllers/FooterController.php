<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFooterRequest;
use App\Http\Requests\UpdateFooterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.footers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.footers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFooterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Footer::create($validated);

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
    public function update(UpdateFooterRequest $request, Footer $footer)
    {
        $validated = $request->validated();

        $footer->update($validated);

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

    /**
     * Get paginated footers data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Footer::query();

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('url', 'like', "%$search%");
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
        $footers = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $footers->map(function ($footer) {
            return [
                'name' => $footer->name,
                'url' => $footer->url,
                'actions' => [
                    'show' => route('footers.show', $footer->id),
                    'edit' => route('footers.edit', $footer->id),
                    'delete' => route('footers.destroy', $footer->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $footers->currentPage(),
            'totalPages' => $footers->lastPage(),
            'pageSize' => $footers->perPage(),
            'totalCount' => $footers->total(),
        ];

        return response()->json($response);
    }
}
