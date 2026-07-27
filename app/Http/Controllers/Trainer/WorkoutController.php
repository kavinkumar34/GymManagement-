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

        $trainerId = session('gym_user_id');
        $workouts = WorkoutPlan::where('trainer_id', $trainerId)
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

            'days' => 'required|array|min:1',
            'days.*.day' => 'required|string',

            'days.*.exercises' => 'required|array|min:1',

            'days.*.exercises.*.exercise_name' => 'required|string|max:255',
            'days.*.exercises.*.sets' => 'nullable|integer|min:1',
            'days.*.exercises.*.reps' => 'nullable|string|max:100',
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

                $displayOrder = 0;

                foreach ($request->days as $day) {
                    foreach ($day['exercises'] as $exercise) {
                        WorkoutExercise::create([
                            'workout_plan_id' => $workout->id,
                            'day' => $day['day'],
                            'exercise_name' => $exercise['exercise_name'],
                            'sets' => $exercise['sets'] ?? null,
                            'reps' => $exercise['reps'] ?? null,
                            'weight' => $exercise['weight'] ?? null,
                            'rest_time' => $exercise['rest_time'] ?? null,
                            // 'exercise_image' => $exercise['exercise_image'] ?? null, // REMOVED
                            'exercise_video' => $exercise['exercise_video'] ?? null,
                            'trainer_notes' => $exercise['trainer_notes'] ?? null,
                            'display_order' => $displayOrder++,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('trainer.workout.index')
                ->with('success', 'Workout created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
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
        $workout = WorkoutPlan::where('trainer_id', session('gym_user_id'))
            ->findOrFail($id);

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'days' => 'required|array|min:1',
            'days.*.day' => 'required|string',
            'days.*.exercises' => 'required|array|min:1',
            'days.*.exercises.*.exercise_name' => 'required|string|max:255',
            'days.*.exercises.*.sets' => 'nullable|integer|min:1',
            'days.*.exercises.*.reps' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Update workout
            $workout->update([
                'member_id'   => $request->member_id,
                'title'       => $request->title,
                'description' => $request->description,
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date,
            ]);

            // Delete old exercises
            WorkoutExercise::where('workout_plan_id', $workout->id)->delete();

            $displayOrder = 0;

            foreach ($request->days as $day) {
                foreach ($day['exercises'] as $exercise) {
                    WorkoutExercise::create([
                        'workout_plan_id' => $workout->id,
                        'day' => $day['day'],
                        'exercise_name' => $exercise['exercise_name'],
                        'sets' => $exercise['sets'] ?? null,
                        'reps' => $exercise['reps'] ?? null,
                        'weight' => $exercise['weight'] ?? null,
                        'rest_time' => $exercise['rest_time'] ?? null,
                        // 'exercise_image' => $exercise['exercise_image'] ?? null, // REMOVED
                        'exercise_video' => $exercise['exercise_video'] ?? null,
                        'trainer_notes' => $exercise['trainer_notes'] ?? null,
                        'display_order' => $displayOrder++,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('trainer.workout.index')
                ->with('success', 'Workout plan updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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