@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-user-tag"></i>
                    Assign Trainer to Members
                </h4>

                <div>
                    <a href="{{ route('admin.assign.trainer.list') }}" class="btn btn-info me-2">
                        <i class="fas fa-list"></i> Assigned Members
                    </a>
                </div>

            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- ============================================ -->
                <!-- BULK ASSIGN FORM                            -->
                <!-- ============================================ -->
                <form action="{{ route('admin.assign.trainer.bulk') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <!-- Select Trainer -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="text-success">
                                        <i class="fas fa-user-check"></i> Select Trainer
                                    </h5>
                                    <select name="trainer_id" id="bulk_trainer_id" class="form-select" required>
                                        <option value="">-- Select Trainer --</option>
                                        @foreach($trainers as $trainer)
                                            <option value="{{ $trainer->id }}">
                                                {{ $trainer->name }} 
                                                ({{ $trainer->specialization }})
                                                - Assigned: {{ $trainer->assigned_members }} members
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select a trainer to assign to selected members</small>
                                </div>
                            </div>
                        </div>

                        <!-- Select All / Actions -->
                        <div class="col-md-8">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="text-primary">
                                        <i class="fas fa-users"></i> Bulk Actions
                                    </h5>
                                    <div class="d-flex gap-3 align-items-center flex-wrap">
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="selectAll()">
                                            <i class="fas fa-check-double"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAll()">
                                            <i class="fas fa-times"></i> Deselect All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info" onclick="selectUnassigned()">
                                            <i class="fas fa-user-slash"></i> Select Unassigned Only
                                        </button>
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Assign selected members to this trainer?')">
                                            <i class="fas fa-user-plus"></i> Assign Selected Members
                                        </button>
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle"></i> 
                                        Select members below and assign them to the selected trainer
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">

                            <thead class="table-dark">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleAllCheckboxes()">
                                    </th>
                                    <th width="60">#</th>
                                    <th>Member Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($members as $key => $member)
                                    <tr>
                                        <td>
                                            <input type="checkbox" 
                                                   name="member_ids[]" 
                                                   value="{{ $member->id }}"
                                                   class="member-checkbox">
                                        </td>
                                        <td>{{ $members->firstItem() + $key }}</td>
                                        <td>
                                            <strong>{{ $member->name }}</strong>
                                        </td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-user-slash"></i> Not Assigned
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center py-4">
                                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                                <h5 class="text-success">All Members Are Assigned!</h5>
                                                <p class="text-muted">No unassigned members found.</p>
                                                <a href="{{ route('admin.assign.trainer.list') }}" class="btn btn-primary">
                                                    <i class="fas fa-list"></i> View Assigned Members
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </form>

                <div class="d-flex justify-content-end mt-3">
                    {{ $members->links() }}
                </div>

            </div>

        </div>

    </div>
</div>

<script>
    // Select All Checkboxes
    function selectAll() {
        document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
            checkbox.checked = true;
        });
        document.getElementById('selectAllCheckbox').checked = true;
    }

    // Deselect All Checkboxes
    function deselectAll() {
        document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
            checkbox.checked = false;
        });
        document.getElementById('selectAllCheckbox').checked = false;
    }

    // Select Unassigned Only
    function selectUnassigned() {
        document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
            checkbox.checked = true;
        });
        document.getElementById('selectAllCheckbox').checked = true;
    }

    // Toggle All Checkboxes
    function toggleAllCheckboxes() {
        const isChecked = document.getElementById('selectAllCheckbox').checked;
        document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    }

    // Update Select All checkbox when individual checkboxes change
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('.member-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.member-checkbox:checked');
                document.getElementById('selectAllCheckbox').checked = 
                    allCheckboxes.length === checkedCheckboxes.length;
            });
        });
    });
</script>

@endsection