<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DietPlan;
use App\Models\DietMeal;
use App\Models\Member;

class DietController extends Controller
{
    public function index()
    {
        $dietPlans = DietPlan::where('trainer_id', session('gym_user_id'))
            ->with(['member', 'meals'])
            ->latest()
            ->get();

        return view('trainer.diet.index', compact('dietPlans'));
    }

    public function create()
    {
        $members = Member::where('trainer_id', session('gym_user_id'))
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('trainer.diet.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',

            'title' => 'required|max:255',
            'goal' => 'nullable|max:255',
            'description' => 'nullable',

            'start_date' => 'required|date',
            'end_date' => 'nullable|date',

            'meals' => 'required|array',
            'meals.*.day' => 'required',
            'meals.*.meal_time' => 'required',
            'meals.*.food_name' => 'required',
        ]);

        foreach ($request->member_ids as $memberId) {

            $diet = DietPlan::create([
                'trainer_id' => session('gym_user_id'),
                'member_id' => $memberId,

                'title' => $request->title,
                'goal' => $request->goal,
                'description' => $request->description,

                'start_date' => $request->start_date,
                'end_date' => $request->end_date,

                'status' => 'Active',
            ]);

            foreach ($request->meals as $meal) {

                DietMeal::create([

                    'diet_plan_id' => $diet->id,

                    'day' => $meal['day'],

                    'meal_time' => $meal['meal_time'],

                    'food_name' => $meal['food_name'],

                    'quantity' => $meal['quantity'] ?? null,

                    'calories' => $meal['calories'] ?? null,

                    'protein' => $meal['protein'] ?? null,

                    'carbs' => $meal['carbs'] ?? null,

                    'fats' => $meal['fats'] ?? null,

                    'notes' => $meal['notes'] ?? null,

                ]);
            }
        }

        return redirect()
            ->route('trainer.diet.index')
            ->with('success', 'Diet Plan Assigned Successfully.');
    }
        public function show($id)
    {
        $diet = DietPlan::where('trainer_id', session('gym_user_id'))
            ->with(['member', 'meals'])
            ->findOrFail($id);

        return view('trainer.diet.show', compact('diet'));
    }

    public function edit($id)
    {
        $diet = DietPlan::where('trainer_id', session('gym_user_id'))
            ->with('meals')
            ->findOrFail($id);

        $members = Member::where('trainer_id', session('gym_user_id'))
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('trainer.diet.edit', compact('diet', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',

            'title' => 'required|max:255',
            'goal' => 'nullable|max:255',
            'description' => 'nullable',

            'start_date' => 'required|date',
            'end_date' => 'nullable|date',

            'meals' => 'required|array',
            'meals.*.day' => 'required',
            'meals.*.meal_time' => 'required',
            'meals.*.food_name' => 'required',
        ]);

        $diet = DietPlan::where('trainer_id', session('gym_user_id'))
            ->findOrFail($id);

        $diet->update([

            'member_id' => $request->member_id,

            'title' => $request->title,

            'goal' => $request->goal,

            'description' => $request->description,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,

        ]);

        DietMeal::where('diet_plan_id', $diet->id)->delete();

        foreach ($request->meals as $meal) {

            DietMeal::create([

                'diet_plan_id' => $diet->id,

                'day' => $meal['day'],

                'meal_time' => $meal['meal_time'],

                'food_name' => $meal['food_name'],

                'quantity' => $meal['quantity'] ?? null,

                'calories' => $meal['calories'] ?? null,

                'protein' => $meal['protein'] ?? null,

                'carbs' => $meal['carbs'] ?? null,

                'fats' => $meal['fats'] ?? null,

                'notes' => $meal['notes'] ?? null,

            ]);
        }

        return redirect()
            ->route('trainer.diet.index')
            ->with('success', 'Diet Plan Updated Successfully.');
    }

    public function destroy($id)
    {
        $diet = DietPlan::where('trainer_id', session('gym_user_id'))
            ->findOrFail($id);

        DietMeal::where('diet_plan_id', $diet->id)->delete();

        $diet->delete();

        return redirect()
            ->route('trainer.diet.index')
            ->with('success', 'Diet Plan Deleted Successfully.');
    }
}