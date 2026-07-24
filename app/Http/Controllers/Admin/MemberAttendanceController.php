<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberAttendance;

class MemberAttendanceController extends Controller
{
    public function index()
    {
        $attendance = MemberAttendance::with(['member', 'trainer'])
            ->latest()
            ->paginate(20);

        return view('admin.member-attendance.index', compact('attendance'));
    }
}