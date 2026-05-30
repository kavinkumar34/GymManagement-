@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fas fa-user-plus"></i> Member Registration</h4>
                <small>Register new gym member</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.member.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Personal Information</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input type="tel" name="emergency_contact" class="form-control" placeholder="Emergency phone number">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <!-- Fitness Information -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Fitness Information</h5>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" step="0.01" name="height" class="form-control" id="height" onchange="calculateBMI()">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control" id="weight" onchange="calculateBMI()">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">BMI</label>
                            <input type="text" name="bmi" class="form-control" id="bmi" readonly>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Goal Type <span class="text-danger">*</span></label>
                            <select name="goal_type" class="form-control" required>
                                <option value="Weight Loss">Weight Loss</option>
                                <option value="Muscle Gain">Muscle Gain</option>
                                <option value="Fitness">Fitness</option>
                                <option value="Body Building">Body Building</option>
                                <option value="Fat Loss">Fat Loss</option>
                                <option value="Strength Training">Strength Training</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Medical Issues (if any)</label>
                            <textarea name="medical_issues" class="form-control" rows="2" placeholder="Any medical conditions or allergies"></textarea>
                        </div>
                        
                        <!-- Membership Information -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Membership Information</h5>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Join Date <span class="text-danger">*</span></label>
                            <input type="date" name="join_date" class="form-control" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Membership Plan <span class="text-danger">*</span></label>
                            <select name="membership_plan" class="form-control" required>
                                <option value="Basic">Basic - ₹2,000/month</option>
                                <option value="Standard">Standard - ₹3,500/month</option>
                                <option value="Premium">Premium - ₹5,000/month</option>
                                <option value="VIP">VIP - ₹8,000/month</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Membership Duration <span class="text-danger">*</span></label>
                            <select name="membership_duration" class="form-control" required>
                                <option value="1 Month">1 Month</option>
                                <option value="3 Months">3 Months</option>
                                <option value="6 Months">6 Months</option>
                                <option value="1 Year">1 Year</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Assign Trainer</label>
                            <select name="trainer_id" class="form-control">
                                <option value="">-- Select Trainer --</option>
                                @foreach($trainers as $trainer)
                                    <option value="{{ $trainer->id }}">{{ $trainer->name }} ({{ $trainer->specialization }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Register Member
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