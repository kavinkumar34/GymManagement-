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

        /* ===== FULL WIDTH BANNER - SMOOTH ===== */
        .banner-full-width {
            width: 100%;
            margin: 0;
            padding: 0;
            position: relative;
            left: 0;
            right: 0;
            overflow: hidden;
            background: #f0f0f0;
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
            position: relative;
        }

        .banner-full-width .carousel-item {
            width: 100%;
            height: 500px;
            margin: 0;
            padding: 0;
            position: relative;
            overflow: hidden;
            background: #f0f0f0;
            transition: none;
        }

        .banner-full-width .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: transform 0.3s ease;
        }

        .banner-placeholder {
            width: 100%;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 1.2rem;
        }

        .banner-placeholder i {
            font-size: 2.5rem;
            margin-right: 12px;
        }

        .banner-full-width .carousel-control-prev,
        .banner-full-width .carousel-control-next {
            width: 44px;
            height: 44px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.4);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 10;
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

        .banner-full-width .carousel-indicators {
            bottom: 15px;
            z-index: 11;
        }

        .banner-full-width .carousel-indicators button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid white;
            background: transparent;
            opacity: 0.6;
            transition: all 0.3s;
            margin: 0 4px;
        }

        .banner-full-width .carousel-indicators button.active {
            background: white;
            opacity: 1;
            transform: scale(1.1);
        }

        /* ===== PRODUCT CARD ===== */
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

        /* ===== COLOR OPTIONS - WITH COLOR COUNT ===== */
        .color-options-container {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            margin-top: 6px;
            align-items: center;
        }

        .color-options-container .color-label {
            font-size: 0.65rem;
            color: #666;
            font-weight: 500;
            margin-right: 2px;
        }

        .color-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .color-dot:hover {
            transform: scale(1.15);
            border-color: #dc3545;
        }

        .color-dot.more-colors {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #f0f0f0;
            border: 2px solid #e0e0e0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: #666;
            font-weight: 600;
            cursor: pointer;
        }

        .color-dot.more-colors:hover {
            border-color: #dc3545;
            background: #dc3545;
            color: white;
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

        /* ============================================================ */
        /* ===== CUSTOM ALERT / TOAST STYLES ===== */
        /* ============================================================ */
        .custom-alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .custom-alert-overlay.show {
            display: flex;
        }

        .custom-alert-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px 35px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        .custom-alert-box .alert-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.2rem;
        }

        .custom-alert-box .alert-icon.warning {
            background: #fff3cd;
            color: #dc3545;
        }

        .custom-alert-box .alert-icon.success {
            background: #d4edda;
            color: #28a745;
        }

        .custom-alert-box .alert-icon.info {
            background: #d1ecf1;
            color: #17a2b8;
        }

        .custom-alert-box .alert-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .custom-alert-box .alert-message {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .custom-alert-box .alert-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .custom-alert-box .alert-btn {
            padding: 8px 24px;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .custom-alert-box .alert-btn-primary {
            background: #dc3545;
            color: white;
        }

        .custom-alert-box .alert-btn-primary:hover {
            background: #b02a37;
            transform: scale(1.02);
        }

        .custom-alert-box .alert-btn-secondary {
            background: #e2e8f0;
            color: #64748b;
        }

        .custom-alert-box .alert-btn-secondary:hover {
            background: #cbd5e1;
        }

        .custom-alert-box .alert-btn-success {
            background: #28a745;
            color: white;
        }

        .custom-alert-box .alert-btn-success:hover {
            background: #1e7e34;
            transform: scale(1.02);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        /* Mobile responsive */
        @media (max-width: 576px) {
            .custom-alert-box {
                padding: 25px 20px;
                max-width: 95%;
            }

            .custom-alert-box .alert-icon {
                width: 55px;
                height: 55px;
                font-size: 1.8rem;
            }

            .custom-alert-box .alert-title {
                font-size: 1rem;
            }

            .custom-alert-box .alert-message {
                font-size: 0.8rem;
            }

            .custom-alert-box .alert-btn {
                padding: 6px 18px;
                font-size: 0.8rem;
            }
        }

        /* ============================================================ */
        /* ===== RESPONSIVE ===== */
        /* ============================================================ */

        @media (max-width: 768px) {
            .banner-full-width .carousel-item {
                height: 320px;
            }

            .banner-placeholder {
                height: 320px;
                font-size: 1rem;
            }

            .banner-placeholder i {
                font-size: 2rem;
            }

            .category-image-wrapper {
                height: 220px;
            }

            .product-image-container {
                height: 200px;
            }

            .product-card .product-name {
                font-size: 0.8rem;
                min-height: 35px;
            }

            .product-price-container .final-price {
                font-size: 1rem;
            }

            .product-brand {
                font-size: 0.7rem;
            }

            .category-info h5 {
                font-size: 1.1rem;
            }

            .color-dot {
                width: 16px;
                height: 16px;
            }

            .color-dot.more-colors {
                width: 16px;
                height: 16px;
                font-size: 6px;
            }
        }

        @media (max-width: 576px) {
            .banner-full-width .carousel-item {
                height: 220px;
            }

            .banner-placeholder {
                height: 220px;
                font-size: 0.85rem;
            }

            .banner-placeholder i {
                font-size: 1.5rem;
            }

            .banner-full-width .carousel-control-prev,
            .banner-full-width .carousel-control-next {
                width: 32px;
                height: 32px;
            }

            .banner-full-width .carousel-control-prev {
                left: 8px;
            }

            .banner-full-width .carousel-control-next {
                right: 8px;
            }

            .banner-full-width .carousel-control-prev-icon,
            .banner-full-width .carousel-control-next-icon {
                width: 14px;
                height: 14px;
            }

            .category-image-wrapper {
                height: 180px;
            }

            .category-info {
                padding: 12px 15px;
            }

            .category-info h5 {
                font-size: 0.9rem;
                margin-bottom: 4px;
            }

            .category-info p {
                font-size: 0.75rem;
            }

            .product-image-container {
                height: 150px;
            }

            .product-card .card-body {
                padding: 8px 10px 12px;
            }

            .product-card .product-name {
                font-size: 0.7rem;
                min-height: 28px;
            }

            .product-brand {
                font-size: 0.6rem;
                margin-bottom: 1px;
            }

            .product-brand i {
                font-size: 0.55rem;
            }

            .product-price-container .final-price {
                font-size: 0.85rem;
            }

            .product-price-container .original-price {
                font-size: 0.7rem;
            }

            .product-price-container .discount-percent {
                font-size: 0.6rem;
                padding: 1px 6px;
            }

            .product-price-container {
                gap: 4px;
            }

            .discount-badge {
                font-size: 0.6rem;
                padding: 2px 8px;
                top: 6px;
                right: 6px;
            }

            .wishlist-btn {
                width: 28px;
                height: 28px;
                top: 6px;
                left: 6px;
            }

            .wishlist-btn i {
                font-size: 0.8rem;
            }

            .product-stock-low {
                font-size: 0.65rem;
                margin-top: 4px;
            }

            .product-stock-out {
                font-size: 0.65rem;
                margin-top: 4px;
                padding: 3px 8px;
            }

            .color-options-container {
                margin-top: 4px;
                gap: 4px;
            }

            .color-options-container .color-label {
                font-size: 0.55rem;
            }

            .color-dot {
                width: 14px;
                height: 14px;
                border-width: 1.5px;
            }

            .color-dot.more-colors {
                width: 14px;
                height: 14px;
                font-size: 5px;
                border-width: 1.5px;
            }

            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .category-row .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            h2 {
                font-size: 1.1rem !important;
            }

            .d-flex .btn-link {
                font-size: 0.75rem !important;
            }

            .banner-full-width .carousel-indicators button {
                width: 8px;
                height: 8px;
                margin: 0 3px;
            }
        }

        @media (max-width: 400px) {
            .banner-full-width .carousel-item {
                height: 180px;
            }

            .banner-placeholder {
                height: 180px;
                font-size: 0.75rem;
            }

            .banner-placeholder i {
                font-size: 1.2rem;
            }

            .product-image-container {
                height: 120px;
            }

            .product-card .product-name {
                font-size: 0.65rem;
                min-height: 24px;
            }

            .product-price-container .final-price {
                font-size: 0.75rem;
            }

            .product-brand {
                font-size: 0.55rem;
            }

            .color-dot {
                width: 12px;
                height: 12px;
            }

            .color-dot.more-colors {
                width: 12px;
                height: 12px;
                font-size: 4px;
            }

            .category-image-wrapper {
                height: 140px;
            }

            .category-info h5 {
                font-size: 0.75rem;
            }

            .category-info p {
                font-size: 0.65rem;
            }
        }
    </style>

    <!-- ===== CUSTOM ALERT OVERLAY ===== -->
    <div class="custom-alert-overlay" id="customAlertOverlay">
        <div class="custom-alert-box">
            <div class="alert-icon warning" id="alertIcon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-title" id="alertTitle">Login Required</div>
            <div class="alert-message" id="alertMessage">Please login to add items to wishlist!</div>
            <div class="alert-buttons" id="alertButtons">
                <button class="alert-btn alert-btn-secondary" onclick="closeCustomAlert()">Cancel</button>
                <a href="{{ route('login') }}" class="alert-btn alert-btn-primary" id="alertActionBtn">Login Now</a>
            </div>
        </div>
    </div>

    <!-- ===== FULL WIDTH BANNER ===== -->
    <div class="banner-full-width">
        <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner" id="bannerContainer">
                <div class="carousel-item active">
                    <div class="banner-placeholder">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Loading banners...</span>
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
            <a href="/shop" style="color: #dc3545 !important; font-size: 0.9rem;text-decoration:none;">View All →</a>
        </div>

        <div id="productsLoader" class="loader" style="display: none;">
            <i class="fas fa-spinner"></i>
            <p>Loading products...</p>
        </div>

        <div class="row" id="productsContainer"></div>
    </div>

    <script>
        // ================================================================
        // ===== CUSTOM ALERT FUNCTIONS =====
        // ================================================================

        function showCustomAlert(title, message, type = 'warning', buttonText = 'Login Now', buttonLink =
            '{{ route('login') }}') {
            const overlay = document.getElementById('customAlertOverlay');
            const icon = document.getElementById('alertIcon');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');
            const actionBtn = document.getElementById('alertActionBtn');

            // Set icon
            icon.className = 'alert-icon ' + type;
            if (type === 'warning') {
                icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            } else if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            } else if (type === 'info') {
                icon.innerHTML = '<i class="fas fa-info-circle"></i>';
            }

            titleEl.textContent = title;
            messageEl.textContent = message;

            if (buttonText && buttonLink) {
                actionBtn.textContent = buttonText;
                actionBtn.href = buttonLink;
                actionBtn.style.display = 'inline-block';
            } else {
                actionBtn.style.display = 'none';
            }

            overlay.classList.add('show');
        }

        function closeCustomAlert() {
            const overlay = document.getElementById('customAlertOverlay');
            overlay.classList.remove('show');
        }

        // Close alert on overlay click
        document.getElementById('customAlertOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomAlert();
            }
        });

        // ================================================================
        // ===== SHOW LOGIN REQUIRED ALERT =====
        // ================================================================

        function showLoginRequiredAlert() {
            showCustomAlert(
                '🔒 Login Required',
                'Please login to add items to wishlist!',
                'warning',
                'Login Now',
                '{{ route('login') }}'
            );
        }

        // ================================================================
        // ===== BANNER LOADING =====
        // ================================================================
        let bannerLoaded = false;

        async function loadBanners() {
            try {
                const response = await fetch('/api/banners');
                const banners = await response.json();
                const bannerContainer = document.getElementById('bannerContainer');
                if (!bannerContainer) return;

                if (!banners || banners.length === 0) {
                    bannerContainer.innerHTML = `
                        <div class="carousel-item active">
                            <div class="banner-placeholder" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-image"></i>
                                <span>No Banners Available</span>
                            </div>
                        </div>
                    `;
                    return;
                }

                let bannerHtml = '';
                banners.forEach((banner, index) => {
                    const isActive = index === 0 ? 'active' : '';
                    const imageUrl = banner.image_url || '';

                    bannerHtml += `
                        <div class="carousel-item ${isActive}">
                            ${banner.link ? `<a href="${banner.link}" target="_blank" style="display:block;width:100%;height:100%;">` : ''}
                                <img src="${imageUrl}" alt="Banner" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                            ${banner.link ? `</a>` : ''}
                        </div>
                    `;
                });

                bannerContainer.innerHTML = bannerHtml;

                const carouselElement = document.getElementById('bannerSlider');
                if (carouselElement) {
                    const existingInstance = bootstrap.Carousel.getInstance(carouselElement);
                    if (existingInstance) {
                        existingInstance.dispose();
                    }
                    new bootstrap.Carousel(carouselElement, {
                        interval: 5000,
                        pause: 'hover',
                        wrap: true,
                        touch: true,
                        ride: 'carousel'
                    });
                }

                bannerLoaded = true;

            } catch (error) {
                console.error('Error loading banners:', error);
                const bannerContainer = document.getElementById('bannerContainer');
                if (bannerContainer) {
                    bannerContainer.innerHTML = `
                        <div class="carousel-item active">
                            <div class="banner-placeholder" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>Failed to load banners</span>
                            </div>
                        </div>
                    `;
                }
            }
        }

        // ================================================================
        // ===== WISHLIST FUNCTIONS =====
        // ================================================================
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
                // Show custom alert instead of confirm
                showLoginRequiredAlert();
                return;
            @endif

            let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const existingIndex = currentWishlist.findIndex(item => item.id === id);
            const icon = document.getElementById(`wishlist-icon-${id}`);

            if (existingIndex !== -1) {
                currentWishlist.splice(existingIndex, 1);
                if (icon) icon.className = 'far fa-heart';
                showCustomToast('💔 Removed', 'Item removed from wishlist!', 'info');
            } else {
                currentWishlist.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    added_at: new Date().toISOString()
                });
                if (icon) icon.className = 'fas fa-heart';
                showCustomToast('❤️ Added', 'Item added to wishlist!', 'success');
            }

            localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
            wishlist = currentWishlist;
            updateWishlistCount();
        }

        function goToProductDetail(productId, event) {
            if (event.target.closest('.wishlist-btn') ||
                event.target.closest('.btn-add-cart') ||
                event.target.closest('.btn-buy-now')) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        // ===== CUSTOM TOAST NOTIFICATION =====
        function showCustomToast(title, message, type = 'info') {
            // Use the existing toast from app.blade.php if available
            if (typeof showNotification === 'function') {
                showNotification(message, type);
            } else {
                // Fallback simple toast
                let notification = document.createElement('div');
                notification.className = 'alert alert-' + (type === 'success' ? 'success' : 'info') +
                    ' alert-dismissible fade show';
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.zIndex = '99999';
                notification.style.minWidth = '250px';
                notification.style.boxShadow = '0 10px 30px rgba(0,0,0,0.15)';
                notification.style.borderRadius = '12px';
                notification.innerHTML = '<i class="fas fa-check-circle me-2"></i> ' + message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }
        }

        function goToCategoryProducts(categoryId, categoryName) {
            window.location.href = `/shop?category=${categoryId}&name=${encodeURIComponent(categoryName)}`;
        }

        // ================================================================
        // ===== LOAD CATEGORIES =====
        // ================================================================
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
                                `<img src="/storage/${cat.image}" alt="${cat.name}" loading="lazy">` : 
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

        // ================================================================
        // ===== GET PRODUCT IMAGES =====
        // ================================================================
        function getProductImages(product) {
            let images = [];

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

            if (images.length === 0 && product.product_images && product.product_images.length > 0) {
                const normalImages = product.product_images.filter(img => !img.variant_id || img.variant_id === null || img
                    .variant_id === 0);
                if (normalImages.length > 0) {
                    const sortedImages = [...normalImages].sort((a, b) => {
                        if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                        return (a.display_order || 0) - (b.display_order || 0);
                    });
                    images = sortedImages.map(img => '/storage/' + img.image_path);
                }
            }

            if (images.length === 0 && product.all_images && product.all_images.length > 0) {
                images = product.all_images.map(img => {
                    if (img.startsWith('http')) return img;
                    return '/storage/' + img;
                });
            }

            if (images.length === 0 && product.image) {
                if (product.image.startsWith('http')) {
                    images.push(product.image);
                } else {
                    images.push('/storage/' + product.image);
                }
            }

            if (images.length === 0) {
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
                images.push(`data:image/svg+xml;base64,${encoded}`);
            }

            return images;
        }

        // ================================================================
        // ===== GET VARIANT DATA WITH COLORS =====
        // ================================================================
        function getVariantData(product) {
            if (product.variants && product.variants.length > 0) {
                const firstVariant = product.variants[0];

                let variantImages = [];
                if (product.product_images && product.product_images.length > 0) {
                    const variantImageObjs = product.product_images.filter(img => img.variant_id == firstVariant.id);
                    if (variantImageObjs.length > 0) {
                        const sortedImages = [...variantImageObjs].sort((a, b) => {
                            if (a.is_main !== b.is_main) return b.is_main - a.is_main;
                            return (a.display_order || 0) - (b.display_order || 0);
                        });
                        variantImages = sortedImages.map(img => '/storage/' + img.image_path);
                    }
                }

                if (variantImages.length === 0 && product.image) {
                    variantImages.push('/storage/' + product.image);
                }

                if (variantImages.length === 0) {
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

                let colors = [];
                if (product.variants && product.variants.length > 0) {
                    const colorSet = new Set();
                    product.variants.forEach(variant => {
                        if (variant.color && variant.color.trim() !== '') {
                            colorSet.add(variant.color);
                        }
                    });
                    colors = Array.from(colorSet);
                }

                let totalStock = 0;
                product.variants.forEach(v => {
                    totalStock += parseInt(v.stock) || 0;
                });

                const originalPrice = parseFloat(firstVariant.total_price) || parseFloat(firstVariant.mrp) || parseFloat(
                    firstVariant.price) || 0;
                const displayPrice = parseFloat(firstVariant.final_price) || parseFloat(firstVariant.price) || 0;

                return {
                    hasVariant: true,
                    image: variantImages[0],
                    allImages: variantImages,
                    price: displayPrice,
                    originalPrice: originalPrice,
                    discountType: firstVariant.discount_type || 'flat',
                    discountValue: parseFloat(firstVariant.discount_value) || 0,
                    stock: parseInt(firstVariant.stock) || 0,
                    totalStock: totalStock,
                    variantId: firstVariant.id,
                    colors: colors,
                    variantCount: product.variants.length
                };
            }

            const originalPrice = parseFloat(product.total_price) || parseFloat(product.mrp) || parseFloat(product.price) ||
                0;
            const displayPrice = parseFloat(product.final_price) || parseFloat(product.price) || 0;

            return {
                hasVariant: false,
                image: null,
                allImages: [],
                price: displayPrice,
                originalPrice: originalPrice,
                discountType: product.discount_type || 'flat',
                discountValue: parseFloat(product.discount_value) || 0,
                stock: parseInt(product.stock) || 0,
                totalStock: parseInt(product.stock) || 0,
                variantId: null,
                colors: [],
                variantCount: 0
            };
        }

        // ================================================================
        // ===== CALCULATE DISCOUNT =====
        // ================================================================
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
                    discountDisplay = `₹${discountValue.toFixed(2)} off`;
                } else if (discountType === 'percentage') {
                    discountDisplay = `${discountValue}% off`;
                } else {
                    discountDisplay = `₹${discountValue.toFixed(2)} off`;
                }
            } else if (originalPrice > 0 && displayPrice > 0 && displayPrice < originalPrice) {
                hasDiscount = true;
                const discountPercent = Math.round(((originalPrice - displayPrice) / originalPrice) * 100);
                discountDisplay = `${discountPercent}% off`;
            }

            return {
                originalPrice: originalPrice,
                displayPrice: displayPrice,
                discountDisplay: discountDisplay,
                hasDiscount: hasDiscount && discountDisplay !== ''
            };
        }

        // ================================================================
        // ===== LOAD PRODUCTS =====
        // ================================================================
        async function loadProducts() {
            const loader = document.getElementById('productsLoader');
            const container = document.getElementById('productsContainer');
            if (loader) loader.style.display = 'block';

            try {
                const response = await fetch('/api/products');
                const products = await response.json();

                if (loader) loader.style.display = 'none';

                const allProducts = products.sort((a, b) => {
                    return (b.id || 0) - (a.id || 0);
                });

                if (allProducts.length === 0) {
                    container.innerHTML =
                        '<div class="col-12"><div class="no-products">No products available</div></div>';
                    return;
                }

                container.innerHTML = allProducts.map(product => {
                    const variantData = getVariantData(product);

                    let imageUrls = [];
                    if (variantData.hasVariant && variantData.allImages.length > 0) {
                        imageUrls = variantData.allImages;
                    } else {
                        imageUrls = getProductImages(product);
                    }

                    const firstImage = imageUrls.length > 0 ? imageUrls[0] :
                        'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMGYwZjAiLz48dGV4dCB4PSIxNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjUwIiBmaWxsPSIjY2NjIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCI+Tm8gSW1hZ2U8L3RleHQ+PC9zdmc+';

                    const totalStock = variantData.totalStock || parseInt(product.stock) || 0;

                    const priceData = {
                        originalPrice: variantData.originalPrice,
                        price: variantData.price,
                        discountType: variantData.discountType,
                        discountValue: variantData.discountValue
                    };

                    const discount = calculateDiscount(priceData);
                    const displayPrice = discount.displayPrice;
                    const originalPrice = discount.originalPrice;
                    const discountDisplay = discount.discountDisplay;
                    const hasDiscount = discount.hasDiscount;

                    const isInWishlist = wishlist.some(item => item.id === product.id);
                    const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                    const escapeName = product.name.replace(/'/g, "\\'");

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

                    let colorHtml = '';
                    const totalColors = variantData.colors.length;

                    if (totalColors > 0) {
                        const displayColors = variantData.colors.slice(0, 4);
                        const remaining = totalColors - 4;

                        colorHtml = `
                        <div class="color-options-container">
                            <span class="color-label">${totalColors} Color${totalColors > 1 ? 's' : ''}:</span>
                            ${displayColors.map(color => `
                                        <span class="color-dot" style="background: ${color.toLowerCase()};" title="${color}"></span>
                                    `).join('')}
                            ${remaining > 0 ? `<span class="color-dot more-colors">+${remaining}</span>` : ''}
                        </div>
                    `;
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

                    return `
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
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
                                ${colorHtml}
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

        // ================================================================
        // ===== INITIALIZE =====
        // ================================================================
        document.addEventListener('DOMContentLoaded', function() {
            wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            cart = JSON.parse(localStorage.getItem('cart')) || [];

            loadBanners();
            loadCategories();
            loadProducts();

            updateCartCount();
            updateWishlistCount();
        });

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && !bannerLoaded) {
                loadBanners();
            }
        });
    </script>
@endsection
