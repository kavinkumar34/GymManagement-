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
                    STATISTICS CARDS
        ============================================ -->

        <div class="row">

            <!-- Members -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card blue">

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

            <!-- Active -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card green">

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

            <!-- Trainers -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card orange">

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

            <!-- Revenue -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card purple">

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

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card dark">

                    <div class="card-icon">

                        <i class="fas fa-credit-card"></i>

                    </div>

                    <div>

                        <h6>Membership Plans</h6>

                        <h2>{{ $totalMemberships }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card red">

                    <div class="card-icon">

                        <i class="fas fa-box-open"></i>

                    </div>

                    <div>

                        <h6>Total Packages</h6>

                        <h2>{{ $totalPackages }}</h2>

                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="dashboard-card cyan">

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
                    RECENT TRAINERS
=========================================================== --}}

    <div class="col-lg-4 mb-4">

        <div class="card border-0 shadow-lg rounded-4">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    <i class="fas fa-user-tie text-success me-2"></i>

                    Recent Trainers

                </h5>

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
                    MEMBERSHIP PLANS
=========================================================== --}}

<div class="row">

<div class="col-lg-6 mb-4">

<div class="card border-0 shadow-lg rounded-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

<i class="fas fa-id-card text-warning me-2"></i>

Latest Membership Plans

</h5>

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
                    PACKAGES
=========================================================== --}}

<div class="col-lg-6 mb-4">

<div class="card border-0 shadow-lg rounded-4">

<div class="card-header bg-white">

<h5 class="fw-bold">

<i class="fas fa-box-open text-danger me-2"></i>

Latest Packages

</h5>

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
                    QUICK ACTIONS
============================================================ --}}

<div class="row">

    <div class="col-lg-12">

        <div class="card border-0 shadow-lg rounded-4">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    <i class="fas fa-bolt text-warning me-2"></i>

                    Quick Actions

                </h5>

            </div>

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-md-3 mb-3">

                        <a href="{{ route('admin.member.create') }}"
                           class="btn btn-primary w-100 py-3">

                            <i class="fas fa-user-plus fa-2x d-block mb-2"></i>

                            Add Member

                        </a>

                    </div>

                    <div class="col-md-3 mb-3">

                        <a href="{{ route('admin.trainer.create') }}"
                           class="btn btn-success w-100 py-3">

                            <i class="fas fa-user-tie fa-2x d-block mb-2"></i>

                            Add Trainer

                        </a>

                    </div>

                    <div class="col-md-3 mb-3">

                        <a href="{{ route('admin.membership.create') }}"
                           class="btn btn-warning w-100 py-3">

                            <i class="fas fa-id-card fa-2x d-block mb-2"></i>

                            Membership

                        </a>

                    </div>

                    <div class="col-md-3 mb-3">

                        <a href="{{ route('admin.package.create') }}"
                           class="btn btn-danger w-100 py-3">

                            <i class="fas fa-box-open fa-2x d-block mb-2"></i>

                            Add Package

                        </a>

                    </div>

                </div>

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

                Gym Management System |

                Dashboard Version 1.0

            </small>

        </div>

    </div>

</div>

@endsection