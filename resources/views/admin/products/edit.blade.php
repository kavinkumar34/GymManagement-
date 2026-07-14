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

        .variant-item {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            position: relative;
        }

        .variant-item .variant-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .variant-item .variant-number {
            font-weight: 600;
            color: #0d6efd;
            font-size: 14px;
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

        .form-label-sm {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
            color: #495057;
        }

        .form-control-sm {
            font-size: 13px;
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

        .size-chart-badge.men { background: #cfe2ff; color: #084298; }
        .size-chart-badge.women { background: #f8d7da; color: #721c24; }
        .size-chart-badge.kids { background: #d1e7dd; color: #0f5132; }
        .size-chart-badge.unisex { background: #e2d9f3; color: #4b0082; }
        .size-chart-badge.topwear { background: #fff3cd; color: #856404; }
        .size-chart-badge.bottomwear { background: #d6d8db; color: #1e2124; }
        .size-chart-badge.footwear { background: #fce4ec; color: #c62828; }

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

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                            enctype="multipart/form-data" id="productForm">
                            @csrf
                            @method('PUT')

                            <!-- Hidden inputs for discount fields -->
                            <input type="hidden" name="discount_type" id="hidden_discount_type" value="{{ $product->discount_type ?? 'flat' }}">
                            <input type="hidden" name="discount_value" id="hidden_discount_value" value="{{ $product->discount_value ?? 0 }}">
                            <input type="hidden" name="discount_amount" id="hidden_discount_amount" value="{{ $product->discount_amount ?? 0 }}">
                            <input type="hidden" name="gst_percentage" id="hidden_gst_percentage" value="{{ $product->gst_percentage ?? 0 }}">
                            <input type="hidden" name="gst_amount" id="hidden_gst_amount" value="{{ $product->gst_amount ?? 0 }}">
                            <input type="hidden" name="total_price" id="hidden_total_price" value="{{ $product->total_price ?? 0 }}">
                            <input type="hidden" name="final_price" id="hidden_final_price" value="{{ $product->final_price ?? 0 }}">

                            <div class="row">
                                <!-- LEFT COLUMN - 8 columns -->
                                <div class="col-md-8">
                                    <!-- Basic Information -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Basic Information</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Product Name <span class="required-star">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $product->name) }}" required>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="field-label">Top Category <span class="required-star">*</span></label>
                                                    <select name="top_category_id" id="top_category" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($topCategories as $tc)
                                                            <option value="{{ $tc->id }}" data-gst="{{ $tc->gst_rate ?? 0 }}"
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
                                                    <label class="field-label">Category <span class="required-star">*</span></label>
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
                                                    <label class="field-label">Sub Category <span class="required-star">*</span></label>
                                                    <select name="sub_category_id" id="sub_category" class="form-control" required>
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
                                                    <select name="product_type_id" id="product_type_id" class="form-control">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($productTypes as $pt)
                                                            <option value="{{ $pt->id }}"
                                                                {{ old('product_type_id', $product->product_type_id) == $pt->id ? 'selected' : '' }}>
                                                                {{ $pt->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="productTypeHelper">Select product type</div>
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
                                                                <span class="size-chart-badge {{ $sc->gender ?? 'unisex' }}">{{ ucfirst($sc->gender ?? 'Unisex') }}</span>
                                                                <span class="size-chart-badge {{ $sc->category_type ?? 'topwear' }}">{{ ucfirst($sc->category_type ?? 'Topwear') }}</span>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-text" id="sizeChartHelper">Select a size chart for this product</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing with GST and Discount -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            Pricing, GST & Discount
                                            <span id="gst_badge" class="gst-badge"
                                                style="{{ $product->top_category_id && $product->topCategory && $product->topCategory->gst_rate ? 'display:inline-block;' : 'display:none;' }}">
                                                <i class="fas fa-check-circle"></i> GST: {{ $product->topCategory->gst_rate ?? 0 }}%
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <!-- GST Info -->
                                            <div class="gst-info" id="gst_info_box"
                                                style="{{ $product->top_category_id && $product->topCategory && $product->topCategory->gst_rate ? 'display:block;' : 'display:none;' }}">
                                                <span class="gst-label"><i class="fas fa-percent"></i> GST Rate:</span>
                                                <span id="gst_rate_display">{{ $product->topCategory->gst_rate ?? 0 }}%</span>
                                                <span style="margin-left: 15px;" class="gst-label"><i class="fas fa-calculator"></i> GST Amount:</span>
                                                <span id="gst_amount_display">₹{{ number_format(($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span>
                                                <span style="margin-left: 15px; color: #6c757d; font-size: 12px;">(Calculated on SP)</span>
                                            </div>

                                            <!-- Calculation Flow -->
                                            <div class="calculation-flow" id="calculation_flow">
                                                <span class="step">SP: <span class="highlight" id="flow_selling">₹{{ number_format($product->mrp, 2) }}</span></span>
                                                <span class="arrow">+</span>
                                                <span class="step">GST: <span class="highlight" id="flow_gst">₹{{ number_format(($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span></span>
                                                <span class="arrow">=</span>
                                                <span class="step">Total: <span class="highlight" id="flow_total_price">₹{{ number_format($product->mrp + ($product->mrp * ($product->topCategory->gst_rate ?? 0)) / 100, 2) }}</span></span>
                                                <span class="arrow">-</span>
                                                <span class="step">Disc: <span class="highlight" id="flow_discount">₹{{ number_format($product->mrp - $product->final_price, 2) }}</span></span>
                                                <span class="arrow">=</span>
                                                <span class="step" style="border-color: #28a745; background: #d4edda;">Final: <span class="highlight green" id="flow_final">₹{{ number_format($product->final_price, 2) }}</span></span>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Cost Price (₹) <span class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="price" id="price" class="form-control" required min="0" value="{{ old('price', $product->price) }}">
                                                    </div>
                                                    <div class="help-text">Your purchase price</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Selling Price (₹) <span class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="mrp" id="mrp" class="form-control" required min="0" value="{{ old('mrp', $product->mrp) }}" oninput="calculateAll()">
                                                    </div>
                                                    <div class="help-text">Customer price before discount</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Discount Type</label>
                                                    <div class="discount-type-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="discount_type" id="discount_flat" value="flat" {{ old('discount_type', $product->discount_type ?? 'flat') == 'flat' ? 'checked' : '' }} onchange="calculateAll()">
                                                            <label class="form-check-label" for="discount_flat">Flat</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="discount_type" id="discount_percentage" value="percentage" {{ old('discount_type', $product->discount_type ?? 'flat') == 'percentage' ? 'checked' : '' }} onchange="calculateAll()">
                                                            <label class="form-check-label" for="discount_percentage">%</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Discount Value</label>
                                                    <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control" min="0" value="{{ old('discount_value', $product->discount_value ?? 0) }}" oninput="calculateAll()">
                                                    <div class="help-text" id="discount_value_hint">Enter discount amount</div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">GST Amt (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="gst_amount_field" class="form-control" readonly style="background-color: #e9ecef; font-weight: bold; color: #0d6efd;">
                                                    </div>
                                                    <div class="help-text" id="gst_calc_info">GST on SP</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Total Price (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="total_price_display" class="form-control" readonly style="background-color: #e9ecef; font-weight: bold; color: #0d6efd;">
                                                    </div>
                                                    <div class="help-text">SP + GST</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Disc Amt (₹)</label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" id="discount_amount_display" class="form-control" readonly style="background-color: #e9ecef; font-weight: bold; color: #dc3545;">
                                                    </div>
                                                    <div class="help-text" id="discount_calc_info">Calculated from discount</div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label class="field-label">Final Price (₹) <span class="required-star">*</span></label>
                                                    <div class="price-input-group">
                                                        <span class="currency-symbol">₹</span>
                                                        <input type="number" step="0.01" name="final_price" id="final_price" class="form-control" readonly style="background-color: #d4edda; font-weight: bold; color: #28a745; font-size: 18px;" value="{{ old('final_price', $product->final_price) }}">
                                                    </div>
                                                    <div class="help-text">Total - Discount</div>
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
                                                <label class="field-label">Description <span class="text-muted">(Use bullet points with ● or -)</span></label>
                                                <textarea name="description" id="description" class="form-control" rows="8"
                                                    placeholder="Enter product description with bullet points...">{{ old('description', $product->description) }}</textarea>
                                                <div class="help-text">
                                                    <i class="fas fa-info-circle"></i> Use <code>•</code> or <code>-</code> for bullet points. HTML supported.
                                                </div>
                                            </div>

                                            <div class="mt-3" id="descriptionPreview" style="{{ old('description', $product->description) ? 'display:block;' : 'display:none;' }}">
                                                <label class="fw-bold">Preview:</label>
                                                <div class="border rounded p-3 bg-light" id="descriptionPreviewContent">
                                                    {!! $product->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- RIGHT COLUMN - 4 columns -->
                                <div class="col-md-4">
                                    <!-- Inventory -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Inventory & Status</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Stock Qty <span class="required-star">*</span></label>
                                                <input type="number" name="stock" id="stock" class="form-control"
                                                    value="{{ old('stock', $product->stock) }}" min="0" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Active" {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                    <option value="Draft" {{ old('status', $product->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Images -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Product Images</div>
                                        <div class="card-body">
                                            <!-- Existing Images -->
                                            @if (isset($productImages) && $productImages->count() > 0)
                                                <div class="mb-3">
                                                    <label class="field-label">Existing Images</label>
                                                    <div class="d-flex flex-wrap">
                                                        @foreach ($productImages as $image)
                                                            <div class="existing-image-item" id="existing-image-{{ $image->id }}">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                                                                <button type="button" class="remove-existing-img" onclick="removeExistingImage({{ $image->id }})">×</button>
                                                                <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="deleted_images" id="deleted_images" value="">
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label class="d-block field-label">Add New Images <span class="text-muted">(Max 4 total)</span></label>
                                                <div class="image-upload-area" onclick="document.getElementById('product_images_input').click()">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                    <p class="mb-0">Click to upload new images</p>
                                                </div>
                                                <input type="file" id="product_images_input" name="new_images[]" class="form-control mt-2" accept="image/*" multiple style="display: block;" onchange="previewImages(this)">
                                                <div id="images_preview" class="image-preview-container mt-3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Return & Delivery -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">Return & Delivery</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="field-label">Cash on Delivery (COD)</label>
                                                <div class="d-flex align-items-center mt-2">
                                                    <label class="switch">
                                                        <input type="checkbox" name="cod_available" id="cod_toggle" value="1" {{ old('cod_available', $product->cod_available) ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <span class="toggle-label">Status: <span id="cod_status" class="toggle-status {{ old('cod_available', $product->cod_available) ? 'active' : 'inactive' }}">{{ old('cod_available', $product->cod_available) ? 'Available' : 'Not Available' }}</span></span>
                                                </div>
                                                <div class="help-text">Toggle to enable/disable COD</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Return Days</label>
                                                <select name="return_days" class="form-control">
                                                    <option value="3" {{ old('return_days', $product->return_days) == 3 ? 'selected' : '' }}>3 Days</option>
                                                    <option value="7" {{ old('return_days', $product->return_days) == 7 ? 'selected' : '' }}>7 Days</option>
                                                    <option value="15" {{ old('return_days', $product->return_days) == 15 ? 'selected' : '' }}>15 Days</option>
                                                    <option value="30" {{ old('return_days', $product->return_days) == 30 ? 'selected' : '' }}>30 Days</option>
                                                    <option value="0" {{ old('return_days', $product->return_days) == 0 ? 'selected' : '' }}>Non-returnable</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="field-label">Delivery Days</label>
                                                <select name="delivery_days" class="form-control">
                                                    <option value="1" {{ old('delivery_days', $product->delivery_days) == 1 ? 'selected' : '' }}>1 Day</option>
                                                    <option value="2" {{ old('delivery_days', $product->delivery_days) == 2 ? 'selected' : '' }}>2 Days</option>
                                                    <option value="3" {{ old('delivery_days', $product->delivery_days) == 3 ? 'selected' : '' }}>3 Days</option>
                                                    <option value="5" {{ old('delivery_days', $product->delivery_days) == 5 ? 'selected' : '' }}>5 Days</option>
                                                    <option value="7" {{ old('delivery_days', $product->delivery_days) == 7 ? 'selected' : '' }}>7 Days</option>
                                                    <option value="10" {{ old('delivery_days', $product->delivery_days) == 10 ? 'selected' : '' }}>10 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      

                            <!-- Submit -->
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
            var variantIndex = {{ isset($product->variants) ? $product->variants->count() : 0 }};
            var currentGstRate = {{ $product->topCategory->gst_rate ?? 0 }};
            var deletedVariants = [];
            var deletedImages = [];

            // ========== TOP CATEGORY CHANGE - FETCH GST ==========
            $('#top_category').on('change', function() {
                var topCategoryId = $(this).val();
                var selectedOption = $(this).find('option:selected');
                var dataGst = parseFloat(selectedOption.data('gst')) || 0;

                if (topCategoryId) {
                    $('#gst_badge').show().html('<i class="fas fa-spinner fa-spin"></i> Loading GST...');

                    if (dataGst > 0) {
                        currentGstRate = dataGst;
                        updateGstInfo(dataGst);
                        $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '%').show();
                        $('#gst_selected_info').text('GST: ' + dataGst + '% (from ' + selectedOption.text().trim() + ')');
                    }

                    $.ajax({
                        url: '/admin/get-gst-rate/' + topCategoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.gst_rate > 0) {
                                currentGstRate = response.gst_rate;
                                updateGstInfo(response.gst_rate);
                                $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + response.gst_rate + '%').show();
                                $('#gst_selected_info').text('GST: ' + response.gst_rate + '% (from ' + selectedOption.text().trim() + ')');
                            } else if (dataGst === 0) {
                                $('#gst_badge').html('<i class="fas fa-exclamation-circle"></i> No GST set').show();
                                $('#gst_selected_info').text('No GST set for this category');
                                currentGstRate = 0;
                                updateGstInfo(0);
                            }
                            calculateAll();
                        },
                        error: function() {
                            if (dataGst > 0) {
                                currentGstRate = dataGst;
                                updateGstInfo(dataGst);
                                $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '%').show();
                            } else {
                                currentGstRate = 0;
                                updateGstInfo(0);
                                $('#gst_badge').html('<i class="fas fa-exclamation-triangle"></i> Error loading GST').show();
                            }
                            calculateAll();
                        }
                    });
                } else {
                    $('#gst_badge').hide();
                    $('#gst_selected_info').text('Select top category to auto-fill GST');
                    currentGstRate = 0;
                    updateGstInfo(0);
                    calculateAll();
                }
            });

            // ========== UPDATE GST INFO ==========
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

            // ========== CALCULATE ALL ==========
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

                // Update display fields
                $('#gst_amount_field').val(gstAmount.toFixed(2));
                $('#total_price_display').val(totalPrice.toFixed(2));
                $('#discount_amount_display').val(discountAmount.toFixed(2));
                $('#final_price').val(finalPrice.toFixed(2));

                // Update hidden fields
                $('#hidden_gst_percentage').val(gstRate);
                $('#hidden_gst_amount').val(gstAmount.toFixed(2));
                $('#hidden_total_price').val(totalPrice.toFixed(2));
                $('#hidden_discount_amount').val(discountAmount.toFixed(2));
                $('#hidden_discount_value').val(discountValue);
                $('#hidden_discount_type').val(discountType);
                $('#hidden_final_price').val(finalPrice.toFixed(2));

                // Update Flow Display
                $('#flow_selling').text('₹' + sellingPrice.toFixed(2));
                $('#flow_gst').text('₹' + gstAmount.toFixed(2));
                $('#flow_total_price').text('₹' + totalPrice.toFixed(2));
                $('#flow_discount').text('₹' + discountAmount.toFixed(2));
                $('#flow_final').text('₹' + finalPrice.toFixed(2));

                // Update GST info
                if (gstRate > 0) {
                    $('#gst_calc_info').text('GST @ ' + gstRate + '% on SP ₹' + sellingPrice.toFixed(2));
                    $('#gst_amount_display').text('₹' + gstAmount.toFixed(2));
                    $('#discount_calc_info').text('Discount on Total Price');
                } else {
                    $('#gst_calc_info').text('No GST applied');
                    $('#gst_amount_display').text('₹0.00');
                    $('#discount_calc_info').text('Discount on SP');
                }

                var savedAmount = sellingPrice - finalPrice;
                if (savedAmount < 0) savedAmount = 0;
                $('#saved_amount').text('₹' + savedAmount.toFixed(2));

                var discountPercent = 0;
                if (sellingPrice > 0 && finalPrice > 0) {
                    discountPercent = ((sellingPrice - finalPrice) / sellingPrice) * 100;
                }
                if (discountPercent < 0) discountPercent = 0;
                $('#discount_percent_info').text(discountPercent.toFixed(1) + '% off');

                $('#final_total_display').text('₹' + finalPrice.toFixed(2));

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

            // ========== DISCOUNT TYPE CHANGE ==========
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

            // ========== PRICE CHANGE EVENTS ==========
            $('#mrp, #discount_value').on('input', function() {
                calculateAll();
            });

            // ========== COD TOGGLE STATUS ==========
            $('#cod_toggle').on('change', function() {
                var isChecked = $(this).is(':checked');
                var statusSpan = $('#cod_status');
                if (isChecked) {
                    statusSpan.text('Available').removeClass('inactive').addClass('active');
                } else {
                    statusSpan.text('Not Available').removeClass('active').addClass('inactive');
                }
            });

            // ========== ADD VARIANT ==========
            function addVariant() {
                variantIndex++;
                var html = `
                <div class="variant-item" id="variant-${variantIndex}">
                    <div class="variant-header">
                        <span class="variant-number"><i class="fas fa-palette me-2"></i> Variant #${variantIndex}</span>
                        <button type="button" class="remove-variant" data-variant="${variantIndex}">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label class="form-label-sm">Size</label>
                            <select name="variants[${variantIndex}][size]" class="form-control form-control-sm">
                                <option value="">Select Size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label-sm">Color</label>
                            <input type="text" name="variants[${variantIndex}][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label-sm">Stock <span class="required-star">*</span></label>
                            <input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm variant-stock" value="0" min="0" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label-sm">Price (₹)</label>
                            <input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm" min="0" placeholder="Optional">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label-sm">Value</label>
                            <input type="text" name="variants[${variantIndex}][value]" class="form-control form-control-sm" placeholder="e.g. 32">
                        </div>
                    </div>
                </div>
            `;
                $('#variants_container').append(html);
            }

            $('#add_variant').on('click', function() {
                addVariant();
            });

            $(document).on('click', '.remove-variant', function() {
                var variantId = $(this).data('variant');
                var variantElement = $('#variant-' + variantId);
                var variantInput = variantElement.find('input[name*="[id]"]');

                if (variantInput.length > 0) {
                    var variantDbId = variantInput.val();
                    if (variantDbId) {
                        deletedVariants.push(variantDbId);
                        $('#deleted_variants').val(JSON.stringify(deletedVariants));
                    }
                }

                variantElement.remove();
            });

            // ========== REMOVE EXISTING IMAGE ==========
            window.removeExistingImage = function(imageId) {
                if (confirm('Remove this image?')) {
                    deletedImages.push(imageId);
                    $('#deleted_images').val(JSON.stringify(deletedImages));
                    $('#existing-image-' + imageId).hide();
                }
            };

            // ========== CATEGORY CHANGE ==========
            $('#category').on('change', function() {
                var catId = $(this).val();
                if (catId) {
                    $.get('/admin/get-subcategories/' + catId, function(data) {
                        var subSelect = $('#sub_category');
                        subSelect.empty().append('<option value="">-- Select Sub Category --</option>');
                        $.each(data, function(i, sub) {
                            subSelect.append('<option value="' + sub.id + '">' + sub.name + '</option>');
                        });
                        $('select[name="product_type_id"]').empty().append('<option value="">-- Select Product Type --</option>');
                    });
                }
            });

            $('#top_category').on('change', function() {
                var topId = $(this).val();
                if (topId) {
                    $.get('/admin/get-categories/' + topId, function(data) {
                        var categorySelect = $('#category');
                        categorySelect.empty().append('<option value="">-- Select Category --</option>');
                        $.each(data, function(i, cat) {
                            categorySelect.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                        });
                        $('#sub_category').empty().append('<option value="">-- Select Sub Category --</option>');
                        $('select[name="product_type_id"]').empty().append('<option value="">-- Select Product Type --</option>');
                    });
                }
            });

            $('#sub_category').on('change', function() {
                var subId = $(this).val();
                if (subId) {
                    $.get('/admin/get-producttypes/' + subId, function(data) {
                        var ptSelect = $('select[name="product_type_id"]');
                        ptSelect.empty().append('<option value="">-- Select Product Type --</option>');
                        $.each(data, function(i, pt) {
                            ptSelect.append('<option value="' + pt.id + '">' + pt.name + '</option>');
                        });
                    });
                }
            });

            // ========== IMAGE FUNCTIONS ==========
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
                            '<button type="button" class="remove-img" onclick="removeNewImage(' + index + ')">×</button>' +
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

            // ========== FORM SUBMIT ==========
            $('#productForm').on('submit', function(e) {
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

                var dataTransfer = new DataTransfer();
                for (var i = 0; i < window.imageFiles.length; i++) {
                    dataTransfer.items.add(window.imageFiles[i]);
                }
                document.getElementById('product_images_input').files = dataTransfer.files;

                return true;
            });

            // ========== INITIAL CALCULATION ==========
            calculateAll();
        });
    </script>
@endsection