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
            return back()->with('error', 'Invalid captcha code. Please try again.')->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'trainer') {
                return redirect()->route('trainer.dashboard');
            } elseif ($user->role === 'member') {
                return redirect()->route('member.dashboard');
            }
            
            return redirect()->route('home');
        }

        return back()->with('error', 'Invalid email or password. Please try again.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->withHeaders([
            'Clear-Site-Data' => 'storage'
        ]);
    }
}