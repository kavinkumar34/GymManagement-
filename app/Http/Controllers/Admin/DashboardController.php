<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Package;
use App\Models\MemberAttendance;
use App\Models\TrainerAttendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // STATISTICS CARDS DATA
        // ==========================================
        
        // Total Members
        $totalMembers = Member::count();
        
        // Active Members
        $activeMembers = Member::where('status', 'Active')->count();
        
        // Total Trainers
        $totalTrainers = Trainer::count();
        
        // Total Memberships
        $totalMemberships = Membership::count();
        
        // Active Memberships
        $activeMemberships = Membership::where('status', 'Active')->count();
        
        // Inactive Memberships
        $inactiveMemberships = Membership::where('status', 'Inactive')->count();
        
        // Total Packages
        $totalPackages = Package::count();
        
        // ==========================================
        // REVENUE CALCULATIONS
        // ==========================================
        
        // Total Revenue from members final_price
        $totalRevenue = Member::sum('final_price') ?? 0;
        
        // Monthly Revenue (current month)
        $monthlyRevenue = Member::whereMonth('join_date', date('m'))
            ->whereYear('join_date', date('Y'))
            ->sum('final_price') ?? 0;
        
        // ==========================================
        // ATTENDANCE DATA
        // ==========================================
        
        // Today's Check-ins (Member Attendance)
        $todayCheckins = MemberAttendance::whereDate('attendance_date', today())
            ->where('status', 'Present')
            ->count();
        
        // Today's Trainer Attendance
        $todayTrainerAttendance = TrainerAttendance::whereDate('attendance_date', today())
            ->where('status', 'Present')
            ->count();
        
        // ==========================================
        // RECENT RECORDS
        // ==========================================
        
        // Latest Members (with trainer relation)
        $recentMembers = Member::with('trainer')
            ->latest()
            ->take(10)
            ->get();
        
        // Latest Trainers
        $recentTrainers = Trainer::latest()
            ->take(5)
            ->get();
        
        // Latest Memberships
        $recentMemberships = Membership::latest()
            ->take(5)
            ->get();
        
        // Latest Packages
        $recentPackages = Package::latest()
            ->take(5)
            ->get();
        
        // ==========================================
        // CHART DATA - Revenue Chart (Last 6 Months)
        // ==========================================
        
        $chartLabels = [];
        $chartRevenue = [];
        $chartTarget = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('M', strtotime("-$i months"));
            $chartLabels[] = $month;
            
            $revenue = Member::whereMonth('join_date', date('m', strtotime("-$i months")))
                ->whereYear('join_date', date('Y', strtotime("-$i months")))
                ->sum('final_price') ?? 0;
            
            $chartRevenue[] = $revenue;
            $chartTarget[] = $revenue * 1.2; // 20% target
        }
        
        // ==========================================
        // CHART DATA - Membership Distribution
        // ==========================================
        
        // Get all membership plans
        $membershipPlans = Membership::select('plan_name', 'id', 'status')->get();
        
        // Count members for each plan using manual query
        $membershipLabels = [];
        $membershipData = [];
        
        foreach ($membershipPlans as $plan) {
            // Count members with this membership plan
            $memberCount = Member::where('membership_plan', $plan->plan_name)->count();
            
            $membershipLabels[] = $plan->plan_name ?? 'N/A';
            $membershipData[] = $memberCount;
            
            // Add percentage to plan object
            $plan->members_count = $memberCount;
        }
        
        // If no membership plans exist, use default data
        if (empty($membershipLabels)) {
            $membershipLabels = ['Basic', 'Standard', 'Premium', 'Pro'];
            $membershipData = [30, 45, 15, 10];
        }
        
        // Calculate percentages for membership plans
        $totalMembersWithPlan = array_sum($membershipData);
        foreach ($membershipPlans as $plan) {
            $plan->percentage = $totalMembersWithPlan > 0 
                ? round(($plan->members_count / $totalMembersWithPlan) * 100, 1) 
                : 0;
        }
        
        // ==========================================
        // RECENT ACTIVITIES
        // ==========================================
        
        $recentActivities = collect();
        
        // Member activities
        $memberActivities = Member::latest()->take(5)->get()->map(function($member) {
            return (object) [
                'type' => 'success',
                'icon' => 'fa-user-plus',
                'description' => "New member <strong>{$member->name}</strong> joined",
                'created_at' => $member->created_at ?? now()
            ];
        });
        
        // Trainer activities
        $trainerActivities = Trainer::latest()->take(5)->get()->map(function($trainer) {
            return (object) [
                'type' => 'info',
                'icon' => 'fa-chalkboard-user',
                'description' => "New trainer <strong>{$trainer->name}</strong> added",
                'created_at' => $trainer->created_at ?? now()
            ];
        });
        
        // Membership activities
        $membershipActivities = Membership::latest()->take(3)->get()->map(function($membership) {
            return (object) [
                'type' => 'warning',
                'icon' => 'fa-id-card',
                'description' => "New membership plan <strong>{$membership->plan_name}</strong> created",
                'created_at' => $membership->created_at ?? now()
            ];
        });
        
        // Merge all activities
        $recentActivities = $memberActivities
            ->merge($trainerActivities)
            ->merge($membershipActivities)
            ->sortByDesc('created_at')
            ->take(10);
        
        // ==========================================
        // UPCOMING RENEWALS
        // ==========================================
        
        $upcomingRenewals = Member::where('status', 'Active')
            ->whereNotNull('membership_plan')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($member) {
                // Calculate days left based on join_date and membership_duration
                $daysLeft = 0;
                if ($member->join_date && $member->membership_duration) {
                    // Parse duration (e.g., "1 Month", "3 Months", "1 Year")
                    $duration = intval($member->membership_duration) ?: 1;
                    $durationType = str_contains($member->membership_duration, 'Year') ? 'year' : 'month';
                    
                    $endDate = \Carbon\Carbon::parse($member->join_date);
                    if ($durationType == 'year') {
                        $endDate->addYears($duration);
                    } else {
                        $endDate->addMonths($duration);
                    }
                    $daysLeft = now()->diffInDays($endDate, false);
                    $daysLeft = max(0, $daysLeft);
                } else {
                    // If no duration, use join_date + 30 days as default
                    if ($member->join_date) {
                        $endDate = \Carbon\Carbon::parse($member->join_date)->addDays(30);
                        $daysLeft = now()->diffInDays($endDate, false);
                        $daysLeft = max(0, $daysLeft);
                    } else {
                        $daysLeft = rand(1, 30); // Random for demo
                    }
                }
                
                return (object) [
                    'name' => $member->name,
                    'membership_plan' => $member->membership_plan ?? 'No plan',
                    'days_left' => $daysLeft
                ];
            });
        
        // ==========================================
        // GROWTH PERCENTAGES (for trends)
        // ==========================================
        
        // Member growth (compare last month vs current month)
        $lastMonthMembers = Member::whereMonth('join_date', date('m', strtotime('-1 month')))
            ->whereYear('join_date', date('Y', strtotime('-1 month')))
            ->count();
        $memberGrowth = $lastMonthMembers > 0 
            ? round((($totalMembers - $lastMonthMembers) / $lastMonthMembers) * 100, 1) 
            : 0;
        
        // Active member growth
        $lastMonthActiveMembers = Member::where('status', 'Active')
            ->whereMonth('updated_at', date('m', strtotime('-1 month')))
            ->count();
        $activeMemberGrowth = $lastMonthActiveMembers > 0 
            ? round((($activeMembers - $lastMonthActiveMembers) / $lastMonthActiveMembers) * 100, 1) 
            : 0;
        
        // Trainer growth
        $lastMonthTrainers = Trainer::whereMonth('join_date', date('m', strtotime('-1 month')))
            ->whereYear('join_date', date('Y', strtotime('-1 month')))
            ->count();
        $trainerGrowth = $lastMonthTrainers > 0 
            ? round((($totalTrainers - $lastMonthTrainers) / $lastMonthTrainers) * 100, 1) 
            : 0;
        
        // Revenue growth
        $lastMonthRevenue = Member::whereMonth('join_date', date('m', strtotime('-1 month')))
            ->whereYear('join_date', date('Y', strtotime('-1 month')))
            ->sum('final_price') ?? 0;
        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) 
            : 0;
        
        // Package growth
        $lastMonthPackages = Package::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->count();
        $packageGrowth = $lastMonthPackages > 0 
            ? round((($totalPackages - $lastMonthPackages) / $lastMonthPackages) * 100, 1) 
            : 0;
        
        // ==========================================
        // PROGRESS PERCENTAGES (for progress bars)
        // ==========================================
        
        // Member progress (assuming 1000 is max target)
        $memberProgress = min(100, round(($totalMembers / 1000) * 100, 1));
        
        // Active member progress (assuming 800 is max target)
        $activeMemberProgress = min(100, round(($activeMembers / 800) * 100, 1));
        
        // Trainer progress (assuming 50 is max target)
        $trainerProgress = min(100, round(($totalTrainers / 50) * 100, 1));
        
        // Revenue progress (assuming ₹50,000 is max target)
        $revenueProgress = min(100, round(($totalRevenue / 50000) * 100, 1));
        
        // Monthly revenue progress (assuming ₹10,000 is max target)
        $monthlyProgress = min(100, round(($monthlyRevenue / 10000) * 100, 1));
        
        // Check-in progress (assuming 50 is max target)
        $checkinProgress = min(100, round(($todayCheckins / 50) * 100, 1));
        
        // ==========================================
        // RETURN VIEW WITH ALL DATA
        // ==========================================
        
        return view('admin.gym-management-dashboard', compact(
            // Statistics
            'totalMembers',
            'activeMembers',
            'totalTrainers',
            'totalMemberships',
            'activeMemberships',
            'inactiveMemberships',
            'totalPackages',
            
            // Revenue
            'totalRevenue',
            'monthlyRevenue',
            
            // Attendance
            'todayCheckins',
            'todayTrainerAttendance',
            
            // Recent Records
            'recentMembers',
            'recentTrainers',
            'recentMemberships',
            'recentPackages',
            
            // Chart Data
            'chartLabels',
            'chartRevenue',
            'chartTarget',
            'membershipPlans',
            'membershipLabels',
            'membershipData',
            
            // Activities
            'recentActivities',
            'upcomingRenewals',
            
            // Growth Percentages
            'memberGrowth',
            'activeMemberGrowth',
            'trainerGrowth',
            'revenueGrowth',
            'packageGrowth',
            
            // Progress Percentages
            'memberProgress',
            'activeMemberProgress',
            'trainerProgress',
            'revenueProgress',
            'monthlyProgress',
            'checkinProgress'
        ));
    }
}