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

        try {
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

                // Store user ID in session before showing recovery codes
                session(['temp_2fa_user_id' => $user->id]);

                return redirect()->route('2fa.show-recovery-codes');
            }

            return back()->withErrors(['one_time_password' => 'Invalid verification code']);
        } catch (\Exception $e) {
            return back()->withErrors(['one_time_password' => 'Error verifying code']);
        }
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

    public function showVerifyForm(Request $request)
    {
        if (!session('2fa.user_id')) {
            return redirect()->route('signin');
        }

        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $userId = session('2fa.user_id');
        if (!$userId) {
            return redirect()->route('signin')
                ->withErrors(['email' => 'Invalid session. Please login again.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('signin')
                ->withErrors(['email' => 'Invalid session. Please login again.']);
        }

        try {
            // Check if it's a recovery code
            $recoveryCodes = json_decode($user->two_factor_recovery_codes, true) ?? [];
            if (in_array($request->code, $recoveryCodes)) {
                // Remove used recovery code
                $recoveryCodes = array_diff($recoveryCodes, [$request->code]);
                $user->two_factor_recovery_codes = json_encode(array_values($recoveryCodes));
                $user->save();

                Auth::login($user);
                session(['2fa_verified' => true]);
                session()->forget('2fa.user_id');
                return redirect()->intended(route('library'))
                    ->with('status', 'Recovery code used successfully. Please generate new recovery codes.');
            }

            // Verify regular 2FA code
            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

            if ($valid) {
                Auth::login($user);
                session(['2fa_verified' => true]);
                session()->forget('2fa.user_id');
                return redirect()->intended(route('library'));
            }

            return back()->withErrors(['code' => 'Invalid verification code']);
        } catch (\Exception $e) {
            \Log::error('2FA verification error: ' . $e->getMessage());
            return back()->withErrors(['code' => 'Error verifying code']);
        }
    }

    public function showRecoveryCodes()
    {
        // Check if we have a temp user ID from 2FA setup
        $userId = session('temp_2fa_user_id');
        if (!$userId) {
            return redirect()->route('profile.edit');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('profile.edit');
        }

        $recoveryCodes = json_decode($user->two_factor_recovery_codes);
        
        // Clear the temporary session
        session()->forget('temp_2fa_user_id');
        
        return view('auth.2fa-recovery-codes', [
            'recoveryCodes' => $recoveryCodes,
            'showVerifyButton' => false
        ]);
    }

    public function completeSetup()
    {
        return redirect()->route('profile.edit')
            ->with('success', '2FA has been enabled successfully');
    }
}