<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }
    public function login(Request $request) {
        Session::put('logged_in', true); // dummy login
        return redirect('/');
    }
}