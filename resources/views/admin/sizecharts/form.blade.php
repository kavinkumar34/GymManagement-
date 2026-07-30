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
        max-width: 1100px;
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

    .form-control[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
        color: var(--gray);
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
    /* FILE INPUT                                  */
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

    /* ============================================ */
    /* SIZE ROW                                    */
    /* ============================================ */
    .size-row {
        background: var(--light-gray);
        padding: 14px 16px;
        border-radius: var(--radius);
        margin-bottom: 10px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px;
    }

    .size-row:hover {
        background: #fff;
        border-color: var(--primary);
        box-shadow: 0 2px 10px rgba(74, 158, 255, 0.08);
    }

    .size-row .field-group {
        flex: 1;
        min-width: 80px;
    }

    .size-row .field-group .field-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--gray);
        margin-bottom: 2px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .size-row .field-group input {
        font-size: 13px;
        height: 34px;
        padding: 5px 10px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        width: 100%;
        transition: all 0.3s;
        background: #fff;
        color: var(--dark);
    }

    .size-row .field-group input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .size-row .remove-size {
        margin-top: 18px;
        height: 34px;
        padding: 0 14px;
        border: none;
        border-radius: var(--radius);
        background: #fce4ec;
        color: #c62828;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        font-weight: 500;
        flex-shrink: 0;
    }

    .size-row .remove-size:hover {
        background: #ef5350;
        color: #fff;
        transform: scale(1.05);
    }

    /* ============================================ */
    /* CATEGORY TYPE BADGE                         */
    /* ============================================ */
    .category-type-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }

    .category-type-badge.topwear {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .category-type-badge.bottomwear {
        background: #fff3e0;
        color: #e65100;
    }

    .category-type-badge.footwear {
        background: #e0f7fa;
        color: #00838f;
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

    .btn-add-size {
        background: #e3f2fd;
        color: #1565c0;
        border: none;
        padding: 7px 18px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-add-size:hover {
        background: #4a9eff;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 158, 255, 0.3);
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

        .size-row {
            flex-direction: column;
            padding: 12px 14px;
        }

        .size-row .field-group {
            min-width: 100%;
        }

        .size-row .remove-size {
            margin-top: 4px;
            width: 100%;
            justify-content: center;
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

        .btn-add-size {
            font-size: 12px;
            padding: 6px 14px;
        }

        .file-input-wrapper .file-label {
            font-size: 12px;
            padding: 5px 10px;
            height: 34px;
        }

        .file-input-wrapper .file-name {
            font-size: 11px;
        }

        .size-row .field-group input {
            font-size: 12px;
            height: 30px;
        }

        .size-row .field-group .field-label {
            font-size: 9px;
        }

        .current-image img {
            width: 40px;
            height: 40px;
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
                <h4><i class="fas fa-{{ isset($sizeChart) ? 'edit' : 'plus' }}"></i> {{ isset($sizeChart) ? 'Edit Size Chart' : 'Add Size Chart' }}</h4>
                <small style="opacity:0.8;">{{ isset($sizeChart) ? 'Update size chart details' : 'Create a new size chart' }}</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> {{ isset($sizeChart) ? 'Edit Mode' : 'Create Mode' }}
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

            <form action="{{ isset($sizeChart) ? route('admin.sizecharts.update', $sizeChart->id) : route('admin.sizecharts.store') }}" 
                  method="POST" enctype="multipart/form-data" id="sizeChartForm">
                @csrf
                @if (isset($sizeChart))
                    @method('PUT')
                @endif

                <!-- ========================================== -->
                <!-- BASIC INFORMATION                          -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-info-circle"></i> Basic Information
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $sizeChart->title ?? '') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="men" {{ old('gender', $sizeChart->gender ?? '') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('gender', $sizeChart->gender ?? '') == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="kids" {{ old('gender', $sizeChart->gender ?? '') == 'kids' ? 'selected' : '' }}>Kids</option>
                            <option value="unisex" {{ old('gender', $sizeChart->gender ?? '') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Category Type <span class="text-danger">*</span></label>
                        <select name="category_type" id="category_type" class="form-control" required>
                            <option value="topwear" {{ old('category_type', $sizeChart->category_type ?? '') == 'topwear' ? 'selected' : '' }}>Topwear</option>
                            <option value="bottomwear" {{ old('category_type', $sizeChart->category_type ?? '') == 'bottomwear' ? 'selected' : '' }}>Bottomwear</option>
                            <option value="footwear" {{ old('category_type', $sizeChart->category_type ?? '') == 'footwear' ? 'selected' : '' }}>Footwear</option>
                        </select>
                        <small class="text-muted" style="font-size:11px;" id="categoryTypeHint">Select category to show relevant measurements</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        @if(isset($sizeChart) && $sizeChart->image)
                            <div class="current-image">
                                <img src="{{ asset('storage/'.$sizeChart->image) }}" alt="{{ $sizeChart->title }}">
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
                        <small class="text-muted" style="font-size:11px;">Leave empty to keep current image</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Default Unit</label>
                        <select name="default_unit" class="form-control">
                            <option value="in" {{ old('default_unit', $sizeChart->default_unit ?? '') == 'in' ? 'selected' : '' }}>Inches (in)</option>
                            <option value="cm" {{ old('default_unit', $sizeChart->default_unit ?? '') == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                        </select>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SIZE MEASUREMENTS                         -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-ruler"></i> Size Measurements
                    <span id="categoryTypeDisplay" class="category-type-badge topwear ms-2">Topwear</span>
                    <small class="text-muted ms-2" id="fieldInfo" style="font-size:12px;">(Size, Chest, Waist, Length, Sleeve)</small>
                </div>

                <div id="sizes-container">
                    @php
                        $sizes = [];
                        if (isset($sizeChart) && $sizeChart->sizes) {
                            if (is_array($sizeChart->sizes)) {
                                $sizes = $sizeChart->sizes;
                            } else {
                                $sizes = json_decode($sizeChart->sizes, true) ?: [];
                            }
                        }
                        $categoryType = old('category_type', $sizeChart->category_type ?? 'topwear');
                        $sizeIndex = 0;
                    @endphp

                    @if (count($sizes) > 0)
                        @foreach ($sizes as $index => $size)
                            <div class="size-row" data-category="{{ $categoryType }}" id="size-row-{{ $sizeIndex }}">
                                <div class="field-group">
                                    <label class="field-label">Size *</label>
                                    <input type="text" name="sizes[{{ $sizeIndex }}][size]" placeholder="e.g., S, M, L" value="{{ $size['size'] ?? '' }}" required>
                                </div>

                                <div class="field-group topwear-field" style="{{ $categoryType == 'topwear' ? 'display:block;' : 'display:none;' }}">
                                    <label class="field-label">Chest</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][chest]" placeholder="Chest" value="{{ $size['chest'] ?? '' }}">
                                </div>

                                <div class="field-group bottomwear-field topwear-field" style="{{ ($categoryType == 'topwear' || $categoryType == 'bottomwear') ? 'display:block;' : 'display:none;' }}">
                                    <label class="field-label">Waist</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][waist]" placeholder="Waist" value="{{ $size['waist'] ?? '' }}">
                                </div>

                                <div class="field-group all-category-field">
                                    <label class="field-label">Length</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][length]" placeholder="Length" value="{{ $size['length'] ?? '' }}">
                                </div>

                                <div class="field-group bottomwear-field" style="{{ $categoryType == 'bottomwear' ? 'display:block;' : 'display:none;' }}">
                                    <label class="field-label">Inseam</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][inseam]" placeholder="Inseam" value="{{ $size['inseam'] ?? '' }}">
                                </div>

                                <div class="field-group topwear-field" style="{{ $categoryType == 'topwear' ? 'display:block;' : 'display:none;' }}">
                                    <label class="field-label">Sleeve</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][sleeve]" placeholder="Sleeve" value="{{ $size['sleeve'] ?? '' }}">
                                </div>

                                <div class="field-group footwear-field" style="{{ $categoryType == 'footwear' ? 'display:block;' : 'display:none;' }}">
                                    <label class="field-label">Width</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][width]" placeholder="Width" value="{{ $size['width'] ?? '' }}">
                                </div>

                                <div class="field-group footwear-field" style="{{ $categoryType == 'footwear' ? 'display:block;' : 'display:none;' }}">
                                    <label class="field-label">Heel</label>
                                    <input type="number" step="0.1" name="sizes[{{ $sizeIndex }}][heel]" placeholder="Heel" value="{{ $size['heel'] ?? '' }}">
                                </div>

                                <button type="button" class="remove-size" onclick="removeSizeRow(this)">✕</button>
                            </div>
                            @php $sizeIndex++; @endphp
                        @endforeach
                    @else
                        <div class="size-row" data-category="{{ $categoryType }}" id="size-row-0">
                            <div class="field-group">
                                <label class="field-label">Size *</label>
                                <input type="text" name="sizes[0][size]" placeholder="e.g., S, M, L" required>
                            </div>

                            <div class="field-group topwear-field" style="{{ $categoryType == 'topwear' ? 'display:block;' : 'display:none;' }}">
                                <label class="field-label">Chest</label>
                                <input type="number" step="0.1" name="sizes[0][chest]" placeholder="Chest">
                            </div>

                            <div class="field-group bottomwear-field topwear-field" style="{{ ($categoryType == 'topwear' || $categoryType == 'bottomwear') ? 'display:block;' : 'display:none;' }}">
                                <label class="field-label">Waist</label>
                                <input type="number" step="0.1" name="sizes[0][waist]" placeholder="Waist">
                            </div>

                            <div class="field-group all-category-field">
                                <label class="field-label">Length</label>
                                <input type="number" step="0.1" name="sizes[0][length]" placeholder="Length">
                            </div>

                            <div class="field-group bottomwear-field" style="{{ $categoryType == 'bottomwear' ? 'display:block;' : 'display:none;' }}">
                                <label class="field-label">Inseam</label>
                                <input type="number" step="0.1" name="sizes[0][inseam]" placeholder="Inseam">
                            </div>

                            <div class="field-group topwear-field" style="{{ $categoryType == 'topwear' ? 'display:block;' : 'display:none;' }}">
                                <label class="field-label">Sleeve</label>
                                <input type="number" step="0.1" name="sizes[0][sleeve]" placeholder="Sleeve">
                            </div>

                            <div class="field-group footwear-field" style="{{ $categoryType == 'footwear' ? 'display:block;' : 'display:none;' }}">
                                <label class="field-label">Width</label>
                                <input type="number" step="0.1" name="sizes[0][width]" placeholder="Width">
                            </div>

                            <div class="field-group footwear-field" style="{{ $categoryType == 'footwear' ? 'display:block;' : 'display:none;' }}">
                                <label class="field-label">Heel</label>
                                <input type="number" step="0.1" name="sizes[0][heel]" placeholder="Heel">
                            </div>

                            <button type="button" class="remove-size" onclick="removeSizeRow(this)">✕</button>
                        </div>
                        @php $sizeIndex++; @endphp
                    @endif
                </div>

                <button type="button" class="btn-add-size mt-2" onclick="addSizeRow()">
                    <i class="fas fa-plus"></i> Add Size
                </button>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($sizeChart) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.sizecharts.index') }}" class="btn btn-secondary">
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
// UPDATE FIELDS BY CATEGORY
// ============================================
function updateFieldsByCategory(categoryType) {
    var badge = document.getElementById('categoryTypeDisplay');
    var fieldInfo = document.getElementById('fieldInfo');
    var categoryNames = {
        'topwear': 'Topwear',
        'bottomwear': 'Bottomwear',
        'footwear': 'Footwear'
    };
    var fieldNames = {
        'topwear': '(Size, Chest, Waist, Length, Sleeve)',
        'bottomwear': '(Size, Waist, Length, Inseam)',
        'footwear': '(Size, Length, Width, Heel)'
    };

    badge.textContent = categoryNames[categoryType] || 'Topwear';
    badge.className = 'category-type-badge ' + categoryType;
    fieldInfo.textContent = fieldNames[categoryType] || '';

    var rows = document.querySelectorAll('.size-row');

    rows.forEach(function(row) {
        if (categoryType === 'topwear') {
            row.querySelectorAll('.topwear-field').forEach(function(el) {
                el.style.display = 'block';
            });
            row.querySelectorAll('.bottomwear-field').forEach(function(el) {
                if (el.classList.contains('topwear-field')) {
                    el.style.display = 'block';
                } else {
                    el.style.display = 'none';
                }
            });
            row.querySelectorAll('.footwear-field').forEach(function(el) {
                el.style.display = 'none';
            });
        } else if (categoryType === 'bottomwear') {
            row.querySelectorAll('.bottomwear-field').forEach(function(el) {
                el.style.display = 'block';
            });
            row.querySelectorAll('.topwear-field').forEach(function(el) {
                if (el.classList.contains('bottomwear-field')) {
                    el.style.display = 'block';
                } else {
                    el.style.display = 'none';
                }
            });
            row.querySelectorAll('.footwear-field').forEach(function(el) {
                el.style.display = 'none';
            });
        } else if (categoryType === 'footwear') {
            row.querySelectorAll('.footwear-field').forEach(function(el) {
                el.style.display = 'block';
            });
            row.querySelectorAll('.topwear-field').forEach(function(el) {
                el.style.display = 'none';
            });
            row.querySelectorAll('.bottomwear-field').forEach(function(el) {
                el.style.display = 'none';
            });
        }
    });

    var hint = document.getElementById('categoryTypeHint');
    var hintTexts = {
        'topwear': 'Topwear measurements: Size, Chest, Waist, Length, Sleeve',
        'bottomwear': 'Bottomwear measurements: Size, Waist, Length, Inseam',
        'footwear': 'Footwear measurements: Size, Length, Width, Heel'
    };
    hint.textContent = hintTexts[categoryType] || 'Select category type to show relevant measurements';
}

// ============================================
// CATEGORY TYPE CHANGE
// ============================================
document.getElementById('category_type')?.addEventListener('change', function() {
    updateFieldsByCategory(this.value);
});

// ============================================
// ADD SIZE ROW
// ============================================
var sizeIndex = {{ isset($sizeChart) && $sizeChart->sizes ? (is_array($sizeChart->sizes) ? count($sizeChart->sizes) : count(json_decode($sizeChart->sizes, true))) : 1 }};

function addSizeRow() {
    var container = document.getElementById('sizes-container');
    var categoryType = document.getElementById('category_type').value;
    var rowId = sizeIndex;

    var div = document.createElement('div');
    div.className = 'size-row';
    div.setAttribute('data-category', categoryType);
    div.id = 'size-row-' + rowId;

    var chestDisplay = (categoryType === 'topwear') ? 'block' : 'none';
    var waistDisplay = (categoryType === 'topwear' || categoryType === 'bottomwear') ? 'block' : 'none';
    var inseamDisplay = (categoryType === 'bottomwear') ? 'block' : 'none';
    var sleeveDisplay = (categoryType === 'topwear') ? 'block' : 'none';
    var widthDisplay = (categoryType === 'footwear') ? 'block' : 'none';
    var heelDisplay = (categoryType === 'footwear') ? 'block' : 'none';

    div.innerHTML = `
        <div class="field-group">
            <label class="field-label">Size *</label>
            <input type="text" name="sizes[${rowId}][size]" placeholder="e.g., S, M, L" required>
        </div>
        <div class="field-group topwear-field" style="display:${chestDisplay};">
            <label class="field-label">Chest</label>
            <input type="number" step="0.1" name="sizes[${rowId}][chest]" placeholder="Chest">
        </div>
        <div class="field-group bottomwear-field topwear-field" style="display:${waistDisplay};">
            <label class="field-label">Waist</label>
            <input type="number" step="0.1" name="sizes[${rowId}][waist]" placeholder="Waist">
        </div>
        <div class="field-group all-category-field">
            <label class="field-label">Length</label>
            <input type="number" step="0.1" name="sizes[${rowId}][length]" placeholder="Length">
        </div>
        <div class="field-group bottomwear-field" style="display:${inseamDisplay};">
            <label class="field-label">Inseam</label>
            <input type="number" step="0.1" name="sizes[${rowId}][inseam]" placeholder="Inseam">
        </div>
        <div class="field-group topwear-field" style="display:${sleeveDisplay};">
            <label class="field-label">Sleeve</label>
            <input type="number" step="0.1" name="sizes[${rowId}][sleeve]" placeholder="Sleeve">
        </div>
        <div class="field-group footwear-field" style="display:${widthDisplay};">
            <label class="field-label">Width</label>
            <input type="number" step="0.1" name="sizes[${rowId}][width]" placeholder="Width">
        </div>
        <div class="field-group footwear-field" style="display:${heelDisplay};">
            <label class="field-label">Heel</label>
            <input type="number" step="0.1" name="sizes[${rowId}][heel]" placeholder="Heel">
        </div>
        <button type="button" class="remove-size" onclick="removeSizeRow(this)">✕</button>
    `;

    container.appendChild(div);
    sizeIndex++;
}

// ============================================
// REMOVE SIZE ROW
// ============================================
function removeSizeRow(btn) {
    var row = btn.closest('.size-row');
    var rows = document.querySelectorAll('.size-row');
    if (rows.length <= 1) {
        alert('At least one size row is required!');
        return;
    }
    if (confirm('Remove this size row?')) {
        row.remove();
    }
}

// ============================================
// INITIAL SETUP
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    var categoryType = document.getElementById('category_type').value;
    updateFieldsByCategory(categoryType);
});
</script>

@endsection