@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-user-tag"></i>
                    Assign Trainer - {{ $member->name }}
                </h4>

                <a href="{{ route('admin.assign.trainer.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

            </div>

            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <!-- Member Details -->
                    <div class="col-md-5">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="text-primary">Member Details</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Name</th>
                                        <td><strong>{{ $member->name }}</strong></td>
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
                                        <th>Current Trainer</th>
                                        <td>
                                            @if($member->trainer)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-user-check"></i> {{ $member->trainer->name }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-user-slash"></i> Not Assigned
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Assign Trainer Form -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-success">Select Trainer</h5>

                                <form action="{{ route('admin.member.assign.trainer.store', $member->id) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="trainer_id" class="form-label fw-bold">
                                            Trainer <span class="text-danger">*</span>
                                        </label>
                                        <select name="trainer_id" id="trainer_id" class="form-select" required>
                                            <option value="">-- Select Trainer --</option>
                                            @foreach($trainers as $trainer)
                                                <option value="{{ $trainer->id }}"
                                                    {{ old('trainer_id', $member->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                                    {{ $trainer->name }} 
                                                    ({{ $trainer->specialization }})
                                                    - Assigned: {{ $trainer->assigned_members }} members
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-user-check"></i> Assign Trainer
                                        </button>

                                        @if($member->trainer_id)
                                            <a href="{{ route('admin.member.remove.trainer', $member->id) }}"
                                               class="btn btn-danger"
                                               onclick="return confirm('Remove trainer from {{ $member->name }}?')">
                                                <i class="fas fa-user-slash"></i> Remove Trainer
                                            </a>
                                        @endif
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection