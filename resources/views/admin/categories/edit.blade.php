@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-edit"></i> Edit Category</h4>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back to Categories
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

                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Top Category <span class="text-danger">*</span></label>
                            <select name="top_category_id" class="form-control" required>
                                <option value="">Select Top Category</option>
                                @foreach($topCategories as $tc)
                                    <option value="{{ $tc->id }}" {{ old('top_category_id', $category->top_category_id) == $tc->id ? 'selected' : '' }}>
                                        {{ $tc->name }} (GST: {{ $tc->gst_rate }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if($category->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$category->image) }}" style="width:80px;" class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon ?? 'fas fa-tag') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ $category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
