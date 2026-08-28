<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Package;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        // ===== VALIDATION =====
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:members,email',
            'address' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'join_date' => 'required|date',
            'plan_type' => 'required|in:membership,package,monthly',
            'membership_plan' => 'nullable|required_if:plan_type,membership',
            'package_name' => 'nullable|required_if:plan_type,package',
            'trainer_id' => 'nullable|exists:trainers,id',
            'goal_type' => 'required',
            'status' => 'required',
            
            // ===== NEW VALIDATION FOR PAYMENT =====
            'payment_type' => 'required|in:hand,online',
            'transaction_id' => 'nullable|required_if:payment_type,online|string|max:100',
            'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // ===== GENERATE MEMBER ID =====
        $lastMember = Member::orderBy('id', 'desc')->first();
        $memberId = 'M' . str_pad(($lastMember ? $lastMember->id + 1 : 1), 4, '0', STR_PAD_LEFT);
        
        // ===== CALCULATE AGE =====
        $age = null;
        if ($request->dob) {
            $age = Carbon::parse($request->dob)->age;
        }
        
        // ===== CALCULATE BMI =====
        $bmi = null;
        if ($request->height && $request->weight) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 1);
        }
        
        // ===== HANDLE PHOTO UPLOAD =====
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('member-photos', 'public');
        }

        // ===== HANDLE PAYMENT SCREENSHOT UPLOAD =====
        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $screenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
        }

        // ===== SET PLAN DETAILS =====
        $membershipPlan = null;
        $membershipDuration = null;
        $finalPrice = null;
        $monthlyMonth = null;
        $monthlyPrice = null;
        $monthlyTotal = null;
        $expiryDate = null;

        if ($request->plan_type == 'membership' && $request->membership_plan) {
            $membership = Membership::where('plan_name', $request->membership_plan)->first();
            if ($membership) {
                $membershipPlan = $membership->plan_name;
                $membershipDuration = $membership->duration . ' ' . $membership->duration_type;
                $finalPrice = $membership->final_price;
                $expiryDate = Carbon::parse($request->join_date)->addMonths((int)$membership->duration)->toDateString();
            }
        } elseif ($request->plan_type == 'package' && $request->package_name) {
            $package = Package::where('package_name', $request->package_name)->first();
            if ($package) {
                $membershipPlan = $package->package_name;
                $membershipDuration = $package->duration . ' ' . $package->duration_type;
                $finalPrice = $package->price;
                $expiryDate = Carbon::parse($request->join_date)->addMonths((int)$package->duration)->toDateString();
            }
        } elseif ($request->plan_type == 'monthly') {
            $monthlyMonth = (int)$request->monthly_month;
            $monthlyPrice = (float)$request->monthly_price;
            $monthlyTotal = $request->monthly_total ?? ($monthlyMonth * $monthlyPrice);
            $membershipPlan = 'Monthly Plan';
            $membershipDuration = $monthlyMonth . ' Month(s)';
            $finalPrice = $monthlyTotal;
            $expiryDate = Carbon::parse($request->join_date)->addMonths($monthlyMonth)->toDateString();
        }

        // ===== CREATE MEMBER =====
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
            'expiry_date' => $expiryDate,
            'plan_type' => $request->plan_type,
            'membership_plan' => $membershipPlan,
            'membership_duration' => $membershipDuration,
            'final_price' => $finalPrice,
            'trainer_id' => $request->trainer_id,
            'medical_issues' => $request->medical_issues,
            'goal_type' => $request->goal_type,
            'photo' => $photoPath,
            'status' => $request->status,
            
            // ===== NEW PAYMENT FIELDS =====
            'monthly_month' => $monthlyMonth,
            'monthly_price' => $monthlyPrice,
            'payment_type' => $request->payment_type,
            'transaction_id' => $request->transaction_id,
            'payment_screenshot' => $screenshotPath,
        ]);
        
        // ===== SAVE PAYMENT HISTORY =====
        PaymentHistory::create([
            'member_id' => $member->id,
            'plan_type' => $request->plan_type,
            'plan_name' => $membershipPlan,
            'duration' => $membershipDuration,
            'amount' => $finalPrice,
            'payment_type' => $request->payment_type,
            'transaction_id' => $request->transaction_id,
            'payment_date' => $request->join_date,
            'old_expiry_date' => null,
            'new_expiry_date' => $expiryDate,
        ]);
        
        // ===== UPDATE TRAINER ASSIGNED COUNT =====
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
        $member = Member::with('trainer')->findOrFail($id);
        $trainers = Trainer::where('status', 'Active')->get();
        $memberships = Membership::where('status', 'Active')->get();
        $packages = Package::where('status', 'Active')->get();
        
        return view('admin.member-edit', compact('member', 'trainers', 'memberships', 'packages'));
    }
    
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        // ==========================================
        // CHECK: IS MEMBER ACTIVE?
        // ==========================================
        $isActive = ($member->status == 'Active' && !$member->isExpired());
        
        if ($isActive) {
            // ===== WHEN ACTIVE: ONLY ALLOW PERSONAL INFO, FITNESS INFO & TRAINER =====
            $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|unique:members,email,' . $id,
                'address' => 'nullable|string',
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'goal_type' => 'required',
                'medical_issues' => 'nullable|string',
                'trainer_id' => 'nullable|exists:trainers,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'emergency_contact' => 'nullable|string|max:20',
                'dob' => 'nullable|date',
            ]);
        } else {
            // ===== WHEN EXPIRED/INACTIVE: ALLOW ALL FIELDS =====
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:members,email,' . $id,
                'status' => 'required',
                'payment_type' => 'nullable|in:hand,online',
                'transaction_id' => 'nullable|string|max:100',
                'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'plan_type' => 'nullable|in:membership,package,monthly',
                'membership_plan' => 'nullable',
                'package_name' => 'nullable',
                'join_date' => 'nullable|date',
                'trainer_id' => 'nullable|exists:trainers,id',
                'renewal_amount' => 'nullable|numeric',
            ]);
        }
        
        // ===== CALCULATE BMI =====
        $bmi = $member->bmi;
        if ($request->height && $request->weight) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 1);
        }
        
        // ===== HANDLE PHOTO UPLOAD =====
        $photoPath = $member->photo;
        if ($request->hasFile('photo')) {
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            $photoPath = $request->file('photo')->store('member-photos', 'public');
        }
        
        // ==========================================
        // BASE UPDATE DATA (ALWAYS UPDATED)
        // ==========================================
        $updateData = [
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'age' => $request->age,
            'phone' => $request->phone,
            'address' => $request->address,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $bmi,
            'emergency_contact' => $request->emergency_contact,
            'medical_issues' => $request->medical_issues,
            'goal_type' => $request->goal_type,
            'photo' => $photoPath,
            'trainer_id' => $request->trainer_id,
        ];
        
        // ==========================================
        // IF ACTIVE: DON'T UPDATE LOCKED FIELDS
        // ==========================================
        if ($isActive) {
            // Only update base data (Personal + Fitness + Trainer)
            $member->update($updateData);
            
            return redirect()->route('admin.members')->with('success', 'Personal information updated successfully! ✅');
        }
        
        // ==========================================
        // IF EXPIRED/INACTIVE: UPDATE ALL FIELDS
        // ==========================================
        
        // ===== HANDLE PAYMENT SCREENSHOT UPLOAD =====
        $screenshotPath = $member->payment_screenshot;
        if ($request->hasFile('payment_screenshot')) {
            if ($member->payment_screenshot && Storage::disk('public')->exists($member->payment_screenshot)) {
                Storage::disk('public')->delete($member->payment_screenshot);
            }
            $screenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
        }
        
        // ===== SET PLAN DETAILS =====
        $membershipPlan = $request->membership_plan;
        $membershipDuration = $request->membership_duration;
        $finalPrice = $request->final_price;
        $monthlyMonth = $member->monthly_month;
        $monthlyPrice = $member->monthly_price;
        $expiryDate = $member->expiry_date;
        $oldExpiryDate = $member->expiry_date;
        
        if ($request->plan_type == 'package' && $request->package_name) {
            $package = Package::where('package_name', $request->package_name)->first();
            if ($package) {
                $membershipPlan = $package->package_name;
                $membershipDuration = $package->duration . ' ' . $package->duration_type;
                $finalPrice = $package->price;
                $expiryDate = Carbon::parse($request->join_date)->addMonths((int)$package->duration)->toDateString();
            }
        }
        
        if ($request->plan_type == 'membership' && $request->membership_plan) {
            $membership = Membership::where('plan_name', $request->membership_plan)->first();
            if ($membership) {
                $membershipPlan = $membership->plan_name;
                $membershipDuration = $membership->duration . ' ' . $membership->duration_type;
                $finalPrice = $membership->final_price;
                $expiryDate = Carbon::parse($request->join_date)->addMonths((int)$membership->duration)->toDateString();
            }
        }
        
        if ($request->plan_type == 'monthly') {
            $monthlyMonth = (int)($request->monthly_month ?? $member->monthly_month);
            $monthlyPrice = (float)($request->monthly_price ?? $member->monthly_price);
            $monthlyTotal = $monthlyMonth * $monthlyPrice;
            $membershipPlan = 'Monthly Plan';
            $membershipDuration = $monthlyMonth . ' Month(s)';
            $finalPrice = $monthlyTotal;
            $expiryDate = Carbon::parse($request->join_date)->addMonths($monthlyMonth)->toDateString();
        }
        
        // ===== ADD LOCKED FIELDS TO UPDATE =====
        $updateData['email'] = $request->email;
        $updateData['join_date'] = $request->join_date;
        $updateData['expiry_date'] = $expiryDate;
        $updateData['plan_type'] = $request->plan_type;
        $updateData['membership_plan'] = $membershipPlan;
        $updateData['membership_duration'] = $membershipDuration;
        $updateData['final_price'] = $finalPrice;
        $updateData['status'] = $request->status;
        $updateData['monthly_month'] = $monthlyMonth;
        $updateData['monthly_price'] = $monthlyPrice;
        $updateData['payment_type'] = $request->payment_type;
        $updateData['transaction_id'] = $request->transaction_id;
        $updateData['payment_screenshot'] = $screenshotPath;
        
        // ===== UPDATE MEMBER =====
        $member->update($updateData);
        
        // ==========================================
        // ✅ SAVE PAYMENT HISTORY (ONLY IF RENEWED)
        // ==========================================
        if ($request->status == 'Active' && $oldExpiryDate != $expiryDate && $request->renewal_amount) {
            PaymentHistory::create([
                'member_id' => $member->id,
                'plan_type' => $request->plan_type,
                'plan_name' => $membershipPlan,
                'duration' => $membershipDuration,
                'amount' => $request->renewal_amount ?? $finalPrice,
                'payment_type' => $request->payment_type ?? $member->payment_type,
                'transaction_id' => $request->transaction_id,
                'payment_date' => $request->join_date ?? now(),
                'old_expiry_date' => $oldExpiryDate,
                'new_expiry_date' => $expiryDate,
            ]);
        }
        
        return redirect()->route('admin.members')->with('success', 'Member updated successfully! 🎉');
    }
    
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        if ($member->payment_screenshot) {
            Storage::disk('public')->delete($member->payment_screenshot);
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