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
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
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
        background: rgba(255,255,255,0.2);
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
    
    /* Product Card - Full Image Cover */
    .product-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        height: 100%;
        position: relative;
        background: white;
        cursor: pointer;
    }
    
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    
    .product-image-slider {
        position: relative;
        overflow: hidden;
        background: #f5f5f5;
        width: 100%;
        padding-top: 100%;
    }
    
    .product-image-slider .carousel-inner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .product-image-slider .carousel-item {
        width: 100%;
        height: 100%;
    }
    
    .product-image-slider .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: #f5f5f5;
    }
    
    .product-image-slider .carousel-control-prev,
    .product-image-slider .carousel-control-next {
        opacity: 0;
        transition: opacity 0.3s;
        width: 28px;
        height: 28px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        z-index: 10;
    }
    
    .product-card:hover .product-image-slider .carousel-control-prev,
    .product-card:hover .product-image-slider .carousel-control-next {
        opacity: 1;
    }
    
    .product-image-slider .carousel-control-prev {
        left: 6px;
    }
    
    .product-image-slider .carousel-control-next {
        right: 6px;
    }
    
    .product-image-slider .carousel-control-prev-icon,
    .product-image-slider .carousel-control-next-icon {
        background-size: 60%;
        width: 14px;
        height: 14px;
    }
    
    .carousel-indicators {
        display: none;
    }
    
    .product-card .card-body {
        padding: 10px 12px;
    }
    
    .product-card .card-title {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #1e293b;
    }
    
    .product-card .product-category-name {
        font-size: 0.7rem;
        color: #999;
        margin-bottom: 4px;
    }
    
    .product-price-display {
        font-size: 0.95rem;
        font-weight: bold;
        color: #dc3545;
    }
    
    .product-old-price-display {
        text-decoration: line-through;
        color: #999;
        font-size: 0.7rem;
        margin-right: 5px;
    }
    
    .discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #dc3545;
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: bold;
        z-index: 2;
    }
    
    .wishlist-btn {
        position: absolute;
        top: 8px;
        left: 8px;
        background: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: all 0.3s;
    }
    
    .wishlist-btn i {
        font-size: 0.8rem;
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
        padding: 4px 10px;
        color: white;
        transition: all 0.3s;
        font-size: 0.65rem;
        cursor: pointer;
    }
    
    .btn-add-cart:hover {
        background: #dc3545;
    }
    
    .btn-buy-now {
        background: #dc3545;
        border: none;
        border-radius: 25px;
        padding: 4px 10px;
        color: white;
        transition: all 0.3s;
        font-size: 0.65rem;
        cursor: pointer;
    }
    
    .btn-buy-now:hover {
        background: #000000;
    }
    
    .product-actions {
        display: flex;
        gap: 4px;
        justify-content: center;
        margin-top: 6px;
    }
    
    /* Filter Sidebar */
    .filter-sidebar {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        position: sticky;
        top: 20px;
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
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
    
    .product-grid > [class*="col-"] {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    @media (max-width: 768px) {
        .product-actions {
            flex-direction: column;
        }
        .btn-add-cart, .btn-buy-now {
            width: 100%;
        }
        .filter-sidebar {
            position: static;
            margin-bottom: 20px;
        }
        .sub-category-item {
            min-width: 120px;
            padding: 14px 16px;
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
        .product-image-slider .carousel-control-prev,
        .product-image-slider .carousel-control-next {
            opacity: 1;
            width: 24px;
            height: 24px;
        }
    }
    
    @media (max-width: 576px) {
        .sub-category-item {
            min-width: 100px;
            padding: 10px 12px;
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
        .product-image-slider .carousel-control-prev,
        .product-image-slider .carousel-control-next {
            width: 20px;
            height: 20px;
        }
        .product-image-slider .carousel-control-prev-icon,
        .product-image-slider .carousel-control-next-icon {
            width: 10px;
            height: 10px;
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
        <!-- Filter Sidebar - Left Side -->
        <div class="col-md-3">
            <div class="filter-sidebar">
                <h5 class="mb-3"><i class="fas fa-filter me-2 text-danger"></i> Filters</h5>
                
                <div class="filter-section">
                    <div class="filter-title collapsed" onclick="toggleFilter(this, 'gender')">
                        Gender <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="filter-content" id="filter-gender" style="display: none;">
                        <ul class="filter-options">
                            <li><label><input type="checkbox" value="Men" class="filter-check" data-filter="gender"> Men</label></li>
                            <li><label><input type="checkbox" value="Women" class="filter-check" data-filter="gender"> Women</label></li>
                            <li><label><input type="checkbox" value="Unisex" class="filter-check" data-filter="gender"> Unisex</label></li>
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
                            <li><label><input type="radio" name="price" value="500-1000"> ₹500 - ₹1000</label></li>
                            <li><label><input type="radio" name="price" value="1000-2000"> ₹1000 - ₹2000</label></li>
                            <li><label><input type="radio" name="price" value="2000-5000"> ₹2000 - ₹5000</label></li>
                            <li><label><input type="radio" name="price" value="5000-10000"> ₹5000 - ₹10000</label></li>
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
                            <span class="color-btn" style="background: #FFFFFF; border:1px solid #ddd;" data-color="White"></span>
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
        
        <!-- Products Container - Right Side -->
        <div class="col-md-9">
            <!-- Filter Info -->
            <div class="filter-info">
                <div class="results-count">
                    <strong id="productCountDisplay">0</strong> products found
                </div>
                <div class="delivery-badge">
                    <i class="fas fa-truck me-1"></i> Next day delivery available
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
                container.innerHTML = '<span class="text-muted" style="font-size:0.85rem;">No sub categories available</span>';
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
            
            const brands = [...new Set(products.map(p => p.brand).filter(b => b))];
            const brandFilterList = document.getElementById('brandFilterList');
            if (brandFilterList && brands.length > 0) {
                brandFilterList.innerHTML = brands.map(brand => 
                    `<li><label><input type="checkbox" value="${brand}" class="filter-check" data-filter="brand"> ${brand}</label></li>`
                ).join('');
            }
            
            if (products.length === 0) {
                container.innerHTML = '<div class="col-12"><div class="no-products">No products available</div></div>';
                return;
            }
            
            renderProducts(products);
        } catch (error) {
            console.error('Error loading products:', error);
            loader.style.display = 'none';
            container.innerHTML = '<div class="col-12"><div class="no-products text-danger">Error loading products. Please try again.</div></div>';
        }
    }
    
    function getProductImages(product) {
        let images = [];
        
        if (product.all_images && Array.isArray(product.all_images) && product.all_images.length > 0) {
            product.all_images.forEach(img => {
                if (img && img.trim() !== '') {
                    let imageUrl = img.startsWith('http') ? img : '/storage/' + img;
                    if (!images.includes(imageUrl)) {
                        images.push(imageUrl);
                    }
                }
            });
        } else if (product.image) {
            images.push(product.image.startsWith('http') ? product.image : '/storage/' + product.image);
        } else {
            images.push('https://via.placeholder.com/300x300?text=No+Image');
        }
        
        return images.slice(0, 4);
    }
    
    function renderProducts(products) {
        const container = document.getElementById('productsContainer');
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        
        if (products.length === 0) {
            container.innerHTML = '<div class="col-12"><div class="no-products">No products found</div></div>';
            return;
        }
        
        container.innerHTML = products.map(product => {
            const discountPercent = product.discount_price ? Math.round(((product.price - product.discount_price) / product.price) * 100) : 0;
            const displayPrice = product.discount_price ? product.discount_price : product.price;
            const oldPriceHtml = product.discount_price ? `<span class="product-old-price-display">₹${parseFloat(product.price).toLocaleString()}</span>` : '';
            const discountBadge = product.discount_price ? `<div class="discount-badge">-${discountPercent}%</div>` : '';
            const isInWishlist = wishlist.some(item => item.id === product.id);
            const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
            const escapeName = product.name.replace(/'/g, "\\'");
            
            const images = getProductImages(product);
            const carouselId = `productCarousel-${product.id}`;
            const hasMultipleImages = images.length > 1;
            
            const firstImage = images.length > 0 ? images[0] : '';
            
            return `
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="product-card card" onclick="goToProductDetail(${product.id}, event)">
                        ${discountBadge}
                        <button class="wishlist-btn" onclick="toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${firstImage}', event)">
                            <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                        </button>
                        
                        <div id="${carouselId}" class="carousel slide product-image-slider" data-bs-ride="false" data-bs-interval="false">
                            <div class="carousel-inner">
                                ${images.map((imgUrl, idx) => `
                                    <div class="carousel-item ${idx === 0 ? 'active' : ''}">
                                        <img src="${imgUrl}" alt="${product.name}">
                                    </div>
                                `).join('')}
                            </div>
                            ${hasMultipleImages ? `
                                <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev" onclick="event.stopPropagation()">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next" onclick="event.stopPropagation()">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            ` : ''}
                        </div>
                        
                        <div class="card-body text-center">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="product-category-name">${product.gender || (product.category ? product.category.name : 'Uncategorized')}</p>
                            <div>
                                ${oldPriceHtml}
                                <span class="product-price-display">₹${parseFloat(displayPrice).toLocaleString()}</span>
                            </div>
                        
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
            filtered = filtered.filter(p => selectedBrands.includes(p.brand));
        }
        if (selectedPrice) {
            const [min, max] = selectedPrice.split('-');
            if (max === '10000+') {
                filtered = filtered.filter(p => (p.discount_price || p.price) >= parseInt(min));
            } else {
                filtered = filtered.filter(p => (p.discount_price || p.price) >= parseInt(min) && (p.discount_price || p.price) <= parseInt(max));
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
        
        switch(sortValue) {
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
        @if(!auth()->check())
            if(confirm('Please login to add items to wishlist. Go to login page?')) {
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
            currentWishlist.push({ id, name, price, image, added_at: new Date().toISOString() });
            if (icon) icon.className = 'fas fa-heart';
            showNotification('Added to wishlist!', 'success');
        }
        localStorage.setItem('wishlist', JSON.stringify(currentWishlist));
        updateNavbarWishlistCount();
    }
    
    function addToCart(id, name, price, imageUrl, event) {
        if (event) event.stopPropagation();
        @if(!auth()->check())
            if(confirm('Please login to add products to cart. Go to login page?')) {
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
            cart.push({ id, name, price: price, image: finalImage, quantity: 1 });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateNavbarCartCount();
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
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("buy.now") }}';
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
        notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
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