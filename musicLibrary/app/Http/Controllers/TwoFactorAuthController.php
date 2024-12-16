<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

class TwoFactorAuthController extends Controller
{
    public function __construct()
    {
        \Log::info('Timezone Information', [
            'php_timezone' => date_default_timezone_get(),
            'app_timezone' => config('app.timezone'),
            'current_time' => now()->format('Y-m-d H:i:s'),
            'timestamp' => time(),
        ]);
    }

    public function show2faForm()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        
        if (!$user->two_factor_secret) {
            $secretKey = $google2fa->generateSecretKey();
            $user->two_factor_secret = $secretKey;
            $user->save();
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'Music Library',
            $user->email,
            $user->two_factor_secret
        );

        \Log::info('2FA Setup', [
            'secret' => $user->two_factor_secret,
            'qr_url' => $qrCodeUrl
        ]);

        $qrCode = new QrCode($qrCodeUrl);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeData = $result->getString();

        return view('auth.2fa-setup', [
            'secret' => $user->two_factor_secret,
            'qrCodeUrl' => base64_encode($qrCodeData)
        ]);
    }

    public function enable2fa(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string|size:6'
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        try {
            $code = preg_replace('/[^0-9]/', '', $request->one_time_password);
            $timestamp = time();
            $currentOtp = $google2fa->getCurrentOtp($user->two_factor_secret);
            
            // Log all possible codes in a wider time window
            $codes = [];
            for ($i = -2; $i <= 2; $i++) {
                $checkTime = $timestamp + ($i * 30);
                $codes[$checkTime] = $google2fa->getCurrentOtp($user->two_factor_secret, $checkTime);
            }
            
            \Log::info('2FA Debug Information', [
                'entered_code' => $code,
                'current_server_time' => date('Y-m-d H:i:s', $timestamp),
                'possible_valid_codes' => $codes,
                'secret' => $user->two_factor_secret,
                'current_otp' => $currentOtp,
                'timezone_info' => [
                    'php_timezone' => date_default_timezone_get(),
                    'app_timezone' => config('app.timezone'),
                    'utc_time' => gmdate('Y-m-d H:i:s'),
                    'timestamp' => $timestamp
                ]
            ]);

            // Try direct comparison first
            if ($code === $currentOtp) {
                $valid = true;
            } else {
                // If direct comparison fails, try with window
                $valid = $google2fa->verifyKey(
                    $user->two_factor_secret,
                    $code,
                    4  // Increased window to ±4 intervals (±2 minutes)
                );
            }
                
            if ($valid) {
                $recoveryCodes = collect(range(1, 8))->map(function () {
                    return Str::random(10);
                })->toJson();

                $user->two_factor_confirmed_at = now();
                $user->two_factor_recovery_codes = $recoveryCodes;
                $user->save();

                session(['temp_2fa_user_id' => $user->id]);

                return redirect()->route('2fa.show-recovery-codes');
            }

            \Log::warning('2FA Verification Failed', [
                'entered_code' => $code,
                'expected_current_code' => $currentOtp,
                'time_info' => [
                    'timestamp' => $timestamp,
                    'timezone' => date_default_timezone_get(),
                    'current_window' => floor($timestamp / 30),
                    'previous_window' => floor(($timestamp - 30) / 30),
                    'next_window' => floor(($timestamp + 30) / 30)
                ]
            ]);

            return back()->withErrors([
                'one_time_password' => 'Invalid verification code. Please ensure your device time is synchronized.'
            ]);
        } catch (\Exception $e) {
            \Log::error('2FA verification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'code' => $code ?? null,
                'timestamp' => $timestamp ?? null
            ]);
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
            $recoveryCodes = json_decode($user->two_factor_recovery_codes, true) ?? [];
            if (in_array($request->code, $recoveryCodes)) {
                $recoveryCodes = array_diff($recoveryCodes, [$request->code]);
                $user->two_factor_recovery_codes = json_encode(array_values($recoveryCodes));
                $user->save();

                Auth::login($user);
                session(['2fa_verified' => true]);
                session()->forget('2fa.user_id');
                return redirect()->intended(route('library'))
                    ->with('status', 'Recovery code used successfully. Please generate new recovery codes.');
            }

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
        $userId = session('temp_2fa_user_id');
        if (!$userId) {
            return redirect()->route('profile.edit');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('profile.edit');
        }

        $recoveryCodes = json_decode($user->two_factor_recovery_codes);
        
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