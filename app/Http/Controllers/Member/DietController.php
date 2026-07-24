<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DietPlan;

class DietController extends Controller
{
    /**
     * Display all diet plans for the logged-in member.
     */
    public function index()
    {
        $dietPlans = DietPlan::where('member_id', session('gym_user_id'))
            ->with(['trainer'])
            ->latest()
            ->get();

        return view('member.diet.index', compact('dietPlans'));
    }

    /**
     * Display the selected diet plan.
     */
    public function show($id)
    {
        $diet = DietPlan::where('member_id', session('gym_user_id'))
            ->with(['trainer', 'meals'])
            ->findOrFail($id);

        return view('member.diet.show', compact('diet'));
    }
}