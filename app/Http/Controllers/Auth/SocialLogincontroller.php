<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLogincontroller extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, $provider)
    {
        try {
            // Keep stateful verification to protect against OAuth CSRF attacks
            $provider_user = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            // Handle invalid state (CSRF attempt, expired session, or refreshed callback URL)
            return redirect()->route('login')->withErrors([
                'email' => __('Authentication failed or the session expired. Please try again.'),
            ]);
        } catch (Exception $e) {
            // Handle any other OAuth provider error
            return redirect()->route('login')->withErrors([
                'email' => __('Unable to login with :provider. Please try again.', ['provider' => ucfirst($provider)]),
            ]);
        }

        // 1. Check if user already linked with this provider
        $user = User::where([
            'provider' => $provider,
            'provider_id' => $provider_user->getId(),
        ])->first();

        if (!$user) {
            // 2. Check if a user with the same email already exists
            $user = User::where('email', $provider_user->getEmail())->first();

            if ($user) {
                // Link this provider to the existing account
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $provider_user->getId(),
                    'provider_token' => $provider_user->token,
                ]);
            } else {
                // 3. Create a new user with a secure random password
                $user = User::create([
                    'name' => $provider_user->getName() ?? $provider_user->getNickname() ?? 'User',
                    'email' => $provider_user->getEmail(),
                    'password' => Hash::make(Str::random(32)),
                    'provider' => $provider,
                    'provider_id' => $provider_user->getId(),
                    'provider_token' => $provider_user->token,
                    'email_verified_at' => now(),
                ]);
            }
        } else {
            // Refresh provider token
            $user->update([
                'provider_token' => $provider_user->token,
            ]);
        }

        Auth::login($user, remember: true);

        // Security: Regenerate session ID to prevent Session Fixation attacks
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}