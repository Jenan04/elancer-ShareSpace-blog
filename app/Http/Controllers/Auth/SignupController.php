<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    //
    public function showRegistrationForm() {
    return view('auth.signup');
}
}
