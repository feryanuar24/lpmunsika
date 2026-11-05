<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(VerifyEmailRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->intended(route('dashboard', absolute: false))
                ->with('success', 'Alamat email Anda sudah terverifikasi.');
        }

        $user->sendEmailVerificationNotification();

        return back()
            ->with('success', 'Tautan verifikasi baru telah dikirim ke alamat email Anda.');
    }
}
