<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Trainer;

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

        // Regenerate session
        $request->session()->regenerate();

        // Store Gym Management user in session
        session([
            'gym_user_id'    => $userData->id,
            'gym_user_name'  => $userData->name,
            'gym_user_email' => $userData->email,
            'gym_user_role'  => $role,
        ]);

        if ($role == 'member') {
            return redirect()->route('member.dashboard')
                ->with('success', 'Welcome ' . $userData->name);
        }

        if ($role == 'trainer') {
            return redirect()->route('trainer.dashboard')
                ->with('success', 'Welcome ' . $userData->name);
        }

        return back()->with('error', 'Invalid Role');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'gym_user_id',
            'gym_user_name',
            'gym_user_email',
            'gym_user_role'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('member.trainer.login');
    }
}