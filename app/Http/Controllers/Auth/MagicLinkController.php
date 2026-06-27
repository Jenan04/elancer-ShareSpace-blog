<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PasswordlessAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MagicLinkController extends Controller
{
    public function handle(Request $request, PasswordlessAuthService $authService): RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('auth.link-expired');
        }

        $token = $request->query('token');

        if (! $token) {
            return redirect()->route('auth.link-expired');
        }

        $user = $authService->verifyMagicLinkToken($token);

        if (! $user) {
            return redirect()->route('auth.link-expired');
        }

        return redirect()->route('feed');
    }
}
