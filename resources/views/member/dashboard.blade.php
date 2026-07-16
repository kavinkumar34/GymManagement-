@extends('layouts.dashboard-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="mb-0">Welcome back, {{ Auth::user()->name }}! 👋</h4>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Membership Status</h6>
                    <h4 class="text-success">Active</h4>
                    <small class="text-muted">Expires: 2026-12-31</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Attendance This Month</h6>
                    <h4>18/30 days</h4>
                    <small class="text-muted">Normal Range</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Current BMI</h6>
                    <h4>22.5</h4>
                    <small class="text-muted">This month</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Weight Progress</h6>
                    <h4 class="text-success">-3 kg</h4>
                    <small class="text-muted">This month</small>
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
                    <ul class="list-unstyled">
                        <li class="py-2 border-bottom">🏋️ Bench Press - 3 sets x 10 reps</li>
                        <li class="py-2 border-bottom">💪 Incline Dumbbell Press - 3 sets x 12 reps</li>
                        <li class="py-2 border-bottom">🔽 Triceps Pushdown - 3 sets x 15 reps</li>
                        <li class="py-2">🏃 Cardio - 20 mins treadmill</li>
                    </ul>
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
                    <ul class="list-unstyled">
                        <li class="py-2 border-bottom">🍳 Breakfast: 4 egg whites + oats</li>
                        <li class="py-2 border-bottom">🍗 Lunch: Chicken breast + brown rice</li>
                        <li class="py-2 border-bottom">🐟 Dinner: Grilled fish + vegetables</li>
                        <li class="py-2">🥤 Protein Shake - Post workout</li>
                    </ul>
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
                                <tr>
                                    <td>2026-01-15</td>
                                    <td>Premium</td>
                                    <td>₹1,999</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>2025-12-15</td>
                                    <td>Premium</td>
                                    <td>₹1,999</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>2025-11-15</td>
                                    <td>Standard</td>
                                    <td>₹999</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection