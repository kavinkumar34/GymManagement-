<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    // Appointment List
    public function index()
    {
        $trainerId = Session::get('gym_user_id');

        $appointments = Appointment::with('member')
            ->where('trainer_id', $trainerId)
            ->orderBy('appointment_date', 'asc')
            ->paginate(10);

        return view('trainer.appointment.index', compact('appointments'));
    }

    // Approve Appointment
    public function approve(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->status = 'Approved';
        $appointment->trainer_remark = $request->trainer_remark;
        $appointment->save();

        return back()->with('success', 'Appointment Approved Successfully.');
    }

    // Reject Appointment
    public function reject(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->status = 'Rejected';
        $appointment->trainer_remark = $request->trainer_remark;
        $appointment->save();

        return back()->with('success', 'Appointment Rejected Successfully.');
    }
}