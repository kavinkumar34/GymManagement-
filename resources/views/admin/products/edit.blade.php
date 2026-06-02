@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-edit"></i> Edit Product: {{ $product->name }}</h4>
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

                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" id="productForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Same form as create.blade.php but with values filled from $product -->
                    <!-- Category Selection -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Main Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="main_category" class="form-control" required>
                                <option value="">Select Main Category</option>
                                @foreach($mainCategories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sub Category</label>
                            <select name="sub_category_id" id="sub_category" class="form-control">
                                <option value="">Select Sub Category (Optional)</option>
                                @foreach($subCategories as $subCat)
                                    <option value="{{ $subCat->id }}" {{ $product->sub_category_id == $subCat->id ? 'selected' : '' }}>
                                        {{ $subCat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>
                    </div>
                    
                    <!-- Pricing -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Pricing</h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Discount Price (₹)</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">MRP (Compare at price)</label>
                            <input type="number" step="0.01" name="mrp" class="form-control" value="{{ old('mrp', $product->mrp) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">GST %</label>
                            <select name="gst_percentage" class="form-control">
                                <option value="0" {{ $product->gst_percentage == 0 ? 'selected' : '' }}>0%</option>
                                <option value="5" {{ $product->gst_percentage == 5 ? 'selected' : '' }}>5%</option>
                                <option value="12" {{ $product->gst_percentage == 12 ? 'selected' : '' }}>12%</option>
                                <option value="18" {{ $product->gst_percentage == 18 ? 'selected' : '' }}>18%</option>
                                <option value="28" {{ $product->gst_percentage == 28 ? 'selected' : '' }}>28%</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Stock & Shipping -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Weight</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}">
                                <select name="weight_unit" class="form-control" style="width: 80px;">
                                    <option value="kg" {{ $product->weight_unit == 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="g" {{ $product->weight_unit == 'g' ? 'selected' : '' }}>g</option>
                                    <option value="lb" {{ $product->weight_unit == 'lb' ? 'selected' : '' }}>lb</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Draft" {{ $product->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Return Policy (Days)</label>
                            <select name="return_days" class="form-control">
                                <option value="7" {{ $product->return_days == 7 ? 'selected' : '' }}>7 Days</option>
                                <option value="15" {{ $product->return_days == 15 ? 'selected' : '' }}>15 Days</option>
                                <option value="30" {{ $product->return_days == 30 ? 'selected' : '' }}>30 Days</option>
                                <option value="0" {{ $product->return_days == 0 ? 'selected' : '' }}>Non-returnable</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Images -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Product Images</h5>
                        </div>
                        @if($product->image)
                        <div class="col-md-12 mb-2">
                            <label>Current Main Image:</label>
                            <div>
                                <img src="{{ asset('storage/' . $product->image) }}" style="max-width: 100px;" class="img-thumbnail">
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Change Main Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Additional Images (Multiple)</label>
                            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Description</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Features</h5>
                        </div>
                        <div class="col-md-12">
                            <label class="mr-3"><input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> Featured</label>
                            <label class="mr-3"><input type="checkbox" name="is_best_seller" value="1" {{ $product->is_best_seller ? 'checked' : '' }}> Best Seller</label>
                            <label class="mr-3"><input type="checkbox" name="is_new_arrival" value="1" {{ $product->is_new_arrival ? 'checked' : '' }}> New Arrival</label>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width:150px;" class="img-thumbnail">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection