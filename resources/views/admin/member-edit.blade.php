@extends('layouts.admin-layout')

@section('content')
    <style>
        /* ============================================ */
        /* COLOR VARIABLES - MATCHING NAVBAR          */
        /* ============================================ */
        :root {
            --primary: #4a9eff;
            --primary-dark: #2b7be0;
            --primary-light: #8ab4f8;
            --success: #4caf50;
            --warning: #ffa726;
            --danger: #ef5350;
            --dark: #1a1a2e;
            --gray: #6c757d;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            --radius: 10px;
            --radius-lg: 16px;
        }

        .admin-main-content {
            padding: 20px 25px;
            background: #f0f4f8;
            min-height: 100vh;
        }

        .edit-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 1100px;
            margin: 0 auto;
        }

        .edit-card .card-header {
            padding: 16px 24px;
            background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
            color: #ffffff;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .edit-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-card .card-header h4 i {
            color: #4a9eff;
        }

        .edit-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .edit-card .card-body {
            padding: 20px 24px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            padding: 6px 14px;
            background: var(--light-gray);
            border-radius: var(--radius);
            border-left: 3px solid var(--primary);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--primary);
            font-size: 14px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .form-label .text-danger {
            color: var(--danger) !important;
        }

        .form-control {
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 7px 12px;
            font-size: 13px;
            transition: all 0.3s;
            background: #ffffff;
            height: 38px;
            color: var(--dark);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .form-control[readonly] {
            background: #f8f9fa;
            cursor: not-allowed;
            color: var(--gray);
        }

        textarea.form-control {
            height: auto;
            min-height: 50px;
            resize: vertical;
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            cursor: pointer;
            color: #1a1a2e !important;
            background-color: #ffffff !important;
        }

        select.form-control option {
            padding: 8px 12px;
            color: #1a1a2e !important;
            background: #ffffff !important;
        }

        select.form-control option:hover,
        select.form-control option:focus {
            background: #e8f4fd !important;
            color: #1a1a2e !important;
        }

        select.form-control option:checked {
            background: #d4e8fc !important;
            color: #1a1a2e !important;
        }

        select.form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            color: #1a1a2e !important;
        }

        select.form-control:-moz-focusring {
            color: #1a1a2e !important;
            text-shadow: 0 0 0 #1a1a2e !important;
        }

        .file-input-wrapper {
            position: relative;
            height: 38px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .file-input-wrapper .file-input-container {
            position: relative;
            flex: 1;
            height: 38px;
            min-width: 150px;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .file-input-wrapper .file-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: #ffffff;
            font-size: 13px;
            color: var(--gray);
            height: 38px;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
            cursor: pointer;
            white-space: nowrap;
        }

        .file-input-wrapper .file-label i {
            color: var(--primary);
            font-size: 14px;
        }

        .file-input-wrapper .file-label:hover {
            border-color: var(--primary);
            background: #f8f9fa;
        }

        .file-input-wrapper .file-name {
            font-size: 13px;
            color: var(--dark);
            padding: 0 8px;
            flex: 1;
            min-width: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-input-wrapper .file-name .no-file {
            color: var(--gray);
            font-style: italic;
        }

        .file-input-wrapper .file-name .selected-file {
            color: var(--primary);
            font-weight: 500;
        }

        .current-photo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .current-photo img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .current-photo .photo-label {
            font-size: 12px;
            color: var(--gray);
        }

        .compact-row {
            margin-bottom: 0;
        }

        .compact-row .mb-3 {
            margin-bottom: 10px !important;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 9px 24px;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 13px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
        }

        .btn-secondary {
            background: #f0f4f8;
            color: var(--gray);
            border: 1px solid var(--border-color);
            padding: 9px 24px;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 13px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            color: var(--dark);
        }

        .form-actions {
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .dynamic-field {
            display: none;
        }

        .dynamic-field.show {
            display: block;
        }

        .disabled-section {
            opacity: 0.6;
            position: relative;
        }

        .disabled-section .disabled-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .disabled-section .disabled-overlay .lock-badge {
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            color: #92400e;
            font-weight: 600;
            font-size: 13px;
        }

        .disabled-section .disabled-overlay .lock-badge i {
            color: #f59e0b;
            margin-right: 8px;
        }

        .date-readonly {
            background: #f8f9fa !important;
            color: #6c757d !important;
            cursor: not-allowed;
        }

        input[type="tel"] {
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .edit-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .edit-card .card-header h4 {
                font-size: 16px;
            }

            .edit-card .card-body {
                padding: 14px 16px;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .file-input-wrapper {
                flex-wrap: wrap;
                height: auto;
            }

            .file-input-wrapper .file-input-container {
                flex: 1;
                min-width: 150px;
            }

            .file-input-wrapper .file-name {
                font-size: 12px;
                min-width: 50px;
            }

            .current-photo img {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 576px) {
            .edit-card .card-header h4 {
                font-size: 14px;
            }

            .edit-card .card-body {
                padding: 10px 12px;
            }

            .form-label {
                font-size: 11px;
            }

            .form-control {
                font-size: 12px;
                padding: 5px 10px;
                height: 34px;
            }

            .section-title {
                font-size: 12px;
                padding: 5px 10px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 7px 16px;
                font-size: 12px;
            }

            .file-input-wrapper .file-label {
                font-size: 12px;
                padding: 5px 10px;
                height: 34px;
            }

            .file-input-wrapper .file-name {
                font-size: 11px;
            }

            .current-photo img {
                width: 32px;
                height: 32px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="edit-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-edit"></i> Edit Member</h4>
                    <small>Update member details</small>
                </div>
                <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-user"></i> {{ $member->member_id }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                
                <!-- ========================================== -->
                <!-- ⚠️ INFO: ACTIVE MEMBER - LIMITED EDIT     -->
                <!-- ========================================== -->
                @if($member->status == 'Active' && !$member->isExpired())
                    <div class="alert alert-info" style="background: #dbeafe; border-left: 4px solid #3b82f6; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-info-circle" style="font-size: 20px; color: #3b82f6;"></i>
                            <div>
                                <strong style="color: #1d4ed8;">Member is Active!</strong><br>
                                <span style="color: #1d4ed8; font-size: 0.85rem;">
                                    You can edit Personal Information and Fitness Information. 
                                    Email, Membership & Payment details are locked until plan expires.
                                    <strong>{{ floor(now()->diffInDays($member->expiry_date)) }} days left.</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.member.update', $member->id) }}" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- ========================================== -->
                    <!-- PERSONAL INFORMATION (ALWAYS EDITABLE)    -->
                    <!-- ========================================== -->
                    <div class="section-title">
                        <i class="fas fa-user"></i> Personal Information
                    </div>

                    <div class="row compact-row">
                        <!-- Register Date - NEVER CHANGEABLE -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Register Date</label>
                            <input type="date" name="register_date" class="form-control date-readonly" 
                                   value="{{ old('register_date', $member->register_date ?? date('Y-m-d')) }}" readonly>
                            <small class="text-muted" style="font-size:11px;">First registration date - Cannot be changed</small>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Profile Photo</label>
                            @if ($member->photo)
                                <div class="current-photo">
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}">
                                    <span class="photo-label"><i class="fas fa-check-circle text-success"></i> Current Photo</span>
                                </div>
                            @endif
                            <div class="file-input-wrapper">
                                <div class="file-input-container">
                                    <div class="file-label">
                                        <i class="fas fa-camera"></i>
                                        <span>Choose photo</span>
                                    </div>
                                    <input type="file" name="photo" accept="image/*" id="profilePhoto" onchange="updateFileName()">
                                </div>
                                <span class="file-name" id="fileNameDisplay">
                                    <span class="no-file">No file chosen</span>
                                </span>
                            </div>
                            <small class="text-muted" style="font-size:11px;">Leave empty to keep current photo</small>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $member->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', $member->dob) }}" id="dob">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Age</label>
                            <input type="text" name="age" class="form-control" id="age" value="{{ old('age', $member->age) }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Member ID</label>
                            <input type="text" class="form-control" value="{{ $member->member_id }}" readonly>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}" 
                                   pattern="[0-9]{10}" maxlength="10" minlength="10" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                            <small class="text-muted" style="font-size:11px;">Enter 10 digit phone number only</small>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" 
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }} required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input type="tel" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $member->emergency_contact) }}" 
                                   pattern="[0-9]{10}" maxlength="10" minlength="10"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" placeholder="Enter 10 digit number">
                            <small class="text-muted" style="font-size:11px;">Enter 10 digit phone number only</small>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $member->address) }}</textarea>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- FITNESS INFORMATION (ALWAYS EDITABLE)     -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-heartbeat"></i> Fitness Information
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" step="0.01" name="height" class="form-control" value="{{ old('height', $member->height) }}" id="height" onchange="calculateBMI()">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $member->weight) }}" id="weight" onchange="calculateBMI()">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">BMI</label>
                            <input type="text" name="bmi" class="form-control" id="bmi" value="{{ old('bmi', $member->bmi) }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Goal Type <span class="text-danger">*</span></label>
                            <select name="goal_type" class="form-control" required>
                                <option value="Weight Loss" {{ old('goal_type', $member->goal_type) == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                                <option value="Muscle Gain" {{ old('goal_type', $member->goal_type) == 'Muscle Gain' ? 'selected' : '' }}>Muscle Gain</option>
                                <option value="Fitness" {{ old('goal_type', $member->goal_type) == 'Fitness' ? 'selected' : '' }}>Fitness</option>
                                <option value="Body Building" {{ old('goal_type', $member->goal_type) == 'Body Building' ? 'selected' : '' }}>Body Building</option>
                                <option value="Fat Loss" {{ old('goal_type', $member->goal_type) == 'Fat Loss' ? 'selected' : '' }}>Fat Loss</option>
                                <option value="Strength Training" {{ old('goal_type', $member->goal_type) == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                            </select>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Medical Issues (if any)</label>
                            <textarea name="medical_issues" class="form-control" rows="2" placeholder="Any medical conditions or allergies">{{ old('medical_issues', $member->medical_issues) }}</textarea>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- MEMBERSHIP INFORMATION - Join Date HERE   -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-id-card"></i> Membership Information
                        @if($member->status == 'Active' && !$member->isExpired())
                            <span style="font-size:11px; color:#f59e0b; font-weight:400; margin-left:8px;">
                                <i class="fas fa-lock me-1"></i> Locked
                            </span>
                        @endif
                    </div>

                    <div class="row compact-row {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled-section' : '' }}">
                        @if($member->status == 'Active' && !$member->isExpired())
                            <div class="disabled-overlay">
                                <span class="lock-badge">
                                    <i class="fas fa-lock"></i> Locked - Plan Active
                                </span>
                            </div>
                        @endif

                        <!-- Join Date - ORIGINAL POSITION -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Join Date <span class="text-danger">*</span></label>
                            <input type="date" name="join_date" class="form-control" value="{{ old('join_date', $member->join_date) }}" 
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }} required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $member->expiry_date) }}" 
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }} readonly>
                            <small class="text-muted" style="font-size:11px;">Auto-calculated based on plan duration</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Plan Type <span class="text-danger">*</span></label>
                            <select name="plan_type" id="planType" class="form-control" required onchange="togglePlanFields()"
                                    {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled style=background:#f8f9fa;color:#6c757d;' : '' }}>
                                <option value="">-- Select Plan Type --</option>
                                <option value="membership" {{ old('plan_type', $member->plan_type) == 'membership' ? 'selected' : '' }}>Membership</option>
                                <option value="package" {{ old('plan_type', $member->plan_type) == 'package' ? 'selected' : '' }}>Package</option>
                              <!--  <option value="monthly" {{ old('plan_type', $member->plan_type) == 'monthly' ? 'selected' : '' }}>Monthly Plan</option> -->
                            </select>
                        </div>

                        <!-- Membership Plan -->
                        <div class="col-md-3 mb-3 dynamic-field" id="membershipPlanDiv">
                            <label class="form-label">Membership Plan <span class="text-danger">*</span></label>
                            <select name="membership_plan" id="membershipPlan" class="form-control" onchange="getMembershipDetails()"
                                    {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled style=background:#f8f9fa;color:#6c757d;' : '' }}>
                                <option value="">-- Select Membership --</option>
                                @foreach ($memberships as $membership)
                                    <option value="{{ $membership->plan_name }}" {{ old('membership_plan', $member->membership_plan) == $membership->plan_name ? 'selected' : '' }}>
                                        {{ $membership->plan_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Package -->
                        <div class="col-md-3 mb-3 dynamic-field" id="packageDiv">
                            <label class="form-label">Package <span class="text-danger">*</span></label>
                            <select name="package_name" id="packageName" class="form-control" onchange="getPackageDetails()"
                                    {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled style=background:#f8f9fa;color:#6c757d;' : '' }}>
                                <option value="">-- Select Package --</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->package_name }}" {{ old('package_name', $member->membership_plan) == $package->package_name ? 'selected' : '' }}>
                                        {{ $package->package_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- ===== MONTHLY PLAN FIELDS ===== -->
                    <div class="row compact-row" id="monthlyFieldsRow">
                        <div class="col-md-3 mb-3 dynamic-field" id="monthlyMonthDiv">
                            <label class="form-label">Month <span class="text-danger">*</span></label>
                            <input type="number" name="monthly_month" id="monthlyMonth" class="form-control" value="{{ old('monthly_month', $member->monthly_month) }}" placeholder="Enter months (e.g., 3)" min="1" onchange="calculateMonthlyTotal()"
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }}>
                        </div>

                        <div class="col-md-3 mb-3 dynamic-field" id="monthlyPriceDiv">
                            <label class="form-label">Price (per month) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="monthly_price" id="monthlyPrice" class="form-control" value="{{ old('monthly_price', $member->monthly_price) }}" placeholder="e.g., 500" onchange="calculateMonthlyTotal()"
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }}>
                        </div>
                    </div>

                    <!-- ===== HIDE THESE FIELDS FOR MONTHLY PLAN ===== -->
                    <div class="row compact-row" id="membershipFieldsDiv">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration_display" id="durationDisplay" class="form-control" value="{{ old('membership_duration', $member->membership_duration) }}" readonly>
                            <input type="hidden" name="membership_duration" id="membershipDuration" value="{{ old('membership_duration', $member->membership_duration) }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" name="price_display" id="priceDisplay" class="form-control" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Final Price</label>
                            <input type="text" name="final_price_display" id="finalPriceDisplay" class="form-control" value="{{ old('final_price', $member->final_price) }}" readonly>
                            <input type="hidden" name="final_price" id="finalPriceHidden" value="{{ old('final_price', $member->final_price) }}">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row compact-row" id="descriptionDiv">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description_display" id="descriptionDisplay" class="form-control" rows="2" readonly></textarea>
                        </div>
                    </div>

                    <div class="row compact-row" id="featuresDiv" style="display:none;">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Included Features</label>
                            <textarea name="features_display" id="featuresDisplay" class="form-control" rows="3" readonly></textarea>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- PAYMENT INFORMATION (LOCKED IF ACTIVE)    -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-credit-card"></i> Payment Information
                        @if($member->status == 'Active' && !$member->isExpired())
                            <span style="font-size:11px; color:#f59e0b; font-weight:400; margin-left:8px;">
                                <i class="fas fa-lock me-1"></i> Locked
                            </span>
                        @endif
                    </div>

                    <div class="row compact-row {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled-section' : '' }}">
                        @if($member->status == 'Active' && !$member->isExpired())
                            <div class="disabled-overlay">
                                <span class="lock-badge">
                                    <i class="fas fa-lock"></i> Locked - Plan Active
                                </span>
                            </div>
                        @endif

                        <!-- Payment Date - NEW -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" 
                                   value="{{ old('payment_date', $member->payment_date ?? $member->join_date) }}"
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }} required>
                            <small class="text-muted" style="font-size:11px;">Date when payment was made</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Payment Type</label>
                            <select name="payment_type" id="paymentType" class="form-control" onchange="togglePaymentFields()"
                                    {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled style=background:#f8f9fa;color:#6c757d;' : '' }}>
                                <option value="">-- Select Payment Type --</option>
                                <option value="hand" {{ old('payment_type', $member->payment_type) == 'hand' ? 'selected' : '' }}>Hand Payment</option>
                                <option value="online" {{ old('payment_type', $member->payment_type) == 'online' ? 'selected' : '' }}>Online Payment</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 dynamic-field" id="transactionIdDiv">
                            <label class="form-label">Transaction ID</label>
                            <input type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id', $member->transaction_id) }}" placeholder="Enter transaction ID"
                                   {{ ($member->status == 'Active' && !$member->isExpired()) ? 'readonly style=background:#f8f9fa;color:#6c757d;' : '' }}>
                        </div>

                        <div class="col-md-12 mb-3 dynamic-field" id="screenshotDiv">
                            <label class="form-label">Upload Screenshot</label>
                            @if ($member->payment_screenshot)
                                <div class="current-photo">
                                    <img src="{{ asset('storage/' . $member->payment_screenshot) }}" alt="Payment Screenshot" style="width:50px; height:50px; border-radius:8px; object-fit:cover; border:2px solid var(--border-color);">
                                    <span class="photo-label"><i class="fas fa-check-circle text-success"></i> Current</span>
                                </div>
                            @endif
                            <div class="file-input-wrapper">
                                <div class="file-input-container">
                                    <div class="file-label">
                                        <i class="fas fa-image"></i>
                                        <span>Choose screenshot</span>
                                    </div>
                                    <input type="file" name="payment_screenshot" accept="image/*" id="paymentScreenshot" onchange="updateScreenshotFileName()"
                                           {{ ($member->status == 'Active' && !$member->isExpired()) ? 'disabled style=background:#f8f9fa;color:#6c757d;' : '' }}>
                                </div>
                                <span class="file-name" id="screenshotFileName">
                                    <span class="no-file">No file chosen</span>
                                </span>
                            </div>
                            <small class="text-muted" style="font-size:11px;">Leave empty to keep current screenshot</small>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- RENEWAL PAYMENT FIELD (Only if expired)   -->
                    <!-- ========================================== -->
                    @if($member->status == 'Inactive' || $member->isExpired())
                    <div class="row compact-row" id="renewalPaymentDiv">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                <i class="fas fa-credit-card" style="color: #10b981;"></i> Renewal Payment Amount
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" name="renewal_amount" class="form-control" placeholder="Enter renewal payment amount" value="{{ old('renewal_amount', $member->final_price) }}" required>
                            <small class="text-muted">This will be recorded in payment history for finance reports.</small>
                            @error('renewal_amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- ASSIGNMENT                                 -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-user-tag"></i> Assignment
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assign Trainer</label>
                            <select name="trainer_id" class="form-control">
                                <option value="">-- Select Trainer --</option>
                                @foreach ($trainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ old('trainer_id', $member->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                        {{ $trainer->name }} ({{ $trainer->specialization }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- ✅ STATUS - MOVED TO BOTTOM (BELOW ASSIGNMENT) -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-toggle-on"></i> Status
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="Active" {{ old('status', $member->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $member->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <small class="text-muted" style="font-size:11px;">Change member status (Active/Inactive)</small>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- FORM ACTIONS                              -->
                    <!-- ========================================== -->
                    <div class="form-actions">
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

    <script>
        // ============================================
        // PROFILE PHOTO - FILE NAME UPDATE
        // ============================================
        function updateFileName() {
            var input = document.getElementById('profilePhoto');
            var display = document.getElementById('fileNameDisplay');

            if (input.files && input.files.length > 0) {
                var fileName = input.files[0].name;
                if (fileName.length > 30) {
                    fileName = fileName.substring(0, 27) + '...';
                }
                display.innerHTML = '<span class="selected-file"><i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + fileName + '</span>';
            } else {
                display.innerHTML = '<span class="no-file">No file chosen</span>';
            }
        }

        // ============================================
        // PAYMENT SCREENSHOT - FILE NAME UPDATE
        // ============================================
        function updateScreenshotFileName() {
            var input = document.getElementById('paymentScreenshot');
            var display = document.getElementById('screenshotFileName');

            if (input.files && input.files.length > 0) {
                var fileName = input.files[0].name;
                if (fileName.length > 30) {
                    fileName = fileName.substring(0, 27) + '...';
                }
                display.innerHTML = '<span class="selected-file"><i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + fileName + '</span>';
            } else {
                display.innerHTML = '<span class="no-file">No file chosen</span>';
            }
        }

        // ============================================
        // CALCULATE BMI
        // ============================================
        function calculateBMI() {
            let height = document.getElementById('height').value;
            let weight = document.getElementById('weight').value;

            if (height > 0 && weight > 0) {
                let heightInMeters = height / 100;
                let bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
                document.getElementById('bmi').value = bmi;
            }
        }

        // ============================================
        // AUTO-CALCULATE AGE FROM DOB
        // ============================================
        function calculateAgeFromDOB() {
            var dobInput = document.getElementById('dob');
            var ageInput = document.getElementById('age');
            
            if (dobInput && dobInput.value) {
                var birthDate = new Date(dobInput.value);
                var today = new Date();
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                
                ageInput.value = age;
            }
        }

        // ============================================
        // TOGGLE PLAN FIELDS
        // ============================================
        function togglePlanFields() {
            let planType = document.getElementById('planType').value;

            document.getElementById('membershipPlanDiv').classList.remove('show');
            document.getElementById('packageDiv').classList.remove('show');
            document.getElementById('monthlyMonthDiv').classList.remove('show');
            document.getElementById('monthlyPriceDiv').classList.remove('show');

            if (planType == 'membership') {
                document.getElementById('membershipPlanDiv').classList.add('show');
                document.getElementById('membershipFieldsDiv').style.display = 'flex';
                document.getElementById('descriptionDiv').style.display = 'flex';
                document.getElementById('packageName').value = '';
                clearFields();
                let membershipPlan = document.getElementById('membershipPlan');
                if (membershipPlan.value) {
                    getMembershipDetails();
                }
            } else if (planType == 'package') {
                document.getElementById('packageDiv').classList.add('show');
                document.getElementById('membershipFieldsDiv').style.display = 'flex';
                document.getElementById('descriptionDiv').style.display = 'flex';
                document.getElementById('membershipPlan').value = '';
                clearFields();
                let packageName = document.getElementById('packageName');
                if (packageName.value) {
                    getPackageDetails();
                }
            } else if (planType == 'monthly') {
                document.getElementById('monthlyMonthDiv').classList.add('show');
                document.getElementById('monthlyPriceDiv').classList.add('show');
                document.getElementById('membershipFieldsDiv').style.display = 'none';
                document.getElementById('descriptionDiv').style.display = 'none';
                document.getElementById('featuresDiv').style.display = 'none';
                clearFields();
                calculateMonthlyTotal();
            } else {
                document.getElementById('membershipFieldsDiv').style.display = 'none';
                document.getElementById('descriptionDiv').style.display = 'none';
                clearFields();
            }
        }

        // ============================================
        // GET MEMBERSHIP DETAILS
        // ============================================
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

        // ============================================
        // GET PACKAGE DETAILS
        // ============================================
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

        // ============================================
        // CALCULATE MONTHLY TOTAL
        // ============================================
        function calculateMonthlyTotal() {
            let month = document.getElementById('monthlyMonth').value;
            let price = document.getElementById('monthlyPrice').value;

            if (month && price && price > 0) {
                let total = parseFloat(month) * parseFloat(price);
                document.getElementById('finalPriceDisplay').value = '₹ ' + total.toFixed(2);
                document.getElementById('finalPriceHidden').value = total.toFixed(2);
                document.getElementById('durationDisplay').value = month + ' Month(s)';
                document.getElementById('membershipDuration').value = month + ' Month(s)';
                document.getElementById('priceDisplay').value = '₹ ' + price + ' × ' + month + ' months';
                document.getElementById('descriptionDisplay').value = 'Monthly Plan - ' + month + ' Month(s) at ₹' + price + '/month';
            }
        }

        // ============================================
        // TOGGLE PAYMENT FIELDS
        // ============================================
        function togglePaymentFields() {
            let paymentType = document.getElementById('paymentType').value;

            document.getElementById('transactionIdDiv').classList.remove('show');
            document.getElementById('screenshotDiv').classList.remove('show');

            if (paymentType == 'online') {
                document.getElementById('transactionIdDiv').classList.add('show');
                document.getElementById('screenshotDiv').classList.add('show');
            }
        }

        // ============================================
        // CLEAR FIELDS
        // ============================================
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

        // ============================================
        // AUTO-LOAD ON PAGE LOAD
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            let planType = document.getElementById('planType').value;
            let membershipPlan = document.getElementById('membershipPlan');
            let packageName = document.getElementById('packageName');

            if (planType == 'membership' && membershipPlan.value) {
                getMembershipDetails();
            } else if (planType == 'package' && packageName.value) {
                getPackageDetails();
            } else if (planType == 'monthly') {
                document.getElementById('monthlyMonthDiv').classList.add('show');
                document.getElementById('monthlyPriceDiv').classList.add('show');
                document.getElementById('membershipFieldsDiv').style.display = 'none';
                document.getElementById('descriptionDiv').style.display = 'none';
                document.getElementById('featuresDiv').style.display = 'none';
                calculateMonthlyTotal();
            }

            togglePaymentFields();

            var dobInput = document.getElementById('dob');
            if (dobInput) {
                dobInput.addEventListener('change', calculateAgeFromDOB);
                dobInput.addEventListener('blur', calculateAgeFromDOB);
                calculateAgeFromDOB();
            }
        });
    </script>
@endsection