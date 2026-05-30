@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fas fa-home"></i> Member Dashboard</h4>
                <small>Welcome back, {{ auth()->user()->name }}!</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>Membership Status</h5>
                                <h3>Active</h3>
                                <small>Expires: 2026-12-31</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Attendance This Month</h5>
                                <h3>18/30 days</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5>Current BMI</h5>
                                <h3>22.5</h3>
                                <small>Normal Range</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5>Weight Progress</h5>
                                <h3>-3 kg</h3>
                                <small>This month</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Today's Workout Plan</div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">🏋️ Bench Press - 3 sets x 10 reps</li>
                                    <li class="list-group-item">💪 Incline Dumbbell Press - 3 sets x 12 reps</li>
                                    <li class="list-group-item">📌 Triceps Pushdown - 3 sets x 15 reps</li>
                                    <li class="list-group-item">🏃‍♂️ Cardio - 20 mins treadmill</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Today's Diet Plan</div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">🍳 Breakfast: 4 egg whites + oats</li>
                                    <li class="list-group-item">🍗 Lunch: Chicken breast + brown rice</li>
                                    <li class="list-group-item">🥗 Dinner: Grilled fish + vegetables</li>
                                    <li class="list-group-item">🥛 Protein Shake - Post workout</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Payment History</div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr><th>Date</th><th>Amount</th><th>Plan</th><th>Status</th><th>Receipt</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>2026-01-01</td><td>₹12,000</td><td>Yearly Premium</td><td><span class="badge bg-success">Paid</span></td><td><button class="btn btn-sm btn-info">Download</button></td></tr>
                                        <tr><td>2025-01-01</td><td>₹12,000</td><td>Yearly Premium</td><td><span class="badge bg-success">Paid</span></td><td><button class="btn btn-sm btn-info">Download</button></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection