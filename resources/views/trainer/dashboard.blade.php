@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4><i class="fas fa-chalkboard-user"></i> Trainer Dashboard</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Assigned Members</h5>
                                <h2>25</h2>
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
                
                <div class="mt-4">
                    <h5>Today's Schedule</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>Time</th><th>Member</th><th>Workout Plan</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>6:00 AM</td><td>Rahul Sharma</td><td>Chest & Triceps</td><td><span class="badge bg-success">Completed</span></td></tr>
                            <tr><td>7:00 AM</td><td>Priya Patel</td><td>Cardio & Abs</td><td><span class="badge bg-warning">In Progress</span></td></tr>
                            <tr><td>5:00 PM</td><td>Amit Kumar</td><td>Back & Biceps</td><td><span class="badge bg-secondary">Pending</span></td></tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <h5>Assigned Members List</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>Name</th><th>Membership</th><th>Progress</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>John Doe</td><td>Premium</td><td>75%</td><td><button class="btn btn-sm btn-primary">View</button></td></tr>
                            <tr><td>Jane Smith</td><td>Basic</td><td>60%</td><td><button class="btn btn-sm btn-primary">View</button></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection