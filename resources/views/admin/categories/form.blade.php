@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-{{ isset($category) ? 'edit' : 'plus' }} me-2 text-primary"></i>{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h5></div>
        <div class="card-body">
            <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf @if(isset($category)) @method('PUT') @endif
                <div class="row">
                    <div class="col-md-6 mb-3"><label>Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required></div>
                    <div class="col-md-6 mb-3"><label>Top Category <span class="text-danger">*</span></label>
                        <select name="top_category_id" class="form-control" required>
                            <option value="">Select</option>
                            @foreach($topCategories as $tc)
                                <option value="{{ $tc->id }}" {{ old('top_category_id', $category->top_category_id ?? '') == $tc->id ? 'selected' : '' }}>{{ $tc->name }} (GST:{{ $tc->gst_rate }}%)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3"><label>Image</label><input type="file" name="image" class="form-control">@if(isset($category) && $category->image)<div class="mt-2"><img src="{{ asset('storage/'.$category->image) }}" style="width:80px;"></div>@endif</div>
                    <div class="col-md-6 mb-3"><label>Banner</label><input type="file" name="banner" class="form-control">@if(isset($category) && $category->banner)<div class="mt-2"><img src="{{ asset('storage/'.$category->banner) }}" style="width:80px;"></div>@endif</div>
                    <div class="col-md-6 mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->is_active ?? 1) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Active</label></div></div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button><a href="{{ route('admin.categories') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection