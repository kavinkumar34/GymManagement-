<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Member;

class TrainerMemberController extends Controller
{
    public function index()
    {
        if (
            !session()->has('gym_user_id') ||
            session('gym_user_role') != 'trainer'
        ) {
            return redirect()->route('member.trainer.login');
        }

        $trainerId = session('gym_user_id');

        $members = Member::where('trainer_id', $trainerId)
            ->orderBy('name')
            ->get();

        return view('trainer.members', compact('members'));
    }
}