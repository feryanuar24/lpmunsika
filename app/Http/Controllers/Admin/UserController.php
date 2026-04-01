<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'roles' => Role::all(),
        ];

        return view('pages.users.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'email_verified_at' => now(),
                'password' => bcrypt($validated['password']),
            ]);

            $user->addRoles($validated['roles']);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Error during user creation: ' . $th->getMessage());

            return back()
                ->onlyInput(['name', 'email', 'roles'])
                ->with('error', 'Terjadi kesalahan saat menambahkan user');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $data = [
            'user' => $user
        ];

        return view('pages.users.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $data = [
            'user' => $user,
            'roles' => Role::all(),
        ];

        return view('pages.users.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user->name  = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->syncRoles($validated['roles']);

            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Error during user update: ' . $th->getMessage());

            return back()
                ->onlyInput(['name', 'email', 'roles'])
                ->with('error', 'Terjadi kesalahan saat memperbarui user');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus diri sendiri.');
        }

        try {
            DB::beginTransaction();

            if (config('session.driver') === 'database') {
                DB::table('sessions')->where('user_id', $user->id)->delete();
            }

            $user->delete();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Error during user deletion: ' . $th->getMessage());

            return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat menghapus user');
        }
    }

    /**
     * Get paginated users data for datatable.
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = User::query()->with('roles');

        // Handle search
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('created_at', 'like', "%$search%")
                    ->orWhere('updated_at', 'like', "%$search%")
                    ->orWhereHas('roles', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });

            if (strtolower($search) === 'terverifikasi') {
                $query->orWhere('email_verified_at', '!=', null);
            } elseif (strtolower($search) === 'belum terverifikasi') {
                $query->orWhere('email_verified_at', null);
            }
        }

        // Handle sorting
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder');
        if (!empty($sortOrder) && !empty($sortField)) {
            if ($sortField === 'email_verified_at') {
                $query->orderByRaw("CASE WHEN email_verified_at IS NULL THEN 0 ELSE 1 END $sortOrder")
                    ->orderBy('email_verified_at', $sortOrder);
            } elseif ($sortField === 'role_names') {
                $query->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                    ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                    ->groupBy('users.id')
                    ->orderByRaw('MIN(roles.name) ' . $sortOrder)
                    ->select('users.*');
            } else {
                $query->orderBy($sortField, $sortOrder);
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        // Get pagination parameters
        $page = $request->input('page', 1);
        $size = $request->input('size', 5);
        $users = $query->paginate($size, ['*'], 'page', $page);

        // Format data for KTUI datatable
        $data = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'role_names' => $user->roles->pluck('name')->toArray(),
                'email_verified_at' => $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi',
                'created_at' => $user->created_at->translatedFormat('d M Y H:i'),
                'updated_at' => $user->updated_at->translatedFormat('d M Y H:i'),
                'actions' => [
                    'show' => route('users.show', $user->id),
                    'edit' => route('users.edit', $user->id),
                    'delete' => route('users.destroy', $user->id),
                ],
            ];
        });

        $response = [
            'data' => $data,
            'page' => $users->currentPage(),
            'totalPages' => $users->lastPage(),
            'pageSize' => $users->perPage(),
            'totalCount' => $users->total(),
        ];

        return response()->json($response);
    }

    /**
     * Save FCM token for the authenticated user.
     */
    public function saveFcmToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'fcm_token' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return response()->json(
                ['message' => 'User belum terautentikasi'],
                401
            );
        }

        $user->fcm_token = $validated['fcm_token'];
        $user->save();

        return response()->json(
            ['message' => 'FCM token berhasil disimpan']
        );
    }

    /**
     * Mark a notification as read for the authenticated user.
     */
    public function readNotification(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notification_id' => ['required', 'string', 'exists:notifications,id'],
        ]);

        $notification = $request->user()?->notifications()
            ->whereKey($validated['notification_id'])
            ->first();

        if (!$notification) {
            return redirect()->back()->with('error', 'Notifikasi tidak ditemukan');
        }

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sebagai dibaca');
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function readAllNotifications(Request $request): RedirectResponse
    {
        $request->user()?->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca');
    }
}
