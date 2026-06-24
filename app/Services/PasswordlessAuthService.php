<?php

namespace App\Services;

use App\Models\LoginCode;
use App\Models\User;
use App\Models\Role;
use App\Notifications\SendLoginCodeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PasswordlessAuthService
{
    public function sendLoginCode(string $email): void
    {
        LoginCode::where('email', $email)->delete();

        $plainOtp = (string) random_int(100000, 999999);
        $plainToken = Str::random(40);
        $expiresAt = now()->addMinutes(15);

        LoginCode::create([
            'email' => $email,
            'otp' => Hash::make($plainOtp),
            'token' => Hash::make($plainToken),
            'otp_attempts' => 0,
            'expires_at' => $expiresAt,
        ]);

        $magicLink = URL::temporarySignedRoute(
            'auth.magic-link',
            $expiresAt,
            ['token' => $plainToken]
        );

        Notification::route('mail', $email)->notify(
            new SendLoginCodeNotification($plainOtp, $magicLink)
        );
    }

    public function verifyOtp(string $email, string $otp): ?User
    {
        $loginCode = LoginCode::where('email', $email)->first();

        if (! $loginCode) {
            return null;
        }

        if ($loginCode->hasExceededOtpAttempts()) {
            return null;
        }

        if ($loginCode->isExpired()) {
            $loginCode->delete();

            return null;
        }

        if (! Hash::check($otp, $loginCode->otp)) {
            $loginCode->increment('otp_attempts');

            return null;
        }

        return $this->authenticateUser($email, $loginCode);
    }

    public function verifyMagicLinkToken(string $token): ?User
    {
        $loginCode = LoginCode::where('expires_at', '>', now())->get()
            ->first(fn (LoginCode $code) => Hash::check($token, $code->token));

        if (! $loginCode) {
            return null;
        }

        if ($loginCode->isExpired()) {
            $loginCode->delete();

            return null;
        }

        return $this->authenticateUser($loginCode->email, $loginCode);
    }

    public function authenticateUser(string $email, ?LoginCode $loginCode = null): User
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            // ['role' => 'user']
            [
            'name' => explode('@', $email)[0],
            'slug' => \Illuminate\Support\Str::slug(explode('@', $email)[0]) . '-' . \Illuminate\Support\Str::random(5),
            'status' => \App\Enums\UserStatus::ACTIVE, 
        ]
        );

        if ($user->wasRecentlyCreated) {
        $defaultRole = Role::where('name', 'User')->first();
        if ($defaultRole) {
            $user->roles()->attach($defaultRole->id);
        }
    }

        if (! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        if ($loginCode) {
            $loginCode->delete();
        } else {
            LoginCode::where('email', $email)->delete();
        }

        RateLimiter::clear($this->throttleKey($email));

        Auth::login($user, remember: true);
        request()->session()->regenerate();

        return $user;
    }

    public function throttleKey(string $email): string
    {
        return 'passwordless-auth:'.strtolower($email);
    }
}
