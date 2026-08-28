<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // REVENUE FROM MEMBERSHIPS
        // ==========================================
        $membershipRevenue = Member::where('plan_type', 'membership')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // REVENUE FROM PACKAGES
        // ==========================================
        $packageRevenue = Member::where('plan_type', 'package')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // REVENUE FROM MONTHLY PLANS
        // ==========================================
        $monthlyRevenue = Member::where('plan_type', 'monthly')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // TOTAL REVENUE
        // ==========================================
        $totalRevenue = $membershipRevenue + $packageRevenue + $monthlyRevenue;

        // ==========================================
        // HAND PAYMENT REVENUE
        // ==========================================
        $handPaymentRevenue = Member::where('payment_type', 'hand')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // ONLINE PAYMENT REVENUE
        // ==========================================
        $onlinePaymentRevenue = Member::where('payment_type', 'online')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // HAND PAYMENT BY PLAN TYPE
        // ==========================================
        $handMembership = Member::where('payment_type', 'hand')
            ->where('plan_type', 'membership')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        $handPackage = Member::where('payment_type', 'hand')
            ->where('plan_type', 'package')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        $handMonthly = Member::where('payment_type', 'hand')
            ->where('plan_type', 'monthly')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // ONLINE PAYMENT BY PLAN TYPE
        // ==========================================
        $onlineMembership = Member::where('payment_type', 'online')
            ->where('plan_type', 'membership')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        $onlinePackage = Member::where('payment_type', 'online')
            ->where('plan_type', 'package')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        $onlineMonthly = Member::where('payment_type', 'online')
            ->where('plan_type', 'monthly')
            ->where('status', 'Active')
            ->sum('final_price') ?? 0;

        // ==========================================
        // COUNT BY PLAN TYPE
        // ==========================================
        $membershipCount = Member::where('plan_type', 'membership')
            ->where('status', 'Active')
            ->count();

        $packageCount = Member::where('plan_type', 'package')
            ->where('status', 'Active')
            ->count();

        $monthlyCount = Member::where('plan_type', 'monthly')
            ->where('status', 'Active')
            ->count();

        $totalMembers = Member::where('status', 'Active')->count();

        // ==========================================
        // HAND PAYMENT COUNT
        // ==========================================
        $handCount = Member::where('payment_type', 'hand')
            ->where('status', 'Active')
            ->count();

        // ==========================================
        // ONLINE PAYMENT COUNT
        // ==========================================
        $onlineCount = Member::where('payment_type', 'online')
            ->where('status', 'Active')
            ->count();

        // ==========================================
        // MONTHLY REVENUE CHART DATA (Last 12 Months)
        // ==========================================
        $monthlyLabels = [];
        $monthlyChartData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');

            $revenue = Member::where('status', 'Active')
                ->whereYear('join_date', $month->year)
                ->whereMonth('join_date', $month->month)
                ->sum('final_price') ?? 0;

            $monthlyChartData[] = $revenue;
        }

        // ==========================================
        // MONTHLY HAND VS ONLINE CHART
        // ==========================================
        $monthlyHandData = [];
        $monthlyOnlineData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);

            $hand = Member::where('payment_type', 'hand')
                ->where('status', 'Active')
                ->whereYear('join_date', $month->year)
                ->whereMonth('join_date', $month->month)
                ->sum('final_price') ?? 0;

            $online = Member::where('payment_type', 'online')
                ->where('status', 'Active')
                ->whereYear('join_date', $month->year)
                ->whereMonth('join_date', $month->month)
                ->sum('final_price') ?? 0;

            $monthlyHandData[] = $hand;
            $monthlyOnlineData[] = $online;
        }

        // ==========================================
        // MEMBERS TABLE DATA (WITH PAGINATION)
        // ==========================================
        $members = Member::with('trainer')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.finance-reports', compact(
            'membershipRevenue',
            'packageRevenue',
            'monthlyRevenue',
            'totalRevenue',
            'handPaymentRevenue',
            'onlinePaymentRevenue',
            'handMembership',
            'handPackage',
            'handMonthly',
            'onlineMembership',
            'onlinePackage',
            'onlineMonthly',
            'membershipCount',
            'packageCount',
            'monthlyCount',
            'totalMembers',
            'handCount',
            'onlineCount',
            'monthlyLabels',
            'monthlyChartData',
            'monthlyHandData',
            'monthlyOnlineData',
            'members'
        ));
    }
}