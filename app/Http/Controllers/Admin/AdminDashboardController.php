<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total members (both member and trainer roles)
        $totalMembers = User::count();
        
        // Active members (role = 'member')
        $activeMembers = User::where('role', 'member')->count();
        
        // Total trainers
        $totalTrainers = User::where('role', 'trainer')->count();
        
        // Member count
        $memberCount = User::where('role', 'member')->count();
        
        // New members this month
        $newThisMonth = User::whereMonth('created_at', Carbon::now()->month)
                           ->whereYear('created_at', Carbon::now()->year)
                           ->count();
        
        // Recent members (last 5)
        $recentMembers = User::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Last 7 days labels
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $last7Days[] = Carbon::now()->subDays($i)->format('d M');
        }
        
        // Registrations per day for last 7 days
        $registrationsPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = User::whereDate('created_at', $date)->count();
            $registrationsPerDay[] = $count;
        }
        
        return view('admin.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'totalTrainers',
            'memberCount',
            'newThisMonth',
            'recentMembers',
            'last7Days',
            'registrationsPerDay'
        ));
    }
}