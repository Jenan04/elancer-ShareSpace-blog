<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
})->name('landing');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
