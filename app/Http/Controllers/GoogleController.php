<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(['usr_email' => $googleUser->getEmail()],
    [
        'usr_name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'password' => bcrypt('google_' . $googleUser->getId()),
        'usr_nik' => null,
    ]);

            Auth::login($user);

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google');
        }
    }
}
