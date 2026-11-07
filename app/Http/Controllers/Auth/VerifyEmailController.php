<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            return redirect()->route('login')
                ->with('error', 'Tautan verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            if (Auth::check() && Auth::id() !== $user->id) {
                return redirect()->route('dashboard')
                    ->with('success', "Email untuk {$user->email} sudah terverifikasi.");
            }

            if (! Auth::check()) {
                Auth::login($user);
            }

            return redirect()->intended(route('dashboard', absolute: false))
                ->with('success', 'Email Anda sudah terverifikasi sebelumnya.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if (Auth::check() && Auth::id() !== $user->id) {
            return redirect()->route('dashboard')
                ->with('success', "Email untuk {$user->email} berhasil diverifikasi.");
        }

        if (! Auth::check()) {
            Auth::login($user);
        }

        return redirect()->intended(route('dashboard', absolute: false))
            ->with('success', 'Email Anda telah terverifikasi.');
    }
}

