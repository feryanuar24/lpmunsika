<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRoleRequest;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.permission-role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::all();
        $roles = Role::all();

        $data = [
            'permissions' => $permissions,
            'roles' => $roles,
        ];

        return view('pages.permission-role.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $permission = Permission::find($validated['permission_id']);
        $role = Role::find($validated['role_id']);
        $role->givePermission($permission);

        return redirect()->route('permission-role.index')->with('success', 'Permission berhasil ditambahkan ke role.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission, Role $role): RedirectResponse
    {
        $role->removePermission($permission);

        return redirect()->route('permission-role.index')->with('success', 'Permission berhasil dihapus dari role.');
    }

    /**
     * Get paginated permission_role data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = PermissionRole::query()->with(['permission', 'role']);

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('permission', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%")
                        ->orWhere('display_name', 'like', "%$search%");
                })->orWhereHas('role', function ($q3) use ($search) {
                    $q3->where('name', 'like', "%$search%")
                        ->orWhere('display_name', 'like', "%$search%");
                });
            });
        }

        // Handle sorting
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder');
        if (!empty($sortOrder) && !empty($sortField)) {
            if ($sortField === 'permission_name') {
                $query->leftJoin('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                    ->orderBy('permissions.name', $sortOrder);
            } elseif ($sortField === 'role_name') {
                $query->leftJoin('roles', 'permission_role.role_id', '=', 'roles.id')
                    ->orderBy('roles.name', $sortOrder);
            }
        } else {
            $query->leftJoin('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                ->orderBy('permissions.name', 'asc');
        }

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);
        $permission_role = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $permission_role->map(function ($value) {
            return [
                'permission_name' => $value->permission->name,
                'role_name' => $value->role->name,
                'actions' => [
                    'delete' => route('permission-role.destroy', ['permission' => $value->permission_id, 'role' => $value->role_id]),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $permission_role->currentPage(),
            'totalPages' => $permission_role->lastPage(),
            'pageSize' => $permission_role->perPage(),
            'totalCount' => $permission_role->total(),
        ];

        return response()->json($response);
    }
}
