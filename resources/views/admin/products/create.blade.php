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
    
    .calculation-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
        margin-top: 10px;
    }
    .calculation-box .calc-item {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px dashed #dee2e6;
    }
    .calculation-box .calc-item:last-child {
        border-bottom: none;
    }
    .calculation-box .calc-label {
        font-weight: 500;
        color: #495057;
    }
    .calculation-box .calc-value {
        font-weight: 600;
        color: #0d6efd;
    }
    .calculation-box .calc-value.profit {
        color: #28a745;
    }
    .calculation-box .calc-value.loss {
        color: #dc3545;
    }
    .calculation-box .calc-value.discount-highlight {
        color: #ff6b6b;
        font-weight: 700;
    }
    .calculation-box .calc-value.you-save {
        color: #dc3545;
        font-weight: 700;
        font-size: 16px;
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
</style>

<div class="container">
    <div class="row" style="margin-left:200px;"> 
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
                            <!-- LEFT COLUMN -->
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

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label>Size Chart</label>
                                                <select name="size_chart_id" class="form-control">
                                                    <option value="">-- Select Size Chart --</option>
                                                    @foreach($sizeCharts ?? [] as $sc)
                                                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                                                    @endforeach
                                                </select>
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
                                                <input type="number" step="0.01" name="price" id="price" class="form-control" required min="0" oninput="calculateAll()">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Discount Price (₹)</label>
                                                <input type="number" step="0.01" name="discount_price" id="discount_price" class="form-control" min="0" oninput="calculateAll()">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>MRP (₹)</label>
                                                <input type="number" step="0.01" name="mrp" id="mrp" class="form-control" min="0" oninput="calculateAll()">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>GST (%) <span class="text-muted" id="gst_auto_label">(Auto from category)</span></label>
                                                <select name="gst_percentage" id="gst_percentage" class="form-control" onchange="calculateAll()">
                                                    <option value="0">0%</option>
                                                    <option value="5">5%</option>
                                                    <option value="10">10%</option>
                                                    <option value="12">12%</option>
                                                    <option value="18" selected>18%</option>
                                                    <option value="28">28%</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Discount Type</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="discount_type" id="discount_flat" value="flat" checked onchange="calculateAll()">
                                                        <label class="form-check-label" for="discount_flat">Flat (₹)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="discount_type" id="discount_percentage" value="percentage" onchange="calculateAll()">
                                                        <label class="form-check-label" for="discount_percentage">Percentage (%)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Discount Value</label>
                                                <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control" min="0" value="0" oninput="calculateAll()">
                                                <small class="text-muted" id="discount_value_hint">Enter discount amount</small>
                                            </div>
                                        </div>

                                        <!-- Calculation Box -->
                                        <div class="calculation-box mt-3">
                                            <h6 class="mb-3"><i class="fas fa-calculator me-2"></i> Price Calculation</h6>
                                            <div class="calc-item">
                                                <span class="calc-label">Base Price:</span>
                                                <span class="calc-value" id="calc_price">₹0.00</span>
                                            </div>
                                            <div class="calc-item">
                                                <span class="calc-label">GST (<span id="calc_gst_percent">0</span>%):</span>
                                                <span class="calc-value" id="calc_gst_amount">₹0.00</span>
                                            </div>
                                            <div class="calc-item">
                                                <span class="calc-label">Total Price (With GST):</span>
                                                <span class="calc-value" id="calc_total_price">₹0.00</span>
                                            </div>
                                            <div class="calc-item">
                                                <span class="calc-label">MRP:</span>
                                                <span class="calc-value" id="calc_mrp">₹0.00</span>
                                            </div>
                                            <div class="calc-item">
                                                <span class="calc-label">Profit / Loss:</span>
                                                <span class="calc-value" id="calc_profit">₹0.00</span>
                                            </div>
                                            <div class="calc-item">
                                                <span class="calc-label">Discount Applied:</span>
                                                <span class="calc-value discount-highlight" id="calc_discount">₹0.00</span>
                                            </div>
                                            <div class="calc-item" style="border-bottom: 2px solid #0d6efd; padding-bottom: 8px; margin-bottom: 5px;">
                                                <span class="calc-label" style="font-weight: 700;">Final Price After Discount:</span>
                                                <span class="calc-value" style="font-weight: 700; font-size: 16px; color: #28a745;" id="calc_final_price">₹0.00</span>
                                            </div>
                                            <div class="calc-item">
                                                <span class="calc-label">Total Stock (Including Variants):</span>
                                                <span class="calc-value" id="calc_total_stock">0</span>
                                            </div>
                                            <div class="calc-item" style="background: #fff3cd; padding: 8px 12px; border-radius: 4px; margin-top: 5px; border-left: 3px solid #ffc107;">
                                                <span class="calc-label" style="font-weight: 700;">🤑 You Save:</span>
                                                <span class="calc-value you-save" id="calc_you_save">₹0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Category Attributes -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-cog me-2 text-primary"></i> Product Attributes
                                        <small class="text-muted ms-2">Select category to see relevant attributes</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="attr-btn-group">
                                            <button type="button" class="category-attr-btn" data-attr="clothing">
                                                <i class="fas fa-tshirt"></i> Clothing
                                                <span class="attr-tag">Men/Women</span>
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="footwear">
                                                <i class="fas fa-shoe-prints"></i> Footwear
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="equipment">
                                                <i class="fas fa-dumbbell"></i> Equipment
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="massager">
                                                <i class="fas fa-hand-sparkles"></i> Massagers
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="accessory">
                                                <i class="fas fa-shopping-bag"></i> Accessories
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="supplements">
                                                <i class="fas fa-flask"></i> Supplements
                                            </button>
                                        </div>

                                        <!-- CLOTHING ATTRIBUTES -->
                                        <div id="clothing_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-tshirt me-2"></i> Clothing Attributes <span class="badge bg-secondary">Men/Women</span></div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Clothing Type <span class="required-star">*</span></label>
                                                        <select name="attributes[clothing][clothing_type]" class="form-control form-control-sm">
                                                            <option value="">Select Type</option>
                                                            <option value="T-Shirt">T-Shirt</option>
                                                            <option value="Shirt">Shirt</option>
                                                            <option value="Pant">Pant</option>
                                                            <option value="Jeans">Jeans</option>
                                                            <option value="Jacket">Jacket</option>
                                                            <option value="Sweater">Sweater</option>
                                                            <option value="Hoodie">Hoodie</option>
                                                            <option value="Track Pant">Track Pant</option>
                                                            <option value="Shorts">Shorts</option>
                                                            <option value="Leggings">Leggings</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color <span class="required-star">*</span></label>
                                                        <input type="text" name="attributes[clothing][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red, Blue">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Material</label>
                                                        <select name="attributes[clothing][material]" class="form-control form-control-sm">
                                                            <option value="">Select Material</option>
                                                            <option value="Cotton">Cotton</option>
                                                            <option value="Polyester">Polyester</option>
                                                            <option value="Linen">Linen</option>
                                                            <option value="Denim">Denim</option>
                                                            <option value="Leather">Leather</option>
                                                            <option value="Wool">Wool</option>
                                                            <option value="Spandex">Spandex</option>
                                                            <option value="Nylon">Nylon</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Waist Size (For Pants)</label>
                                                        <select name="attributes[clothing][waist_size]" class="form-control form-control-sm">
                                                            <option value="">Select Waist</option>
                                                            <option value="28">28</option>
                                                            <option value="30">30</option>
                                                            <option value="32">32</option>
                                                            <option value="34">34</option>
                                                            <option value="36">36</option>
                                                            <option value="38">38</option>
                                                            <option value="40">40</option>
                                                            <option value="42">42</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Inseam Length</label>
                                                        <select name="attributes[clothing][inseam_length]" class="form-control form-control-sm">
                                                            <option value="">Select Inseam</option>
                                                            <option value="28">28"</option>
                                                            <option value="30">30"</option>
                                                            <option value="32">32"</option>
                                                            <option value="34">34"</option>
                                                            <option value="36">36"</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Sleeve Type</label>
                                                        <select name="attributes[clothing][sleeve]" class="form-control form-control-sm">
                                                            <option value="">Select Sleeve</option>
                                                            <option value="Full Sleeve">Full Sleeve</option>
                                                            <option value="Half Sleeve">Half Sleeve</option>
                                                            <option value="Sleeveless">Sleeveless</option>
                                                            <option value="Cap Sleeve">Cap Sleeve</option>
                                                            <option value="Three Quarter">Three Quarter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Fit Type</label>
                                                        <select name="attributes[clothing][fit]" class="form-control form-control-sm">
                                                            <option value="">Select Fit</option>
                                                            <option value="Regular">Regular</option>
                                                            <option value="Slim">Slim</option>
                                                            <option value="Oversized">Oversized</option>
                                                            <option value="Relaxed">Relaxed</option>
                                                            <option value="Athletic">Athletic</option>
                                                            <option value="Compression">Compression</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Pattern</label>
                                                        <select name="attributes[clothing][pattern]" class="form-control form-control-sm">
                                                            <option value="">Select Pattern</option>
                                                            <option value="Solid">Solid</option>
                                                            <option value="Striped">Striped</option>
                                                            <option value="Checked">Checked</option>
                                                            <option value="Printed">Printed</option>
                                                            <option value="Camouflage">Camouflage</option>
                                                            <option value="Floral">Floral</option>
                                                            <option value="Polka Dot">Polka Dot</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Neck Type</label>
                                                        <select name="attributes[clothing][neck]" class="form-control form-control-sm">
                                                            <option value="">Select Neck</option>
                                                            <option value="Round Neck">Round Neck</option>
                                                            <option value="V-Neck">V-Neck</option>
                                                            <option value="Collar">Collar</option>
                                                            <option value="Turtleneck">Turtleneck</option>
                                                            <option value="Scoop">Scoop</option>
                                                            <option value="Sweetheart">Sweetheart</option>
                                                            <option value="Halter">Halter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Gender</label>
                                                        <select name="attributes[clothing][gender]" class="form-control form-control-sm">
                                                            <option value="Men">Men</option>
                                                            <option value="Women">Women</option>
                                                            <option value="Unisex">Unisex</option>
                                                            <option value="Kids">Kids</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Fabric Weight</label>
                                                        <select name="attributes[clothing][fabric_weight]" class="form-control form-control-sm">
                                                            <option value="">Select Fabric Weight</option>
                                                            <option value="Light">Light</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="Heavy">Heavy</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Care Instructions</label>
                                                        <select name="attributes[clothing][care_instructions]" class="form-control form-control-sm">
                                                            <option value="">Select Care</option>
                                                            <option value="Machine Wash">Machine Wash</option>
                                                            <option value="Hand Wash">Hand Wash</option>
                                                            <option value="Dry Clean">Dry Clean</option>
                                                            <option value="Gentle Cycle">Gentle Cycle</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- VARIANT SECTION -->
                                                <hr>
                                                <div class="variant-section">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0"><i class="fas fa-layer-group me-2"></i> Size Variants (S, M, L, XL)</h6>
                                                        <button type="button" id="add_variant" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-plus"></i> Add Size
                                                        </button>
                                                    </div>
                                                    <div id="variants_container"></div>
                                                    <small class="text-muted">Add different sizes with their own stock quantities</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FOOTWEAR ATTRIBUTES -->
                                        <div id="footwear_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-shoe-prints me-2"></i> Footwear Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Shoe Size <span class="required-star">*</span></label>
                                                        <select name="attributes[footwear][shoe_size]" class="form-control form-control-sm">
                                                            <option value="">Select Size</option>
                                                            <option value="UK 3">UK 3</option>
                                                            <option value="UK 4">UK 4</option>
                                                            <option value="UK 5">UK 5</option>
                                                            <option value="UK 6">UK 6</option>
                                                            <option value="UK 7">UK 7</option>
                                                            <option value="UK 8">UK 8</option>
                                                            <option value="UK 9">UK 9</option>
                                                            <option value="UK 10">UK 10</option>
                                                            <option value="UK 11">UK 11</option>
                                                            <option value="UK 12">UK 12</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color <span class="required-star">*</span></label>
                                                        <input type="text" name="attributes[footwear][color]" class="form-control form-control-sm" placeholder="e.g. Black, White">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Material</label>
                                                        <select name="attributes[footwear][material]" class="form-control form-control-sm">
                                                            <option value="">Select Material</option>
                                                            <option value="Leather">Leather</option>
                                                            <option value="Synthetic">Synthetic</option>
                                                            <option value="Mesh">Mesh</option>
                                                            <option value="Canvas">Canvas</option>
                                                            <option value="Knit">Knit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Sole Type</label>
                                                        <select name="attributes[footwear][sole_type]" class="form-control form-control-sm">
                                                            <option value="">Select Sole</option>
                                                            <option value="Rubber">Rubber</option>
                                                            <option value="EVA">EVA</option>
                                                            <option value="PU">PU</option>
                                                            <option value="TPR">TPR</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Cushioning Level</label>
                                                        <select name="attributes[footwear][cushioning]" class="form-control form-control-sm">
                                                            <option value="">Select Cushioning</option>
                                                            <option value="Low">Low</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="High">High</option>
                                                            <option value="Max">Max</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Arch Support</label>
                                                        <select name="attributes[footwear][arch_support]" class="form-control form-control-sm">
                                                            <option value="">Select Arch</option>
                                                            <option value="Flat">Flat</option>
                                                            <option value="Normal">Normal</option>
                                                            <option value="High">High</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Closure Type</label>
                                                        <select name="attributes[footwear][closure_type]" class="form-control form-control-sm">
                                                            <option value="">Select Closure</option>
                                                            <option value="Lace-up">Lace-up</option>
                                                            <option value="Velcro">Velcro</option>
                                                            <option value="Slip-on">Slip-on</option>
                                                            <option value="Zipper">Zipper</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Activity Type</label>
                                                        <select name="attributes[footwear][activity_type]" class="form-control form-control-sm">
                                                            <option value="">Select Activity</option>
                                                            <option value="Running">Running</option>
                                                            <option value="Gym">Gym</option>
                                                            <option value="Walking">Walking</option>
                                                            <option value="Casual">Casual</option>
                                                            <option value="Training">Training</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Weight (grams)</label>
                                                        <input type="number" name="attributes[footwear][weight]" class="form-control form-control-sm" placeholder="e.g. 300">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- EQUIPMENT ATTRIBUTES -->
                                        <div id="equipment_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-dumbbell me-2"></i> Equipment Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Equipment Type <span class="required-star">*</span></label>
                                                        <select name="attributes[equipment][equipment_type]" class="form-control form-control-sm">
                                                            <option value="">Select Type</option>
                                                            <option value="Cardio">Cardio</option>
                                                            <option value="Strength">Strength</option>
                                                            <option value="Functional">Functional</option>
                                                            <option value="Weightlifting">Weightlifting</option>
                                                            <option value="Yoga">Yoga</option>
                                                            <option value="Recovery">Recovery</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Weight Capacity (kg)</label>
                                                        <input type="number" name="attributes[equipment][weight_capacity]" class="form-control form-control-sm" min="0" placeholder="Max weight">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Material</label>
                                                        <select name="attributes[equipment][material]" class="form-control form-control-sm">
                                                            <option value="">Select Material</option>
                                                            <option value="Steel">Steel</option>
                                                            <option value="Cast Iron">Cast Iron</option>
                                                            <option value="Rubber">Rubber</option>
                                                            <option value="Plastic">Plastic</option>
                                                            <option value="Wood">Wood</option>
                                                            <option value="Aluminium">Aluminium</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Dimensions (cm)</label>
                                                        <input type="text" name="attributes[equipment][dimensions]" class="form-control form-control-sm" placeholder="50x30x20">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Product Weight (kg)</label>
                                                        <input type="number" step="0.01" name="attributes[equipment][product_weight]" class="form-control form-control-sm" min="0" placeholder="Product weight">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Assembly Required</label>
                                                        <select name="attributes[equipment][assembly]" class="form-control form-control-sm">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="Professional">Professional Required</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Warranty (Months)</label>
                                                        <input type="number" name="attributes[equipment][warranty]" class="form-control form-control-sm" value="12" min="0">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Usage Type</label>
                                                        <select name="attributes[equipment][usage_type]" class="form-control form-control-sm">
                                                            <option value="">Select Usage</option>
                                                            <option value="Home">Home</option>
                                                            <option value="Commercial">Commercial</option>
                                                            <option value="Both">Both</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color</label>
                                                        <input type="text" name="attributes[equipment][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <label class="form-label-sm">Resistance Level</label>
                                                        <select name="attributes[equipment][resistance_level]" class="form-control form-control-sm">
                                                            <option value="">Select Resistance</option>
                                                            <option value="Low">Low</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="High">High</option>
                                                            <option value="Adjustable">Adjustable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MASSAGERS ATTRIBUTES -->
                                        <div id="massager_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-hand-sparkles me-2"></i> Massagers Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Massager Type <span class="required-star">*</span></label>
                                                        <select name="attributes[massager][massager_type]" class="form-control form-control-sm">
                                                            <option value="">Select Type</option>
                                                            <option value="Handheld">Handheld</option>
                                                            <option value="Neck">Neck Massager</option>
                                                            <option value="Foot">Foot Massager</option>
                                                            <option value="Full Body">Full Body</option>
                                                            <option value="Eye">Eye Massager</option>
                                                            <option value="Back">Back Massager</option>
                                                            <option value="Percussion">Percussion Massager</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Power Source</label>
                                                        <select name="attributes[massager][power_source]" class="form-control form-control-sm">
                                                            <option value="">Select Power</option>
                                                            <option value="Battery">Battery</option>
                                                            <option value="Electric">Electric</option>
                                                            <option value="Manual">Manual</option>
                                                            <option value="Rechargeable">Rechargeable</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Battery Life (Hours)</label>
                                                        <input type="number" name="attributes[massager][battery_life]" class="form-control form-control-sm" min="0" placeholder="e.g. 4">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Massage Modes</label>
                                                        <select name="attributes[massager][massage_modes]" class="form-control form-control-sm">
                                                            <option value="">Select Modes</option>
                                                            <option value="Vibration">Vibration</option>
                                                            <option value="Rolling">Rolling</option>
                                                            <option value="Kneading">Kneading</option>
                                                            <option value="Shiatsu">Shiatsu</option>
                                                            <option value="Percussion">Percussion</option>
                                                            <option value="Combination">Combination</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Speed Settings</label>
                                                        <select name="attributes[massager][speed_settings]" class="form-control form-control-sm">
                                                            <option value="">Select Speeds</option>
                                                            <option value="1 Speed">1 Speed</option>
                                                            <option value="3 Speeds">3 Speeds</option>
                                                            <option value="5 Speeds">5 Speeds</option>
                                                            <option value="10 Speeds">10 Speeds</option>
                                                            <option value="Variable">Variable</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Attachments</label>
                                                        <select name="attributes[massager][attachments]" class="form-control form-control-sm">
                                                            <option value="">Select Attachments</option>
                                                            <option value="1 Head">1 Head</option>
                                                            <option value="2 Heads">2 Heads</option>
                                                            <option value="3 Heads">3 Heads</option>
                                                            <option value="4+ Heads">4+ Heads</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Waterproof</label>
                                                        <select name="attributes[massager][waterproof]" class="form-control form-control-sm">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="Splash Proof">Splash Proof</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Heat Function</label>
                                                        <select name="attributes[massager][heat_function]" class="form-control form-control-sm">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color</label>
                                                        <input type="text" name="attributes[massager][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <label class="form-label-sm">Warranty (Months)</label>
                                                        <input type="number" name="attributes[massager][warranty]" class="form-control form-control-sm" value="12" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ACCESSORIES ATTRIBUTES -->
                                        <div id="accessory_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-shopping-bag me-2"></i> Accessories Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Accessory Type <span class="required-star">*</span></label>
                                                        <select name="attributes[accessory][accessory_type]" class="form-control form-control-sm">
                                                            <option value="">Select Type</option>
                                                            <option value="Gym Bag">Gym Bag</option>
                                                            <option value="Water Bottle">Water Bottle</option>
                                                            <option value="Gloves">Gloves</option>
                                                            <option value="Belt">Belt</option>
                                                            <option value="Wrist Wrap">Wrist Wrap</option>
                                                            <option value="Knee Sleeve">Knee Sleeve</option>
                                                            <option value="Headband">Headband</option>
                                                            <option value="Towel">Towel</option>
                                                            <option value="Shaker">Shaker</option>
                                                            <option value="Foam Roller">Foam Roller</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Material</label>
                                                        <select name="attributes[accessory][material]" class="form-control form-control-sm">
                                                            <option value="">Select Material</option>
                                                            <option value="Neoprene">Neoprene</option>
                                                            <option value="Nylon">Nylon</option>
                                                            <option value="Silicone">Silicone</option>
                                                            <option value="Leather">Leather</option>
                                                            <option value="Cotton">Cotton</option>
                                                            <option value="Polyester">Polyester</option>
                                                            <option value="Rubber">Rubber</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color</label>
                                                        <input type="text" name="attributes[accessory][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Size</label>
                                                        <select name="attributes[accessory][size]" class="form-control form-control-sm">
                                                            <option value="">Select Size</option>
                                                            <option value="One Size">One Size</option>
                                                            <option value="S/M">S/M</option>
                                                            <option value="L/XL">L/XL</option>
                                                            <option value="Adjustable">Adjustable</option>
                                                            <option value="500ml">500ml</option>
                                                            <option value="750ml">750ml</option>
                                                            <option value="1L">1L</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Weight (grams)</label>
                                                        <input type="number" name="attributes[accessory][weight]" class="form-control form-control-sm" min="0" placeholder="e.g. 200">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Gender</label>
                                                        <select name="attributes[accessory][gender]" class="form-control form-control-sm">
                                                            <option value="Men">Men</option>
                                                            <option value="Women">Women</option>
                                                            <option value="Unisex">Unisex</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Features</label>
                                                        <select name="attributes[accessory][features]" class="form-control form-control-sm">
                                                            <option value="">Select Features</option>
                                                            <option value="Waterproof">Waterproof</option>
                                                            <option value="Adjustable">Adjustable</option>
                                                            <option value="Reflective">Reflective</option>
                                                            <option value="Breathable">Breathable</option>
                                                            <option value="Anti-slip">Anti-slip</option>
                                                            <option value="Insulated">Insulated</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Warranty (Months)</label>
                                                        <input type="number" name="attributes[accessory][warranty]" class="form-control form-control-sm" value="6" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SUPPLEMENTS ATTRIBUTES -->
                                        <div id="supplements_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-flask me-2"></i> Supplements Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Supplement Type <span class="required-star">*</span></label>
                                                        <select name="attributes[supplements][supplement_type]" class="form-control form-control-sm">
                                                            <option value="">Select Type</option>
                                                            <option value="Whey Protein">Whey Protein</option>
                                                            <option value="Mass Gainer">Mass Gainer</option>
                                                            <option value="BCAA">BCAA</option>
                                                            <option value="Pre-Workout">Pre-Workout</option>
                                                            <option value="Creatine">Creatine</option>
                                                            <option value="Glutamine">Glutamine</option>
                                                            <option value="Casein">Casein</option>
                                                            <option value="Plant Protein">Plant Protein</option>
                                                            <option value="Vitamins">Vitamins</option>
                                                            <option value="Fat Burner">Fat Burner</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Weight/Size <span class="required-star">*</span></label>
                                                        <select name="attributes[supplements][weight]" class="form-control form-control-sm">
                                                            <option value="">Select Weight</option>
                                                            <option value="250g">250g</option>
                                                            <option value="500g">500g</option>
                                                            <option value="750g">750g</option>
                                                            <option value="1kg">1kg</option>
                                                            <option value="2kg">2kg</option>
                                                            <option value="3kg">3kg</option>
                                                            <option value="5kg">5kg</option>
                                                            <option value="10kg">10kg</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Flavor</label>
                                                        <input type="text" name="attributes[supplements][flavor]" class="form-control form-control-sm" placeholder="e.g. Vanilla, Chocolate">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Serving Size</label>
                                                        <input type="text" name="attributes[supplements][serving_size]" class="form-control form-control-sm" placeholder="1 scoop (30g)">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Servings Count</label>
                                                        <input type="number" name="attributes[supplements][servings_count]" class="form-control form-control-sm" value="0" min="0">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Protein Per Serving (g)</label>
                                                        <input type="number" name="attributes[supplements][protein_per_serving]" class="form-control form-control-sm" min="0" placeholder="24">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Calories Per Serving</label>
                                                        <input type="number" name="attributes[supplements][calories_per_serving]" class="form-control form-control-sm" min="0" placeholder="120">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Carbs Per Serving (g)</label>
                                                        <input type="number" name="attributes[supplements][carbs_per_serving]" class="form-control form-control-sm" min="0" placeholder="5">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Fat Per Serving (g)</label>
                                                        <input type="number" name="attributes[supplements][fat_per_serving]" class="form-control form-control-sm" min="0" placeholder="2">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Dietary</label>
                                                        <select name="attributes[supplements][dietary]" class="form-control form-control-sm">
                                                            <option value="">Select Dietary</option>
                                                            <option value="Vegetarian">Vegetarian</option>
                                                            <option value="Vegan">Vegan</option>
                                                            <option value="Gluten-Free">Gluten-Free</option>
                                                            <option value="Keto">Keto</option>
                                                            <option value="Organic">Organic</option>
                                                            <option value="Non-GMO">Non-GMO</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Expiry Date</label>
                                                        <input type="date" name="attributes[supplements][expiry]" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Usage Instructions</label>
                                                        <input type="text" name="attributes[supplements][usage_instructions]" class="form-control form-control-sm" placeholder="Mix with water or milk">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Ingredients</label>
                                                        <textarea name="attributes[supplements][ingredients]" class="form-control form-control-sm" rows="2" placeholder="List of ingredients"></textarea>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Caution / Allergy</label>
                                                        <textarea name="attributes[supplements][caution]" class="form-control form-control-sm" rows="2" placeholder="Allergy warnings"></textarea>
                                                    </div>
                                                </div>
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
                                            <label>Description Title</label>
                                            <input type="text" name="description_title" class="form-control" placeholder="Product Features">
                                        </div>
                                        <div class="mb-3">
                                            <label>Description Details</label>
                                            <textarea name="description_details" class="form-control" rows="4" placeholder="Detailed description"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Full Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Full description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="col-md-4">
                                <!-- Inventory -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Inventory</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Stock Quantity <span class="required-star">*</span></label>
                                            <input type="number" name="stock" id="stock" class="form-control" value="0" min="0" required oninput="calculateAll()">
                                        </div>
                                        <div class="mb-3">
                                            <label>Min Stock Alert</label>
                                            <input type="number" name="min_stock_alert" class="form-control" value="5" min="0">
                                        </div>
                                        <div class="mb-3">
                                            <label>Weight</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="weight" class="form-control" min="0" placeholder="0.5">
                                                <select name="weight_unit" class="form-control" style="width: 80px;">
                                                    <option value="kg">kg</option>
                                                    <option value="g">g</option>
                                                    <option value="lb">lb</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Dimensions</label>
                                            <input type="text" name="dimensions" class="form-control" placeholder="L × W × H cm">
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
                                        <div class="mb-3">
                                            <label>Video URL</label>
                                            <input type="url" name="video_url" class="form-control" placeholder="YouTube or Vimeo link">
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Shipping Info</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Shipping Information</label>
                                            <textarea name="shipping_info" class="form-control" rows="3" placeholder="Shipping details"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Return & Warranty -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Return & Warranty</div>
                                    <div class="card-body">
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

        // ========== AUTO GST FETCH FROM TOP CATEGORY ==========
        $('#top_category').on('change', function() {
            var topCategoryId = $(this).val();
            
            if (topCategoryId) {
                // Show loading state
                $('#gst_badge').show().html('<i class="fas fa-spinner fa-spin"></i> Loading GST...');
                
                // Get the GST from data attribute directly first (fallback)
                var selectedOption = $(this).find('option:selected');
                var dataGst = selectedOption.data('gst') || 0;
                
                $.ajax({
                    url: '/admin/get-gst-rate/' + topCategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('GST Response:', response);
                        if (response.success) {
                            var gstRate = response.gst_rate || 0;
                            
                            // ✅ Update GST dropdown with the rate from top category
                            $('#gst_percentage').val(gstRate);
                            
                            // Update GST badge
                            $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + gstRate + '% (Auto)').show();
                            
                            // Update label with selected category name
                            var selectedText = selectedOption.text().trim();
                            $('#gst_auto_label').text('(Auto from: ' + selectedText + ')');
                            
                            // Recalculate all
                            calculateAll();
                        } else {
                            // Fallback: use data attribute from option
                            if (dataGst > 0) {
                                $('#gst_percentage').val(dataGst);
                                $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '% (Auto)').show();
                                var selectedText = selectedOption.text().trim();
                                $('#gst_auto_label').text('(Auto from: ' + selectedText + ')');
                                calculateAll();
                            } else {
                                $('#gst_badge').html('<i class="fas fa-exclamation-circle"></i> ' + (response.message || 'No GST set')).show();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);
                        
                        // Fallback: use data attribute from option
                        if (dataGst > 0) {
                            $('#gst_percentage').val(dataGst);
                            $('#gst_badge').html('<i class="fas fa-check-circle"></i> GST: ' + dataGst + '% (Auto from data)').show();
                            var selectedText = selectedOption.text().trim();
                            $('#gst_auto_label').text('(Auto from: ' + selectedText + ')');
                            calculateAll();
                        } else {
                            $('#gst_badge').html('<i class="fas fa-exclamation-triangle"></i> Error loading GST').show();
                        }
                    }
                });
            } else {
                $('#gst_badge').hide();
                $('#gst_auto_label').text('(Auto from category)');
                $('#gst_percentage').val(18);
                calculateAll();
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
                            <input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm variant-stock" value="0" min="0" required oninput="calculateAll()">
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
            calculateAll();
        }

        // Add variant on button click
        $('#add_variant').on('click', function() {
            addVariant();
        });

        // Remove variant
        $(document).on('click', '.remove-variant', function() {
            var totalVariants = $('.variant-item').length;
            if (totalVariants <= 1) {
                alert('At least one variant is required!');
                return;
            }
            if (confirm('Remove this variant?')) {
                var variantId = $(this).data('variant');
                $('#variant-' + variantId).remove();
                calculateAll();
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
                
                // If clothing is opened, add first variant if not already added
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

        // Initial calculate
        calculateAll();
        
        // Trigger change on page load to set initial GST if top category is pre-selected
        if ($('#top_category').val()) {
            $('#top_category').trigger('change');
        }
    });

    // ========== MAIN CALCULATION FUNCTION ==========
    function calculateAll() {
        var price = parseFloat(document.getElementById('price').value) || 0;
        var mrp = parseFloat(document.getElementById('mrp').value) || 0;
        var gstPercent = parseFloat(document.getElementById('gst_percentage').value) || 0;
        var discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
        var discountType = document.querySelector('input[name="discount_type"]:checked').value;

        // Calculate GST
        var gstAmount = (price * gstPercent) / 100;
        var totalPrice = price + gstAmount;
        var profit = mrp - price;

        // Calculate Discount
        var discountApplied = 0;
        var finalPrice = price;
        
        if (discountType === 'flat') {
            discountApplied = discountValue;
            finalPrice = price - discountValue;
        } else if (discountType === 'percentage') {
            discountApplied = (price * discountValue) / 100;
            finalPrice = price - discountApplied;
        }
        if (finalPrice < 0) {
            finalPrice = 0;
            discountApplied = price;
        }

        // Calculate You Save (MRP - Final Price)
        var youSave = mrp - finalPrice;
        if (youSave < 0) youSave = 0;

        // Calculate total variant stock
        var totalVariantStock = 0;
        $('.variant-stock').each(function() {
            var val = parseInt($(this).val()) || 0;
            totalVariantStock += val;
        });
        var totalStock = totalVariantStock + (parseInt(document.getElementById('stock').value) || 0);

        // Update calculation box
        document.getElementById('calc_price').textContent = '₹' + price.toFixed(2);
        document.getElementById('calc_gst_percent').textContent = gstPercent;
        document.getElementById('calc_gst_amount').textContent = '₹' + gstAmount.toFixed(2);
        document.getElementById('calc_total_price').textContent = '₹' + totalPrice.toFixed(2);
        document.getElementById('calc_mrp').textContent = '₹' + mrp.toFixed(2);
        
        var profitElement = document.getElementById('calc_profit');
        profitElement.textContent = '₹' + profit.toFixed(2);
        profitElement.className = 'calc-value ' + (profit >= 0 ? 'profit' : 'loss');
        
        document.getElementById('calc_discount').textContent = '₹' + discountApplied.toFixed(2);
        document.getElementById('calc_final_price').textContent = '₹' + finalPrice.toFixed(2);
        document.getElementById('calc_total_stock').textContent = totalStock;
        document.getElementById('calc_you_save').textContent = '₹' + youSave.toFixed(2);

        // Update discount hint
        var hint = document.getElementById('discount_value_hint');
        if (discountType === 'flat') {
            hint.textContent = 'Enter discount amount in ₹';
            hint.style.color = '#6c757d';
        } else {
            hint.textContent = 'Enter discount percentage (%)';
            hint.style.color = '#6c757d';
        }
    }
</script>
@endsection