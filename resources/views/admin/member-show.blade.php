@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4><i class="fas fa-user"></i> Member Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Member ID</th>
                                <td>{{ $member->member_id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $member->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $member->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $member->phone }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $member->gender ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $member->dob ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Age</th>
                                <td>{{ $member->age ?? 'Not specified' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Height</th>
                                <td>{{ $member->height ?? 'Not specified' }} cm</td>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <td>{{ $member->weight ?? 'Not specified' }} kg</td>
                            </tr>
                            <tr>
                                <th>BMI</th>
                                <td>{{ $member->bmi ?? 'Not calculated' }}</td>
                            </tr>
                            <tr>
                                <th>Membership Plan</th>
                                <td><span class="badge bg-primary">{{ $member->membership_plan ?? 'Basic' }}</span></td>
                            </tr>
                            <tr>
                                <th>Membership Duration</th>
                                <td>{{ $member->membership_duration ?? '1 Month' }}</td>
                            </tr>
                            <tr>
                                <th>Join Date</th>
                                <td>{{ $member->join_date }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($member->status == 'Active')
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
                                <td>{{ $member->address ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Emergency Contact</th>
                                <td>{{ $member->emergency_contact ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Assigned Trainer</th>
                                <td>
                                    @if($member->trainer)
                                        {{ $member->trainer->name }} ({{ $member->trainer->specialization }})
                                    @else
                                        <span class="badge bg-secondary">Not Assigned</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Medical Issues</th>
                                <td>{{ $member->medical_issues ?? 'None' }}</td>
                            </tr>
                            <tr>
                                <th>Goal Type</th>
                                <td>{{ $member->goal_type ?? 'Fitness' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.members') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('admin.member.edit', $member->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Member
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection