<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()
            ->intended(route('dashboard', absolute: false))
            ->with('success', 'Email Anda telah terverifikasi.');
    }
}
