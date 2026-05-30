@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4><i class="fas fa-chalkboard-user"></i> Trainer Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Trainer ID</th>
                                <td>{{ $trainer->trainer_id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $trainer->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $trainer->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $trainer->phone }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $trainer->gender ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $trainer->dob ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Age</th>
                                <td>{{ $trainer->age ?? 'Not specified' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Experience</th>
                                <td>{{ $trainer->experience ?? '0' }} years</td>
                            </tr>
                            <tr>
                                <th>Specialization</th>
                                <td><span class="badge bg-success">{{ $trainer->specialization }}</span></td>
                            </tr>
                            <tr>
                                <th>Salary</th>
                                <td>₹{{ number_format($trainer->salary ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Join Date</th>
                                <td>{{ $trainer->join_date }}</td>
                            </tr>
                            <tr>
                                <th>Shift Timing</th>
                                <td>{{ $trainer->shift_timing }}</td>
                            </tr>
                            <tr>
                                <th>Assigned Members</th>
                                <td><span class="badge bg-primary">{{ $trainer->assigned_members ?? 0 }} Members</span></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($trainer->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Address</th>
                                <td>{{ $trainer->address ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Certifications</th>
                                <td>{{ $trainer->certification ?? 'Not specified' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.trainers') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('admin.trainer.edit', $trainer->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Trainer
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection