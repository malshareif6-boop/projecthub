<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        if ($provider === 'github') {
            return Socialite::driver('github')
                ->scopes(['user:email'])
                ->stateless()
                ->redirect();
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {

            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Social login failed: ' . $e->getMessage()]);
        }

        $providerIdColumn = $provider . '_id';


        $email = $socialUser->getEmail() ?? ($socialUser->getNickname() ? $socialUser->getNickname() . '@github.local' : null);

        if (!$email) {
            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Unable to retrieve email from ' . ucfirst($provider) . '. Please make your email public in settings.',
                ]);
        }


        $user = User::where($providerIdColumn, $socialUser->getId())->first();

        //
        if (!$user) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    $providerIdColumn => $socialUser->getId(),
                    'avatar'          => $socialUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            }
        }

        //
        if (!$user) {
            $data = [
                'name'            => $socialUser->getName() ?: ($socialUser->getNickname() ?: 'User'),
                'email'           => $email,
                'email_verified_at' => now(),
                $providerIdColumn => $socialUser->getId(),
                'avatar'          => $socialUser->getAvatar(),
                'role'            => 'student',
                'is_active'       => true,
            ];

            if (in_array('username', (new User)->getFillable(), true)) {
                $base = Str::slug(
                    $socialUser->getNickname() ?: Str::before($email, '@')
                ) ?: 'user';
                $data['username'] = $base . '-' . Str::lower(Str::random(4));
            }

            $user = User::create($data);
        }

        if (!$user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        if (!$user->is_active) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been deactivated.']);
        }

        Auth::login($user, true);

        return match ($user->role) {
            'admin'      => redirect()->intended(route('admin.dashboard')),
            'supervisor' => redirect()->intended(route('supervisor.dashboard')),
            default      => redirect()->intended(route('dashboard')),
        };
    }

    private function validateProvider(string $provider): void
    {
        if (! in_array($provider, ['google', 'github'], true)) {
            abort(404);
        }
    }
}
