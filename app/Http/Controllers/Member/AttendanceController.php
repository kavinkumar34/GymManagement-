<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberAttendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $memberId = session('gym_user_id');

        $history = MemberAttendance::with('trainer')
                    ->where('member_id',$memberId)
                    ->orderBy('attendance_date','desc')
                    ->get();

        return view('member.attendance.index',compact('history'));
    }
}