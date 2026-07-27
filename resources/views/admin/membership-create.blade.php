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
        .create-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 1100px;
            margin: 0 auto;
        }

        .create-card .card-header {
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

        .create-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .create-card .card-header h4 i {
            color: #4a9eff;
        }

        .create-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .create-card .card-body {
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

        .form-control,
        .form-select {
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

        .form-control:focus,
        .form-select:focus {
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
        select.form-control,
        select.form-select {
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

        select.form-control option,
        select.form-select option {
            padding: 8px 12px;
            color: #1a1a2e !important;
            background: #ffffff !important;
        }

        select.form-control option:hover,
        select.form-control option:focus,
        select.form-select option:hover,
        select.form-select option:focus {
            background: #e8f4fd !important;
            color: #1a1a2e !important;
        }

        select.form-control option:checked,
        select.form-select option:checked {
            background: #d4e8fc !important;
            color: #1a1a2e !important;
        }

        select.form-control:focus,
        select.form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            color: #1a1a2e !important;
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

        /* ============================================ */
        /* IMAGE PREVIEW                               */
        /* ============================================ */
        .image-preview-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .image-preview-container .preview-img {
            display: none;
            width: 120px;
            height: 120px;
            border-radius: var(--radius);
            border: 2px solid var(--border-color);
            object-fit: cover;
            box-shadow: var(--shadow);
        }

        .image-preview-container .preview-img.show {
            display: inline-block;
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
        .btn-success {
            background: #4caf50;
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

        .btn-success:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(76, 175, 80, 0.35);
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
            margin-top: 10px;
        }

        /* ============================================ */
        /* ERROR ALERT                                 */
        /* ============================================ */
        .alert-danger {
            background: #fce4ec;
            color: #c62828;
            border-left: 4px solid #ef5350;
            border-radius: var(--radius);
            padding: 12px 18px;
            margin-bottom: 16px;
            border: none;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        /* ============================================ */
        /* RESPONSIVE                                  */
        /* ============================================ */
        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .create-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .create-card .card-header h4 {
                font-size: 16px;
            }

            .create-card .card-body {
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

            .image-preview-container .preview-img {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 576px) {
            .create-card .card-header h4 {
                font-size: 14px;
            }

            .create-card .card-body {
                padding: 10px 12px;
            }

            .form-label {
                font-size: 11px;
            }

            .form-control,
            .form-select {
                font-size: 12px;
                padding: 5px 10px;
                height: 34px;
            }

            .section-title {
                font-size: 12px;
                padding: 5px 10px;
            }

            .btn-success,
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

            .image-preview-container .preview-img {
                width: 80px;
                height: 80px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="create-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-id-card"></i> Add Membership</h4>
                    <small>Create new membership plan</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> Active Form
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.membership.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- ========================================== -->
                    <!-- PLAN INFORMATION                           -->
                    <!-- ========================================== -->
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Plan Information
                    </div>

                    <div class="row compact-row">
                        <!-- Plan Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" name="plan_name" class="form-control" value="{{ old('plan_name') }}"
                                required>
                        </div>

                        <!-- Image -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Membership Image</label>
                            <div class="file-input-wrapper">
                                <div class="file-input-container">
                                    <div class="file-label">
                                        <i class="fas fa-image"></i>
                                        <span>Choose image</span>
                                    </div>
                                    <input type="file" name="image" id="image" accept="image/*"
                                        onchange="previewImage(event)">
                                </div>
                                <span class="file-name" id="fileNameDisplay">
                                    <span class="no-file">No file chosen</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div class="row compact-row">
                        <div class="col-md-12">
                            <div class="image-preview-container">
                                <img id="preview" class="preview-img" src="">
                            </div>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- PRICING & DURATION                         -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-clock"></i> Pricing & Duration
                    </div>

                    <div class="row compact-row">
                        <!-- Duration -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration <span class="text-danger">*</span></label>
                            <input type="number" name="duration" class="form-control" value="{{ old('duration') }}"
                                required>
                        </div>

                        <!-- Duration Type -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration Type <span class="text-danger">*</span></label>
                            <select name="duration_type" class="form-control">
                                <option value="Days">Days</option>
                                <option value="Months" selected>Months</option>
                                <option value="Years">Years</option>
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" id="price" name="price" class="form-control"
                                value="{{ old('price') }}" onkeyup="calculatePrice()" onchange="calculatePrice()" required>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <!-- Discount Type -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Discount Type</label>
                            <select name="discount_type" id="discount_type" class="form-control"
                                onchange="calculatePrice()">
                                <option value="Flat">Flat (₹)</option>
                                <option value="Percentage">Percentage (%)</option>
                            </select>
                        </div>

                        <!-- Discount -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Discount</label>
                            <input type="number" step="0.01" id="discount" name="discount" value="0"
                                class="form-control" onkeyup="calculatePrice()" onchange="calculatePrice()">
                        </div>

                        <!-- Final Price -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Final Price</label>
                            <input type="text" id="final_price" name="final_price" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- DESCRIPTION & STATUS                      -->
                    <!-- ========================================== -->
                    <div class="section-title mt-2">
                        <i class="fas fa-cog"></i> Additional Details
                    </div>

                    <div class="row compact-row">
                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- FORM ACTIONS                              -->
                    <!-- ========================================== -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Membership
                        </button>
                        <a href="{{ route('admin.membership.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function calculatePrice() {
            let price = parseFloat(document.getElementById('price').value) || 0;
            let discount = parseFloat(document.getElementById('discount').value) || 0;
            let type = document.getElementById('discount_type').value;
            let finalPrice = price;

            if (type == "Flat") {
                finalPrice = price - discount;
            } else {
                finalPrice = price - ((price * discount) / 100);
            }

            if (finalPrice < 0) {
                finalPrice = 0;
            }

            document.getElementById('final_price').value = '₹ ' + finalPrice.toFixed(2);
        }

        function previewImage(event) {
            let reader = new FileReader();
            reader.onload = function() {
                let output = document.getElementById('preview');
                output.src = reader.result;
                output.className = 'preview-img show';
            }
            reader.readAsDataURL(event.target.files[0]);

            // Update file name
            let input = document.getElementById('image');
            let display = document.getElementById('fileNameDisplay');
            if (input.files && input.files.length > 0) {
                let fileName = input.files[0].name;
                if (fileName.length > 30) {
                    fileName = fileName.substring(0, 27) + '...';
                }
                display.innerHTML =
                    '<span class="selected-file"><i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + fileName +
                    '</span>';
            }
        }

        // Initial calculation
        document.addEventListener('DOMContentLoaded', function() {
            calculatePrice();
        });
    </script>

@endsection
