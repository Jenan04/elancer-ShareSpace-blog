<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/signup', [RegisterController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [RegisterController::class, 'store']);

    Route::get('/signin', [RegisterController::class, 'showSignin'])->name('signin');
    Route::post('/signin', [RegisterController::class, 'store']);

    Route::get('/auth/check-income', [RegisterController::class, 'showCheckIncome'])->name('auth.check-income');
    Route::post('/auth/verify-otp', [OtpVerificationController::class, 'verify'])->name('auth.verify-otp');

    Route::get('/auth/magic-link', [MagicLinkController::class, 'handle'])
        ->name('auth.magic-link');

    Route::view('/auth/link-expired', 'auth.link-expired')->name('auth.link-expired');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
