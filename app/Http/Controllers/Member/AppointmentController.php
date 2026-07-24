<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment;
use App\Models\Member;
use App\Models\Trainer;

class AppointmentController extends Controller
{
    // Appointment List
    public function index()
    {
        $memberId = Session::get('gym_user_id');

        $appointments = Appointment::with('trainer')
            ->where('member_id', $memberId)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('member.appointment.index', compact('appointments'));
    }

    // Appointment Create Page
    public function create()
    {
        $memberId = Session::get('gym_user_id');

        $member = Member::find($memberId);

        $trainer = Trainer::find($member->trainer_id);

        return view('member.appointment.create', compact('trainer'));
    }

    // Store Appointment
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'purpose' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $memberId = Session::get('gym_user_id');

        $member = Member::find($memberId);

        Appointment::create([
            'member_id' => $memberId,
            'trainer_id' => $member->trainer_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'purpose' => $request->purpose,
            'description' => $request->description,
            'status' => 'Pending'
        ]);

        return redirect()
            ->route('member.appointment.index')
            ->with('success', 'Appointment booked successfully.');
    }
}