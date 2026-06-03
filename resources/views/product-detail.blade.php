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
    
    /* Main Image */
    .main-image-container {
        width: 100%;
        height: 400px;
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 15px;
        cursor: pointer;
    }
    
    .main-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    /* Thumbnail Slider */
    .thumbnail-slider-container {
        position: relative;
        padding: 0 35px;
    }
    
    .thumbnail-wrapper {
        overflow-x: auto;
        scroll-behavior: smooth;
        white-space: nowrap;
        padding: 10px 0;
        scrollbar-width: thin;
    }
    
    .thumbnail-wrapper::-webkit-scrollbar {
        height: 5px;
    }
    
    .thumbnail-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    
    .thumbnail-wrapper::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 5px;
    }
    
    .thumbnail-item {
        display: inline-block;
        width: 80px;
        height: 80px;
        margin-right: 10px;
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        transition: all 0.3s;
    }
    
    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .thumbnail-item.active {
        border-color: #dc3545;
        box-shadow: 0 0 5px rgba(220,53,69,0.5);
    }
    
    .thumbnail-item:hover {
        transform: scale(1.05);
    }
    
    /* Slider Buttons */
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: white;
        border: 1px solid #ddd;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
    }
    
    .slider-btn:hover {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    .slider-left {
        left: 0;
    }
    
    .slider-right {
        right: 0;
    }
    
    /* Price Section */
    .price {
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
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        margin-left: 10px;
    }
    
    /* Size Selection */
    .size-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin: 15px 0;
    }
    
    .size-btn {
        width: 50px;
        padding: 8px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .size-btn:hover, .size-btn.selected {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    /* Quantity Selector */
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 15px 0;
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
    
    /* Action Buttons */
    .btn-add-cart {
        background: #000000;
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        color: white;
        transition: all 0.3s;
    }
    
    .btn-add-cart:hover {
        background: #dc3545;
        transform: scale(1.02);
    }
    
    .btn-buy-now {
        background: #dc3545;
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        color: white;
        transition: all 0.3s;
    }
    
    .btn-buy-now:hover {
        background: #000000;
        transform: scale(1.02);
    }
    
    /* Related Products */
    .related-card {
        transition: transform 0.3s;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .related-card:hover {
        transform: translateY(-5px);
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    /* Warning Message */
    .size-warning {
        color: red;
        font-size: 12px;
        display: none;
        margin-top: 5px;
    }
    
    /* Dropdown Select Style */
    .info-dropdown {
        width: 100%;
        padding: 12px 15px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: white;
        cursor: pointer;
        margin-bottom: 15px;
    }
    
    .info-dropdown:focus {
        outline: none;
        border-color: #dc3545;
    }
    
    /* Content Box with Scroll */
    .info-content {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .info-content::-webkit-scrollbar {
        width: 5px;
    }
    
    .info-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    
    .info-content::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 5px;
    }
    
    /* Specs List */
    .specs-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .specs-list li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .specs-list li strong {
        width: 120px;
        display: inline-block;
    }
    
    /* Right Side Wrapper */
    .right-side-wrapper {
        padding-left: 20px;
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
            <!-- LEFT COLUMN - Product Images -->
            <div class="col-md-6">
                <!-- Main Image -->
                <div class="main-image-container">
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="main-image" alt="{{ $product->name }}">
                </div>
                
                <!-- Thumbnail Slider -->
                <div class="thumbnail-slider-container">
                    <button class="slider-btn slider-left" onclick="scrollThumbnails(-120)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="thumbnail-wrapper" id="thumbnailWrapper">
                        @php
                            $allImages = [];
                            if($product->image) {
                                $allImages[] = $product->image;
                            }
                            if($product->gallery_images) {
                                $gallery = is_string($product->gallery_images) ? json_decode($product->gallery_images, true) : $product->gallery_images;
                                if(is_array($gallery)) {
                                    $allImages = array_merge($allImages, $gallery);
                                }
                            }
                            if(count($allImages) == 0) {
                                $allImages = ['https://via.placeholder.com/300x300?text=No+Image'];
                            }
                        @endphp
                        
                        @foreach($allImages as $index => $img)
                        <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}" onclick="changeMainImage('{{ asset('storage/' . $img) }}', this)">
                            <img src="{{ asset('storage/' . $img) }}" alt="Thumbnail {{ $index+1 }}">
                        </div>
                        @endforeach
                    </div>
                    
                    <button class="slider-btn slider-right" onclick="scrollThumbnails(120)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <!-- RIGHT COLUMN - Dropdown + Content + Price -->
            <div class="col-md-6">
                <div class="right-side-wrapper">
                    <!-- Product Basic Info -->
                    <h1 class="mb-2">{{ $product->name }}</h1>
                    
                    <p class="text-muted mb-3">
                        <i class="fas fa-tag"></i> {{ $product->category ? $product->category->name : 'Uncategorized' }}
                    </p>
                    
                    <!-- Rating Stars -->
                    <div class="mb-2">
                        <span class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                        <span class="text-muted ms-2">(0 reviews)</span>
                    </div>
                    
                    <!-- Price -->
                    <div class="mb-3">
                        @if($product->discount_price && $product->discount_price < $product->price)
                            <span class="price">₹{{ number_format($product->discount_price, 2) }}</span>
                            <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                            <span class="discount-badge">{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF</span>
                        @else
                            <span class="price">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    
                    <!-- GST Info -->
                    <p class="text-muted small">Inclusive of all taxes</p>
                    
                    <!-- Size Selection (Only for Clothing) -->
                    @if($product->category_id == 2)
                    <div class="mb-3">
                        <label><strong>Select Size</strong></label>
                        <div class="size-options" id="sizeOptions">
                            <button type="button" class="size-btn" data-size="XS">XS</button>
                            <button type="button" class="size-btn" data-size="S">S</button>
                            <button type="button" class="size-btn" data-size="M">M</button>
                            <button type="button" class="size-btn" data-size="L">L</button>
                            <button type="button" class="size-btn" data-size="XL">XL</button>
                            <button type="button" class="size-btn" data-size="XXL">XXL</button>
                        </div>
                        <div id="sizeWarning" class="size-warning">Please select a size first</div>
                    </div>
                    @endif
                    
                    <!-- Quantity Selector -->
                    <div class="quantity-selector">
                        <button class="quantity-btn" onclick="decrementQuantity()">-</button>
                        <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->stock }}">
                        <button class="quantity-btn" onclick="incrementQuantity()">+</button>
                    </div>
                    
                    <!-- Stock Status -->
                    <div class="mb-3">
                        @if($product->stock > 0)
                            <span class="text-success"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} items)</span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="product-actions mb-4">
                        <button class="btn-add-cart" onclick="addToCartWithSize()">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn-buy-now ms-2" onclick="buyNowWithSize()">
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    </div>
                    
                    <!-- Delivery Info -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <i class="fas fa-truck"></i> <strong>COD Available</strong>
                        </div>
                        <div class="col-6">
                            <i class="fas fa-undo-alt"></i> <strong>{{ $product->return_days ?? 7 }} Days Return</strong>
                        </div>
                    </div>
                    
                    <!-- ========== DROPDOWN FOR PRODUCT INFO ========== -->
                    <div class="mt-3">
                        <select id="infoDropdown" class="info-dropdown">
                            <option value="details">📋 PRODUCT DETAILS</option>
                            <option value="know">🔍 KNOW YOUR PRODUCT</option>
                            <option value="return">🔄 RETURN & EXCHANGE</option>
                        </select>
                        
                        <div id="infoContent" class="info-content">
                            <!-- PRODUCT DETAILS Content -->
                            <div id="detailsContent">
                                <h6>Product Description</h6>
                                <p>{{ $product->description ?? 'No description available' }}</p>
                                @if($product->short_description)
                                    <div class="alert alert-light mt-2 p-2">
                                        <strong>Highlights:</strong>
                                        <p class="mb-0 small">{{ $product->short_description }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- KNOW YOUR PRODUCT Content (Hidden by default) -->
                            <div id="knowContent" style="display: none;">
                                <h6>Product Specifications</h6>
                                <ul class="specs-list">
                                    <li><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</li>
                                    <li><strong>GST:</strong> {{ $product->gst_percentage ?? 18 }}%</li>
                                    <li><strong>Weight:</strong> {{ $product->weight ?? 0 }} {{ $product->weight_unit ?? 'kg' }}</li>
                                    @if($product->dimensions)
                                    <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                                    @endif
                                    <li><strong>Material:</strong> High Quality Fabric</li>
                                    <li><strong>Care Instructions:</strong> Machine wash cold</li>
                                    <li><strong>Fit Type:</strong> Regular Fit</li>
                                </ul>
                            </div>
                            
                            <!-- RETURN & EXCHANGE Content (Hidden by default) -->
                            <div id="returnContent" style="display: none;">
                                <h6>Return & Exchange Policy</h6>
                                <p>You can return this product within {{ $product->return_days ?? 30 }} days of delivery.</p>
                                <p><strong>Exchange Available:</strong> Yes</p>
                                <p>Exchange within {{ $product->return_days ?? 30 }} days of delivery.</p>
                                <p><strong>Warranty:</strong> {{ $product->warranty_months ?? 0 }} months manufacturer warranty</p>
                                <p><strong>Conditions:</strong> Product must be unused and in original packaging.</p>
                                <hr>
                                <h6>How to Return?</h6>
                                <ol class="ps-3">
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
                <div class="card related-card h-100">
                    <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $related->name }}">
                    <div class="card-body text-center">
                        <h6 class="card-title">{{ Str::limit($related->name, 35) }}</h6>
                        @if($related->discount_price && $related->discount_price < $related->price)
                            <span class="text-danger fw-bold">₹{{ number_format($related->discount_price, 2) }}</span>
                            <span class="text-muted text-decoration-line-through ms-1 small">₹{{ number_format($related->price, 2) }}</span>
                        @else
                            <span class="text-danger fw-bold">₹{{ number_format($related->price, 2) }}</span>
                        @endif
                        <a href="/product/{{ $related->id }}" class="btn btn-outline-primary btn-sm mt-2 d-block">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    // Image Slider Functions
    let selectedSize = null;
    
    function changeMainImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
    }
    
    function scrollThumbnails(scrollAmount) {
        const wrapper = document.getElementById('thumbnailWrapper');
        wrapper.scrollLeft += scrollAmount;
    }
    
    // ========== DROPDOWN CHANGE HANDLER ==========
    document.getElementById('infoDropdown').addEventListener('change', function() {
        let selectedValue = this.value;
        
        // Hide all content divs
        document.getElementById('detailsContent').style.display = 'none';
        document.getElementById('knowContent').style.display = 'none';
        document.getElementById('returnContent').style.display = 'none';
        
        // Show selected content
        if (selectedValue === 'details') {
            document.getElementById('detailsContent').style.display = 'block';
        } else if (selectedValue === 'know') {
            document.getElementById('knowContent').style.display = 'block';
        } else if (selectedValue === 'return') {
            document.getElementById('returnContent').style.display = 'block';
        }
    });
    
    // Size Selection (Only for Clothing)
    @if($product->category_id == 2)
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            selectedSize = this.getAttribute('data-size');
            document.getElementById('sizeWarning').style.display = 'none';
        });
    });
    @endif
    
    // Quantity Functions
    function incrementQuantity() {
        let qty = document.getElementById('quantity');
        let max = parseInt(qty.getAttribute('max')) || 999;
        let newVal = parseInt(qty.value) + 1;
        if (newVal <= max) {
            qty.value = newVal;
        }
    }
    
    function decrementQuantity() {
        let qty = document.getElementById('quantity');
        let newVal = parseInt(qty.value) - 1;
        if (newVal >= 1) {
            qty.value = newVal;
        }
    }
    
    // Add to Cart
    function addToCartWithSize() {
        @if(!auth()->check())
            if(confirm('Please login to add products to cart. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        @if($product->category_id == 2)
            if (!selectedSize) {
                document.getElementById('sizeWarning').style.display = 'block';
                return;
            }
        @endif
        
        let quantity = parseInt(document.getElementById('quantity').value);
        let price = {{ $product->discount_price ?? $product->price }};
        let imageUrl = "{{ asset('storage/' . $product->image) }}";
        
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingItem = cart.find(item => item.id === {{ $product->id }} && item.size === selectedSize);
        
        if(existingItem) {
            existingItem.quantity += quantity;
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
        
        let notification = document.createElement('div');
        notification.className = 'alert alert-success alert-dismissible fade show';
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '250px';
        notification.innerHTML = '<i class="fas fa-check-circle me-2"></i> ' + "{{ addslashes($product->name) }}" + ' added to cart!<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 2000);
        
        updateCartCountDisplay();
    }
    
    // Buy Now
    function buyNowWithSize() {
        @if(!auth()->check())
            if(confirm('Please login to purchase. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        @if($product->category_id == 2)
            if (!selectedSize) {
                document.getElementById('sizeWarning').style.display = 'block';
                return;
            }
        @endif
        
        let quantity = document.getElementById('quantity').value;
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
        productInput.value = {{ $product->id }};
        form.appendChild(productInput);
        
        let quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = quantity;
        form.appendChild(quantityInput);
        
        if(selectedSize) {
            let sizeInput = document.createElement('input');
            sizeInput.type = 'hidden';
            sizeInput.name = 'size';
            sizeInput.value = selectedSize;
            form.appendChild(sizeInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
    
    function updateCartCountDisplay() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let count = cart.reduce((total, item) => total + item.quantity, 0);
        let cartCountElement = document.getElementById('navbarCartCount');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }
</script>
@endsection