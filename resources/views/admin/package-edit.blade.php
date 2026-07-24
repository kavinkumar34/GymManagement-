@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-edit"></i>
                    Edit Package
                </h4>

                <a href="{{ route('admin.package.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
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

<form action="{{ route('admin.package.update', $package->id) }}"
      method="POST"
      enctype="multipart/form-data">
                          @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Package Name -->
                        <div class="col-md-6 mb-3">
                            <label for="package_name" class="form-label fw-bold">
                                Package Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="package_name"
                                id="package_name"
                                class="form-control @error('package_name') is-invalid @enderror"
                                value="{{ old('package_name', $package->package_name) }}"
                                required>
                            @error('package_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Package Image -->
<div class="col-md-6 mb-3">

    <label class="form-label fw-bold">
        Package Image
    </label>

    <input type="file"
           name="image"
           id="image"
           class="form-control"
           accept="image/*">

    @error('image')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <div class="mt-2">

        @if($package->image)

            <img id="imagePreview"
                 src="{{ asset('storage/'.$package->image) }}"
                 width="120"
                 height="120"
                 class="border rounded"
                 style="object-fit:cover;">

        @else

            <img id="imagePreview"
                 src=""
                 width="120"
                 height="120"
                 class="border rounded"
                 style="display:none;object-fit:cover;">

        @endif

    </div>

</div>

                        <!-- Price -->
                        <div class="col-md-3 mb-3">
                            <label for="price" class="form-label fw-bold">
                                Price (₹) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                name="price"
                                id="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $package->price) }}"
                                step="0.01"
                                min="0"
                                required>
                            @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="col-md-3 mb-3">
                            <label for="duration" class="form-label fw-bold">
                                Duration <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                name="duration"
                                id="duration"
                                class="form-control @error('duration') is-invalid @enderror"
                                value="{{ old('duration', $package->duration) }}"
                                min="1"
                                required>
                            @error('duration')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Duration Type -->
                        <div class="col-md-6 mb-3">
                            <label for="duration_type" class="form-label fw-bold">
                                Duration Type <span class="text-danger">*</span>
                            </label>
                            <select name="duration_type"
                                id="duration_type"
                                class="form-select @error('duration_type') is-invalid @enderror"
                                required>

                                <option value="Days" {{ old('duration_type', $package->duration_type) == 'Days' ? 'selected' : '' }}>
                                    Days
                                </option>
                                <option value="Months" {{ old('duration_type', $package->duration_type) == 'Months' ? 'selected' : '' }}>
                                    Months
                                </option>
                                <option value="Years" {{ old('duration_type', $package->duration_type) == 'Years' ? 'selected' : '' }}>
                                    Years
                                </option>

                            </select>
                            @error('duration_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                                <option value="Active" {{ old('status', $package->status) == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="Inactive" {{ old('status', $package->status) == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-bold">
                                Description
                            </label>
                            <textarea name="description"
                                id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="3">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Included Features -->
                        <div class="col-md-12 mb-3">
                            <label for="included_features" class="form-label fw-bold">
                                Included Features
                                <small class="text-muted">(One per line)</small>
                            </label>
                            <textarea name="included_features"
                                id="included_features"
                                class="form-control @error('included_features') is-invalid @enderror"
                                rows="5">{{ old('included_features', $package->included_features) }}</textarea>
                            @error('included_features')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Each feature should be on a new line
                            </small>
                        </div>

                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Update Package
                        </button>

                        <a href="{{ route('admin.package.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
<script>
document.getElementById('image').addEventListener('change', function(e){

    let preview=document.getElementById('imagePreview');

    if(e.target.files.length){

        preview.src=URL.createObjectURL(e.target.files[0]);
        preview.style.display='block';

    }

});
</script>

@endsection