<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerAttendance;

class TrainerAttendanceController extends Controller
{
    // Trainer Attendance List
    public function index()
    {
        $trainerId = session('gym_user_id');

        $attendances = TrainerAttendance::where('trainer_id', $trainerId)
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('trainer.trainer-attendance.index', compact('attendances'));
    }

    // Attendance Form
    public function create()
    {
        return view('trainer.trainer-attendance.create');
    }

    // Save Attendance
    public function store(Request $request)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'status'          => 'required|in:Present,Absent',
            'check_in'        => 'nullable',
            'check_out'       => 'nullable',
            'remarks'         => 'nullable'
        ]);

        // Prevent duplicate attendance for the same day
        $exists = TrainerAttendance::where('trainer_id', session('gym_user_id'))
            ->where('attendance_date', $request->attendance_date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Attendance already marked for today.');
        }

        TrainerAttendance::create([
            'trainer_id'      => session('gym_user_id'),
            'attendance_date' => $request->attendance_date,
            'status'          => $request->status,
            'check_in'        => $request->check_in,
            'check_out'       => $request->check_out,
            'remarks'         => $request->remarks,
        ]);

        return redirect()->route('trainer.trainer-attendance.index')
            ->with('success', 'Attendance marked successfully.');
    }
}