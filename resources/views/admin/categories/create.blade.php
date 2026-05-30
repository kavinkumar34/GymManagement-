@extends('layouts.admin-layout')

@section('content')
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-plus"></i> Add New Category</h4>
                <a href="{{ route('admin.categories') }}" class="btn btn-light">
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

                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            <small class="text-muted">Example: Gym Equipment, Gym Wear, Supplements</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <div class="input-group">
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', 'fas fa-tag') }}" placeholder="fas fa-dumbbell">
                                <span class="input-group-text">
                                    <i class="{{ old('icon', 'fas fa-tag') }}" id="iconPreview"></i>
                                </span>
                            </div>
                            <small class="text-muted">
                                <a href="https://fontawesome.com/v6/icons" target="_blank">Font Awesome icon class</a> 
                                (e.g., fas fa-dumbbell, fas fa-tshirt, fas fa-shoe-prints)
                            </small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <small class="text-muted">Inactive categories will not appear in the store</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Preview</label>
                            <div class="p-3 bg-light rounded text-center">
                                <i class="{{ old('icon', 'fas fa-tag') }}" style="font-size: 3rem;"></i>
                                <p class="mt-2 mb-0 text-muted">Category icon preview</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Category
                        </button>
                        <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Live icon preview when typing
    const iconInput = document.querySelector('input[name="icon"]');
    const iconPreview = document.getElementById('iconPreview');
    const previewBox = document.querySelector('.p-3.bg-light i');
    
    iconInput.addEventListener('input', function() {
        let iconClass = this.value;
        if (iconClass) {
            iconPreview.className = iconClass;
            if (previewBox) {
                previewBox.className = iconClass;
            }
        } else {
            iconPreview.className = 'fas fa-tag';
            if (previewBox) {
                previewBox.className = 'fas fa-tag';
            }
        }
    });
</script>
@endsection