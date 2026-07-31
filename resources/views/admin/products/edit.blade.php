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

        .final-amount-box {
            background: #f8f9fa;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 15px 20px;
            text-align: center;
        }

        .final-amount-box .label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }

        .final-amount-box .amount {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
        }

        .final-amount-box .amount.negative {
            color: #dc3545;
        }

        .discount-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        .discount-type-group {
            display: flex;
            gap: 15px;
            margin-top: 5px;
        }

        .discount-type-group .form-check {
            margin-right: 15px;
        }

        .discount-type-group .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .price-input-group {
            position: relative;
        }

        .price-input-group .currency-symbol {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #6c757d;
        }

        .price-input-group .form-control {
            padding-left: 25px;
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
            gap: 10px;
            flex-wrap: wrap;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .calculation-flow .step {
            background: white;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid #dee2e6;
            font-size: 13px;
        }

        .calculation-flow .step .highlight {
            font-weight: 700;
            color: #0d6efd;
        }

        .calculation-flow .step .highlight.green {
            color: #28a745;
        }

        .calculation-flow .arrow {
            font-size: 20px;
            color: #6c757d;
        }

        .existing-image-item {
            position: relative;
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            display: inline-block;
            margin-right: 10px;
        }

        .existing-image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .existing-image-item .remove-existing-img {
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
    </style>

    <div class="container">
        <div class="row" style="margin-left:220px; margin-right:20px;">
            <div class="col-12">
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fas fa-edit me-2 text-primary"></i> Edit Product
                    </div>
                    <div class="form-section-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                            enctype="multipart/form-data" id="productForm">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="discount_type" id="hidden_discount_type"
                                value="{{ $product->discount_type ?? 'flat' }}">
                            <input type="hidden" name="discount_value" id="hidden_discount_value"
                                value="{{ $product->discount_value ?? 0 }}">
                            <input type="hidden" name="discount_amount" id="hidden_discount_amount"
                                value="{{ $product->discount_amount ?? 0 }}">
                            <input type="hidden" name="gst_percentage" id="hidden_gst_percentage"
                                value="{{ $product->gst_percentage ?? 0 }}">
                            <input type="hidden" name="gst_amount" id="hidden_gst_amount"
                                value="{{ $product->gst_amount ?? 0 }}">
                            <input type="hidden" name="total_price" id="hidden_total_price"
                                value="{{ $product->total_price ?? 0 }}">
                            <input type="hidden" name="final_price" id="hidden_final_price"
                                value="{{ $product->final_price ?? 0 }}">
                            <input type="hidden" name="deleted_variants" id="deleted_variants" value="">
                            <input type="hidden" name="deleted_variant_images" id="deleted_variant_images" value="">

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Basic Information -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Basic Information</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Product Name <span
                                                        class="required-star">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $product->name) }}" required>
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
                                                                data-gst="{{ $tc->gst_rate ?? 0 }}"
                                                                {{ old('top_category_id', $product->top_category_id) == $tc->id ? 'selected' : '' }}>
                                                                {{ $tc->name }}
                                                                @if ($tc->gst_rate)
                                                                    (GST: {{ $tc->gst_rate }}%)
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="gst_selected_info">
                                                        @if ($product->top_category_id && $product->topCategory)
                                                            GST: {{ $product->topCategory->gst_rate ?? 0 }}%
                                                        @else
                                                            Select top category to auto-fill GST
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Category <span
                                                            class="required-star">*</span></label>
                                                    <select name="category_id" id="category" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}"
                                                                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Sub Category <span
                                                            class="required-star">*</span></label>
                                                    <select name="sub_category_id" id="sub_category" class="form-control"
                                                        required>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($subCategories as $sub)
                                                            <option value="{{ $sub->id }}"
                                                                {{ old('sub_category_id', $product->sub_category_id) == $sub->id ? 'selected' : '' }}>
                                                                {{ $sub->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="field-label">Brand</label>
                                                    <select name="brand_id" class="form-control">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($brands as $b)
                                                            <option value="{{ $b->id }}"
                                                                {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                                                                {{ $b->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="field-label">Product Type</label>
                                                    <select name="product_type_id" id="product_type_id"
                                                        class="form-control" onchange="toggleVariantSections(this.value)">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($productTypes as $pt)
                                                            <option value="{{ $pt->id }}"
                                                                {{ old('product_type_id', $product->product_type_id) == $pt->id ? 'selected' : '' }}>
                                                                {{ $pt->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="productTypeHelper">Select product type
                                                    </div>
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
                                                                data-category="{{ $sc->category_type ?? 'topwear' }}"
                                                                {{ old('size_chart_id', $product->size_chart_id) == $sc->id ? 'selected' : '' }}>
                                                                {{ $sc->title }}
                                                                <span
                                                                    class="size-chart-badge {{ $sc->gender ?? 'unisex' }}">{{ ucfirst($sc->gender ?? 'Unisex') }}</span>
                                                                <span
                                                                    class="size-chart-badge {{ $sc->category_type ?? 'topwear' }}">{{ ucfirst($sc->category_type ?? 'Topwear') }}</span>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="sizeChartHelper">Select a size chart for
                                                        this product</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing -->
                                    <div class="card mb-3" id="pricingSection">
                                        <div class="card-header bg-light">
                                            Pricing, GST & Discount
                                            <span id="gst_badge" class="gst-badge"
                                                style="{{ $product->top_category_id && $product->topCategory && $product->topCategory->gst_rate ? 'display:inline-block;' : 'display:none;' }}">
                                                <i class="fas fa-check-circle"></i> GST:
                                                {{ $product->topCategory->gst_rate ?? 0 }}%
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="gst-info" id="gst_info_box"
                                                style="{{ $product->top_category_id && $product->topCategory && $product->topCategory->gst_rate ? 'display:block;' : 'display:none;' }}">
                                                <span class="gst-label"><i class="fas fa-percent"></i> GST Rate:</span>
                                                <span
                                                    id="gst_rate_display">{{ $product->topCategory->gst_rate ?? 0 }}%</span>
                                                <span style="margin-left: 15px;" class="gst-label"><i
                                                        class="fas fa-calculator"></i> GST Amount:</span>
                                                <span
                                                    id="gst_amount_display">₹{{ number_format(($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span>
                                                <span
                                                    style="margin-left: 15px; color: #6c757d; font-size: 12px;">(Calculated
                                                    on SP)</span>
                                            </div>

                                            <div class="calculation-flow" id="calculation_flow">
                                                <span class="step">SP: <span class="highlight"
                                                        id="flow_selling">₹{{ number_format($product->mrp, 2) }}</span></span>
                                                <span class="arrow">+</span>
                                                <span class="step">GST: <span class="highlight"
                                                        id="flow_gst">₹{{ number_format(($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span></span>
                                                <span class="arrow">=</span>
                                                <span class="step">Total: <span class="highlight"
                                                        id="flow_total_price">₹{{ number_format($product->mrp + ($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span></span>
                                                <span class="arrow">-</span>
                                                <span class="step">Disc: <span class="highlight"
                                                        id="flow_discount">₹{{ number_format($product->mrp - $product->final_price, 2) }}</span></span>
                                                <span class="arrow">=</span>
                                                <span class="step"
                                                    style="border-color: #28a745; background: #d4edda;">Final: <span
                                                        class="highlight green"
                                                        id="flow_final">₹{{ number_format($product->final_price, 2) }}</span></span>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Cost Price (₹) <span
                                                            class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="price"
                                                            id="price" class="form-control" required min="0"
                                                            value="{{ old('price', $product->price) }}">
                                                    </div>
                                                    <div class="help-text">Your purchase price</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Selling Price (₹) <span
                                                            class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="mrp"
                                                            id="mrp" class="form-control" required min="0"
                                                            value="{{ old('mrp', $product->mrp) }}"
                                                            oninput="calculateAll()">
                                                    </div>
                                                    <div class="help-text">Customer price before discount</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Discount Type</label>
                                                    <div class="discount-type-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="discount_type" id="discount_flat" value="flat"
                                                                {{ old('discount_type', $product->discount_type ?? 'flat') == 'flat' ? 'checked' : '' }}
                                                                onchange="calculateAll()">
                                                            <label class="form-check-label"
                                                                for="discount_flat">Flat</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="discount_type" id="discount_percentage"
                                                                value="percentage"
                                                                {{ old('discount_type', $product->discount_type ?? 'flat') == 'percentage' ? 'checked' : '' }}
                                                                onchange="calculateAll()">
                                                            <label class="form-check-label"
                                                                for="discount_percentage">%</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Discount Value</label>
                                                    <input type="number" step="0.01" name="discount_value"
                                                        id="discount_value" class="form-control" min="0"
                                                        value="{{ old('discount_value', $product->discount_value ?? 0) }}"
                                                        oninput="calculateAll()">
                                                    <div class="help-text" id="discount_value_hint">Enter discount amount
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">GST Amt (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="gst_amount_field"
                                                            class="form-control" readonly
                                                            style="background-color: #e9ecef; font-weight: bold; color: #0d6efd;">
                                                    </div>
                                                    <div class="help-text" id="gst_calc_info">GST on SP</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Total Price (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="total_price_display"
                                                            class="form-control" readonly
                                                            style="background-color: #e9ecef; font-weight: bold; color: #0d6efd;">
                                                    </div>
                                                    <div class="help-text">SP + GST</div>
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

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Final Price (₹) <span
                                                            class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="final_price"
                                                            id="final_price" class="form-control" readonly
                                                            style="background-color: #d4edda; font-weight: bold; color: #28a745; font-size: 18px;"
                                                            value="{{ old('final_price', $product->final_price) }}">
                                                    </div>
                                                    <div class="help-text">Total - Discount</div>
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
                                                    id="variantTypeLabel">
                                                    @if ($product->variants && $product->variants->count() > 0)
                                                        {{ $product->productType->name ?? 'Top Wear' }}
                                                    @else
                                                        Top Wear
                                                    @endif
                                                </span>
                                                <span class="gst-badge"
                                                    style="background:#0d6efd; color:white; padding:2px 10px; border-radius:12px; font-size:11px; margin-left:5px;"
                                                    id="variantGstBadge">
                                                    GST: {{ $product->topCategory->gst_rate ?? 0 }}%
                                                </span>
                                            </div>
                                            <div class="card-body" id="variantContainer">
                                                @php
                                                    // Group variants by color
                                                    $groupedVariants = [];
                                                    if ($product->variants && $product->variants->count() > 0) {
                                                        foreach ($product->variants as $variant) {
                                                            $color = $variant->color ?? 'default';
                                                            if (!isset($groupedVariants[$color])) {
                                                                $groupedVariants[$color] = [
                                                                    'color' => $color,
                                                                    'variants' => [],
                                                                    'images' => $variant->variantImages ?? collect(),
                                                                ];
                                                            }
                                                            $groupedVariants[$color]['variants'][] = $variant;
                                                        }
                                                    }
                                                @endphp

                                                @if (count($groupedVariants) > 0)
                                                    @foreach ($groupedVariants as $colorKey => $group)
                                                        @php
                                                            $variantTotalStock = 0;
                                                            foreach ($group['variants'] as $v) {
                                                                $variantTotalStock += $v->stock ?? 0;
                                                            }
                                                            // Use color name as ID, but replace spaces and special chars
                                                            $variantId = preg_replace(
                                                                '/[^a-zA-Z0-9_]/',
                                                                '_',
                                                                $colorKey,
                                                            );
                                                            if (empty($variantId)) {
                                                                $variantId = 'variant_' . $loop->iteration;
                                                            }
                                                        @endphp
                                                        <div class="variant-item" id="variant-{{ $variantId }}">
                                                            <div class="variant-header">
                                                                <span class="variant-number"><i
                                                                        class="fas fa-palette me-2"></i> Variant
                                                                    #{{ $loop->iteration }}</span>
                                                                @if ($loop->iteration > 1)
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger remove-variant"
                                                                        onclick="removeVariant('{{ $variantId }}')">
                                                                        <i class="fas fa-times"></i> Remove
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="field-label">Color <span
                                                                        class="required-star">*</span></label>
                                                                <input type="text"
                                                                    name="variants[{{ $variantId }}][color]"
                                                                    class="form-control variant-required"
                                                                    value="{{ $group['color'] }}"
                                                                    placeholder="e.g., Red, Blue, Black">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="field-label">Images <span
                                                                        class="required-star">*</span></label>
                                                                <div class="variant-image-upload-area"
                                                                    onclick="document.getElementById('variant_images_input_{{ $variantId }}').click()">
                                                                    <i
                                                                        class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                                    <p class="mb-0">Click to upload variant images</p>
                                                                </div>
                                                                <input type="file"
                                                                    id="variant_images_input_{{ $variantId }}"
                                                                    name="variants[{{ $variantId }}][images][]"
                                                                    class="form-control mt-2" accept="image/*" multiple
                                                                    style="display: none;"
                                                                    onchange="previewVariantImages(this, '{{ $variantId }}')">
                                                                <div id="variant_images_preview_{{ $variantId }}"
                                                                    class="variant-image-preview-container mt-2">
                                                                    @if ($group['images'] && $group['images']->count() > 0)
                                                                        @foreach ($group['images'] as $img)
                                                                            <div
                                                                                class="variant-image-preview-item existing">
                                                                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                                                                    alt="Variant Image">
                                                                                <button type="button" class="remove-img"
                                                                                    onclick="removeExistingVariantImage({{ $img->id }}, '{{ $variantId }}')">×</button>
                                                                                <input type="hidden"
                                                                                    name="variants[{{ $variantId }}][existing_images][]"
                                                                                    value="{{ $img->id }}">
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="help-text">Upload multiple images for this
                                                                    variant</div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="field-label">Sizes <span
                                                                        class="required-star">*</span></label>
                                                                <div id="sizesContainer_{{ $variantId }}"
                                                                    class="sizes-container">
                                                                    @foreach ($group['variants'] as $sizeIndex => $sizeVariant)
                                                                        <div class="size-row">
                                                                            <input type="text"
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][size]"
                                                                                class="form-control form-control-sm variant-required"
                                                                                value="{{ $sizeVariant->size ?? '' }}"
                                                                                placeholder="Size"
                                                                                style="min-width:70px;">
                                                                            <input type="hidden"
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][id]"
                                                                                value="{{ $sizeVariant->id }}">
                                                                            <input type="number" step="0.01"
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][cost_price]"
                                                                                class="form-control form-control-sm variant-required"
                                                                                value="{{ $sizeVariant->cost_price ?? 0 }}"
                                                                                placeholder="Cost Price" min="0"
                                                                                style="min-width:90px;"
                                                                                oninput="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                                            <input type="number" step="0.01"
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][mrp]"
                                                                                class="form-control form-control-sm variant-required"
                                                                                value="{{ $sizeVariant->mrp ?? 0 }}"
                                                                                placeholder="MRP" min="0"
                                                                                style="min-width:90px;"
                                                                                oninput="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                                            <input type="number"
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][stock]"
                                                                                class="form-control form-control-sm variant-stock"
                                                                                value="{{ $sizeVariant->stock ?? 0 }}"
                                                                                placeholder="Stock" min="0"
                                                                                style="min-width:70px;"
                                                                                oninput="updateAllStocks()"
                                                                                onchange="updateAllStocks()">
                                                                            <select
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][discount_type]"
                                                                                class="form-control form-control-sm"
                                                                                style="width:80px;"
                                                                                onchange="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                                                <option value="flat"
                                                                                    {{ ($sizeVariant->discount_type ?? 'flat') == 'flat' ? 'selected' : '' }}>
                                                                                    Flat</option>
                                                                                <option value="percentage"
                                                                                    {{ ($sizeVariant->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                                                                    %</option>
                                                                            </select>
                                                                            <input type="number" step="0.01"
                                                                                name="variants[{{ $variantId }}][sizes][{{ $sizeIndex }}][discount_value]"
                                                                                class="form-control form-control-sm"
                                                                                value="{{ $sizeVariant->discount_value ?? 0 }}"
                                                                                placeholder="Disc" min="0"
                                                                                style="width:80px;"
                                                                                oninput="calculateSizePrice(this, '{{ $variantId }}', {{ $sizeIndex }})">
                                                                            <span class="size-calculation"
                                                                                id="sizeCalc_{{ $variantId }}_{{ $sizeIndex }}">
                                                                                GST:
                                                                                ₹{{ number_format((($sizeVariant->mrp ?? 0) * ($sizeVariant->gst_percentage ?? 0)) / 100, 2) }}
                                                                                |
                                                                                Total:
                                                                                ₹{{ number_format(($sizeVariant->mrp ?? 0) + (($sizeVariant->mrp ?? 0) * ($sizeVariant->gst_percentage ?? 0)) / 100, 2) }}
                                                                                |
                                                                                Final:
                                                                                ₹{{ number_format(($sizeVariant->mrp ?? 0) + (($sizeVariant->mrp ?? 0) * ($sizeVariant->gst_percentage ?? 0)) / 100 - (($sizeVariant->discount_type ?? 'flat') == 'flat' ? $sizeVariant->discount_value ?? 0 : (($sizeVariant->mrp ?? 0) * ($sizeVariant->discount_value ?? 0)) / 100), 2) }}
                                                                            </span>
                                                                            @if ($loop->iteration > 1)
                                                                                <span class="remove-size"
                                                                                    onclick="removeSize(this, '{{ $variantId }}')">✕</span>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-secondary mt-2 add-size-btn"
                                                                    data-variant="{{ $variantId }}">
                                                                    <i class="fas fa-plus me-1"></i> Add Size
                                                                </button>
                                                            </div>

                                                            <div class="variant-total-stock">
                                                                <span class="label"><i class="fas fa-cubes me-1"></i>
                                                                    Variant Total Stock</span>
                                                                <span class="value"
                                                                    id="totalVariantStock_{{ $variantId }}">
                                                                    {{ $variantTotalStock }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- Default empty variant -->
                                                    <div class="variant-item" id="variant-default">
                                                        <div class="variant-header">
                                                            <span class="variant-number"><i
                                                                    class="fas fa-palette me-2"></i> Variant #1</span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="field-label">Color <span
                                                                    class="required-star">*</span></label>
                                                            <input type="text" name="variants[default][color]"
                                                                class="form-control variant-required"
                                                                placeholder="e.g., Red, Blue, Black">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="field-label">Images <span
                                                                    class="required-star">*</span></label>
                                                            <div class="variant-image-upload-area"
                                                                onclick="document.getElementById('variant_images_input_default').click()">
                                                                <i
                                                                    class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                                <p class="mb-0">Click to upload variant images</p>
                                                            </div>
                                                            <input type="file" id="variant_images_input_default"
                                                                name="variants[default][images][]"
                                                                class="form-control mt-2" accept="image/*" multiple
                                                                style="display: none;"
                                                                onchange="previewVariantImages(this, 'default')">
                                                            <div id="variant_images_preview_default"
                                                                class="variant-image-preview-container mt-2"></div>
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
                                                                        style="min-width:70px;"
                                                                        oninput="updateAllStocks()"
                                                                        onchange="updateAllStocks()">
                                                                    <select
                                                                        name="variants[default][sizes][0][discount_type]"
                                                                        class="form-control form-control-sm"
                                                                        style="width:80px;"
                                                                        onchange="calculateSizePrice(this, 'default', 0)">
                                                                        <option value="flat">Flat</option>
                                                                        <option value="percentage">%</option>
                                                                    </select>
                                                                    <input type="number" step="0.01"
                                                                        name="variants[default][sizes][0][discount_value]"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Disc" min="0"
                                                                        style="width:80px;"
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
                                                @endif

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
                                        <div class="card-header bg-light">Full Description</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Description</label>
                                                <textarea name="description" id="description" class="form-control" rows="8">{{ old('description', $product->description) }}</textarea>
                                            </div>
                                            <div class="mt-3" id="descriptionPreview"
                                                style="{{ old('description', $product->description) ? 'display:block;' : 'display:none;' }}">
                                                <label class="fw-bold">Preview:</label>
                                                <div class="border rounded p-3 bg-light" id="descriptionPreviewContent">
                                                    {!! $product->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- RIGHT COLUMN -->
                                <div class="col-md-4">
                                    <div class="card mb-3" id="inventorySection">
                                        <div class="card-header bg-light">Inventory & Status</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Stock Qty <span
                                                        class="required-star">*</span></label>
                                                <input type="number" name="stock" id="stock" class="form-control"
                                                    value="{{ old('stock', $product->stock) }}" min="0" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="field-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Active"
                                                        {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="Inactive"
                                                        {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                    <option value="Draft"
                                                        {{ old('status', $product->status) == 'Draft' ? 'selected' : '' }}>
                                                        Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3" id="grandTotalStockSection" style="display: none;">
                                        <div class="card-header bg-light" style="background: #d4edda;">
                                            <i class="fas fa-cubes me-2 text-success"></i> Grand Total Stock
                                        </div>
                                        <div class="card-body">
                                            <div class="grand-total-stock">
                                                <span class="label"><i class="fas fa-boxes me-2"></i> Total Stock (All
                                                    Variants)</span>
                                                <span class="value" id="grandTotalStock">
                                                    @php
                                                        $grandTotal = 0;
                                                        if ($product->variants) {
                                                            foreach ($product->variants as $v) {
                                                                $grandTotal += $v->stock ?? 0;
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $grandTotal }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3" id="productImagesSection">
                                        <div class="card-header bg-light">Product Images</div>
                                        <div class="card-body">
                                            @if (isset($productImages) && $productImages->count() > 0)
                                                <div class="mb-3">
                                                    <label class="field-label">Existing Images</label>
                                                    <div class="d-flex flex-wrap">
                                                        @foreach ($productImages as $image)
                                                            <div class="existing-image-item"
                                                                id="existing-image-{{ $image->id }}">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                    alt="Product Image">
                                                                <button type="button" class="remove-existing-img"
                                                                    onclick="removeExistingImage({{ $image->id }})">×</button>
                                                                <input type="hidden" name="existing_images[]"
                                                                    value="{{ $image->id }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="deleted_images" id="deleted_images"
                                                        value="">
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label class="d-block field-label">Add New Images <span
                                                        class="text-muted">(Max 4 total)</span></label>
                                                <div class="image-upload-area"
                                                    onclick="document.getElementById('product_images_input').click()">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                    <p class="mb-0">Click to upload new images</p>
                                                </div>
                                                <input type="file" id="product_images_input" name="new_images[]"
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
                                                            value="1"
                                                            {{ old('cod_available', $product->cod_available) ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <span class="toggle-label">Status: <span id="cod_status"
                                                            class="toggle-status {{ old('cod_available', $product->cod_available) ? 'active' : 'inactive' }}">{{ old('cod_available', $product->cod_available) ? 'Available' : 'Not Available' }}</span></span>
                                                </div>
                                                <div class="help-text">Toggle to enable/disable COD</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Return Days</label>
                                                <select name="return_days" class="form-control">
                                                    <option value="3"
                                                        {{ old('return_days', $product->return_days) == 3 ? 'selected' : '' }}>
                                                        3 Days</option>
                                                    <option value="7"
                                                        {{ old('return_days', $product->return_days) == 7 ? 'selected' : '' }}>
                                                        7 Days</option>
                                                    <option value="15"
                                                        {{ old('return_days', $product->return_days) == 15 ? 'selected' : '' }}>
                                                        15 Days</option>
                                                    <option value="30"
                                                        {{ old('return_days', $product->return_days) == 30 ? 'selected' : '' }}>
                                                        30 Days</option>
                                                    <option value="0"
                                                        {{ old('return_days', $product->return_days) == 0 ? 'selected' : '' }}>
                                                        Non-returnable</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Delivery Days</label>
                                                <select name="delivery_days" class="form-control">
                                                    <option value="1"
                                                        {{ old('delivery_days', $product->delivery_days) == 1 ? 'selected' : '' }}>
                                                        1 Day</option>
                                                    <option value="2"
                                                        {{ old('delivery_days', $product->delivery_days) == 2 ? 'selected' : '' }}>
                                                        2 Days</option>
                                                    <option value="3"
                                                        {{ old('delivery_days', $product->delivery_days) == 3 ? 'selected' : '' }}>
                                                        3 Days</option>
                                                    <option value="5"
                                                        {{ old('delivery_days', $product->delivery_days) == 5 ? 'selected' : '' }}>
                                                        5 Days</option>
                                                    <option value="7"
                                                        {{ old('delivery_days', $product->delivery_days) == 7 ? 'selected' : '' }}>
                                                        7 Days</option>
                                                    <option value="10"
                                                        {{ old('delivery_days', $product->delivery_days) == 10 ? 'selected' : '' }}>
                                                        10 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Update Product
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
            var currentGstRate = {{ $product->topCategory->gst_rate ?? 0 }};
            var isVariantMode = false;
            var variantCounter = {{ $product->variants ? $product->variants->count() : 0 }};
            window.variantImageFiles = {};

            // ===== DEFINE GLOBAL FUNCTIONS =====

            // Calculate Size Price
            window.calculateSizePrice = function(element, variantId, sizeIndex) {
                var row = $(element).closest('.size-row');
                var costPrice = parseFloat(row.find('input[name*="[cost_price]"]').val()) || 0;
                var mrp = parseFloat(row.find('input[name*="[mrp]"]').val()) || 0;
                var discountType = row.find('select[name*="[discount_type]"]').val() || 'flat';
                var discountValue = parseFloat(row.find('input[name*="[discount_value]"]').val()) || 0;
                var gstRate = currentGstRate || 0;

                var gstAmount = (mrp * gstRate) / 100;
                var totalPrice = mrp + gstAmount;

                var discountAmount = 0;
                if (discountType === 'flat') {
                    discountAmount = discountValue;
                } else {
                    discountAmount = (mrp * discountValue) / 100;
                }

                var finalPrice = totalPrice - discountAmount;
                if (finalPrice < 0) finalPrice = 0;

                var calcSpan = row.find('.size-calculation');
                if (calcSpan.length > 0) {
                    calcSpan.text('GST: ₹' + gstAmount.toFixed(2) + ' | Total: ₹' + totalPrice.toFixed(2) +
                        ' | Final: ₹' + finalPrice.toFixed(2));
                }
            };

            // Update All Stocks
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

            // Remove Size
          window.removeSize = function(element, variantId) {
    var row = $(element).closest('.size-row');
    var container = $('#sizesContainer_' + variantId);
    var totalRows = container.find('.size-row').length;
    if (totalRows > 1) {
        // Check if this is an existing size with an ID
        var sizeId = row.find('input[name*="[id]"]').val();
        if (sizeId) {
            // Add to deleted variants list
            var deletedVariants = $('#deleted_variants').val();
            var deletedArray = deletedVariants ? JSON.parse(deletedVariants) : [];
            if (!deletedArray.includes(sizeId)) {
                deletedArray.push(sizeId);
                $('#deleted_variants').val(JSON.stringify(deletedArray));
            }
        }
        row.remove();
        updateAllStocks();
    } else {
        alert('At least one size is required!');
    }
};

            // Remove Variant
            window.removeVariant = function(variantId) {
                var totalVariants = $('.variant-item').length;
                if (totalVariants > 1) {
                    if (confirm('Remove this variant?')) {
                        var existingId = $('#variant-' + variantId).find('input[name*="[id]"]').val();
                        if (existingId) {
                            var deleted = $('#deleted_variants').val();
                            if (deleted) {
                                var deletedArray = JSON.parse(deleted);
                                deletedArray.push(existingId);
                                $('#deleted_variants').val(JSON.stringify(deletedArray));
                            } else {
                                $('#deleted_variants').val(JSON.stringify([existingId]));
                            }
                        }
                        $('#variant-' + variantId).remove();
                        updateAllStocks();
                    }
                } else {
                    alert('At least one variant is required!');
                }
            };

            // Preview Variant Images
        window.previewVariantImages = function(input, variantId) {
    variantId = variantId || 'default';
    var files = Array.from(input.files);

    if (!window.variantImageFiles[variantId]) {
        window.variantImageFiles[variantId] = [];
    }

    // Store the actual file objects
    window.variantImageFiles[variantId] = window.variantImageFiles[variantId].concat(files);
    
    // Show preview
    updateVariantImagePreview(variantId);
    
    // IMPORTANT: Keep the files in the input
    var dataTransfer = new DataTransfer();
    window.variantImageFiles[variantId].forEach(function(file) {
        dataTransfer.items.add(file);
    });
    input.files = dataTransfer.files;
};

            function updateVariantImagePreview(variantId) {
                var previewId = 'variant_images_preview_' + variantId;
                var preview = $('#' + previewId);
                preview.find('.new-image').remove();

                if (!window.variantImageFiles[variantId] || window.variantImageFiles[variantId].length === 0)
            return;

                window.variantImageFiles[variantId].forEach(function(file, index) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.append(
                            '<div class="variant-image-preview-item new-image">' +
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
    if (window.variantImageFiles[variantId]) {
        window.variantImageFiles[variantId].splice(index, 1);
        
        // Update the file input
        var input = document.getElementById('variant_images_input_' + variantId);
        if (input) {
            var dataTransfer = new DataTransfer();
            window.variantImageFiles[variantId].forEach(function(file) {
                dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        }
        
        var previewId = 'variant_images_preview_' + variantId;
        $('#' + previewId).find('.new-image').remove();
        updateVariantImagePreview(variantId);
    }
};

        window.removeExistingVariantImage = function(imageId, variantId) {
    if (confirm('Remove this image?')) {
        var element = $('input[name="variants[' + variantId + '][existing_images][]"][value="' +
            imageId + '"]');
        element.closest('.variant-image-preview-item').remove();

        var deletedInput = $('#deleted_variant_images');
        var deleted = deletedInput.val();
        if (deleted) {
            var deletedArray = JSON.parse(deleted);
            if (!deletedArray.includes(imageId)) {
                deletedArray.push(imageId);
                deletedInput.val(JSON.stringify(deletedArray));
            }
        } else {
            deletedInput.val(JSON.stringify([imageId]));
        }
    }
};

            // Remove Existing Image
            window.removeExistingImage = function(imageId) {
                if (confirm('Remove this image?')) {
                    var deleted = $('#deleted_images').val();
                    var deletedArray = deleted ? JSON.parse(deleted) : [];
                    deletedArray.push(imageId);
                    $('#deleted_images').val(JSON.stringify(deletedArray));
                    $('#existing-image-' + imageId).hide();
                }
            };

            // ===== INITIAL SETUP =====
            @if ($product->variants && $product->variants->count() > 0)
                isVariantMode = true;
                $('#variantSection').show();
                $('#pricingSection').addClass('hidden-section');
                $('#inventorySection').hide();
                $('#productImagesSection').hide();
                $('#grandTotalStockSection').show();
                $('.variant-required').prop('required', true);
                updateAllStocks();
                updateVariantGst();
            @else
                $('#variantSection').hide();
                $('#pricingSection').removeClass('hidden-section');
                $('#inventorySection').show();
                $('#productImagesSection').show();
                $('#grandTotalStockSection').hide();
                $('.variant-required').prop('required', false);
            @endif

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
                    $('#variantSection').show();
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

                    updateVariantGst();
                    updateAllStocks();
                } else {
                    isVariantMode = false;
                    $('#pricingSection').removeClass('hidden-section');
                    $('#inventorySection').show();
                    $('#productImagesSection').show();
                    $('#variantSection').hide();
                    $('#grandTotalStockSection').hide();
                    $('.variant-required').prop('required', false);
                }
            };

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

            function calculateAll() {
                var sellingPrice = parseFloat($('#mrp').val()) || 0;
                var discountType = $('input[name="discount_type"]:checked').val();
                var discountValue = parseFloat($('#discount_value').val()) || 0;
                var gstRate = currentGstRate || 0;

                var gstAmount = (sellingPrice * gstRate) / 100;
                var totalPrice = sellingPrice + gstAmount;

                var discountAmount = 0;
                if (discountType === 'flat') {
                    discountAmount = discountValue;
                    $('#discount_value_hint').text('Enter flat discount amount (₹)');
                } else {
                    discountAmount = (sellingPrice * discountValue) / 100;
                    $('#discount_value_hint').text('Enter percentage discount (%)');
                }

                var finalPrice = totalPrice - discountAmount;
                if (finalPrice < 0) finalPrice = 0;

                $('#gst_amount_field').val(gstAmount.toFixed(2));
                $('#total_price_display').val(totalPrice.toFixed(2));
                $('#discount_amount_display').val(discountAmount.toFixed(2));
                $('#final_price').val(finalPrice.toFixed(2));

                $('#hidden_gst_percentage').val(gstRate);
                $('#hidden_gst_amount').val(gstAmount.toFixed(2));
                $('#hidden_total_price').val(totalPrice.toFixed(2));
                $('#hidden_discount_amount').val(discountAmount.toFixed(2));
                $('#hidden_discount_value').val(discountValue);
                $('#hidden_discount_type').val(discountType);
                $('#hidden_final_price').val(finalPrice.toFixed(2));

                $('#flow_selling').text('₹' + sellingPrice.toFixed(2));
                $('#flow_gst').text('₹' + gstAmount.toFixed(2));
                $('#flow_total_price').text('₹' + totalPrice.toFixed(2));
                $('#flow_discount').text('₹' + discountAmount.toFixed(2));
                $('#flow_final').text('₹' + finalPrice.toFixed(2));

                if (gstRate > 0) {
                    $('#gst_calc_info').text('GST @ ' + gstRate + '% on SP ₹' + sellingPrice.toFixed(2));
                    $('#gst_amount_display').text('₹' + gstAmount.toFixed(2));
                    $('#discount_calc_info').text('Discount on Total Price');
                } else {
                    $('#gst_calc_info').text('No GST applied');
                    $('#gst_amount_display').text('₹0.00');
                    $('#discount_calc_info').text('Discount on SP');
                }
            }

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

            // ===== ADD SIZE BUTTON =====
            $(document).on('click', '.add-size-btn', function(e) {
                e.preventDefault();
                var variantId = $(this).data('variant');

                if (!variantId) {
                    alert('Variant ID is missing!');
                    return;
                }

                var container = $('#sizesContainer_' + variantId);
                if (container.length === 0) {
                    alert('Sizes container not found for variant: ' + variantId);
                    return;
                }

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

            // ===== ADD VARIANT BUTTON =====
            $('#addVariantBtn').on('click', function(e) {
                e.preventDefault();
                variantCounter++;
                var variantId = 'variant_' + variantCounter;
                window.variantImageFiles[variantId] = [];

                var newVariant = `
                    <div class="variant-item" id="variant-${variantId}">
                        <div class="variant-header">
                            <span class="variant-number"><i class="fas fa-palette me-2"></i> Variant #${variantCounter}</span>
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

            // ===== PRODUCT IMAGE FUNCTIONS =====
            window.imageFiles = [];

            window.previewImages = function(input) {
                var files = Array.from(input.files);
                var totalFiles = window.imageFiles.length + files.length;
                var existingCount = {{ isset($productImages) ? $productImages->count() : 0 }};

                if ((existingCount + totalFiles) > 4) {
                    alert('Maximum 4 images total. You have ' + existingCount + ' existing images.');
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
                            '<button type="button" class="remove-img" onclick="removeNewImage(' +
                            index + ')">×</button>' +
                            '<span class="badge bg-secondary d-block text-center">New</span>' +
                            '</div>'
                        );
                    };
                    reader.readAsDataURL(file);
                });
            }

            window.removeNewImage = function(index) {
                window.imageFiles.splice(index, 1);
                updateImagePreview();

                var dataTransfer = new DataTransfer();
                for (var i = 0; i < window.imageFiles.length; i++) {
                    dataTransfer.items.add(window.imageFiles[i]);
                }
                document.getElementById('product_images_input').files = dataTransfer.files;
            };

            // ===== CATEGORY CHANGE EVENTS =====
            $('#category').on('change', function() {
                var catId = $(this).val();
                if (catId) {
                    $.get('/admin/get-subcategories/' + catId, function(data) {
                        var subSelect = $('#sub_category');
                        subSelect.empty().append(
                            '<option value="">-- Select Sub Category --</option>');
                        $.each(data, function(i, sub) {
                            subSelect.append('<option value="' + sub.id + '">' + sub.name +
                                '</option>');
                        });
                    });
                }
            });

            $('#top_category').on('change', function() {
                var topId = $(this).val();
                if (topId) {
                    $.get('/admin/get-categories/' + topId, function(data) {
                        var categorySelect = $('#category');
                        categorySelect.empty().append(
                            '<option value="">-- Select Category --</option>');
                        $.each(data, function(i, cat) {
                            categorySelect.append('<option value="' + cat.id + '">' + cat
                                .name + '</option>');
                        });
                        $('#sub_category').empty().append(
                            '<option value="">-- Select Sub Category --</option>');
                    });

                    // Fetch GST
                    var selectedOption = $(this).find('option:selected');
                    var dataGst = parseFloat(selectedOption.data('gst')) || 0;

                    $('#gst_badge').show().html('<i class="fas fa-spinner fa-spin"></i> Loading GST...');

                    if (dataGst > 0) {
                        currentGstRate = dataGst;
                        updateGstInfo(dataGst);
                        $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '%')
                            .show();
                        $('#gst_selected_info').text('GST: ' + dataGst + '% (from ' + selectedOption.text()
                            .trim() + ')');
                    }

                    $.ajax({
                        url: '/admin/get-gst-rate/' + topId,
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

            // ===== DISCOUNT TYPE CHANGE =====
            $('input[name="discount_type"]').on('change', function() {
                var discountType = $(this).val();
                if (discountType === 'flat') {
                    $('#discount_value').attr('placeholder', 'Enter flat amount');
                    $('#discount_value_hint').text('Enter flat discount amount (₹)');
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

            // ===== FORM SUBMIT =====
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
                    1 : variantCounter));
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
                        'default' ? 1 : variantCounter) + ', Size ' + (
                        index + 1));
                    sizeInput.focus();
                    return false;
                }
                if (!costPriceInput.val() || parseFloat(costPriceInput.val()) <=
                    0) {
                    hasError = true;
                    costPriceInput.addClass('is-invalid');
                    alert('Please enter valid cost price for Variant #' + (
                            variantId === 'default' ? 1 : variantCounter) +
                        ', Size ' + (index + 1));
                    costPriceInput.focus();
                    return false;
                }
                if (!mrpInput.val() || parseFloat(mrpInput.val()) <= 0) {
                    hasError = true;
                    mrpInput.addClass('is-invalid');
                    alert('Please enter valid MRP for Variant #' + (
                            variantId === 'default' ? 1 : variantCounter) +
                        ', Size ' + (index + 1));
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
        
        // IMPORTANT: Set the variant images in the file inputs before submit
        for (var key in window.variantImageFiles) {
            if (window.variantImageFiles[key] && window.variantImageFiles[key].length > 0) {
                var input = document.getElementById('variant_images_input_' + key);
                if (input) {
                    var dataTransfer = new DataTransfer();
                    window.variantImageFiles[key].forEach(function(file) {
                        dataTransfer.items.add(file);
                    });
                    input.files = dataTransfer.files;
                }
            }
        }
    }

    if (!isVariantMode) {
        var stock = parseInt($('#stock').val());
        if (isNaN(stock) || stock < 0) {
            e.preventDefault();
            alert('Stock cannot be negative.');
            return false;
        }

        var sellingPrice = parseFloat($('#mrp').val()) || 0;
        var finalPrice = parseFloat($('#final_price').val()) || 0;

        if (sellingPrice <= 0) {
            e.preventDefault();
            alert('Please enter a valid selling price.');
            return false;
        }

        if (finalPrice < 0) {
            e.preventDefault();
            alert('Final price cannot be negative. Please check your discount.');
            return false;
        }
    }

    // For product images
    var dataTransfer = new DataTransfer();
    for (var i = 0; i < window.imageFiles.length; i++) {
        dataTransfer.items.add(window.imageFiles[i]);
    }
    document.getElementById('product_images_input').files = dataTransfer.files;

    return true;
});

            // ===== INITIAL CALCULATION =====
            calculateAll();
            updateAllStocks();
            updateVariantGst();
        });
    </script>
@endsection
