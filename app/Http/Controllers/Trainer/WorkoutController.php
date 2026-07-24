<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkoutPlan;
use App\Models\WorkoutExercise;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    public function index()
    {
if (
    !session()->has('gym_user_id') ||
    session('gym_user_role') != 'trainer'
) {
    return redirect()->route('member.trainer.login');
}

$trainerId = session('gym_user_id');        $workouts = WorkoutPlan::where('trainer_id', $trainerId)
            ->with(['member', 'exercises'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('trainer.workout.index', compact('workouts'));
    }

public function create()
{
    if (
        !session()->has('gym_user_id') ||
        session('gym_user_role') != 'trainer'
    ) {
        return redirect()->route('member.trainer.login');
    }

    $trainerId = session('gym_user_id');

    $members = Member::where('trainer_id', $trainerId)
        ->orderBy('name')
        ->get();

    return view('trainer.workout.create', compact('members'));
}

  public function store(Request $request)
{
    $request->validate([
        'member_ids' => 'required|array|min:1',
        'member_ids.*' => 'exists:members,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'exercises' => 'required|array|min:1',
        'exercises.*.day' => 'required',
        'exercises.*.exercise_name' => 'required|string',
        'exercises.*.sets' => 'required|integer|min:1',
        'exercises.*.reps' => 'required|string',
    ]);

    DB::beginTransaction();

    try {

        foreach ($request->member_ids as $memberId) {

            $workout = WorkoutPlan::create([
                'trainer_id' => session('gym_user_id'),
                'member_id' => $memberId,
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'Active'
            ]);

            foreach ($request->exercises as $index => $exercise) {

                WorkoutExercise::create([
                    'workout_plan_id' => $workout->id,
                    'day' => $exercise['day'],
                    'exercise_name' => $exercise['exercise_name'],
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                    'weight' => $exercise['weight'],
                    'rest_time' => $exercise['rest_time'],
                    'exercise_image' => $exercise['exercise_image'],
                    'exercise_video' => $exercise['exercise_video'],
                    'trainer_notes' => $exercise['trainer_notes'],
                    'display_order' => $index,
                ]);
            }
        }

        DB::commit();

        return redirect()->route('trainer.workout.index')
            ->with('success', 'Workout created successfully.');

    } catch (\Exception $e) {

        DB::rollBack();

        dd($e->getMessage(), $e->getTraceAsString());

    }
}

    public function show($id)
    {
        $workout = WorkoutPlan::with(['member', 'exercises'])
->where('trainer_id', session('gym_user_id'))
            ->findOrFail($id);
        
        return view('trainer.workout.show', compact('workout'));
    }

    public function edit($id)
    {
        $workout = WorkoutPlan::with('exercises')
->where('trainer_id', session('gym_user_id'))
            ->findOrFail($id);
        
        $members = Member::where('trainer_id', session('gym_user_id'))->get();
        
        return view('trainer.workout.edit', compact('workout', 'members'));
    }

    public function update(Request $request, $id)
    {
        $workout = WorkoutPlan::where('trainer_id', session('gym_user_id'))->findOrFail($id);

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'exercises' => 'required|array|min:1',
        ]);

        $workout->update([
            'member_id' => $request->member_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Delete old exercises
        WorkoutExercise::where('workout_plan_id', $workout->id)->delete();

        // Add new exercises
        foreach ($request->exercises as $index => $exercise) {
            WorkoutExercise::create([
                'workout_plan_id' => $workout->id,
                'day' => $exercise['day'],
                'exercise_name' => $exercise['exercise_name'],
                'sets' => $exercise['sets'],
                'reps' => $exercise['reps'],
                'weight' => $exercise['weight'] ?? null,
                'rest_time' => $exercise['rest_time'] ?? '60 sec',
                'exercise_image' => $exercise['exercise_image'] ?? null,
                'exercise_video' => $exercise['exercise_video'] ?? null,
                'trainer_notes' => $exercise['trainer_notes'] ?? null,
                'display_order' => $index
            ]);
        }

        return redirect()->route('trainer.workout.index')
            ->with('success', 'Workout plan updated successfully!');
    }

    public function destroy($id)
    {
        $workout = WorkoutPlan::where('trainer_id', session('gym_user_id'))->findOrFail($id);
        WorkoutExercise::where('workout_plan_id', $workout->id)->delete();
        $workout->delete();

        return redirect()->route('trainer.workout.index')
            ->with('success', 'Workout plan deleted successfully!');
    }
}