<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function create()
    {
        $trainers = Trainer::where('status', 'Active')->get();
        $memberships = Membership::where('status', 'Active')->get();
        $packages = Package::where('status', 'Active')->get();
        return view('admin.member-register', compact('trainers', 'memberships', 'packages'));
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
            'plan_type' => 'required|in:membership,package',
            'membership_plan' => 'nullable|required_if:plan_type,membership',
            'package_name' => 'nullable|required_if:plan_type,package',
            'trainer_id' => 'nullable|exists:trainers,id',
            'goal_type' => 'required',
            'status' => 'required'
        ]);

        // Generate Member ID
        $lastMember = Member::orderBy('id', 'desc')->first();
        $memberId = 'M' . str_pad(($lastMember ? $lastMember->id + 1 : 1), 4, '0', STR_PAD_LEFT);
        
        // ✅ Calculate age from DOB
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

        // Set membership plan, duration and final price based on selection
        $membershipPlan = null;
        $membershipDuration = null;
        $finalPrice = null;

        if ($request->plan_type == 'membership' && $request->membership_plan) {
            $membership = Membership::where('plan_name', $request->membership_plan)->first();
            if ($membership) {
                $membershipPlan = $membership->plan_name;
                $membershipDuration = $membership->duration . ' ' . $membership->duration_type;
                $finalPrice = $membership->final_price;
            }
        } elseif ($request->plan_type == 'package' && $request->package_name) {
            $package = Package::where('package_name', $request->package_name)->first();
            if ($package) {
                $membershipPlan = $package->package_name;
                $membershipDuration = $package->duration . ' ' . $package->duration_type;
                $finalPrice = $package->price;
            }
        }
        
        $member = Member::create([
            'member_id' => $memberId,
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'age' => $age,  // ✅ Age stored
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $bmi,
            'emergency_contact' => $request->emergency_contact,
            'join_date' => $request->join_date,
            'plan_type' => $request->plan_type,

            'membership_plan' => $membershipPlan,
            'membership_duration' => $membershipDuration,
            'final_price' => $finalPrice,  // ✅ Final Price stored
            'trainer_id' => $request->trainer_id,
            'medical_issues' => $request->medical_issues,
            'goal_type' => $request->goal_type,
            'photo' => $photoPath,
            'status' => $request->status
        ]);
        
        // Update trainer's assigned members count
        if ($request->trainer_id) {
            $trainer = Trainer::find($request->trainer_id);
            if ($trainer) {
                $trainer->increment('assigned_members');
            }
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
    $memberships = Membership::where('status', 'Active')->get();
    $packages = Package::where('status', 'Active')->get();
    
    return view('admin.member-edit', compact('member', 'trainers', 'memberships', 'packages'));
}
    
public function update(Request $request, $id)
{
    $member = Member::findOrFail($id);
    
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|unique:members,email,' . $id,
        'status' => 'required'
    ]);
    
    // Update BMI if height/weight changed
    $bmi = $member->bmi;
    if ($request->height && $request->weight) {
        $heightInMeters = $request->height / 100;
        $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 1);
    }
    
    // Set membership plan, duration and final price
    $membershipPlan = $request->membership_plan;
    $membershipDuration = $request->membership_duration;
    $finalPrice = $request->final_price;
    
    // If package is selected, get details from package table
    if ($request->plan_type == 'package' && $request->package_name) {
        $package = Package::where('package_name', $request->package_name)->first();
        if ($package) {
            $membershipPlan = $package->package_name;
            $membershipDuration = $package->duration . ' ' . $package->duration_type;
            $finalPrice = $package->price;
        }
    }
    
    // If membership is selected, get details from membership table
    if ($request->plan_type == 'membership' && $request->membership_plan) {
        $membership = Membership::where('plan_name', $request->membership_plan)->first();
        if ($membership) {
            $membershipPlan = $membership->plan_name;
            $membershipDuration = $membership->duration . ' ' . $membership->duration_type;
            $finalPrice = $membership->final_price;
        }
    }
    
    $member->update([
        'name' => $request->name,
        'gender' => $request->gender,
        'dob' => $request->dob,
        'age' => $request->age,
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'height' => $request->height,
        'weight' => $request->weight,
        'bmi' => $bmi,
        'emergency_contact' => $request->emergency_contact,
        'join_date' => $request->join_date,
        'plan_type' => $request->plan_type,

        'membership_plan' => $membershipPlan,
        'membership_duration' => $membershipDuration,
        'final_price' => $finalPrice,
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

    // ============ AJAX Functions ============
    
    public function getMembershipDetails($planName)
    {
        $membership = Membership::where('plan_name', $planName)
            ->where('status', 'Active')
            ->first();
        
        if ($membership) {
            return response()->json([
                'success' => true,
                'data' => [
                    'duration' => $membership->duration,
                    'duration_type' => $membership->duration_type,
                    'price' => $membership->price,
                    'final_price' => $membership->final_price,
                    'description' => $membership->description,
                ]
            ]);
        }
        
        return response()->json(['success' => false]);
    }

    public function getPackageDetails($packageName)
    {
        $package = Package::where('package_name', $packageName)
            ->where('status', 'Active')
            ->first();
        
        if ($package) {
            return response()->json([
                'success' => true,
                'data' => [
                    'duration' => $package->duration,
                    'duration_type' => $package->duration_type,
                    'price' => $package->price,
                    'description' => $package->description,
                    'included_features' => $package->included_features,
                ]
            ]);
        }
        
        return response()->json(['success' => false]);
    }
    public function handPayment()
{
    $members = Member::orderBy('id', 'desc')->paginate(15);
    return view('admin.hand-payment', compact('members'));
}
}