<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\User;

class MemberTrainerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.member-trainer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required', // This will be phone number
            'role' => 'required|in:member,trainer'
        ]);

        $email = $request->email;
        $phone = $request->password; // User enters phone number in password field
        $role = $request->role;

        $userData = null;
        $userPhone = null;
        $userName = null;
        $userEmail = null;

        // Check in members table
        if ($role === 'member') {
            $member = Member::where('email', $email)
                ->where('phone', $phone) // Check phone number
                ->where('status', 'Active')
                ->first();
            
            if ($member) {
                $userData = $member;
                $userPhone = $member->phone;
                $userName = $member->name;
                $userEmail = $member->email;
            }
        } 
        // Check in trainers table
        elseif ($role === 'trainer') {
            $trainer = Trainer::where('email', $email)
                ->where('phone', $phone) // Check phone number
                ->where('status', 'Active')
                ->first();
            
            if ($trainer) {
                $userData = $trainer;
                $userPhone = $trainer->phone;
                $userName = $trainer->name;
                $userEmail = $trainer->email;
            }
        }

        // If no match found
        if (!$userData) {
            return back()->with('error', 'Invalid email or phone number. Please check and try again.')->withInput();
        }

        // Check if user exists in users table, if not create one
        $user = User::where('email', $userEmail)->first();
        
        if (!$user) {
            // Create user in users table with phone as password hash
            $user = User::create([
                'name' => $userName,
                'email' => $userEmail,
                'phone' => $userPhone,
                'password' => bcrypt($userPhone), // Phone number as password
                'role' => $role,
                'is_verified' => 1,
            ]);
        } else {
            // Update user phone if different
            if ($user->phone != $userPhone) {
                $user->phone = $userPhone;
                $user->name = $userName;
                $user->save();
            }
        }

        // Login the user
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect based on role
        if ($role === 'trainer') {
            return redirect()->route('trainer.dashboard')->with('success', 'Welcome back, ' . $userName . '!');
        } elseif ($role === 'member') {
            return redirect()->route('member.dashboard')->with('success', 'Welcome back, ' . $userName . '!');
        }

        Auth::logout();
        return back()->with('error', 'Invalid role.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}