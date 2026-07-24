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
                <form method="POST" action="{{ route('admin.member.store') }}" enctype="multipart/form-data" id="memberForm">
                    @csrf
                    
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Personal Information</h5>
                        </div>
                        
                        <!-- Full Name with Photo -->
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
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
                            <input type="date" name="dob" class="form-control" id="dob" onchange="calculateAge()">
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input type="tel" name="emergency_contact" class="form-control" placeholder="Emergency phone number">
                        </div>
                        
                        <div class="col-md-8 mb-3">
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

                        <!-- Plan Type Selection -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Plan Type <span class="text-danger">*</span></label>
                            <select name="plan_type" id="planType" class="form-control" required onchange="togglePlanFields()">
                                <option value="">-- Select Plan Type --</option>
                                <option value="membership">Membership</option>
                                <option value="package">Package</option>
                            </select>
                        </div>

                        <!-- Membership Plan Dropdown -->
                        <div class="col-md-3 mb-3" id="membershipPlanDiv" style="display:none;">
                            <label class="form-label">Membership Plan <span class="text-danger">*</span></label>
                            <select name="membership_plan" id="membershipPlan" class="form-control" onchange="getMembershipDetails()">
                                <option value="">-- Select Membership --</option>
                                @foreach($memberships as $membership)
                                    <option value="{{ $membership->plan_name }}">{{ $membership->plan_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Package Dropdown -->
                        <div class="col-md-3 mb-3" id="packageDiv" style="display:none;">
                            <label class="form-label">Package <span class="text-danger">*</span></label>
                            <select name="package_name" id="packageName" class="form-control" onchange="getPackageDetails()">
                                <option value="">-- Select Package --</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->package_name }}">{{ $package->package_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Duration -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration_display" id="durationDisplay" class="form-control" readonly>
                            <input type="hidden" name="membership_duration" id="membershipDuration">
                        </div>

                        <!-- Price -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" name="price_display" id="priceDisplay" class="form-control" readonly>
                        </div>

                        <!-- Final Price -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Final Price</label>
                            <input type="text" name="final_price_display" id="finalPriceDisplay" class="form-control" readonly>
                            <input type="hidden" name="final_price" id="finalPriceHidden">
                        </div>
                        
                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description_display" id="descriptionDisplay" class="form-control" rows="2" readonly></textarea>
                        </div>

                        <!-- Included Features -->
                        <div class="col-md-12 mb-3" id="featuresDiv" style="display:none;">
                            <label class="form-label">Included Features</label>
                            <textarea name="features_display" id="featuresDisplay" class="form-control" rows="3" readonly></textarea>
                        </div>
                        
                        <!-- Trainer -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assign Trainer</label>
                            <select name="trainer_id" class="form-control">
                                <option value="">-- Select Trainer --</option>
                                @foreach($trainers as $trainer)
                                    <option value="{{ $trainer->id }}">{{ $trainer->name }} ({{ $trainer->specialization }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Status -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
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
// Calculate Age from DOB
function calculateAge() {
    let dob = document.getElementById('dob').value;
    if (dob) {
        let birthDate = new Date(dob);
        let today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        let monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        // Store age in hidden field or display
        document.getElementById('ageDisplay').value = age;
    }
}

// Calculate BMI
function calculateBMI() {
    let height = document.getElementById('height').value;
    let weight = document.getElementById('weight').value;
    
    if (height > 0 && weight > 0) {
        let heightInMeters = height / 100;
        let bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
        document.getElementById('bmi').value = bmi;
    }
}

// Toggle Plan Fields
function togglePlanFields() {
    let planType = document.getElementById('planType').value;
    
    document.getElementById('membershipPlanDiv').style.display = (planType == 'membership') ? 'block' : 'none';
    document.getElementById('packageDiv').style.display = (planType == 'package') ? 'block' : 'none';
    
    // Clear fields
    clearFields();
}

// Get Membership Details via AJAX
function getMembershipDetails() {
    let planName = document.getElementById('membershipPlan').value;
    
    if (!planName) {
        clearFields();
        return;
    }
    
    fetch('/get-membership-details/' + encodeURIComponent(planName))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let duration = data.data.duration + ' ' + data.data.duration_type;
                document.getElementById('durationDisplay').value = duration;
                document.getElementById('membershipDuration').value = duration;
                document.getElementById('priceDisplay').value = '₹ ' + data.data.price;
                document.getElementById('finalPriceDisplay').value = '₹ ' + data.data.final_price;
                document.getElementById('finalPriceHidden').value = data.data.final_price;
                document.getElementById('descriptionDisplay').value = data.data.description || '';
                document.getElementById('featuresDiv').style.display = 'none';
                document.getElementById('featuresDisplay').value = '';
            } else {
                clearFields();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            clearFields();
        });
}

// Get Package Details via AJAX
function getPackageDetails() {
    let packageName = document.getElementById('packageName').value;
    
    if (!packageName) {
        clearFields();
        return;
    }
    
    fetch('/get-package-details/' + encodeURIComponent(packageName))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let duration = data.data.duration + ' ' + data.data.duration_type;
                document.getElementById('durationDisplay').value = duration;
                document.getElementById('membershipDuration').value = duration;
                document.getElementById('priceDisplay').value = '₹ ' + data.data.price;
                document.getElementById('finalPriceDisplay').value = '₹ ' + data.data.price;
                document.getElementById('finalPriceHidden').value = data.data.price;
                document.getElementById('descriptionDisplay').value = data.data.description || '';
                
                // Show features
                if (data.data.included_features) {
                    document.getElementById('featuresDisplay').value = data.data.included_features;
                    document.getElementById('featuresDiv').style.display = 'block';
                } else {
                    document.getElementById('featuresDisplay').value = '';
                    document.getElementById('featuresDiv').style.display = 'none';
                }
            } else {
                clearFields();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            clearFields();
        });
}

// Clear all fields
function clearFields() {
    document.getElementById('durationDisplay').value = '';
    document.getElementById('membershipDuration').value = '';
    document.getElementById('priceDisplay').value = '';
    document.getElementById('finalPriceDisplay').value = '';
    document.getElementById('finalPriceHidden').value = '';
    document.getElementById('descriptionDisplay').value = '';
    document.getElementById('featuresDisplay').value = '';
    document.getElementById('featuresDiv').style.display = 'none';
}
</script>
@endsection