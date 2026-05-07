<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Permission::create($validated);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): View
    {
        $data = [
            'permission' => $permission
        ];

        return view('pages.permissions.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): View
    {
        $data = [
            'permission' => $permission
        ];

        return view('pages.permissions.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validated();

        $permission->update($validated);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dihapus.');
    }

    /**
     * Get paginated permissions data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Permission::query();

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('display_name', 'like', "%$search%");
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
        $permissions = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $permissions->map(function ($permission) {
            return [
                'name' => $permission->name,
                'display_name' => $permission->display_name,
                'actions' => [
                    'show' => route('permissions.show', $permission->id),
                    'edit' => route('permissions.edit', $permission->id),
                    'delete' => route('permissions.destroy', $permission->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $permissions->currentPage(),
            'totalPages' => $permissions->lastPage(),
            'pageSize' => $permissions->perPage(),
            'totalCount' => $permissions->total(),
        ];

        return response()->json($response);
    }
}
