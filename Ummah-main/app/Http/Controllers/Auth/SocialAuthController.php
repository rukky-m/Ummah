<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', '=', $googleUser->id)
                        ->orWhere('email', '=', $googleUser->email)
                        ->first();

        if ($user && $user->member) {
            Auth::login($user);
            return redirect()->intended('/dashboard');
        }

        if (!$user) {
            // Create a new user but don't log them in yet or log them in and redirect to complete profile
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'password' => bcrypt(Str::random(24)),
                'role' => 'member', 
            ]);
            $user->sendEmailVerificationNotification();
        }

        Auth::login($user);

        // If user has no member profile, redirect to complete profile
        if (!$user->member) {
            return redirect()->route('complete-profile.step1');
        }

        return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google authentication failed. Please try again.');
        }
    }
}
