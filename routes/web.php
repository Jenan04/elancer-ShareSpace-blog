<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/signup', [RegisterController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [RegisterController::class, 'store']);

    Route::get('/signin', [RegisterController::class, 'showSignin'])->name('signin');
    Route::get('/login', fn() => redirect()->route('signin'))->name('login');
    Route::post('/signin', [RegisterController::class, 'store']);

    Route::get('/auth/check-income', [RegisterController::class, 'showCheckIncome'])->name('auth.check-income');
    Route::post('/auth/verify-otp', [OtpVerificationController::class, 'verify'])->name('auth.verify-otp');

    Route::get('/auth/magic-link', [MagicLinkController::class, 'handle'])
        ->name('auth.magic-link');

    Route::view('/auth/link-expired', 'auth.link-expired')->name('auth.link-expired');
});

// Publicly accessible Feed, Post Show, and Profile
Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/p/{username}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/posts/{id}/react', [FeedController::class, 'react'])->name('posts.react');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Authenticated editor endpoints
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/api/ai/suggest-tags', [PostController::class, 'suggestTags'])->name('api.suggest-tags');
});
