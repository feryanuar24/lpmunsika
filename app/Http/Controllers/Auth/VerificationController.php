<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVerificationRequest;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class VerificationController extends Controller
{
    /**
     * Show the verification notice.
     */
    public function create()
    {
        return view('pages.verify-email.index');
    }

    /**
     * Send the verification email.
     */
    public function store(StoreVerificationRequest $request)
    {
        try {
            if (!$request->user()) {
                return redirect()->route('login');
            }
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->route('dashboard');
            }

            $request->user()->sendEmailVerificationNotification();

            return back()->with('success', 'Link verifikasi telah dikirim ke email Anda.');
        } catch (Throwable $th) {
            Log::error('Error sending verification email: ' . $th->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat mengirim email verifikasi.');
        }
    }

    /**
     * Handle the verification callback.
     */
    public function update(EmailVerificationRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->fulfill();

            Notification::create([
                'user_id' => $request->user()->id,
                'title' => 'Pengguna Memverifikasi Email',
                'message' => 'Pengguna ' . ($request->user()->name ?? 'Anonim') . ' berhasil memverifikasi emailnya.',
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Verifikasi email berhasil!');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during email verification: ' . $th->getMessage());

            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat memverifikasi email.');
        }
    }
}
