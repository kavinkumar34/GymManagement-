@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold">Gym Management Dashboard</h2>
                <p class="text-muted">Welcome to the Gym Management Admin Panel</p>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <h5>Total Members</h5>
                        <h2>{{ $totalMembers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body text-center">
                        <h5>Total Trainers</h5>
                        <h2>{{ $totalTrainers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm bg-warning text-dark">
                    <div class="card-body text-center">
                        <h5>Total Memberships</h5>
                        <h2>{{ $totalMemberships }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body text-center">
                        <h5>Active Memberships</h5>
                        <h2>{{ $activeMemberships }}</h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Memberships -->
        <div class="card shadow mt-3">

            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Recent Membership Plans</h5>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentMemberships as $key => $membership)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $membership->plan_name }}</td>

                            <td>{{ $membership->duration }} {{ $membership->duration_type }}</td>

                            <td>₹ {{ number_format($membership->price,2) }}</td>

                            <td>

                                @if($membership->status == 'Active')

                                    <span class="badge bg-success">Active</span>

                                @else

                                    <span class="badge bg-danger">Inactive</span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center">
                                No Memberships Found
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

@endsection