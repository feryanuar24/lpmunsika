<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->addRole('visitor');

            DB::commit();

            return redirect(route('login', absolute: false))
                ->with('success', 'Akun berhasil dibuat. Silahkan masuk dan verifikasi email Anda.');
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Error during user registration: ' . $th->getMessage());

            return back()
                ->onlyInput(['name', 'email'])
                ->with('error', 'Terjadi kesalahan saat mendaftar');
        }
    }
}
