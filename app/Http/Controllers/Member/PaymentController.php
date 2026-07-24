<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;

class PaymentController extends Controller
{
    public function index()
    {
        $member = Member::where('email', session('gym_user_email'))->first();

        return view('member.payments', compact('member'));
    }
}