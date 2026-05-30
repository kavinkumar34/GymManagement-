<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function create()
    {
        $trainers = Trainer::where('status', 'Active')->get();
        return view('admin.member-register', compact('trainers'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email',
            'address' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'join_date' => 'required|date',
            'membership_plan' => 'required',
            'membership_duration' => 'required',
            'trainer_id' => 'nullable|exists:trainers,id',
            'goal_type' => 'required',
            'status' => 'required'
        ]);
        
        // Generate Member ID
        $lastMember = Member::orderBy('id', 'desc')->first();
        $memberId = 'M' . str_pad(($lastMember ? $lastMember->id + 1 : 1), 4, '0', STR_PAD_LEFT);
        
        // Calculate age from DOB
        $age = null;
        if ($request->dob) {
            $age = \Carbon\Carbon::parse($request->dob)->age;
        }
        
        // Calculate BMI
        $bmi = null;
        if ($request->height && $request->weight) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 1);
        }
        
        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('member-photos', 'public');
        }
        
        $member = Member::create([
            'member_id' => $memberId,
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'age' => $age,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $bmi,
            'emergency_contact' => $request->emergency_contact,
            'join_date' => $request->join_date,
            'membership_plan' => $request->membership_plan,
            'membership_duration' => $request->membership_duration,
            'trainer_id' => $request->trainer_id,
            'medical_issues' => $request->medical_issues,
            'goal_type' => $request->goal_type,
            'photo' => $photoPath,
            'status' => $request->status
        ]);
        
        // Update trainer's assigned members count
        if ($request->trainer_id) {
            $trainer = Trainer::find($request->trainer_id);
            $trainer->increment('assigned_members');
        }
        
        return redirect()->route('admin.members')->with('success', 'Member registered successfully! Member ID: ' . $memberId);
    }
    
    public function index()
    {
        $members = Member::with('trainer')->orderBy('id', 'desc')->paginate(15);
        return view('admin.members-list', compact('members'));
    }
    
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $trainers = Trainer::where('status', 'Active')->get();
        return view('admin.member-edit', compact('member', 'trainers'));
    }
    
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email,' . $id,
            'membership_plan' => 'required',
            'status' => 'required'
        ]);
        
        // Update BMI if height/weight changed
        $bmi = $member->bmi;
        if ($request->height && $request->weight) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 1);
        }
        
        $member->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $bmi,
            'emergency_contact' => $request->emergency_contact,
            'membership_plan' => $request->membership_plan,
            'membership_duration' => $request->membership_duration,
            'trainer_id' => $request->trainer_id,
            'medical_issues' => $request->medical_issues,
            'goal_type' => $request->goal_type,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.members')->with('success', 'Member updated successfully!');
    }
    
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        $member->delete();
        
        return redirect()->route('admin.members')->with('success', 'Member deleted successfully!');
    }
    public function show($id)
{
    $member = Member::with('trainer')->findOrFail($id);
    return view('admin.member-show', compact('member'));
}
}