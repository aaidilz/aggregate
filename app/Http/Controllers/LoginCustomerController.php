<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginCustomerController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login-customer');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            notify()->success('Login successful!', 'Welcome back!');
            return redirect()->intended('/u');
        }

        return back()->with('error', 'Login failed! Please check your username and password.');
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
