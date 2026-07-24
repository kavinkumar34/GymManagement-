@extends('layouts.member-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Welcome Card with Trainer Info -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @php
                            $member = App\Models\Member::where('email', session('gym_user_email'))->first();
                            $trainer = $member ? $member->trainer : null;
                            $memberName = $member ? $member->name : session('gym_user_name', 'Guest');
                        @endphp
                        <h4 class="mb-2">
                            Welcome back, {{ $memberName }}! 👋
                        </h4>

                        @if ($trainer)
                            <div class="alert alert-success mt-2">
                                <i class="fas fa-user-check me-2"></i>
                                <strong>Your Trainer:</strong> {{ $trainer->name }}
                                ({{ $trainer->specialization }})
                                <br>
                                <small>
                                    <i class="fas fa-phone me-1"></i> {{ $trainer->phone }}
                                    | <i class="fas fa-envelope me-1"></i> {{ $trainer->email }}
                                </small>
                            </div>
                        @else
                            <div class="alert alert-warning mt-2">
                                <i class="fas fa-user-slash me-2"></i>
                                <strong>No Trainer Assigned Yet.</strong>
                                Please contact admin to assign a trainer.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Cards - Dynamic Data -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Membership Status</h6>
                        <h4 class="text-success">
                            @if($member && $member->status == 'Active')
                                Active
                            @else
                                Inactive
                            @endif
                        </h4>
                        <small class="text-muted">
                            Plan: {{ $member ? $member->membership_plan : 'N/A' }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Attendance This Month</h6>
                        @php
                            $attendanceCount = 0;
                            if ($member) {
                                $attendanceCount = \App\Models\MemberAttendance::where('member_id', $member->id)
                                    ->whereMonth('attendance_date', now()->month)
                                    ->whereYear('attendance_date', now()->year)
                                    ->where('status', 'Present')
                                    ->count();
                            }
                            $daysInMonth = now()->daysInMonth;
                        @endphp
                        <h4>{{ $attendanceCount }}/{{ $daysInMonth }} days</h4>
                        <small class="text-muted">
                            @if($attendanceCount > 0)
                                {{ round(($attendanceCount / $daysInMonth) * 100) }}% attendance
                            @else
                                No attendance recorded
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Current BMI</h6>
                        @php
                            $bmi = $member ? $member->bmi : null;
                        @endphp
                        <h4>{{ $bmi ?? 'N/A' }}</h4>
                        <small class="text-muted">
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
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Current Weight</h6>
                        @php
                            $weight = $member ? $member->weight : null;
                        @endphp
                        <h4>{{ $weight ? $weight . ' kg' : 'N/A' }}</h4>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i> Last updated: {{ $member && $member->updated_at ? $member->updated_at->format('d M Y') : 'Never' }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Today's Workout Plan -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-dumbbell me-2"></i> Today's Workout Plan</h5>
                    </div>
                    <div class="card-body">
                        @php
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
                        @endphp
                        @if($todayExercises && $todayExercises->count() > 0)
                            <ul class="list-unstyled">
                                @foreach($todayExercises as $exercise)
                                    <li class="py-2 border-bottom">
                                        🏋️ {{ $exercise->exercise_name }} - 
                                        {{ $exercise->sets }} sets x {{ $exercise->reps }} reps
                                        @if($exercise->weight)
                                            <span class="badge bg-info">Weight: {{ $exercise->weight }} kg</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @elseif($todayWorkout)
                            <div class="text-center py-3">
                                <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                <p class="text-muted">No exercises scheduled for today.</p>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-calendar-plus text-muted fa-2x mb-2"></i>
                                <p class="text-muted">No active workout plan assigned.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Today's Diet Plan -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-utensils me-2"></i> Today's Diet Plan</h5>
                    </div>
                    <div class="card-body">
                        @php
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
                        @endphp
                        @if($todayMeals && $todayMeals->count() > 0)
                            <ul class="list-unstyled">
                                @foreach($todayMeals as $meal)
                                    <li class="py-2 border-bottom">
                                        <strong>{{ $meal->meal_time }}:</strong> {{ $meal->food_name }}
                                        @if($meal->quantity)
                                            <span class="badge bg-secondary">{{ $meal->quantity }}</span>
                                        @endif
                                        @if($meal->calories)
                                            <span class="badge bg-warning text-dark">{{ $meal->calories }} cal</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @elseif($todayDiet)
                            <div class="text-center py-3">
                                <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                <p class="text-muted">No meals scheduled for today.</p>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-utensils text-muted fa-2x mb-2"></i>
                                <p class="text-muted">No active diet plan assigned.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i> Payment History</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $payments = collect();
                            if ($member) {
                                $payments = \App\Models\MembershipOrder::where('member_id', $member->member_id)
                                    ->orWhere('user_id', auth()->id())
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            }
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Plan</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                                            <td>{{ $payment->plan_name }}</td>
                                            <td>₹{{ number_format($payment->amount, 2) }}</td>
                                            <td>
                                                @if($payment->payment_status == 'SUCCESS')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($payment->payment_status == 'PENDING')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                <i class="fas fa-credit-card fa-2x d-block mb-2"></i>
                                                No payment history found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection