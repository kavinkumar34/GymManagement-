@extends('layouts.admin-layout')

@section('title','Gym Management Dashboard')

@section('content')

<div class="admin-main-content">

    <div class="container-fluid">

        <!-- ===========================================
                    DASHBOARD HEADER
        ============================================ -->

        <div class="dashboard-header mb-4">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h2 class="fw-bold mb-2">

                        <i class="fas fa-dumbbell text-warning"></i>

                        Gym Management Dashboard

                    </h2>

                    <p class="text-muted mb-0">

                        Welcome back Admin 👋

                        Manage your gym members, trainers,
                        memberships and revenue from one place.

                    </p>

                </div>

                <div class="col-lg-4 text-end">

                    <span class="badge bg-success p-3 fs-6">

                        <i class="fas fa-calendar"></i>

                        {{ now()->format('d M Y') }}

                    </span>

                </div>

            </div>

        </div>

        <!-- ===========================================
                    QUICK ACTIONS - TOP SECTION (UNIQUE LIGHT DESIGN)
        ============================================ -->

        <div class="quick-actions-wrapper mb-4">

            <div class="quick-actions-card">

                <div class="quick-actions-header">

                    <h5 class="fw-bold mb-0">

                        <i class="fas fa-bolt text-warning me-2"></i>

                        Quick Actions

                    </h5>

                    <span class="quick-actions-badge">

                        <i class="fas fa-clock"></i> Instant Access

                    </span>

                </div>

                <div class="quick-actions-body">

                    <div class="quick-action-item">

                        <a href="{{ route('admin.member.create') }}" class="quick-action-btn primary">

                            <div class="quick-action-icon">

                                <i class="fas fa-user-plus"></i>

                            </div>

                            <div class="quick-action-text">

                                <span class="action-title">Add Member</span>

                                <span class="action-sub">Register new member</span>

                            </div>

                            <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>

                        </a>

                    </div>

                    <div class="quick-action-item">

                        <a href="{{ route('admin.trainer.create') }}" class="quick-action-btn success">

                            <div class="quick-action-icon">

                                <i class="fas fa-user-tie"></i>

                            </div>

                            <div class="quick-action-text">

                                <span class="action-title">Add Trainer</span>

                                <span class="action-sub">Hire new trainer</span>

                            </div>

                            <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>

                        </a>

                    </div>

                    <div class="quick-action-item">

                        <a href="{{ route('admin.membership.create') }}" class="quick-action-btn warning">

                            <div class="quick-action-icon">

                                <i class="fas fa-id-card"></i>

                            </div>

                            <div class="quick-action-text">

                                <span class="action-title">Membership</span>

                                <span class="action-sub">Create new plan</span>

                            </div>

                            <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>

                        </a>

                    </div>

                    <div class="quick-action-item">

                        <a href="{{ route('admin.package.create') }}" class="quick-action-btn danger">

                            <div class="quick-action-icon">

                                <i class="fas fa-box-open"></i>

                            </div>

                            <div class="quick-action-text">

                                <span class="action-title">Add Package</span>

                                <span class="action-sub">Create new package</span>

                            </div>

                            <span class="action-arrow"><i class="fas fa-arrow-right"></i></span>

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- ===========================================
                    STATISTICS CARDS (ALL CLICKABLE)
        ============================================ -->

        <div class="row">

            <!-- Total Members -> Member List -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card blue clickable-card" onclick="window.location.href='{{ route('admin.member.index') }}'">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6>Total Members</h6>
                        <h2>{{ $totalMembers }}</h2>
                        <small>
                            {{ $memberGrowth }}%
                            Growth
                        </small>
                    </div>
                </div>
            </div>

            <!-- Active Members -> Filter Active Members -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card green clickable-card" onclick="window.location.href='{{ route('admin.member.index', ['status' => 'Active']) }}'">
                    <div class="card-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <h6>Active Members</h6>
                        <h2>{{ $activeMembers }}</h2>
                        <small>
                            {{ $activeMemberGrowth }}%
                            Growth
                        </small>
                    </div>
                </div>
            </div>

            <!-- Total Trainers -> Trainer List -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card orange clickable-card" onclick="window.location.href='{{ route('admin.trainer.index') }}'">
                    <div class="card-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h6>Total Trainers</h6>
                        <h2>{{ $totalTrainers }}</h2>
                        <small>
                            {{ $trainerGrowth }}%
                            Growth
                        </small>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -> Payment Page -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card purple clickable-card" onclick="window.location.href='{{ route('admin.hand.payment') }}'">
                    <div class="card-icon">
                        <i class="fas fa-indian-rupee-sign"></i>
                    </div>
                    <div>
                        <h6>Total Revenue</h6>
                        <h2>
                            ₹{{ number_format($totalRevenue,2) }}
                        </h2>
                        <small>
                            {{ $revenueGrowth }}%
                            Growth
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <!-- SECOND ROW -->

        <div class="row">

            <!-- Membership Plans -> Membership List -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card dark clickable-card" onclick="window.location.href='{{ route('admin.membership.index') }}'">
                    <div class="card-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <h6>Membership Plans</h6>
                        <h2>{{ $totalMemberships }}</h2>
                    </div>
                </div>
            </div>

            <!-- Total Packages -> Package List -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card red clickable-card" onclick="window.location.href='{{ route('admin.package.index') }}'">
                    <div class="card-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <h6>Total Packages</h6>
                        <h2>{{ $totalPackages }}</h2>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue -> Payment Page -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card cyan clickable-card" onclick="window.location.href='{{ route('admin.hand.payment') }}'">
                    <div class="card-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <h6>Monthly Revenue</h6>
                        <h2>
                            ₹{{ number_format($monthlyRevenue,2) }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Today's Check-in -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card teal">
                    <div class="card-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6>Today's Check-in</h6>
                        <h2>
                            {{ $todayCheckins }}
                        </h2>
                    </div>
                </div>
            </div>

        </div>

        <style>

        .dashboard-header{

        background:#fff;

        padding:25px;

        border-radius:15px;

        box-shadow:0 5px 20px rgba(0,0,0,.08);

        margin-bottom:25px;

        }

        .dashboard-card{

        display:flex;

        align-items:center;

        justify-content:space-between;

        padding:25px;

        border-radius:18px;

        color:#fff;

        transition:.3s;

        box-shadow:0 10px 30px rgba(0,0,0,.1);

        }

        .dashboard-card:hover{

        transform:translateY(-8px);

        }

        .dashboard-card h6{

        font-size:15px;

        margin-bottom:8px;

        opacity:.9;

        }

        .dashboard-card h2{

        font-size:32px;

        font-weight:700;

        margin-bottom:5px;

        }

        .card-icon{

        width:70px;

        height:70px;

        border-radius:50%;

        background:rgba(255,255,255,.2);

        display:flex;

        justify-content:center;

        align-items:center;

        font-size:28px;

        }

        /* Clickable Card Style */
        .clickable-card {
            cursor: pointer;
            position: relative;
        }

        .clickable-card::after {
            content: '\f054';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 12px;
            right: 16px;
            font-size: 12px;
            opacity: 0;
            transition: all 0.3s ease;
            color: rgba(255,255,255,0.7);
        }

        .clickable-card:hover::after {
            opacity: 1;
            transform: translateX(3px);
        }

        .clickable-card:active {
            transform: scale(0.97);
        }

        .blue{

        background:linear-gradient(135deg,#4facfe,#00f2fe);

        }

        .green{

        background:linear-gradient(135deg,#43e97b,#38f9d7);

        }

        .orange{

        background:linear-gradient(135deg,#fa709a,#fee140);

        }

        .purple{

        background:linear-gradient(135deg,#6a11cb,#2575fc);

        }

        .dark{

        background:linear-gradient(135deg,#232526,#414345);

        }

        .red{

        background:linear-gradient(135deg,#ff512f,#dd2476);

        }

        .cyan{

        background:linear-gradient(135deg,#00c6ff,#0072ff);

        }

        .teal{

        background:linear-gradient(135deg,#11998e,#38ef7d);

        }

        /* ============================================================
                    QUICK ACTIONS - UNIQUE LIGHT DESIGN
        ============================================================ */

        .quick-actions-wrapper {

            padding: 0;

        }

        .quick-actions-card {

            background: #ffffff;

            border-radius: 18px;

            box-shadow: 0 5px 25px rgba(0,0,0,0.06);

            border: 1px solid rgba(0,0,0,0.04);

            overflow: hidden;

            transition: all 0.3s ease;

        }

        .quick-actions-card:hover {

            box-shadow: 0 8px 35px rgba(0,0,0,0.10);

        }

        .quick-actions-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 18px 28px;

            background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%);

            border-bottom: 1px solid rgba(0,0,0,0.04);

        }

        .quick-actions-header h5 {

            font-size: 1.1rem;

            color: #1a1a2e;

        }

        .quick-actions-header h5 i {

            color: #f59e0b;

        }

        .quick-actions-badge {

            background: linear-gradient(135deg, #fef3c7, #fde68a);

            color: #92400e;

            padding: 5px 16px;

            border-radius: 50px;

            font-size: 0.75rem;

            font-weight: 600;

            letter-spacing: 0.3px;

        }

        .quick-actions-badge i {

            margin-right: 5px;

        }

        .quick-actions-body {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 0;

            padding: 8px;

        }

        .quick-action-item {

            padding: 4px;

        }

        .quick-action-btn {

            display: flex;

            align-items: center;

            gap: 16px;

            padding: 16px 20px;

            border-radius: 14px;

            text-decoration: none;

            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            background: #f8fafc;

            border: 1px solid transparent;

            position: relative;

            overflow: hidden;

        }

        .quick-action-btn::before {

            content: '';

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            bottom: 0;

            opacity: 0;

            transition: all 0.4s ease;

            border-radius: 14px;

        }

        .quick-action-btn:hover {

            transform: translateY(-3px);

            box-shadow: 0 8px 25px rgba(0,0,0,0.10);

        }

        .quick-action-btn:hover::before {

            opacity: 1;

        }

        .quick-action-btn:hover .action-arrow {

            transform: translateX(5px);

            opacity: 1;

        }

        .quick-action-btn.primary {

            background: linear-gradient(135deg, #eff6ff, #dbeafe);

            border-color: rgba(37, 99, 235, 0.15);

        }

        .quick-action-btn.primary:hover {

            background: linear-gradient(135deg, #dbeafe, #bfdbfe);

            border-color: #3b82f6;

            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.20);

        }

        .quick-action-btn.primary .quick-action-icon {

            background: linear-gradient(135deg, #3b82f6, #2563eb);

            color: white;

        }

        .quick-action-btn.success {

            background: linear-gradient(135deg, #ecfdf5, #d1fae5);

            border-color: rgba(34, 197, 94, 0.15);

        }

        .quick-action-btn.success:hover {

            background: linear-gradient(135deg, #d1fae5, #a7f3d0);

            border-color: #22c55e;

            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.20);

        }

        .quick-action-btn.success .quick-action-icon {

            background: linear-gradient(135deg, #22c55e, #16a34a);

            color: white;

        }

        .quick-action-btn.warning {

            background: linear-gradient(135deg, #fffbeb, #fef3c7);

            border-color: rgba(245, 158, 11, 0.15);

        }

        .quick-action-btn.warning:hover {

            background: linear-gradient(135deg, #fef3c7, #fde68a);

            border-color: #f59e0b;

            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.20);

        }

        .quick-action-btn.warning .quick-action-icon {

            background: linear-gradient(135deg, #f59e0b, #d97706);

            color: white;

        }

        .quick-action-btn.danger {

            background: linear-gradient(135deg, #fef2f2, #fecaca);

            border-color: rgba(239, 68, 68, 0.15);

        }

        .quick-action-btn.danger:hover {

            background: linear-gradient(135deg, #fecaca, #fca5a5);

            border-color: #ef4444;

            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.20);

        }

        .quick-action-btn.danger .quick-action-icon {

            background: linear-gradient(135deg, #ef4444, #dc2626);

            color: white;

        }

        .quick-action-icon {

            width: 48px;

            height: 48px;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            flex-shrink: 0;

            transition: all 0.3s ease;

        }

        .quick-action-btn:hover .quick-action-icon {

            transform: scale(1.05) rotate(-3deg);

        }

        .quick-action-text {

            flex: 1;

            min-width: 0;

        }

        .action-title {

            display: block;

            font-weight: 700;

            font-size: 0.95rem;

            color: #1a1a2e;

            letter-spacing: 0.2px;

        }

        .action-sub {

            display: block;

            font-size: 0.75rem;

            color: #6b7280;

            font-weight: 500;

            margin-top: 2px;

        }

        .action-arrow {

            color: #9ca3af;

            font-size: 0.85rem;

            transition: all 0.3s ease;

            opacity: 0.5;

            flex-shrink: 0;

        }

        .quick-action-btn:hover .action-arrow {

            opacity: 1;

        }

        /* Responsive Quick Actions */

        @media (max-width: 1200px) {

            .quick-actions-body {

                grid-template-columns: repeat(2, 1fr);

            }

        }

        @media (max-width: 576px) {

            .quick-actions-body {

                grid-template-columns: 1fr;

            }

            .quick-actions-header {

                flex-direction: column;

                gap: 8px;

                text-align: center;

                padding: 15px 20px;

            }

            .quick-action-btn {

                padding: 14px 16px;

            }

            .quick-action-icon {

                width: 40px;

                height: 40px;

                font-size: 16px;

            }

            .action-title {

                font-size: 0.85rem;

            }

        }

        </style>

        {{-- ===========================================
                CHART SECTION
        =========================================== --}}

        <div class="row mt-4">

            <!-- Revenue Chart -->

            <div class="col-lg-8 mb-4">

                <div class="card border-0 shadow-lg rounded-4">

                    <div class="card-header bg-white border-0 py-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <h5 class="fw-bold mb-0">

                                <i class="fas fa-chart-line text-primary me-2"></i>

                                Revenue Overview

                            </h5>

                            <span class="badge bg-success">

                                Last 6 Months

                            </span>

                        </div>

                    </div>

                    <div class="card-body">

                        <canvas id="revenueChart" height="120"></canvas>

                    </div>

                </div>

            </div>

            <!-- Membership Distribution -->

            <div class="col-lg-4 mb-4">

                <div class="card border-0 shadow-lg rounded-4">

                    <div class="card-header bg-white border-0 py-3">

                        <h5 class="fw-bold mb-0">

                            <i class="fas fa-chart-pie text-danger me-2"></i>

                            Membership Distribution

                        </h5>

                    </div>

                    <div class="card-body">

                        <canvas id="membershipChart" height="220"></canvas>

                        <hr>

                        @foreach($membershipPlans as $plan)

                            <div class="d-flex justify-content-between mb-3">

                                <div>

                                    <strong>{{ $plan->plan_name }}</strong>

                                </div>

                                <span class="badge bg-primary">

                                    {{ $plan->members_count }}

                                    Members

                                </span>

                            </div>

                            <div class="progress mb-3" style="height:8px;">

                                <div class="progress-bar bg-success"

                                     style="width: {{ $plan->percentage }}%">

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        {{-- ===========================================
                PROGRESS CARDS
        =========================================== --}}

        <div class="row">

            <div class="col-lg-4 mb-4">

                <div class="card border-0 shadow rounded-4">

                    <div class="card-body">

                        <h6 class="fw-bold">

                            Member Target

                        </h6>

                        <h3>

                            {{ $memberProgress }}%

                        </h3>

                        <div class="progress mt-3">

                            <div class="progress-bar bg-primary"

                                style="width: {{ $memberProgress }}%">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <div class="card border-0 shadow rounded-4">

                    <div class="card-body">

                        <h6 class="fw-bold">

                            Revenue Target

                        </h6>

                        <h3>

                            {{ $revenueProgress }}%

                        </h3>

                        <div class="progress mt-3">

                            <div class="progress-bar bg-success"

                                style="width: {{ $revenueProgress }}%">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 mb-4">

                <div class="card border-0 shadow rounded-4">

                    <div class="card-body">

                        <h6 class="fw-bold">

                            Today's Attendance

                        </h6>

                        <h3>

                            {{ $checkinProgress }}%

                        </h3>

                        <div class="progress mt-3">

                            <div class="progress-bar bg-warning"

                                style="width: {{ $checkinProgress }}%">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ===========================================
                CHART JS
        =========================================== --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

        const revenueChart = new Chart(

        document.getElementById('revenueChart'),

        {

        type:'line',

        data:{

        labels:@json($chartLabels),

        datasets:[

        {

        label:'Revenue',

        data:@json($chartRevenue),

        borderColor:'#2563eb',

        backgroundColor:'rgba(37,99,235,.15)',

        fill:true,

        tension:.4

        },

        {

        label:'Target',

        data:@json($chartTarget),

        borderColor:'#22c55e',

        borderDash:[6,6],

        fill:false,

        tension:.4

        }

        ]

        },

        options:{

        responsive:true,

        plugins:{

        legend:{

        position:'top'

        }

        }

        }

        }

        );

        const membershipChart = new Chart(

        document.getElementById('membershipChart'),

        {

        type:'doughnut',

        data:{

        labels:@json($membershipLabels),

        datasets:[{

        data:@json($membershipData)

        }]

        },

        options:{

        responsive:true,

        plugins:{

        legend:{

        position:'bottom'

        }

        }

        }

        }

        );

        </script>

        {{-- ===========================================================
                    RECENT MEMBERS
        =========================================================== --}}

        <div class="row mt-4">

            <div class="col-lg-8 mb-4">

                <div class="card border-0 shadow-lg rounded-4">

                    <div class="card-header bg-white d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">

                            <i class="fas fa-users text-primary me-2"></i>

                            Recent Members

                        </h5>

                        <a href="{{ route('admin.member.index') }}"
                           class="btn btn-primary btn-sm">

                            View All

                        </a>

                    </div>

                    <div class="card-body table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>Photo</th>

                                    <th>Member</th>

                                    <th>Trainer</th>

                                    <th>Plan</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                            @forelse($recentMembers as $member)

                                <tr>

                                    <td width="70">

                                        @if($member->photo)

                                        <img src="{{ asset('storage/'.$member->photo) }}"
                                             class="rounded-circle"
                                             width="50"
                                             height="50">

                                        @else

                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}"
                                             class="rounded-circle"
                                             width="50">

                                        @endif

                                    </td>

                                    <td>

                                        <strong>{{ $member->name }}</strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $member->phone }}

                                        </small>

                                    </td>

                                    <td>

                                        {{ optional($member->trainer)->name ?? 'Not Assigned' }}

                                    </td>

                                    <td>

                                        {{ $member->membership_plan }}

                                    </td>

                                    <td>

                                        @if($member->status=='Active')

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                        @else

                                        <span class="badge bg-danger">

                                            Inactive

                                        </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="text-center text-muted">

                                        No Members Found

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        {{-- ===========================================================
                    RECENT TRAINERS (WITH VIEW ALL)
        =========================================================== --}}

            <div class="col-lg-4 mb-4">

                <div class="card border-0 shadow-lg rounded-4">

                    <div class="card-header bg-white d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">

                            <i class="fas fa-user-tie text-success me-2"></i>

                            Recent Trainers

                        </h5>

                        <a href="{{ route('admin.trainer.index') }}"
                           class="btn btn-success btn-sm">

                            View All

                        </a>

                    </div>

                    <div class="card-body">

                        @forelse($recentTrainers as $trainer)

                        <div class="d-flex align-items-center mb-3">

                            @if($trainer->photo)

                            <img src="{{ asset('storage/'.$trainer->photo) }}"
                                 class="rounded-circle me-3"
                                 width="55"
                                 height="55">

                            @else

                            <img src="https://ui-avatars.com/api/?name={{ urlencode($trainer->name) }}"
                                 class="rounded-circle me-3"
                                 width="55">

                            @endif

                            <div>

                                <h6 class="mb-1">

                                    {{ $trainer->name }}

                                </h6>

                                <small class="text-muted">

                                    {{ $trainer->specialization }}

                                </small>

                            </div>

                        </div>

                        @empty

                        <p class="text-center">

                            No Trainers Found

                        </p>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

        {{-- ===========================================================
                    MEMBERSHIP PLANS (WITH VIEW ALL)
        =========================================================== --}}

        <div class="row">

        <div class="col-lg-6 mb-4">

        <div class="card border-0 shadow-lg rounded-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="fw-bold">

        <i class="fas fa-id-card text-warning me-2"></i>

        Latest Membership Plans

        </h5>

        <a href="{{ route('admin.membership.index') }}"
           class="btn btn-warning btn-sm">

            View All

        </a>

        </div>

        <div class="card-body table-responsive">

        <table class="table">

        <thead>

        <tr>

        <th>Plan</th>

        <th>Duration</th>

        <th>Price</th>

        </tr>

        </thead>

        <tbody>

        @foreach($recentMemberships as $plan)

        <tr>

        <td>

        {{ $plan->plan_name }}

        </td>

        <td>

        {{ $plan->duration }}

        {{ $plan->duration_type }}

        </td>

        <td>

        ₹ {{ number_format($plan->final_price,2) }}

        </td>

        </tr>

        @endforeach

        </tbody>

        </table>

        </div>

        </div>

        </div>

        {{-- ===========================================================
                    PACKAGES (WITH VIEW ALL)
        =========================================================== --}}

        <div class="col-lg-6 mb-4">

        <div class="card border-0 shadow-lg rounded-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="fw-bold">

        <i class="fas fa-box-open text-danger me-2"></i>

        Latest Packages

        </h5>

        <a href="{{ route('admin.package.index') }}"
           class="btn btn-danger btn-sm">

            View All

        </a>

        </div>

        <div class="card-body table-responsive">

        <table class="table">

        <thead>

        <tr>

        <th>Package</th>

        <th>Duration</th>

        <th>Price</th>

        </tr>

        </thead>

        <tbody>

        @foreach($recentPackages as $package)

        <tr>

        <td>

        {{ $package->package_name }}

        </td>

        <td>

        {{ $package->duration }}

        {{ $package->duration_type }}

        </td>

        <td>

        ₹ {{ number_format($package->price,2) }}

        </td>

        </tr>

        @endforeach

        </tbody>

        </table>

        </div>

        </div>

        </div>

        </div>

        {{-- ============================================================
                    DASHBOARD FOOTER
        ============================================================ --}}

        <div class="row mt-4">

            <div class="col-12">

                <div class="text-center text-muted">

                    <hr>

                    <small>

                        © {{ date('Y') }}

                        Gym Management System 

                      

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection