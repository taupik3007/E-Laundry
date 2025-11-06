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

            $user = User::updateOrCreate(['email' => $googleUser->getEmail()],
    [
        'usr_name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'password' => bcrypt('google_' . $googleUser->getId()),
        'usr_nik' => null,
    ]);
        if ($user->wasRecentlyCreated) {
            $user->assignRole('customer'); // ganti sesuai role default yang kamu mau
        }

            Auth::login($user);
        // dd($user);

             if ($user->hasRole('owner')) {
                return redirect()->intended(route('owner.dashboard', absolute: false));
             }elseif ($user->hasRole('employee')) {
            return redirect()->intended(route('emloyee.dashboard', absolute: false));
             }elseif ($user->hasRole('customer')) {
        // dd($user);

            return redirect()->intended(route('customer.dashboard', absolute: false));
             }
        } catch (\Exception $e) {
        // dd($user);

            return redirect('/login')->with('error', 'Gagal login dengan Google');
        }
    }
}
