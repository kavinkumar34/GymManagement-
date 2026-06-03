@extends('layouts.app')

@section('content')
<style>
    /* Sale Banner */
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
    
    /* Product Card */
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
    
    /* Product Image Slider Styles */
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
    
    /* Wishlist Button */
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
    
    /* Category Section */
    .category-card {
        background: #292727;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 20px;
    }
    
    .category-card:hover {
        background: #dc3545;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .category-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    
    /* Search Bar */
    .search-bar {
        max-width: 500px;
        margin: 20px auto;
    }
    
    .search-bar input {
        border-radius: 30px 0 0 30px;
        padding: 12px 20px;
        border: 2px solid #ddd;
    }
    
    .search-bar button {
        border-radius: 0 30px 30px 0;
        background: #000000;
        border: none;
        padding: 12px 25px;
        color: white;
    }
    
    .search-bar button:hover {
        background: #dc3545;
    }
    
    /* No products message */
    .no-products {
        text-align: center;
        padding: 50px;
        background: white;
        border-radius: 15px;
    }
    
    /* Loading spinner */
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
    
    /* Headings */
    h2, .section-title {
        color: #000000;
    }
    
    /* Best Sellers Card */
    .best-sellers-card {
        background: white;
        border: 1px solid #eee;
    }
    
    .best-sellers-header {
        background: #000000 !important;
        color: white !important;
        border-radius: 15px 15px 0 0;
    }
    
    .text-primary {
        color: #dc3545 !important;
    }
    
    .text-primary:hover {
        color: #000000 !important;
    }
    
    /* Banner Slider Styles */
    .banner-slider {
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 0 !important;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        width: 100%;
        position: relative;
        left: 0;
        right: 0;
    }
    
    .banner-slider .carousel-item {
        height: 450px;
        width: 100%;
    }
    
    .banner-slider .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .banner-caption {
        position: absolute;
        bottom: 20%;
        left: 10%;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        background: rgba(0,0,0,0.4);
        padding: 15px 25px;
        border-radius: 10px;
    }
    
    .banner-caption h3 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .banner-caption p {
        font-size: 1.2rem;
        margin-bottom: 0;
    }
    
    @media (max-width: 768px) {
        .banner-slider .carousel-item {
            height: 250px;
        }
        .banner-caption {
            bottom: 10%;
            left: 5%;
            padding: 8px 15px;
        }
        .banner-caption h3 {
            font-size: 1rem;
        }
        .banner-caption p {
            font-size: 0.7rem;
        }
    }
</style>

<!-- Banner Slider Section -->
<div id="bannerSlider" class="carousel slide banner-slider" data-bs-ride="carousel" style="margin: 0; padding: 0; width: 100%;">
    <div class="carousel-inner" id="bannerContainer" style="width: 100%;">
        <div class="carousel-item active">
            <div style="height:450px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;width:100%;">
                <i class="fas fa-spinner fa-spin fa-2x"></i> <span class="ms-2">Loading banners...</span>
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

<!-- Category Section -->
<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #000000;">Shop by Category</h2>
    <div class="row" id="categoryContainer"></div>
</div>

<!-- Products Section -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #000000;">🔥 Best Selling Products</h2>
        <a href="#" style="color: #dc3545 !important;">View All →</a>
    </div>
    
    <div id="productsLoader" class="loader" style="display: none;">
        <i class="fas fa-spinner"></i>
        <p>Loading products...</p>
    </div>
    
    <div class="row" id="productsContainer"></div>
</div>

<!-- Best Sellers List -->
<div class="container mt-5 mb-5">
    <div class="card best-sellers-card">
        <div class="card-header best-sellers-header">
            <h4 class="mb-0"><i class="fas fa-trophy"></i> Best Selling Products</h4>
        </div>
        <div class="card-body" id="bestSellersList"></div>
    </div>
</div>

<script>
    // Banner loading function
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
                            <img src="${banner.image_url}" alt="Banner" style="width:100%; height:450px; object-fit:cover;">
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

    function checkAndHideWishlistCountIfViewed() {
        let permanentHide = localStorage.getItem('wishlist_permanent_hide') === 'true';
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        
        if (permanentHide && wishlistCountElement) {
            wishlistCountElement.style.display = 'none';
        } else if (!permanentHide && wishlistCountElement) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            let count = wishlist.length;
            if (count > 0) {
                wishlistCountElement.style.display = '';
                wishlistCountElement.textContent = count;
                wishlistCountElement.classList.remove('hide-badge');
            } else {
                wishlistCountElement.style.display = 'none';
            }
        }
    }

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    
    function updateCartCount() {
        let count = cart.reduce((total, item) => total + item.quantity, 0);
        let cartCountElement = document.getElementById('navbarCartCount');
        if (cartCountElement) {
            cartCountElement.textContent = count;
            if(count > 0) {
                cartCountElement.classList.remove('hide-badge');
            } else {
                cartCountElement.classList.add('hide-badge');
            }
        }
    }
    
    function updateWishlistCount() {
        let count = wishlist.length;
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        if (wishlistCountElement) {
            if (count > 0) {
                wishlistCountElement.textContent = count;
                wishlistCountElement.classList.remove('hide-badge');
            } else {
                wishlistCountElement.textContent = '';
                wishlistCountElement.classList.add('hide-badge');
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
        localStorage.removeItem('wishlist_permanent_hide');
        
        let count = wishlist.length;
        let wishlistCountElement = document.getElementById('navbarWishlistCount');
        if (wishlistCountElement && count > 0) {
            wishlistCountElement.style.display = '';
            wishlistCountElement.textContent = count;
            wishlistCountElement.classList.remove('hide-badge');
        } else {
            wishlistCountElement.style.display = 'none';
        }
    }
    
    function addToCart(id, name, price, imageUrl) {
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
    
    function buyNow(productId, productName, productPrice) {
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
    
    // Load categories from database
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
                <div class="col-md-2 col-6">
                    <div class="category-card" onclick="filterCategory(${cat.id})">
                        <div class="category-icon"><i class="${cat.icon}"></i></div>
                        <h6>${cat.name}</h6>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }
    
    // Load products from database with image slider - Click goes to product detail page
    async function loadProducts() {
        const loader = document.getElementById('productsLoader');
        const container = document.getElementById('productsContainer');
        if (loader) loader.style.display = 'block';
        
        try {
            const response = await fetch('/api/products');
            const products = await response.json();
            if (loader) loader.style.display = 'none';
            
            if (products.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products available</div></div>';
                return;
            }
            
            container.innerHTML = products.map(product => {
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
                
                return `
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card card">
                            ${discountBadge}
                            <button class="wishlist-btn" onclick="toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrls[0]}')">
                                <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                            </button>
                            
                            <div id="${carouselId}" class="carousel slide product-image-slider" data-bs-ride="false">
                                <div class="carousel-inner">
                                    ${imageUrls.map((imgUrl, idx) => `
                                        <div class="carousel-item ${idx === 0 ? 'active' : ''}">
                                            <a href="/product/${product.id}" style="display: block; text-decoration: none;">
                                                <img src="${imgUrl}" class="d-block w-100 product-image" alt="${product.name}" style="height: 200px; object-fit: cover; cursor: pointer;">
                                            </a>
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
                            
                            <div class="card-body text-center">
                                <a href="/product/${product.id}" style="text-decoration: none; color: inherit;">
                                    <h5 class="card-title">${product.name}</h5>
                                </a>
                                <p class="text-muted">${product.category ? product.category.name : 'Uncategorized'}</p>
                                <div>
                                    ${oldPriceHtml}
                                    <span class="product-price">₹${parseFloat(displayPrice).toLocaleString()}</span>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-add-cart" onclick="addToCart(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrls[0]}')">
                                        <i class="fas fa-shopping-cart"></i> Add
                                    </button>
                                    <button class="btn-buy-now" onclick="buyNow(${product.id}, '${escapeName}', ${displayPrice})">
                                        <i class="fas fa-bolt"></i> Buy Now
                                    </button>
                                </div>
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
    
    // Load best sellers
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
                    ${products.map((product, index) => `
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
    
    // Search products
    async function searchProducts() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        if (!searchTerm) {
            loadProducts();
            return;
        }
        
        const loader = document.getElementById('productsLoader');
        const container = document.getElementById('productsContainer');
        if (loader) loader.style.display = 'block';
        
        try {
            const response = await fetch(`/api/products/search?q=${encodeURIComponent(searchTerm)}`);
            const products = await response.json();
            if (loader) loader.style.display = 'none';
            
            if (products.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products found matching your search</div></div>';
                return;
            }
            
            container.innerHTML = products.map(product => {
                const displayPrice = product.discount_price ? product.discount_price : product.price;
                const imageUrl = product.image ? '/storage/' + product.image : 'https://via.placeholder.com/300x200?text=No+Image';
                const isInWishlist = wishlist.some(item => item.id === product.id);
                const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                const escapeName = product.name.replace(/'/g, "\\'");
                
                return `
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card card">
                            <button class="wishlist-btn" onclick="toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrl}')">
                                <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                            </button>
                            <a href="/product/${product.id}" style="display: block;">
                                <img src="${imageUrl}" class="product-image" alt="${product.name}" style="height: 200px; object-fit: cover; width: 100%;">
                            </a>
                            <div class="card-body text-center">
                                <a href="/product/${product.id}" style="text-decoration: none; color: inherit;">
                                    <h5 class="card-title">${product.name}</h5>
                                </a>
                                <p class="text-muted">${product.category ? product.category.name : 'Uncategorized'}</p>
                                <span class="product-price">₹${parseFloat(displayPrice).toLocaleString()}</span>
                                <div class="product-actions mt-3">
                                    <button class="btn-add-cart" onclick="addToCart(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrl}')">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                    <button class="btn-buy-now" onclick="buyNow(${product.id}, '${escapeName}', ${displayPrice})">
                                        <i class="fas fa-bolt"></i> Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            loadWishlistStatus();
        } catch (error) {
            console.error('Error searching products:', error);
            if (loader) loader.style.display = 'none';
        }
    }
    
    // Filter by category
    async function filterCategory(categoryId) {
        const loader = document.getElementById('productsLoader');
        const container = document.getElementById('productsContainer');
        if (loader) loader.style.display = 'block';
        
        try {
            const response = await fetch(`/api/products/category/${categoryId}`);
            const products = await response.json();
            if (loader) loader.style.display = 'none';
            
            if (products.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products in this category</div></div>';
                return;
            }
            
            container.innerHTML = products.map(product => {
                const displayPrice = product.discount_price ? product.discount_price : product.price;
                const imageUrl = product.image ? '/storage/' + product.image : 'https://via.placeholder.com/300x200?text=No+Image';
                const isInWishlist = wishlist.some(item => item.id === product.id);
                const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                const escapeName = product.name.replace(/'/g, "\\'");
                
                return `
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card card">
                            <button class="wishlist-btn" onclick="toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrl}')">
                                <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                            </button>
                            <a href="/product/${product.id}" style="display: block;">
                                <img src="${imageUrl}" class="product-image" alt="${product.name}" style="height: 200px; object-fit: cover; width: 100%;">
                            </a>
                            <div class="card-body text-center">
                                <a href="/product/${product.id}" style="text-decoration: none; color: inherit;">
                                    <h5 class="card-title">${product.name}</h5>
                                </a>
                                <span class="product-price">₹${parseFloat(displayPrice).toLocaleString()}</span>
                                <div class="product-actions mt-3">
                                    <button class="btn-add-cart" onclick="addToCart(${product.id}, '${escapeName}', ${displayPrice}, '${imageUrl}')">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                    <button class="btn-buy-now" onclick="buyNow(${product.id}, '${escapeName}', ${displayPrice})">
                                        <i class="fas fa-bolt"></i> Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            loadWishlistStatus();
        } catch (error) {
            console.error('Error filtering products:', error);
            if (loader) loader.style.display = 'none';
        }
    }
    
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        loadBanners();
        wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        loadCategories();
        loadProducts();
        loadBestSellers();
        updateCartCount();
        checkAndHideWishlistCountIfViewed();
    });
</script>
@endsection