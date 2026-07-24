<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberAttendance;
use App\Models\Member;

class MemberAttendanceController extends Controller
{
    // Assigned Members Attendance
    public function index()
    {
        $trainerId = session('gym_user_id');

        $attendances = MemberAttendance::with('member')
            ->where('trainer_id', $trainerId)
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('trainer.member-attendance.index', compact('attendances'));
    }

    // Attendance Form
    public function create()
    {
        $trainerId = session('gym_user_id');

        $members = Member::where('trainer_id', $trainerId)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('trainer.member-attendance.create', compact('members'));
    }

    // Save Attendance
    public function store(Request $request)
    {
        $request->validate([
            'member_id'       => 'required',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:Present,Absent',
            'check_in'        => 'nullable',
            'check_out'       => 'nullable',
            'remarks'         => 'nullable'
        ]);

        $exists = MemberAttendance::where('member_id', $request->member_id)
            ->where('attendance_date', $request->attendance_date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Attendance already marked for this member.');
        }

        MemberAttendance::create([
            'trainer_id'      => session('gym_user_id'),
            'member_id'       => $request->member_id,
            'attendance_date' => $request->attendance_date,
            'status'          => $request->status,
            'check_in'        => $request->check_in,
            'check_out'       => $request->check_out,
            'remarks'         => $request->remarks,
        ]);

        return redirect()->route('trainer.member-attendance.index')
            ->with('success', 'Member attendance marked successfully.');
    }

    // Attendance History
    public function show($memberId)
    {
        $trainerId = session('gym_user_id');

        $member = Member::where('id', $memberId)
            ->where('trainer_id', $trainerId)
            ->firstOrFail();

        $history = MemberAttendance::where('member_id', $memberId)
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('trainer.member-attendance.show', compact('member', 'history'));
    }
}