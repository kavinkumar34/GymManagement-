<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

 public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'captcha' => 'required'
    ]);

    if ($request->captcha != session('captcha')) {
        return back()->with('error', 'Invalid captcha')->withInput();
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Redirect to home page (store) after login
        return redirect()->route('home');
    }

    return back()->with('error', 'Invalid credentials')->withInput($request->only('email'));
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // Clear cart from localStorage via JavaScript
    return redirect('/')->withHeaders([
        'Clear-Site-Data' => 'storage'
    ]);
}
}