@extends('layouts.admin-layout')

@section('content')
<style>
    .form-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .form-section-header {
        background: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }
    .form-section-body {
        padding: 20px;
    }
    .image-preview-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .image-preview-item {
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-preview-item .remove-img {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: red;
        color: white;
        border: none;
        font-size: 12px;
        cursor: pointer;
    }
    .variant-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .required-star {
        color: red;
    }
    .image-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    .image-upload-area:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
    }
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
</style>

<div class="container">
    <div class="row" style="margin-left:200px;"> 
        <div class="col-12">
            <div class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-plus-circle me-2 text-primary"></i> Add New Product
                </div>
                <div class="form-section-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="row">
                            <!-- LEFT COLUMN (8 columns) -->
                            <div class="col-md-8">
                                <!-- Basic Information Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Basic Information</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Product Name <span class="required-star">*</span></label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Top Category <span class="required-star">*</span></label>
                                                <select name="top_category_id" id="top_category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($topCategories as $tc)
                                                        <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Category <span class="required-star">*</span></label>
                                                <select name="category_id" id="category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Sub Category <span class="required-star">*</span></label>
                                                <select name="sub_category_id" id="sub_category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($subCategories as $sub)
                                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Brand</label>
                                                <select name="brand_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($brands as $b)
                                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Product Type</label>
                                                <select name="product_type_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($productTypes as $pt)
                                                        <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Size Chart</label>
                                                <select name="size_chart_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($sizeCharts as $sc)
                                                        <option value="{{ $sc->id }}">{{ $sc->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Variants Section (Shows only for Clothing - Category ID 2) -->
                                <div id="variants_section" style="display: none;">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-palette me-1"></i> Product Variants (Size & Color)</span>
                                            <button type="button" id="add_variant" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Add Variant
                                            </button>
                                        </div>
                                        <div class="card-body" id="variants_container"></div>
                                    </div>
                                </div>

                                <!-- Description Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Description</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Short Description</label>
                                            <textarea name="short_description" class="form-control" rows="2" placeholder="Brief description for listing page"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Full Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Detailed product description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN (4 columns) -->
                            <div class="col-md-4">
                                <!-- Pricing Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Pricing</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Price (₹) <span class="required-star">*</span></label>
                                            <input type="number" step="0.01" name="price" class="form-control" required min="0">
                                        </div>
                                        <div class="mb-3">
                                            <label>Discount Price (₹)</label>
                                            <input type="number" step="0.01" name="discount_price" class="form-control" min="0" placeholder="Sale price">
                                        </div>
                                        <div class="mb-3">
                                            <label>MRP (₹)</label>
                                            <input type="number" step="0.01" name="mrp" class="form-control" min="0" placeholder="Maximum retail price">
                                        </div>
                                        <div class="mb-3">
                                            <label>GST (%)</label>
                                            <select name="gst_percentage" class="form-control">
                                                <option value="0">0%</option>
                                                <option value="5">5%</option>
                                                <option value="12">12%</option>
                                                <option value="18" selected>18%</option>
                                                <option value="28">28%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inventory Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Inventory</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Stock Quantity <span class="required-star">*</span></label>
                                            <input type="number" name="stock" id="stock" class="form-control" value="0" min="0" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Min Stock Alert</label>
                                            <input type="number" name="min_stock_alert" class="form-control" value="5" min="0">
                                            <small class="text-muted">Notify when stock reaches this level</small>
                                        </div>
                                        <div class="mb-3">
                                            <label>Weight</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="weight" class="form-control" min="0" placeholder="0.5">
                                                <select name="weight_unit" class="form-control" style="width: 80px;">
                                                    <option value="kg">kg</option>
                                                    <option value="g">g</option>
                                                    <option value="lb">lb</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Dimensions</label>
                                            <input type="text" name="dimensions" class="form-control" placeholder="L × W × H cm">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Draft">Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Features</div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="featured">
                                            <label class="form-check-label" for="featured">Featured Product</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_best_seller" value="1" class="form-check-input" id="bestseller">
                                            <label class="form-check-label" for="bestseller">Best Seller</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_new_arrival" value="1" class="form-check-input" id="newarrival">
                                            <label class="form-check-label" for="newarrival">New Arrival</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_trending" value="1" class="form-check-input" id="trending">
                                            <label class="form-check-label" for="trending">Trending</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Images Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Product Images</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="d-block">Product Images <span class="required-star">*</span> <span class="text-muted">(1 to 4 images)</span></label>
                                            <div class="image-upload-area" onclick="document.getElementById('product_images_input').click()">
                                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                <p class="mb-0">Click to upload images</p>
                                                <small class="text-muted">You can select 1 to 4 images</small>
                                            </div>
                                            <!-- REMOVED required attribute and changed to visible input -->
                                            <input type="file" id="product_images_input" name="images[]" class="form-control mt-2" accept="image/*" multiple style="display: block;" onchange="previewImages(this)">
                                            <div id="images_preview" class="image-preview-container mt-3"></div>
                                            <div id="image_count_warning" class="alert alert-warning mt-2" style="display: none; font-size: 12px; padding: 8px;">
                                                <i class="fas fa-exclamation-triangle me-1"></i> You can upload maximum 4 images. Please remove some images.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Info Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Shipping Info</div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="cod_available" value="1" id="cod" checked>
                                            <label class="form-check-label" for="cod">Cash on Delivery (COD) Available</label>
                                        </div>
                                        <div class="mb-3">
                                            <label>Delivery Time</label>
                                            <select name="delivery_option" class="form-control">
                                                <option value="1_day">Express Delivery (1 Day)</option>
                                                <option value="2_3_days">Fast Delivery (2-3 Days)</option>
                                                <option value="3_5_days">Standard Delivery (3-5 Days)</option>
                                                <option value="5_7_days">Economy Delivery (5-7 Days)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Return & Warranty Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Return & Warranty</div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="return_available" value="1" id="return_available" checked>
                                            <label class="form-check-label" for="return_available">Return Available</label>
                                        </div>
                                        <div class="mb-3">
                                            <label>Return Days</label>
                                            <select name="return_days" class="form-control">
                                                <option value="7">7 Days</option>
                                                <option value="15">15 Days</option>
                                                <option value="30" selected>30 Days</option>
                                                <option value="0">Non-returnable</option>
                                            </select>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="exchange_available" value="1" id="exchange_available">
                                            <label class="form-check-label" for="exchange_available">Exchange Available</label>
                                        </div>
                                        <div class="mb-3">
                                            <label>Warranty (Months)</label>
                                            <input type="number" name="warranty_months" class="form-control" value="0" min="0">
                                            <small class="text-muted">0 = No warranty</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Save Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 ms-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let variantIndex = 0;
    let imageFiles = [];

    // ========== DYNAMIC CATEGORY FILTERING ==========
    
    $('#top_category').change(function() {
        let topId = $(this).val();
        if (topId) {
            $.get(`/admin/get-categories/${topId}`, function(data) {
                let categorySelect = $('#category');
                categorySelect.empty().append('<option value="">-- Select Category --</option>');
                $.each(data, function(i, cat) {
                    categorySelect.append(`<option value="${cat.id}">${cat.name}</option>`);
                });
                $('#sub_category').empty().append('<option value="">-- Select Sub Category --</option>');
                $('select[name="product_type_id"]').empty().append('<option value="">-- Select Product Type --</option>');
            });
        }
    });

    $('#category').change(function() {
        let catId = $(this).val();
        if (catId) {
            $.get(`/admin/get-subcategories/${catId}`, function(data) {
                let subSelect = $('#sub_category');
                subSelect.empty().append('<option value="">-- Select Sub Category --</option>');
                $.each(data, function(i, sub) {
                    subSelect.append(`<option value="${sub.id}">${sub.name}</option>`);
                });
                $('select[name="product_type_id"]').empty().append('<option value="">-- Select Product Type --</option>');
            });
        }
        if (catId == '2') {
            $('#variants_section').show();
        } else {
            $('#variants_section').hide();
            $('#variants_container').empty();
        }
    });

    $('#sub_category').change(function() {
        let subId = $(this).val();
        if (subId) {
            $.get(`/admin/get-producttypes/${subId}`, function(data) {
                let ptSelect = $('select[name="product_type_id"]');
                ptSelect.empty().append('<option value="">-- Select Product Type --</option>');
                $.each(data, function(i, pt) {
                    ptSelect.append(`<option value="${pt.id}">${pt.name}</option>`);
                });
            });
        }
    });

    // ========== VARIANT FUNCTIONS ==========
    
    $('#add_variant').click(function() {
        variantIndex++;
        let html = `<div class="variant-card">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label style="font-size: 11px;">Size</label>
                    <input type="text" name="variants[${variantIndex}][size]" class="form-control form-control-sm" placeholder="e.g., S, M, L, XL">
                </div>
                <div class="col-md-3 mb-2">
                    <label style="font-size: 11px;">Color</label>
                    <input type="text" name="variants[${variantIndex}][color]" class="form-control form-control-sm" placeholder="e.g., Red, Blue">
                </div>
                <div class="col-md-2 mb-2">
                    <label style="font-size: 11px;">Stock</label>
                    <input type="number" name="variants[${variantIndex}][stock]" class="form-control form-control-sm" value="0" min="0">
                </div>
                <div class="col-md-2 mb-2">
                    <label style="font-size: 11px;">Price (₹)</label>
                    <input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm" min="0">
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-variant mt-4">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        </div>`;
        $('#variants_container').append(html);
    });

    $(document).on('click', '.remove-variant', function() {
        $(this).closest('.variant-card').remove();
    });

    // ========== IMAGE FUNCTIONS ==========
    
    function previewImages(input) {
        let files = Array.from(input.files);
        let totalFiles = imageFiles.length + files.length;
        
        if (totalFiles > 4) {
            alert('You can upload maximum 4 images only. You have ' + totalFiles + ' images selected.');
            input.value = '';
            return;
        }
        
        imageFiles = [...imageFiles, ...files];
        updateImagePreview();
        checkImageCount();
    }

    function updateImagePreview() {
        let preview = $('#images_preview');
        preview.empty();
        
        if (imageFiles.length === 0) return;
        
        imageFiles.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.append(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}">
                        <button type="button" class="remove-img" onclick="removeImage(${index})">×</button>
                        <span class="badge ${index === 0 ? 'bg-primary' : 'bg-secondary'} d-block text-center">${index === 0 ? 'Main Image' : 'Image ' + (index + 1)}</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        imageFiles.splice(index, 1);
        updateImagePreview();
        checkImageCount();
        
        // Update the file input
        let dataTransfer = new DataTransfer();
        for (let i = 0; i < imageFiles.length; i++) {
            dataTransfer.items.add(imageFiles[i]);
        }
        document.getElementById('product_images_input').files = dataTransfer.files;
    }
    
    function checkImageCount() {
        if (imageFiles.length > 4) {
            $('#image_count_warning').show();
        } else {
            $('#image_count_warning').hide();
        }
    }

    // ========== FORM SUBMIT HANDLER ==========
    
    $('#productForm').on('submit', function(e) {
        let stock = parseInt($('#stock').val());
        if (isNaN(stock) || stock < 0) {
            e.preventDefault();
            alert('Stock cannot be negative. Please enter 0 or more.');
            return false;
        }
        
        if (imageFiles.length === 0) {
            e.preventDefault();
            alert('Please upload at least 1 product image.');
            return false;
        }
        
        if (imageFiles.length > 4) {
            e.preventDefault();
            alert('Maximum 4 images allowed. Please remove some images.');
            return false;
        }
        
        // Update file input with current images before submit
        let dataTransfer = new DataTransfer();
        for (let i = 0; i < imageFiles.length; i++) {
            dataTransfer.items.add(imageFiles[i]);
        }
        document.getElementById('product_images_input').files = dataTransfer.files;
        
        // Allow normal form submission
        return true;
    });
</script>
@endsection