<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;

class AssignTrainerController extends Controller
{
 /**
 * Show assign trainer main page - Only Unassigned Members
 */
public function index()
{
    // Show only unassigned members
    $members = Member::with('trainer')
        ->where('status', 'Active')
        ->whereNull('trainer_id')  // 👈 Only unassigned members
        ->orderBy('name', 'asc')
        ->paginate(15);
        
    $trainers = Trainer::where('status', 'Active')
        ->orderBy('name', 'asc')
        ->get();
        
    return view('admin.assign-trainer', compact('members', 'trainers'));
}

    /**
     * Bulk Assign - One Trainer to Multiple Members
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id'
        ]);

        $trainer = Trainer::find($request->trainer_id);
        $memberIds = $request->member_ids;
        $assignedCount = 0;

        foreach ($memberIds as $memberId) {
            $member = Member::find($memberId);
            
            // Skip if already assigned
            if ($member->trainer_id) {
                continue;
            }

            // Assign trainer
            $member->trainer_id = $trainer->id;
            $member->save();
            $assignedCount++;
        }

        // Update trainer's assigned members count
        $trainer->assigned_members = $trainer->members()->count();
        $trainer->save();

        if ($assignedCount > 0) {
            return redirect()->route('admin.assign.trainer.index')
                ->with('success', $assignedCount . ' members assigned to ' . $trainer->name . ' successfully!');
        } else {
            return redirect()->route('admin.assign.trainer.index')
                ->with('error', 'No members were assigned. They may already have trainers.');
        }
    }

    /**
     * Show assign trainer form for specific member (Single Assign)
     */
    public function assignForm($id)
    {
        $member = Member::with('trainer')->findOrFail($id);
        $trainers = Trainer::where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();
            
        return view('admin.assign-trainer-form', compact('member', 'trainers'));
    }

    /**
     * Store trainer assignment (Single Assign)
     */
    public function storeAssign(Request $request, $id)
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

        return redirect()->route('admin.assign.trainer.index')
            ->with('success', 'Trainer assigned to ' . $member->name . ' successfully!');
    }

    /**
     * Remove trainer from member
     */
    public function removeTrainer($id)
    {
        $member = Member::findOrFail($id);
        $memberName = $member->name;
        
        if ($member->trainer_id) {
            $trainer = Trainer::find($member->trainer_id);
            if ($trainer) {
                $trainer->assigned_members = max(0, $trainer->assigned_members - 1);
                $trainer->save();
            }
        }

        $member->trainer_id = null;
        $member->save();

        return redirect()->route('admin.assign.trainer.index')
            ->with('success', 'Trainer removed from ' . $memberName . ' successfully!');
    }

    /**
     * Show assigned members list
     */
    public function assignedList()
    {
        $members = Member::with('trainer')
            ->whereNotNull('trainer_id')
            ->orderBy('name', 'asc')
            ->paginate(15);
            
        return view('admin.assigned-members-list', compact('members'));
    }
}