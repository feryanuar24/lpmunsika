<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePasswordResetRequest;
use App\Http\Requests\UpdatePasswordResetRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    /**
     * Show form to request password reset link.
     */
    public function create()
    {
        return view('pages.forgot-password.index');
    }

    /**
     * Send reset link to email.
     */
    public function store(StorePasswordResetRequest $request)
    {
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status !== Password::RESET_LINK_SENT) {
                return back()->with('error', 'Gagal mengirim tautan reset kata sandi. Periksa alamat email dan coba lagi.');
            }

            return back()->with('success', 'Tautan untuk mereset kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk dan folder spam.');
        } catch (Throwable $th) {
            Log::error('Error during password reset link request: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat mengirim email reset kata sandi.')
                ->onlyInput('email');
        }
    }

    /**
     * Show form to reset password.
     */
    public function edit(string $token, Request $request)
    {
        $data = [
            'token' => $token,
            'email' => $request->query('email')
        ];

        return view('pages.forgot-password.edit', compact('data'));
    }

    /**
     * Handle reset password request.
     */
    public function update(UpdatePasswordResetRequest $request)
    {
        try {
            $updatedUserId = null;
            $updatedUserName = null;

            DB::beginTransaction();

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) use (&$updatedUserId, &$updatedUserName) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();
                    $updatedUserId = $user->id;
                    $updatedUserName = $user->name;
                }
            );

            if ($status !== Password::PASSWORD_RESET) {
                DB::rollBack();

                return back()->with('error', 'Gagal mereset kata sandi. Token tidak valid atau data tidak cocok.');
            }

            Notification::create([
                'user_id' => $updatedUserId,
                'title' => 'Pengguna Memperbaharui Kata Sandi',
                'message' => 'Pengguna ' . ($updatedUserName ?? 'Anonim') . ' berhasil memperbaharui kata sandinya.',
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Kata sandi berhasil direset. Silakan login dengan kata sandi baru Anda.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error('Error during password reset: ' . $th->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat memproses permintaan reset kata sandi.')
                ->onlyInput(['email', 'token']);
        }
    }
}
