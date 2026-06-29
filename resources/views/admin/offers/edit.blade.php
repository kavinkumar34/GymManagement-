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
    .required-star {
        color: red;
    }
    .offer-type-card {
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 10px;
    }
    .offer-type-card:hover {
        border-color: #0d6efd;
        transform: translateY(-3px);
    }
    .offer-type-card.active {
        border-color: #0d6efd;
        background: #f0f7ff;
    }
    .offer-type-card i {
        font-size: 30px;
        color: #0d6efd;
        margin-bottom: 8px;
    }
    .offer-type-card h6 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .offer-type-card small {
        font-size: 11px;
        color: #6c757d;
    }
    .product-selector {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
    }
    .product-selector .product-item {
        padding: 8px 12px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .product-selector .product-item:hover {
        background: #f8f9fa;
    }
    .product-selector .product-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }
    .category-tag, .brand-tag {
        display: inline-block;
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        margin: 3px;
        cursor: pointer;
    }
    .category-tag:hover, .brand-tag:hover {
        background: #dee2e6;
    }
    .category-tag.selected, .brand-tag.selected {
        background: #0d6efd;
        color: white;
    }
    .selection-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px 15px;
        margin-top: 10px;
        border-left: 4px solid #0d6efd;
    }
    .selection-info .badge-count {
        display: inline-block;
        background: #0d6efd;
        color: white;
        border-radius: 50%;
        padding: 2px 10px;
        font-size: 12px;
        margin-left: 5px;
    }
    .selection-section {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .selection-section.active-section {
        border-color: #28a745;
        background: #f0fff4;
    }
    .selection-section .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .selection-section .section-header h6 {
        margin-bottom: 0;
    }
    .selection-section .section-header .badge-status {
        font-size: 11px;
        padding: 3px 12px;
        border-radius: 20px;
    }
    .badge-status.selected {
        background: #28a745;
        color: white;
    }
    .badge-status.not-selected {
        background: #e9ecef;
        color: #6c757d;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }
    .status-badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .status-badge.scheduled {
        background: #fff3cd;
        color: #856404;
    }
    .status-badge.expired {
        background: #e2e3e5;
        color: #383d41;
    }
</style>

<div class="container">
    <div class="row" style="margin-left:200px;">
        <div class="col-12">
            <div class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-edit me-2 text-primary"></i> Edit Offer: {{ $offer->offer_name }}
                    <span class="status-badge {{ $offer->status }} ms-3">{{ ucfirst($offer->status) }}</span>
                </div>
                <div class="form-section-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.offers.update', $offer->id) }}" enctype="multipart/form-data" id="offerForm">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-info-circle me-2"></i> Basic Information
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Offer Name <span class="required-star">*</span></label>
                                        <input type="text" name="offer_name" class="form-control" required 
                                               value="{{ old('offer_name', $offer->offer_name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Offer Code <span class="required-star">*</span></label>
                                        <input type="text" name="offer_code" class="form-control" required 
                                               value="{{ old('offer_code', $offer->offer_code) }}">
                                        <small class="text-muted">Unique code for this offer</small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Offer Description</label>
                                    <textarea name="offer_description" class="form-control" rows="2" 
                                              placeholder="Describe this offer">{{ old('offer_description', $offer->offer_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Offer Type Selection -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-tag me-2"></i> Offer Type <span class="required-star">*</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $offerTypes = [
                                            'product' => ['icon' => 'fa-box', 'label' => 'Product Offer', 'desc' => 'Specific product discount'],
                                            'category' => ['icon' => 'fa-th-list', 'label' => 'Category Offer', 'desc' => 'Category-wide discount'],
                                            'brand' => ['icon' => 'fa-building', 'label' => 'Brand Offer', 'desc' => 'Brand-wide discount'],
                                            'cart' => ['icon' => 'fa-shopping-cart', 'label' => 'Cart Offer', 'desc' => 'Cart minimum discount'],
                                            'bogo' => ['icon' => 'fa-gift', 'label' => 'BOGO Offer', 'desc' => 'Buy X Get Y Free'],
                                            'bundle' => ['icon' => 'fa-layer-group', 'label' => 'Bundle Offer', 'desc' => 'Product bundle discount'],
                                            'flash_sale' => ['icon' => 'fa-bolt', 'label' => 'Flash Sale', 'desc' => 'Time-limited sale'],
                                            'new_user' => ['icon' => 'fa-user-plus', 'label' => 'New User', 'desc' => 'First-time buyers'],
                                            'festival' => ['icon' => 'fa-calendar-alt', 'label' => 'Festival Offer', 'desc' => 'Special occasion']
                                        ];
                                    @endphp
                                    @foreach($offerTypes as $key => $type)
                                        <div class="col-md-4">
                                            <div class="offer-type-card {{ $key == $offer->offer_type ? 'active' : '' }}" 
                                                 data-type="{{ $key }}" onclick="selectOfferType('{{ $key }}')">
                                                <i class="fas {{ $type['icon'] }}"></i>
                                                <h6>{{ $type['label'] }}</h6>
                                                <small>{{ $type['desc'] }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="offer_type" id="offer_type" value="{{ $offer->offer_type }}">
                            </div>
                        </div>

                        <!-- Discount Configuration -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-percent me-2"></i> Discount Configuration
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Discount Type <span class="required-star">*</span></label>
                                        <select name="discount_type" class="form-control" id="discount_type" onchange="toggleDiscountFields()">
                                            <option value="percentage" {{ $offer->discount_type == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                            <option value="fixed" {{ $offer->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                                            <option value="buy_x_get_y" {{ $offer->discount_type == 'buy_x_get_y' ? 'selected' : '' }}>Buy X Get Y</option>
                                            <option value="free_shipping" {{ $offer->discount_type == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3" id="discount_value_field">
                                        <label>Discount Value <span class="required-star">*</span></label>
                                        <input type="number" step="0.01" name="discount_value" class="form-control" 
                                               id="discount_value" placeholder="Enter discount" min="0"
                                               value="{{ old('discount_value', $offer->discount_value) }}">
                                        <small class="text-muted" id="discount_value_hint">
                                            @if($offer->discount_type == 'percentage')
                                                Enter percentage (e.g. 10 for 10%)
                                            @elseif($offer->discount_type == 'fixed')
                                                Enter fixed amount in ₹
                                            @else
                                                Enter discount value
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-md-4 mb-3" id="max_discount_field">
                                        <label>Max Discount Amount (₹)</label>
                                        <input type="number" step="0.01" name="max_discount_amount" class="form-control" 
                                               placeholder="Maximum discount cap" min="0"
                                               value="{{ old('max_discount_amount', $offer->max_discount_amount) }}">
                                        <small class="text-muted">Leave empty for no limit</small>
                                    </div>
                                </div>

                                <!-- BOGO Fields -->
                                <div id="bogo_fields" style="display: {{ $offer->discount_type == 'buy_x_get_y' ? 'block' : 'none' }};">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Buy Quantity <span class="required-star">*</span></label>
                                            <input type="number" name="buy_quantity" class="form-control" 
                                                   placeholder="e.g. 2" min="1"
                                                   value="{{ old('buy_quantity', $offer->buy_quantity) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Get Quantity <span class="required-star">*</span></label>
                                            <input type="number" name="get_quantity" class="form-control" 
                                                   placeholder="e.g. 1" min="1"
                                                   value="{{ old('get_quantity', $offer->get_quantity) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Get Product (Optional)</label>
                                            <select name="get_product_id" class="form-control">
                                                <option value="">Free Product (Same as bought)</option>
                                                @foreach($products ?? [] as $product)
                                                    <option value="{{ $product->id }}" 
                                                        {{ $offer->get_product_id == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Minimum Order -->
                                <div class="row mt-2">
                                    <div class="col-md-6 mb-3">
                                        <label>Minimum Order Amount (₹)</label>
                                        <input type="number" step="0.01" name="min_order_amount" class="form-control" 
                                               placeholder="e.g. 999" min="0"
                                               value="{{ old('min_order_amount', $offer->min_order_amount) }}">
                                        <small class="text-muted">Minimum cart value to apply this offer</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product/Category/Brand Selection -->
                        <div id="applicable_fields" style="display: {{ in_array($offer->offer_type, ['product', 'category', 'brand', 'bundle']) ? 'block' : 'none' }};">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <i class="fas fa-cubes me-2"></i> Applicable Products / Categories / Brands
                                </div>
                                <div class="card-body">
                                    <!-- Hidden inputs -->
                                    <input type="hidden" name="applicable_products" id="applicable_products_hidden" value="{{ json_encode($offer->applicable_products ?? []) }}">
                                    <input type="hidden" name="applicable_categories" id="applicable_categories_hidden" value="{{ json_encode($offer->applicable_categories ?? []) }}">
                                    <input type="hidden" name="applicable_brands" id="applicable_brands_hidden" value="{{ json_encode($offer->applicable_brands ?? []) }}">

                                    <!-- Products -->
                                    <div class="row mb-3" id="productSection">
                                        <div class="col-12">
                                            <h6><i class="fas fa-box me-2 text-primary"></i> Select Products</h6>
                                            <div class="product-selector">
                                                <input type="text" class="form-control mb-2" placeholder="Search products..." 
                                                       onkeyup="filterProducts(this.value)">
                                                <div id="productList">
                                                    @foreach($products ?? [] as $product)
                                                        <div class="product-item">
                                                            <input type="checkbox" class="product-checkbox" 
                                                                   value="{{ $product->id }}" id="prod_{{ $product->id }}"
                                                                   {{ in_array($product->id, $offer->applicable_products ?? []) ? 'checked' : '' }}
                                                                   onchange="updateProductSelection()">
                                                            <label for="prod_{{ $product->id }}" style="margin:0;cursor:pointer;">
                                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                                     onerror="this.src='https://via.placeholder.com/40'">
                                                                {{ $product->name }}
                                                                <small class="text-muted">(₹{{ number_format($product->price, 2) }})</small>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="selection-info">
                                                <span>Selected: </span>
                                                <span class="badge-count" id="selectedProductCount">{{ count($offer->applicable_products ?? []) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Categories -->
                                    <div class="row mb-3" id="categorySection">
                                        <div class="col-12">
                                            <h6><i class="fas fa-th-list me-2 text-primary"></i> Select Categories</h6>
                                            <div id="categoryList">
                                                @foreach($categories ?? [] as $category)
                                                    <span class="category-tag {{ in_array($category->id, $offer->applicable_categories ?? []) ? 'selected' : '' }}" 
                                                          onclick="toggleCategory(this, {{ $category->id }})">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            <div class="selection-info mt-2">
                                                <span>Selected: </span>
                                                <span class="badge-count" id="selectedCategoryCount">{{ count($offer->applicable_categories ?? []) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Brands -->
                                    <div class="row mb-3" id="brandSection">
                                        <div class="col-12">
                                            <h6><i class="fas fa-building me-2 text-primary"></i> Select Brands</h6>
                                            <div id="brandList">
                                                @foreach($brands ?? [] as $brand)
                                                    <span class="brand-tag {{ in_array($brand->id, $offer->applicable_brands ?? []) ? 'selected' : '' }}" 
                                                          onclick="toggleBrand(this, {{ $brand->id }})">
                                                        @if($brand->logo)
                                                            <img src="{{ asset('storage/' . $brand->logo) }}" style="width:16px;height:16px;object-fit:contain;margin-right:4px;">
                                                        @endif
                                                        {{ $brand->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            <div class="selection-info mt-2">
                                                <span>Selected: </span>
                                                <span class="badge-count" id="selectedBrandCount">{{ count($offer->applicable_brands ?? []) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Excluded -->
                                    <div class="row mt-3">
                                        <div class="col-md-4 mb-2">
                                            <label>Excluded Products</label>
                                            <select name="excluded_products[]" class="form-control" multiple>
                                                @foreach($products ?? [] as $product)
                                                    <option value="{{ $product->id }}" 
                                                        {{ in_array($product->id, $offer->excluded_products ?? []) ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Excluded Categories</label>
                                            <select name="excluded_categories[]" class="form-control" multiple>
                                                @foreach($categories ?? [] as $category)
                                                    <option value="{{ $category->id }}" 
                                                        {{ in_array($category->id, $offer->excluded_categories ?? []) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Excluded Brands</label>
                                            <select name="excluded_brands[]" class="form-control" multiple>
                                                @foreach($brands ?? [] as $brand)
                                                    <option value="{{ $brand->id }}" 
                                                        {{ in_array($brand->id, $offer->excluded_brands ?? []) ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Restrictions -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-users me-2"></i> Customer Restrictions
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Usage Limit Per User</label>
                                        <input type="number" name="usage_limit_per_user" class="form-control" 
                                               value="{{ old('usage_limit_per_user', $offer->usage_limit_per_user ?? 1) }}" min="0">
                                        <small class="text-muted">0 = Unlimited</small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Total Usage Limit</label>
                                        <input type="number" name="usage_limit_total" class="form-control" 
                                               placeholder="Total times" min="0"
                                               value="{{ old('usage_limit_total', $offer->usage_limit_total) }}">
                                        <small class="text-muted">Leave empty for unlimited</small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" name="new_user_only" value="1" class="form-check-input" id="new_user_only"
                                                   {{ $offer->new_user_only ? 'checked' : '' }}>
                                            <label class="form-check-label" for="new_user_only">
                                                <i class="fas fa-user-plus text-success"></i> New Users Only
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="first_order_only" value="1" class="form-check-input" id="first_order_only"
                                                   {{ $offer->first_order_only ? 'checked' : '' }}>
                                            <label class="form-check-label" for="first_order_only">
                                                <i class="fas fa-shopping-bag text-primary"></i> First Order Only
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-calendar-alt me-2"></i> Date & Time
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Start Date <span class="required-star">*</span></label>
                                        <input type="datetime-local" name="start_date" class="form-control" required
                                               value="{{ old('start_date', $offer->start_date ? date('Y-m-d\TH:i', strtotime($offer->start_date)) : '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>End Date <span class="required-star">*</span></label>
                                        <input type="datetime-local" name="end_date" class="form-control" required
                                               value="{{ old('end_date', $offer->end_date ? date('Y-m-d\TH:i', strtotime($offer->end_date)) : '') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Valid Days</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                            <label class="btn btn-outline-secondary btn-sm">
                                                <input type="checkbox" name="valid_days[]" value="{{ $day }}"
                                                       {{ in_array($day, $offer->valid_days ?? []) ? 'checked' : '' }}>
                                                {{ $day }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Leave empty for all days</small>
                                </div>
                            </div>
                        </div>

                        <!-- Display Settings -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-eye me-2"></i> Display Settings
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Banner Image</label>
                                        @if($offer->banner_image)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $offer->banner_image) }}" 
                                                     alt="Banner" style="max-width: 200px; max-height: 100px; border-radius: 8px;">
                                            </div>
                                        @endif
                                        <input type="file" name="banner_image" class="form-control" accept="image/*">
                                        <small class="text-muted">Upload promotional banner (Recommended: 1200x400)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Priority</label>
                                        <input type="number" name="priority" class="form-control" 
                                               value="{{ old('priority', $offer->priority ?? 0) }}" min="0">
                                        <small class="text-muted">Higher priority offers will be shown first</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="show_on_homepage" value="1" class="form-check-input" id="show_on_homepage"
                                                   {{ $offer->show_on_homepage ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_on_homepage">
                                                <i class="fas fa-home text-primary"></i> Show on Homepage
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="auto_apply" value="1" class="form-check-input" id="auto_apply"
                                                   {{ $offer->auto_apply ? 'checked' : '' }}>
                                            <label class="form-check-label" for="auto_apply">
                                                <i class="fas fa-magic text-success"></i> Auto Apply
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_stackable" value="1" class="form-check-input" id="is_stackable"
                                                   {{ $offer->is_stackable ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_stackable">
                                                <i class="fas fa-layer-group text-warning"></i> Stackable with Others
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <i class="fas fa-toggle-on me-2"></i> Status
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="active" {{ $offer->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $offer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="scheduled" {{ $offer->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="expired" {{ $offer->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Usage Count</label>
                                        <input type="text" class="form-control" value="{{ $offer->usage_count }} times used" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Update Offer
                            </button>
                            <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary px-4 ms-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ========== OFFER TYPE SELECTION ==========
    function selectOfferType(type) {
        document.querySelectorAll('.offer-type-card').forEach(card => {
            card.classList.remove('active');
        });
        document.querySelector(`.offer-type-card[data-type="${type}"]`).classList.add('active');
        document.getElementById('offer_type').value = type;

        var applicableFields = document.getElementById('applicable_fields');
        if (type === 'product' || type === 'category' || type === 'brand' || type === 'bundle') {
            applicableFields.style.display = 'block';
            
            if (type === 'product') {
                document.getElementById('productSection').style.display = 'block';
                document.getElementById('categorySection').style.display = 'none';
                document.getElementById('brandSection').style.display = 'none';
            } else if (type === 'category') {
                document.getElementById('productSection').style.display = 'none';
                document.getElementById('categorySection').style.display = 'block';
                document.getElementById('brandSection').style.display = 'none';
            } else if (type === 'brand') {
                document.getElementById('productSection').style.display = 'none';
                document.getElementById('categorySection').style.display = 'none';
                document.getElementById('brandSection').style.display = 'block';
            } else {
                document.getElementById('productSection').style.display = 'block';
                document.getElementById('categorySection').style.display = 'block';
                document.getElementById('brandSection').style.display = 'block';
            }
        } else {
            applicableFields.style.display = 'none';
        }

        document.getElementById('bogo_fields').style.display = type === 'bogo' ? 'block' : 'none';
    }

    // ========== DISCOUNT TYPE CHANGE ==========
    function toggleDiscountFields() {
        var type = document.getElementById('discount_type').value;
        var valueField = document.getElementById('discount_value_field');
        var maxField = document.getElementById('max_discount_field');
        var hint = document.getElementById('discount_value_hint');

        if (type === 'buy_x_get_y') {
            valueField.style.display = 'none';
            maxField.style.display = 'none';
            document.getElementById('bogo_fields').style.display = 'block';
        } else if (type === 'free_shipping') {
            valueField.style.display = 'none';
            maxField.style.display = 'none';
            hint.textContent = 'No value needed - Free Shipping';
            document.getElementById('bogo_fields').style.display = 'none';
        } else {
            valueField.style.display = 'block';
            maxField.style.display = 'block';
            hint.textContent = type === 'percentage' ? 'Enter percentage (e.g. 10 for 10%)' : 'Enter fixed amount in ₹';
            document.getElementById('bogo_fields').style.display = 'none';
        }
    }

    // ========== PRODUCT SELECTION ==========
    var selectedProducts = {!! json_encode($offer->applicable_products ?? []) !!};

    function updateProductSelection() {
        var checkboxes = document.querySelectorAll('.product-checkbox:checked');
        selectedProducts = [];
        checkboxes.forEach(function(cb) {
            selectedProducts.push(parseInt(cb.value));
        });
        
        var jsonValue = JSON.stringify(selectedProducts);
        document.getElementById('applicable_products_hidden').value = jsonValue;
        document.getElementById('selectedProductCount').textContent = selectedProducts.length;
    }

    // ========== CATEGORY SELECTION ==========
    var selectedCategories = {!! json_encode($offer->applicable_categories ?? []) !!};

    function toggleCategory(element, id) {
        element.classList.toggle('selected');
        var index = selectedCategories.indexOf(id);
        if (index > -1) {
            selectedCategories.splice(index, 1);
        } else {
            selectedCategories.push(id);
        }
        var jsonValue = JSON.stringify(selectedCategories);
        document.getElementById('applicable_categories_hidden').value = jsonValue;
        document.getElementById('selectedCategoryCount').textContent = selectedCategories.length;
    }

    // ========== BRAND SELECTION ==========
    var selectedBrands = {!! json_encode($offer->applicable_brands ?? []) !!};

    function toggleBrand(element, id) {
        element.classList.toggle('selected');
        var index = selectedBrands.indexOf(id);
        if (index > -1) {
            selectedBrands.splice(index, 1);
        } else {
            selectedBrands.push(id);
        }
        var jsonValue = JSON.stringify(selectedBrands);
        document.getElementById('applicable_brands_hidden').value = jsonValue;
        document.getElementById('selectedBrandCount').textContent = selectedBrands.length;
    }

    // ========== PRODUCT SEARCH ==========
    function filterProducts(searchTerm) {
        var items = document.querySelectorAll('#productList .product-item');
        items.forEach(function(item) {
            var text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm.toLowerCase()) ? 'flex' : 'none';
        });
    }

    // ========== INITIALIZATION ==========
    document.addEventListener('DOMContentLoaded', function() {
        toggleDiscountFields();
        selectOfferType(document.getElementById('offer_type').value);
        
        // Update counts
        document.getElementById('selectedProductCount').textContent = selectedProducts.length;
        document.getElementById('selectedCategoryCount').textContent = selectedCategories.length;
        document.getElementById('selectedBrandCount').textContent = selectedBrands.length;
    });
</script>
@endsection