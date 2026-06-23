<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        $socialUser = Socialite::driver('google')->user();

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->google_id = $user->google_id ?: $socialUser->getId();
            $user->name = $user->name ?: $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getEmail();
            $user->email_verified_at = $user->email_verified_at ?: now();
            $user->save();
        } else {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getEmail(),
                'email' => $socialUser->getEmail(),
                'google_id' => $socialUser->getId(),
                'email_verified_at' => now(),
                'password' => Hash::make(uniqid('google-', true)),
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended(route('home', absolute: false));
    }
}
