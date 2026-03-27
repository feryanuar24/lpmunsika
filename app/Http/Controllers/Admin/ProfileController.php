<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('pages.profile.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): View
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('pages.profile.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::find(Auth::id());

        if ($user->email !== $validated['email']) {
            $validated['email_verified_at'] = null;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        User::destroy(Auth::id());

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Akun Anda telah dihapus.');
    }
}
