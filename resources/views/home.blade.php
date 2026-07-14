@extends('layouts.app')

@section('content')
    <style>
        /* ===== PREVENT HORIZONTAL SCROLL ===== */
        html,
        body {
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
            background: rgba(0, 0, 0, 0.3);
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

        /* ===== PRODUCT CARD - VD LOOKS STYLE ===== */
        .product-card {
            border: 1px solid #eee;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            margin-bottom: 25px;
            height: 100%;
            position: relative;
            background: white;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .product-image-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
            background: #f8f9fa;
            position: relative;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
            background: #ffffff;
            padding: 10px;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.03);
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
        }

        .wishlist-btn i {
            font-size: 1rem;
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

        .product-card .card-body {
            padding: 12px 15px 15px;
            text-align: left;
        }

        /* ===== PRODUCT BRAND - NEW ===== */
        .product-brand {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 2px;
            text-align: left;
            letter-spacing: 0.3px;
        }

        .product-brand i {
            font-size: 0.65rem;
            margin-right: 4px;
            color: #6c757d;
        }

        .product-card .product-name {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 4px;
            color: #1e293b;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 40px;
            text-align: left;
        }

        /* Price container - VD LOOKS style */
        .product-price-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 2px;
        }

        .product-price-container .final-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .product-price-container .original-price {
            font-size: 0.85rem;
            color: #999;
            text-decoration: line-through;
        }

        .product-price-container .discount-percent {
            background: #dc3545;
            color: white;
            padding: 1px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .product-stock-low {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 6px;
            text-align: left;
            font-weight: 600;
        }

        .product-stock-low i {
            font-size: 0.8rem;
            margin-right: 4px;
            color: #dc3545;
        }

        .product-stock-out {
            font-size: 0.8rem;
            color: #999;
            margin-top: 6px;
            text-align: left;
            font-weight: 500;
            background: #f5f5f5;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .product-stock-out i {
            font-size: 0.8rem;
            margin-right: 4px;
            color: #999;
        }

        /* REMOVED RATING - NO STARS */
        .product-rating {
            display: none !important;
        }

        /* ===== CATEGORY CARD ===== */
        .category-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
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
            background: rgba(0, 0, 0, 0.3);
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

        .category-row>[class*="col-"] {
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .no-products {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
        }

        /* Placeholder image style */
        .placeholder-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            color: #999;
            font-size: 14px;
            flex-direction: column;
        }

        .placeholder-image i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 8px;
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

            .product-image-container {
                height: 200px;
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

            .product-image-container {
                height: 160px;
            }

            .product-card .product-name {
                font-size: 0.75rem;
                min-height: 30px;
            }

            .product-price-container .final-price {
                font-size: 0.95rem;
            }

            .product-brand {
                font-size: 0.65rem;
            }
        }
    </style>

    <!-- ===== FULL WIDTH BANNER - NO GAPS ===== -->
    <div class="banner-full-width">
        <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner" id="bannerContainer">
                <div class="carousel-item active">
                    <div
                        style="height:550px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;width:100%;">
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

    <script>
        // ===== BANNER LOADING =====
        async function loadBanners() {
            try {
                const response = await fetch('/api/banners');
                const banners = await response.json();
                const bannerContainer = document.getElementById('bannerContainer');
                if (!bannerContainer) return;

                if (banners.length === 0) {
                    bannerContainer.innerHTML =
                        '<div class="carousel-item active"><div style="height:450px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:white;width:100%;"><i class="fas fa-image fa-2x"></i> <span class="ms-2">No Banners Available</span></div></div>';
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
                if (count > 0) {
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
            @if (!auth()->check())
                if (confirm('Please login to add items to wishlist. Go to login page?')) {
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

            @if (!auth()->check())
                if (confirm('Please login to add products to cart. Go to login page?')) {
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

            if (existingItem) {
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

            @if (!auth()->check())
                if (confirm('Please login to purchase. Go to login page?')) {
                    window.location.href = "{{ route('login') }}";
                }
                return;
            @endif

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('buy.now') }}';

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
                event.target.closest('.btn-buy-now')) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        function showNotification(message, type) {
            let notification = document.createElement('div');
            notification.className = 'alert alert-' + (type === 'success' ? 'success' : 'info') +
                ' alert-dismissible fade show';
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '250px';
            notification.innerHTML = '<i class="fas fa-check-circle"></i> ' + message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
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

        // ===== FIXED: GET PRODUCT IMAGES (Supports Variants) =====
        function getProductImages(product) {
            let images = [];

            // DEBUG: Log the product data
            console.log('🔍 Product:', product.id, product.name);
            console.log('  - Variants:', product.variants ? product.variants.length : 0);
            console.log('  - Images:', product.product_images ? product.product_images.length : 0);

            // 1. CHECK VARIANT IMAGES FIRST
            if (product.variants && product.variants.length > 0) {
                // Get the first variant
                const firstVariant = product.variants[0];
                console.log('  - First Variant ID:', firstVariant.id);

                // Check if product_images has variant_id matching
                if (product.product_images && product.product_images.length > 0) {
                    // Filter images for this variant
                    const variantImages = product.product_images.filter(img => img.variant_id == firstVariant.id);
                    console.log('  - Variant Images Found:', variantImages.length);

                    if (variantImages.length > 0) {
                        // Sort by is_main (main image first)
                        const sortedImages = [...variantImages].sort((a, b) => {
                            if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                            return (a.display_order || 0) - (b.display_order || 0);
                        });
                        images = sortedImages.map(img => '/storage/' + img.image_path);
                        console.log('  - Using variant images:', images);
                    }
                }
            }

            // 2. If no variant images, check product_images without variant_id (normal product)
            if (images.length === 0 && product.product_images && product.product_images.length > 0) {
                // Filter images that don't have variant_id or variant_id is null
                const normalImages = product.product_images.filter(img => !img.variant_id || img.variant_id === null || img
                    .variant_id === 0);
                if (normalImages.length > 0) {
                    const sortedImages = [...normalImages].sort((a, b) => {
                        if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                        return (a.display_order || 0) - (b.display_order || 0);
                    });
                    images = sortedImages.map(img => '/storage/' + img.image_path);
                    console.log('  - Using normal product images:', images);
                } else {
                    // If all images have variant_id, try to get any image
                    const anyImages = [...product.product_images].sort((a, b) => {
                        if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                        return (a.display_order || 0) - (b.display_order || 0);
                    });
                    if (anyImages.length > 0) {
                        images = anyImages.map(img => '/storage/' + img.image_path);
                        console.log('  - Using any product image:', images);
                    }
                }
            }

            // 3. Check all_images from API
            if (images.length === 0 && product.all_images && product.all_images.length > 0) {
                images = product.all_images.map(img => {
                    if (img.startsWith('http')) return img;
                    return '/storage/' + img;
                });
                console.log('  - Using all_images:', images);
            }

            // 4. Check product.image field
            if (images.length === 0 && product.image) {
                if (product.image.startsWith('http')) {
                    images.push(product.image);
                } else {
                    images.push('/storage/' + product.image);
                }
                console.log('  - Using product.image:', images);
            }

            // 5. Check image_url
            if (images.length === 0 && product.image_url) {
                images.push(product.image_url);
                console.log('  - Using image_url:', images);
            }

            // 6. Fallback - Show a colored placeholder with product name
            if (images.length === 0) {
                // Use inline SVG placeholder instead of external URL
                const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF8A5C', '#A29BFE'];
                const colorIndex = (product.id || 1) % colors.length;
                const bgColor = colors[colorIndex];
                const text = product.name ? product.name.substring(0, 2).toUpperCase() : '?';

                // Create a data URL for the placeholder
                const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
                    <rect width="300" height="300" fill="${bgColor}" opacity="0.3"/>
                    <rect x="50" y="50" width="200" height="200" fill="${bgColor}" rx="10"/>
                    <text x="150" y="175" font-family="Arial" font-size="80" fill="${bgColor}" text-anchor="middle" dominant-baseline="central">${text}</text>
                    <text x="150" y="250" font-family="Arial" font-size="14" fill="#999" text-anchor="middle">${product.name || 'Product'}</text>
                </svg>`;

                const encoded = btoa(svg);
                const dataUrl = `data:image/svg+xml;base64,${encoded}`;
                images.push(dataUrl);
                console.log('  - Using SVG placeholder with color:', bgColor);
            }

            return images;
        }

        // ===== GET VARIANT DATA =====
    // ===== GET VARIANT DATA =====
function getVariantData(product) {
    // If product has variants, use the first variant's data
    if (product.variants && product.variants.length > 0) {
        const firstVariant = product.variants[0];

        // Get variant images
        let variantImages = [];
        if (product.product_images && product.product_images.length > 0) {
            // Filter images for this variant
            const variantImageObjs = product.product_images.filter(img => img.variant_id == firstVariant.id);
            if (variantImageObjs.length > 0) {
                const sortedImages = [...variantImageObjs].sort((a, b) => {
                    if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                    return (a.display_order || 0) - (b.display_order || 0);
                });
                variantImages = sortedImages.map(img => '/storage/' + img.image_path);
            }
        }

        // If no variant images, check product_images without variant_id
        if (variantImages.length === 0 && product.product_images && product.product_images.length > 0) {
            const normalImages = product.product_images.filter(img => !img.variant_id || img.variant_id === null ||
                img.variant_id === 0);
            if (normalImages.length > 0) {
                const sortedImages = [...normalImages].sort((a, b) => {
                    if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                    return (a.display_order || 0) - (b.display_order || 0);
                });
                variantImages = sortedImages.map(img => '/storage/' + img.image_path);
            }
        }

        // Fallback to product.image
        if (variantImages.length === 0 && product.image) {
            variantImages.push('/storage/' + product.image);
        }

        if (variantImages.length === 0) {
            // Use placeholder
            const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF8A5C', '#A29BFE'];
            const colorIndex = (product.id || 1) % colors.length;
            const bgColor = colors[colorIndex];
            const text = product.name ? product.name.substring(0, 2).toUpperCase() : '?';
            const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
                <rect width="300" height="300" fill="${bgColor}" opacity="0.3"/>
                <rect x="50" y="50" width="200" height="200" fill="${bgColor}" rx="10"/>
                <text x="150" y="175" font-family="Arial" font-size="80" fill="${bgColor}" text-anchor="middle" dominant-baseline="central">${text}</text>
                <text x="150" y="250" font-family="Arial" font-size="14" fill="#999" text-anchor="middle">${product.name || 'Product'}</text>
            </svg>`;
            const encoded = btoa(svg);
            variantImages.push(`data:image/svg+xml;base64,${encoded}`);
        }

        // Calculate total stock from all variants
        let totalStock = 0;
        product.variants.forEach(v => {
            totalStock += parseInt(v.stock) || 0;
        });

        // ===== FIX: Use total_price as original price, final_price as discounted price =====
        const originalPrice = parseFloat(firstVariant.total_price) || parseFloat(firstVariant.mrp) || parseFloat(firstVariant.price) || 0;
        const displayPrice = parseFloat(firstVariant.final_price) || parseFloat(firstVariant.price) || 0;

        return {
            hasVariant: true,
            image: variantImages[0],
            allImages: variantImages,
            price: displayPrice,
            originalPrice: originalPrice,
            discountType: firstVariant.discount_type || 'flat',
            discountValue: parseFloat(firstVariant.discount_value) || 0,
            discountAmount: parseFloat(firstVariant.discount_amount) || 0,
            stock: parseInt(firstVariant.stock) || 0,
            totalStock: totalStock,
            gstPercentage: parseFloat(firstVariant.gst_percentage) || 0,
            gstAmount: parseFloat(firstVariant.gst_amount) || 0,
            variantId: firstVariant.id
        };
    }

    // Normal product (no variants)
    // ===== FIX: Use total_price as original price, final_price as discounted price =====
    const originalPrice = parseFloat(product.total_price) || parseFloat(product.mrp) || parseFloat(product.price) || 0;
    const displayPrice = parseFloat(product.final_price) || parseFloat(product.price) || 0;

    return {
        hasVariant: false,
        image: null,
        allImages: [],
        price: displayPrice,
        originalPrice: originalPrice,
        discountType: product.discount_type || 'flat',
        discountValue: parseFloat(product.discount_value) || 0,
        discountAmount: parseFloat(product.discount_amount) || 0,
        stock: parseInt(product.stock) || 0,
        totalStock: parseInt(product.stock) || 0,
        gstPercentage: parseFloat(product.gst_percentage) || 0,
        gstAmount: parseFloat(product.gst_amount) || 0,
        variantId: null
    };
}

    // ===== CALCULATE DISCOUNT =====
function calculateDiscount(priceData) {
    const originalPrice = priceData.originalPrice || 0;
    const displayPrice = priceData.price || 0;
    const discountType = priceData.discountType || 'flat';
    const discountValue = priceData.discountValue || 0;

    let discountDisplay = '';
    let hasDiscount = false;
    let finalPrice = displayPrice;

    // If discount_value > 0, show the discount based on type
    if (discountValue > 0 && originalPrice > 0) {
        hasDiscount = true;
        const discountAmount = originalPrice - displayPrice;
        const discountPercent = Math.round((discountAmount / originalPrice) * 100);
        
        if (discountType === 'flat') {
            discountDisplay = `₹${discountValue.toFixed(2)} off`;
        } else if (discountType === 'percentage') {
            discountDisplay = `${discountValue}% off`;
        } else {
            discountDisplay = `₹${discountValue.toFixed(2)} off`;
        }
    }
    // If no discount_value but final price is less than original
    else if (originalPrice > 0 && displayPrice > 0 && displayPrice < originalPrice) {
        hasDiscount = true;
        const discountPercent = Math.round(((originalPrice - displayPrice) / originalPrice) * 100);
        discountDisplay = `${discountPercent}% off`;
    }

    return {
        originalPrice: originalPrice,
        displayPrice: finalPrice,
        discountDisplay: discountDisplay,
        hasDiscount: hasDiscount && discountDisplay !== ''
    };
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

                console.log('📦 Total Products:', products.length);

                const allProducts = products.sort((a, b) => {
                    return (b.id || 0) - (a.id || 0);
                });

                if (allProducts.length === 0) {
                    container.innerHTML =
                        '<div class="col-12"><div class="no-products">No products available</div></div>';
                    return;
                }

                container.innerHTML = allProducts.map(product => {
                    // Get variant data (for variant products)
                    const variantData = getVariantData(product);

                    // Get product images - USE VARIANT IMAGES IF AVAILABLE
                    let imageUrls = [];
                    if (variantData.hasVariant && variantData.allImages.length > 0) {
                        imageUrls = variantData.allImages;
                    } else {
                        imageUrls = getProductImages(product);
                    }

                    const firstImage = imageUrls.length > 0 ? imageUrls[0] :
                        'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjUwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+Tm8gSW1hZ2U8L3RleHQ+PC9zdmc+';

                    // Use variant stock if available
                    const totalStock = variantData.totalStock || parseInt(product.stock) || 0;

                    const priceData = {
                        originalPrice: variantData.originalPrice,
                        price: variantData.price,
                        discountType: variantData.discountType,
                        discountValue: variantData.discountValue
                    };

                    // Calculate discount
                    const discount = calculateDiscount(priceData);
                    const displayPrice = discount.displayPrice;
                    const originalPrice = discount.originalPrice;
                    const discountDisplay = discount.discountDisplay;
                    const hasDiscount = discount.hasDiscount;

                    const isInWishlist = wishlist.some(item => item.id === product.id);
                    const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                    const escapeName = product.name.replace(/'/g, "\\'");

                    // ===== GET BRAND NAME =====
                    let brandName = '';
                    if (product.brand) {
                        brandName = product.brand.name || '';
                    } else if (product.brand_name) {
                        brandName = product.brand_name;
                    }

                    let stockHtml = '';
                    if (totalStock <= 5 && totalStock > 0) {
                        stockHtml = `
                        <div class="product-stock-low">
                            <i class="fas fa-exclamation-triangle"></i>
                            Only ${totalStock} left in stock!
                        </div>
                    `;
                    } else if (totalStock === 0) {
                        stockHtml = `
                        <div class="product-stock-out">
                            <i class="fas fa-times-circle"></i>
                            Out of Stock
                        </div>
                    `;
                    }

                    // Price HTML - VD LOOKS style
                    let priceHtml = '';
                    if (hasDiscount && originalPrice > 0 && displayPrice > 0) {
                        priceHtml = `
                        <div class="product-price-container">
                            <span class="final-price">₹${displayPrice.toFixed(2)}</span>
                            <span class="original-price">₹${originalPrice.toFixed(2)}</span>
                            <span class="discount-percent">${discountDisplay}</span>
                        </div>
                    `;
                    } else {
                        priceHtml = `
                        <div class="product-price-container">
                            <span class="final-price">₹${displayPrice.toFixed(2)}</span>
                        </div>
                    `;
                    }

                    // Variant indicator
                    const variantBadge = variantData.hasVariant ?
                        `<span style="position:absolute;bottom:10px;right:10px;background:#0d6efd;color:white;padding:2px 8px;border-radius:4px;font-size:10px;z-index:1;">${product.variants.length} Variants</span>` :
                        '';

                    // ===== BRAND HTML =====
                    let brandHtml = '';
                    if (brandName) {
                        brandHtml = `
                        <div class="product-brand">
                            <i class="fas fa-tag"></i>
                            ${brandName}
                        </div>
                    `;
                    }

                    return `
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                            ${hasDiscount && displayPrice > 0 ? `<div class="discount-badge">${discountDisplay}</div>` : ''}
                            ${variantBadge}
                            <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${firstImage}')">
                                <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                            </button>
                            
                            <div class="product-image-container">
                                <img src="${firstImage}" alt="${product.name}" 
                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjQwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+TG9hZCBFcnJvcjwvdGV4dD48L3N2Zz4='"
                                    loading="lazy">
                            </div>
                            
                            <div class="card-body">
                                ${brandHtml}
                                <div class="product-name">${product.name}</div>
                                ${priceHtml}
                                ${stockHtml}
                            </div>
                        </div>
                    </div>
                `;
                }).join('');

                loadWishlistStatus();

            } catch (error) {
                console.error('Error loading products:', error);
                if (loader) loader.style.display = 'none';
                container.innerHTML =
                    '<div class="col-12"><div class="no-products text-danger">Error loading products. Please try again.</div></div>';
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
