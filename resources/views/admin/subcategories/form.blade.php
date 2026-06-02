@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:150px;">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-{{ isset($subCategory) ? 'edit' : 'plus' }} me-2 text-primary"></i>
                {{ isset($subCategory) ? 'Edit Sub Category' : 'Add Sub Category' }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($subCategory) ? route('admin.subcategories.update', $subCategory->id) : route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($subCategory)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $subCategory->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $subCategory->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if(isset($subCategory) && $subCategory->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$subCategory->image) }}" style="width:80px;" class="img-thumbnail">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" 
                                {{ old('is_active', $subCategory->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ isset($subCategory) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection