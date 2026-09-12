<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                return redirect()
                    ->route('login')
                    ->with('error', 'Akun Gmail belum terdaftar di sistem. Silakan hubungi admin perpustakaan.');
            }

            if (!$user->is_active) {
                return redirect()
                    ->route('login')
                    ->with('error', 'Akun Anda sedang nonaktif. Silakan hubungi admin perpustakaan.');
            }

            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'last_login_at' => now(),
            ]);

            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        } catch (Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Login Google gagal. Silakan coba lagi. Pesan error: ' . $e->getMessage());
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}
