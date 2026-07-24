<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan;

class WorkoutController extends Controller
{
    public function index()
    {
        // Check Member Login
        if (
            !session()->has('gym_user_id') ||
            session('gym_user_role') != 'member'
        ) {
            return redirect()->route('member.trainer.login');
        }

        $memberId = session('gym_user_id');

        $workouts = WorkoutPlan::where('member_id', $memberId)
            ->with(['trainer', 'exercises'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.workout.index', compact('workouts'));
    }

    public function show($id)
    {
        // Check Member Login
        if (
            !session()->has('gym_user_id') ||
            session('gym_user_role') != 'member'
        ) {
            return redirect()->route('member.trainer.login');
        }

        $memberId = session('gym_user_id');

        $workout = WorkoutPlan::with(['trainer', 'exercises'])
            ->where('member_id', $memberId)
            ->findOrFail($id);

        return view('member.workout.show', compact('workout'));
    }
}