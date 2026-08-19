@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <h4 class="mb-0">
                    <i class="fas fa-chalkboard-user me-2"></i> Trainer Dashboard
                </h4>
            </div>

            <div class="card-body">
                @php
                    // Get trainer from session
                    $trainer = App\Models\Trainer::find(session('gym_user_id'));
                    if(!$trainer && auth()->check()) {
                        $trainer = App\Models\Trainer::where('email', auth()->user()->email)->first();
                    }
                    if(!$trainer) {
                        $trainer = App\Models\Trainer::first();
                    }

                    // Get members assigned to this trainer
                    $members = $trainer ? $trainer->members : collect();
                    $memberCount = $members->count();

                    // Get today's date
                    $today = date('Y-m-d');

                    // Get today's attendance for trainer
                    $todayTrainerAttendance = 0;
                    if($trainer && class_exists('App\Models\TrainerAttendance')) {
                        try {
                            $todayTrainerAttendance = App\Models\TrainerAttendance::where('trainer_id', $trainer->id)
                                ->whereDate('attendance_date', $today)
                                ->count();
                        } catch (\Exception $e) {
                            $todayTrainerAttendance = 0;
                        }
                    }

                    // Get today's member attendance
                    $todayMemberAttendance = 0;
                    if($trainer && class_exists('App\Models\MemberAttendance')) {
                        try {
                            $todayMemberAttendance = App\Models\MemberAttendance::whereHas('member', function($query) use ($trainer) {
                                $query->where('trainer_id', $trainer->id);
                            })->whereDate('attendance_date', $today)
                            ->count();
                        } catch (\Exception $e) {
                            $todayMemberAttendance = 0;
                        }
                    }

                    // Get total progress records
                    $totalProgress = 0;
                    if($trainer && class_exists('App\Models\Progress')) {
                        try {
                            $totalProgress = App\Models\Progress::whereHas('member', function($query) use ($trainer) {
                                $query->where('trainer_id', $trainer->id);
                            })->count();
                        } catch (\Exception $e) {
                            $totalProgress = 0;
                        }
                    }

                    // Get today's appointments
                    $todayAppointments = collect();
                    if($trainer && class_exists('App\Models\Appointment')) {
                        try {
                            $todayAppointments = App\Models\Appointment::where('trainer_id', $trainer->id)
                                ->whereDate('appointment_date', $today)
                                ->with('member')
                                ->get();
                        } catch (\Exception $e) {
                            $todayAppointments = collect();
                        }
                    }
                @endphp

                <!-- Stats Cards - Clickable -->
                <div class="row g-3">
                    <!-- Assigned Members -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <a href="{{ route('trainer.members') }}" class="text-decoration-none">
                            <div class="card text-white shadow-sm border-0 stat-card" style="background: linear-gradient(135deg, #0d2818, #1a472a); cursor: pointer;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-1"><i class="fas fa-users me-2"></i>Assigned Members</h6>
                                            <h2 class="mb-0 fw-bold">{{ $memberCount }}</h2>
                                        </div>
                                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                            <i class="fas fa-users fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <small class="text-white-50">Click to view members</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- My Attendance -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <a href="{{ route('trainer.trainer-attendance.index') }}" class="text-decoration-none">
                            <div class="card text-white shadow-sm border-0 stat-card" style="background: linear-gradient(135deg, #3b82f6, #2563eb); cursor: pointer;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-1"><i class="fas fa-calendar-check me-2"></i>My Attendance</h6>
                                            <h2 class="mb-0 fw-bold">{{ $todayTrainerAttendance }}</h2>
                                        </div>
                                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                            <i class="fas fa-calendar-check fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <small class="text-white-50">Today's attendance</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Member Attendance -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <a href="{{ route('trainer.member-attendance.index') }}" class="text-decoration-none">
                            <div class="card text-white shadow-sm border-0 stat-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); cursor: pointer;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-1"><i class="fas fa-users-check me-2"></i>Member Attendance</h6>
                                            <h2 class="mb-0 fw-bold">{{ $todayMemberAttendance }}</h2>
                                        </div>
                                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                            <i class="fas fa-users-check fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <small class="text-white-50">Today's member attendance</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Total Progress -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <a href="{{ route('trainer.progress.index') }}" class="text-decoration-none">
                            <div class="card text-white shadow-sm border-0 stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706); cursor: pointer;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-white-50 mb-1"><i class="fas fa-chart-line me-2"></i>Total Progress</h6>
                                            <h2 class="mb-0 fw-bold">{{ $totalProgress }}</h2>
                                        </div>
                                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                            <i class="fas fa-chart-line fa-2x text-white"></i>
                                        </div>
                                    </div>
                                    <small class="text-white-50">Total progress records</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 style="color: #0d2818;">
                            <i class="fas fa-calendar-check me-2 text-success"></i>Today's Appointments
                        </h5>
                        <span class="badge" style="background: #0d2818; color: white; padding: 5px 15px;">
                            <i class="far fa-calendar-alt me-1"></i> {{ date('d M Y') }}
                        </span>
                    </div>

                    @if($todayAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead style="background: #0d2818; color: white;">
                                    <tr>
                                        <th><i class="fas fa-clock me-1"></i> Time</th>
                                        <th><i class="fas fa-user me-1"></i> Member</th>
                                        <th><i class="fas fa-tag me-1"></i> Purpose</th>
                                        <th><i class="fas fa-info-circle me-1"></i> Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todayAppointments as $appointment)
                                        <tr>
                                            <td>
                                                <span class="badge" style="background: #1a472a; color: white;">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $appointment->member->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $appointment->member->member_id ?? '' }}</small>
                                            </td>
                                            <td>{{ $appointment->purpose ?? 'General' }}</td>
                                            <td>
                                                @if($appointment->status == 'Approved')
                                                    <span class="badge" style="background: #10b981; color: white; padding: 5px 15px;">
                                                        <i class="fas fa-check-circle me-1"></i> Approved
                                                    </span>
                                                @elseif($appointment->status == 'Completed')
                                                    <span class="badge" style="background: #3b82f6; color: white; padding: 5px 15px;">
                                                        <i class="fas fa-check-double me-1"></i> Completed
                                                    </span>
                                                @elseif($appointment->status == 'Rejected')
                                                    <span class="badge" style="background: #ef4444; color: white; padding: 5px 15px;">
                                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                                    </span>
                                                @else
                                                    <span class="badge" style="background: #f59e0b; color: white; padding: 5px 15px;">
                                                        <i class="fas fa-hourglass me-1"></i> Pending
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert" style="background: rgba(13, 40, 24, 0.05); border-left: 4px solid #3b82f6; border-radius: 10px;">
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2 d-block"></i>
                                <p class="text-muted mb-0">No appointments scheduled for today.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========================================================= -->
                <!-- Assigned Members List with View Button on Right Side       -->
                <!-- ========================================================= -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 style="color: #0d2818; margin: 0;">
                            <i class="fas fa-list me-2 text-success"></i>Assigned Members List
                        </h5>
                        <!-- View Button - Right Side Corner -->
                        <a href="{{ route('trainer.members') }}" 
                           class="btn action-btn" 
                           style="background: #0d2818; color: white; border-radius: 6px; border: none; padding: 5px 16px; font-size: 0.8rem; height: 34px; min-width: 70px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                            <i class="fas fa-eye me-1"></i> View All
                        </a>
                    </div>

                    @if($memberCount > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead style="background: #0d2818; color: white;">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Membership</th>
                                        <th>Goal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $key => $member)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $member->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $member->member_id ?? '' }}</small>
                                            </td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td>
                                                @if($member->plan_type == 'membership')
                                                    <span class="badge" style="background: #0d2818; color: #ffd54f;">
                                                        <i class="fas fa-id-card me-1"></i> {{ $member->membership_plan ?? 'Basic' }}
                                                    </span>
                                                @elseif($member->plan_type == 'package')
                                                    <span class="badge" style="background: #ffd54f; color: #0d2818;">
                                                        <i class="fas fa-box me-1"></i> {{ $member->membership_plan ?? 'Basic' }}
                                                    </span>
                                                @else
                                                    <span class="badge" style="background: #1a472a; color: white;">
                                                        {{ $member->membership_plan ?? 'Basic' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge" style="background: #8b5cf6; color: white;">
                                                    {{ $member->goal_type ?? 'Fitness' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert" style="background: rgba(13, 40, 24, 0.05); border-left: 4px solid #f59e0b; border-radius: 10px;">
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2 d-block"></i>
                                <p class="text-muted mb-0">No members assigned to you yet.</p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    }
    
    .action-btn {
        padding: 5px 16px !important;
        font-size: 0.8rem !important;
        border-radius: 6px !important;
        height: 34px !important;
        min-height: 34px !important;
        max-height: 34px !important;
        min-width: 70px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        line-height: 1 !important;
        white-space: nowrap !important;
    }
    .action-btn i { font-size: 0.75rem !important; }
    .action-btn:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); 
        opacity: 0.9; 
        background: #1a472a !important;
    }

    .table-hover tbody tr:hover {
        background: rgba(13, 40, 24, 0.03);
        transition: all 0.3s ease;
    }

    a.text-decoration-none:hover .stat-card {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    }

    @media (max-width: 768px) {
        .card-header .d-flex { flex-direction: column; gap: 10px; align-items: flex-start !important; }
        .action-btn { height: 30px !important; min-height: 30px !important; max-height: 30px !important; min-width: 60px !important; padding: 4px 12px !important; font-size: 0.7rem !important; }
        .action-btn i { font-size: 0.65rem !important; }
        .row.g-3 .col-md-6 { margin-bottom: 15px; }
        .table-responsive { font-size: 0.85rem; }
        .stat-card:hover { transform: translateY(-3px); }
        .d-flex.justify-content-between.align-items-center.mb-3 { 
            flex-direction: column; 
            align-items: flex-start !important; 
            gap: 10px; 
        }
    }

    @media (max-width: 576px) {
        .table-responsive { font-size: 0.8rem; }
        .badge { font-size: 0.65rem; }
        .action-btn { height: 28px !important; min-height: 28px !important; max-height: 28px !important; min-width: 50px !important; padding: 3px 10px !important; font-size: 0.65rem !important; }
        .action-btn i { font-size: 0.6rem !important; }
        .card-header h4 { font-size: 1rem; }
        .stat-card .card-body { padding: 15px !important; }
        .stat-card h2 { font-size: 1.5rem !important; }
        .stat-card h6 { font-size: 0.75rem !important; }
        .stat-card .rounded-circle { padding: 10px !important; }
        .stat-card .rounded-circle i { font-size: 1.2rem !important; }
        .d-flex.justify-content-between.align-items-center.mb-3 { 
            flex-direction: column; 
            align-items: flex-start !important; 
            gap: 8px; 
        }
    }
</style>

@endsection