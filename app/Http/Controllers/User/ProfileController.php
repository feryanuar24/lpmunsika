<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('pages.profile.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('pages.profile.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::findOrFail(Auth::id());

            DB::beginTransaction();

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Memperbarui Akun',
                'message' => 'Pengguna ' . ($user->name ?? 'Anonim') . ' berhasil memperbaharui akun.',
            ]);

            DB::commit();

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error updating profile: ' . $th->getMessage());

            return back()
                ->onlyInput(['name', 'email'])
                ->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            User::destroy($user->id);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Menghapus Akun',
                'message' => 'Pengguna ' . ($user->name ?? 'Anonim') . ' berhasil menghapus akun.',
            ]);

            DB::commit();

            Auth::logout();

            return redirect()->route('landing')->with('success', 'Akun Anda telah dihapus.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error deleting profile: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus akun Anda.');
        }
    }
}
