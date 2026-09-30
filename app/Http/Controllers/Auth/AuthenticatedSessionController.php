<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Fortify\Features;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */


    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = $request->user();

        if (
            \Laravel\Fortify\Features::enabled(\Laravel\Fortify\Features::twoFactorAuthentication())
            && $user->two_factor_secret
            && $user->two_factor_confirmed_at
        ) {
            // 1) احفظ id قبل أي logout
            $request->session()->put([
                'login.id'       => $user->id,
                'login.remember' => $request->boolean('remember'),
            ]);

            // 2) اخرج من الجلسة المصادَق عليها فقط
            Auth::logout();

            // 3) لا تستدعِ session()->invalidate() ولا regenerate هنا
            $request->session()->save();

            return redirect()->route('two-factor.login');
        }

        $request->session()->regenerate();

        return match ($user->role) {
            'admin'      => redirect()->intended(route('admin.dashboard')),
            'supervisor' => redirect()->intended(route('supervisor.dashboard')),
            default      => redirect()->intended(route('dashboard')),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
