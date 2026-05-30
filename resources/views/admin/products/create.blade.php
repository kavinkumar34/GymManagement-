@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-plus"></i> Add New Product</h4>
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

                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-12">
                            <h5 class="bg-light p-2">Basic Information</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="fas fa-plus"></i> New Category
                                </button>
                            </div>
                        </div>
                        
                        <!-- Pricing Information -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Pricing & Stock</h5>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Discount Price (₹)</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price') }}">
                            <small class="text-muted">Leave empty if no discount</small>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Images -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Product Images</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Main Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">
                            <small class="text-muted">Upload main product image (JPG, PNG, JPEG - Max 2MB) - Optional</small>
                            <div class="mt-2" id="imagePreview"></div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Additional Images (Multiple)</label>
                            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/jpg" multiple>
                            <small class="text-muted">You can select multiple images - Optional</small>
                        </div>
                        
                        <!-- Features -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Product Features</h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Product Tags</label>
                            <div class="d-flex gap-4">
                                <label class="form-check-label">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> Featured Product
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }}> Best Seller
                                </label>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="col-md-12 mt-3">
                            <h5 class="bg-light p-2">Product Description</h5>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Product
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" id="categoryName" class="form-control" placeholder="e.g., Gym Equipment" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class</label>
                        <input type="text" id="categoryIcon" class="form-control" placeholder="fas fa-dumbbell" value="fas fa-tag">
                        <small class="text-muted">Font Awesome icon class (e.g., fas fa-dumbbell, fas fa-tshirt)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select id="categoryStatus" class="form-control">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addQuickCategory()">Add Category</button>
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
    
    // Quick add category via AJAX
    function addQuickCategory() {
        const name = document.getElementById('categoryName').value;
        const icon = document.getElementById('categoryIcon').value;
        const status = document.getElementById('categoryStatus').value;
        
        if (!name) {
            alert('Please enter category name');
            return;
        }
        
        fetch('/admin/categories/quick-store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: name,
                icon: icon,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.querySelector('select[name="category_id"]');
                const option = document.createElement('option');
                option.value = data.category.id;
                option.text = data.category.name;
                select.appendChild(option);
                option.selected = true;
                
                document.getElementById('categoryName').value = '';
                document.getElementById('categoryIcon').value = 'fas fa-tag';
                document.getElementById('categoryStatus').value = 'Active';
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                modal.hide();
                
                alert('Category added successfully!');
            } else {
                alert(data.message || 'Failed to add category');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding category');
        });
    }
</script>
@endsection