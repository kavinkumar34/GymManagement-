@extends('layouts.admin-layout')

@section('content')
    <style>
        .container {
            margin-left: 300px;
            padding: 20px;
        }

        .product-image-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .product-image-placeholder {
            width: 50px;
            height: 50px;
            background: #e9ecef;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 20px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-badge.draft {
            background: #fff3cd;
            color: #856404;
        }

        .action-btns .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .action-btns .btn-view {
            background: #e7f3ff;
            color: #0d6efd;
            border: 1px solid #b6d4fe;
        }

        .action-btns .btn-view:hover {
            background: #0d6efd;
            color: white;
        }

        .action-btns .btn-edit {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffe69c;
        }

        .action-btns .btn-edit:hover {
            background: #856404;
            color: white;
        }

        .action-btns .btn-delete {
            background: #f8d7da;
            color: #dc3545;
            border: 1px solid #f5c2c7;
        }

        .action-btns .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        /* View Modal Styles */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
            background: #f8f9fa;
            border-radius: 16px 16px 0 0;
        }

        .modal-header .modal-title {
            font-weight: 700;
            font-size: 18px;
        }

        .modal-body {
            padding: 25px;
        }

        .product-detail-image {
            width: 100%;
            height: 320px;
            object-fit: contain;
            border-radius: 12px;
            background: #f8f9fa;
            padding: 10px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .detail-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 500;
            color: #1a1a2e;
        }

        .detail-row {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .variant-badge {
            display: inline-block;
            background: #e9ecef;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            margin: 2px 4px 2px 0;
        }

        .variant-badge .size {
            font-weight: 600;
            color: #0d6efd;
        }

        .variant-badge .color {
            color: #6c757d;
        }

        .variant-badge .stock {
            color: #28a745;
            font-weight: 600;
        }

        .gallery-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .gallery-thumb:hover {
            border-color: #0d6efd;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
        }

        .gallery-thumb.active {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px #0d6efd;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .price-tag {
            font-size: 24px;
            font-weight: 700;
            color: #28a745;
        }

        .price-tag .original {
            font-size: 16px;
            color: #6c757d;
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 10px;
        }

        .discount-tag {
            background: #dc3545;
            color: white;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 25px;
            background: #f8f9fa;
            border-radius: 0 0 16px 16px;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }

        .product-detail-left {
            padding-right: 20px;
        }

        .product-detail-right {
            padding-left: 20px;
        }

        .gallery-container {
            margin-top: 15px;
        }

        .gallery-thumbnails {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .gallery-main-image {
            width: 100%;
            height: 320px;
            object-fit: contain;
            border-radius: 12px;
            background: #f8f9fa;
            padding: 10px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px 20px;
        }

        .product-title {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .product-badges {
            margin-bottom: 10px;
        }

        .product-badges .badge {
            font-size: 12px;
            padding: 6px 12px;
        }

        @media (max-width: 768px) {
            .product-detail-left {
                padding-right: 0;
            }

            .product-detail-right {
                padding-left: 0;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .product-detail-image,
            .gallery-main-image {
                height: 250px;
            }

            .gallery-thumb {
                width: 60px;
                height: 60px;
            }
        }
    </style>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2 text-primary"></i>
                    Products
                    <span class="badge bg-secondary ms-2">{{ $products->total() }}</span>
                </h5>
                <div>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Product
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="60">ID</th>
                                <th width="70">Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="text-muted">#{{ $product->id }}</td>
                                    <td>
                                        @php
                                            $mainImage = null;
                                            if ($product->productImages && $product->productImages->count() > 0) {
                                                $mainImage = $product->productImages->where('is_main', 1)->first();
                                                if (!$mainImage) {
                                                    $mainImage = $product->productImages->first();
                                                }
                                            }
                                            $imagePath = $mainImage ? $mainImage->image_path : $product->image;
                                        @endphp
                                        @if ($imagePath)
                                            <img src="{{ asset('storage/' . $imagePath) }}" class="product-image-thumb"
                                                alt="{{ $product->name }}" onerror="this.style.display='none'">
                                        @endif
                                        @if (!$imagePath)
                                            <div class="product-image-placeholder">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $product->category->name ?? 'N/A' }}
                                            @if ($product->subCategory)
                                                > {{ $product->subCategory->name }}
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="price-tag" style="font-size: 18px;">
                                            ₹{{ number_format($product->final_price ?? $product->mrp, 2) }}
                                            @if ($product->final_price && $product->final_price < $product->mrp)
                                                <span class="original" style="font-size: 13px;">
                                                    ₹{{ number_format($product->mrp, 2) }}
                                                </span>
                                                <span class="discount-tag" style="font-size: 10px;">
                                                    -{{ round((($product->mrp - $product->final_price) / $product->mrp) * 100) }}%
                                                </span>
                                            @endif
                                        </div>
                                        <small class="text-muted">Cost: ₹{{ number_format($product->price, 2) }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $totalStock = $product->stock;
                                            if ($product->variants) {
                                                $totalStock += $product->variants->sum('stock');
                                            }
                                        @endphp
                                        <span
                                            class="badge bg-{{ $totalStock > 0 ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                            {{ $totalStock }}
                                        </span>
                                        @if ($product->variants && $product->variants->count() > 0)
                                            <br>
                                            <small class="text-muted">{{ $product->variants->count() }} variants</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge {{ strtolower($product->status) }}">
                                            {{ $product->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns d-flex gap-1">
                                            <button class="btn btn-view" onclick="viewProduct({{ $product->id }})"
                                                title="View Product">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-edit"
                                                title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-delete" onclick="deleteItem({{ $product->id }})"
                                                title="Delete Product">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $product->id }}"
                                                action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
                                        <h6 class="text-muted">No products found</h6>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="fas fa-plus me-1"></i> Add Your First Product
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of
                            {{ $products->total() }} products
                        </small>
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Product Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-box me-2 text-primary"></i>
                        <span id="modalProductTitle">Product Details</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="productDetailBody">
                    <div class="loading-spinner">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading product details...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <a href="#" id="editProductBtn" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ========== DELETE FUNCTION ==========
        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // ========== VIEW PRODUCT FUNCTION ==========
        function viewProduct(productId) {
            var modal = new bootstrap.Modal(document.getElementById('viewProductModal'));
            var body = document.getElementById('productDetailBody');
            var title = document.getElementById('modalProductTitle');

            body.innerHTML = `
            <div class="loading-spinner">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading product details...</p>
                </div>
            </div>
        `;

            modal.show();

            fetch(`/admin/products/${productId}/details`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        var product = data.product;
                        var variants = data.variants || [];
                        var images = data.images || [];

                        title.textContent = product.name + ' - Product Details';

                        // ===== SET FIRST IMAGE AS MAIN =====
                        var mainImageSrc = '';
                        var allImages = [];

                        if (images.length > 0) {
                            // Get all image paths from product_images table
                            images.forEach(function(img) {
                                allImages.push('/storage/' + img.image_path);
                            });
                            mainImageSrc = allImages[0]; // First image as main
                        } else if (product.image) {
                            // Fallback to product.image if no product_images
                            mainImageSrc = '/storage/' + product.image;
                            allImages = [mainImageSrc];
                        } else {
                            mainImageSrc = 'https://via.placeholder.com/400x400?text=No+Image';
                            allImages = [mainImageSrc];
                        }

                        // ===== BUILD GALLERY HTML =====
                        var galleryHtml = '';
                        if (allImages.length > 0) {
                            galleryHtml = `
                        <div class="gallery-container">
                            <span class="detail-label"><i class="fas fa-images me-1"></i> Product Gallery</span>
                            <div class="gallery-thumbnails">
                                ${allImages.map(function(imgSrc, index) {
                                    return `
                                            <div class="gallery-thumb ${index === 0 ? 'active' : ''}" 
                                                onclick="changeGalleryImage(this, '${imgSrc}')" 
                                                title="Image ${index + 1}">
                                                <img src="${imgSrc}" alt="Product Image ${index + 1}" onerror="this.parentElement.style.display='none'">
                                            </div>
                                        `;
                                }).join('')}
                            </div>
                        </div>
                    `;
                        }

                        // ===== BUILD VARIANTS HTML =====
                        var variantsHtml = '';
                        if (variants.length > 0) {
                            variantsHtml = `
                        <div class="mt-3">
                            <span class="detail-label"><i class="fas fa-palette me-1"></i> Variants</span>
                            <div class="mt-2">
                                ${variants.map(function(v) {
                                    return `
                                            <span class="variant-badge">
                                                <span class="size">${v.size || 'N/A'}</span>
                                                ${v.color ? '<span class="color">| ' + v.color + '</span>' : ''}
                                                <span class="stock">| Stock: ${v.stock}</span>
                                                ${v.price ? '| ₹' + parseFloat(v.price).toFixed(2) : ''}
                                            </span>
                                        `;
                                }).join('')}
                            </div>
                        </div>
                    `;
                        }

                        // ===== BUILD PRODUCT DETAILS HTML =====
                        var html = `
                    <div class="row">
                        <!-- LEFT COLUMN - Product Image & Gallery -->
                        <div class="col-md-5 product-detail-left">
                            <img src="${mainImageSrc}" 
                                id="mainProductImage" 
                                class="product-detail-image" 
                                alt="${product.name}"
                                onerror="this.src='https://via.placeholder.com/400x400?text=No+Image'">
                            ${galleryHtml}
                        </div>
                        
                        <!-- RIGHT COLUMN - All Product Details -->
                        <div class="col-md-7 product-detail-right">
                            <h4 class="product-title">${product.name}</h4>
                            
                            <div class="product-badges">
                                ${product.category_name ? '<span class="badge bg-secondary me-1">' + product.category_name + '</span>' : ''}
                                ${product.sub_category_name ? '<span class="badge bg-secondary me-1">' + product.sub_category_name + '</span>' : ''}
                                ${product.brand_name ? '<span class="badge bg-secondary">' + product.brand_name + '</span>' : ''}
                            </div>
                            
                            <div class="mb-3">
                                <div class="price-tag">
                                    ₹${parseFloat(product.final_price || product.price).toFixed(2)}
                                    ${product.mrp && product.final_price < product.mrp ? 
                                        '<span class="original">₹' + parseFloat(product.mrp).toFixed(2) + '</span>' + 
                                        '<span class="discount-tag">-' + Math.round(((product.mrp - product.final_price) / product.mrp) * 100) + '%</span>' 
                                        : ''}
                                </div>
                            </div>
                            
                            <!-- Detail Grid -->
                            <div class="detail-grid">
                                <div class="detail-row">
                                    <div class="detail-label">Cost Price</div>
                                    <div class="detail-value">₹${parseFloat(product.price).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">MRP</div>
                                    <div class="detail-value">₹${parseFloat(product.mrp).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Discount Type</div>
                                    <div class="detail-value">${product.discount_type || 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Discount Value</div>
                                    <div class="detail-value">${product.discount_value ? product.discount_value + '%' : 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Discount Amount</div>
                                    <div class="detail-value">₹${parseFloat(product.discount_amount || 0).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">GST Percentage</div>
                                    <div class="detail-value">${product.gst_percentage || 0}%</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">GST Amount</div>
                                    <div class="detail-value">₹${parseFloat(product.gst_amount || 0).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Total Price (with GST)</div>
                                    <div class="detail-value">₹${parseFloat(product.total_price || 0).toFixed(2)}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Stock</div>
                                    <div class="detail-value">
                                        <span class="badge bg-${product.total_stock > 0 ? 'success' : 'danger'}">
                                            ${product.total_stock}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value">
                                        <span class="status-badge ${(product.status || 'draft').toLowerCase()}">
                                            ${product.status || 'Draft'}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">COD Available</div>
                                    <div class="detail-value">
                                        <span class="badge bg-${product.cod_available ? 'success' : 'secondary'}">
                                            ${product.cod_available ? 'Yes' : 'No'}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Return Days</div>
                                    <div class="detail-value">${product.return_days || 'N/A'} days</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Delivery Days</div>
                                    <div class="detail-value">${product.delivery_days || 'N/A'} days</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Top Category</div>
                                    <div class="detail-value">${product.top_category_id || 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Category</div>
                                    <div class="detail-value">${product.category_id || 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Sub Category</div>
                                    <div class="detail-value">${product.sub_category_id || 'N/A'}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Product Type</div>
                                    <div class="detail-value">${product.product_type_id || 'N/A'}</div>
                                </div>
                            </div>
                            
                            ${variantsHtml}
                            
                            ${product.description ? `
                                    <div class="mt-3">
                                        <span class="detail-label"><i class="fas fa-align-left me-1"></i> Description</span>
                                        <p class="detail-value mt-1">${product.description}</p>
                                    </div>
                                ` : ''}
                        </div>
                    </div>
                `;

                        body.innerHTML = html;

                        // Store all images for gallery functionality
                        window.galleryImages = allImages;

                        document.getElementById('editProductBtn').href = `/admin/products/${product.id}/edit`;

                    } else {
                        body.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                        <h6 class="text-danger">Error loading product details</h6>
                        <p class="text-muted">${data.message || 'Please try again later'}</p>
                    </div>
                `;
                    }
                })
                .catch(error => {
                    body.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                    <h6 class="text-danger">Error loading product details</h6>
                    <p class="text-muted">Please try again later</p>
                </div>
            `;
                    console.error('Error:', error);
                });
        }

        // ========== GALLERY IMAGE CHANGE ==========
        function changeGalleryImage(element, imageSrc) {
            // Remove active class from all thumbnails
            document.querySelectorAll('.gallery-thumb').forEach(function(thumb) {
                thumb.classList.remove('active');
            });

            // Add active class to clicked thumbnail
            element.classList.add('active');

            // Change main image
            var mainImage = document.getElementById('mainProductImage');
            if (mainImage) {
                mainImage.src = imageSrc;
                mainImage.onerror = function() {
                    this.src = 'https://via.placeholder.com/400x400?text=No+Image';
                };
            }
        }
    </script>
@endsection
