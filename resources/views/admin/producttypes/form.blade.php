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
        --shadow-hover: 0 8px 35px rgba(0,0,0,0.12);
        --radius: 10px;
        --radius-lg: 16px;
    }

    .admin-main-content {
        padding: 20px 25px !important;
        background: #f0f4f8;
        min-height: 100vh;
        margin-left: 270px !important;
        width: auto !important;
        max-width: calc(100% - 270px) !important;
        box-sizing: border-box;
    }

    /* ============================================ */
    /* FORM CARD                                   */
    /* ============================================ */
    .form-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card .card-header {
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

    .form-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card .card-header h4 i {
        color: #4a9eff;
    }

    .form-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .form-card .card-body {
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

    /* ============================================ */
    /* TOGGLE SWITCH                               */
    /* ============================================ */
    .form-check {
        padding-left: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-check-input {
        width: 44px;
        height: 22px;
        background: #e5e7eb;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: 0.3s;
        position: relative;
        flex-shrink: 0;
        margin: 0;
        appearance: none;
        -webkit-appearance: none;
    }

    .form-check-input:checked {
        background: #4caf50;
    }

    .form-check-input::before {
        content: "";
        position: absolute;
        height: 18px;
        width: 18px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }

    .form-check-input:checked::before {
        transform: translateX(22px);
    }

    .form-check-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
        cursor: pointer;
        margin: 0;
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

    .current-image {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
        padding: 8px 12px;
        background: var(--light-gray);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .current-image img {
        width: 60px;
        height: 60px;
        border-radius: var(--radius);
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .current-image .image-label {
        font-size: 12px;
        color: var(--gray);
    }

    .text-muted {
        font-size: 11px;
        color: var(--gray) !important;
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

    .invalid-feedback {
        font-size: 12px;
        color: var(--danger);
        margin-top: 4px;
        display: block;
    }

    /* ============================================ */
    /* RESPONSIVE                                  */
    /* ============================================ */
    @media (max-width: 992px) {
        .admin-main-content {
            margin-left: 70px !important;
            max-width: calc(100% - 70px) !important;
            padding: 15px 18px !important;
        }
    }

    @media (max-width: 768px) {
        .admin-main-content {
            margin-left: 0 !important;
            max-width: 100% !important;
            padding: 12px 15px !important;
        }

        .form-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .form-card .card-header h4 {
            font-size: 16px;
        }

        .form-card .card-body {
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

        .current-image img {
            width: 48px;
            height: 48px;
        }
    }

    @media (max-width: 576px) {
        .form-card .card-header h4 {
            font-size: 14px;
        }

        .form-card .card-body {
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

        .form-check-input {
            width: 36px;
            height: 18px;
        }

        .form-check-input::before {
            height: 14px;
            width: 14px;
            left: 2px;
            bottom: 2px;
        }

        .form-check-input:checked::before {
            transform: translateX(18px);
        }

        .form-check-label {
            font-size: 12px;
        }
    }
</style>

<!-- ============================================ -->
<!-- MAIN CONTENT                                -->
<!-- ============================================ -->
<div class="admin-main-content">
    <div class="form-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-{{ isset($productType) ? 'edit' : 'plus' }}"></i> {{ isset($productType) ? 'Edit Product Type' : 'Add Product Type' }}</h4>
                <small style="opacity:0.8;">{{ isset($productType) ? 'Update product type details' : 'Create a new product type' }}</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-circle" style="font-size:6px; color:{{ isset($productType) ? '#ffa726' : '#4caf50' }};"></i> {{ isset($productType) ? 'Edit Mode' : 'Create Mode' }}
            </span>
        </div>

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

            @if (session('error'))
                <div class="alert-danger">
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ isset($productType) ? route('admin.producttypes.update', $productType->id) : route('admin.producttypes.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($productType))
                    @method('PUT')
                @endif

                <!-- ========================================== -->
                <!-- PRODUCT TYPE DETAILS                      -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-info-circle"></i> Product Type Details
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <select name="name" class="form-control @error('name') is-invalid @enderror" required>
                            <option value="">Select Product Type</option>
                            <option value="Top Wear" {{ old('name', $productType->name ?? '') == 'Top Wear' ? 'selected' : '' }}>
                                👕 Top Wear
                            </option>
                            <option value="Bottom Wear" {{ old('name', $productType->name ?? '') == 'Bottom Wear' ? 'selected' : '' }}>
                                👖 Bottom Wear
                            </option>
                            <option value="Foot Wear" {{ old('name', $productType->name ?? '') == 'Foot Wear' ? 'selected' : '' }}>
                                👟 Foot Wear
                            </option>
                        </select>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $productType->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        @if (isset($productType) && $productType->image)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $productType->image) }}" alt="{{ $productType->name }}">
                                <span class="image-label"><i class="fas fa-check-circle text-success"></i> Current Image</span>
                            </div>
                        @endif
                        <div class="file-input-wrapper">
                            <div class="file-input-container">
                                <div class="file-label">
                                    <i class="fas fa-image"></i>
                                    <span>Choose image</span>
                                </div>
                                <input type="file" name="image" id="image" accept="image/*" onchange="updateFileName()">
                            </div>
                            <span class="file-name" id="fileNameDisplay">
                                <span class="no-file">No file chosen</span>
                            </span>
                        </div>
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check" style="margin-top: 28px;">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="is_active" {{ old('is_active', $productType->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-circle" style="font-size:8px; color:#4caf50;"></i> Active
                            </label>
                        </div>
                        <small class="text-muted">Enable to make this product type active and visible</small>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($productType) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.producttypes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- SCRIPTS                                      -->
<!-- ============================================ -->
<script>
// ============================================
// FILE NAME UPDATE
// ============================================
function updateFileName() {
    var input = document.getElementById('image');
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
// AUTO-HIDE ERRORS
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    var alerts = document.querySelectorAll('.alert-danger');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 3000);
    });
});
</script>

@endsection