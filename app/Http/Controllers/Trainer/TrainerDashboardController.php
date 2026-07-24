<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;

class TrainerDashboardController extends Controller
{
    public function index()
    {
        // Check Trainer Login
        if (
            !session()->has('gym_user_id') ||
            session('gym_user_role') != 'trainer'
        ) {
            return redirect()->route('member.trainer.login')
                ->with('error', 'Please login as Trainer.');
        }

        return view('trainer.dashboard');
    }
}