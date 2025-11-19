<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Throwable;

class LoginController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.login.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();
            $maxAttempts = 5;
            $decaySeconds = 900;

            // Check for too many login attempts
            if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                $minutes = ceil($seconds / 60);
                return back()
                    ->with('error', "Terlalu banyak percobaan login. Silakan tunggu sekitar {$minutes} menit dan coba lagi.")
                    ->onlyInput('email');
            }

            // Attempt to authenticate the user
            if (!Auth::attempt($credentials, $request->boolean('remember_me'))) {
                RateLimiter::hit($throttleKey, $decaySeconds);
                $remaining = $maxAttempts - RateLimiter::attempts($throttleKey);
                return back()
                    ->with('error', "Login Gagal! Silakan periksa kembali email dan password Anda. Anda memiliki {$remaining} percobaan tersisa.")
                    ->onlyInput('email');
            }
            $request->session()->regenerate();

            // Clear login attempts
            RateLimiter::clear($throttleKey);

            $user = Auth::user();

            // Check email verification
            if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();

                return redirect()->route('verification.notice')->with('success', 'Silakan verifikasi email Anda terlebih dahulu. Kami telah mengirimkan link verifikasi ke email Anda.');
            }

            return redirect()->intended(route('dashboard'))->with('success', 'Login Berhasil!');
        } catch (Throwable $th) {
            Log::error('Error during user login: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat proses login.')
                ->onlyInput('email');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('landing')->with('success', 'Logout Berhasil!');
        } catch (Throwable $th) {
            Log::error('Error during user logout: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat proses logout.');
        }
    }
}
