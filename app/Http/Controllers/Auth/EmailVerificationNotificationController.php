<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Notifications\CustomVerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
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

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $user->notify(new CustomVerifyEmailNotification($url));

        return back()
            ->with('success', 'Tautan verifikasi baru telah dikirim ke alamat email Anda.');
    }
}
