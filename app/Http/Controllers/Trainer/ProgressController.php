<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProgressController extends Controller
{
    // Progress List
    public function index()
    {
        $trainerId = Session::get('gym_user_id');

        $progress = Progress::with('member')
            ->where('trainer_id', $trainerId)
            ->latest()
            ->paginate(10);

        return view('trainer.progress.index', compact('progress'));
    }

    // Add Progress Form
    public function create()
    {
        $trainerId = Session::get('gym_user_id');

        // Show only members assigned to this trainer
        $members = Member::where('trainer_id', $trainerId)
            ->where('status', 1)
            ->get();

        return view('trainer.progress.create', compact('members'));
    }

    // Save Progress
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'progress_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric'
        ]);

        $bmi = $request->weight / (($request->height / 100) * ($request->height / 100));

        $progress = new Progress();

        $progress->trainer_id = Session::get('gym_user_id');
        $progress->member_id = $request->member_id;

        $progress->weight = $request->weight;
        $progress->height = $request->height;
        $progress->bmi = round($bmi, 2);

        $progress->body_fat = $request->body_fat;

        $progress->chest = $request->chest;
        $progress->waist = $request->waist;
        $progress->hips = $request->hips;

        $progress->left_arm = $request->left_arm;
        $progress->right_arm = $request->right_arm;

        $progress->left_thigh = $request->left_thigh;
        $progress->right_thigh = $request->right_thigh;

        $progress->notes = $request->notes;

        $progress->progress_date = $request->progress_date;

        if ($request->hasFile('before_photo')) {
            $progress->before_photo = $request->file('before_photo')
                ->store('progress', 'public');
        }

        if ($request->hasFile('after_photo')) {
            $progress->after_photo = $request->file('after_photo')
                ->store('progress', 'public');
        }

        $progress->save();

        return redirect()
            ->route('trainer.progress.index')
            ->with('success', 'Progress Added Successfully');
    }

    // Edit Form
    public function edit($id)
    {
        $progress = Progress::findOrFail($id);

        $trainerId = Session::get('gym_user_id');

        $members = Member::where('trainer_id', $trainerId)->get();

        return view('trainer.progress.edit', compact('progress', 'members'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $progress = Progress::findOrFail($id);

        $bmi = $request->weight / (($request->height / 100) * ($request->height / 100));

        $progress->member_id = $request->member_id;

        $progress->weight = $request->weight;
        $progress->height = $request->height;
        $progress->bmi = round($bmi, 2);

        $progress->body_fat = $request->body_fat;

        $progress->chest = $request->chest;
        $progress->waist = $request->waist;
        $progress->hips = $request->hips;

        $progress->left_arm = $request->left_arm;
        $progress->right_arm = $request->right_arm;

        $progress->left_thigh = $request->left_thigh;
        $progress->right_thigh = $request->right_thigh;

        $progress->notes = $request->notes;

        $progress->progress_date = $request->progress_date;

        if ($request->hasFile('before_photo')) {
            $progress->before_photo = $request->file('before_photo')
                ->store('progress', 'public');
        }

        if ($request->hasFile('after_photo')) {
            $progress->after_photo = $request->file('after_photo')
                ->store('progress', 'public');
        }

        $progress->save();

        return redirect()
            ->route('trainer.progress.index')
            ->with('success', 'Progress Updated Successfully');
    }

    // Delete
    public function destroy($id)
    {
        Progress::findOrFail($id)->delete();

        return back()->with('success', 'Progress Deleted Successfully');
    }
    public function chart($memberId)
{
    $progress = \App\Models\Progress::where('member_id', $memberId)
        ->orderBy('progress_date', 'ASC')
        ->get();

    $dates = $progress->pluck('progress_date');
    $weights = $progress->pluck('weight');
    $bmis = $progress->pluck('bmi');

    return view('trainer.progress.chart', compact(
        'dates',
        'weights',
        'bmis'
    ));
}
}