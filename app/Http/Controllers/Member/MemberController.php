<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Member;      // 👈 Add this
use App\Models\Trainer;     // 👈 Add this
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

        return back()->with('success', 'You have selected "' . $membership->plan_name . '" plan! Proceed to payment.');
    }

    // ============================================ //
    // ASSIGN TRAINER TO MEMBER                     //
    // ============================================ //

    /**
     * Show form to assign trainer to member
     */
    public function assignTrainer($id)
    {
        $member = Member::findOrFail($id);
        $trainers = Trainer::where('status', 'Active')->get();
        
        return view('admin.member-assign-trainer', compact('member', 'trainers'));
    }

    /**
     * Assign trainer to member
     */
    public function storeAssignTrainer(Request $request, $id)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id'
        ]);

        $member = Member::findOrFail($id);
        
        // Check if member already has a trainer
        if ($member->trainer_id) {
            // Remove from old trainer's assigned count
            $oldTrainer = Trainer::find($member->trainer_id);
            if ($oldTrainer) {
                $oldTrainer->assigned_members = max(0, $oldTrainer->assigned_members - 1);
                $oldTrainer->save();
            }
        }

        // Assign new trainer
        $member->trainer_id = $request->trainer_id;
        $member->save();

        // Update trainer's assigned members count
        $trainer = Trainer::find($request->trainer_id);
        if ($trainer) {
            $trainer->assigned_members = $trainer->members()->count();
            $trainer->save();
        }

        return redirect()->route('admin.members')
            ->with('success', 'Trainer assigned to member successfully!');
    }

    /**
     * Remove trainer from member
     */
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