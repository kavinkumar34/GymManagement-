<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;

class MemberDashboardController extends Controller
{
    public function index()
    {
        return view('member.dashboard');
    }
}