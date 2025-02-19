<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    // Redirect ke Google untuk login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada di database
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Jika user belum ada, buat akun baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('password_default'), // Password default (bisa diganti)
                ]);
            }

            // Login user
            Auth::login($user);

            return redirect()->route('dashboard'); // Redirect ke dashboard setelah login
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google!');
        }
    }
}
