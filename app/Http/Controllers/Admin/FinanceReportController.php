<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // REVENUE FROM PAYMENT HISTORY (ALL TIME)
        // ==========================================
        $totalRevenue = PaymentHistory::sum('amount') ?? 0;

        // ==========================================
        // REVENUE BY PLAN TYPE
        // ==========================================
        $membershipRevenue = PaymentHistory::where('plan_type', 'membership')->sum('amount') ?? 0;
        $packageRevenue = PaymentHistory::where('plan_type', 'package')->sum('amount') ?? 0;
        $monthlyRevenue = PaymentHistory::where('plan_type', 'monthly')->sum('amount') ?? 0;

        // ==========================================
        // REVENUE BY PAYMENT TYPE
        // ==========================================
        $handPaymentRevenue = PaymentHistory::where('payment_type', 'hand')->sum('amount') ?? 0;
        $onlinePaymentRevenue = PaymentHistory::where('payment_type', 'online')->sum('amount') ?? 0;

        // ==========================================
        // HAND PAYMENT BY PLAN TYPE
        // ==========================================
        $handMembership = PaymentHistory::where('payment_type', 'hand')
            ->where('plan_type', 'membership')
            ->sum('amount') ?? 0;

        $handPackage = PaymentHistory::where('payment_type', 'hand')
            ->where('plan_type', 'package')
            ->sum('amount') ?? 0;

        $handMonthly = PaymentHistory::where('payment_type', 'hand')
            ->where('plan_type', 'monthly')
            ->sum('amount') ?? 0;

        // ==========================================
        // ONLINE PAYMENT BY PLAN TYPE
        // ==========================================
        $onlineMembership = PaymentHistory::where('payment_type', 'online')
            ->where('plan_type', 'membership')
            ->sum('amount') ?? 0;

        $onlinePackage = PaymentHistory::where('payment_type', 'online')
            ->where('plan_type', 'package')
            ->sum('amount') ?? 0;

        $onlineMonthly = PaymentHistory::where('payment_type', 'online')
            ->where('plan_type', 'monthly')
            ->sum('amount') ?? 0;

        // ==========================================
        // COUNT BY PLAN TYPE (From Members Table)
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
        // PAYMENT COUNT BY TYPE (From PaymentHistory)
        // ==========================================
        $handCount = PaymentHistory::where('payment_type', 'hand')
            ->distinct('member_id')
            ->count('member_id');

        $onlineCount = PaymentHistory::where('payment_type', 'online')
            ->distinct('member_id')
            ->count('member_id');

        // ==========================================
        // MONTHLY REVENUE CHART DATA (Last 12 Months)
        // ==========================================
        $monthlyLabels = [];
        $monthlyChartData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');

            $revenue = PaymentHistory::whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount') ?? 0;

            $monthlyChartData[] = $revenue;
        }

        // ==========================================
        // MONTHLY HAND VS ONLINE CHART
        // ==========================================
        $monthlyHandData = [];
        $monthlyOnlineData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);

            $hand = PaymentHistory::where('payment_type', 'hand')
                ->whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount') ?? 0;

            $online = PaymentHistory::where('payment_type', 'online')
                ->whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount') ?? 0;

            $monthlyHandData[] = $hand;
            $monthlyOnlineData[] = $online;
        }

        // ==========================================
        // TODAY, WEEK, MONTH REVENUE
        // ==========================================
        $todayRevenue = PaymentHistory::whereDate('payment_date', today())->sum('amount') ?? 0;
        $weekRevenue = PaymentHistory::whereBetween('payment_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount') ?? 0;
        $monthRevenue = PaymentHistory::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount') ?? 0;

        // ==========================================
        // AVERAGE REVENUE PER MEMBER
        // ==========================================
        $totalMembersAll = Member::count();
        $averagePerMember = $totalMembersAll > 0 
            ? round($totalRevenue / $totalMembersAll, 2) 
            : 0;

        // ==========================================
        // PAYMENT HISTORY TABLE DATA (WITH PAGINATION)
        // ==========================================
        $paymentHistory = PaymentHistory::with('member')
            ->orderBy('created_at', 'desc')
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
            'todayRevenue',
            'weekRevenue',
            'monthRevenue',
            'averagePerMember',
            'paymentHistory'  // ✅ NEW - Payment History with pagination
        ));
    }
}