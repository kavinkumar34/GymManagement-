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
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --radius: 10px;
        --radius-lg: 16px;
    }

    .admin-main-content {
        padding: 20px 25px;
        background: #f0f4f8;
        min-height: 100vh;
    }

    .register-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 1100px;
        margin: 0 auto;
    }

    .register-card .card-header {
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

    .register-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .register-card .card-header h4 i {
        color: #4a9eff;
    }

    .register-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .register-card .card-body {
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
        background: #fff;
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
    }

    .file-input-wrapper .file-input-container {
        position: relative;
        flex: 1;
        height: 38px;
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
        background: #fff;
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

    .dynamic-field {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .dynamic-field.show {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    .date-readonly {
        background: #f8f9fa !important;
        color: #6c757d !important;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }

        .register-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .register-card .card-header h4 {
            font-size: 16px;
        }

        .register-card .card-body {
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
    }

    @media (max-width: 576px) {
        .register-card .card-header h4 {
            font-size: 14px;
        }

        .register-card .card-body {
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
    }
</style>

<div class="admin-main-content">
    <div class="register-card">
        <!-- Header -->
        <div class="card-header">
            <div>
                <h4><i class="fas fa-user-plus"></i> Member Registration</h4>
                <small>Register new gym member</small>
            </div>
            <div>
                <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> Active Form
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">
            <form method="POST" action="{{ route('admin.member.store') }}" enctype="multipart/form-data" id="memberForm">
                @csrf
                
                <!-- ========================================== -->
                <!-- PERSONAL INFORMATION                       -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-user"></i> Personal Information
                </div>

                <div class="row compact-row">
                    <!-- Full Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <!-- Profile Photo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profile Photo</label>
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
                    </div>
                </div>

                <div class="row compact-row">
                    <!-- Register Date - NEW, READONLY, AUTO-FILLED -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Register Date <span class="text-danger">*</span></label>
                        <input type="date" name="register_date" class="form-control date-readonly" 
                               value="{{ date('Y-m-d') }}" readonly>
                        <small class="text-muted" style="font-size:11px;">Auto-filled, cannot be changed</small>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-control" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" id="dob" onchange="calculateAge()">
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" 
                               pattern="[0-9]{10}" maxlength="10" minlength="10"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
                        <small class="text-muted" style="font-size:11px;">Enter 10 digit phone number only</small>
                    </div>
                </div>

                <div class="row compact-row">
                    <!-- Email -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Emergency Contact</label>
                        <input type="tel" name="emergency_contact" class="form-control" 
                               pattern="[0-9]{10}" maxlength="10" minlength="10"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" 
                               placeholder="Emergency phone number">
                        <small class="text-muted" style="font-size:11px;">Enter 10 digit phone number only</small>
                    </div>

                    <!-- Address -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FITNESS INFORMATION                        -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-heartbeat"></i> Fitness Information
                </div>

                <div class="row compact-row">
                    <!-- Height -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" step="0.01" name="height" class="form-control" id="height" onchange="calculateBMI()">
                    </div>

                    <!-- Weight -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" class="form-control" id="weight" onchange="calculateBMI()">
                    </div>

                    <!-- BMI -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">BMI</label>
                        <input type="text" name="bmi" class="form-control" id="bmi" readonly>
                    </div>

                    <!-- Goal Type -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Goal Type <span class="text-danger">*</span></label>
                        <select name="goal_type" class="form-control" required>
                            <option value="Weight Loss">Weight Loss</option>
                            <option value="Muscle Gain">Muscle Gain</option>
                            <option value="Fitness">Fitness</option>
                            <option value="Body Building">Body Building</option>
                            <option value="Strength Training">Strength Training</option>
                            <option value="Fat Loss">Fat Loss</option>
                        </select>
                    </div>
                </div>

                <div class="row compact-row">
                    <!-- Medical Issues -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Medical Issues (if any)</label>
                        <textarea name="medical_issues" class="form-control" rows="2" placeholder="Any medical conditions or allergies"></textarea>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- MEMBERSHIP INFORMATION - Join Date HERE    -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-id-card"></i> Membership Information
                </div>

                <div class="row compact-row">
                    <!-- Join Date - ORIGINAL POSITION -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Join Date <span class="text-danger">*</span></label>
                        <input type="date" name="join_date" class="form-control" 
                               value="{{ date('Y-m-d') }}" id="joinDate" required>
                        <small class="text-muted" style="font-size:11px;">Membership start date</small>
                    </div>

                    <!-- Plan Type -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Plan Type <span class="text-danger">*</span></label>
                        <select name="plan_type" id="planType" class="form-control" required onchange="togglePlanFields()">
                            <option value="">-- Select Plan Type --</option>
                            <option value="membership">Membership</option>
                            <option value="package">Package</option>
                            <option value="monthly">Monthly Plan</option>
                        </select>
                    </div>

                    <!-- Membership Plan -->
                    <div class="col-md-3 mb-3 dynamic-field" id="membershipPlanDiv">
                        <label class="form-label">Membership Plan <span class="text-danger">*</span></label>
                        <select name="membership_plan" id="membershipPlan" class="form-control" onchange="getMembershipDetails()">
                            <option value="">-- Select Membership --</option>
                            @foreach($memberships as $membership)
                                <option value="{{ $membership->plan_name }}">{{ $membership->plan_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Package -->
                    <div class="col-md-3 mb-3 dynamic-field" id="packageDiv">
                        <label class="form-label">Package <span class="text-danger">*</span></label>
                        <select name="package_name" id="packageName" class="form-control" onchange="getPackageDetails()">
                            <option value="">-- Select Package --</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->package_name }}">{{ $package->package_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- ===== MONTHLY PLAN FIELDS ===== -->
                <div class="row compact-row dynamic-field" id="monthlyFieldsDiv">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Month <span class="text-danger">*</span></label>
                        <input type="number" name="monthly_month" id="monthlyMonth" class="form-control" placeholder="Enter months (e.g., 3)" min="1" onchange="calculateMonthlyTotal()">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Price (per month) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="monthly_price" id="monthlyPrice" class="form-control" placeholder="e.g., 500" onchange="calculateMonthlyTotal()">
                    </div>
                </div>

                <!-- ===== HIDE THESE FIELDS FOR MONTHLY PLAN ===== -->
                <div class="row compact-row" id="membershipFieldsDiv">
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

                    <!-- Status -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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
                    <!-- Included Features -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Included Features</label>
                        <textarea name="features_display" id="featuresDisplay" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- PAYMENT INFORMATION - UPDATED              -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-credit-card"></i> Payment Information
                </div>

                <div class="row compact-row">
                    <!-- Payment Date - NEW -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" class="form-control" 
                               value="{{ date('Y-m-d') }}" id="paymentDate" required>
                        <small class="text-muted" style="font-size:11px;">Date when payment was made</small>
                    </div>

                    <!-- Payment Type -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                        <select name="payment_type" id="paymentType" class="form-control" required onchange="togglePaymentFields()">
                            <option value="">-- Select Payment Type --</option>
                            <option value="hand">Hand Payment</option>
                            <option value="online">Online Payment</option>
                        </select>
                    </div>

                    <!-- Transaction ID (Dynamic - Online Payment) -->
                    <div class="col-md-4 mb-3 dynamic-field" id="transactionIdDiv">
                        <label class="form-label">Transaction ID <span class="text-danger">*</span></label>
                        <input type="text" name="transaction_id" id="transactionId" class="form-control" placeholder="Enter transaction ID">
                    </div>
                </div>

                <div class="row compact-row">
                    <!-- Upload Screenshot (Dynamic - Online Payment) -->
                    <div class="col-md-12 mb-3 dynamic-field" id="screenshotDiv">
                        <label class="form-label">Upload Screenshot</label>
                        <div class="file-input-wrapper">
                            <div class="file-input-container">
                                <div class="file-label">
                                    <i class="fas fa-image"></i>
                                    <span>Choose screenshot</span>
                                </div>
                                <input type="file" name="payment_screenshot" accept="image/*" id="paymentScreenshot" onchange="updateScreenshotFileName()">
                            </div>
                            <span class="file-name" id="screenshotFileName">
                                <span class="no-file">No file chosen</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- ASSIGNMENT                                 -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-user-tag"></i> Assignment
                </div>

                <div class="row compact-row">
                    <!-- Assign Trainer -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assign Trainer</label>
                        <select name="trainer_id" class="form-control">
                            <option value="">-- Select Trainer --</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}">{{ $trainer->name }} ({{ $trainer->specialization }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
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
// CALCULATE AGE
// ============================================
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
        console.log('Age:', age);
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
// TOGGLE PLAN FIELDS
// ============================================
function togglePlanFields() {
    let planType = document.getElementById('planType').value;
    
    document.getElementById('membershipPlanDiv').classList.remove('show');
    document.getElementById('packageDiv').classList.remove('show');
    document.getElementById('monthlyFieldsDiv').classList.remove('show');
    
    if (planType == 'membership') {
        document.getElementById('membershipPlanDiv').classList.add('show');
        document.getElementById('membershipFieldsDiv').style.display = 'flex';
        document.getElementById('descriptionDiv').style.display = 'flex';
    } else if (planType == 'package') {
        document.getElementById('packageDiv').classList.add('show');
        document.getElementById('membershipFieldsDiv').style.display = 'flex';
        document.getElementById('descriptionDiv').style.display = 'flex';
    } else if (planType == 'monthly') {
        document.getElementById('monthlyFieldsDiv').classList.add('show');
        document.getElementById('membershipFieldsDiv').style.display = 'none';
        document.getElementById('descriptionDiv').style.display = 'none';
        document.getElementById('featuresDiv').style.display = 'none';
    }
    
    clearFields();
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
    } else {
        document.getElementById('finalPriceDisplay').value = '';
        document.getElementById('finalPriceHidden').value = '';
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
    document.getElementById('monthlyMonth').value = '';
    document.getElementById('monthlyPrice').value = '';
}

// ============================================
// INITIALIZE
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    togglePlanFields();
    togglePaymentFields();
});
</script>

<!-- Hidden field for membership duration -->
<input type="hidden" name="membership_duration" id="membershipDurationHidden" form="memberForm">

@endsection