@extends('layouts.admin-layout')

@section('content')
    <style>
        .form-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-section-header {
            background: #f8f9fa;
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }

        .form-section-body {
            padding: 20px;
        }

        .image-preview-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .image-preview-item {
            position: relative;
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-item .remove-img {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: red;
            color: white;
            border: none;
            font-size: 12px;
            cursor: pointer;
        }

        .required-star {
            color: red;
        }

        .image-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload-area:hover {
            border-color: #0d6efd;
            background: #f8f9fa;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
            margin-right: 10px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .toggle-label {
            font-weight: 500;
            margin-top: 5px;
        }

        .toggle-status {
            font-weight: 600;
            margin-left: 5px;
        }

        .toggle-status.active {
            color: #28a745;
        }

        .toggle-status.inactive {
            color: #dc3545;
        }

        .size-chart-badge {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
            margin-left: 5px;
        }

        .size-chart-badge.men {
            background: #cfe2ff;
            color: #084298;
        }

        .size-chart-badge.women {
            background: #f8d7da;
            color: #721c24;
        }

        .size-chart-badge.kids {
            background: #d1e7dd;
            color: #0f5132;
        }

        .size-chart-badge.unisex {
            background: #e2d9f3;
            color: #4b0082;
        }

        .size-chart-badge.topwear {
            background: #fff3cd;
            color: #856404;
        }

        .size-chart-badge.bottomwear {
            background: #d6d8db;
            color: #1e2124;
        }

        .size-chart-badge.footwear {
            background: #fce4ec;
            color: #c62828;
        }

        .product-type-loading,
        .subcategory-loading {
            display: none;
            color: #0d6efd;
            font-size: 12px;
            margin-top: 5px;
        }

        .product-type-loading .spinner,
        .subcategory-loading .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .help-text {
            font-size: 11px;
            color: #6c757d;
            margin-top: 3px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 4px;
            display: block;
        }

        .variant-section {
            display: none;
            margin-top: 20px;
        }

        .variant-section.active {
            display: block;
        }

        .variant-item {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            position: relative;
            transition: all 0.3s;
        }

        .variant-item:hover {
            border-color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
        }

        .variant-item .variant-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .variant-item .variant-number {
            font-weight: 600;
            color: #0d6efd;
            font-size: 16px;
        }

        .variant-item .remove-variant {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 14px;
        }

        .variant-item .remove-variant:hover {
            color: #bd2130;
        }

        .variant-total-stock {
            background: #e7f3ff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .variant-total-stock .label {
            font-weight: 600;
            color: #0d6efd;
        }

        .variant-total-stock .value {
            font-size: 20px;
            font-weight: 700;
            color: #28a745;
        }

        .size-row {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
        }

        .size-row .form-control {
            flex: 1;
            min-width: 70px;
            font-size: 12px;
        }

        .size-row .form-control-sm {
            font-size: 12px;
        }

        .size-row .remove-size {
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
            padding: 0 5px;
        }

        .size-row .remove-size:hover {
            color: #bd2130;
        }

        .size-calculation {
            font-size: 11px;
            color: #6c757d;
            padding: 5px 8px;
            background: #e9ecef;
            border-radius: 4px;
            white-space: nowrap;
        }

        .variant-image-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .variant-image-upload-area:hover {
            border-color: #0d6efd;
            background: #f8f9fa;
        }

        .variant-image-preview-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .variant-image-preview-item {
            position: relative;
            width: 70px;
            height: 70px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .variant-image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .variant-image-preview-item .remove-img {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: red;
            color: white;
            border: none;
            font-size: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hidden-section {
            display: none !important;
        }

        .product-type-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .product-type-info .title {
            font-weight: 600;
            color: #856404;
        }

        .gst-badge {
            display: inline-block;
            background: #0d6efd;
            color: white;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            margin-left: 5px;
        }

        .gst-info {
            background: #e7f3ff;
            border-left: 4px solid #0d6efd;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .gst-info .gst-label {
            font-weight: 600;
            color: #0d6efd;
        }

        .calculation-flow {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 12px;
        }

        .calculation-flow .step {
            background: white;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid #dee2e6;
            font-size: 12px;
        }

        .calculation-flow .step .highlight {
            font-weight: 700;
            color: #0d6efd;
        }

        .calculation-flow .step .highlight.green {
            color: #28a745;
        }

        .calculation-flow .arrow {
            font-size: 16px;
            color: #6c757d;
        }

        .grand-total-stock {
            background: #d4edda;
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #28a745;
        }

        .grand-total-stock .label {
            font-weight: 700;
            color: #155724;
            font-size: 15px;
        }

        .grand-total-stock .value {
            font-size: 24px;
            font-weight: 700;
            color: #28a745;
        }

        /* Hide variant fields when section is not active */
        .variant-section:not(.active) .variant-item {
            display: none;
        }
    </style>

    <div class="container">
        <div class="row" style="margin-left:220px; margin-right:20px;">
            <div class="col-12">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-plus-circle me-2 text-primary"></i> Add New Product
                    </div>
                    <div class="form-section-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
                            id="productForm" novalidate>
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Basic Information -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Basic Information</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Product Name <span
                                                        class="required-star">*</span></label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Top Category <span
                                                            class="required-star">*</span></label>
                                                    <select name="top_category_id" id="top_category" class="form-control"
                                                        required>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($topCategories as $tc)
                                                            <option value="{{ $tc->id }}"
                                                                data-gst="{{ $tc->gst_rate ?? 0 }}">
                                                                {{ $tc->name }}
                                                                @if ($tc->gst_rate)
                                                                    (GST: {{ $tc->gst_rate }}%)
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="gst_selected_info">Select top category to
                                                        auto-fill GST</div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Category <span
                                                            class="required-star">*</span></label>
                                                    <select name="category_id" id="category" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Sub Category <span
                                                            class="required-star">*</span></label>
                                                    <select name="sub_category_id" id="sub_category" class="form-control"
                                                        required>
                                                        <option value="">-- Select Category First --</option>
                                                    </select>
                                                    <div class="subcategory-loading" id="subCategoryLoading">
                                                        <i class="fas fa-spinner spinner"></i> Loading sub categories...
                                                    </div>
                                                    <div class="help-text" id="subCategoryHelper">Select a category to load
                                                        sub categories</div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="field-label">Brand</label>
                                                    <select name="brand_id" class="form-control">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($brands as $b)
                                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="field-label">Product Type</label>
                                                    <select name="product_type_id" id="product_type_id" class="form-control"
                                                        onchange="toggleVariantSections(this.value)">
                                                        <option value="">-- Select Category First --</option>
                                                    </select>
                                                    <div class="product-type-loading" id="productTypeLoading">
                                                        <i class="fas fa-spinner spinner"></i> Loading product types...
                                                    </div>
                                                    <div class="help-text" id="productTypeHelper">Select a category to load
                                                        product types</div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="field-label">Size Chart</label>
                                                    <select name="size_chart_id" id="size_chart_id" class="form-control">
                                                        <option value="">-- Select Size Chart --</option>
                                                        @foreach ($sizeCharts ?? [] as $sc)
                                                            <option value="{{ $sc->id }}"
                                                                data-gender="{{ $sc->gender ?? 'unisex' }}"
                                                                data-category="{{ $sc->category_type ?? 'topwear' }}">
                                                                {{ $sc->title }}
                                                                <span
                                                                    class="size-chart-badge {{ $sc->gender ?? 'unisex' }}">{{ ucfirst($sc->gender ?? 'Unisex') }}</span>
                                                                <span
                                                                    class="size-chart-badge {{ $sc->category_type ?? 'topwear' }}">{{ ucfirst($sc->category_type ?? 'Topwear') }}</span>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="sizeChartHelper">Select a size chart for this
                                                        product</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing, GST & Discount (Normal Mode) -->
                                    <!-- Pricing, GST & Discount (Normal Mode) -->
                                    <div class="card mb-3" id="pricingSection">
                                        <div class="card-header bg-light">
                                            Pricing, GST & Discount
                                            <span id="gst_badge" class="gst-badge" style="display:none;">
                                                <i class="fas fa-sync-alt fa-spin"></i> Loading GST...
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="gst-info" id="gst_info_box" style="display:none;">
                                                <span class="gst-label"><i class="fas fa-percent"></i> GST Rate:</span>
                                                <span id="gst_rate_display">0%</span>
                                                <span style="margin-left: 15px;" class="gst-label"><i
                                                        class="fas fa-calculator"></i> GST Amt:</span>
                                                <span id="gst_amount_display">₹0.00</span>
                                                <span
                                                    style="margin-left: 15px; color: #6c757d; font-size: 12px;">(Calculated
                                                    on SP)</span>
                                            </div>

                                            <div class="calculation-flow" id="calculation_flow">
                                                <span class="step">SP: <span class="highlight"
                                                        id="flow_selling">₹0</span></span>
                                                <span class="arrow">+</span>
                                                <span class="step">GST: <span class="highlight"
                                                        id="flow_gst">₹0</span></span>
                                                <span class="arrow">=</span>
                                                <span class="step">Total: <span class="highlight"
                                                        id="flow_total_price">₹0</span></span>
                                                <span class="arrow">-</span>
                                                <span class="step">Disc: <span class="highlight"
                                                        id="flow_discount">₹0</span></span>
                                                <span class="arrow">=</span>
                                                <span class="step"
                                                    style="border-color: #28a745; background: #d4edda;">Final: <span
                                                        class="highlight green" id="flow_final">₹0</span></span>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Cost Price (₹) <span
                                                            class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="price"
                                                            id="price" class="form-control" required min="0"
                                                            value="0">
                                                    </div>
                                                    <div class="help-text">Your purchase price</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">MRP (₹) <span
                                                            class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="mrp"
                                                            id="mrp" class="form-control" required min="0"
                                                            value="0" oninput="calculateAll()">
                                                    </div>
                                                    <div class="help-text">Maximum Retail Price</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Discount Type</label>
                                                    <div class="discount-type-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="discount_type" id="discount_flat" value="flat"
                                                                checked onchange="calculateAll()">
                                                            <label class="form-check-label"
                                                                for="discount_flat">Flat</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="discount_type" id="discount_percentage"
                                                                value="percentage" onchange="calculateAll()">
                                                            <label class="form-check-label"
                                                                for="discount_percentage">%</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Discount Value</label>
                                                    <input type="number" step="0.01" name="discount_value"
                                                        id="discount_value" class="form-control" min="0"
                                                        value="0" oninput="calculateAll()">
                                                    <div class="help-text" id="discount_value_hint">Enter discount amount
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">GST Amt (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="gst_amount_field"
                                                            class="form-control" readonly
                                                            style="background-color: #e9ecef; font-weight: bold; color: #0d6efd;">
                                                    </div>
                                                    <div class="help-text" id="gst_calc_info">GST on MRP</div>
                                                </div>

                                                <!-- NEW: Total Price Field (MRP + GST) -->
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Total Price (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="total_price_field"
                                                            class="form-control" readonly
                                                            style="background-color: #fff3cd; font-weight: bold; color: #856404; border-color: #ffc107;">
                                                    </div>
                                                    <div class="help-text">MRP + GST</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Disc Amt (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="discount_amount_display"
                                                            class="form-control" readonly
                                                            style="background-color: #e9ecef; font-weight: bold; color: #dc3545;">
                                                    </div>
                                                    <div class="help-text" id="discount_calc_info">Calculated from
                                                        discount</div>
                                                </div>
                                            </div>

                                            <!-- Final Price row -->
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Final Price (₹) <span
                                                            class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="final_price"
                                                            id="final_price" class="form-control" readonly
                                                            style="background-color: #d4edda; font-weight: bold; color: #28a745; font-size: 18px;">
                                                    </div>
                                                    <div class="help-text">Total Price - Discount</div>
                                                </div>

                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="final-amount-box"
                                                                style="border-color: #dc3545; background: #f8f9fa; border: 2px solid #dc3545; border-radius: 8px; padding: 15px 20px; text-align: center;">
                                                                <div class="label"
                                                                    style="font-size:13px; color:#6c757d; font-weight:500;">
                                                                    You Save</div>
                                                                <div class="amount" id="saved_amount"
                                                                    style="font-size:28px; font-weight:bold; color:#28a745;">
                                                                    ₹0.00</div>
                                                                <div class="discount-info" id="discount_percent_info"
                                                                    style="font-size:12px; color:#6c757d; margin-top:5px;">
                                                                    0% off</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="final-amount-box"
                                                                style="border-color: #28a745; background: #f8f9fa; border: 2px solid #28a745; border-radius: 8px; padding: 15px 20px; text-align: center;">
                                                                <div class="label"
                                                                    style="font-size:13px; color:#6c757d; font-weight:500;">
                                                                    Final Price (Customer Pays)</div>
                                                                <div class="amount" id="final_total_display"
                                                                    style="font-size:28px; font-weight:bold; color:#28a745;">
                                                                    ₹0.00</div>
                                                                <div class="discount-info"
                                                                    style="font-size:12px; color:#6c757d; margin-top:5px;">
                                                                    Incl. GST</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Variant Section -->
                                    <div class="variant-section" id="variantSection">
                                        <div class="card mb-3">
                                            <div class="card-header bg-light">
                                                <i class="fas fa-palette me-2"></i> Variant Details
                                                <span class="text-muted" style="font-size:12px; margin-left:10px;"
                                                    id="variantTypeLabel">Top Wear</span>
                                                <span class="gst-badge"
                                                    style="background:#0d6efd; color:white; padding:2px 10px; border-radius:12px; font-size:11px; margin-left:5px;"
                                                    id="variantGstBadge">GST: 0%</span>
                                            </div>
                                            <div class="card-body" id="variantContainer">
                                                <!-- Default Variant -->
                                                <div class="variant-item" id="variant-default">
                                                    <div class="variant-header">
                                                        <span class="variant-number"><i class="fas fa-palette me-2"></i>
                                                            Variant #1</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="field-label">Color <span
                                                                class="required-star">*</span></label>
                                                        <input type="text" name="variants[default][color]"
                                                            id="variant_color" class="form-control variant-required"
                                                            placeholder="e.g., Red, Blue, Black">
                                                        <div class="help-text">Enter color name for this variant</div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="field-label">Images <span
                                                                class="required-star">*</span> <span
                                                                class="text-muted">(Multiple images allowed)</span></label>
                                                        <div class="variant-image-upload-area"
                                                            onclick="document.getElementById('variant_images_input_default').click()">
                                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                            <p class="mb-0">Click to upload variant images</p>
                                                        </div>
                                                        <input type="file" id="variant_images_input_default"
                                                            name="variants[default][images][]" class="form-control mt-2"
                                                            accept="image/*" multiple style="display: none;"
                                                            onchange="previewVariantImages(this, 'default')">
                                                        <div id="variant_images_preview_default"
                                                            class="variant-image-preview-container mt-2"></div>
                                                        <div class="help-text">Upload multiple images for this variant
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="field-label">Sizes <span
                                                                class="required-star">*</span></label>
                                                        <div id="sizesContainer_default" class="sizes-container">
                                                            <div class="size-row">
                                                                <input type="text"
                                                                    name="variants[default][sizes][0][size]"
                                                                    class="form-control form-control-sm variant-required"
                                                                    placeholder="Size" style="min-width:70px;">
                                                                <input type="number" step="0.01"
                                                                    name="variants[default][sizes][0][cost_price]"
                                                                    class="form-control form-control-sm variant-required"
                                                                    placeholder="Cost Price" min="0"
                                                                    style="min-width:90px;"
                                                                    oninput="calculateSizePrice(this, 'default', 0)">
                                                                <input type="number" step="0.01"
                                                                    name="variants[default][sizes][0][mrp]"
                                                                    class="form-control form-control-sm variant-required"
                                                                    placeholder="MRP" min="0"
                                                                    style="min-width:90px;"
                                                                    oninput="calculateSizePrice(this, 'default', 0)">
                                                                <input type="number"
                                                                    name="variants[default][sizes][0][stock]"
                                                                    class="form-control form-control-sm variant-stock"
                                                                    placeholder="Stock" min="0"
                                                                    style="min-width:70px;" oninput="updateAllStocks()"
                                                                    onchange="updateAllStocks()">
                                                                <select name="variants[default][sizes][0][discount_type]"
                                                                    class="form-control form-control-sm"
                                                                    style="width:80px;"
                                                                    onchange="calculateSizePrice(this, 'default', 0)">
                                                                    <option value="flat">Flat</option>
                                                                    <option value="percentage">%</option>
                                                                </select>
                                                                <input type="number" step="0.01"
                                                                    name="variants[default][sizes][0][discount_value]"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="Disc" min="0" style="width:80px;"
                                                                    oninput="calculateSizePrice(this, 'default', 0)">
                                                                <span class="size-calculation"
                                                                    id="sizeCalc_default_0">GST: ₹0.00 | Total: ₹0.00 |
                                                                    Final: ₹0.00</span>
                                                                <span class="remove-size"
                                                                    onclick="removeSize(this, 'default')">✕</span>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-sm btn-secondary mt-2 add-size-btn"
                                                            data-variant="default">
                                                            <i class="fas fa-plus me-1"></i> Add Size
                                                        </button>
                                                    </div>

                                                    <div class="variant-total-stock">
                                                        <span class="label"><i class="fas fa-cubes me-1"></i> Variant
                                                            Total Stock</span>
                                                        <span class="value" id="totalVariantStock_default">0</span>
                                                    </div>
                                                </div>

                                                <div id="additionalVariants"></div>

                                                <div class="mt-3">
                                                    <button type="button" id="addVariantBtn"
                                                        class="btn btn-primary w-100">
                                                        <i class="fas fa-plus me-1"></i> Add Another Variant
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <i class="fas fa-align-left me-2"></i> Full Description
                                            <small class="text-muted">(Supports bullet points, bold, formatting)</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Description <span class="text-muted">(Use
                                                        bullet points with ● or -)</span></label>
                                                <textarea name="description" id="description" class="form-control" rows="8"
                                                    placeholder="Enter product description with bullet points...
Example:
• Soft and baby-friendly fabric
• Reusable and washable for daily use
• Comfortable fit for babies
• Good absorbency for dryness
• Gentle on delicate baby skin
• Eco-friendly and budget-friendly choice
• Ideal for everyday wear, naps, and travel"></textarea>
                                                <div class="help-text">
                                                    <i class="fas fa-info-circle"></i> Use <code>•</code> or <code>-</code>
                                                    for bullet points. HTML supported.
                                                </div>
                                            </div>

                                            <div class="mt-3" id="descriptionPreview" style="display:none;">
                                                <label class="fw-bold">Preview:</label>
                                                <div class="border rounded p-3 bg-light" id="descriptionPreviewContent">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card mb-3" id="inventorySection">
                                        <div class="card-header bg-light">Inventory & Status</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Stock Qty <span
                                                        class="required-star">*</span></label>
                                                <input type="number" name="stock" id="stock" class="form-control"
                                                    value="0" min="0" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="Draft">Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3" id="productImagesSection">
                                        <div class="card-header bg-light">Product Images</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="d-block field-label">Images <span
                                                        class="required-star">*</span> <span
                                                        class="text-muted">(1-4)</span></label>
                                                <div class="image-upload-area"
                                                    onclick="document.getElementById('product_images_input').click()">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                    <p class="mb-0">Click to upload images</p>
                                                </div>
                                                <input type="file" id="product_images_input" name="images[]"
                                                    class="form-control mt-2" accept="image/*" multiple
                                                    style="display: block;" onchange="previewImages(this)">
                                                <div id="images_preview" class="image-preview-container mt-3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Return & Delivery</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Cash on Delivery (COD)</label>
                                                <div class="d-flex align-items-center mt-2">
                                                    <label class="switch">
                                                        <input type="checkbox" name="cod_available" id="cod_toggle"
                                                            value="1" checked>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <span class="toggle-label">Status: <span id="cod_status"
                                                            class="toggle-status active">Available</span></span>
                                                </div>
                                                <div class="help-text">Toggle to enable/disable COD</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Return Days</label>
                                                <select name="return_days" class="form-control">
                                                    <option value="3">3 Days</option>
                                                    <option value="7">7 Days</option>
                                                    <option value="15">15 Days</option>
                                                    <option value="30" selected>30 Days</option>
                                                    <option value="0">Non-returnable</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Delivery Days</label>
                                                <select name="delivery_days" class="form-control">
                                                    <option value="1">1 Day</option>
                                                    <option value="2">2 Days</option>
                                                    <option value="3" selected>3 Days</option>
                                                    <option value="5">5 Days</option>
                                                    <option value="7">7 Days</option>
                                                    <option value="10">10 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3" id="grandTotalStockSection" style="display:none;">
                                        <div class="card-header bg-light" style="background: #d4edda;">
                                            <i class="fas fa-cubes me-2 text-success"></i> Grand Total Stock
                                        </div>
                                        <div class="card-body">
                                            <div class="grand-total-stock">
                                                <span class="label"><i class="fas fa-boxes me-2"></i> Total Stock (All
                                                    Variants)</span>
                                                <span class="value" id="grandTotalStock">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Save Product
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 ms-2">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var currentGstRate = 0;
            var variantIdCounter = 1;
            var variantImageFiles = {};
            var isVariantMode = false;

            // ===== CALCULATE SIZE PRICE =====
            window.calculateSizePrice = function(element, variantId, sizeIndex) {
                var row = $(element).closest('.size-row');
                var costPrice = parseFloat(row.find('input[name*="[cost_price]"]').val()) || 0;
                var mrp = parseFloat(row.find('input[name*="[mrp]"]').val()) || 0;
                var discountType = row.find('select[name*="[discount_type]"]').val() || 'flat';
                var discountValue = parseFloat(row.find('input[name*="[discount_value]"]').val()) || 0;
                var gstRate = currentGstRate || 0;

                // Calculate GST on MRP
                var gstAmount = (mrp * gstRate) / 100;
                var totalPrice = mrp + gstAmount;

                // Calculate discount amount
                var discountAmount = 0;
                if (discountType === 'flat') {
                    discountAmount = discountValue;
                } else {
                    discountAmount = (mrp * discountValue) / 100;
                }

                // Final Price = Total Price - Discount
                var finalPrice = totalPrice - discountAmount;
                if (finalPrice < 0) finalPrice = 0;

                // Update the calculation display
                var calcSpan = row.find('.size-calculation');
                if (calcSpan.length > 0) {
                    calcSpan.text('GST: ₹' + gstAmount.toFixed(2) + ' | Total: ₹' + totalPrice.toFixed(2) +
                        ' | Final: ₹' + finalPrice.toFixed(2));
                }
            };

            // ===== UPDATE ALL STOCKS =====
            window.updateAllStocks = function() {
                $('.variant-item').each(function() {
                    var variantId = $(this).attr('id').replace('variant-', '');
                    var total = 0;
                    $(this).find('.size-row input[name*="[stock]"]').each(function() {
                        var val = parseInt($(this).val()) || 0;
                        total += val;
                    });
                    $('#totalVariantStock_' + variantId).text(total);
                });
                updateGrandTotalStock();
            };

            // ===== UPDATE GRAND TOTAL STOCK =====
            function updateGrandTotalStock() {
                var grandTotal = 0;
                $('.variant-item').each(function() {
                    $(this).find('.size-row input[name*="[stock]"]').each(function() {
                        var val = parseInt($(this).val()) || 0;
                        grandTotal += val;
                    });
                });
                $('#grandTotalStock').text(grandTotal);
            }

            // ===== TOGGLE VARIANT SECTIONS =====
            window.toggleVariantSections = function(productTypeId) {
                var selectedOption = $('#product_type_id option:selected');
                var productTypeName = selectedOption.text().toLowerCase();

                var isClothing = productTypeName.includes('top') || productTypeName.includes('bottom') ||
                    productTypeName.includes('foot') || productTypeName.includes('shirt') ||
                    productTypeName.includes('tshirt') || productTypeName.includes('pant') ||
                    productTypeName.includes('jean') || productTypeName.includes('shoe') ||
                    productTypeName.includes('sandal') || productTypeName.includes('wear');

                if (isClothing && productTypeId) {
                    isVariantMode = true;
                    $('#pricingSection').addClass('hidden-section');
                    $('#inventorySection').hide();
                    $('#productImagesSection').hide();
                    $('#variantSection').addClass('active');
                    $('#grandTotalStockSection').show();

                    $('.variant-required').prop('required', true);

                    if (productTypeName.includes('top') || productTypeName.includes('shirt') || productTypeName
                        .includes('tshirt')) {
                        $('#variantTypeLabel').text('Top Wear');
                    } else if (productTypeName.includes('bottom') || productTypeName.includes('pant') ||
                        productTypeName.includes('jean')) {
                        $('#variantTypeLabel').text('Bottom Wear');
                    } else if (productTypeName.includes('foot') || productTypeName.includes('shoe') ||
                        productTypeName.includes('sandal')) {
                        $('#variantTypeLabel').text('Foot Wear');
                    }

                    $('.size-row').each(function() {
                        var mrpInput = $(this).find('input[name*="[mrp]"]');
                        if (mrpInput.length > 0) {
                            calculateSizePrice(mrpInput[0], 'default', 0);
                        }
                    });
                } else {
                    isVariantMode = false;
                    $('#pricingSection').removeClass('hidden-section');
                    $('#inventorySection').show();
                    $('#productImagesSection').show();
                    $('#variantSection').removeClass('active');
                    $('#grandTotalStockSection').hide();
                    $('.variant-required').prop('required', false);
                }

                updateVariantGst();
                updateAllStocks();
            };

            // ===== UPDATE VARIANT GST =====
            function updateVariantGst() {
                var gstRate = currentGstRate || 0;
                $('#variantGstBadge').text('GST: ' + gstRate + '%');

                $('.size-row').each(function() {
                    var mrpInput = $(this).find('input[name*="[mrp]"]');
                    if (mrpInput.length > 0) {
                        calculateSizePrice(mrpInput[0], 'default', 0);
                    }
                });
            }

            // ===== PREVIEW VARIANT IMAGES =====
            window.previewVariantImages = function(input, variantId) {
                variantId = variantId || 'default';
                var files = Array.from(input.files);

                if (!variantImageFiles[variantId]) {
                    variantImageFiles[variantId] = [];
                }

                variantImageFiles[variantId] = variantImageFiles[variantId].concat(files);
                updateVariantImagePreview(variantId);
            };

            function updateVariantImagePreview(variantId) {
                var previewId = 'variant_images_preview_' + variantId;
                var preview = $('#' + previewId);
                preview.empty();

                if (!variantImageFiles[variantId] || variantImageFiles[variantId].length === 0) return;

                variantImageFiles[variantId].forEach(function(file, index) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.append(
                            '<div class="variant-image-preview-item">' +
                            '<img src="' + e.target.result + '">' +
                            '<button type="button" class="remove-img" onclick="removeVariantImage(\'' +
                            variantId + '\', ' + index + ')">×</button>' +
                            '</div>'
                        );
                    };
                    reader.readAsDataURL(file);
                });
            }

            window.removeVariantImage = function(variantId, index) {
                if (variantImageFiles[variantId]) {
                    variantImageFiles[variantId].splice(index, 1);
                    updateVariantImagePreview(variantId);
                }
            };

            // ===== ADD SIZE =====
            $(document).on('click', '.add-size-btn', function() {
                var variantId = $(this).data('variant');
                var container = $('#sizesContainer_' + variantId);
                var sizeIndex = container.find('.size-row').length;

                var newRow = `
                    <div class="size-row">
                        <input type="text" name="variants[${variantId}][sizes][${sizeIndex}][size]" class="form-control form-control-sm variant-required" placeholder="Size" style="min-width:70px;">
                        <input type="number" step="0.01" name="variants[${variantId}][sizes][${sizeIndex}][cost_price]" class="form-control form-control-sm variant-required" placeholder="Cost Price" min="0" style="min-width:90px;" oninput="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                        <input type="number" step="0.01" name="variants[${variantId}][sizes][${sizeIndex}][mrp]" class="form-control form-control-sm variant-required" placeholder="MRP" min="0" style="min-width:90px;" oninput="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                        <input type="number" name="variants[${variantId}][sizes][${sizeIndex}][stock]" class="form-control form-control-sm variant-stock" placeholder="Stock" min="0" style="min-width:70px;" oninput="updateAllStocks()" onchange="updateAllStocks()">
                        <select name="variants[${variantId}][sizes][${sizeIndex}][discount_type]" class="form-control form-control-sm" style="width:80px;" onchange="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                            <option value="flat">Flat</option>
                            <option value="percentage">%</option>
                        </select>
                        <input type="number" step="0.01" name="variants[${variantId}][sizes][${sizeIndex}][discount_value]" class="form-control form-control-sm" placeholder="Disc" min="0" style="width:80px;" oninput="calculateSizePrice(this, '${variantId}', ${sizeIndex})">
                        <span class="size-calculation" id="sizeCalc_${variantId}_${sizeIndex}">GST: ₹0.00 | Total: ₹0.00 | Final: ₹0.00</span>
                        <span class="remove-size" onclick="removeSize(this, '${variantId}')">✕</span>
                    </div>
                `;
                container.append(newRow);

                if (isVariantMode) {
                    container.find('.variant-required').prop('required', true);
                }

                updateAllStocks();
            });

            // ===== REMOVE SIZE =====
            window.removeSize = function(element, variantId) {
                var row = $(element).closest('.size-row');
                var container = $('#sizesContainer_' + variantId);
                var totalRows = container.find('.size-row').length;
                if (totalRows > 1) {
                    row.remove();
                    updateAllStocks();
                } else {
                    alert('At least one size is required!');
                }
            };

            // ===== ADD ANOTHER VARIANT =====
            $('#addVariantBtn').on('click', function() {
                var variantId = 'variant_' + (++variantIdCounter);
                variantImageFiles[variantId] = [];

                var newVariant = `
                    <div class="variant-item" id="variant-${variantId}">
                        <div class="variant-header">
                            <span class="variant-number"><i class="fas fa-palette me-2"></i> Variant #${variantIdCounter}</span>
                            <button type="button" class="btn btn-sm btn-danger remove-variant" onclick="removeVariant('${variantId}')">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                        <div class="mb-3">
                            <label class="field-label">Color <span class="required-star">*</span></label>
                            <input type="text" name="variants[${variantId}][color]" class="form-control variant-required" placeholder="e.g., Red, Blue, Black">
                        </div>
                        <div class="mb-3">
                            <label class="field-label">Images <span class="required-star">*</span></label>
                            <div class="variant-image-upload-area" onclick="document.getElementById('variant_images_input_${variantId}').click()">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                <p class="mb-0">Click to upload variant images</p>
                            </div>
                            <input type="file" id="variant_images_input_${variantId}" name="variants[${variantId}][images][]" class="form-control mt-2" accept="image/*" multiple style="display: none;" onchange="previewVariantImages(this, '${variantId}')">
                            <div id="variant_images_preview_${variantId}" class="variant-image-preview-container mt-2"></div>
                        </div>
                        <div class="mb-3">
                            <label class="field-label">Sizes <span class="required-star">*</span></label>
                            <div id="sizesContainer_${variantId}" class="sizes-container">
                                <div class="size-row">
                                    <input type="text" name="variants[${variantId}][sizes][0][size]" class="form-control form-control-sm variant-required" placeholder="Size" style="min-width:70px;">
                                    <input type="number" step="0.01" name="variants[${variantId}][sizes][0][cost_price]" class="form-control form-control-sm variant-required" placeholder="Cost Price" min="0" style="min-width:90px;" oninput="calculateSizePrice(this, '${variantId}', 0)">
                                    <input type="number" step="0.01" name="variants[${variantId}][sizes][0][mrp]" class="form-control form-control-sm variant-required" placeholder="MRP" min="0" style="min-width:90px;" oninput="calculateSizePrice(this, '${variantId}', 0)">
                                    <input type="number" name="variants[${variantId}][sizes][0][stock]" class="form-control form-control-sm variant-stock" placeholder="Stock" min="0" style="min-width:70px;" oninput="updateAllStocks()" onchange="updateAllStocks()">
                                    <select name="variants[${variantId}][sizes][0][discount_type]" class="form-control form-control-sm" style="width:80px;" onchange="calculateSizePrice(this, '${variantId}', 0)">
                                        <option value="flat">Flat</option>
                                        <option value="percentage">%</option>
                                    </select>
                                    <input type="number" step="0.01" name="variants[${variantId}][sizes][0][discount_value]" class="form-control form-control-sm" placeholder="Disc" min="0" style="width:80px;" oninput="calculateSizePrice(this, '${variantId}', 0)">
                                    <span class="size-calculation" id="sizeCalc_${variantId}_0">GST: ₹0.00 | Total: ₹0.00 | Final: ₹0.00</span>
                                    <span class="remove-size" onclick="removeSize(this, '${variantId}')">✕</span>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2 add-size-btn" data-variant="${variantId}">
                                <i class="fas fa-plus me-1"></i> Add Size
                            </button>
                        </div>
                        <div class="variant-total-stock">
                            <span class="label"><i class="fas fa-cubes me-1"></i> Variant Total Stock</span>
                            <span class="value" id="totalVariantStock_${variantId}">0</span>
                        </div>
                    </div>
                `;
                $('#additionalVariants').append(newVariant);

                if (isVariantMode) {
                    $('#variant-' + variantId).find('.variant-required').prop('required', true);
                }

                updateAllStocks();
            });

            // ===== REMOVE VARIANT =====
            window.removeVariant = function(variantId) {
                var totalVariants = $('.variant-item').length;
                if (totalVariants > 1) {
                    if (confirm('Remove this variant?')) {
                        $('#variant-' + variantId).remove();
                        updateAllStocks();
                    }
                } else {
                    alert('At least one variant is required!');
                }
            };

            // ===== CATEGORY CHANGE =====
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subCategorySelect = $('#sub_category');
                var subLoadingIndicator = $('#subCategoryLoading');
                var subHelperText = $('#subCategoryHelper');
                var productTypeSelect = $('#product_type_id');
                var ptLoadingIndicator = $('#productTypeLoading');
                var ptHelperText = $('#productTypeHelper');

                subCategorySelect.empty().append('<option value="">-- Select Sub Category --</option>');

                if (categoryId) {
                    subLoadingIndicator.show();
                    subHelperText.text('Loading sub categories...');

                    $.ajax({
                        url: '/admin/get-subcategories/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            subLoadingIndicator.hide();
                            if (data.length > 0) {
                                $.each(data, function(i, sub) {
                                    subCategorySelect.append('<option value="' + sub
                                        .id + '">' + sub.name + '</option>');
                                });
                                subHelperText.text(data.length + ' sub categories found');
                            } else {
                                subHelperText.text('No sub categories found');
                            }
                        },
                        error: function() {
                            subLoadingIndicator.hide();
                            subHelperText.text('Error loading sub categories');
                        }
                    });
                } else {
                    subLoadingIndicator.hide();
                    subHelperText.text('Select a category to load sub categories');
                }

                productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');

                if (categoryId) {
                    ptLoadingIndicator.show();
                    ptHelperText.text('Loading product types...');

                    $.ajax({
                        url: '/admin/get-producttypes-by-category/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            ptLoadingIndicator.hide();
                            if (data.length > 0) {
                                $.each(data, function(i, pt) {
                                    productTypeSelect.append('<option value="' + pt.id +
                                        '">' + pt.name + '</option>');
                                });
                                ptHelperText.text(data.length + ' product types found');
                            } else {
                                ptHelperText.text('No product types found');
                            }
                        },
                        error: function() {
                            ptLoadingIndicator.hide();
                            ptHelperText.text('Error loading product types');
                        }
                    });
                } else {
                    ptLoadingIndicator.hide();
                    ptHelperText.text('Select a category to load product types');
                }
            });

            // ===== TOP CATEGORY CHANGE =====
            $('#top_category').on('change', function() {
                var topCategoryId = $(this).val();
                var selectedOption = $(this).find('option:selected');
                var dataGst = parseFloat(selectedOption.data('gst')) || 0;

                if (topCategoryId) {
                    $.get('/admin/get-categories/' + topCategoryId, function(data) {
                        var categorySelect = $('#category');
                        categorySelect.empty().append(
                            '<option value="">-- Select Category --</option>');
                        $.each(data, function(i, cat) {
                            categorySelect.append('<option value="' + cat.id + '">' + cat
                                .name + '</option>');
                        });
                        $('#sub_category').empty().append(
                            '<option value="">-- Select Category First --</option>');
                        $('#subCategoryHelper').text('Select a category to load sub categories');
                    });

                    $('#gst_badge').show().html('<i class="fas fa-spinner fa-spin"></i> Loading GST...');

                    if (dataGst > 0) {
                        currentGstRate = dataGst;
                        updateGstInfo(dataGst);
                        $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '%')
                            .show();
                        $('#gst_selected_info').text('GST: ' + dataGst + '% (from ' + selectedOption.text()
                            .trim() + ')');
                        updateVariantGst();
                    }

                    $.ajax({
                        url: '/admin/get-gst-rate/' + topCategoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.gst_rate > 0) {
                                currentGstRate = response.gst_rate;
                                updateGstInfo(response.gst_rate);
                                $('#gst_badge').html(
                                    '<i class="fas fa-check-circle"></i> GST: ' + response
                                    .gst_rate + '%').show();
                                $('#gst_selected_info').text('GST: ' + response.gst_rate +
                                    '% (from ' + selectedOption.text().trim() + ')');
                                updateVariantGst();
                            } else if (dataGst === 0) {
                                $('#gst_badge').html(
                                        '<i class="fas fa-exclamation-circle"></i> No GST set')
                                    .show();
                                $('#gst_selected_info').text('No GST set for this category');
                                currentGstRate = 0;
                                updateGstInfo(0);
                                updateVariantGst();
                            }
                            calculateAll();
                        },
                        error: function() {
                            if (dataGst > 0) {
                                currentGstRate = dataGst;
                                updateGstInfo(dataGst);
                                $('#gst_badge').html(
                                    '<i class="fas fa-check-circle"></i> GST: ' + dataGst +
                                    '%').show();
                                updateVariantGst();
                            } else {
                                currentGstRate = 0;
                                updateGstInfo(0);
                                $('#gst_badge').html(
                                    '<i class="fas fa-exclamation-triangle"></i> Error loading GST'
                                ).show();
                                updateVariantGst();
                            }
                            calculateAll();
                        }
                    });
                } else {
                    $('#gst_badge').hide();
                    $('#gst_selected_info').text('Select top category to auto-fill GST');
                    currentGstRate = 0;
                    updateGstInfo(0);
                    updateVariantGst();
                    calculateAll();
                }
            });

            // ===== UPDATE GST INFO =====
            function updateGstInfo(gstRate) {
                var gstBox = $('#gst_info_box');
                if (gstRate > 0) {
                    gstBox.show();
                    $('#gst_rate_display').text(gstRate + '%');
                } else {
                    gstBox.hide();
                    $('#gst_rate_display').text('0%');
                }
                calculateAll();
            }

            // ===== CALCULATE ALL (Normal Mode) =====
            // ===== CALCULATE ALL (Normal Mode) =====
            function calculateAll() {
                var mrp = parseFloat($('#mrp').val()) || 0;
                var discountType = $('input[name="discount_type"]:checked').val();
                var discountValue = parseFloat($('#discount_value').val()) || 0;
                var gstRate = currentGstRate || 0;

                var gstAmount = (mrp * gstRate) / 100;
                var priceWithGst = mrp + gstAmount;
                var discountAmount = 0;
                if (discountType === 'flat') {
                    discountAmount = discountValue;
                    $('#discount_value_hint').text('Enter flat discount amount');
                } else {
                    discountAmount = (mrp * discountValue) / 100;
                    $('#discount_value_hint').text('Enter percentage discount (%)');
                }
                var sellingPrice = priceWithGst - discountAmount;
                if (sellingPrice < 0) sellingPrice = 0;

                // Update all fields
                $('#gst_amount_field').val(gstAmount.toFixed(2));
                $('#total_price_field').val(priceWithGst.toFixed(2)); // NEW: Total Price
                $('#discount_amount_display').val(discountAmount.toFixed(2));
                $('#final_price').val(sellingPrice.toFixed(2));

                // Update calculation flow
                $('#flow_selling').text('₹' + mrp.toFixed(2));
                $('#flow_gst').text('₹' + gstAmount.toFixed(2));
                $('#flow_total_price').text('₹' + priceWithGst.toFixed(2));
                $('#flow_discount').text('₹' + discountAmount.toFixed(2));
                $('#flow_final').text('₹' + sellingPrice.toFixed(2));

                if (gstRate > 0) {
                    $('#gst_calc_info').text('GST @ ' + gstRate + '% on MRP ₹' + mrp.toFixed(2));
                    $('#gst_amount_display').text('₹' + gstAmount.toFixed(2));
                    $('#discount_calc_info').text('Discount on Total Price');
                } else {
                    $('#gst_calc_info').text('No GST applied');
                    $('#gst_amount_display').text('₹0.00');
                    $('#discount_calc_info').text('Discount on MRP');
                }

                var savedAmount = mrp - sellingPrice;
                if (savedAmount < 0) savedAmount = 0;
                $('#saved_amount').text('₹' + savedAmount.toFixed(2));

                var discountPercent = 0;
                if (mrp > 0 && sellingPrice > 0) {
                    discountPercent = ((mrp - sellingPrice) / mrp) * 100;
                }
                if (discountPercent < 0) discountPercent = 0;
                $('#discount_percent_info').text(discountPercent.toFixed(1) + '% off');

                $('#final_total_display').text('₹' + sellingPrice.toFixed(2));

                var savedElement = $('#saved_amount');
                var finalDisplay = $('#final_total_display');
                if (savedAmount > 0) {
                    savedElement.removeClass('negative').css('color', '#28a745');
                    finalDisplay.css('color', '#28a745');
                } else {
                    savedElement.css('color', '#dc3545');
                    finalDisplay.css('color', '#dc3545');
                }
            }

            // ===== DISCOUNT TYPE CHANGE =====
            $('input[name="discount_type"]').on('change', function() {
                var discountType = $(this).val();
                if (discountType === 'flat') {
                    $('#discount_value').attr('placeholder', 'Enter flat amount');
                    $('#discount_value_hint').text('Enter flat discount amount');
                } else {
                    $('#discount_value').attr('placeholder', 'Enter percentage');
                    $('#discount_value_hint').text('Enter percentage discount (%)');
                }
                calculateAll();
            });

            // ===== PRICE CHANGE EVENTS =====
            $('#mrp, #discount_value').on('input', function() {
                calculateAll();
            });

            // ===== COD TOGGLE =====
            $('#cod_toggle').on('change', function() {
                var isChecked = $(this).is(':checked');
                var statusSpan = $('#cod_status');
                if (isChecked) {
                    statusSpan.text('Available').removeClass('inactive').addClass('active');
                } else {
                    statusSpan.text('Not Available').removeClass('active').addClass('inactive');
                }
            });

            // ===== MAIN PRODUCT IMAGE FUNCTIONS =====
            window.imageFiles = [];

            window.previewImages = function(input) {
                var files = Array.from(input.files);
                var totalFiles = window.imageFiles.length + files.length;

                if (totalFiles > 4) {
                    alert('Maximum 4 images only.');
                    input.value = '';
                    return;
                }

                window.imageFiles = window.imageFiles.concat(files);
                updateImagePreview();
            };

            function updateImagePreview() {
                var preview = $('#images_preview');
                preview.empty();

                if (!window.imageFiles || window.imageFiles.length === 0) return;

                window.imageFiles.forEach(function(file, index) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.append(
                            '<div class="image-preview-item">' +
                            '<img src="' + e.target.result + '">' +
                            '<button type="button" class="remove-img" onclick="removeImage(' +
                            index + ')">×</button>' +
                            '<span class="badge ' + (index === 0 ? 'bg-primary' : 'bg-secondary') +
                            ' d-block text-center">' + (index === 0 ? 'Main' : 'Image ' + (index +
                                1)) + '</span>' +
                            '</div>'
                        );
                    };
                    reader.readAsDataURL(file);
                });
            }

            window.removeImage = function(index) {
                window.imageFiles.splice(index, 1);
                updateImagePreview();

                var dataTransfer = new DataTransfer();
                for (var i = 0; i < window.imageFiles.length; i++) {
                    dataTransfer.items.add(window.imageFiles[i]);
                }
                document.getElementById('product_images_input').files = dataTransfer.files;
            };

            // ===== FORM SUBMIT =====
            $('#productForm').on('submit', function(e) {
                if (isVariantMode) {
                    var hasError = false;

                    $('.variant-item').each(function() {
                        var variantId = $(this).attr('id').replace('variant-', '');

                        var colorInput = $(this).find('input[name*="[color]"]');
                        if (colorInput.length && !colorInput.val().trim()) {
                            hasError = true;
                            colorInput.addClass('is-invalid');
                            alert('Please enter color for Variant #' + (variantId === 'default' ?
                                1 : variantIdCounter));
                            colorInput.focus();
                            return false;
                        }

                        var sizeRows = $(this).find('.size-row');
                        sizeRows.each(function(index) {
                            var sizeInput = $(this).find('input[name*="[size]"]');
                            var costPriceInput = $(this).find(
                                'input[name*="[cost_price]"]');
                            var mrpInput = $(this).find('input[name*="[mrp]"]');

                            if (!sizeInput.val().trim()) {
                                hasError = true;
                                sizeInput.addClass('is-invalid');
                                alert('Please enter size for Variant #' + (variantId ===
                                        'default' ? 1 : variantIdCounter) + ', Size ' +
                                    (index + 1));
                                sizeInput.focus();
                                return false;
                            }
                            if (!costPriceInput.val() || parseFloat(costPriceInput.val()) <=
                                0) {
                                hasError = true;
                                costPriceInput.addClass('is-invalid');
                                alert('Please enter valid cost price for Variant #' + (
                                    variantId === 'default' ? 1 : variantIdCounter
                                ) + ', Size ' + (index + 1));
                                costPriceInput.focus();
                                return false;
                            }
                            if (!mrpInput.val() || parseFloat(mrpInput.val()) <= 0) {
                                hasError = true;
                                mrpInput.addClass('is-invalid');
                                alert('Please enter valid MRP for Variant #' + (
                                    variantId === 'default' ? 1 : variantIdCounter
                                ) + ', Size ' + (index + 1));
                                mrpInput.focus();
                                return false;
                            }
                        });

                        if (hasError) return false;
                    });

                    if (hasError) {
                        e.preventDefault();
                        return false;
                    }

                    // Check if variant images are uploaded
                    let hasVariantImage = false;
                    for (let key in variantImageFiles) {
                        if (variantImageFiles[key] && variantImageFiles[key].length > 0) {
                            hasVariantImage = true;
                            break;
                        }
                    }

                    if (!hasVariantImage) {
                        e.preventDefault();
                        alert('Please upload at least 1 variant image.');
                        return false;
                    }

                    var dataTransfer = new DataTransfer();
                    for (var i = 0; i < window.imageFiles.length; i++) {
                        dataTransfer.items.add(window.imageFiles[i]);
                    }
                    document.getElementById('product_images_input').files = dataTransfer.files;

                    return true;
                }

                if (!isVariantMode) {
                    var stock = parseInt($('#stock').val());
                    if (isNaN(stock) || stock < 0) {
                        e.preventDefault();
                        alert('Stock cannot be negative.');
                        return false;
                    }

                    var mrp = parseFloat($('#mrp').val()) || 0;
                    var sellingPrice = parseFloat($('#final_price').val()) || 0;

                    if (mrp <= 0) {
                        e.preventDefault();
                        alert('Please enter a valid MRP.');
                        return false;
                    }

                    if (sellingPrice < 0) {
                        e.preventDefault();
                        alert('Selling price cannot be negative.');
                        return false;
                    }

                    if (!window.imageFiles || window.imageFiles.length === 0) {
                        e.preventDefault();
                        alert('Please upload at least 1 product image.');
                        return false;
                    }

                    var dataTransfer = new DataTransfer();
                    for (var i = 0; i < window.imageFiles.length; i++) {
                        dataTransfer.items.add(window.imageFiles[i]);
                    }
                    document.getElementById('product_images_input').files = dataTransfer.files;
                }

                return true;
            });

            // ===== INITIAL CALCULATION =====
            calculateAll();
            updateVariantGst();
            updateAllStocks();

            // ===== DESCRIPTION PREVIEW =====
            function previewDescription() {
                var description = $('#description').val();
                var previewDiv = $('#descriptionPreview');
                var contentDiv = $('#descriptionPreviewContent');

                if (description.trim() !== '') {
                    previewDiv.show();

                    var html = description;
                    var lines = html.split('\n');
                    var inList = false;
                    var processedLines = [];

                    for (var i = 0; i < lines.length; i++) {
                        var line = lines[i].trim();

                        if (line.match(/^[•\-*]\s/)) {
                            if (!inList) {
                                processedLines.push('<ul class="mb-2">');
                                inList = true;
                            }
                            var text = line.replace(/^[•\-*]\s/, '');
                            processedLines.push('<li>' + text + '</li>');
                        } else {
                            if (inList) {
                                processedLines.push('</ul>');
                                inList = false;
                            }
                            if (line !== '') {
                                processedLines.push('<p>' + line + '</p>');
                            } else {
                                processedLines.push('<br>');
                            }
                        }
                    }

                    if (inList) {
                        processedLines.push('</ul>');
                    }

                    var finalHtml = processedLines.join('');

                    if (html.match(/<[^>]+>/)) {
                        contentDiv.html(html);
                    } else {
                        contentDiv.html(finalHtml);
                    }
                } else {
                    previewDiv.hide();
                }
            }

            $('#description').on('input', function() {
                previewDescription();
            });

            if ($('#description').val().trim() !== '') {
                previewDescription();
            }

            $(document).on('input', '.is-invalid', function() {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
@endsection
