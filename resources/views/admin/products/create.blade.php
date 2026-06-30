@extends('layouts.admin-layout')

@section('content')
<style>
    .form-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    .category-attr-btn {
        border: 2px solid #dee2e6;
        padding: 8px 18px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
        font-weight: 500;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .category-attr-btn:hover {
        border-color: #0d6efd;
        background: #f0f4ff;
        transform: translateY(-2px);
    }
    .category-attr-btn.active {
        border-color: #0d6efd;
        background: #0d6efd;
        color: white;
    }
    .category-attr-btn i {
        font-size: 14px;
    }
    .attr-fields-container {
        background: #f8f9fa;
        padding: 0;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
        margin-top: 15px;
        display: none;
        overflow: hidden;
    }
    .attr-fields-container.show {
        display: block !important;
        animation: slideDown 0.4s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); max-height: 0; }
        to { opacity: 1; transform: translateY(0); max-height: 2000px; }
    }
    .attr-fields-container .attr-header {
        background: #e9ecef;
        font-weight: 600;
        padding: 10px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .attr-fields-container .attr-body {
        padding: 15px;
    }
    .attr-btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 15px 0;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid #eef2f6;
    }
    .attr-btn-group .category-attr-btn {
        flex: 0 1 auto;
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
    .attr-tag {
        display: inline-block;
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 10px;
        color: #495057;
        margin-left: 5px;
    }
    
    /* Rating Stars */
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-stars input {
        display: none;
    }
    .rating-stars label {
        font-size: 28px;
        color: #ddd;
        cursor: pointer;
        transition: 0.2s;
        padding: 0 3px;
    }
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input:checked ~ label {
        color: #ffc107;
    }
    
    /* Variant Styles */
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
    
    .gst-auto-badge {
        display: inline-block;
        background: #28a745;
        color: #fff;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        margin-left: 8px;
    }

    /* Size Chart Dropdown Styling */
    .size-chart-option {
        padding: 5px 10px;
    }
    .size-chart-option .chart-name {
        font-weight: 500;
    }
    .size-chart-option .chart-details {
        font-size: 11px;
        color: #6c757d;
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

    /* Toggle Switch for COD */
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
    input:checked + .slider {
        background-color: #28a745;
    }
    input:checked + .slider:before {
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
</style>

<div class="container-fluid">
    <div class="row" style="margin-left:220px; margin-right:20px;"> 
        <div class="col-12">
            <div class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-plus-circle me-2 text-primary"></i> Add New Product
                </div>
                <div class="form-section-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="row">
                            <!-- LEFT COLUMN - 8 columns -->
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Basic Information</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Product Name <span class="required-star">*</span></label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Top Category <span class="required-star">*</span></label>
                                                <select name="top_category_id" id="top_category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($topCategories as $tc)
                                                        <option value="{{ $tc->id }}" data-gst="{{ $tc->gst_rate ?? 0 }}">
                                                            {{ $tc->name }} 
                                                            @if($tc->gst_rate)
                                                                (GST: {{ $tc->gst_rate }}%)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Category <span class="required-star">*</span></label>
                                                <select name="category_id" id="category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Sub Category <span class="required-star">*</span></label>
                                                <select name="sub_category_id" id="sub_category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($subCategories as $sub)
                                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Brand</label>
                                                <select name="brand_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($brands as $b)
                                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Product Type</label>
                                                <select name="product_type_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($productTypes as $pt)
                                                        <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- SIZE CHART DROPDOWN -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label>Size Chart</label>
                                                <select name="size_chart_id" id="size_chart_id" class="form-control">
                                                    <option value="">-- Select Size Chart --</option>
                                                    @foreach($sizeCharts ?? [] as $sc)
                                                        <option value="{{ $sc->id }}" 
                                                                data-gender="{{ $sc->gender ?? 'unisex' }}" 
                                                                data-category="{{ $sc->category_type ?? 'topwear' }}"
                                                                style="display:none;">
                                                            {{ $sc->title }}
                                                            <span class="size-chart-badge {{ $sc->gender ?? 'unisex' }}">{{ ucfirst($sc->gender ?? 'Unisex') }}</span>
                                                            <span class="size-chart-badge {{ $sc->category_type ?? 'topwear' }}">{{ ucfirst($sc->category_type ?? 'Topwear') }}</span>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted" id="sizeChartHelper">Select Gender and Category Type to see relevant size charts</small>
                                            </div>
                                        </div>

                                        <!-- Product Rating -->
                                        <div class="mb-3">
                                            <label>Product Rating</label>
                                            <div class="rating-stars">
                                                <input type="radio" name="rating" value="5" id="star5">
                                                <label for="star5"><i class="fas fa-star"></i></label>
                                                <input type="radio" name="rating" value="4" id="star4">
                                                <label for="star4"><i class="fas fa-star"></i></label>
                                                <input type="radio" name="rating" value="3" id="star3">
                                                <label for="star3"><i class="fas fa-star"></i></label>
                                                <input type="radio" name="rating" value="2" id="star2">
                                                <label for="star2"><i class="fas fa-star"></i></label>
                                                <input type="radio" name="rating" value="1" id="star1" checked>
                                                <label for="star1"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing & GST -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        Pricing & GST 
                                        <span id="gst_badge" class="gst-auto-badge" style="display:none;">
                                            <i class="fas fa-sync-alt fa-spin"></i> Auto GST
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Price (₹) <span class="required-star">*</span></label>
                                                <input type="number" step="0.01" name="price" id="price" class="form-control" required min="0">
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label>MRP (₹)</label>
                                                <input type="number" step="0.01" name="mrp" id="mrp" class="form-control" min="0">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label>GST (%)</label>
                                                <input type="number" step="0.01" name="gst_percentage" id="gst_percentage" class="form-control" value="18" min="0">
                                                <small class="text-muted" id="gst_auto_label">(Auto from category)</small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Discount Type</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="discount_type" id="discount_flat" value="flat" checked>
                                                        <label class="form-check-label" for="discount_flat">Flat (₹)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="discount_type" id="discount_percentage" value="percentage">
                                                        <label class="form-check-label" for="discount_percentage">Percentage (%)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Discount Value</label>
                                                <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control" min="0" value="0">
                                                <small class="text-muted" id="discount_value_hint">Enter discount amount</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Description</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Short Description</label>
                                            <textarea name="short_description" class="form-control" rows="2" placeholder="Brief description"></textarea>
                                        </div>
                                     
                                        <div class="mb-3">
                                            <label>Full Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Full description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN - 4 columns -->
                            <div class="col-md-4">
                                <!-- Inventory -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Inventory</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Stock Quantity <span class="required-star">*</span></label>
                                            <input type="number" name="stock" id="stock" class="form-control" value="0" min="0" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Min Stock Alert</label>
                                            <input type="number" name="min_stock_alert" class="form-control" value="5" min="0">
                                        </div>
                                      
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Draft">Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Images -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Product Images</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="d-block">Product Images <span class="required-star">*</span> <span class="text-muted">(1-4)</span></label>
                                            <div class="image-upload-area" onclick="document.getElementById('product_images_input').click()">
                                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                <p class="mb-0">Click to upload images</p>
                                            </div>
                                            <input type="file" id="product_images_input" name="images[]" class="form-control mt-2" accept="image/*" multiple style="display: block;" onchange="previewImages(this)">
                                            <div id="images_preview" class="image-preview-container mt-3"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Return & Warranty with COD and Return/Exchange Policy -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Return & Warranty</div>
                                    <div class="card-body">
                                        <!-- Cash on Delivery Toggle -->
                                        <div class="mb-3">
                                            <label>Cash on Delivery (COD) Available</label>
                                            <div class="d-flex align-items-center mt-2">
                                                <label class="switch">
                                                    <input type="checkbox" name="cod_available" id="cod_toggle" value="1" checked>
                                                    <span class="slider"></span>
                                                </label>
                                                <span class="toggle-label">COD Status: <span id="cod_status" class="toggle-status active">Available</span></span>
                                            </div>
                                            <small class="text-muted">Toggle to enable/disable Cash on Delivery for this product</small>
                                        </div>

                                        <!-- Return & Exchange Policy -->
                                        <div class="mb-3">
                                            <label>Return & Exchange Policy</label>
                                            <select name="return_exchange_policy" class="form-control">
                                                <option value="return_available">Return Available</option>
                                                <option value="exchange_available">Exchange Available</option>
                                                <option value="both_available" selected>Return & Exchange Available</option>
                                                <option value="not_available">Not Available</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Return Days</label>
                                            <select name="return_days" class="form-control">
                                                <option value="7">7 Days</option>
                                                <option value="15">15 Days</option>
                                                <option value="30" selected>30 Days</option>
                                                <option value="0">Non-returnable</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Return Policy</label>
                                            <textarea name="return_policy" class="form-control" rows="2" placeholder="Return policy"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Warranty (Months)</label>
                                            <input type="number" name="warranty_months" class="form-control" value="0" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
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
        // ========== VARIABLE DECLARATIONS ==========
        var variantIndex = 0;
        var clothingOpened = false;

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

        // ========== SIZE CHART FILTER ==========
        function filterSizeCharts() {
            var gender = $('#gender_select').val();
            var categoryType = $('#category_type_select').val();
            
            $('#size_chart_id option').each(function() {
                var option = $(this);
                var optionGender = option.data('gender') || 'unisex';
                var optionCategory = option.data('category') || 'topwear';
                
                if (!gender && !categoryType) {
                    option.show();
                    return;
                }
                
                var matchGender = !gender || optionGender === gender;
                var matchCategory = !categoryType || optionCategory === categoryType;
                
                if (matchGender && matchCategory) {
                    option.show();
                } else {
                    option.hide();
                }
            });
            
            var visibleCount = $('#size_chart_id option:visible').length - 1;
            if (visibleCount > 0) {
                $('#sizeChartHelper').text('Showing ' + visibleCount + ' size charts matching your selection');
            } else {
                $('#sizeChartHelper').text('No size charts found for this selection. Please try different filters.');
            }
        }

        // ========== AUTO GST FETCH FROM TOP CATEGORY ==========
        $('#top_category').on('change', function() {
            var topCategoryId = $(this).val();
            
            if (topCategoryId) {
                $('#gst_badge').show().html('<i class="fas fa-spinner fa-spin"></i> Loading GST...');
                
                var selectedOption = $(this).find('option:selected');
                var dataGst = selectedOption.data('gst') || 0;
                
                $.ajax({
                    url: '/admin/get-gst-rate/' + topCategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var gstRate = response.gst_rate || 0;
                            $('#gst_percentage').val(gstRate);
                            $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + gstRate + '% (Auto)').show();
                            var selectedText = selectedOption.text().trim();
                            $('#gst_auto_label').text('(Auto from: ' + selectedText + ')');
                        } else {
                            if (dataGst > 0) {
                                $('#gst_percentage').val(dataGst);
                                $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '% (Auto)').show();
                                var selectedText = selectedOption.text().trim();
                                $('#gst_auto_label').text('(Auto from: ' + selectedText + ')');
                            } else {
                                $('#gst_badge').html('<i class="fas fa-exclamation-circle"></i> ' + (response.message || 'No GST set')).show();
                            }
                        }
                    },
                    error: function() {
                        if (dataGst > 0) {
                            $('#gst_percentage').val(dataGst);
                            $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '% (Auto from data)').show();
                            var selectedText = selectedOption.text().trim();
                            $('#gst_auto_label').text('(Auto from: ' + selectedText + ')');
                        } else {
                            $('#gst_badge').html('<i class="fas fa-exclamation-triangle"></i> Error loading GST').show();
                        }
                    }
                });
            } else {
                $('#gst_badge').hide();
                $('#gst_auto_label').text('(Auto from category)');
                $('#gst_percentage').val(18);
            }
        });

        // ========== VARIANT MANAGEMENT ==========
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
                            <label class="form-label-sm">Size <span class="required-star">*</span></label>
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
            var totalVariants = $('.variant-item').length;
            if (totalVariants <= 1) {
                alert('At least one variant is required!');
                return;
            }
            if (confirm('Remove this variant?')) {
                var variantId = $(this).data('variant');
                $('#variant-' + variantId).remove();
            }
        });

        // ========== ATTRIBUTE BUTTON TOGGLE ==========
        $('.category-attr-btn').on('click', function() {
            var attrName = $(this).data('attr');
            var isActive = $(this).hasClass('active');
            
            $('.category-attr-btn').removeClass('active');
            $('.attr-fields-container').removeClass('show');
            
            if (!isActive) {
                $(this).addClass('active');
                $('#' + attrName + '_attrs').addClass('show');
                
                if (attrName === 'clothing' && !clothingOpened) {
                    clothingOpened = true;
                    $('#variants_container').empty();
                    addVariant();
                }
            }
        });

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
        window.previewImages = function(input) {
            var files = Array.from(input.files);
            var totalFiles = window.imageFiles ? window.imageFiles.length + files.length : files.length;
            
            if (totalFiles > 4) {
                alert('Maximum 4 images only.');
                input.value = '';
                return;
            }
            
            if (!window.imageFiles) {
                window.imageFiles = [];
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
                            '<button type="button" class="remove-img" onclick="removeImage(' + index + ')">×</button>' +
                            '<span class="badge ' + (index === 0 ? 'bg-primary' : 'bg-secondary') + ' d-block text-center">' + (index === 0 ? 'Main Image' : 'Image ' + (index + 1)) + '</span>' +
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

        // ========== FORM SUBMIT ==========
        $('#productForm').on('submit', function(e) {
            var stock = parseInt($('#stock').val());
            if (isNaN(stock) || stock < 0) {
                e.preventDefault();
                alert('Stock cannot be negative.');
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
            
            return true;
        });

        // ========== INITIAL SETUP ==========
        if ($('#top_category').val()) {
            $('#top_category').trigger('change');
        }

        filterSizeCharts();
    });
</script>
@endsection