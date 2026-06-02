@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid" style="margin-left:300px;">
    <div class="card shadow-sm" style="max-width:900px;">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-{{ isset($sizeChart) ? 'edit' : 'plus' }} me-2 text-primary"></i>
                {{ isset($sizeChart) ? 'Edit Size Chart' : 'Add Size Chart' }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($sizeChart) ? route('admin.sizecharts.update', $sizeChart->id) : route('admin.sizecharts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($sizeChart)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $sizeChart->title ?? '') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="men" {{ old('gender', $sizeChart->gender ?? '') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('gender', $sizeChart->gender ?? '') == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="kids" {{ old('gender', $sizeChart->gender ?? '') == 'kids' ? 'selected' : '' }}>Kids</option>
                            <option value="unisex" {{ old('gender', $sizeChart->gender ?? '') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Category Type</label>
                        <select name="category_type" class="form-control">
                            <option value="topwear" {{ old('category_type', $sizeChart->category_type ?? '') == 'topwear' ? 'selected' : '' }}>Topwear</option>
                            <option value="bottomwear" {{ old('category_type', $sizeChart->category_type ?? '') == 'bottomwear' ? 'selected' : '' }}>Bottomwear</option>
                            <option value="footwear" {{ old('category_type', $sizeChart->category_type ?? '') == 'footwear' ? 'selected' : '' }}>Footwear</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if(isset($sizeChart) && $sizeChart->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$sizeChart->image) }}" style="width:80px;" class="img-thumbnail">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Default Unit</label>
                        <select name="default_unit" class="form-control">
                            <option value="in" {{ old('default_unit', $sizeChart->default_unit ?? '') == 'in' ? 'selected' : '' }}>Inches (in)</option>
                            <option value="cm" {{ old('default_unit', $sizeChart->default_unit ?? '') == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                        </select>
                    </div>
                </div>

                <h6 class="mt-3">Size Measurements</h6>
                <div id="sizes-container">
                    @php 
                        $sizes = isset($sizeChart) && $sizeChart->sizes ? (is_array($sizeChart->sizes) ? $sizeChart->sizes : json_decode($sizeChart->sizes, true)) : []; 
                    @endphp
                    
                    @forelse($sizes as $index => $size)
                    <div class="row mb-2 size-row">
                        <div class="col-md-2">
                            <input type="text" name="sizes[{{ $index }}][size]" class="form-control" placeholder="Size (e.g., S, M, L)" value="{{ $size['size'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[{{ $index }}][chest]" class="form-control" placeholder="Chest" value="{{ $size['chest'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[{{ $index }}][waist]" class="form-control" placeholder="Waist" value="{{ $size['waist'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[{{ $index }}][length]" class="form-control" placeholder="Length" value="{{ $size['length'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[{{ $index }}][inseam]" class="form-control" placeholder="Inseam" value="{{ $size['inseam'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-size">X</button>
                        </div>
                    </div>
                    @empty
                    <div class="row mb-2 size-row">
                        <div class="col-md-2">
                            <input type="text" name="sizes[0][size]" class="form-control" placeholder="Size (e.g., S, M, L)">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[0][chest]" class="form-control" placeholder="Chest">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[0][waist]" class="form-control" placeholder="Waist">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[0][length]" class="form-control" placeholder="Length">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.1" name="sizes[0][inseam]" class="form-control" placeholder="Inseam">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-size">X</button>
                        </div>
                    </div>
                    @endforelse
                </div>
                <button type="button" id="add-size" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-plus"></i> Add Size
                </button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> {{ isset($sizeChart) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('admin.sizecharts.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let sizeIndex = {{ isset($sizes) ? count($sizes) : 0 }};

document.getElementById('add-size')?.addEventListener('click', function(){
    let container = document.getElementById('sizes-container');
    let div = document.createElement('div');
    div.className = 'row mb-2 size-row';
    div.innerHTML = `
        <div class="col-md-2">
            <input type="text" name="sizes[${sizeIndex}][size]" class="form-control" placeholder="Size (e.g., S, M, L)">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.1" name="sizes[${sizeIndex}][chest]" class="form-control" placeholder="Chest">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.1" name="sizes[${sizeIndex}][waist]" class="form-control" placeholder="Waist">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.1" name="sizes[${sizeIndex}][length]" class="form-control" placeholder="Length">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.1" name="sizes[${sizeIndex}][inseam]" class="form-control" placeholder="Inseam">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-size">X</button>
        </div>
    `;
    container.appendChild(div);
    sizeIndex++;
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-size')){
        e.target.closest('.size-row').remove();
    }
});
</script>
@endsection