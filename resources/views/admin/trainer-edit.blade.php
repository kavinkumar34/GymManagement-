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

        /* ============================================ */
        /* CARD STYLES                                 */
        /* ============================================ */
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

        /* ============================================ */
        /* SECTION HEADERS                             */
        /* ============================================ */
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

        /* ============================================ */
        /* FORM STYLES                                 */
        /* ============================================ */
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

        /* ============================================ */
        /* DROPDOWN - SAME AS INPUTS                   */
        /* ============================================ */
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

        /* Firefox fix */
        select.form-control:-moz-focusring {
            color: #1a1a2e !important;
            text-shadow: 0 0 0 #1a1a2e !important;
        }

        /* ============================================ */
        /* FILE INPUT WITH FILE NAME                  */
        /* ============================================ */
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

        /* ============================================ */
        /* COMPACT ROW                                */
        /* ============================================ */
        .compact-row {
            margin-bottom: 0;
        }

        .compact-row .mb-3 {
            margin-bottom: 10px !important;
        }

        /* ============================================ */
        /* BUTTON STYLES                               */
        /* ============================================ */
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

        /* ============================================ */
        /* RESPONSIVE                                  */
        /* ============================================ */
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
                    <h4><i class="fas fa-edit"></i> Edit Trainer</h4>
                    <small>Update trainer details</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-id-card"></i> {{ $trainer->trainer_id }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.trainer.update', $trainer->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $trainer->name) }}" required>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male" {{ old('gender', $trainer->gender) == 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female" {{ old('gender', $trainer->gender) == 'Female' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="Other" {{ old('gender', $trainer->gender) == 'Other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                value="{{ old('dob', $trainer->dob) }}">
                        </div>
                    </div>

                    <div class="row compact-row">
                        <!-- Phone Number -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control"
                                value="{{ old('phone', $trainer->phone) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $trainer->email) }}" required>
                        </div>

                        <!-- Profile Photo -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Profile Photo</label>
                            @if ($trainer->photo)
                                <div class="current-photo">
                                    <img src="{{ asset('storage/' . $trainer->photo) }}" alt="{{ $trainer->name }}">
                                    <span class="photo-label"><i class="fas fa-check-circle text-success"></i> Current
                                        Photo</span>
                                </div>
                            @endif
                            <div class="file-input-wrapper">
                                <div class="file-input-container">
                                    <div class="file-label">
                                        <i class="fas fa-camera"></i>
                                        <span>Choose photo</span>
                                    </div>
                                    <input type="file" name="photo" accept="image/*" id="profilePhoto"
                                        onchange="updateFileName()">
                                </div>
                                <span class="file-name" id="fileNameDisplay">
                                    <span class="no-file">No file chosen</span>
                                </span>
                            </div>
                            <small class="text-muted" style="font-size:11px;">Leave empty to keep current photo</small>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <!-- Address -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $trainer->address) }}</textarea>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- PROFESSIONAL INFORMATION                   -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-briefcase"></i> Professional Information
                    </div>

                    <div class="row compact-row">
                        <!-- Experience -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Experience (years)</label>
                            <input type="number" name="experience" class="form-control"
                                value="{{ old('experience', $trainer->experience) }}" min="0">
                        </div>

                        <!-- Specialization -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Specialization</label>
                            <select name="specialization" class="form-control">
                                <option value="Cardio"
                                    {{ old('specialization', $trainer->specialization) == 'Cardio' ? 'selected' : '' }}>
                                    Cardio</option>
                                <option value="Yoga"
                                    {{ old('specialization', $trainer->specialization) == 'Yoga' ? 'selected' : '' }}>Yoga
                                </option>
                                <option value="Weight Training"
                                    {{ old('specialization', $trainer->specialization) == 'Weight Training' ? 'selected' : '' }}>
                                    Weight Training</option>
                                <option value="CrossFit"
                                    {{ old('specialization', $trainer->specialization) == 'CrossFit' ? 'selected' : '' }}>
                                    CrossFit</option>
                                <option value="Zumba"
                                    {{ old('specialization', $trainer->specialization) == 'Zumba' ? 'selected' : '' }}>
                                    Zumba</option>
                                <option value="Body Building"
                                    {{ old('specialization', $trainer->specialization) == 'Body Building' ? 'selected' : '' }}>
                                    Body Building</option>
                                <option value="Personal Training"
                                    {{ old('specialization', $trainer->specialization) == 'Personal Training' ? 'selected' : '' }}>
                                    Personal Training</option>
                            </select>
                        </div>

                        <!-- Salary -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Salary (₹ per month)</label>
                            <input type="number" step="0.01" name="salary" class="form-control"
                                value="{{ old('salary', $trainer->salary) }}">
                        </div>

                        <!-- Join Date -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Join Date</label>
                            <input type="date" name="join_date" class="form-control"
                                value="{{ old('join_date', $trainer->join_date) }}">
                        </div>
                    </div>

                    <div class="row compact-row">
                        <!-- Shift Timing -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shift Timing</label>
                            <select name="shift_timing" class="form-control">
                                <option value="Morning (6AM-12PM)"
                                    {{ old('shift_timing', $trainer->shift_timing) == 'Morning (6AM-12PM)' ? 'selected' : '' }}>
                                    Morning (6AM-12PM)</option>
                                <option value="Evening (12PM-6PM)"
                                    {{ old('shift_timing', $trainer->shift_timing) == 'Evening (12PM-6PM)' ? 'selected' : '' }}>
                                    Evening (12PM-6PM)</option>
                                <option value="Night (6PM-10PM)"
                                    {{ old('shift_timing', $trainer->shift_timing) == 'Night (6PM-10PM)' ? 'selected' : '' }}>
                                    Night (6PM-10PM)</option>
                                <option value="Full Day"
                                    {{ old('shift_timing', $trainer->shift_timing) == 'Full Day' ? 'selected' : '' }}>Full
                                    Day</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active"
                                    {{ old('status', $trainer->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive"
                                    {{ old('status', $trainer->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <!-- Certifications -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Certifications</label>
                            <textarea name="certification" class="form-control" rows="2"
                                placeholder="List your certifications and qualifications">{{ old('certification', $trainer->certification) }}</textarea>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- FORM ACTIONS                              -->
                    <!-- ========================================== -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Trainer
                        </button>
                        <a href="{{ route('admin.trainers') }}" class="btn btn-secondary">
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
                display.innerHTML =
                    '<span class="selected-file"><i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + fileName +
                    '</span>';
            } else {
                display.innerHTML = '<span class="no-file">No file chosen</span>';
            }
        }
    </script>
@endsection
