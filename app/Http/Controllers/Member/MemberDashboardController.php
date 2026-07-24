<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;

class MemberDashboardController extends Controller
{
    public function index()
    {
        // Check Member Login
        if (
            !session()->has('gym_user_id') ||
            session('gym_user_role') != 'member'
        ) {
            return redirect()->route('member.trainer.login')
                ->with('error', 'Please login as Member.');
        }

        return view('member.dashboard');
    }
}