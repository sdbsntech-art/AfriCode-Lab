<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (! $this->googleIsConfigured()) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Le service Google Client ID / Secret n’est pas configuré dans le fichier .env.']);
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            Log::error('Google Auth Redirect error: '.$e->getMessage());

            return redirect()->route('login')
                ->withErrors(['google' => 'Impossible de contacter Google OAuth : '.$e->getMessage()]);
        }
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->query('error')) {
            return redirect()->route('login')
                ->withErrors(['google' => 'La connexion via Google a été annulée par l’utilisateur.']);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::error('Google Auth Callback exception: '.$e->getMessage());

            return redirect()->route('login')
                ->withErrors(['google' => 'Erreur Google OAuth : Identifiants Google invalides ou expirés dans le fichier .env.']);
        }

        if (! $googleUser instanceof GoogleUser || ! filter_var($googleUser->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Google n’a pas transmis une adresse e-mail valide.']);
        }

        $rawUser = $googleUser->user ?? [];
        if (! filter_var($rawUser['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            return redirect()->route('login')
                ->withErrors(['google' => 'L’adresse e-mail Google n’a pas été vérifiée par Google.']);
        }

        $googleId = $googleUser->getId();
        $email = Str::lower(trim($googleUser->getEmail()));

        $user = User::where('google_id', $googleId)->orWhere('email', $email)->first();

        if ($user && $user->google_id && $user->google_id !== $googleId) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Cette adresse e-mail est déjà associée à un autre identifiant Google.']);
        }

        if ($user && ! $user->is_active) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Ce compte a été désactivé par l’administration AfriCode Lab.']);
        }

        if ($user && $user->google_id === $googleId && ! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        } elseif ($user && ! $user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Vérifiez d’abord votre adresse e-mail avec le lien envoyé lors de votre inscription, puis réessayez.']);
        }

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: Str::before($email, '@'),
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)),
                'google_id' => $googleId,
                'avatar' => $googleUser->getAvatar(),
                'role' => 'student',
                'is_active' => true,
            ]);
        } else {
            if (! $user->google_id) {
                $user->google_id = $googleId;
            }
            if (! $user->avatar && $googleUser->getAvatar()) {
                $user->avatar = $googleUser->getAvatar();
            }
            $user->save();
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Bienvenue dans votre Espace Administrateur AfriCode Lab.');
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Connexion Google réussie ! Bienvenue sur AfriCode Lab.');
    }

    private function googleIsConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }
}
