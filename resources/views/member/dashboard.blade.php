@extends('layouts.member-layout')

@section('content')
@php
    // Fetch member data - Same as payments.blade.php
    $member = App\Models\Member::where('email', session('gym_user_email'))->first();
    $memberName = $member ? $member->name : session('gym_user_name', 'Guest');
    $trainer = $member ? $member->trainer : null;
    
    // Stats
    $attendanceCount = 0;
    $daysInMonth = now()->daysInMonth;
    if ($member) {
        $attendanceCount = \App\Models\MemberAttendance::where('member_id', $member->id)
            ->whereMonth('attendance_date', now()->month)
            ->whereYear('attendance_date', now()->year)
            ->where('status', 'Present')
            ->count();
    }
    
    $bmi = $member ? $member->bmi : null;
    $weight = $member ? $member->weight : null;
    
    // Today's Workout
    $todayWorkout = null;
    $todayExercises = collect();
    if ($member) {
        $todayWorkout = \App\Models\WorkoutPlan::where('member_id', $member->id)
            ->where('status', 'Active')
            ->whereDate('start_date', '<=', now())
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', now());
            })
            ->first();
        if ($todayWorkout) {
            $todayName = date('l');
            $todayExercises = \App\Models\WorkoutExercise::where('workout_plan_id', $todayWorkout->id)
                ->where('day', $todayName)
                ->orderBy('display_order')
                ->get();
        }
    }
    
    // Today's Diet
    $todayDiet = null;
    $todayMeals = collect();
    if ($member) {
        $todayDiet = \App\Models\DietPlan::where('member_id', $member->id)
            ->where('status', 'Active')
            ->whereDate('start_date', '<=', now())
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', now());
            })
            ->first();
        if ($todayDiet) {
            $todayName = date('l');
            $todayMeals = \App\Models\DietMeal::where('diet_plan_id', $todayDiet->id)
                ->where('day', $todayName)
                ->get();
        }
    }
    
    // Payment Data - Same as payments.blade.php
    $payments = collect();
    if ($member) {
        // Get payment/order details from MembershipOrder
        $payments = \App\Models\MembershipOrder::where('member_id', $member->member_id)
            ->orWhere('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
@endphp

<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <!-- Welcome Card with Trainer Info -->
        <div class="col-12 mb-4">
            <div class="dashboard-welcome-card">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h4 class="welcome-title">
                            Welcome back, {{ $memberName }}! 👋
                        </h4>
                        <p class="welcome-subtitle">Here's your fitness overview for today</p>
                    </div>
                    <div class="welcome-date">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ now()->format('l, d M Y') }}
                    </div>
                </div>
                
                @if ($trainer)
                    <div class="trainer-info-box">
                        <div class="trainer-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="trainer-details">
                            <span class="trainer-label">Your Trainer</span>
                            <span class="trainer-name">{{ $trainer->name }}</span>
                            <span class="trainer-specialization">{{ $trainer->specialization }}</span>
                            <div class="trainer-contact">
                                <span><i class="fas fa-phone me-1"></i> {{ $trainer->phone }}</span>
                                <span><i class="fas fa-envelope me-1"></i> {{ $trainer->email }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="trainer-info-box no-trainer">
                        <div class="trainer-avatar">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <div class="trainer-details">
                            <span class="trainer-label">No Trainer Assigned</span>
                            <span class="trainer-name text-muted">Please contact admin to assign a trainer</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="stat-card memberships">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Membership Status</span>
                    <span class="stat-value {{ $member && $member->status == 'Active' ? 'active' : 'inactive' }}">
                        {{ $member && $member->status == 'Active' ? 'Active' : 'Inactive' }}
                    </span>
                    <span class="stat-sub">Plan: {{ $member ? $member->membership_plan : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="stat-card attendance">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Attendance This Month</span>
                    <span class="stat-value">{{ $attendanceCount }}/{{ $daysInMonth }}</span>
                    <span class="stat-sub">
                        @if($attendanceCount > 0)
                            {{ round(($attendanceCount / $daysInMonth) * 100) }}% attendance
                        @else
                            No attendance recorded
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="stat-card bmi">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-weight"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Current BMI</span>
                    <span class="stat-value">{{ $bmi ?? 'N/A' }}</span>
                    <span class="stat-sub">
                        @if($bmi)
                            @if($bmi < 18.5)
                                Underweight
                            @elseif($bmi >= 18.5 && $bmi < 25)
                                Normal
                            @elseif($bmi >= 25 && $bmi < 30)
                                Overweight
                            @else
                                Obese
                            @endif
                        @else
                            Not calculated
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="stat-card weight">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-weight-scale"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Current Weight</span>
                    <span class="stat-value">{{ $weight ? $weight . ' kg' : 'N/A' }}</span>
                    <span class="stat-sub">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        {{ $member && $member->updated_at ? $member->updated_at->format('d M Y') : 'Never' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Today's Workout & Diet -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="card-title">
                        <i class="fas fa-dumbbell me-2"></i> Today's Workout Plan
                    </h5>
                    <span class="card-date">{{ now()->format('l') }}</span>
                </div>
                <div class="dashboard-card-body">
                    @if($todayExercises && $todayExercises->count() > 0)
                        <ul class="exercise-list">
                            @foreach($todayExercises as $exercise)
                                <li class="exercise-item">
                                    <span class="exercise-icon">🏋️</span>
                                    <div class="exercise-info">
                                        <span class="exercise-name">{{ $exercise->exercise_name }}</span>
                                        <span class="exercise-detail">
                                            {{ $exercise->sets }} sets × {{ $exercise->reps }} reps
                                            @if($exercise->weight)
                                                <span class="badge-weight">{{ $exercise->weight }} kg</span>
                                            @endif
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @elseif($todayWorkout)
                        <div class="empty-state-small">
                            <i class="fas fa-check-circle text-success"></i>
                            <p>No exercises scheduled for today.</p>
                        </div>
                    @else
                        <div class="empty-state-small">
                            <i class="fas fa-calendar-plus"></i>
                            <p>No active workout plan assigned.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="card-title">
                        <i class="fas fa-utensils me-2"></i> Today's Diet Plan
                    </h5>
                    <span class="card-date">{{ now()->format('l') }}</span>
                </div>
                <div class="dashboard-card-body">
                    @if($todayMeals && $todayMeals->count() > 0)
                        <ul class="meal-list">
                            @foreach($todayMeals as $meal)
                                <li class="meal-item">
                                    <span class="meal-time-badge">{{ $meal->meal_time }}</span>
                                    <div class="meal-info">
                                        <span class="meal-name">{{ $meal->food_name }}</span>
                                        <div class="meal-details">
                                            @if($meal->quantity)
                                                <span class="badge-quantity">{{ $meal->quantity }}</span>
                                            @endif
                                            @if($meal->calories)
                                                <span class="badge-calories">{{ $meal->calories }} cal</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @elseif($todayDiet)
                        <div class="empty-state-small">
                            <i class="fas fa-check-circle text-success"></i>
                            <p>No meals scheduled for today.</p>
                        </div>
                    @else
                        <div class="empty-state-small">
                            <i class="fas fa-utensils"></i>
                            <p>No active diet plan assigned.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment History - Same data as payments.blade.php -->
        <div class="col-12 mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="card-title">
                        <i class="fas fa-credit-card me-2"></i> Recent Payments
                    </h5>
                    <a href="{{ route('member.payments.index') }}" class="view-all-link">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="dashboard-card-body p-0">
                    <div class="table-responsive">
                        <table class="payment-table-dashboard">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Plan Type</th>
                                    <th>Plan Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($member)
                                    <!-- Show Member's Current Plan as Payment Info -->
                                    <tr>
                                        <td>
                                            <span class="payment-date">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ $member->created_at ? $member->created_at->format('d M Y') : date('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($member->plan_type == 'membership')
                                                <span class="plan-badge membership">
                                                    <i class="fas fa-id-card me-1"></i> Membership
                                                </span>
                                            @elseif($member->plan_type == 'package')
                                                <span class="plan-badge package">
                                                    <i class="fas fa-box me-1"></i> Package
                                                </span>
                                            @else
                                                <span class="plan-badge none">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="plan-name-badge">
                                                <i class="fas fa-tag me-1"></i> 
                                                {{ $member->membership_plan ?? 'Basic' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="payment-amount">
                                                ₹ {{ number_format($member->final_price ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($member->status == 'Active')
                                                <span class="payment-status paid">
                                                    <i class="fas fa-check-circle me-1"></i> Paid
                                                </span>
                                            @else
                                                <span class="payment-status failed">
                                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <!-- Additional Orders/Payments from MembershipOrder -->
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>
                                                <span class="payment-date">
                                                    <i class="fas fa-calendar-day me-1"></i>
                                                    {{ $payment->created_at->format('d M Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($payment->plan_type == 'membership' || $member->plan_type == 'membership')
                                                    <span class="plan-badge membership">
                                                        <i class="fas fa-id-card me-1"></i> Membership
                                                    </span>
                                                @elseif($payment->plan_type == 'package' || $member->plan_type == 'package')
                                                    <span class="plan-badge package">
                                                        <i class="fas fa-box me-1"></i> Package
                                                    </span>
                                                @else
                                                    <span class="plan-badge none">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="plan-name-badge">
                                                    <i class="fas fa-tag me-1"></i> 
                                                    {{ $payment->plan_name ?? $member->membership_plan }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="payment-amount">
                                                    ₹ {{ number_format($payment->amount ?? $member->final_price, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($payment->payment_status == 'SUCCESS')
                                                    <span class="payment-status paid">
                                                        <i class="fas fa-check-circle me-1"></i> Paid
                                                    </span>
                                                @elseif($payment->payment_status == 'PENDING')
                                                    <span class="payment-status pending">
                                                        <i class="fas fa-clock me-1"></i> Pending
                                                    </span>
                                                @else
                                                    <span class="payment-status failed">
                                                        <i class="fas fa-times-circle me-1"></i> Failed
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="empty-payment">
                                            <i class="fas fa-credit-card fa-2x"></i>
                                            <p>No payment history found.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* WELCOME CARD - Matching Navbar Theme         */
/* ============================================ */
.dashboard-welcome-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.welcome-content {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.welcome-title {
    font-weight: 700;
    font-size: 1.2rem;
    margin: 0;
}

.welcome-subtitle {
    font-size: 0.85rem;
    opacity: 0.8;
    margin: 0;
}

.welcome-date {
    background: rgba(255, 255, 255, 0.15);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

/* ============================================ */
/* TRAINER INFO BOX                             */
/* ============================================ */
.trainer-info-box {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
}

.trainer-info-box.no-trainer {
    background: #fffbeb;
}

.trainer-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.trainer-info-box.no-trainer .trainer-avatar {
    background: #f59e0b;
}

.trainer-details {
    flex: 1;
}

.trainer-label {
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}

.trainer-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0d1b3e;
}

.trainer-specialization {
    font-size: 0.85rem;
    color: #1a2a6c;
    font-weight: 500;
}

.trainer-contact {
    display: flex;
    gap: 16px;
    margin-top: 4px;
    font-size: 0.8rem;
    color: #64748b;
}

.trainer-contact i {
    color: #1a2a6c;
}

/* ============================================ */
/* STAT CARDS                                   */
/* ============================================ */
.stat-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
    border: 1px solid rgba(13, 27, 62, 0.06);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(13, 27, 62, 0.1);
}

.stat-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.stat-card.memberships .stat-icon-wrapper {
    background: #dbeafe;
    color: #1a2a6c;
}

.stat-card.attendance .stat-icon-wrapper {
    background: #dcfce7;
    color: #10b981;
}

.stat-card.bmi .stat-icon-wrapper {
    background: #fef3c7;
    color: #f59e0b;
}

.stat-card.weight .stat-icon-wrapper {
    background: #fce4ec;
    color: #ef4444;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
    display: block;
}

.stat-value {
    font-size: 1.3rem;
    font-weight: 700;
    color: #0d1b3e;
    display: block;
}

.stat-value.active {
    color: #10b981;
}

.stat-value.inactive {
    color: #ef4444;
}

.stat-sub {
    font-size: 0.75rem;
    color: #94a3b8;
}

/* ============================================ */
/* DASHBOARD CARDS                              */
/* ============================================ */
.dashboard-card {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
    border: 1px solid rgba(13, 27, 62, 0.06);
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: 0 8px 25px rgba(13, 27, 62, 0.08);
}

.dashboard-card-header {
    padding: 14px 20px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dashboard-card-header .card-title {
    font-weight: 600;
    font-size: 0.95rem;
    margin: 0;
}

.dashboard-card-header .card-title i {
    color: #ffd54f;
}

.dashboard-card-header .card-date {
    font-size: 0.75rem;
    opacity: 0.8;
    background: rgba(255, 255, 255, 0.15);
    padding: 2px 12px;
    border-radius: 12px;
}

.view-all-link {
    color: #ffd54f;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.view-all-link:hover {
    color: #ffffff;
    transform: translateX(2px);
}

.dashboard-card-body {
    padding: 16px 20px;
}

/* ============================================ */
/* EXERCISE LIST                                */
/* ============================================ */
.exercise-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.exercise-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(13, 27, 62, 0.05);
}

.exercise-item:last-child {
    border-bottom: none;
}

.exercise-icon {
    font-size: 1.2rem;
}

.exercise-info {
    flex: 1;
}

.exercise-name {
    font-weight: 600;
    color: #0d1b3e;
    display: block;
}

.exercise-detail {
    font-size: 0.8rem;
    color: #64748b;
}

.badge-weight {
    display: inline-block;
    padding: 1px 10px;
    background: #dbeafe;
    color: #1a2a6c;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-left: 6px;
}

/* ============================================ */
/* MEAL LIST                                    */
/* ============================================ */
.meal-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.meal-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(13, 27, 62, 0.05);
}

.meal-item:last-child {
    border-bottom: none;
}

.meal-time-badge {
    padding: 3px 12px;
    background: #fef3c7;
    color: #92400e;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
    min-width: 80px;
    text-align: center;
}

.meal-info {
    flex: 1;
}

.meal-name {
    font-weight: 600;
    color: #0d1b3e;
    display: block;
}

.meal-details {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 2px;
}

.badge-quantity {
    display: inline-block;
    padding: 1px 10px;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 500;
}

.badge-calories {
    display: inline-block;
    padding: 1px 10px;
    background: #fef3c7;
    color: #92400e;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* ============================================ */
/* EMPTY STATE SMALL                            */
/* ============================================ */
.empty-state-small {
    text-align: center;
    padding: 20px 10px;
    color: #94a3b8;
}

.empty-state-small i {
    font-size: 2rem;
    display: block;
    margin-bottom: 8px;
}

.empty-state-small i.text-success {
    color: #10b981;
}

.empty-state-small p {
    margin: 0;
    font-size: 0.9rem;
}

/* ============================================ */
/* PAYMENT TABLE - Same as payments.blade.php   */
/* ============================================ */
.payment-table-dashboard {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}

.payment-table-dashboard thead {
    background: #f8fafc;
}

.payment-table-dashboard thead th {
    padding: 10px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #94a3b8;
    letter-spacing: 0.5px;
}

.payment-table-dashboard tbody td {
    padding: 10px 16px;
    border-top: 1px solid rgba(13, 27, 62, 0.05);
    color: #334155;
}

.payment-date {
    color: #0d1b3e;
    font-weight: 500;
    white-space: nowrap;
}

.payment-date i {
    color: #1a2a6c;
}

.payment-amount {
    font-weight: 700;
    color: #0d1b3e;
}

/* Plan Badges - Same as payments.blade.php */
.plan-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.plan-badge.membership {
    background: #dcfce7;
    color: #15803d;
}

.plan-badge.package {
    background: #fef3c7;
    color: #92400e;
}

.plan-badge.none {
    background: #f1f5f9;
    color: #64748b;
}

.plan-name-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: #dbeafe;
    color: #1d4ed8;
    display: inline-flex;
    align-items: center;
}

.plan-name-badge i {
    color: #1d4ed8;
}

.payment-status {
    display: inline-flex;
    align-items: center;
    padding: 3px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.payment-status.paid {
    background: #dcfce7;
    color: #15803d;
}

.payment-status.paid i {
    color: #10b981;
}

.payment-status.pending {
    background: #fef3c7;
    color: #92400e;
}

.payment-status.pending i {
    color: #f59e0b;
}

.payment-status.failed {
    background: #fef2f2;
    color: #991b1b;
}

.payment-status.failed i {
    color: #ef4444;
}

.empty-payment {
    text-align: center;
    padding: 30px 20px !important;
    color: #94a3b8;
}

.empty-payment i {
    display: block;
    margin-bottom: 8px;
}

.empty-payment p {
    margin: 0;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .welcome-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .trainer-contact {
        flex-direction: column;
        gap: 4px;
    }
}

@media (max-width: 768px) {
    .welcome-title {
        font-size: 1rem;
    }
    
    .welcome-date {
        font-size: 0.75rem;
        padding: 4px 12px;
    }
    
    .trainer-info-box {
        flex-direction: column;
        text-align: center;
        padding: 12px 16px;
    }
    
    .trainer-contact {
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }
    
    .stat-card {
        padding: 14px 16px;
    }
    
    .stat-value {
        font-size: 1.1rem;
    }
    
    .dashboard-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        padding: 12px 16px;
    }
    
    .dashboard-card-body {
        padding: 12px 16px;
    }
    
    .meal-time-badge {
        min-width: 60px;
        font-size: 0.65rem;
        padding: 2px 8px;
    }
    
    .payment-table-dashboard {
        font-size: 0.75rem;
    }
    
    .payment-table-dashboard thead th,
    .payment-table-dashboard tbody td {
        padding: 6px 10px;
    }
}

@media (max-width: 480px) {
    .stat-card {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }
    
    .stat-icon-wrapper {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .stat-value {
        font-size: 1rem;
    }
    
    .exercise-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .meal-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .meal-time-badge {
        min-width: unset;
        width: 100%;
    }
    
    .payment-table-dashboard {
        font-size: 0.65rem;
    }
    
    .payment-table-dashboard thead th,
    .payment-table-dashboard tbody td {
        padding: 4px 6px;
    }
    
    .payment-status {
        font-size: 0.6rem;
        padding: 2px 8px;
    }
    
    .plan-name-badge {
        font-size: 0.65rem;
        padding: 2px 10px;
    }
    
    .plan-badge {
        font-size: 0.6rem;
        padding: 2px 8px;
    }
}

/* ============================================ */
/* ANIMATIONS                                   */
/* ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.4s ease forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.2s; }

.dashboard-card {
    animation: fadeInUp 0.4s ease forwards;
}

.dashboard-card:nth-child(1) { animation-delay: 0.1s; }
.dashboard-card:nth-child(2) { animation-delay: 0.15s; }
</style>
@endsection