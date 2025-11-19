<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'users' => User::with('roles')->get(),
        ];

        return view('pages.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'roles' => Role::all(),
        ];

        return view('pages.users.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'email_verified_at' => now(),
                'password' => bcrypt($request->input('password')),
            ]);

            $user->addRoles($request->input('roles'));

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Pengguna Ditambahkan',
                'message' => 'Pengguna ' . ($user->name ?? 'Anonim') . ' berhasil ditambahkan.',
            ]);

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
    public function show(User $user)
    {
        $data = [
            'user' => $user
        ];

        return view('pages.users.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
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
    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            DB::beginTransaction();

            $user->name  = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->syncRoles($validated['roles']);

            $user->save();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Pengguna Diperbaharui',
                'message' => 'Pengguna ' . ($user->name ?? 'Anonim') . ' berhasil diperbaharui.',
            ]);

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
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            $user->delete();

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Dihapus',
                'message' => 'Pengguna ' . ($user->name ?? 'Anonim') . ' berhasil dihapus.',
            ]);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during user deletion: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus user');
        }
    }
}
