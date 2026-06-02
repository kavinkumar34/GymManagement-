@extends('layouts.admin-layout')

@section('content')
<div class="container" style="margin-left:500px;">
    <div class="card shadow-sm" style="max-width:600px;">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-{{ isset($brand) ? 'edit' : 'plus' }} me-2 text-primary"></i>
                {{ isset($brand) ? 'Edit Brand' : 'Add Brand' }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($brand)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        @if(isset($brand) && $brand->logo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$brand->logo) }}" style="width:60px;" class="img-thumbnail">
                            </div>
                        @endif
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $brand->description ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" 
                                {{ old('is_active', $brand->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ isset($brand) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection