@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:150px;">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-{{ isset($topCategory) ? 'edit' : 'plus' }} me-2 text-primary"></i>
                {{ isset($topCategory) ? 'Edit Top Category' : 'Add New Top Category' }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($topCategory) ? route('admin.topcategories.update', $topCategory->id) : route('admin.topcategories.store') }}" method="POST">
                @csrf
                @if(isset($topCategory)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $topCategory->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">GST Rate (%) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="gst_rate" class="form-control @error('gst_rate') is-invalid @enderror" 
                               value="{{ old('gst_rate', $topCategory->gst_rate ?? '') }}" required>
                        @error('gst_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $topCategory->description ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                   id="is_active" {{ old('is_active', $topCategory->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ isset($topCategory) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.topcategories.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection