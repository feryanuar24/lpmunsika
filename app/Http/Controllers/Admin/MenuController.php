<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.menus.index');
    }

    /**
     * Get paginated menus data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Menu::query()->with('parent');

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('url', 'like', "%$search%")
                    ->orWhereHas('parent', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        // Handle sorting
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder');
        if (!empty($sortOrder) && !empty($sortField)) {
            if ($sortField === 'parent_name') {
                $query->leftJoin('menus as parent', 'menus.parent_id', '=', 'parent.id')
                    ->orderBy('parent.name', $sortOrder)
                    ->select('menus.*');
            } else {
                $query->orderBy($sortField, $sortOrder);
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);
        $menus = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $menus->map(function ($menu) {
            return [
                'name' => $menu->name,
                'url' => $menu->url,
                'icon' => $menu->icon,
                'parent_name' => $menu->parent ? $menu->parent->name : null,
                'actions' => [
                    'redirect' => $menu->url
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $menus->currentPage(),
            'totalPages' => $menus->lastPage(),
            'pageSize' => $menus->perPage(),
            'totalCount' => $menus->total(),
        ];

        return response()->json($response);
    }
}
