<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    // Display Membership Plans
    public function membership()
    {
        $memberships = Membership::where('status', 'Active')
            ->orderBy('final_price', 'asc')
            ->paginate(9);

        return view('member.membership', compact('memberships'));
    }

    // Buy Membership
    public function buyMembership(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id'
        ]);

        $membership = Membership::findOrFail($request->membership_id);

        if ($membership->status != 'Active') {
            return back()->with('error', 'This membership plan is currently unavailable.');
        }

        // Here you can add logic for:
        // 1. Check if user already has active membership
        // 2. Create order/payment record
        // 3. Redirect to payment gateway (Razorpay/PayPal/etc)
        // 4. Update user's membership

        // For now, just show success message
        return back()->with('success', 'You have selected "' . $membership->plan_name . '" plan! Proceed to payment.');
    }
}