@extends('layouts.admin-layout')

@section('content')
<style>
    .compact-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .compact-form .card {
        margin-bottom: 12px;
        border-radius: 8px;
    }
    .compact-form .card-header {
        padding: 8px 15px;
        font-size: 14px;
        font-weight: 600;
        background-color: #f8f9fa;
    }
    .compact-form .card-body {
        padding: 15px;
    }
    .compact-form .form-label {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #495057;
    }
    .compact-form .form-control, .compact-form .form-select {
        font-size: 13px;
        padding: 6px 10px;
        height: 36px;
        border-radius: 4px;
    }
    .compact-form textarea.form-control {
        height: auto;
    }
    .form-check-label {
        font-size: 12px;
    }
    h5 {
        font-size: 15px !important;
    }
    small, .small {
        font-size: 11px !important;
    }
    .attribute-group {
        background: #f8f9fa;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        border-left: 3px solid #0d6efd;
    }
    .variant-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .btn-xs {
        padding: 2px 8px;
        font-size: 11px;
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
</style>

<div class="compact-container">
    <div class="compact-form" style="margin-left:200px;">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Product
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                    @csrf

                    <div class="row">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-info-circle me-1"></i> Basic Information
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Top Category <span class="text-danger">*</span></label>
                                            <select name="top_category_id" id="top_category" class="form-select" required>
                                                <option value="">-- Select Top Category --</option>
                                                @foreach($topCategories as $tc)
                                                    <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="category" class="form-select" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                            <select name="sub_category_id" id="sub_category" class="form-select" required>
                                                <option value="">-- Select Sub Category --</option>
                                                @foreach($subCategories as $sub)
                                                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Brand</label>
                                            <select name="brand_id" id="brand_id" class="form-select">
                                                <option value="">-- Select Brand --</option>
                                                @foreach($brands as $b)
                                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Product Type</label>
                                            <select name="product_type_id" id="product_type" class="form-select">
                                                <option value="">-- Select Product Type --</option>
                                                @foreach($productTypes as $pt)
                                                    <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Size Chart</label>
                                            <select name="size_chart_id" class="form-select">
                                                <option value="">-- Select Size Chart --</option>
                                                @foreach($sizeCharts as $sc)
                                                    <option value="{{ $sc->id }}">{{ $sc->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Attributes -->
                            <div id="attributes_section" style="display: none;">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-tags me-1"></i> Product Attributes
                                    </div>
                                    <div class="card-body" id="attributes_container"></div>
                                </div>
                            </div>

                            <!-- Variations -->
                            <div id="variations_section" style="display: none;">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-palette me-1"></i> Variants (Color + Size)</span>
                                        <button type="button" id="add_variant" class="btn btn-xs btn-primary">
                                            <i class="fas fa-plus"></i> Add Variant
                                        </button>
                                    </div>
                                    <div class="card-body" id="variations_container"></div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-align-left me-1"></i> Description
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2" placeholder="Brief description for listing page"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Full Description</label>
                                        <textarea name="description" class="form-control" rows="4" placeholder="Detailed product description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-4">
                            <!-- Pricing -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-dollar-sign me-1"></i> Pricing
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="price" id="base_price" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Discount Price (₹)</label>
                                        <input type="number" step="0.01" name="discount_price" class="form-control" placeholder="Sale price">
                                        <small class="text-muted">Final price after discount</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">MRP (₹)</label>
                                        <input type="number" step="0.01" name="mrp" class="form-control" placeholder="Maximum retail price">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">GST Percentage (%)</label>
                                        <select name="gst_percentage" class="form-select">
                                            <option value="0">0%</option>
                                            <option value="5">5%</option>
                                            <option value="12">12%</option>
                                            <option value="18" selected>18%</option>
                                            <option value="28">28%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock & Inventory -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-boxes me-1"></i> Inventory
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" class="form-control" value="0" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Minimum Stock Alert</label>
                                        <input type="number" name="min_stock_alert" class="form-control" value="5" placeholder="Notify when stock below">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Weight</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="weight" class="form-control" placeholder="0.5">
                                            <select name="weight_unit" class="form-select" style="width: 80px;">
                                                <option value="kg">kg</option>
                                                <option value="g">g</option>
                                                <option value="lb">lb</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Dimensions (L × W × H)</label>
                                        <input type="text" name="dimensions" class="form-control" placeholder="30 × 20 × 10 cm">
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-star me-1"></i> Features
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured">
                                            <label class="form-check-label" for="featured">Featured Product</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_best_seller" value="1" id="bestseller">
                                            <label class="form-check-label" for="bestseller">Best Seller</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_new_arrival" value="1" id="newarrival">
                                            <label class="form-check-label" for="newarrival">New Arrival</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_trending" value="1" id="trending">
                                            <label class="form-check-label" for="trending">Trending</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Draft">Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Return & Warranty -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <i class="fas fa-undo-alt me-1"></i> Return & Warranty
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Return Days</label>
                                        <select name="return_days" class="form-select">
                                            <option value="7">7 Days</option>
                                            <option value="15">15 Days</option>
                                            <option value="30" selected>30 Days</option>
                                            <option value="0">Non-returnable</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Warranty (Months)</label>
                                        <input type="number" name="warranty_months" class="form-control" value="0" placeholder="Warranty period in months">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCT IMAGES -->
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <i class="fas fa-image me-1"></i> Product Images (Max 4 Images)
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Main Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewMainImage(this)" required>
                                    <small class="text-muted">Primary product image (Required)</small>
                                    <div id="main_image_preview" class="mt-2"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gallery Images <span class="text-danger">(Up to 3 images)</span></label>
                                    <input type="file" id="gallery_input" class="form-control" accept="image/*" multiple onchange="previewGalleryImages(this)">
                                    <small class="text-muted">Select up to 3 additional images</small>
                                    <div id="gallery_preview" class="image-preview-container mt-2"></div>
                                </div>
                            </div>
                            <div id="image_count_warning" class="alert alert-warning mt-2" style="display: none; font-size: 12px; padding: 8px;">
                                <i class="fas fa-exclamation-triangle me-1"></i> Maximum 4 images allowed (1 main + 3 gallery). Please remove some images.
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-3 text-end">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let selectedAttrs = {};
let variantIndex = 0;
let galleryFiles = [];
let mainImageFile = null;

// ========== DYNAMIC CATEGORY FILTERING ==========

// Top Category change - Filter Categories
$('#top_category').change(function() {
    let topId = $(this).val();
    let categorySelect = $('#category');
    let subCategorySelect = $('#sub_category');
    let productTypeSelect = $('#product_type');
    
    if (topId) {
        $.ajax({
            url: `/admin/get-categories/${topId}`,
            type: 'GET',
            success: function(data) {
                categorySelect.empty().append('<option value="">-- Select Category --</option>');
                $.each(data, function(i, cat) {
                    categorySelect.append(`<option value="${cat.id}">${cat.name}</option>`);
                });
                subCategorySelect.empty().append('<option value="">-- Select Sub Category --</option>');
                productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');
            },
            error: function() {
                categorySelect.empty().append('<option value="">Error loading categories</option>');
            }
        });
    } else {
        categorySelect.empty().append('<option value="">-- Select Category --</option>');
        subCategorySelect.empty().append('<option value="">-- Select Sub Category --</option>');
        productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');
    }
});

// Category change - Filter Sub Categories
$('#category').change(function() {
    let catId = $(this).val();
    let subCategorySelect = $('#sub_category');
    let productTypeSelect = $('#product_type');
    
    if (catId) {
        $.ajax({
            url: `/admin/get-subcategories/${catId}`,
            type: 'GET',
            success: function(data) {
                subCategorySelect.empty().append('<option value="">-- Select Sub Category --</option>');
                $.each(data, function(i, sub) {
                    subCategorySelect.append(`<option value="${sub.id}">${sub.name}</option>`);
                });
                productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');
                loadAttributes(catId);
            },
            error: function() {
                subCategorySelect.empty().append('<option value="">Error loading sub categories</option>');
            }
        });
    } else {
        subCategorySelect.empty().append('<option value="">-- Select Sub Category --</option>');
        productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');
    }
});

// Sub Category change - Filter Product Types
$('#sub_category').change(function() {
    let subId = $(this).val();
    let productTypeSelect = $('#product_type');
    
    if (subId) {
        $.ajax({
            url: `/admin/get-producttypes/${subId}`,
            type: 'GET',
            success: function(data) {
                productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');
                $.each(data, function(i, pt) {
                    productTypeSelect.append(`<option value="${pt.id}">${pt.name}</option>`);
                });
                loadSubCategoryAttributes(subId);
            },
            error: function() {
                productTypeSelect.empty().append('<option value="">Error loading product types</option>');
            }
        });
    } else {
        productTypeSelect.empty().append('<option value="">-- Select Product Type --</option>');
    }
});

function loadAttributes(catId){
    $.get(`/admin/get-category-attributes/${catId}`, function(data){
        if(data.length > 0){
            $('#attributes_section').show();
            renderAttributes(data);
        } else {
            $('#attributes_section').hide();
        }
    }).fail(function(error) {
        console.log('Error loading attributes:', error);
    });
}

function loadSubCategoryAttributes(subId){
    $.get(`/admin/get-subcategory-attributes/${subId}`, function(data){
        if(data.length > 0){
            $('#attributes_section').show();
            renderAttributes(data);
        } else {
            $('#attributes_section').hide();
        }
    }).fail(function(error) {
        console.log('Error loading subcategory attributes:', error);
    });
}

function renderAttributes(attrs){
    let container = $('#attributes_container');
    container.empty();
    selectedAttrs = {};

    $.each(attrs, function(i, attr){
        let html = `<div class="attribute-group">
            <label>${attr.label} ${attr.required ? '<span class="text-danger">*</span>' : ''}</label>
            <select name="attributes[${attr.name}]" class="form-select attribute-select" data-attr="${attr.name}" ${attr.required ? 'required' : ''}>
                <option value="">Select ${attr.label}</option>`;
        $.each(attr.values, function(j, val){
            html += `<option value="${val.value}" data-price="${val.additional_price || 0}">${val.value}${val.additional_price > 0 ? ' (+₹'+val.additional_price+')' : ''}</option>`;
        });
        html += `</select></div>`;
        container.append(html);
    });

    $('.attribute-select').change(function(){
        updateSelectedAttributes();
    });
}

function updateSelectedAttributes(){
    selectedAttrs = {};
    $('.attribute-select').each(function(){
        let val = $(this).val();
        if(val){
            let name = $(this).data('attr');
            let price = $(this).find('option:selected').data('price') || 0;
            selectedAttrs[name] = [{name: name, value: val, price: price}];
        }
    });
    if(Object.keys(selectedAttrs).length > 0){
        generateVariations();
    }
}

function generateVariations(){
    let attrsArray = Object.values(selectedAttrs);
    if(attrsArray.length === 0) return;
    let combinations = [[]];
    for(let attr of attrsArray){
        let newCombos = [];
        for(let combo of combinations){
            for(let val of attr){
                newCombos.push([...combo, val]);
            }
        }
        combinations = newCombos;
    }
    renderVariationFields(combinations);
}

function renderVariationFields(combinations){
    let container = $('#variations_container');
    container.empty();
    $('#variations_section').show();
    let basePrice = $('#base_price').val() || 0;

    $.each(combinations, function(idx, combo){
        let text = combo.map(c => `${c.name}:${c.value}`).join(', ');
        let extraPrice = combo.reduce((sum,c) => sum + (c.price || 0), 0);
        let finalPrice = parseFloat(basePrice) + extraPrice;

        let html = `<div class="variant-card">
            <input type="hidden" name="variants[${idx}][attributes]" value='${JSON.stringify(combo)}'>
            <div class="row g-2">
                <div class="col-4">
                    <label style="font-size: 11px;">Color / Variation</label>
                    <input type="text" name="variants[${idx}][color]" class="form-control form-control-sm" value="${text}" readonly>
                </div>
                <div class="col-3">
                    <label style="font-size: 11px;">Price (₹)</label>
                    <input type="number" step="0.01" name="variants[${idx}][price]" class="form-control form-control-sm variant-price" value="${finalPrice}">
                </div>
                <div class="col-2">
                    <label style="font-size: 11px;">Stock</label>
                    <input type="number" name="variants[${idx}][stock]" class="form-control form-control-sm" value="0">
                </div>
                <div class="col-3">
                    <label style="font-size: 11px;">Image</label>
                    <input type="file" name="variant_images[${idx}][]" class="form-control form-control-sm" accept="image/*">
                </div>
            </div>
        </div>`;
        container.append(html);
    });
}

$('#base_price').on('input', function(){
    let newBase = $(this).val() || 0;
    $('.variant-price').each(function(){
        let extra = 0;
        $(this).closest('.variant-card').find('input[type="hidden"]').each(function(){
            try {
                let combo = JSON.parse($(this).val());
                extra = combo.reduce((s,c) => s + (c.price || 0), 0);
            } catch(e) {}
        });
        $(this).val(parseFloat(newBase) + extra);
    });
});

function previewMainImage(input) {
    let preview = $('#main_image_preview');
    preview.empty();
    if (input.files && input.files[0]) {
        mainImageFile = input.files[0];
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.html(`<div class="image-preview-item">
                <img src="${e.target.result}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                <span class="badge bg-primary mt-1 d-block text-center">Main Image</span>
            </div>`);
        };
        reader.readAsDataURL(input.files[0]);
    }
    updateImageCount();
}

function previewGalleryImages(input) {
    let files = Array.from(input.files);
    let existingCount = galleryFiles.length;
    let availableSlots = 3 - existingCount;
    if (files.length > availableSlots) {
        alert(`You can only add ${availableSlots} more image(s). Maximum 3 gallery images.`);
        input.value = '';
        return;
    }
    galleryFiles = [...galleryFiles, ...files];
    updateGalleryPreview();
    updateImageCount();
}

function updateGalleryPreview() {
    let preview = $('#gallery_preview');
    preview.empty();
    galleryFiles.forEach((file, index) => {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.append(`
                <div class="image-preview-item" data-index="${index}">
                    <img src="${e.target.result}">
                    <button type="button" class="remove-img" onclick="removeGalleryImage(${index})">×</button>
                    <span class="badge bg-secondary mt-1 d-block text-center">Gallery ${index + 1}</span>
                </div>
            `);
        };
        reader.readAsDataURL(file);
    });
}

function removeGalleryImage(index) {
    galleryFiles.splice(index, 1);
    updateGalleryPreview();
    updateImageCount();
    let galleryInput = $('#gallery_input');
    galleryInput.val('');
}

function updateImageCount() {
    let mainCount = mainImageFile ? 1 : 0;
    let galleryCount = galleryFiles.length;
    let totalCount = mainCount + galleryCount;
    if (totalCount > 4) {
        $('#image_count_warning').show();
    } else {
        $('#image_count_warning').hide();
    }
}

$('#productForm').on('submit', function(e) {
    let mainCount = mainImageFile ? 1 : 0;
    let galleryCount = galleryFiles.length;
    let totalCount = mainCount + galleryCount;
    if (totalCount === 0) {
        e.preventDefault();
        alert('Please upload at least 1 main image');
        return false;
    }
    if (totalCount > 4) {
        e.preventDefault();
        alert('Maximum 4 images allowed (1 main + 3 gallery)');
        return false;
    }
});

$('#add_variant').click(function(){
    variantIndex++;
    let html = `<div class="variant-card">
        <div class="row g-2">
            <div class="col-4">
                <label style="font-size: 11px;">Color / Variation</label>
                <input type="text" name="custom_variants[${variantIndex}][color]" class="form-control form-control-sm" placeholder="e.g., Red, Blue">
            </div>
            <div class="col-3">
                <label style="font-size: 11px;">Price (₹)</label>
                <input type="number" step="0.01" name="custom_variants[${variantIndex}][price]" class="form-control form-control-sm" placeholder="Price">
            </div>
            <div class="col-2">
                <label style="font-size: 11px;">Stock</label>
                <input type="number" name="custom_variants[${variantIndex}][stock]" class="form-control form-control-sm" placeholder="Stock" value="0">
            </div>
            <div class="col-3">
                <label style="font-size: 11px;">Image</label>
                <input type="file" name="custom_variant_images[${variantIndex}][]" class="form-control form-control-sm" accept="image/*">
            </div>
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-danger btn-xs remove-variant">
                <i class="fas fa-trash"></i> Remove Variant
            </button>
        </div>
    </div>`;
    $('#variations_container').append(html);
});

$(document).on('click', '.remove-variant', function(){
    $(this).closest('.variant-card').remove();
});
</script>
@endsection