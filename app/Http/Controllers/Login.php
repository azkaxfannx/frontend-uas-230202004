<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'admin@example.com' && $password === '123456') {
            Session::put('logged_in', true);
            return redirect('/')->with('success', 'Login berhasil');
        }

        return redirect('/login')->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Session::forget('logged_in');
        return redirect('/login')->with('success', 'Berhasil logout');
    }
}