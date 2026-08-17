<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function execute(string $username, string $password, bool $remember, string $ip): bool
    {
        $throttleKey = Str::transliterate(Str::lower($username) . '|' . $ip);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'username' => [
                    'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $minutes . ' menit.'
                ],
            ]);
        }

        $credentials = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? ['email' => $username, 'password' => $password]
            : ['username' => $username, 'password' => $password];

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            return true;
        }

        RateLimiter::hit($throttleKey, 900);

        return false;
    }
}
