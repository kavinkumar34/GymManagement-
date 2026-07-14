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

        .wishlist-header {
            padding: 30px 0 20px 0;
            border-bottom: 1px solid #eef2f6;
            margin-bottom: 30px;
        }

        .wishlist-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .wishlist-header h2 i {
            color: #dc3545;
        }

        .wishlist-header p {
            color: #64748b;
            font-size: 15px;
            margin-top: 5px;
        }

        /* ===== PRODUCT CARD - SAME AS HOME PAGE ===== */
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

        /* Remove from wishlist button - similar to wishlist-btn on home */
        .remove-wishlist-btn {
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
            color: #dc3545;
        }

        .remove-wishlist-btn i {
            font-size: 1rem;
            transition: all 0.3s;
        }

        .remove-wishlist-btn:hover {
            transform: scale(1.1);
            background: #dc3545;
            color: white;
        }

        .product-card .card-body {
            padding: 12px 15px 15px;
            text-align: left;
        }

        /* ===== PRODUCT BRAND - SAME AS HOME ===== */
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

        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .btn-add-cart-wishlist {
            background: #000000;
            border: none;
            border-radius: 25px;
            padding: 6px 15px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.75rem;
            flex: 1;
        }

        .btn-add-cart-wishlist:hover {
            background: #dc3545;
        }

        .btn-buy-now-wishlist {
            background: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 6px 15px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.75rem;
            flex: 1;
        }

        .btn-buy-now-wishlist:hover {
            background: #000000;
        }

        /* Empty wishlist */
        .empty-wishlist {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-wishlist i {
            font-size: 4rem;
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        .empty-wishlist h4 {
            color: #1a1a2e;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-wishlist p {
            color: #999;
            margin-bottom: 20px;
        }

        .btn-shop-now {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-shop-now:hover {
            background: #000000;
            color: white;
        }

        /* ===== CUSTOM CONFIRMATION NOTIFICATION ===== */
        .confirm-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 320px;
            max-width: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 20px 25px;
            animation: slideInRight 0.3s ease;
            border-left: 5px solid #dc3545;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .confirm-notification .notif-icon {
            width: 45px;
            height: 45px;
            background: #dc3545;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .confirm-notification .notif-content {
            flex: 1;
        }

        .confirm-notification .notif-title {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .confirm-notification .notif-message {
            font-size: 13px;
            color: #64748b;
        }

        .confirm-notification .notif-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .confirm-notification .btn-notif-confirm {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .confirm-notification .btn-notif-confirm:hover {
            background: #bd2130;
        }

        .confirm-notification .btn-notif-cancel {
            background: #e2e8f0;
            color: #64748b;
            border: none;
            border-radius: 20px;
            padding: 6px 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .confirm-notification .btn-notif-cancel:hover {
            background: #cbd5e1;
        }

        .confirm-notification .notif-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            color: #999;
            cursor: pointer;
            transition: all 0.3s;
        }

        .confirm-notification .notif-close:hover {
            color: #dc3545;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .wishlist-header h2 {
                font-size: 22px;
            }

            .product-image-container {
                height: 200px;
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

            .product-actions {
                flex-direction: column;
            }

            .btn-add-cart-wishlist,
            .btn-buy-now-wishlist {
                width: 100%;
            }

            .confirm-notification {
                min-width: 280px;
                max-width: 90%;
                right: 10px;
                top: 10px;
                padding: 15px 20px;
            }
        }

        @media (max-width: 576px) {
            .product-image-container {
                height: 160px;
            }

            .product-card .product-name {
                font-size: 0.7rem;
                min-height: 25px;
            }

            .product-price-container .final-price {
                font-size: 0.85rem;
            }

            .product-brand {
                font-size: 0.6rem;
            }

            .confirm-notification {
                min-width: auto;
                width: 90%;
                right: 5%;
                top: 10px;
                padding: 15px;
            }

            .confirm-notification .notif-actions {
                flex-direction: column;
            }

            .confirm-notification .btn-notif-confirm,
            .confirm-notification .btn-notif-cancel {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="container">
        <!-- Wishlist Header -->
        <div class="wishlist-header">
            <h2><i class="fas fa-heart"></i> My Wishlist</h2>
            <p>Products you've saved for later</p>
        </div>

        <!-- Wishlist Products Container -->
        <div id="wishlistContainer" class="row"></div>

        <!-- Empty Wishlist Message -->
        <div id="emptyWishlist" class="empty-wishlist" style="display: none;">
            <i class="fas fa-heart-broken"></i>
            <h4>Your wishlist is empty</h4>
            <p>Start adding items to your wishlist by clicking the heart icon on products.</p>
            <a href="{{ url('/') }}" class="btn-shop-now">Continue Shopping</a>
        </div>
    </div>

    <script>
        // ===== WISHLIST DATA =====
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let pendingRemoveId = null;
        let pendingRemoveName = '';

        // ===== CONFIRMATION NOTIFICATION =====
        function showConfirmNotification(id, name) {
            pendingRemoveId = id;
            pendingRemoveName = name;

            // Remove existing notification if any
            const existing = document.querySelector('.confirm-notification');
            if (existing) {
                existing.remove();
            }

            const notification = document.createElement('div');
            notification.className = 'confirm-notification';
            notification.id = 'confirmNotification';
            notification.innerHTML = `
                <button class="notif-close" onclick="closeConfirmNotification()">✕</button>
                <div style="display:flex; gap:15px; align-items:flex-start;">
                    <div class="notif-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-title">Remove from Wishlist?</div>
                        <div class="notif-message">Are you sure you want to remove "<strong>${name}</strong>" from your wishlist?</div>
                        <div class="notif-actions">
                            <button class="btn-notif-confirm" onclick="confirmRemove()">
                                <i class="fas fa-trash-alt me-1"></i> Remove
                            </button>
                            <button class="btn-notif-cancel" onclick="closeConfirmNotification()">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto close after 10 seconds if no action
            setTimeout(() => {
                closeConfirmNotification();
            }, 10000);
        }

        function closeConfirmNotification() {
            const notification = document.getElementById('confirmNotification');
            if (notification) {
                notification.style.animation = 'slideInRight 0.3s ease reverse';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
            pendingRemoveId = null;
            pendingRemoveName = '';
        }

        function confirmRemove() {
            if (pendingRemoveId !== null) {
                removeFromWishlist(pendingRemoveId);
                closeConfirmNotification();
            }
        }

        // ===== UPDATE WISHLIST COUNT =====
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

        // ===== UPDATE CART COUNT =====
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

        // ===== SHOW NOTIFICATION =====
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

   

       

        // ===== REMOVE FROM WISHLIST =====
        function removeFromWishlist(id) {
            wishlist = wishlist.filter(item => item.id !== id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));

            // Update the heart icon on home page if exists
            const heartIcon = document.getElementById(`wishlist-icon-${id}`);
            if (heartIcon) heartIcon.className = 'far fa-heart';

            loadWishlist();
            updateWishlistCount();
            showNotification('Removed from wishlist', 'info');
        }

        // ===== OPEN REMOVE CONFIRMATION =====
        function openRemoveConfirm(id, name) {
            showConfirmNotification(id, name);
        }

        // ===== GO TO PRODUCT DETAIL =====
        function goToProductDetail(productId, event) {
            if (event && (event.target.closest('.remove-wishlist-btn') ||
                    event.target.closest('.btn-add-cart-wishlist') ||
                    event.target.closest('.btn-buy-now-wishlist'))) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        // ===== GET VARIANT DATA =====
        function getVariantData(product) {
            if (product.variants && product.variants.length > 0) {
                const firstVariant = product.variants[0];

                let totalStock = 0;
                product.variants.forEach(v => {
                    totalStock += parseInt(v.stock) || 0;
                });

                // Use total_price as original price, final_price as discounted price
                const originalPrice = parseFloat(firstVariant.total_price) || parseFloat(firstVariant.mrp) || parseFloat(
                    firstVariant.price) || 0;
                const displayPrice = parseFloat(firstVariant.final_price) || parseFloat(firstVariant.price) || 0;

                return {
                    hasVariant: true,
                    price: displayPrice,
                    originalPrice: originalPrice,
                    discountType: firstVariant.discount_type || 'flat',
                    discountValue: parseFloat(firstVariant.discount_value) || 0,
                    totalStock: totalStock
                };
            }

            // Normal product
            const originalPrice = parseFloat(product.total_price) || parseFloat(product.mrp) || parseFloat(product.price) ||
                0;
            const displayPrice = parseFloat(product.final_price) || parseFloat(product.price) || 0;

            return {
                hasVariant: false,
                price: displayPrice,
                originalPrice: originalPrice,
                discountType: product.discount_type || 'flat',
                discountValue: parseFloat(product.discount_value) || 0,
                totalStock: parseInt(product.stock) || 0
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

            if (discountValue > 0 && originalPrice > 0) {
                hasDiscount = true;
                const discountAmount = originalPrice - displayPrice;
                const discountPercent = Math.round((discountAmount / originalPrice) * 100);

                if (discountType === 'flat') {
                    discountDisplay = '₹' + discountValue.toFixed(2) + ' off';
                } else if (discountType === 'percentage') {
                    discountDisplay = discountValue + '% off';
                } else {
                    discountDisplay = '₹' + discountValue.toFixed(2) + ' off';
                }
            } else if (originalPrice > 0 && displayPrice > 0 && displayPrice < originalPrice) {
                hasDiscount = true;
                const discountPercent = Math.round(((originalPrice - displayPrice) / originalPrice) * 100);
                discountDisplay = discountPercent + '% off';
            }

            return {
                originalPrice: originalPrice,
                displayPrice: displayPrice,
                discountDisplay: discountDisplay,
                hasDiscount: hasDiscount && discountDisplay !== ''
            };
        }

        // ===== GET PRODUCT IMAGES =====
        function getProductImages(product) {
            let images = [];

            // Check variant images first
            if (product.variants && product.variants.length > 0) {
                const firstVariant = product.variants[0];
                if (product.product_images && product.product_images.length > 0) {
                    const variantImages = product.product_images.filter(img => img.variant_id == firstVariant.id);
                    if (variantImages.length > 0) {
                        const sortedImages = [...variantImages].sort((a, b) => {
                            if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                            return (a.display_order || 0) - (b.display_order || 0);
                        });
                        images = sortedImages.map(img => '/storage/' + img.image_path);
                    }
                }
            }

            // Check all_images from API
            if (images.length === 0 && product.all_images && product.all_images.length > 0) {
                images = product.all_images.map(img => {
                    if (img.startsWith('http')) return img;
                    return '/storage/' + img;
                });
            }

            // Check product.image field
            if (images.length === 0 && product.image) {
                if (product.image.startsWith('http')) {
                    images.push(product.image);
                } else {
                    images.push('/storage/' + product.image);
                }
            }

            // Fallback
            if (images.length === 0) {
                images.push('https://via.placeholder.com/300x300?text=No+Image');
            }

            return images;
        }

        // ===== LOAD WISHLIST =====
        async function loadWishlist() {
            const container = document.getElementById('wishlistContainer');
            const emptyDiv = document.getElementById('emptyWishlist');

            if (wishlist.length === 0) {
                container.style.display = 'none';
                emptyDiv.style.display = 'block';
                return;
            }

            container.style.display = 'flex';
            emptyDiv.style.display = 'none';

            let wishlistItems = [];

            try {
                const response = await fetch('/api/products');
                const products = await response.json();

                wishlistItems = wishlist.map(item => {
                    const product = products.find(p => p.id === item.id);
                    if (product) {
                        const variantData = getVariantData(product);
                        const priceData = {
                            originalPrice: variantData.originalPrice,
                            price: variantData.price,
                            discountType: variantData.discountType,
                            discountValue: variantData.discountValue
                        };
                        const discount = calculateDiscount(priceData);

                        const images = getProductImages(product);
                        const firstImage = images.length > 0 ? images[0] :
                            'https://via.placeholder.com/300x300?text=No+Image';

                        let brandName = '';
                        if (product.brand) {
                            brandName = product.brand.name || '';
                        } else if (product.brand_name) {
                            brandName = product.brand_name;
                        }

                        let brandHtml = '';
                        if (brandName) {
                            brandHtml = `
                                <div class="product-brand">
                                    <i class="fas fa-tag"></i>
                                    ${brandName}
                                </div>
                            `;
                        }

                        let stockHtml = '';
                        const totalStock = variantData.totalStock || 0;
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

                        let priceHtml = '';
                        if (discount.hasDiscount && discount.originalPrice > 0 && discount.displayPrice > 0) {
                            priceHtml = `
                                <div class="product-price-container">
                                    <span class="final-price">₹${discount.displayPrice.toFixed(2)}</span>
                                    <span class="original-price">₹${discount.originalPrice.toFixed(2)}</span>
                                    <span class="discount-percent">${discount.discountDisplay}</span>
                                </div>
                            `;
                        } else {
                            priceHtml = `
                                <div class="product-price-container">
                                    <span class="final-price">₹${discount.displayPrice.toFixed(2)}</span>
                                </div>
                            `;
                        }

                        const variantBadge = (product.variants && product.variants.length > 0) ?
                            `<span style="position:absolute;bottom:10px;right:10px;background:#0d6efd;color:white;padding:2px 8px;border-radius:4px;font-size:10px;z-index:1;">${product.variants.length} Variants</span>` :
                            '';

                        const escapeName = product.name.replace(/'/g, "\\'");

                        return {
                            id: product.id,
                            name: product.name,
                            escapeName: escapeName,
                            image: firstImage,
                            price: discount.displayPrice,
                            brandHtml: brandHtml,
                            priceHtml: priceHtml,
                            stockHtml: stockHtml,
                            variantBadge: variantBadge,
                            hasDiscount: discount.hasDiscount,
                            discountDisplay: discount.discountDisplay
                        };
                    }
                    return null;
                }).filter(item => item !== null);

            } catch (error) {
                console.error('Error fetching product details:', error);
                // Fallback: use basic data from localStorage
                wishlistItems = wishlist.map(item => {
                    const price = parseFloat(item.price) || 0;
                    return {
                        id: item.id,
                        name: item.name,
                        escapeName: item.name.replace(/'/g, "\\'"),
                        image: item.image || 'https://via.placeholder.com/300x300?text=No+Image',
                        price: price,
                        brandHtml: '',
                        priceHtml: `
                            <div class="product-price-container">
                                <span class="final-price">₹${price.toFixed(2)}</span>
                            </div>
                        `,
                        stockHtml: '',
                        variantBadge: '',
                        hasDiscount: false,
                        discountDisplay: ''
                    };
                });
            }

            // Render wishlist items
            container.innerHTML = wishlistItems.map(item => `
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="product-card card" onclick="goToProductDetail(${item.id}, event)">
                        ${item.hasDiscount && item.price > 0 ? `<div class="discount-badge">${item.discountDisplay}</div>` : ''}
                        ${item.variantBadge}
                        <button class="remove-wishlist-btn" onclick="event.stopPropagation(); openRemoveConfirm(${item.id}, '${item.escapeName}')" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <div class="product-image-container">
                            <img src="${item.image}" alt="${item.name}" 
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjQwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+TG9hZCBFcnJvcjwvdGV4dD48L3N2Zz4='"
                                loading="lazy">
                        </div>
                        
                        <div class="card-body">
                            ${item.brandHtml}
                            <div class="product-name">${item.name}</div>
                            ${item.priceHtml}
                            ${item.stockHtml}
                            
                         
                        </div>
                    </div>
                </div>
            `).join('');

            updateWishlistCount();
        }

        // ===== INITIALIZE =====
        document.addEventListener('DOMContentLoaded', function() {
            wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            cart = JSON.parse(localStorage.getItem('cart')) || [];
            loadWishlist();
            updateCartCount();
            updateWishlistCount();
        });
    </script>
@endsection
