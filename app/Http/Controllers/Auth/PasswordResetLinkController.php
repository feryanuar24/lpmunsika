<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{

    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Handle the incoming password reset link request.
     */
    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan dalam sistem kami.',
            ]);
        }

        $token = Password::createToken($user);
        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(config('auth.passwords.users.expire')),
            [
                'token' => $token,
                'email' => $user->email,
            ]
        );

        $user->notify(new CustomResetPasswordNotification($url));

        return back()->with('success', 'Tautan reset password telah dikirim ke email Anda.');
    }
}
