<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        $data = [
            'category' => $category,
        ];

        return view('pages.categories.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $data = [
            'category' => $category,
        ];

        return view('pages.categories.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Get paginated categories data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Category::whereNotIn('name', ['Produk', 'Karya Mahasiswa']);

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
        $categories = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'slug' => $category->slug,
                'actions' => [
                    'show' => route('categories.show', $category->id),
                    'edit' => route('categories.edit', $category->id),
                    'delete' => route('categories.destroy', $category->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $categories->currentPage(),
            'totalPages' => $categories->lastPage(),
            'pageSize' => $categories->perPage(),
            'totalCount' => $categories->total(),
        ];

        return response()->json($response);
    }
}
