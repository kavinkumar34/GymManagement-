@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4><i class="fas fa-edit"></i> Edit Banner</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        @if($banner->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($banner->image) }}" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <small class="text-muted">Leave empty to keep current image (Max: 5MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link" class="form-control" value="{{ $banner->link }}" placeholder="https://example.com">
                        <small class="text-muted">Optional - where the banner should link to</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="order" class="form-control" value="{{ $banner->order }}">
                        <small class="text-muted">Lower number = Higher priority</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ $banner->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $banner->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection