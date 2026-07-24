@extends('layouts.admin-layout')

@section('content')
    <div class="admin-main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4><i class="fas fa-edit"></i> Edit Member</h4>
                    <small>Update member details</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.member.update', $member->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-12">
                                <h5 class="bg-light p-2">Personal Information</h5>
                            </div>

                            <!-- Full Name with Photo -->
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $member->name) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Profile Photo</label>
                                @if ($member->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                            width="60" height="60"
                                            style="object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                                        <br>
                                        <small class="text-muted">Current Photo</small>
                                    </div>
                                @endif
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                <small class="text-muted">Leave empty to keep current photo</small>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="Female"
                                        {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other"
                                        {{ old('gender', $member->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control"
                                    value="{{ old('dob', $member->dob) }}" id="dob">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Age</label>
                                <input type="text" name="age" class="form-control"
                                    value="{{ old('age', $member->age) }}" readonly>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control"
                                    value="{{ old('phone', $member->phone) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $member->email) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Emergency Contact</label>
                                <input type="tel" name="emergency_contact" class="form-control"
                                    value="{{ old('emergency_contact', $member->emergency_contact) }}"
                                    placeholder="Emergency phone number">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Member ID</label>
                                <input type="text" class="form-control" value="{{ $member->member_id }}" readonly>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address', $member->address) }}</textarea>
                            </div>

                            <!-- Fitness Information -->
                            <div class="col-md-12 mt-3">
                                <h5 class="bg-light p-2">Fitness Information</h5>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Height (cm)</label>
                                <input type="number" step="0.01" name="height" class="form-control"
                                    value="{{ old('height', $member->height) }}" id="height" onchange="calculateBMI()">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" class="form-control"
                                    value="{{ old('weight', $member->weight) }}" id="weight"
                                    onchange="calculateBMI()">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">BMI</label>
                                <input type="text" name="bmi" class="form-control" id="bmi"
                                    value="{{ old('bmi', $member->bmi) }}" readonly>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Goal Type <span class="text-danger">*</span></label>
                                <select name="goal_type" class="form-control" required>
                                    <option value="Weight Loss"
                                        {{ old('goal_type', $member->goal_type) == 'Weight Loss' ? 'selected' : '' }}>
                                        Weight Loss</option>
                                    <option value="Muscle Gain"
                                        {{ old('goal_type', $member->goal_type) == 'Muscle Gain' ? 'selected' : '' }}>
                                        Muscle Gain</option>
                                    <option value="Fitness"
                                        {{ old('goal_type', $member->goal_type) == 'Fitness' ? 'selected' : '' }}>Fitness
                                    </option>
                                    <option value="Body Building"
                                        {{ old('goal_type', $member->goal_type) == 'Body Building' ? 'selected' : '' }}>
                                        Body Building</option>
                                    <option value="Fat Loss"
                                        {{ old('goal_type', $member->goal_type) == 'Fat Loss' ? 'selected' : '' }}>Fat Loss
                                    </option>
                                    <option value="Strength Training"
                                        {{ old('goal_type', $member->goal_type) == 'Strength Training' ? 'selected' : '' }}>
                                        Strength Training</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Medical Issues (if any)</label>
                                <textarea name="medical_issues" class="form-control" rows="2"
                                    placeholder="Any medical conditions or allergies">{{ old('medical_issues', $member->medical_issues) }}</textarea>
                            </div>

                            <!-- Membership Information -->
                            <div class="col-md-12 mt-3">
                                <h5 class="bg-light p-2">Membership Information</h5>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Join Date <span class="text-danger">*</span></label>
                                <input type="date" name="join_date" class="form-control"
                                    value="{{ old('join_date', $member->join_date) }}" required>
                            </div>

                            <!-- Plan Type Selection -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Plan Type <span class="text-danger">*</span></label>
                                <select name="plan_type" id="planType" class="form-control" required
                                    onchange="togglePlanFields()">
                                    <option value="">-- Select Plan Type --</option>
                                    <option value="membership"
                                        {{ old('plan_type', $member->plan_type) == 'membership' ? 'selected' : '' }}>
                                        Membership
                                    </option>

                                    <option value="package"
                                        {{ old('plan_type', $member->plan_type) == 'package' ? 'selected' : '' }}>
                                        Package
                                    </option>
                                </select>
                            </div>

                            <!-- Membership Plan Dropdown (Shows only when Plan Type = Membership) -->
                            <div class="col-md-3 mb-3" id="membershipPlanDiv"
                                style="{{ old('plan_type', $member->plan_type) == 'membership' ? 'display:block;' : 'display:none;' }}">
                                <label class="form-label">Membership Plan <span class="text-danger">*</span></label>
                                <select name="membership_plan" id="membershipPlan" class="form-control"
                                    onchange="getMembershipDetails()">
                                    <option value="">-- Select Membership --</option>
                                    @foreach ($memberships as $membership)
                                        <option value="{{ $membership->plan_name }}"
                                            {{ old('membership_plan', $member->membership_plan) == $membership->plan_name ? 'selected' : '' }}>
                                            {{ $membership->plan_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Package Dropdown (Shows only when Plan Type = Package) -->
                            <div class="col-md-3 mb-3" id="packageDiv"
                                style="{{ old('plan_type', $member->plan_type) == 'package' ? 'display:block;' : 'display:none;' }}">
                                <label class="form-label">Package <span class="text-danger">*</span></label>
                                <select name="package_name" id="packageName" class="form-control"
                                    onchange="getPackageDetails()">
                                    <option value="">-- Select Package --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->package_name }}"
                                            {{ old('package_name', $member->membership_plan) == $package->package_name ? 'selected' : '' }}>
                                            {{ $package->package_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" name="duration_display" id="durationDisplay" class="form-control"
                                    value="{{ old('membership_duration', $member->membership_duration) }}" readonly>
                                <input type="hidden" name="membership_duration" id="membershipDuration"
                                    value="{{ old('membership_duration', $member->membership_duration) }}">
                            </div>

                            <!-- Price -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price_display" id="priceDisplay" class="form-control"
                                    readonly>
                            </div>

                            <!-- Final Price -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Final Price</label>
                                <input type="text" name="final_price_display" id="finalPriceDisplay"
                                    class="form-control" value="{{ old('final_price', $member->final_price) }}" readonly>
                                <input type="hidden" name="final_price" id="finalPriceHidden"
                                    value="{{ old('final_price', $member->final_price) }}">
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
                                    @foreach ($trainers as $trainer)
                                        <option value="{{ $trainer->id }}"
                                            {{ old('trainer_id', $member->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                            {{ $trainer->name }} ({{ $trainer->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="Active"
                                        {{ old('status', $member->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive"
                                        {{ old('status', $member->status) == 'Inactive' ? 'selected' : '' }}>Inactive
                                    </option>
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

            if (planType == 'membership') {
                document.getElementById('membershipPlanDiv').style.display = 'block';
                document.getElementById('packageDiv').style.display = 'none';
                document.getElementById('packageName').value = '';
                clearFields();
                // Auto load membership details if value exists
                let membershipPlan = document.getElementById('membershipPlan');
                if (membershipPlan.value) {
                    getMembershipDetails();
                }
            } else if (planType == 'package') {
                document.getElementById('membershipPlanDiv').style.display = 'none';
                document.getElementById('packageDiv').style.display = 'block';
                document.getElementById('membershipPlan').value = '';
                clearFields();
                // Auto load package details if value exists
                let packageName = document.getElementById('packageName');
                if (packageName.value) {
                    getPackageDetails();
                }
            } else {
                document.getElementById('membershipPlanDiv').style.display = 'none';
                document.getElementById('packageDiv').style.display = 'none';
                clearFields();
            }
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

        // Auto-load details on page load
        document.addEventListener('DOMContentLoaded', function() {
            let planType = document.getElementById('planType').value;
            let membershipPlan = document.getElementById('membershipPlan');
            let packageName = document.getElementById('packageName');

            if (planType == 'membership' && membershipPlan.value) {
                getMembershipDetails();
            } else if (planType == 'package' && packageName.value) {
                getPackageDetails();
            }
        });
    </script>
@endsection
