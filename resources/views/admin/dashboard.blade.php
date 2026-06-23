@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h4>
                </div>
                <div class="card-body">
                    <!-- Stats Cards -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Total Members</h5>
                                    <h2>{{ $totalMembers ?? 0 }}</h2>
                                    <small>All registered users</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Active Members</h5>
                                    <h2>{{ $activeMembers ?? 0 }}</h2>
                                    <small>Currently active</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Trainers</h5>
                                    <h2>{{ $totalTrainers ?? 0 }}</h2>
                                    <small>Fitness trainers</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>New This Month</h5>
                                    <h2>{{ $newThisMonth ?? 0 }}</h2>
                                    <small>Joined in {{ date('F Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charts Row -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Member Distribution</div>
                                <div class="card-body">
                                    <canvas id="memberChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Recent Registrations</div>
                                <div class="card-body">
                                    <canvas id="registrationChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Members Table -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-users"></i> Recent Members
                                    <a href="#" class="btn btn-sm btn-primary float-end">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Joined Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentMembers ?? [] as $member)
                                                <tr>
                                                    <td>{{ $member->id }}</td>
                                                    <td>{{ $member->name }}</td>
                                                    <td>{{ $member->email }}</td>
                                                    <td>{{ $member->phone ?? 'N/A' }}</td>
                                                    <td>{{ $member->created_at->format('d M Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No members found</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Role Summary -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">User Summary</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Count</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="badge bg-primary">👤 Total Users</span></td>
                                                <td>{{ $totalMembers ?? 0 }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" style="width: 100%">
                                                            100%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-success">🏋️ Trainers</span></td>
                                                <td>{{ $totalTrainers ?? 0 }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: {{ ($totalMembers ?? 1) > 0 ? (($totalTrainers ?? 0)/($totalMembers ?? 1))*100 : 0 }}%">
                                                            {{ ($totalMembers ?? 1) > 0 ? round((($totalTrainers ?? 0)/($totalMembers ?? 1))*100) : 0 }}%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-info">🆕 New This Month</span></td>
                                                <td>{{ $newThisMonth ?? 0 }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info" style="width: {{ ($totalMembers ?? 1) > 0 ? (($newThisMonth ?? 0)/($totalMembers ?? 1))*100 : 0 }}%">
                                                            {{ ($totalMembers ?? 1) > 0 ? round((($newThisMonth ?? 0)/($totalMembers ?? 1))*100) : 0 }}%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Quick Actions</div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.member.create') }}" class="btn btn-primary">
                                            <i class="fas fa-user-plus"></i> Add New Member
                                        </a>
                                        <a href="{{ route('admin.trainer.create') }}" class="btn btn-success">
                                            <i class="fas fa-chalkboard-user"></i> Add New Trainer
                                        </a>
                                        <a href="#" class="btn btn-info">
                                            <i class="fas fa-file-export"></i> Export Reports
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Member Distribution Chart
    const ctx1 = document.getElementById('memberChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Members', 'Trainers'],
            datasets: [{
                data: [
                    {{ ($totalMembers ?? 0) - ($totalTrainers ?? 0) }}, 
                    {{ $totalTrainers ?? 0 }}
                ],
                backgroundColor: ['#3498db', '#2ecc71'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Registration Chart (Last 7 days)
    const ctx2 = document.getElementById('registrationChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: {!! json_encode($last7Days ?? []) !!},
            datasets: [{
                label: 'New Registrations',
                data: {!! json_encode($registrationsPerDay ?? []) !!},
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
@endsection