@extends('layouts.trainer-layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4><i class="fas fa-chalkboard-user"></i> Trainer Dashboard</h4>
            </div>
            <div class="card-body">
                
            @php
    $trainer = App\Models\Trainer::find(session('gym_user_id'));
    $members = $trainer ? $trainer->members : collect();
    $memberCount = $members->count();
@endphp
                
                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Assigned Members</h5>
                                <h2>{{ $memberCount }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5>Today's Sessions</h5>
                                <h2>8</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>Pending Plans</h5>
                                <h2>5</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Today's Schedule -->
                <div class="mt-4">
                    <h5>Today's Schedule</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Member</th>
                                <th>Workout Plan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>6:00 AM</td>
                                <td>Rahul Sharma</td>
                                <td>Chest & Triceps</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>7:00 AM</td>
                                <td>Priya Patel</td>
                                <td>Cardio & Abs</td>
                                <td><span class="badge bg-warning">In Progress</span></td>
                            </tr>
                            <tr>
                                <td>5:00 PM</td>
                                <td>Amit Kumar</td>
                                <td>Back & Biceps</td>
                                <td><span class="badge bg-secondary">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Assigned Members List - Dynamic -->
                <div class="mt-4">
                    <h5>Assigned Members List</h5>
                    
                    @if($memberCount > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Membership</th>
                                        <th>Goal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $key => $member)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><strong>{{ $member->name }}</strong></td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $member->membership_plan ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $member->goal_type ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            No members assigned to you yet.
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection