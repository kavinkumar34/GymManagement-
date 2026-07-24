@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-users"></i>
                    Assigned Members List
                </h4>

                <a href="{{ route('admin.assign.trainer.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">

                        <thead class="table-dark">
                            <tr>
                                <th width="60">#</th>
                                <th>Trainer Name</th>
                                <th>Trainer Email</th>
                                <th>Trainer Phone</th>
                                <th>Assigned Members</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                // Group members by trainer
                                $groupedMembers = $members->groupBy('trainer_id');
                            @endphp

                            @forelse($groupedMembers as $trainerId => $memberList)
                                @php
                                    $trainer = $memberList->first()->trainer;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong class="text-success">
                                            <i class="fas fa-user-check"></i> {{ $trainer->name ?? 'N/A' }}
                                        </strong>
                                    </td>
                                    <td>{{ $trainer->email ?? 'N/A' }}</td>
                                    <td>{{ $trainer->phone ?? 'N/A' }}</td>
                                    <td>
                                        @foreach($memberList as $member)
                                            <span class="badge bg-primary m-1">
                                                <i class="fas fa-user"></i> {{ $member->name }}
                                            </span>
                                        @endforeach
                                        <br>
                                        <small class="text-muted">
                                            Total: {{ $memberList->count() }} members
                                        </small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewMembersModal{{ $trainerId }}">
                                            <i class="fas fa-eye"></i> View Members
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="text-center py-4">
                                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Members Assigned to Trainers</h5>
                                            <p>Assign trainers to members from the main page.</p>
                                            <a href="{{ route('admin.assign.trainer.index') }}" class="btn btn-primary">
                                                <i class="fas fa-user-tag"></i> Assign Now
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $members->links() }}
                </div>

            </div>

        </div>

    </div>
</div>

<!-- ============================================ -->
<!-- VIEW MEMBERS MODAL                          -->
<!-- ============================================ -->
<!-- ============================================ -->
<!-- VIEW MEMBERS MODAL                          -->
<!-- ============================================ -->
@foreach($groupedMembers as $trainerId => $memberList)
    @php
        $trainer = $memberList->first()->trainer;
    @endphp
    <div class="modal fade" id="viewMembersModal{{ $trainerId }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-users"></i> 
                        Members of {{ $trainer->name ?? 'N/A' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Member Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Goal Type</th>
                                    <th>Plan Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($memberList as $key => $member)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><strong>{{ $member->name }}</strong></td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td>
                                            <span class="badge" style="background: #fce7f3; color: #db2777; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;">
                                                <i class="fas fa-bullseye me-1"></i> {{ $member->goal_type ?? 'Fitness' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($member->plan_type == 'membership')
                                                <span class="badge" style="background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;">
                                                    <i class="fas fa-id-card me-1"></i> Membership
                                                </span>
                                            @elseif($member->plan_type == 'package')
                                                <span class="badge" style="background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;">
                                                    <i class="fas fa-box me-1"></i> Package
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                            <br>
                                            <small style="color: #64748b; font-size: 0.7rem;">
                                                {{ $member->membership_plan ?? 'Basic' }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        <strong>Total Members:</strong> {{ $memberList->count() }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection