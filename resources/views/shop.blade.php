@extends('layouts.app')

@section('content')
<style>
    .shop-header {
        background: linear-gradient(135deg, #1e293b 0%, #2d3a4b 100%);
        padding: 60px 0;
        margin-bottom: 40px;
        color: white;
        text-align: center;
    }
    
    .shop-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .shop-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
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
    
    /* Product Image Slider Styles */
    .product-image-slider {
        position: relative;
        overflow: hidden;
        background: #f5f5f5;
    }
    
    .product-image-slider .carousel-inner {
        height: 250px;
    }
    
    .product-image-slider .carousel-item img {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }
    
    .product-image-slider .carousel-control-prev,
    .product-image-slider .carousel-control-next {
        opacity: 0;
        transition: opacity 0.3s;
        width: 40px;
        height: 40px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.6);
        border-radius: 50%;
        z-index: 10;
    }
    
    .product-card:hover .product-image-slider .carousel-control-prev,
    .product-card:hover .product-image-slider .carousel-control-next {
        opacity: 1;
    }
    
    .product-image-slider .carousel-control-prev {
        left: 10px;
    }
    
    .product-image-slider .carousel-control-next {
        right: 10px;
    }
    
    .product-image-slider .carousel-control-prev-icon,
    .product-image-slider .carousel-control-next-icon {
        background-size: 60%;
        width: 20px;
        height: 20px;
    }
    
    .carousel-indicators {
        display: none;
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
        z-index: 2;
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
    
    /* Filter Sidebar Styles */
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
        margin-bottom: 20px;
        border-bottom: 1px solid #eef2f6;
        padding-bottom: 15px;
    }
    
    .filter-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .filter-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        user-select: none;
    }
    
    .filter-title i {
        font-size: 0.8rem;
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
        max-height: 200px;
        overflow-y: auto;
    }
    
    .filter-options li {
        margin-bottom: 8px;
    }
    
    .filter-options label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.85rem;
        color: #64748b;
        transition: all 0.3s;
    }
    
    .filter-options label:hover {
        color: #dc3545;
    }
    
    .filter-options input[type="checkbox"],
    .filter-options input[type="radio"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #dc3545;
    }
    
    .price-range {
        padding: 10px 0;
    }
    
    .size-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .size-btn {
        padding: 5px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        font-size: 0.75rem;
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
        gap: 10px;
    }
    
    .color-btn {
        width: 30px;
        height: 30px;
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
        padding: 8px 15px;
        font-size: 0.8rem;
        cursor: pointer;
        flex: 1;
    }
    
    .btn-reset-filter {
        background: #e2e8f0;
        color: #64748b;
        border: none;
        border-radius: 25px;
        padding: 8px 15px;
        font-size: 0.8rem;
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
        padding: 50px;
        background: white;
        border-radius: 15px;
    }
    
    .sorting-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }
    
    .sort-select {
        padding: 8px 20px;
        border-radius: 30px;
        border: 1px solid #e0e0e0;
        background: white;
        font-size: 0.85rem;
        cursor: pointer;
        outline: none;
    }
    
    @media (max-width: 768px) {
        .product-actions {
            flex-direction: column;
        }
        .btn-add-cart, .btn-buy-now {
            width: 100%;
        }
        .shop-header {
            padding: 40px 0;
        }
        .shop-header h1 {
            font-size: 1.8rem;
        }
        .filter-sidebar {
            position: static;
            margin-bottom: 20px;
        }
        .product-image-slider .carousel-inner {
            height: 200px;
        }
        .product-image-slider .carousel-item img {
            height: 200px;
        }
    }
</style>

<div class="shop-header">
    <div class="container">
        <h1><i class="fas fa-store me-2"></i> Our Shop</h1>
        <p id="categoryDescription">Browse our collection of premium products</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Filter Sidebar -->
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
        
        <div class="col-md-9">
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
            
            <div class="row" id="productsContainer"></div>
        </div>
    </div>
</div>

<script>
    let currentCategoryId = null;
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
    
    async function loadProducts() {
        const loader = document.getElementById('loader');
        const container = document.getElementById('productsContainer');
        loader.style.display = 'block';
        
        try {
            let url = '/api/products';
            if (currentCategoryId) {
                url = `/api/products/category/${currentCategoryId}`;
            }
            
            const response = await fetch(url);
            const products = await response.json();
            allProducts = products;
            filteredProducts = [...products];
            loader.style.display = 'none';
            
            // Extract unique brands
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
        
        // Use all_images array from API
        if (product.all_images && Array.isArray(product.all_images) && product.all_images.length > 0) {
            product.all_images.forEach(img => {
                if (img && img.trim() !== '') {
                    let imageUrl = img.startsWith('http') ? img : '/storage/' + img;
                    if (!images.includes(imageUrl)) {
                        images.push(imageUrl);
                    }
                }
            });
        } 
        else if (product.image) {
            images.push(product.image.startsWith('http') ? product.image : '/storage/' + product.image);
        } 
        else {
            images.push('https://via.placeholder.com/300x300?text=No+Image');
        }
        
        // Limit to max 4 images
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
            const oldPriceHtml = product.discount_price ? `<span class="product-old-price">₹${parseFloat(product.price).toLocaleString()}</span>` : '';
            const discountBadge = product.discount_price ? `<div class="discount-badge">-${discountPercent}%</div>` : '';
            const isInWishlist = wishlist.some(item => item.id === product.id);
            const heartClass = isInWishlist ? 'fas fa-heart' : 'far fa-heart';
            const escapeName = product.name.replace(/'/g, "\\'");
            
            const images = getProductImages(product);
            const carouselId = `productCarousel-${product.id}`;
            const hasMultipleImages = images.length > 1;
            
            return `
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="product-card card">
                        ${discountBadge}
                        <button class="wishlist-btn" onclick="toggleWishlist(${product.id}, '${escapeName}', ${displayPrice}, '${images[0]}', event)">
                            <i class="${heartClass}" id="wishlist-icon-${product.id}"></i>
                        </button>
                        
                        <div id="${carouselId}" class="carousel slide product-image-slider" data-bs-ride="false" data-bs-interval="false">
                            <div class="carousel-inner">
                                ${images.map((imgUrl, idx) => `
                                    <div class="carousel-item ${idx === 0 ? 'active' : ''}">
                                        <img src="${imgUrl}" alt="${product.name}" onclick="goToProductDetail(${product.id}, event)">
                                    </div>
                                `).join('')}
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev" onclick="event.stopPropagation()">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next" onclick="event.stopPropagation()">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        
                        <div class="card-body text-center" onclick="goToProductDetail(${product.id}, event)">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="text-muted">${product.gender || (product.category ? product.category.name : 'Uncategorized')}</p>
                            <div>
                                ${oldPriceHtml}
                                <span class="product-price">₹${parseFloat(displayPrice).toLocaleString()}</span>
                            </div>
                            <div class="product-actions">
                                <button class="btn-add-cart" onclick="addToCart(${product.id}, '${escapeName}', ${displayPrice}, '${images[0]}', event)">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button class="btn-buy-now" onclick="buyNow(${product.id}, '${escapeName}', ${displayPrice}, event)">
                                    <i class="fas fa-bolt"></i> Buy Now
                                </button>
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
    }
    
    // Event listeners
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
        const categoryName = getUrlParameter('name');
        if (categoryName) {
            document.getElementById('categoryDescription').innerHTML = `Browse our collection of ${decodeURIComponent(categoryName)} products`;
        }
        loadCategoriesAndBrands();
        loadProducts();
        updateNavbarCartCount();
        updateNavbarWishlistCount();
    });
</script>
@endsection