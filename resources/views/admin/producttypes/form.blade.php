@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:200px;">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-{{ isset($productType) ? 'edit' : 'plus' }} me-2 text-primary"></i>
                {{ isset($productType) ? 'Edit Product Type' : 'Add Product Type' }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($productType) ? route('admin.producttypes.update', $productType->id) : route('admin.producttypes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($productType)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $productType->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                        <select name="sub_category_id" class="form-control" required>
                            <option value="">Select Sub Category</option>
                            @foreach($subCategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('sub_category_id', $productType->sub_category_id ?? '') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }} ({{ $sub->category->name ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if(isset($productType) && $productType->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$productType->image) }}" style="width:80px;" class="img-thumbnail">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" 
                                {{ old('is_active', $productType->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ isset($productType) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.producttypes.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection