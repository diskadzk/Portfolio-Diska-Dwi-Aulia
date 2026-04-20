<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->email;
        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['msg' => 'Email sudah terdaftar!']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => $request->password,
            'role' => 'pembeli',
        ]);

        Auth::login($user);
        return redirect('/')->with('success', 'User berhasil dibuat!');
    }

    public function registerMitra(Request $request)
    {
        $email = $request->email;
        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['msg' => 'Email Mitra sudah terdaftar!']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->location,
            'role' => 'mitra',
        ]);

        Auth::login($user);
        return redirect('/dashboard-mitra')->with('success', 'Pendaftaran Mitra Tani berhasil!');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'mitra') {
                return redirect('/dashboard-mitra');
            }
            return redirect('/');
        }

        return back()->withErrors(['msg' => 'Email atau Password salah!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('logged_out', true);
    }

    // ===== SOCIAL LOGIN (Google & Facebook) =====

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/')->withErrors(['msg' => 'Gagal login dengan ' . ucfirst($provider) . '. Silakan coba lagi.']);
        }

        $user = User::where('provider', $provider)
                     ->where('provider_id', $socialUser->getId())
                     ->first();

        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'role' => 'pembeli',
                ]);
            }
        }

        Auth::login($user, true);
        return redirect('/')->with('success', 'Berhasil masuk dengan ' . ucfirst($provider) . '!');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}