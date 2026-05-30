@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4><i class="fas fa-edit"></i> Edit Member</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.member.update', $member->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $member->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" value="{{ $member->phone }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $member->email }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input type="tel" name="emergency_contact" class="form-control" value="{{ $member->emergency_contact }}">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ $member->address }}</textarea>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" step="0.01" name="height" class="form-control" value="{{ $member->height }}" id="height" onchange="calculateBMI()">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control" value="{{ $member->weight }}" id="weight" onchange="calculateBMI()">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">BMI</label>
                            <input type="text" name="bmi" class="form-control" id="bmi" value="{{ $member->bmi }}" readonly>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Goal Type</label>
                            <select name="goal_type" class="form-control">
                                <option value="Weight Loss" {{ $member->goal_type == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                                <option value="Muscle Gain" {{ $member->goal_type == 'Muscle Gain' ? 'selected' : '' }}>Muscle Gain</option>
                                <option value="Fitness" {{ $member->goal_type == 'Fitness' ? 'selected' : '' }}>Fitness</option>
                                <option value="Body Building" {{ $member->goal_type == 'Body Building' ? 'selected' : '' }}>Body Building</option>
                                <option value="Fat Loss" {{ $member->goal_type == 'Fat Loss' ? 'selected' : '' }}>Fat Loss</option>
                                <option value="Strength Training" {{ $member->goal_type == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Medical Issues</label>
                            <textarea name="medical_issues" class="form-control" rows="2">{{ $member->medical_issues }}</textarea>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Membership Plan</label>
                            <select name="membership_plan" class="form-control">
                                <option value="Basic" {{ $member->membership_plan == 'Basic' ? 'selected' : '' }}>Basic</option>
                                <option value="Standard" {{ $member->membership_plan == 'Standard' ? 'selected' : '' }}>Standard</option>
                                <option value="Premium" {{ $member->membership_plan == 'Premium' ? 'selected' : '' }}>Premium</option>
                                <option value="VIP" {{ $member->membership_plan == 'VIP' ? 'selected' : '' }}>VIP</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Membership Duration</label>
                            <select name="membership_duration" class="form-control">
                                <option value="1 Month" {{ $member->membership_duration == '1 Month' ? 'selected' : '' }}>1 Month</option>
                                <option value="3 Months" {{ $member->membership_duration == '3 Months' ? 'selected' : '' }}>3 Months</option>
                                <option value="6 Months" {{ $member->membership_duration == '6 Months' ? 'selected' : '' }}>6 Months</option>
                                <option value="1 Year" {{ $member->membership_duration == '1 Year' ? 'selected' : '' }}>1 Year</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Assign Trainer</label>
                            <select name="trainer_id" class="form-control">
                                <option value="">-- Select Trainer --</option>
                                @foreach($trainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ $member->trainer_id == $trainer->id ? 'selected' : '' }}>
                                        {{ $trainer->name }} ({{ $trainer->specialization }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $member->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $member->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Member
                        </button>
                        <a href="{{ route('admin.members') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function calculateBMI() {
    let height = document.getElementById('height').value;
    let weight = document.getElementById('weight').value;
    
    if (height > 0 && weight > 0) {
        let heightInMeters = height / 100;
        let bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
        document.getElementById('bmi').value = bmi;
    }
}
</script>
@endsection