@extends('layouts.app')

@section('content')
    <style>
        /* Breadcrumb */
        .breadcrumb-section {
            background: #f8fafc;
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #eef2f6;
        }

        .breadcrumb-section .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
        }

        .breadcrumb-section .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .breadcrumb-section .breadcrumb-item a:hover {
            color: #dc3545;
        }

        .breadcrumb-section .breadcrumb-item.active {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Sub Categories - Larger Cards */
        .sub-categories-section {
            margin-bottom: 30px;
            padding: 20px 0;
            background: #ffffff;
            border-radius: 15px;
            border: 1px solid #eef2f6;
        }

        .sub-categories-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 18px;
            padding: 0 20px;
        }

        .sub-categories-scroll {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding: 5px 20px 15px 20px;
            scrollbar-width: thin;
            scrollbar-color: #dc3545 #f1f1f1;
            -webkit-overflow-scrolling: touch;
        }

        .sub-categories-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .sub-categories-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .sub-categories-scroll::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }

        /* Larger Sub Category Card */
        .sub-category-item {
            flex: 0 0 auto;
            min-width: 230px;
            height: 240px;
            text-align: center;
            padding: 18px 20px;
            background: white;
            border-radius: 16px;
            border: 2px solid #eef2f6;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: #1e293b;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
        }

        .sub-category-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #dc3545, #b02a37);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 0;
        }

        .sub-category-item:hover::before {
            opacity: 1;
        }

        .sub-category-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.2);
            border-color: #dc3545;
        }

        .sub-category-item.active {
            border-color: #dc3545;
            background: #dc3545;
            color: white;
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }

        .sub-category-item.active::before {
            opacity: 0;
        }

        .sub-category-item * {
            position: relative;
            z-index: 1;
        }

        .sub-category-item img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 12px;
            border: 3px solid #eef2f6;
            transition: all 0.3s;
        }

        .sub-category-item:hover img {
            border-color: #dc3545;
            transform: scale(1.05);
        }

        .sub-category-item.active img {
            border-color: white;
            transform: scale(1.05);
        }

        .sub-category-item .sub-cat-icon {
            width: 70px;
            height: 70px;
            background: #f8fafc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 2rem;
            color: #64748b;
            border: 3px solid #eef2f6;
            transition: all 0.3s;
        }

        .sub-category-item:hover .sub-cat-icon {
            border-color: #dc3545;
            color: #dc3545;
        }

        .sub-category-item.active .sub-cat-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: white;
        }

        .sub-category-item .sub-cat-name {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
            margin-bottom: 4px;
        }

        .sub-category-item .product-count {
            display: block;
            font-size: 0.7rem;
            opacity: 0.7;
            font-weight: 400;
        }

        .sub-category-item.active .product-count {
            opacity: 0.9;
        }

        /* Filter Info */
        .filter-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-info .results-count {
            font-size: 0.9rem;
            color: #64748b;
        }

        .filter-info .results-count strong {
            color: #1e293b;
        }

        .filter-info .delivery-badge {
            background: #dcfce7;
            color: #15803d;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
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

        /* REMOVED RATING - NO STARS */
        .product-rating {
            display: none !important;
        }

        /* ===== STICKY FILTER SIDEBAR - FIXED ===== */
        .filter-sidebar-wrapper {
            position: sticky;
            top: 80px;
            align-self: flex-start;
        }

        .filter-sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .filter-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }

        .filter-section {
            margin-bottom: 18px;
            border-bottom: 1px solid #eef2f6;
            padding-bottom: 15px;
        }

        .filter-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .filter-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }

        .filter-title i {
            font-size: 0.75rem;
            color: #dc3545;
            transition: transform 0.3s ease;
        }

        .filter-title.collapsed i {
            transform: rotate(-90deg);
        }

        .filter-content {
            display: none;
            transition: all 0.3s ease;
        }

        .filter-options {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 180px;
            overflow-y: auto;
        }

        .filter-options li {
            margin-bottom: 6px;
        }

        .filter-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            color: #64748b;
            transition: all 0.3s;
        }

        .filter-options label:hover {
            color: #dc3545;
        }

        .filter-options input[type="checkbox"],
        .filter-options input[type="radio"] {
            width: 14px;
            height: 14px;
            cursor: pointer;
            accent-color: #dc3545;
        }

        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .size-btn {
            padding: 4px 10px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            font-size: 0.65rem;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .size-btn:hover,
        .size-btn.active {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .color-btn {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .color-btn:hover,
        .color-btn.active {
            transform: scale(1.1);
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-apply-filter {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 6px 12px;
            font-size: 0.75rem;
            cursor: pointer;
            flex: 1;
        }

        .btn-reset-filter {
            background: #e2e8f0;
            color: #64748b;
            border: none;
            border-radius: 25px;
            padding: 6px 12px;
            font-size: 0.75rem;
            cursor: pointer;
            flex: 1;
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
            padding: 40px;
            background: white;
            border-radius: 15px;
        }

        .sorting-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .sort-select {
            padding: 6px 15px;
            border-radius: 30px;
            border: 1px solid #e0e0e0;
            background: white;
            font-size: 0.8rem;
            cursor: pointer;
            outline: none;
        }

        .sort-select:focus {
            border-color: #dc3545;
        }

        .product-grid {
            margin-left: -10px;
            margin-right: -10px;
        }

        .product-grid>[class*="col-"] {
            padding-left: 10px;
            padding-right: 10px;
        }

        @media (max-width: 768px) {
            .filter-sidebar-wrapper {
                position: static;
            }

            .filter-sidebar {
                max-height: none;
                overflow-y: visible;
            }

            .product-actions {
                flex-direction: column;
            }

            .sub-category-item {
                min-width: 120px;
                padding: 14px 16px;
                height: 200px;
            }

            .sub-category-item img {
                width: 55px;
                height: 55px;
            }

            .sub-category-item .sub-cat-icon {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
            }

            .sub-category-item .sub-cat-name {
                font-size: 0.8rem;
            }

            .filter-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .sub-categories-section {
                padding: 12px 0;
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
        }

        @media (max-width: 576px) {
            .sub-category-item {
                min-width: 100px;
                padding: 10px 12px;
                height: 170px;
            }

            .sub-category-item img {
                width: 45px;
                height: 45px;
            }

            .sub-category-item .sub-cat-icon {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .sub-category-item .sub-cat-name {
                font-size: 0.7rem;
            }

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
        }
    </style>

    <!-- Breadcrumb Section -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active" id="breadcrumbCategory">All Products</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mb-4">
        <!-- Sub Categories Section - Full Width Horizontal Scroll -->
        <div class="sub-categories-section" id="subCategoriesSection" style="display: none;">
            <div class="sub-categories-title" id="categoryTitle">Shop by Category</div>
            <div class="sub-categories-scroll" id="subCategoriesContainer">
                <span class="text-muted" style="font-size:0.85rem; padding:10px 0;">Loading sub categories...</span>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar - Left Side - STICKY -->
            <div class="col-md-3">
                <div class="filter-sidebar-wrapper">
                    <div class="filter-sidebar">
                        <h5 class="mb-3"><i class="fas fa-filter me-2 text-danger"></i> Filters</h5>

                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'gender')">
                                Gender <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-gender" style="display: none;">
                                <ul class="filter-options">
                                    <li><label><input type="checkbox" value="Men" class="filter-check"
                                                data-filter="gender"> Men</label></li>
                                    <li><label><input type="checkbox" value="Women" class="filter-check"
                                                data-filter="gender"> Women</label></li>
                                    <li><label><input type="checkbox" value="Unisex" class="filter-check"
                                                data-filter="gender"> Unisex</label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'category')">
                                Category <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-category" style="display: none;">
                                <ul class="filter-options" id="categoryFilterList"></ul>
                            </div>
                        </div>

                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'brand')">
                                Brand <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-brand" style="display: none;">
                                <ul class="filter-options" id="brandFilterList"></ul>
                            </div>
                        </div>

                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'price')">
                                Price <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-price" style="display: none;">
                                <ul class="filter-options">
                                    <li><label><input type="radio" name="price" value="0-500"> ₹0 - ₹500</label></li>
                                    <li><label><input type="radio" name="price" value="500-1000"> ₹500 - ₹1000</label>
                                    </li>
                                    <li><label><input type="radio" name="price" value="1000-2000"> ₹1000 - ₹2000</label>
                                    </li>
                                    <li><label><input type="radio" name="price" value="2000-5000"> ₹2000 - ₹5000</label>
                                    </li>
                                    <li><label><input type="radio" name="price" value="5000-10000"> ₹5000 -
                                            ₹10000</label></li>
                                    <li><label><input type="radio" name="price" value="10000+"> ₹10000+</label></li>
                                </ul>
                            </div>
                        </div>

                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'size')">
                                Size <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-size" style="display: none;">
                                <div class="size-options">
                                    <span class="size-btn" data-size="XS">XS</span>
                                    <span class="size-btn" data-size="S">S</span>
                                    <span class="size-btn" data-size="M">M</span>
                                    <span class="size-btn" data-size="L">L</span>
                                    <span class="size-btn" data-size="XL">XL</span>
                                    <span class="size-btn" data-size="XXL">XXL</span>
                                </div>
                            </div>
                        </div>

                        <div class="filter-section">
                            <div class="filter-title collapsed" onclick="toggleFilter(this, 'color')">
                                Color <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="filter-content" id="filter-color" style="display: none;">
                                <div class="color-options">
                                    <span class="color-btn" style="background: #000000;" data-color="Black"></span>
                                    <span class="color-btn" style="background: #FFFFFF; border:1px solid #ddd;"
                                        data-color="White"></span>
                                    <span class="color-btn" style="background: #FF0000;" data-color="Red"></span>
                                    <span class="color-btn" style="background: #0000FF;" data-color="Blue"></span>
                                    <span class="color-btn" style="background: #008000;" data-color="Green"></span>
                                    <span class="color-btn" style="background: #FFFF00;" data-color="Yellow"></span>
                                    <span class="color-btn" style="background: #FFC0CB;" data-color="Pink"></span>
                                    <span class="color-btn" style="background: #800080;" data-color="Purple"></span>
                                    <span class="color-btn" style="background: #FFA500;" data-color="Orange"></span>
                                    <span class="color-btn" style="background: #808080;" data-color="Grey"></span>
                                </div>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button class="btn-apply-filter" onclick="applyFilters()">Apply Filters</button>
                            <button class="btn-reset-filter" onclick="resetFilters()">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Container - Right Side -->
            <div class="col-md-9">
                <!-- Filter Info -->
                <div class="filter-info">
                    <div class="results-count">
                        <strong id="productCountDisplay">0</strong> products found
                    </div>
                </div>

                <div class="sorting-wrapper">
                    <select class="sort-select" id="sortBy" onchange="sortProducts()">
                        <option value="default">Default Sorting</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="name_asc">Name: A to Z</option>
                        <option value="name_desc">Name: Z to A</option>
                    </select>
                </div>

                <div id="loader" class="loader" style="display: none;">
                    <i class="fas fa-spinner"></i>
                    <p>Loading products...</p>
                </div>

                <div class="row product-grid" id="productsContainer"></div>
            </div>
        </div>
    </div>

    <script>
        let currentCategoryId = null;
        let currentSubCategoryId = null;
        let allProducts = [];
        let filteredProducts = [];
        let categoriesList = [];

        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        function toggleFilter(element, filterId) {
            element.classList.toggle('collapsed');
            const content = document.getElementById(`filter-${filterId}`);
            if (content) {
                content.style.display = content.style.display === 'none' ? 'block' : 'none';
            }
        }

        async function loadCategoriesAndBrands() {
            try {
                const response = await fetch('/api/categories');
                categoriesList = await response.json();
                const categoryFilterList = document.getElementById('categoryFilterList');
                if (categoryFilterList) {
                    categoryFilterList.innerHTML = categoriesList.map(cat =>
                        `<li><label><input type="checkbox" value="${cat.id}" class="filter-check" data-filter="category"> ${cat.name}</label></li>`
                    ).join('');
                }
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        }

        async function loadSubCategories(categoryId) {
            try {
                const response = await fetch(`/api/subcategories/${categoryId}`);
                const subCategories = await response.json();
                const container = document.getElementById('subCategoriesContainer');
                const title = document.getElementById('categoryTitle');
                const section = document.getElementById('subCategoriesSection');

                if (!container) return;

                if (section) {
                    if (subCategories.length > 0) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                }

                if (subCategories.length === 0) {
                    container.innerHTML =
                        '<span class="text-muted" style="font-size:0.85rem;">No sub categories available</span>';
                    return;
                }

                const categoryName = getUrlParameter('name') || 'All Categories';
                if (title) {
                    title.textContent = categoryName;
                }

                const breadcrumb = document.getElementById('breadcrumbCategory');
                if (breadcrumb) {
                    breadcrumb.textContent = categoryName;
                }

                container.innerHTML = subCategories.map(sub => {
                    const isActive = currentSubCategoryId == sub.id;
                    const imageHtml = sub.image ?
                        `<img src="/storage/${sub.image}" alt="${sub.name}">` :
                        `<div class="sub-cat-icon"><i class="fas fa-tag"></i></div>`;

                    return `
                    <a href="javascript:void(0)" 
                       class="sub-category-item ${isActive ? 'active' : ''}"
                       onclick="filterBySubCategory(${sub.id}, ${categoryId}, '${sub.name.replace(/'/g, "\\'")}', this)">
                        ${imageHtml}
                        <span class="sub-cat-name">${sub.name}</span>
                        <span class="product-count">${sub.products_count || 0} products</span>
                    </a>
                `;
                }).join('');

            } catch (error) {
                console.error('Error loading sub categories:', error);
                const container = document.getElementById('subCategoriesContainer');
                if (container) {
                    container.innerHTML = '<span class="text-danger">Error loading sub categories</span>';
                }
            }
        }

        function filterBySubCategory(subCategoryId, categoryId, subName, element) {
            document.querySelectorAll('.sub-category-item').forEach(item => {
                item.classList.remove('active');
            });
            if (element) {
                element.classList.add('active');
            }

            currentSubCategoryId = subCategoryId;
            currentCategoryId = categoryId;

            const breadcrumb = document.getElementById('breadcrumbCategory');
            if (breadcrumb) breadcrumb.textContent = subName;

            const title = document.getElementById('categoryTitle');
            if (title) title.textContent = subName;

            loadProducts();
        }

        // ===== GET PRODUCT IMAGES - SAME AS HOME =====
        function getProductImages(product) {
            let images = [];

            // 1. CHECK VARIANT IMAGES FIRST
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

            // 2. Check all_images from API
            if (images.length === 0 && product.all_images && product.all_images.length > 0) {
                images = product.all_images.map(img => {
                    if (img.startsWith('http')) return img;
                    return '/storage/' + img;
                });
            }

            // 3. Check product.image field
            if (images.length === 0 && product.image) {
                if (product.image.startsWith('http')) {
                    images.push(product.image);
                } else {
                    images.push('/storage/' + product.image);
                }
            }

            // 4. Fallback
            if (images.length === 0) {
                images.push('https://via.placeholder.com/300x300?text=No+Image');
            }

            return images.slice(0, 4);
        }

        // ===== GET VARIANT DATA - FIXED =====
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
                    variantImages.push('https://via.placeholder.com/300x300?text=No+Image');
                }

                let totalStock = 0;
                product.variants.forEach(v => {
                    totalStock += parseInt(v.stock) || 0;
                });

                // ===== FIX: Use total_price as original price, final_price as discounted price =====
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
                    variantId: firstVariant.id
                };
            }

            // Normal product (no variants)
            // ===== FIX: Use total_price as original price, final_price as discounted price =====
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
                variantId: null
            };
        }

        // ===== CALCULATE DISCOUNT - FIXED =====
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

        async function loadProducts() {
            const loader = document.getElementById('loader');
            const container = document.getElementById('productsContainer');
            loader.style.display = 'block';

            try {
                let url = '/api/products';

                if (currentSubCategoryId) {
                    url = `/api/products/subcategory/${currentSubCategoryId}`;
                } else if (currentCategoryId) {
                    url = `/api/products/category/${currentCategoryId}`;
                }

                const response = await fetch(url);
                const products = await response.json();
                allProducts = products;
                filteredProducts = [...products];
                loader.style.display = 'none';

                const countDisplay = document.getElementById('productCountDisplay');
                if (countDisplay) countDisplay.textContent = products.length;

                const brands = [...new Set(products.map(p => p.brand && p.brand.name ? p.brand.name : null).filter(b =>
                    b))];
                const brandFilterList = document.getElementById('brandFilterList');
                if (brandFilterList && brands.length > 0) {
                    brandFilterList.innerHTML = brands.map(brand =>
                        `<li><label><input type="checkbox" value="${brand}" class="filter-check" data-filter="brand"> ${brand}</label></li>`
                    ).join('');
                }

                if (products.length === 0) {
                    container.innerHTML =
                        '<div class="col-12"><div class="no-products">No products available</div></div>';
                    return;
                }

                renderProducts(products);
            } catch (error) {
                console.error('Error loading products:', error);
                loader.style.display = 'none';
                container.innerHTML =
                    '<div class="col-12"><div class="no-products text-danger">Error loading products. Please try again.</div></div>';
            }
        }

        function renderProducts(products) {
            const container = document.getElementById('productsContainer');
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

            if (products.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products found</div></div>';
                return;
            }

            container.innerHTML = products.map(product => {
                // Get variant data
                const variantData = getVariantData(product);

                // Get product images
                let imageUrls = [];
                if (variantData.hasVariant && variantData.allImages.length > 0) {
                    imageUrls = variantData.allImages;
                } else {
                    imageUrls = getProductImages(product);
                }

                const firstImage = imageUrls.length > 0 ? imageUrls[0] :
                    'https://via.placeholder.com/300x300?text=No+Image';

                // Get price data
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

                const totalStock = variantData.totalStock || parseInt(product.stock) || 0;

                const isInWishlist = wishlist.some(item => item.id === product.id);
                const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
                const escapeName = product.name.replace(/'/g, "\\'");

                // ===== GET BRAND NAME - SAME AS HOME =====
                let brandName = '';
                if (product.brand) {
                    brandName = product.brand.name || '';
                } else if (product.brand_name) {
                    brandName = product.brand_name;
                }

                // ===== BRAND HTML - SAME AS HOME =====
                let brandHtml = '';
                if (brandName) {
                    brandHtml = `
                    <div class="product-brand">
                        <i class="fas fa-tag"></i>
                        ${brandName}
                    </div>
                `;
                }

                // ===== STOCK HTML - SAME AS HOME =====
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

                // ===== PRICE HTML - SAME AS HOME =====
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

                // ===== VARIANT BADGE =====
                const variantBadge = variantData.hasVariant ?
                    `<span style="position:absolute;bottom:10px;right:10px;background:#0d6efd;color:white;padding:2px 8px;border-radius:4px;font-size:10px;z-index:1;">${product.variants.length} Variants</span>` :
                    '';

                return `
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                        ${hasDiscount && displayPrice > 0 ? `<div class="discount-badge">${discountDisplay}</div>` : ''}
                        ${variantBadge}
                        <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${firstImage}')">
                            <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                        </button>
                        
                        <div class="product-image-container">
                            <img src="${firstImage}" alt="${product.name}" 
                                onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"
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

            wishlist.forEach(item => {
                const icon = document.getElementById(`wishlist-icon-${item.id}`);
                if (icon) icon.className = 'fas fa-heart';
            });
        }

        function getSelectedCheckboxValues(filterType) {
            const checkboxes = document.querySelectorAll(`.filter-check[data-filter="${filterType}"]:checked`);
            return Array.from(checkboxes).map(cb => cb.value);
        }

        function getSelectedPriceValue() {
            const selected = document.querySelector('input[name="price"]:checked');
            return selected ? selected.value : null;
        }

        function getSelectedSizes() {
            const selected = document.querySelectorAll('.size-btn.active');
            return Array.from(selected).map(btn => btn.dataset.size);
        }

        function getSelectedColors() {
            const selected = document.querySelectorAll('.color-btn.active');
            return Array.from(selected).map(btn => btn.dataset.color);
        }

        function applyFilters() {
            const selectedGenders = getSelectedCheckboxValues('gender');
            const selectedCategories = getSelectedCheckboxValues('category');
            const selectedBrands = getSelectedCheckboxValues('brand');
            const selectedPrice = getSelectedPriceValue();
            const selectedSizes = getSelectedSizes();
            const selectedColors = getSelectedColors();

            let filtered = [...allProducts];

            if (selectedGenders.length > 0) {
                filtered = filtered.filter(p => selectedGenders.includes(p.gender));
            }
            if (selectedCategories.length > 0) {
                filtered = filtered.filter(p => selectedCategories.includes(p.category_id?.toString()));
            }
            if (selectedBrands.length > 0) {
                filtered = filtered.filter(p => selectedBrands.includes(p.brand?.name || p.brand_name));
            }
            if (selectedPrice) {
                const [min, max] = selectedPrice.split('-');
                if (max === '10000+') {
                    filtered = filtered.filter(p => (p.discount_price || p.price) >= parseInt(min));
                } else {
                    filtered = filtered.filter(p => (p.discount_price || p.price) >= parseInt(min) && (p.discount_price || p
                        .price) <= parseInt(max));
                }
            }
            if (selectedSizes.length > 0) {
                filtered = filtered.filter(p => p.size && selectedSizes.some(s => p.size.includes(s)));
            }
            if (selectedColors.length > 0) {
                filtered = filtered.filter(p => p.color && selectedColors.includes(p.color));
            }

            filteredProducts = filtered;
            renderProducts(filtered);

            const countDisplay = document.getElementById('productCountDisplay');
            if (countDisplay) countDisplay.textContent = filtered.length;
        }

        function sortProducts() {
            const sortValue = document.getElementById('sortBy').value;
            let sortedProducts = [...filteredProducts];

            switch (sortValue) {
                case 'price_asc':
                    sortedProducts.sort((a, b) => (a.discount_price || a.price) - (b.discount_price || b.price));
                    break;
                case 'price_desc':
                    sortedProducts.sort((a, b) => (b.discount_price || b.price) - (a.discount_price || a.price));
                    break;
                case 'name_asc':
                    sortedProducts.sort((a, b) => a.name.localeCompare(b.name));
                    break;
                case 'name_desc':
                    sortedProducts.sort((a, b) => b.name.localeCompare(a.name));
                    break;
            }
            renderProducts(sortedProducts);
        }

        function resetFilters() {
            document.querySelectorAll('.filter-check:checked').forEach(cb => cb.checked = false);
            document.querySelectorAll('input[name="price"]:checked').forEach(radio => radio.checked = false);
            document.querySelectorAll('.size-btn.active').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.color-btn.active').forEach(btn => btn.classList.remove('active'));

            filteredProducts = [...allProducts];
            renderProducts(allProducts);
            document.getElementById('sortBy').value = 'default';

            const countDisplay = document.getElementById('productCountDisplay');
            if (countDisplay) countDisplay.textContent = allProducts.length;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('active');
                });
            });

            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('active');
                });
            });
        });

        function goToProductDetail(productId, event) {
            if (event && (event.target.closest('.wishlist-btn') ||
                    event.target.closest('.btn-add-cart') ||
                    event.target.closest('.btn-buy-now') ||
                    event.target.closest('.carousel-control-prev') ||
                    event.target.closest('.carousel-control-next'))) {
                return;
            }
            window.location.href = `/product/${productId}`;
        }

        function toggleWishlist(id, name, price, image, event) {
            if (event) event.stopPropagation();
            @if (!auth()->check())
                if (confirm('Please login to add items to wishlist. Go to login page?')) {
                    window.location.href = "{{ route('login') }}";
                }
                return;
            @endif

            let currentWishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const index = currentWishlist.findIndex(item => item.id === id);
            const icon = document.getElementById(`wishlist-icon-${id}`);

            if (index !== -1) {
                currentWishlist.splice(index, 1);
                if (icon) icon.className = 'far fa-heart';
                showNotification('Removed from wishlist!', 'info');
            } else {
                currentWishlist.push({
                    id,
                    name,
                    price,
                    image,
                    added_at: new Date().toISOString()
                });
                if (icon) icon.className = 'fas fa-heart';
                showNotification('Added to wishlist!', 'success');
            }
            localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
            updateNavbarWishlistCount();
        }

        function addToCart(id, name, price, imageUrl, event) {
            if (event) event.stopPropagation();
            @if (!auth()->check())
                if (confirm('Please login to add products to cart. Go to login page?')) {
                    window.location.href = "{{ route('login') }}";
                }
                return;
            @endif

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existing = cart.find(item => item.id === id);
            const finalImage = imageUrl || '';

            if (existing) {
                existing.quantity++;
            } else {
                cart.push({
                    id,
                    name,
                    price: price,
                    image: finalImage,
                    quantity: 1
                });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateNavbarCartCount();
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

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('buy.now') }}';
            form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="product_id" value="${productId}">
                          <input type="hidden" name="quantity" value="1">`;
            document.body.appendChild(form);
            form.submit();
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show`;
            notification.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:250px';
            notification.innerHTML =
                `<i class="fas fa-check-circle"></i> ${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        function updateNavbarCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const count = cart.reduce((t, i) => t + i.quantity, 0);
            const el = document.getElementById('navbarCartCount');
            if (el) {
                el.textContent = count;
                el.classList.toggle('hide-badge', count === 0);
            }
        }

        function updateNavbarWishlistCount() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const count = wishlist.length;
            const el = document.getElementById('navbarWishlistCount');
            if (el) {
                el.textContent = count;
                el.classList.toggle('hide-badge', count === 0);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            currentCategoryId = getUrlParameter('category');
            currentSubCategoryId = getUrlParameter('subcategory');
            const categoryName = getUrlParameter('name');

            loadCategoriesAndBrands();

            if (currentCategoryId) {
                loadSubCategories(currentCategoryId);
            }

            loadProducts();
            updateNavbarCartCount();
            updateNavbarWishlistCount();
        });
    </script>
@endsection
