<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainerAttendance;

class TrainerAttendanceController extends Controller
{
    public function index()
    {
        $attendance = TrainerAttendance::with('trainer')
            ->latest()
            ->paginate(20);

        return view('admin.trainer-attendance.index', compact('attendance'));
    }
}