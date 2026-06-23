<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\LoginCode;
use App\Services\PasswordlessAuthService;
use Illuminate\Http\RedirectResponse;

class OtpVerificationController extends Controller
{
    public function verify(VerifyOtpRequest $request, PasswordlessAuthService $authService): RedirectResponse
    {
        $email = $request->validated('email');
        $otp = $request->validated('otp');

        $loginCode = LoginCode::where('email', $email)->first();

        if ($loginCode?->hasExceededOtpAttempts()) {
            $loginCode->delete();

            return redirect()
                ->route('signup')
                ->withErrors(['email' => 'Too many failed attempts. Please request a new code.']);
        }

        $user = $authService->verifyOtp($email, $otp);

        if (! $user) {
            $loginCode = LoginCode::where('email', $email)->first();

            if ($loginCode?->hasExceededOtpAttempts()) {
                $loginCode->delete();

                return redirect()
                    ->route('signup')
                    ->withErrors(['email' => 'Too many failed attempts. Please request a new code.']);
            }

            return back()
                ->withInput()
                ->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        return redirect()->route('feed');
    }
}
