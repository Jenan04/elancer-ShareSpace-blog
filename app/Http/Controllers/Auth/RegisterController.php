<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\PasswordlessAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showSignup(): View
    {
        return view('auth.signup', [
            'heading' => 'Bring your stories to life',
            'description' => 'Enter your email to secure your piece of ShareSpace. An elegant home for your essays, research, and daily thoughts—designed for everyone who loves to write.',
            'submitRoute' => route('signup'),
            'alternateLabel' => 'Sign in to an existing blog',
            'alternateRoute' => route('signin'),
        ]);
    }

    public function showSignin(): View
    {
        return view('auth.signup', [
            'heading' => 'Welcome back',
            'description' => 'Enter your email to sign in. We will send you a one-time code and a magic link—use whichever is easiest.',
            'submitRoute' => route('signin'),
            'alternateLabel' => 'Create a new blog',
            'alternateRoute' => route('signup'),
        ]);
    }

    public function store(RegisterRequest $request, PasswordlessAuthService $authService): RedirectResponse
    {
        $email = $request->validated('email');

        $authService->sendLoginCode($email);

        return redirect()
            ->route('auth.check-income')
            ->with('email', $email);
    }

    public function showCheckIncome(): View|RedirectResponse
    {
        $email = session('email');

        if (! $email) {
            return redirect()->route('signup');
        }

        return view('auth.check-income', compact('email'));
    }
}
