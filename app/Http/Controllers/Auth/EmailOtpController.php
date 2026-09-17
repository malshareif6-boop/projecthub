<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailOtpController extends Controller
{
    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if (
            !$user->email_otp ||
            $user->email_otp !== $request->otp ||
            !$user->email_otp_expires_at ||
            now()->gt($user->email_otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired code.']);
        }

        $user->forceFill([
            'email_verified_at'    => now(),
            'email_otp'            => null,
            'email_otp_expires_at' => null,
        ])->save();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Email verified successfully.');
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'email_otp'            => $otp,
            'email_otp_expires_at' => now()->addMinutes(15),
        ])->save();

        Mail::to($user)->queue(new EmailOtpMail($user, $otp));

        return back()->with('success', 'A new code has been sent.');
    }
}
