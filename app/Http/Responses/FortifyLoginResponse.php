<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class FortifyLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // dd($request->user()?->role);
        $user = $request->user();

        $url = match ($user->role ?? null) {
            'admin'      => route('admin.dashboard'),
            'supervisor' => route('supervisor.dashboard'),
            default      => route('dashboard'),
        };

        // return redirect()->intended($url);
        return redirect()->to($url);
    }
}
