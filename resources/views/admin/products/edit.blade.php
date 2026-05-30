@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-edit"></i> Edit Product</h4>
                <a href="{{ route('admin.products') }}" class="btn btn-light">
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

                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Basic Information</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Pricing Information -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Pricing & Stock</h5>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Discount Price (₹)</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}">
                            <small class="text-muted">Leave empty if no discount</small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Images -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Product Images</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current Product Image</label>
                            <div>
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                @else
                                    <div class="bg-light p-3 text-center" style="width: 150px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                        <p class="mb-0">No Image</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Change Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">
                            <small class="text-muted">Leave empty to keep current image (Max 2MB)</small>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                        
                        <!-- Features -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Product Features</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Product Tags</label>
                            <div class="d-flex gap-4">
                                <label class="form-check-label">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}> Featured Product
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}> Best Seller
                                </label>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Product Description</h5>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<script>
    // Preview image before upload
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection