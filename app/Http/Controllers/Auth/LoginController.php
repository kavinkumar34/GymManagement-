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
            
            // 👇 ROLE BASED REDIRECT - ADD THIS
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'trainer') {
                return redirect()->route('trainer.dashboard');
            } elseif ($user->role === 'member') {
                return redirect()->route('member.dashboard');
            }
            
            // Default: Redirect to home page (store)
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