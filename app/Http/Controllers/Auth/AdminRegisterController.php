<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.admin-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'captcha' => 'required'
        ]);

        if ($request->captcha != session('captcha')) {
            return back()->with('error', 'Invalid captcha')->withInput();
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($admin) {
            // Auto login after registration - Direct to dashboard
            Auth::guard('admin')->login($admin);
            
            return redirect()->route('admin.dashboard')->with('success', 'Registration successful! Welcome to Admin Panel!');
        }

        return back()->with('error', 'Registration failed')->withInput();
    }
}