<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MemberRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.member-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:member,trainer',
            'captcha' => 'required'
        ]);

        if ($request->captcha != session('captcha')) {
            return back()->with('error', 'Invalid captcha')->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($user) {
            Auth::login($user);
            
            // Redirect to home page without success message
            return redirect()->route('home');
        }

        return back()->with('error', 'Registration failed')->withInput();
    }
}