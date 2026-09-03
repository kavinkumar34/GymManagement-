<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Package;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Razorpay\Api\Api;

class PlanController extends Controller
{
    public function index()
    {
        $memberships = Membership::where('status', 'Active')->paginate(6);
        $packages = Package::where('status', 'Active')->paginate(6);
        return view('member.plans', compact('memberships', 'packages'));
    }

    public function buyPlan(Request $request)
    {
        $request->validate([
            'plan_type' => 'required|in:membership,package',
            'plan_id' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);

        // Get logged-in member
        $member = Member::where('email', session('gym_user_email'))->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found. Please login again.'
            ]);
        }

        // Check if member already has active plan
        if ($member->status == 'Active' && !$member->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active plan. Please wait until it expires to purchase a new plan.'
            ]);
        }

        // Get plan details
        if ($request->plan_type == 'membership') {
            $plan = Membership::find($request->plan_id);
        } else {
            $plan = Package::find($request->plan_id);
        }

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found.'
            ]);
        }

        // Get price based on discount
        if ($request->plan_type == 'membership') {
            $amount = $plan->final_price ?? $plan->price;
        } else {
            $amount = $plan->price;
        }

        // ✅ STORE OLD EXPIRY DATE FOR RENEWAL TRACKING
        $oldExpiryDate = $member->expiry_date;

        // Store plan details in session for later verification
        session([
            'buy_plan_type' => $request->plan_type,
            'buy_plan_id' => $request->plan_id,
            'buy_plan_name' => $plan->plan_name ?? $plan->package_name,
            'buy_amount' => $amount,
            'buy_duration' => $plan->duration ?? 1,
            'buy_duration_type' => $plan->duration_type ?? 'Month(s)',
            'buy_old_expiry_date' => $oldExpiryDate // ✅ Store old expiry date
        ]);

        // Initialize Razorpay
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        // Create Order
        $orderData = [
            'receipt' => 'receipt_' . time(),
            'amount' => $amount * 100, // Amount in paise
            'currency' => 'INR',
            'payment_capture' => 1
        ];

        try {
            $order = $api->order->create($orderData);
            
            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $amount,
                'plan_name' => $plan->plan_name ?? $plan->package_name,
                'key_id' => env('RAZORPAY_KEY_ID'),
                'member_name' => $member->name,
                'member_email' => $member->email,
                'member_phone' => $member->phone
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to create payment order. Please try again.'
            ]);
        }
    }

    public function paymentSuccess(Request $request)
    {
        // ===== LOG EVERYTHING =====
        \Log::info('=== PAYMENT SUCCESS CALLED ===');
        \Log::info('Request Data:', $request->all());
        \Log::info('Session Data:', session()->all());

        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required'
        ]);

        // ===== VERIFY SIGNATURE =====
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        try {
            $attributes = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);
            \Log::info('✅ Payment signature verified successfully');
        } catch (\Exception $e) {
            \Log::error('❌ Payment verification failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ]);
        }

        // ===== GET PLAN DETAILS FROM SESSION =====
        $planType = session('buy_plan_type');
        $planId = session('buy_plan_id');
        $planName = session('buy_plan_name');
        $amount = session('buy_amount');
        $duration = session('buy_duration');
        $durationType = session('buy_duration_type');
        $oldExpiryDate = session('buy_old_expiry_date'); // ✅ Get old expiry date

        \Log::info('Plan Details from Session:', [
            'planType' => $planType,
            'planName' => $planName,
            'amount' => $amount,
            'duration' => $duration,
            'durationType' => $durationType,
            'oldExpiryDate' => $oldExpiryDate
        ]);

        // ===== CHECK SESSION DATA =====
        if (!$planType || !$planName || !$amount) {
            \Log::error('❌ Session data missing!');
            return response()->json([
                'success' => false,
                'message' => 'Session data missing. Please try again.'
            ]);
        }

        // ===== GET MEMBER =====
        $member = Member::where('email', session('gym_user_email'))->first();

        if (!$member) {
            \Log::error('❌ Member not found for email: ' . session('gym_user_email'));
            return response()->json([
                'success' => false,
                'message' => 'Member not found. Please login again.'
            ]);
        }

        \Log::info('✅ Member found: ' . $member->id . ' - ' . $member->name);

        // ===== CALCULATE EXPIRY DATE =====
        $joinDate = now()->toDateString();
        $expiryDate = null;

        if ($durationType == 'Month(s)' || $durationType == 'month' || $durationType == 'Months') {
            $expiryDate = Carbon::parse($joinDate)->addMonths((int)$duration)->toDateString();
        } elseif ($durationType == 'Year(s)' || $durationType == 'year' || $durationType == 'Years') {
            $expiryDate = Carbon::parse($joinDate)->addYears((int)$duration)->toDateString();
        } elseif ($durationType == 'Day(s)' || $durationType == 'day' || $durationType == 'Days') {
            $expiryDate = Carbon::parse($joinDate)->addDays((int)$duration)->toDateString();
        } else {
            $expiryDate = Carbon::parse($joinDate)->addMonths((int)$duration)->toDateString();
        }

        \Log::info('Join Date: ' . $joinDate . ', Expiry Date: ' . $expiryDate);

        // ===== UPDATE MEMBER =====
        try {
            $member->update([
                'plan_type' => $planType,
                'membership_plan' => $planName,
                'membership_duration' => $duration . ' ' . $durationType,
                'final_price' => $amount,
                'join_date' => $joinDate,
                'expiry_date' => $expiryDate,
                'payment_type' => 'online',
                'transaction_id' => $request->razorpay_payment_id,
                'payment_date' => $joinDate,
                'status' => 'Active'
            ]);

            \Log::info('✅ Member updated successfully: ' . $member->id);
        } catch (\Exception $e) {
            \Log::error('❌ Member update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update member: ' . $e->getMessage()
            ]);
        }

        // ==========================================
        // ✅ CHECK IF THIS IS A RENEWAL
        // ==========================================
        // Method 1: Check if old_expiry_date exists in session
        $isRenewal = !is_null($oldExpiryDate);
        
        // Method 2: Check if member has previous payment history
        $previousPayments = PaymentHistory::where('member_id', $member->id)->count();
        if (!$isRenewal && $previousPayments > 0) {
            $isRenewal = true;
        }
        
        \Log::info('Is Renewal: ' . ($isRenewal ? 'YES' : 'NO'));

        // ===== SAVE PAYMENT HISTORY =====
        try {
            PaymentHistory::create([
                'member_id' => $member->id,
                'plan_type' => $planType,
                'plan_name' => $planName,
                'duration' => $duration . ' ' . $durationType,
                'amount' => $amount,
                'payment_type' => 'online',
                'transaction_id' => $request->razorpay_payment_id,
                'payment_date' => $joinDate,
                'join_date' => $joinDate,
                'old_expiry_date' => $oldExpiryDate, // ✅ Set old expiry date
                'new_expiry_date' => $expiryDate      // ✅ Set new expiry date
            ]);

            \Log::info('✅ Payment history created successfully - Renewal: ' . ($isRenewal ? 'YES' : 'NO'));
        } catch (\Exception $e) {
            \Log::error('❌ Payment history creation failed: ' . $e->getMessage());
            // Don't return error here, member is already updated
        }

        // ===== CLEAR SESSION =====
        session()->forget(['buy_plan_type', 'buy_plan_id', 'buy_plan_name', 'buy_amount', 'buy_duration', 'buy_duration_type', 'buy_old_expiry_date']);

        // ===== UPDATE SESSION =====
        session(['gym_user_name' => $member->name]);

        \Log::info('✅ Payment success completed successfully!');

        return response()->json([
            'success' => true,
            'message' => 'Plan purchased successfully!',
            'redirect' => route('member.plans')
        ]);
    }

    public function paymentFailed(Request $request)
    {
        // Clear session
        session()->forget(['buy_plan_type', 'buy_plan_id', 'buy_plan_name', 'buy_amount', 'buy_duration', 'buy_duration_type', 'buy_old_expiry_date']);

        return redirect()->route('member.plans')->with('error', 'Payment failed. Please try again.');
    }
}