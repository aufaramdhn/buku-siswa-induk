<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function authenticate(LoginRequest $request, LoginAction $loginAction): RedirectResponse
    {
        $remember = $request->has('remember');

        $success = $loginAction->execute(
            $request->input('username'),
            $request->input('password'),
            $remember,
            $request->ip()
        );

        if ($success) {
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'username' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
