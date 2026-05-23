<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignupController;

Route::get('/', function () {
  return view('welcome');
})->name('landing');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Route::get('/signup', [AuthController::class, 'showsignup'])->name('signup');

// Route::middleware('guest')->group(function () {
    
//     Route::get('/signup', [SignupController::class, 'showRegistrationForm'])->name('signup');
//     Route::post('/signup', [SignupController::class, 'signup']);

//     // Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//     // Route::post('/login', [LoginController::class, 'login']);
    
// });

Route::middleware('guest')->group(function () {
    
    Route::get('/signup', [SignupController::class, 'showRegistrationForm'])->name('signup');
    Route::post('/signup', [SignupController::class, 'register']);
    
});