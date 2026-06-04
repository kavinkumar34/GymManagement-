@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-edit"></i> Edit Product: {{ $product->name }}</h4>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" id="productForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Basic Information</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Top Category <span class="text-danger">*</span></label>
                                            <select name="top_category_id" id="top_category" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($topCategories as $tc)
                                                    <option value="{{ $tc->id }}" {{ $product->top_category_id == $tc->id ? 'selected' : '' }}>
                                                        {{ $tc->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="category" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Sub Category <span class="text-danger">*</span></label>
                                            <select name="sub_category_id" id="sub_category" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($subCategories as $sub)
                                                    <option value="{{ $sub->id }}" {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>
                                                        {{ $sub->name }}
                                                    </option>
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
                                                    <option value="{{ $b->id }}" {{ $product->brand_id == $b->id ? 'selected' : '' }}>
                                                        {{ $b->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Product Type</label>
                                            <select name="product_type_id" class="form-control">
                                                <option value="">-- Select --</option>
                                                @foreach($productTypes as $pt)
                                                    <option value="{{ $pt->id }}" {{ $product->product_type_id == $pt->id ? 'selected' : '' }}>
                                                        {{ $pt->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Size Chart</label>
                                            <select name="size_chart_id" class="form-control">
                                                <option value="">-- Select --</option>
                                                @foreach($sizeCharts as $sc)
                                                    <option value="{{ $sc->id }}" {{ $product->size_chart_id == $sc->id ? 'selected' : '' }}>
                                                        {{ $sc->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Description</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label>Full Description</label>
                                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-4">
                            <!-- Pricing -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Pricing</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Price (₹) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Discount Price</label>
                                        <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>MRP</label>
                                        <input type="number" step="0.01" name="mrp" class="form-control" value="{{ old('mrp', $product->mrp) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>GST (%)</label>
                                        <select name="gst_percentage" class="form-control">
                                            <option value="0" {{ $product->gst_percentage == 0 ? 'selected' : '' }}>0%</option>
                                            <option value="5" {{ $product->gst_percentage == 5 ? 'selected' : '' }}>5%</option>
                                            <option value="12" {{ $product->gst_percentage == 12 ? 'selected' : '' }}>12%</option>
                                            <option value="18" {{ $product->gst_percentage == 18 ? 'selected' : '' }}>18%</option>
                                            <option value="28" {{ $product->gst_percentage == 28 ? 'selected' : '' }}>28%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Inventory</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Stock Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Min Stock Alert</label>
                                        <input type="number" name="min_stock_alert" class="form-control" value="{{ old('min_stock_alert', $product->min_stock_alert ?? 5) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Weight</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}">
                                            <select name="weight_unit" class="form-control" style="width: 80px;">
                                                <option value="kg" {{ $product->weight_unit == 'kg' ? 'selected' : '' }}>kg</option>
                                                <option value="g" {{ $product->weight_unit == 'g' ? 'selected' : '' }}>g</option>
                                                <option value="lb" {{ $product->weight_unit == 'lb' ? 'selected' : '' }}>lb</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Dimensions</label>
                                        <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions', $product->dimensions) }}" placeholder="L × W × H cm">
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="Draft" {{ $product->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Features</div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="featured" {{ $product->is_featured ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">Featured Product</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_best_seller" value="1" class="form-check-input" id="bestseller" {{ $product->is_best_seller ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bestseller">Best Seller</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_new_arrival" value="1" class="form-check-input" id="newarrival" {{ $product->is_new_arrival ? 'checked' : '' }}>
                                        <label class="form-check-label" for="newarrival">New Arrival</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_trending" value="1" class="form-check-input" id="trending" {{ $product->is_trending ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trending">Trending</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Images Section -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Product Images</div>
                                <div class="card-body">
<!-- Current Images Display -->
<div class="card mb-3">
    <div class="card-header bg-light">Current Product Images</div>
    <div class="card-body">
        <div class="row" id="existing_images_container">
            @php
                $productImages = \App\Models\ProductImage::where('product_id', $product->id)->orderBy('display_order')->get();
            @endphp
            @forelse($productImages as $imgIndex => $img)
            <div class="col-3 mb-2 position-relative existing-image-item" data-id="{{ $img->id }}">
                <img src="{{ asset('storage/' . $img->image_path) }}" class="img-thumbnail" style="width: 100%; height: 80px; object-fit: cover;">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing-image" data-id="{{ $img->id }}" style="border-radius: 50%; padding: 2px 5px; margin: 2px;">
                    <i class="fas fa-times"></i>
                </button>
                <span class="badge {{ $img->is_main ? 'bg-primary' : 'bg-secondary' }} d-block text-center mt-1">{{ $img->is_main ? 'Main' : 'Image ' . ($imgIndex + 1) }}</span>
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted">No images uploaded for this product.</p>
            </div>
            @endforelse
        </div>
        <input type="hidden" name="deleted_images" id="deleted_images" value="">
    </div>
</div>

                                    <!-- Add New Images -->
                                    <div class="mb-3">
                                        <label class="d-block">Add More Images <span class="text-muted">(Max 4 total)</span></label>
                                        <div class="image-upload-area" onclick="document.getElementById('product_images_input').click()">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                            <p class="mb-0">Click to upload images</p>
                                            <small class="text-muted">You can select up to 4 images total</small>
                                        </div>
                                        <input type="file" id="product_images_input" name="new_images[]" class="d-none" accept="image/*" multiple onchange="previewNewImages(this)">
                                        <div id="new_images_preview" class="image-preview-container mt-3"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Return & Warranty -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">Return & Warranty</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Return Days</label>
                                        <select name="return_days" class="form-control">
                                            <option value="7" {{ $product->return_days == 7 ? 'selected' : '' }}>7 Days</option>
                                            <option value="15" {{ $product->return_days == 15 ? 'selected' : '' }}>15 Days</option>
                                            <option value="30" {{ $product->return_days == 30 ? 'selected' : '' }}>30 Days</option>
                                            <option value="0" {{ $product->return_days == 0 ? 'selected' : '' }}>Non-returnable</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Warranty (Months)</label>
                                        <input type="number" name="warranty_months" class="form-control" value="{{ old('warranty_months', $product->warranty_months ?? 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let newImageFiles = [];
    let existingImageCount = {{ $productImages->count() ?? 0 }};
    let deletedImageIds = [];

    // Remove existing image
    $('.remove-existing-image').click(function() {
        let imageId = $(this).data('id');
        deletedImageIds.push(imageId);
        $('#deleted_images').val(JSON.stringify(deletedImageIds));
        $(this).closest('.existing-image-item').remove();
        existingImageCount--;
    });

    // Preview new images
    function previewNewImages(input) {
        let files = Array.from(input.files);
        let totalFiles = existingImageCount + newImageFiles.length + files.length;
        
        if (totalFiles > 4) {
            alert('Maximum 4 images allowed. You already have ' + existingImageCount + ' images.');
            input.value = '';
            return;
        }
        
        newImageFiles = [...newImageFiles, ...files];
        updateNewImagePreview();
        input.value = '';
    }

    function updateNewImagePreview() {
        let preview = $('#new_images_preview');
        preview.empty();
        
        newImageFiles.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.append(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}">
                        <button type="button" class="remove-img" onclick="removeNewImage(${index})">×</button>
                        <span class="badge bg-info d-block text-center">New</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeNewImage(index) {
        newImageFiles.splice(index, 1);
        updateNewImagePreview();
    }

    // Form submit handler
    $('#productForm').on('submit', function(e) {
        let formData = new FormData(this);
        
        // Append new images
        for (let i = 0; i < newImageFiles.length; i++) {
            formData.append('new_images[]', newImageFiles[i]);
        }
        
        // No AJAX, let normal submit happen
        return true;
    });

    // Dynamic category filtering
    $('#top_category').change(function() {
        let topId = $(this).val();
        if (topId) {
            $.get(`/admin/get-categories/${topId}`, function(data) {
                let categorySelect = $('#category');
                categorySelect.empty().append('<option value="">-- Select Category --</option>');
                $.each(data, function(i, cat) {
                    categorySelect.append(`<option value="${cat.id}">${cat.name}</option>`);
                });
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
            });
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
</script>
@endsection