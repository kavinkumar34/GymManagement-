<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\MembershipOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Check if user is logged in via session
     */
    private function checkGymAuth()
    {
        if (!session()->has('gym_user_id')) {
            return redirect()->route('member.trainer.login')
                ->with('error', 'Please login first.');
        }
        return null;
    }

    /**
     * Get current gym user from session
     */
    private function getGymUser()
    {
        return (object) [
            'id' => session('gym_user_id'),
            'name' => session('gym_user_name'),
            'email' => session('gym_user_email'),
            'role' => session('gym_user_role'),
        ];
    }

    // Display Membership Plans
    public function membership()
    {
        // Check auth using session
        if (!session()->has('gym_user_id')) {
            return redirect()->route('member.trainer.login')
                ->with('error', 'Please login first.');
        }

        $memberships = Membership::where('status', 'Active')
            ->orderBy('final_price', 'asc')
            ->paginate(9);

        return view('member.membership', compact('memberships'));
    }

    // Buy Membership - Initiate PayU Payment
// Buy Membership - Initiate PayU Payment
public function buyMembership(Request $request)
{
    // Check auth using session
    if (!session()->has('gym_user_id')) {
        return redirect()->route('member.trainer.login')
            ->with('error', 'Please login first.');
    }

    $request->validate([
        'membership_id' => 'required|exists:memberships,id'
    ]);

    $membership = Membership::findOrFail($request->membership_id);

    if ($membership->status != 'Active') {
        return back()->with('error', 'This membership plan is currently unavailable.');
    }

    // Get user from session
    $userName = session('gym_user_name');
    $userEmail = session('gym_user_email');
    
    // Get member details
    $member = Member::where('email', $userEmail)->first();

    // Generate transaction ID
    $txnId = 'MEM' . time() . rand(1000, 9999);

    // Create order record
    $order = MembershipOrder::create([
        'user_id' => session('gym_user_id'),
        'member_id' => $member ? $member->member_id : null,
        'membership_id' => $membership->id,
        'plan_name' => $membership->plan_name,
        'duration' => $membership->duration,
        'duration_type' => $membership->duration_type,
        'amount' => $membership->final_price,
        'transaction_id' => $txnId,
        'payment_status' => 'PENDING',
        'payer_name' => $userName,
        'payer_email' => $userEmail,
        'payer_phone' => $member ? $member->phone : null,
    ]);

    // PayU Configuration
    $merchantKey = '5FOEb9';
    $merchantSalt = 'Q7wnZax0G4ySOkdHDpW7bb1Zv8KvsGCs';
    $payuUrl = 'https://test.payu.in/_payment';

    // PayU Required Fields
    $txnId = $order->transaction_id;
    $amount = number_format($order->amount, 2, '.', '');
    $productInfo = $membership->plan_name . ' Membership';
    $firstName = $userName;
    $email = $userEmail;
    $phone = $member ? $member->phone : '9999999999';
    $surl = route('member.payment.success');  // ✅ Fixed
    $furl = route('member.payment.failure');  // ✅ Fixed

    // UDF Fields - Important for PayU
    $udf1 = $membership->id;
    $udf2 = session('gym_user_id');
    $udf3 = '';
    $udf4 = '';
    $udf5 = '';

    // Generate Correct Hash - SHA512 with all fields
    $hashString = $merchantKey . '|' . $txnId . '|' . $amount . '|' . $productInfo . '|' . $firstName . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $merchantSalt;
    
    // Hash should be lowercase
    $hash = strtolower(hash('sha512', $hashString));

    // Store order ID in session

    // Return PayU Form View
    return view('member.payu-payment', compact(
        'merchantKey', 'payuUrl', 'txnId', 'amount', 
        'productInfo', 'firstName', 'email', 'phone', 
        'surl', 'furl', 'hash', 'membership',
        'udf1', 'udf2', 'udf3', 'udf4', 'udf5'
    ));
}

    // Payment Success
    public function paymentSuccess(Request $request)
{
    $order = MembershipOrder::where('transaction_id', $request->txnid)->first();

    if (!$order) {
        return redirect()->route('member.membership')
            ->with('error', 'Order not found.');
    }

    // Restore member session
    session([
        'gym_user_id'    => $order->user_id,
        'gym_user_name'  => $order->payer_name,
        'gym_user_email' => $order->payer_email,
        'gym_user_role'  => 'member',
    ]);

    // Payment success
    if ($request->status == 'success' && !empty($request->mihpayid)) {

        $order->payment_status = 'SUCCESS';
        $order->payment_id = $request->mihpayid;
        $order->payment_response = json_encode($request->all());
        $order->save();

        // Activate membership
        $member = Member::where('email', $order->payer_email)->first();

        if ($member) {
            $member->membership_plan = $order->plan_name;
if ($order->duration == 1 && $order->duration_type == 'Months') {
    $member->membership_duration = '1 Month';
} else {
    $member->membership_duration = $order->duration . ' ' . $order->duration_type;
}            $member->save();
        }

        return redirect()->route('member.payment.success.page', $order->id)
            ->with('success', 'Payment Successful! Membership Activated.');
    }

    // Payment failed
    $order->payment_status = 'FAILED';
    $order->payment_response = json_encode($request->all());
    $order->save();

    return redirect()->route('member.membership')
        ->with('error', 'Payment Failed.');
}

    // Payment Failure
  public function paymentFailure(Request $request)
{
    $order = MembershipOrder::where('transaction_id', $request->txnid)->first();

    if ($order) {

        session([
            'gym_user_id'    => $order->user_id,
            'gym_user_name'  => $order->payer_name,
            'gym_user_email' => $order->payer_email,
            'gym_user_role'  => 'member',
        ]);

        $order->payment_status = 'FAILED';
        $order->payment_response = json_encode($request->all());
        $order->save();
    }

    return redirect()->route('member.membership')
        ->with('error', 'Payment Failed.');
}

    // Payment Success Page
    public function paymentSuccessPage($id)
    {
      if (!session()->has('gym_user_id')) {
    return redirect()->route('member.trainer.login');
}

        $order = MembershipOrder::with('membership')->findOrFail($id);
        
        // Check if order belongs to logged-in user
        if ($order->user_id != session('gym_user_id')) {
            abort(403);
        }

        return view('member.payment-success', compact('order'));
    }

    // ============================================ //
    // ASSIGN TRAINER TO MEMBER                     //
    // ============================================ //

    public function assignTrainer($id)
    {
        $member = Member::findOrFail($id);
        $trainers = Trainer::where('status', 'Active')->get();
        
        return view('admin.member-assign-trainer', compact('member', 'trainers'));
    }

    public function storeAssignTrainer(Request $request, $id)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id'
        ]);

        $member = Member::findOrFail($id);
        
        if ($member->trainer_id) {
            $oldTrainer = Trainer::find($member->trainer_id);
            if ($oldTrainer) {
                $oldTrainer->assigned_members = max(0, $oldTrainer->assigned_members - 1);
                $oldTrainer->save();
            }
        }

        $member->trainer_id = $request->trainer_id;
        $member->save();

        $trainer = Trainer::find($request->trainer_id);
        if ($trainer) {
            $trainer->assigned_members = $trainer->members()->count();
            $trainer->save();
        }

        return redirect()->route('admin.members')
            ->with('success', 'Trainer assigned to member successfully!');
    }

    public function removeTrainer($id)
    {
        $member = Member::findOrFail($id);
        
        if ($member->trainer_id) {
            $trainer = Trainer::find($member->trainer_id);
            if ($trainer) {
                $trainer->assigned_members = max(0, $trainer->assigned_members - 1);
                $trainer->save();
            }
        }

        $member->trainer_id = null;
        $member->save();

        return redirect()->route('admin.members')
            ->with('success', 'Trainer removed from member successfully!');
    }
}