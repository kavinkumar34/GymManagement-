{{-- resources/views/product-detail.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    .product-detail-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin: 20px 0;
    }
    
    /* ========== LEFT COLUMN - VERTICAL THUMBNAILS + MAIN IMAGE ========== */
    .product-gallery-wrapper {
        display: flex;
        gap: 15px;
    }
    
    /* Vertical Thumbnails */
    .vertical-thumbnails {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 85px;
        flex-shrink: 0;
    }
    
    .vertical-thumb {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .vertical-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .vertical-thumb.active {
        border-color: #dc3545;
        box-shadow: 0 0 8px rgba(220,53,69,0.3);
    }
    
    .vertical-thumb:hover {
        transform: scale(1.05);
        border-color: #dc3545;
    }
    
    /* Main Image Area */
    .main-image-area {
        flex: 1;
        background: #f8f9fa;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: zoom-in;
    }
    
    .main-image {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    
    .nav-arrows {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 10px;
        pointer-events: none;
    }
    
    .nav-arrow {
        width: 36px;
        height: 36px;
        background: rgba(0,0,0,0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        cursor: pointer;
        pointer-events: auto;
        transition: all 0.3s;
    }
    
    .nav-arrow:hover {
        background: #dc3545;
    }
    
    /* ========== RIGHT COLUMN - SCROLLABLE CONTENT ========== */
    .right-side-content {
        max-height: 650px;
        overflow-y: auto;
        padding-right: 15px;
    }
    
    .right-side-content::-webkit-scrollbar {
        width: 5px;
    }
    
    .right-side-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    
    .right-side-content::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 5px;
    }
    
    /* Brand */
    .brand-name {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .product-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .product-subtitle {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .product-category {
        color: #999;
        font-size: 12px;
        margin-bottom: 10px;
    }
    
    /* Rating */
    .rating {
        margin-bottom: 15px;
    }
    
    .stars {
        color: #ffc107;
    }
    
    .rating-text {
        color: #666;
        font-size: 12px;
        margin-left: 8px;
    }
    
    /* Price */
    .price-section {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .current-price {
        font-size: 28px;
        font-weight: bold;
        color: #dc3545;
    }
    
    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 18px;
        margin-left: 10px;
    }
    
    .discount-badge {
        background: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 5px;
        font-size: 12px;
        margin-left: 10px;
    }
    
    .tax-text {
        color: #666;
        font-size: 12px;
        margin-top: 5px;
    }
    
    /* Size Selection */
    .size-section {
        margin-bottom: 20px;
    }
    
    .size-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .size-label {
        font-weight: 600;
        font-size: 14px;
    }
    
    .size-guide {
        font-size: 12px;
        color: #0d6efd;
        text-decoration: none;
        cursor: pointer;
    }
    
    .size-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .size-btn {
        min-width: 75px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        font-size: 13px;
    }
    
    .size-btn:hover, .size-btn.selected {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    .size-warning {
        color: red;
        font-size: 12px;
        display: none;
        margin-top: 8px;
    }
    
    /* Quantity */
    .quantity-section {
        margin-bottom: 20px;
    }
    
    .quantity-label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 10px;
        display: block;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .quantity-btn {
        width: 35px;
        height: 35px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
    }
    
    .quantity-input {
        width: 60px;
        text-align: center;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    
    /* Stock */
    .stock-status {
        margin-bottom: 20px;
    }
    
    .in-stock {
        color: #28a745;
        font-size: 14px;
    }
    
    .out-of-stock {
        color: #dc3545;
        font-size: 14px;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .btn-wishlist {
        background: white;
        border: 1px solid #dc3545;
        border-radius: 25px;
        padding: 10px 20px;
        color: #dc3545;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }
    
    .btn-wishlist:hover {
        background: #dc3545;
        color: white;
    }
    
    .btn-add-cart {
        background: #000000;
        border: none;
        border-radius: 25px;
        padding: 10px 25px;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        flex: 1;
        font-size: 14px;
    }
    
    .btn-add-cart:hover {
        background: #dc3545;
    }
    
    .btn-buy-now {
        background: #dc3545;
        border: none;
        border-radius: 25px;
        padding: 10px 25px;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        flex: 1;
        font-size: 14px;
    }
    
    .btn-buy-now:hover {
        background: #000000;
    }
    
    /* Delivery Info */
    .delivery-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .delivery-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    
    .delivery-item i {
        width: 25px;
        color: #dc3545;
    }
    
    .delivery-text {
        font-size: 13px;
    }
    
    .delivery-text strong {
        display: block;
        margin-bottom: 2px;
    }
    
    .delivery-text small {
        color: #666;
    }
    
    .pincode-input {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    
    .pincode-input input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 13px;
    }
    
    .pincode-input button {
        padding: 10px 20px;
        background: #000;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
    }
    
    /* Tabs / Accordion */
    .product-info-tabs {
        margin-top: 20px;
    }
    
    .info-tab {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        margin-bottom: 12px;
        overflow: hidden;
    }
    
    .info-tab-header {
        background: white;
        padding: 12px 15px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        font-weight: 600;
        font-size: 13px;
    }
    
    .info-tab-header i {
        margin-right: 10px;
        color: #dc3545;
    }
    
    .info-tab-header.active {
        background: #dc3545;
        color: white;
    }
    
    .info-tab-header.active i {
        color: white;
    }
    
    .info-tab-content {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: #f8f9fa;
    }
    
    .info-tab-content.show {
        padding: 15px;
        max-height: 250px;
        overflow-y: auto;
    }
    
    .info-tab-content::-webkit-scrollbar {
        width: 5px;
    }
    
    .info-tab-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    
    .info-tab-content::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 5px;
    }
    
    .info-tab-header .arrow {
        transition: transform 0.3s;
    }
    
    .info-tab-header.active .arrow {
        transform: rotate(180deg);
    }
    
    .specs-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .specs-list li {
        padding: 6px 0;
        border-bottom: 1px solid #eee;
    }
    
    .specs-list li strong {
        width: 110px;
        display: inline-block;
    }
    
    /* Related Products */
    .related-card {
        transition: transform 0.3s;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        height: 100%;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    /* Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        cursor: pointer;
    }
    
    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-image {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    
    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .product-gallery-wrapper {
            flex-direction: column-reverse;
        }
        .vertical-thumbnails {
            flex-direction: row;
            width: 100%;
            justify-content: center;
        }
        .main-image-area {
            min-height: 350px;
        }
    }
</style>

<div class="container mt-4">
    <div class="product-detail-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Products' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- ========== LEFT COLUMN - VERTICAL THUMBNAILS + MAIN IMAGE ========== -->
            <div class="col-md-6">
                <div class="product-gallery-wrapper">
                    <!-- Vertical Thumbnails -->
                    <div class="vertical-thumbnails" id="verticalThumbnails">
                        @php
                            // Get all images from product_images table
                            $allImages = \App\Models\ProductImage::where('product_id', $product->id)
                                ->orderBy('display_order')
                                ->get();
                            
                            if($allImages->count() == 0 && $product->image) {
                                $allImages = collect([(object)['image_path' => $product->image, 'is_main' => 1]]);
                            }
                            
                            if($allImages->count() == 0) {
                                $allImages = collect([(object)['image_path' => 'https://via.placeholder.com/500x500?text=No+Image', 'is_main' => 1]]);
                            }
                        @endphp
                        
                        @foreach($allImages as $index => $img)
                        <div class="vertical-thumb {{ $index == 0 ? 'active' : '' }}" data-index="{{ $index }}" onclick="changeMainImage({{ $index }})">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Thumbnail {{ $index+1 }}">
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Main Image Area -->
                    <div class="main-image-area" id="mainImageArea" onclick="openModal(getCurrentImageSrc())">
                        <img id="mainImage" class="main-image" src="{{ asset('storage/' . ($allImages[0]->image_path ?? 'https://via.placeholder.com/500x500')) }}" alt="Product Image">
                        @if($allImages->count() > 1)
                        <div class="nav-arrows">
                            <div class="nav-arrow" onclick="event.stopPropagation(); prevImage()">❮</div>
                            <div class="nav-arrow" onclick="event.stopPropagation(); nextImage()">❯</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- ========== RIGHT COLUMN - ALL CONTENT (SCROLLABLE) ========== -->
            <div class="col-md-6">
                <div class="right-side-content">
                    <!-- Brand -->
                    <div class="brand-name">
                        <i class="fas fa-building"></i> {{ $product->brand->name ?? 'BRAVE' }}
                    </div>
                    
                    <!-- Product Title -->
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <p class="product-subtitle">{{ $product->short_description ?? 'Graphic Printed T-Shirt' }}</p>
                    <p class="product-category">
                        <i class="fas fa-tag"></i> {{ $product->category ? $product->category->name : 'Uncategorized' }}
                    </p>
                    
                    <!-- Rating -->
                    <div class="rating">
                        <span class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                        <span class="rating-text">Based on 0 ratings</span>
                    </div>
                    
                    <!-- Price -->
                    <div class="price-section">
                        @if($product->discount_price && $product->discount_price < $product->price)
                            <span class="current-price">₹{{ number_format($product->discount_price, 2) }}</span>
                            <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                            <span class="discount-badge">{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF</span>
                        @else
                            <span class="current-price">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                        <div class="tax-text">Inclusive of all taxes</div>
                    </div>
                    
                    <!-- Size Selection -->
                    <div class="size-section">
                        <div class="size-header">
                            <span class="size-label">Select Size</span>
                            <a href="#" class="size-guide" onclick="showSizeGuide(event)">Size Guide</a>
                        </div>
                        <div class="size-options" id="sizeOptions">
                            @php
                                $sizes = ['4-5 Years', '5-6 Years', '7-8 Years', '8-9 Years', '9-10 Years', '10-11 Years', '11-12 Years', '12-13 Years'];
                            @endphp
                            @foreach($sizes as $size)
                            <button type="button" class="size-btn" data-size="{{ $size }}">{{ $size }}</button>
                            @endforeach
                        </div>
                        <div id="sizeWarning" class="size-warning">Please select a size first</div>
                    </div>
                    
                    <!-- Quantity -->
                    <div class="quantity-section">
                        <label class="quantity-label">Quantity</label>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 10 }}">
                            <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                        </div>
                    </div>
                    
                    <!-- Stock Status -->
                    <div class="stock-status">
                        @if($product->stock > 0)
                            <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} items available)</span>
                        @else
                            <span class="out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="btn-wishlist" onclick="toggleWishlist(this)">
                            <i class="far fa-heart"></i> Wishlist
                        </button>
                        <button class="btn-add-cart" onclick="addToCartWithSize()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn-buy-now" onclick="buyNowWithSize()">
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    </div>
                    
                    <!-- Delivery Info -->
                    <div class="delivery-box">
                        <div class="delivery-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="delivery-text">
                                <strong>Select Delivery Location</strong>
                                <small>Enter pincode to check availability</small>
                            </div>
                        </div>
                        <div class="pincode-input">
                            <input type="text" id="pincode" placeholder="Enter pincode" maxlength="6">
                            <button onclick="checkPincode()">Check</button>
                        </div>
                        <div id="pincodeMessage" class="mt-2 small"></div>
                    </div>
                    
                    <div class="delivery-box">
                        <div class="delivery-item">
                            <i class="fas fa-truck"></i>
                            <div class="delivery-text">
                                <strong>CASH ON DELIVERY</strong>
                                <small>Available</small>
                            </div>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-undo-alt"></i>
                            <div class="delivery-text">
                                <strong>RETURN & EXCHANGE</strong>
                                <small>{{ $product->return_days ?? 7 }}-day return & exchange</small>
                            </div>
                        </div>
                        <div class="delivery-item">
                            <i class="fas fa-clock"></i>
                            <div class="delivery-text">
                                <strong>DELIVERY</strong>
                                <small>Free delivery on orders above ₹999</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Info Tabs -->
                    <div class="product-info-tabs">
                        <!-- PRODUCT DETAILS -->
                        <div class="info-tab">
                            <div class="info-tab-header" onclick="toggleTab(this)">
                                <span><i class="fas fa-info-circle"></i> PRODUCT DETAILS</span>
                                <span class="arrow">▼</span>
                            </div>
                            <div class="info-tab-content">
                                <p>{{ $product->description ?? 'No description available' }}</p>
                                @if($product->short_description)
                                    <div class="alert alert-light mt-2 p-2">
                                        <strong>Highlights:</strong>
                                        <p class="mb-0">{{ $product->short_description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- KNOW YOUR PRODUCT -->
                        <div class="info-tab">
                            <div class="info-tab-header" onclick="toggleTab(this)">
                                <span><i class="fas fa-clipboard-list"></i> KNOW YOUR PRODUCT</span>
                                <span class="arrow">▼</span>
                            </div>
                            <div class="info-tab-content">
                                <ul class="specs-list">
                                    <li><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</li>
                                    <li><strong>GST:</strong> {{ $product->gst_percentage ?? 18 }}%</li>
                                    <li><strong>Weight:</strong> {{ $product->weight ?? 0 }} {{ $product->weight_unit ?? 'kg' }}</li>
                                    @if($product->dimensions)
                                    <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                                    @endif
                                    <li><strong>Material:</strong> High Quality Cotton</li>
                                    <li><strong>Fit:</strong> Regular Fit</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- RETURN & EXCHANGE -->
                        <div class="info-tab">
                            <div class="info-tab-header" onclick="toggleTab(this)">
                                <span><i class="fas fa-undo-alt"></i> RETURN & EXCHANGE</span>
                                <span class="arrow">▼</span>
                            </div>
                            <div class="info-tab-content">
                                <p>You can return this product within {{ $product->return_days ?? 30 }} days of delivery.</p>
                                <p><strong>Exchange Available:</strong> Yes</p>
                                <p>Exchange within {{ $product->return_days ?? 30 }} days of delivery.</p>
                                <p><strong>Warranty:</strong> {{ $product->warranty_months ?? 0 }} months manufacturer warranty</p>
                                <p><strong>Conditions:</strong> Product must be unused and in original packaging.</p>
                                <hr>
                                <h6>How to Return?</h6>
                                <ol>
                                    <li>Go to your orders section</li>
                                    <li>Select the product you want to return</li>
                                    <li>Choose return reason</li>
                                    <li>Schedule a pickup</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">You May Also Like</h3>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 mb-4">
                <div class="card related-card">
                    <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h6>{{ Str::limit($related->name, 35) }}</h6>
                        @if($related->discount_price)
                            <span class="text-danger fw-bold">₹{{ number_format($related->discount_price, 2) }}</span>
                            <span class="text-muted text-decoration-line-through ms-1 small">₹{{ number_format($related->price, 2) }}</span>
                        @else
                            <span class="text-danger fw-bold">₹{{ number_format($related->price, 2) }}</span>
                        @endif
                        <a href="/product/{{ $related->id }}" class="btn btn-outline-primary btn-sm mt-2 d-block">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" onclick="closeModal()">
    <span class="close-modal">&times;</span>
    <img class="modal-image" id="modalImage">
</div>

<!-- Size Guide Modal -->
<div id="sizeGuideModal" class="image-modal" style="display:none;" onclick="closeSizeGuide()">
    <div style="background:white; border-radius:15px; max-width:500px; width:90%; padding:20px;" onclick="event.stopPropagation()">
        <span style="float:right; cursor:pointer; font-size:24px;" onclick="closeSizeGuide()">&times;</span>
        <h4>Size Guide</h4>
        <table style="width:100%; border-collapse:collapse; margin-top:15px;">
            <tr style="background:#f0f0f0;">
                <th style="padding:10px; border:1px solid #ddd;">Size</th>
                <th style="padding:10px; border:1px solid #ddd;">Age</th>
                <th style="padding:10px; border:1px solid #ddd;">Height (cm)</th>
            </tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">4-5 Years</td><td style="padding:8px; border:1px solid #ddd;">4-5 Years</td><td style="padding:8px; border:1px solid #ddd;">100-110</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">5-6 Years</td><td style="padding:8px; border:1px solid #ddd;">5-6 Years</td><td style="padding:8px; border:1px solid #ddd;">110-116</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">7-8 Years</td><td style="padding:8px; border:1px solid #ddd;">7-8 Years</td><td style="padding:8px; border:1px solid #ddd;">122-128</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">8-9 Years</td><td style="padding:8px; border:1px solid #ddd;">8-9 Years</td><td style="padding:8px; border:1px solid #ddd;">128-134</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">9-10 Years</td><td style="padding:8px; border:1px solid #ddd;">9-10 Years</td><td style="padding:8px; border:1px solid #ddd;">134-140</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">10-11 Years</td><td style="padding:8px; border:1px solid #ddd;">10-11 Years</td><td style="padding:8px; border:1px solid #ddd;">140-146</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">11-12 Years</td><td style="padding:8px; border:1px solid #ddd;">11-12 Years</td><td style="padding:8px; border:1px solid #ddd;">146-152</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">12-13 Years</td><td style="padding:8px; border:1px solid #ddd;">12-13 Years</td><td style="padding:8px; border:1px solid #ddd;">152-158</td></tr>
        </table>
    </div>
</div>

<script>
    // ========== GALLERY VARIABLES ==========
    let currentIndex = 0;
    let totalImages = {{ $allImages->count() }};
    const images = @json($allImages->map(function($img) { return asset('storage/' . $img->image_path); }));
    
    // Change main image
    function changeMainImage(index) {
        currentIndex = index;
        document.getElementById('mainImage').src = images[index];
        
        // Update active thumbnail
        document.querySelectorAll('.vertical-thumb').forEach((thumb, i) => {
            if (i == index) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
    }
    
    function getCurrentImageSrc() {
        return document.getElementById('mainImage').src;
    }
    
    function prevImage() {
        let newIndex = currentIndex - 1;
        if (newIndex < 0) newIndex = totalImages - 1;
        changeMainImage(newIndex);
    }
    
    function nextImage() {
        let newIndex = currentIndex + 1;
        if (newIndex >= totalImages) newIndex = 0;
        changeMainImage(newIndex);
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'Escape') closeModal();
    });
    
    // ========== SIZE GUIDE MODAL ==========
    function showSizeGuide(event) {
        event.preventDefault();
        document.getElementById('sizeGuideModal').style.display = 'flex';
    }
    
    function closeSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'none';
    }
    
    // ========== TAB TOGGLE ==========
    function toggleTab(header) {
        const content = header.nextElementSibling;
        const isActive = header.classList.contains('active');
        
        if (!isActive) {
            document.querySelectorAll('.info-tab-header').forEach(tab => {
                tab.classList.remove('active');
                if(tab.nextElementSibling) tab.nextElementSibling.classList.remove('show');
            });
            header.classList.add('active');
            content.classList.add('show');
        } else {
            header.classList.remove('active');
            content.classList.remove('show');
        }
    }
    
    // ========== WISHLIST ==========
    function toggleWishlist(btn) {
        const icon = btn.querySelector('i');
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            btn.style.background = '#dc3545';
            btn.style.color = 'white';
            showNotification('Added to wishlist!', 'success');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            btn.style.background = 'white';
            btn.style.color = '#dc3545';
            showNotification('Removed from wishlist!', 'info');
        }
    }
    
    // ========== PINCODE CHECK ==========
    function checkPincode() {
        const pincode = document.getElementById('pincode').value;
        const messageDiv = document.getElementById('pincodeMessage');
        
        if (pincode.length !== 6 || isNaN(pincode)) {
            messageDiv.innerHTML = '<span class="text-danger">❌ Please enter valid 6-digit pincode</span>';
            return;
        }
        
        // Example deliverable pincodes
        const deliverable = ['600001', '600002', '600003', '600004', '600005', '110001', '400001'];
        if (deliverable.includes(pincode)) {
            messageDiv.innerHTML = '<span class="text-success">✓ Delivery available to this location!</span>';
        } else {
            messageDiv.innerHTML = '<span class="text-danger">✗ Delivery not available to this location</span>';
        }
    }
    
    // ========== SIZE SELECTION ==========
    let selectedSize = null;
    
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            selectedSize = this.getAttribute('data-size');
            document.getElementById('sizeWarning').style.display = 'none';
        });
    });
    
    // ========== QUANTITY ==========
    function incrementQuantity() {
        let qty = document.getElementById('quantity');
        let max = parseInt(qty.getAttribute('max')) || 99;
        let newVal = parseInt(qty.value) + 1;
        if (newVal <= max) qty.value = newVal;
    }
    
    function decrementQuantity() {
        let qty = document.getElementById('quantity');
        let newVal = parseInt(qty.value) - 1;
        if (newVal >= 1) qty.value = newVal;
    }
    
    // ========== ADD TO CART ==========
    function addToCartWithSize() {
        @if(!auth()->check())
            if(confirm('Please login to add products to cart. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        if (!selectedSize) {
            document.getElementById('sizeWarning').style.display = 'block';
            return;
        }
        
        let quantity = parseInt(document.getElementById('quantity').value);
        let price = {{ $product->discount_price ?? $product->price }};
        let imageUrl = "{{ asset('storage/' . ($allImages[0]->image_path ?? $product->image)) }}";
        
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existing = cart.find(item => item.id === {{ $product->id }} && item.size === selectedSize);
        
        if(existing) {
            existing.quantity += quantity;
        } else {
            cart.push({
                id: {{ $product->id }},
                name: "{{ addslashes($product->name) }}",
                price: price,
                quantity: quantity,
                size: selectedSize,
                image: imageUrl
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        showNotification('Added to cart!', 'success');
        updateCartCount();
    }
    
    // ========== BUY NOW ==========
    function buyNowWithSize() {
        @if(!auth()->check())
            if(confirm('Please login to purchase. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        if (!selectedSize) {
            document.getElementById('sizeWarning').style.display = 'block';
            return;
        }
        
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("buy.now") }}';
        
        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        let product = document.createElement('input');
        product.type = 'hidden';
        product.name = 'product_id';
        product.value = {{ $product->id }};
        form.appendChild(product);
        
        let quantity = document.createElement('input');
        quantity.type = 'hidden';
        quantity.name = 'quantity';
        quantity.value = document.getElementById('quantity').value;
        form.appendChild(quantity);
        
        let size = document.createElement('input');
        size.type = 'hidden';
        size.name = 'size';
        size.value = selectedSize;
        form.appendChild(size);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // ========== NOTIFICATION ==========
    function showNotification(message, type) {
        let notification = document.createElement('div');
        notification.className = 'alert alert-' + (type === 'success' ? 'success' : 'info') + ' alert-dismissible fade show';
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '250px';
        notification.innerHTML = '<i class="fas fa-check-circle me-2"></i> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 2000);
    }
    
    // ========== UPDATE CART ==========
    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let count = cart.reduce((s, i) => s + i.quantity, 0);
        let el = document.getElementById('navbarCartCount');
        if (el) el.textContent = count;
    }
    
    // ========== IMAGE MODAL ==========
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.classList.add('show');
        modalImg.src = src;
    }
    
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('show');
    }
    
    // ========== DOM CONTENT LOADED ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Open first tab by default
        const firstTab = document.querySelector('.info-tab-header');
        if (firstTab) {
            firstTab.classList.add('active');
            if(firstTab.nextElementSibling) firstTab.nextElementSibling.classList.add('show');
        }
        
        // Update cart count on load
        updateCartCount();
        
        // Add click event for image zoom
        const mainImageArea = document.getElementById('mainImageArea');
        if(mainImageArea) {
            mainImageArea.addEventListener('click', function(e) {
                if(!e.target.classList.contains('nav-arrow')) {
                    openModal(getCurrentImageSrc());
                }
            });
        }
    });
</script>
@endsection