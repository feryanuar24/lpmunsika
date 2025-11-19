<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.register.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'avatar'   => $request->input('avatar', null),
            ]);

            $user->addRole('visitor');

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengguna Mendaftar',
                'message' => 'Pengguna ' . ($user->name ?? 'Anonim') . ' telah berhasil mendaftar.',
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silahkan masuk dan verifikasi email Anda.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during user registration: ' . $th->getMessage());

            return back()
                ->onlyInput(['name', 'email'])
                ->with('error', 'Terjadi kesalahan saat mendaftar');
        }
    }
}
