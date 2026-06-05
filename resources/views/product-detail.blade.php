{{-- resources/views/product-detail.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* Delivery Pincode Section Styles */
    .delivery-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #eee;
    }
    
    .delivery-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    
    .delivery-header i {
        font-size: 18px;
        color: #dc3545;
    }
    
    .delivery-header strong {
        font-size: 14px;
        color: #333;
    }
    
    .delivery-header small {
        color: #666;
        font-size: 12px;
        margin-left: 5px;
    }
    
    .pincode-wrapper {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .pincode-wrapper input {
        flex: 1;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .pincode-wrapper input:focus {
        outline: none;
        border-color: #dc3545;
        box-shadow: 0 0 0 2px rgba(220,53,69,0.1);
    }
    
    .pincode-wrapper input.valid {
        border-color: #28a745;
        background-color: #e8f5e9;
    }
    
    .pincode-wrapper input.invalid {
        border-color: #dc3545;
        background-color: #ffebee;
    }
    
    .pincode-wrapper button {
        padding: 12px 24px;
        background: #000;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .pincode-wrapper button:hover {
        background: #dc3545;
    }
    
    .delivery-message {
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }
    
    .delivery-message.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .delivery-message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .delivery-message.info {
        background: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }
    
    .delivery-message i {
        font-size: 14px;
    }
    
    /* Rest of your existing styles */
    .product-detail-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin: 20px 0;
    }
    
    .product-gallery-wrapper {
        display: flex;
        gap: 15px;
    }
    
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
    
    .btn-wishlist:hover:not(:disabled) {
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
    
    .btn-add-cart:hover:not(:disabled) {
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
    
    .btn-buy-now:hover:not(:disabled) {
        background: #000000;
    }
    
    .btn-add-cart:disabled,
    .btn-buy-now:disabled,
    .btn-wishlist:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }
    
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
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 280px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-size: 14px;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .notification.success {
        background: #28a745;
    }
    
    .notification.error {
        background: #dc3545;
    }
    
    .notification.info {
        background: #17a2b8;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
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
        .action-buttons {
            flex-direction: column;
        }
        .btn-add-cart, .btn-buy-now, .btn-wishlist {
            width: 100%;
        }
        .pincode-wrapper {
            flex-direction: column;
        }
        .pincode-wrapper button {
            width: 100%;
        }
    }
</style>

<div class="container mt-4">
    <div class="product-detail-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'Products' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <div class="product-gallery-wrapper">
                    <div class="vertical-thumbnails" id="verticalThumbnails">
                        @php
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
            
            <div class="col-md-6">
                <div class="right-side-content">
                    <div class="brand-name">
                        <i class="fas fa-building"></i> {{ $product->brand->name ?? 'BRAVE' }}
                    </div>
                    
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <p class="product-subtitle">{{ $product->short_description ?? 'Graphic Printed T-Shirt' }}</p>
                    <p class="product-category">
                        <i class="fas fa-tag"></i> {{ $product->category ? $product->category->name : 'Uncategorized' }}
                    </p>
                    
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
                    
                    <div class="size-section">
                        <div class="size-header">
                            <span class="size-label">Select Size</span>
                            <a href="#" class="size-guide" onclick="showSizeGuide(event)">Size Guide</a>
                        </div>
                        <div class="size-options" id="sizeOptions">
                            @php
                                $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                            @endphp
                            @foreach($sizes as $size)
                            <button type="button" class="size-btn" data-size="{{ $size }}">{{ $size }}</button>
                            @endforeach
                        </div>
                        <div id="sizeWarning" class="size-warning">Please select a size first</div>
                    </div>
                    
                    <div class="quantity-section">
                        <label class="quantity-label">Quantity</label>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                            <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 10 }}">
                            <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                        </div>
                    </div>
                    
                    <div class="stock-status">
                        @if($product->stock > 0)
                            <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} items available)</span>
                        @else
                            <span class="out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        @endif
                    </div>
                    
                    <!-- Delivery Section with Pincode Input - EMPTY INITIALLY -->
                    <div class="delivery-section">
                        <div class="delivery-header">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>Select Delivery Location</strong>
                            <small>Enter pincode to check availability</small>
                        </div>
                        <div class="pincode-wrapper">
                            <input type="text" id="pincodeInput" placeholder="Enter pincode" maxlength="6" autocomplete="off" value="">
                            <button id="checkPincodeBtn" onclick="checkPincode()">Check</button>
                        </div>
                        <div id="deliveryMessage" class="delivery-message" style="display: none;"></div>
                    </div>
                    
                    <!-- Delivery Information Box -->
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
                    
                    <div class="action-buttons">
                        <button class="btn-wishlist" id="wishlistBtn" onclick="toggleWishlistDetail()" disabled>
                            <i class="far fa-heart"></i> Wishlist
                        </button>
                        <button class="btn-add-cart" id="addToCartBtn" onclick="addToCartDetail()" disabled>
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn-buy-now" id="buyNowBtn" onclick="buyNowDetail()" disabled>
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    </div>
                    
                    <div class="product-info-tabs">
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

<div id="imageModal" class="image-modal" onclick="closeModal()">
    <span class="close-modal">&times;</span>
    <img class="modal-image" id="modalImage">
</div>

<div id="sizeGuideModal" class="image-modal" style="display:none;" onclick="closeSizeGuide()">
    <div style="background:white; border-radius:15px; max-width:500px; width:90%; padding:20px;" onclick="event.stopPropagation()">
        <span style="float:right; cursor:pointer; font-size:24px;" onclick="closeSizeGuide()">&times;</span>
        <h4>Size Guide</h4>
        <table style="width:100%; border-collapse:collapse; margin-top:15px;">
            <tr style="background:#f0f0f0;">
                <th style="padding:10px; border:1px solid #ddd;">Size</th>
                <th style="padding:10px; border:1px solid #ddd;">Chest (inches)</th>
                <th style="padding:10px; border:1px solid #ddd;">Length (inches)</th>
            </tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">XS</td><td style="padding:8px; border:1px solid #ddd;">34-36</td><td style="padding:8px; border:1px solid #ddd;">27</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">S</td><td style="padding:8px; border:1px solid #ddd;">36-38</td><td style="padding:8px; border:1px solid #ddd;">28</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">M</td><td style="padding:8px; border:1px solid #ddd;">38-40</td><td style="padding:8px; border:1px solid #ddd;">29</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">L</td><td style="padding:8px; border:1px solid #ddd;">40-42</td><td style="padding:8px; border:1px solid #ddd;">30</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">XL</td><td style="padding:8px; border:1px solid #ddd;">42-44</td><td style="padding:8px; border:1px solid #ddd;">31</td></tr>
            <tr><td style="padding:8px; border:1px solid #ddd;">XXL</td><td style="padding:8px; border:1px solid #ddd;">44-46</td><td style="padding:8px; border:1px solid #ddd;">32</td></tr>
        </table>
    </div>
</div>

<script>
    let currentIndex = 0;
    let totalImages = {{ $allImages->count() }};
    const images = @json($allImages->map(function($img) { return asset('storage/' . $img->image_path); }));
    
    const productId = {{ $product->id }};
    const productName = "{{ addslashes($product->name) }}";
    const productPrice = {{ $product->discount_price ?? $product->price }};
    const productImage = "{{ asset('storage/' . ($allImages[0]->image_path ?? $product->image)) }}";
    let selectedSize = null;
    let isPincodeValid = false;
    let currentPincode = '';
    
    const wishlistBtn = document.getElementById('wishlistBtn');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const buyNowBtn = document.getElementById('buyNowBtn');
    const pincodeInput = document.getElementById('pincodeInput');
    const deliveryMessageDiv = document.getElementById('deliveryMessage');
    
    // Initially disable all buttons
    function enableButtons() {
        if (wishlistBtn) wishlistBtn.disabled = false;
        if (addToCartBtn) addToCartBtn.disabled = false;
        if (buyNowBtn) buyNowBtn.disabled = false;
    }
    
    function disableButtons() {
        if (wishlistBtn) wishlistBtn.disabled = true;
        if (addToCartBtn) addToCartBtn.disabled = true;
        if (buyNowBtn) buyNowBtn.disabled = true;
    }
    
    function showDeliveryMessage(message, type, pincode = '', deliveryDays = '') {
        deliveryMessageDiv.style.display = 'flex';
        deliveryMessageDiv.className = `delivery-message ${type}`;
        
        let icon = '';
        let messageText = '';
        
        if (type === 'success') {
            icon = '<i class="fas fa-check-circle"></i>';
            messageText = `✓ Delivery available for pincode ${pincode}! Delivery in ${deliveryDays} days`;
        } else if (type === 'error') {
            icon = '<i class="fas fa-times-circle"></i>';
            messageText = `✗ ${message}`;
        } else {
            icon = '<i class="fas fa-spinner fa-spin"></i>';
            messageText = message;
        }
        
        deliveryMessageDiv.innerHTML = `${icon} ${messageText}`;
    }
    
    function clearDeliveryMessage() {
        deliveryMessageDiv.style.display = 'none';
        deliveryMessageDiv.innerHTML = '';
    }
    
    async function checkPincode() {
        const pincode = pincodeInput.value.trim();
        
        // Check if pincode is empty
        if (pincode === '') {
            showDeliveryMessage('Please enter a pincode', 'error');
            pincodeInput.classList.remove('valid', 'invalid');
            isPincodeValid = false;
            currentPincode = '';
            disableButtons();
            return;
        }
        
        // Check if pincode is valid 6 digits
        if (pincode.length !== 6 || isNaN(pincode)) {
            showDeliveryMessage('Please enter valid 6-digit pincode', 'error');
            pincodeInput.classList.remove('valid', 'invalid');
            isPincodeValid = false;
            currentPincode = '';
            disableButtons();
            return;
        }
        
        showDeliveryMessage('Checking availability...', 'info');
        
        try {
            const response = await fetch(`/api/check-pincode/${pincode}`);
            const data = await response.json();
            
            if (data.deliverable) {
                currentPincode = pincode;
                isPincodeValid = true;
                pincodeInput.classList.add('valid');
                pincodeInput.classList.remove('invalid');
                showDeliveryMessage('', 'success', pincode, data.delivery_days);
                localStorage.setItem('delivery_pincode', pincode);
                enableButtons();
                showNotification(`Delivery available to ${pincode}!`, 'success');
            } else {
                isPincodeValid = false;
                currentPincode = '';
                pincodeInput.classList.add('invalid');
                pincodeInput.classList.remove('valid');
                showDeliveryMessage(data.message, 'error');
                disableButtons();
                showNotification(`Sorry, we don't deliver to ${pincode} yet`, 'error');
            }
        } catch (error) {
            console.error('Error checking pincode:', error);
            showDeliveryMessage('Error checking pincode. Please try again.', 'error');
            disableButtons();
        }
    }
    
    // Function to change main image
    function changeMainImage(index) {
        currentIndex = index;
        document.getElementById('mainImage').src = images[index];
        document.querySelectorAll('.vertical-thumb').forEach((thumb, i) => {
            if (i == index) thumb.classList.add('active');
            else thumb.classList.remove('active');
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
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'Escape') closeModal();
    });
    
    function showSizeGuide(event) {
        event.preventDefault();
        document.getElementById('sizeGuideModal').style.display = 'flex';
    }
    
    function closeSizeGuide() {
        document.getElementById('sizeGuideModal').style.display = 'none';
    }
    
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
    
    function toggleWishlistDetail() {
        if (!isPincodeValid) {
            showNotification('Please check delivery availability first!', 'info');
            pincodeInput.focus();
            return;
        }
        
        @if(!auth()->check())
            if(confirm('Please login to add items to wishlist. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const existingIndex = wishlist.findIndex(item => item.id === productId);
        const btn = document.querySelector('.btn-wishlist');
        const icon = btn.querySelector('i');
        
        if (existingIndex !== -1) {
            wishlist.splice(existingIndex, 1);
            icon.className = 'far fa-heart';
            btn.style.background = 'white';
            btn.style.color = '#dc3545';
            showNotification('Removed from wishlist!', 'info');
        } else {
            wishlist.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                added_at: new Date().toISOString()
            });
            icon.className = 'fas fa-heart';
            btn.style.background = '#dc3545';
            btn.style.color = 'white';
            showNotification('Added to wishlist!', 'success');
        }
        
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        updateWishlistCount();
    }
    
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            selectedSize = this.getAttribute('data-size');
            document.getElementById('sizeWarning').style.display = 'none';
            saveSelectedSize();
        });
    });
    
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
    
    function addToCartDetail() {
        if (!isPincodeValid) {
            showNotification('Please check delivery availability first!', 'info');
            pincodeInput.focus();
            return;
        }
        
        @if(!auth()->check())
            if(confirm('Please login to add products to cart. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        if (!selectedSize) {
            document.getElementById('sizeWarning').style.display = 'block';
            document.getElementById('sizeWarning').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        
        let quantity = parseInt(document.getElementById('quantity').value);
        let currentCart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingItem = currentCart.find(item => item.id === productId && item.size === selectedSize);
        
        if(existingItem) {
            existingItem.quantity += quantity;
        } else {
            currentCart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: quantity,
                size: selectedSize,
                delivery_pincode: currentPincode
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(currentCart));
        showNotification(productName + ' (' + selectedSize + ') added to cart!', 'success');
        updateCartCount();
    }
    
    function buyNowDetail() {
        if (!isPincodeValid) {
            showNotification('Please check delivery availability first!', 'info');
            pincodeInput.focus();
            return;
        }
        
        @if(!auth()->check())
            if(confirm('Please login to purchase. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        if (!selectedSize) {
            document.getElementById('sizeWarning').style.display = 'block';
            document.getElementById('sizeWarning').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        
        let quantity = parseInt(document.getElementById('quantity').value);
        
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("buy.now") }}';
        
        let csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        let productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;
        form.appendChild(productInput);
        
        let quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = quantity;
        form.appendChild(quantityInput);
        
        let sizeInput = document.createElement('input');
        sizeInput.type = 'hidden';
        sizeInput.name = 'size';
        sizeInput.value = selectedSize;
        form.appendChild(sizeInput);
        
        let pincodeField = document.createElement('input');
        pincodeField.type = 'hidden';
        pincodeField.name = 'delivery_pincode';
        pincodeField.value = currentPincode;
        form.appendChild(pincodeField);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} me-2"></i> ${message}`;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
    
    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let count = cart.reduce((total, item) => total + item.quantity, 0);
        let cartCountElement = document.getElementById('navbarCartCount');
        if (cartCountElement) {
            cartCountElement.textContent = count;
            if(count > 0) cartCountElement.classList.remove('hide-badge');
            else cartCountElement.classList.add('hide-badge');
        }
    }
    
    function updateWishlistCount() {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let count = wishlist.length;
        let el = document.getElementById('navbarWishlistCount');
        if (el) {
            if(count > 0) {
                el.textContent = count;
                el.classList.remove('hide-badge');
            } else {
                el.textContent = '';
                el.classList.add('hide-badge');
            }
        }
    }
    
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
    
    function checkWishlistStatus() {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const isInWishlist = wishlist.some(item => item.id === productId);
        const btn = document.querySelector('.btn-wishlist');
        const icon = btn.querySelector('i');
        
        if (isInWishlist) {
            icon.className = 'fas fa-heart';
            btn.style.background = '#dc3545';
            btn.style.color = 'white';
        } else {
            icon.className = 'far fa-heart';
            btn.style.background = 'white';
            btn.style.color = '#dc3545';
        }
    }
    
    function loadSavedSize() {
        let savedSizes = JSON.parse(localStorage.getItem('selectedSizes')) || {};
        if (savedSizes[productId]) {
            selectedSize = savedSizes[productId];
            document.querySelectorAll('.size-btn').forEach(btn => {
                if (btn.getAttribute('data-size') === selectedSize) {
                    btn.classList.add('selected');
                }
            });
        }
    }
    
    function saveSelectedSize() {
        let savedSizes = JSON.parse(localStorage.getItem('selectedSizes')) || {};
        if (selectedSize) {
            savedSizes[productId] = selectedSize;
            localStorage.setItem('selectedSizes', JSON.stringify(savedSizes));
        }
    }
    
    // Enter key press on pincode input
    pincodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            checkPincode();
        }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const firstTab = document.querySelector('.info-tab-header');
        if (firstTab) {
            firstTab.classList.add('active');
            if(firstTab.nextElementSibling) firstTab.nextElementSibling.classList.add('show');
        }
        
        updateCartCount();
        updateWishlistCount();
        checkWishlistStatus();
        loadSavedSize();
        
        // Initially disable all buttons - user must enter pincode first
        disableButtons();
        
        // Clear any saved pincode from localStorage to start empty
        // localStorage.removeItem('delivery_pincode');
        
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