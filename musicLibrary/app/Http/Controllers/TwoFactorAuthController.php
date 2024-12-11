<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class TwoFactorAuthController extends Controller
{
    public function show2faForm()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        
        if (!$user->two_factor_secret) {
            $secretKey = $google2fa->generateSecretKey();
            $user->two_factor_secret = $secretKey;
            $user->save();
        }

        $qrCodeUrl = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->two_factor_secret
        );

        return view('auth.2fa-setup', compact('qrCodeUrl'));
    }

    public function enable2fa(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric'
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey(
            $user->two_factor_secret,
            $request->one_time_password
        );

        if ($valid) {
            // Generate recovery codes
            $recoveryCodes = collect(range(1, 8))->map(function () {
                return Str::random(10);
            })->toJson();

            $user->two_factor_confirmed_at = now();
            $user->two_factor_recovery_codes = $recoveryCodes;
            $user->save();

            return redirect()->route('2fa.show-recovery-codes');
        }

        return back()->withErrors(['one_time_password' => 'Invalid verification code']);
    }

    public function disable2fa(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->two_factor_confirmed_at = null;
        $user->two_factor_recovery_codes = null;
        $user->save();

        return redirect()->route('profile.edit')->with('success', '2FA has been disabled');
    }

    public function showVerifyForm()
    {
        return view('auth.2fa-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $userId = $request->session()->get('2fa.user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('signin');
        }

        // Check if it's a recovery code
        $recoveryCodes = json_decode($user->two_factor_recovery_codes, true);
        if (in_array($request->code, $recoveryCodes)) {
            // Remove used recovery code
            $recoveryCodes = array_diff($recoveryCodes, [$request->code]);
            $user->two_factor_recovery_codes = json_encode(array_values($recoveryCodes));
            $user->save();

            Auth::login($user);
            $request->session()->forget('2fa.user_id');
            return redirect()->intended(route('library'))->with('status', 'Recovery code used successfully. Please generate new recovery codes.');
        }

        // Verify regular 2FA code
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if ($valid) {
            Auth::login($user);
            $request->session()->forget('2fa.user_id');
            return redirect()->intended(route('library'));
        }

        return back()->withErrors(['code' => 'Invalid verification code']);
    }

    public function showRecoveryCodes()
    {
        $recoveryCodes = json_decode(auth()->user()->two_factor_recovery_codes);
        return view('auth.2fa-recovery-codes', compact('recoveryCodes'));
    }
}