<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard Statistics
        $totalMembers = Member::count();

        $totalTrainers = Trainer::count();

        $totalMemberships = Membership::count();

        $activeMemberships = Membership::where('status', 'Active')->count();

        $inactiveMemberships = Membership::where('status', 'Inactive')->count();

        // Latest Members
        $recentMembers = Member::latest()->take(5)->get();

        // Latest Trainers
        $recentTrainers = Trainer::latest()->take(5)->get();

        // Latest Memberships
        $recentMemberships = Membership::latest()->take(5)->get();

        return view('admin.gym-management-dashboard', compact(
            'totalMembers',
            'totalTrainers',
            'totalMemberships',
            'activeMemberships',
            'inactiveMemberships',
            'recentMembers',
            'recentTrainers',
            'recentMemberships'
        ));
    }
}