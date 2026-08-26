<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberAttendance;
use App\Models\Member;

class MemberAttendanceController extends Controller
{
    /**
     * Display attendance list with filters.
     */
    public function index(Request $request)
    {
        $trainerId = session('gym_user_id');

        $query = MemberAttendance::with('member')
            ->where('trainer_id', $trainerId);

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('attendance_date', $request->date);
        }

        if ($request->has('member_id') && $request->member_id) {
            $query->where('member_id', $request->member_id);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);

        $members = Member::where('trainer_id', $trainerId)
                        ->orWhere('trainer_id', null)
                        ->where('status', 1)
                        ->orderBy('name')
                        ->get();

        return view('trainer.member-attendance.index', compact('attendances', 'members'));
    }

    /**
     * Show create attendance form with CHECKBOX for multiple members.
     */
    public function create()
    {
        $trainerId = session('gym_user_id');

        $members = Member::where('trainer_id', $trainerId)
            ->orWhere('trainer_id', null)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('trainer.member-attendance.create', compact('members'));
    }

    /**
     * Store attendance for MULTIPLE members (CHECKBOX support).
     */
    public function store(Request $request)
    {
        // ===== VALIDATION =====
        $request->validate([
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Absent',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'remarks' => 'nullable|string|max:500',
        ]);

        // ===== GET TRAINER ID =====
        $trainerId = session('gym_user_id');

        if (!$trainerId) {
            return redirect()->back()->with('error', 'Trainer not found. Please login again.');
        }

        // ===== CHECK FOR EXISTING ATTENDANCE =====
        $existingMembers = [];
        $successCount = 0;

        foreach ($request->member_ids as $memberId) {
            // Check if attendance already exists for this member on this date
            $exists = MemberAttendance::where('member_id', $memberId)
                        ->whereDate('attendance_date', $request->attendance_date)
                        ->exists();

            if ($exists) {
                $member = Member::find($memberId);
                $existingMembers[] = $member->name ?? $memberId;
                continue;
            }

            // ===== CREATE ATTENDANCE =====
            MemberAttendance::create([
                'member_id' => $memberId,
                'trainer_id' => $trainerId,
                'attendance_date' => $request->attendance_date,
                'status' => $request->status,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'remarks' => $request->remarks,
            ]);

            $successCount++;
        }

        // ===== RESPONSE MESSAGE =====
        $message = "✅ Attendance marked successfully for {$successCount} member(s).";

        if (!empty($existingMembers)) {
            $message .= " ⚠️ Skipped: " . implode(', ', $existingMembers) . " (already marked for this date).";
        }

        if ($successCount == 0 && !empty($existingMembers)) {
            return redirect()->route('trainer.member-attendance.index')
                ->with('warning', 'No new attendance marked. All selected members already have attendance for this date.');
        }

        return redirect()->route('trainer.member-attendance.index')
            ->with('success', $message);
    }

    /**
     * Show attendance history for a specific member.
     */
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

    /**
     * Show edit form for a single attendance record.
     */
    public function edit($id)
    {
        $trainerId = session('gym_user_id');

        $attendance = MemberAttendance::where('id', $id)
                        ->where('trainer_id', $trainerId)
                        ->first();

        if (!$attendance) {
            return redirect()->route('trainer.member-attendance.index')
                ->with('error', 'Attendance record not found.');
        }

        $members = Member::where('trainer_id', $trainerId)
                        ->orWhere('trainer_id', null)
                        ->where('status', 1)
                        ->orderBy('name')
                        ->get();

        return view('trainer.member-attendance.edit', compact('attendance', 'members'));
    }

    /**
     * Update a single attendance record.
     */
    public function update(Request $request, $id)
    {
        $trainerId = session('gym_user_id');

        $attendance = MemberAttendance::where('id', $id)
                        ->where('trainer_id', $trainerId)
                        ->first();

        if (!$attendance) {
            return redirect()->route('trainer.member-attendance.index')
                ->with('error', 'Attendance record not found.');
        }

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Absent',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'remarks' => 'nullable|string|max:500',
        ]);

        $attendance->update([
            'member_id' => $request->member_id,
            'attendance_date' => $request->attendance_date,
            'status' => $request->status,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('trainer.member-attendance.index')
            ->with('success', 'Attendance updated successfully!');
    }

    /**
     * Delete a single attendance record.
     */
    public function destroy($id)
    {
        $trainerId = session('gym_user_id');

        $attendance = MemberAttendance::where('id', $id)
                        ->where('trainer_id', $trainerId)
                        ->first();

        if (!$attendance) {
            return redirect()->route('trainer.member-attendance.index')
                ->with('error', 'Attendance record not found.');
        }

        $attendance->delete();

        return redirect()->route('trainer.member-attendance.index')
            ->with('success', 'Attendance record deleted successfully!');
    }
}