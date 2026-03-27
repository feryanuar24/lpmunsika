<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $data = [
            'role' => $role,
        ];

        return view('pages.roles.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $data = [
            'role' => $role,
        ];

        return view('pages.roles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $validated = $request->validated();

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }

    /**
     * Get paginated roles data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Role::query();

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
        $roles = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $roles->map(function ($role) {
            return [
                'name' => $role->name,
                'display_name' => $role->display_name,
                'actions' => [
                    'show' => route('roles.show', $role->id),
                    'edit' => route('roles.edit', $role->id),
                    'delete' => route('roles.destroy', $role->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $roles->currentPage(),
            'totalPages' => $roles->lastPage(),
            'pageSize' => $roles->perPage(),
            'totalCount' => $roles->total(),
        ];

        return response()->json($response);
    }
}
