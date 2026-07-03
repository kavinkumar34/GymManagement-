@extends('layouts.app')

@section('content')
<style>
    /* ===== PREVENT HORIZONTAL SCROLL ===== */
    html, body {
        overflow-x: hidden !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* ===== FULL WIDTH BANNER - NO GAPS ===== */
    .banner-full-width {
        width: 100%;
        margin: 0;
        padding: 0;
        position: relative;
        left: 0;
        right: 0;
    }

    .banner-full-width .carousel {
        width: 100%;
        margin: 0;
        padding: 0;
        border-radius: 0;
    }

    .banner-full-width .carousel-inner {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .banner-full-width .carousel-item {
        width: 100%;
        height: 550px;
        margin: 0;
        padding: 0;
    }

    .banner-full-width .carousel-item img {
        width: 100%;
        height: 550px;
        object-fit: cover;
        display: block;
    }

    .banner-full-width .carousel-control-prev,
    .banner-full-width .carousel-control-next {
        width: 40px;
        height: 40px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.3);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .banner-full-width:hover .carousel-control-prev,
    .banner-full-width:hover .carousel-control-next {
        opacity: 1;
    }

    .banner-full-width .carousel-control-prev {
        left: 15px;
    }

    .banner-full-width .carousel-control-next {
        right: 15px;
    }

    .banner-full-width .carousel-control-prev-icon,
    .banner-full-width .carousel-control-next-icon {
        width: 20px;
        height: 20px;
        background-size: 100% 100%;
    }

    /* ===== SALE BANNER ===== */
    .sale-banner {
        background: #dc3545;
        padding: 15px;
        text-align: center;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 20px 0;
        border-radius: 10px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    /* ===== PRODUCT CARD ===== */
    .product-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
        position: relative;
        background: white;
        cursor: pointer;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .product-image-slider {
        position: relative;
        overflow: hidden;
    }
    
    .product-image-slider .carousel-control-prev,
    .product-image-slider .carousel-control-next {
        opacity: 0;
        transition: opacity 0.3s;
        width: 30px;
        height: 30px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
    }
    
    .product-card:hover .product-image-slider .carousel-control-prev,
    .product-card:hover .product-image-slider .carousel-control-next {
        opacity: 1;
    }
    
    .product-image-slider .carousel-control-prev {
        left: 5px;
    }
    
    .product-image-slider .carousel-control-next {
        right: 5px;
    }
    
    .product-image-slider .carousel-control-prev-icon,
    .product-image-slider .carousel-control-next-icon {
        background-size: 60%;
        width: 15px;
        height: 15px;
    }
    
    .product-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: #dc3545;
    }
    
    .product-old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
        margin-right: 10px;
    }
    
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 1;
    }
    
    .wishlist-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        background: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s;
    }
    
    .wishlist-btn i {
        font-size: 1.1rem;
        transition: all 0.3s;
    }
    
    .wishlist-btn i.far {
        color: #999;
    }
    
    .wishlist-btn i.fas {
        color: #dc3545;
    }
    
    .wishlist-btn:hover {
        transform: scale(1.1);
    }
    
    .btn-add-cart {
        background: #000000;
        border: none;
        border-radius: 25px;
        padding: 8px 15px;
        color: white;
        transition: all 0.3s;
        font-size: 0.85rem;
        cursor: pointer;
    }
    
    .btn-add-cart:hover {
        background: #dc3545;
        transform: scale(1.05);
    }
    
    .btn-buy-now {
        background: #dc3545;
        border: none;
        border-radius: 25px;
        padding: 8px 15px;
        color: white;
        transition: all 0.3s;
        font-size: 0.85rem;
        cursor: pointer;
    }
    
    .btn-buy-now:hover {
        background: #000000;
        transform: scale(1.05);
    }
    
    .product-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 15px;
    }
    
    .product-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        justify-content: flex-start;
    }
    
    .product-rating .stars {
        display: flex;
        gap: 2px;
    }
    
    .product-rating .stars i {
        font-size: 0.85rem;
    }
    
    .product-rating .stars i.fa-star,
    .product-rating .stars i.fa-star-half-alt {
        color: #f59e0b !important;
    }
    
    .product-rating .stars i.far.fa-star {
        color: #e0e0e0 !important;
    }
    
    .product-rating .rating-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .product-stock-low {
        font-size: 0.9rem;
        color: #ef4444;
        margin-top: 6px;
        text-align: left;
        font-weight: 600;
        background: #fef2f2;
        padding: 4px 10px;
        border-radius: 6px;
        border-left: 3px solid #ef4444;
        display: inline-block;
        width: 100%;
    }
    
    .product-stock-low i {
        font-size: 0.9rem;
        margin-right: 6px;
        color: #ef4444;
    }
    
    .product-card .card-body {
        text-align: left;
        padding: 10px 12px;
    }
    
    .product-card .card-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #1e293b;
        text-align: left;
    }
    
    /* ===== CATEGORY CARD ===== */
    .category-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        margin-bottom: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 35px rgba(0,0,0,0.15);
    }
    
    .category-image-wrapper {
        width: 100%;
        height: 280px;
        overflow: hidden;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .category-image-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        opacity: 0;
        transition: opacity 0.3s;
        z-index: 1;
    }
    
    .category-card:hover .category-image-wrapper::before {
        opacity: 1;
    }
    
    .category-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .category-card:hover .category-image-wrapper img {
        transform: scale(1.1);
    }
    
    .category-icon-wrapper {
        width: 100%;
        height: 280px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .category-icon-wrapper i {
        font-size: 5rem;
        color: #999;
        transition: transform 0.3s;
    }
    
    .category-card:hover .category-icon-wrapper i {
        transform: scale(1.1);
        color: #dc3545;
    }
    
    .category-info {
        padding: 20px;
        text-align: center;
        background: white;
    }
    
    .category-info h5 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1e293b;
    }
    
    .category-info p {
        font-size: 0.85rem;
        color: #dc3545;
        font-weight: 500;
        margin-bottom: 0;
        display: inline-block;
        transition: all 0.3s;
    }
    
    .category-card:hover .category-info p {
        transform: translateX(5px);
        color: #000000;
    }
    
    .category-info p i {
        font-size: 0.75rem;
        transition: transform 0.3s;
    }
    
    .category-card:hover .category-info p i {
        transform: translateX(5px);
    }
    
    .category-row {
        margin-left: -15px;
        margin-right: -15px;
    }
    
    .category-row > [class*="col-"] {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    /* ===== LOADER ===== */
    .loader {
        text-align: center;
        padding: 50px;
    }
    
    .loader i {
        font-size: 3rem;
        color: #dc3545;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .no-products {
        text-align: center;
        padding: 50px;
        background: white;
        border-radius: 15px;
    }

    .best-sellers-card {
        background: white;
        border: 1px solid #eee;
    }
    
    .best-sellers-header {
        background: #000000 !important;
        color: white !important;
        border-radius: 15px 15px 0 0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .banner-full-width .carousel-item,
        .banner-full-width .carousel-item img {
            height: 250px;
        }
        .category-image-wrapper {
            height: 220px;
        }
    }

    @media (max-width: 576px) {
        .banner-full-width .carousel-item,
        .banner-full-width .carousel-item img {
            height: 180px;
        }
        .category-image-wrapper {
            height: 180px;
        }
        .category-info {
            padding: 15px;
        }
        .category-info h5 {
            font-size: 0.9rem;
        }
        .category-info p {
            font-size: 0.75rem;
        }
    }
</style>

<!-- ===== FULL WIDTH BANNER - NO GAPS ===== -->
<div class="banner-full-width">
    <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner" id="bannerContainer">
            <div class="carousel-item active">
                <div style="height:550px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;width:100%;">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <span class="ms-2">Loading banners...</span>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- ===== CATEGORY SECTION ===== -->
<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #000000;">Shop by Category</h2>
    <div class="row category-row" id="categoryContainer"></div>
</div>

<!-- ===== PRODUCTS SECTION ===== -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #000000;">🔥 Best Selling Products</h2>
        <a href="/shop" style="color: #dc3545 !important;">View All →</a>
    </div>
    
    <div id="productsLoader" class="loader" style="display: none;">
        <i class="fas fa-spinner"></i>
        <p>Loading products...</p>
    </div>
    
    <div class="row" id="productsContainer"></div>
</div>

<!-- ===== BEST SELLERS LIST ===== -->
<div class="container mt-5 mb-5">
    <div class="card best-sellers-card">
        <div class="card-header best-sellers-header">
            <h4 class="mb-0"><i class="fas fa-trophy"></i> Best Selling Products</h4>
        </div>
        <div class="card-body" id="bestSellersList"></div>
    </div>
</div>

<script>
    // ===== BANNER LOADING =====
    async function loadBanners() {
        try {
            const response = await fetch('/api/banners');
            const banners = await response.json();
            const bannerContainer = document.getElementById('bannerContainer');
            if (!bannerContainer) return;
            
            if (banners.length === 0) {
                bannerContainer.innerHTML = '<div class="carousel-item active"><div style="height:450px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;width:100%;"><i class="fas fa-image fa-2x"></i> <span class="ms-2">No Banners Available</span></div></div>';
                return;
            }
            
            let bannerHtml = '';
            banners.forEach((banner, index) => {
                bannerHtml += `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}" style="width:100%;">
                        ${banner.link ? `<a href="${banner.link}" target="_blank" style="display:block;width:100%;">` : ''}
                            <img src="${banner.image_url}" alt="Banner" style="width:100%; height:550px; object-fit:cover;">
                        ${banner.link ? `</a>` : ''}
                    </div>
                `;
            });
            bannerContainer.innerHTML = bannerHtml;
        } catch (error) {
            console.error('Error loading banners:', error);
        }
    }

    if (document.getElementById('bannerContainer')) {
        loadBanners();
    }

    // ===== WISHLIST FUNCTIONS =====
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function updateWishlistCount() {
        let count = wishlist.length;
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        if (wishlistCountElement) {
            if (count > 0) {
                wishlistCountElement.textContent = count;
                wishlistCountElement.style.display = '';
            } else {
                wishlistCountElement.style.display = 'none';
            }
        }
    }

    function updateCartCount() {
        let count = cart.reduce((total, item) => total + item.quantity, 0);
        let cartCountElement = document.getElementById('navbarCartCount');
        if (cartCountElement) {
            if(count > 0) {
                cartCountElement.textContent = count;
                cartCountElement.style.display = '';
            } else {
                cartCountElement.style.display = 'none';
            }
        }
    }

    function loadWishlistStatus() {
        wishlist.forEach(item => {
            const icon = document.getElementById(`wishlist-icon-${item.id}`);
            if (icon) {
                icon.className = 'fas fa-heart';
            }
        });
    }

    function toggleWishlist(id, name, price, image) {
        @if(!auth()->check())
            if(confirm('Please login to add items to wishlist. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const existingIndex = currentWishlist.findIndex(item => item.id === id);
        const icon = document.getElementById(`wishlist-icon-${id}`);
        
        if (existingIndex !== -1) {
            currentWishlist.splice(existingIndex, 1);
            if (icon) icon.className = 'far fa-heart';
            showNotification('Removed from wishlist!', 'info');
        } else {
            currentWishlist.push({
                id: id,
                name: name,
                price: price,
                image: image,
                added_at: new Date().toISOString()
            });
            if (icon) icon.className = 'fas fa-heart';
            showNotification('Added to wishlist!', 'success');
        }
        
        localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
        wishlist = currentWishlist;
        updateWishlistCount();
    }

    function addToCart(id, name, price, imageUrl, event) {
        if (event) event.stopPropagation();
        
        @if(!auth()->check())
            if(confirm('Please login to add products to cart. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
        let currentCart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingItem = currentCart.find(item => item.id === id);
        
        let finalImageUrl = imageUrl || '';
        if (finalImageUrl && !finalImageUrl.startsWith('http') && !finalImageUrl.startsWith('/storage/')) {
            finalImageUrl = '/storage/' + finalImageUrl;
        }
        
        if(existingItem) {
            existingItem.quantity++;
            if (!existingItem.image) {
                existingItem.image = finalImageUrl;
            }
        } else {
            currentCart.push({
                id: id,
                name: name,
                price: price,
                image: finalImageUrl,
                quantity: 1
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(currentCart));
        cart = currentCart;
        updateCartCount();
        showNotification(name + ' added to cart!', 'success');
    }

    function buyNow(productId, productName, productPrice, event) {
        if (event) event.stopPropagation();
        
        @if(!auth()->check())
            if(confirm('Please login to purchase. Go to login page?')) {
                window.location.href = "{{ route('login') }}";
            }
            return;
        @endif
        
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
        quantityInput.value = 1;
        form.appendChild(quantityInput);
        
        document.body.appendChild(form);
        form.submit();
    }

    function goToProductDetail(productId, event) {
        if (event.target.closest('.wishlist-btn') || 
            event.target.closest('.btn-add-cart') || 
            event.target.closest('.btn-buy-now') ||
            event.target.closest('.carousel-control-prev') ||
            event.target.closest('.carousel-control-next')) {
            return;
        }
        window.location.href = `/product/${productId}`;
    }

    function showNotification(message, type) {
        let notification = document.createElement('div');
        notification.className = 'alert alert-' + (type === 'success' ? 'success' : 'info') + ' alert-dismissible fade show';
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '250px';
        notification.innerHTML = '<i class="fas fa-check-circle"></i> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    function goToCategoryProducts(categoryId, categoryName) {
        window.location.href = `/shop?category=${categoryId}&name=${encodeURIComponent(categoryName)}`;
    }

    // ===== LOAD CATEGORIES =====
    async function loadCategories() {
        try {
            const response = await fetch('/api/categories');
            const categories = await response.json();
            const categoryContainer = document.getElementById('categoryContainer');
            if (!categoryContainer) return;
            
            if (categories.length === 0) {
                categoryContainer.innerHTML = '<div class="col-12 text-center">No categories found</div>';
                return;
            }
            
            categoryContainer.innerHTML = categories.map(cat => `
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="category-card" onclick="goToCategoryProducts(${cat.id}, '${cat.name.replace(/'/g, "\\'")}')">
                        <div class="category-image-wrapper">
                            ${cat.image ? 
                                `<img src="/storage/${cat.image}" alt="${cat.name}">` : 
                                `<div class="category-icon-wrapper"><i class="fas fa-tag"></i></div>`
                            }
                        </div>
                        <div class="category-info">
                            <h5>${cat.name}</h5>
                            <p>View Products <i class="fas fa-arrow-right ms-1"></i></p>
                        </div>
                    </div>
                </div>
            `).join('');
            
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    // ===== RENDER STARS =====
    function renderStars(rating) {
        const fullStars = Math.floor(rating);
        const halfStar = rating - fullStars >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
        
        let starsHtml = '';
        for (let i = 0; i < fullStars; i++) {
            starsHtml += '<i class="fas fa-star"></i>';
        }
        if (halfStar) {
            starsHtml += '<i class="fas fa-star-half-alt"></i>';
        }
        for (let i = 0; i < emptyStars; i++) {
            starsHtml += '<i class="far fa-star"></i>';
        }
        return starsHtml;
    }

    // ===== LOAD PRODUCTS =====
    async function loadProducts() {
        const loader = document.getElementById('productsLoader');
        const container = document.getElementById('productsContainer');
        if (loader) loader.style.display = 'block';
        
        try {
            const response = await fetch('/api/products');
            const products = await response.json();
            if (loader) loader.style.display = 'none';
            
            const filteredProducts = products.filter(product => {
                const stock = parseInt(product.stock) || 0;
                return stock > 0;
            });
            
            if (filteredProducts.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products available</div></div>';
                return;
            }
            
            container.innerHTML = filteredProducts.map(product => {
                const discountPercent = product.discount_price ? Math.round(((product.price - product.discount_price) / product.price) * 100) : 0;
                const displayPrice = product.discount_price ? product.discount_price : product.price;
                const oldPriceHtml = product.discount_price ? `<span class="product-old-price">₹${parseFloat(product.price).toLocaleString()}</span>` : '';
                const discountBadge = product.discount_price ? `<div class="discount-badge">-${discountPercent}%</div>` : '';
                
                let images = [];
                if (product.image) {
                    images.push(product.image);
                }
                if (product.gallery_images && product.gallery_images.length) {
                    images = [...images, ...product.gallery_images];
                }
                
                if (images.length === 0) {
                    images = ['https://via.placeholder.com/300x300?text=No+Image'];
                }
                
                const imageUrls = images.map(img => img.startsWith('http') ? img : '/storage/' + img);
                const carouselId = `productCarousel-${product.id}`;
                const isInWishlist = wishlist.some(item => item.id === product.id);
                const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                const escapeName = product.name.replace(/'/g, "\\'");
                
                const rating = parseFloat(product.rating) || 0;
                const starsHtml = renderStars(rating);
                
                const stock = parseInt(product.stock) || 0;
                
                let stockAlertHtml = '';
                if (stock <= 5 && stock > 0) {
                    stockAlertHtml = `
                        <div class="product-stock-low">
                            <i class="fas fa-exclamation-triangle"></i>
                            Only ${stock} left in stock!
                        </div>
                    `;
                }
                
                return `
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                            ${discountBadge}
                            <button class="wishlist-btn" onclick="toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrls[0]}')">
                                <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                            </button>
                            
                            <div id="${carouselId}" class="carousel slide product-image-slider" data-bs-ride="false">
                                <div class="carousel-inner">
                                    ${imageUrls.map((imgUrl, idx) => `
                                        <div class="carousel-item ${idx === 0 ? 'active' : ''}">
                                            <img src="${imgUrl}" class="d-block w-100 product-image" alt="${product.name}" style="height: 200px; object-fit: cover;">
                                        </div>
                                    `).join('')}
                                </div>
                                ${imageUrls.length > 1 ? `
                                    <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                ` : ''}
                            </div>
                            
                            <div class="card-body text-center" style="text-align: left !important;">
                                <h5 class="card-title" style="text-align: left;">${product.name}</h5>
                                <div style="text-align: left;">
                                    ${oldPriceHtml}
                                    <span class="product-price" style="text-align: left;">₹${parseFloat(displayPrice).toLocaleString()}</span>
                                </div>
                                
                                <div class="product-rating" style="justify-content: flex-start;">
                                    <div class="stars">${starsHtml}</div>
                                    <span class="rating-value">${rating > 0 ? rating.toFixed(1) : '0.0'}</span>
                                </div>
                                
                                ${stockAlertHtml}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            loadWishlistStatus();
            
        } catch (error) {
            console.error('Error loading products:', error);
            if (loader) loader.style.display = 'none';
            container.innerHTML = '<div class="col-12"><div class="no-products text-danger">Error loading products. Please try again.</div></div>';
        }
    }

    // ===== LOAD BEST SELLERS =====
    async function loadBestSellers() {
        try {
            const response = await fetch('/api/best-sellers');
            const products = await response.json();
            const container = document.getElementById('bestSellersList');
            if (!container) return;
            
            if (products.length === 0) {
                container.innerHTML = '<p class="text-center">No best sellers yet</p>';
                return;
            }
            
            container.innerHTML = `
                <div class="row">
                    ${products.slice(0, 6).map((product, index) => `
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-warning me-3 p-2" style="background-color: #dc3545 !important;">#${index + 1}</span>
                                <div>
                                    <h6 class="mb-0">${product.name}</h6>
                                    <small>Sold: ${product.sold_count || 100}+ units</small>
                                </div>
                                ${index === 0 ? '<span class="ms-auto text-warning" style="color: #dc3545 !important;">🔥 Hot</span>' : ''}
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        } catch (error) {
            console.error('Error loading best sellers:', error);
        }
    }

    // ===== INITIALIZE =====
    document.addEventListener('DOMContentLoaded', function() {
        loadBanners();
        wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        loadCategories();
        loadProducts();
        loadBestSellers();
        updateCartCount();
        updateWishlistCount();
    });
</script>
@endsection