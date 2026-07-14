@extends('layouts.admin-layout')

@section('content')
    <style>
        .size-row {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #e9ecef;
            transition: all 0.3s;
        }

        .size-row:hover {
            background: #fff;
            border-color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
        }

        .size-row .remove-size {
            margin-top: 28px;
        }

        .category-type-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .category-type-badge.topwear {
            background: #cfe2ff;
            color: #084298;
        }

        .category-type-badge.bottomwear {
            background: #d1e7dd;
            color: #0f5132;
        }

        .category-type-badge.footwear {
            background: #fce4ec;
            color: #c62828;
        }

        .field-label {
            font-size: 11px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 2px;
            display: block;
        }

        .field-group {
            margin-bottom: 8px;
        }

        .field-group input {
            font-size: 13px;
        }

        /* Hide fields by default */
        .topwear-field,
        .bottomwear-field,
        .footwear-field {
            display: none;
        }

        .topwear-field.show,
        .bottomwear-field.show,
        .footwear-field.show {
            display: block;
        }

        /* All category fields always visible */
        .all-category-field {
            display: block;
        }
    </style>

    <div class="container-fluid" style="margin-left:300px;">
        <div class="card shadow-sm" style="max-width:1100px;">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-{{ isset($sizeChart) ? 'edit' : 'plus' }} me-2 text-primary"></i>
                    {{ isset($sizeChart) ? 'Edit Size Chart' : 'Add Size Chart' }}
                </h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form
                    action="{{ isset($sizeChart) ? route('admin.sizecharts.update', $sizeChart->id) : route('admin.sizecharts.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($sizeChart))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $sizeChart->title ?? '') }}" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="men"
                                    {{ old('gender', $sizeChart->gender ?? '') == 'men' ? 'selected' : '' }}>Men</option>
                                <option value="women"
                                    {{ old('gender', $sizeChart->gender ?? '') == 'women' ? 'selected' : '' }}>Women
                                </option>
                                <option value="kids"
                                    {{ old('gender', $sizeChart->gender ?? '') == 'kids' ? 'selected' : '' }}>Kids</option>
                                <option value="unisex"
                                    {{ old('gender', $sizeChart->gender ?? '') == 'unisex' ? 'selected' : '' }}>Unisex
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Category Type <span class="text-danger">*</span></label>
                            <select name="category_type" id="category_type" class="form-control" required>
                                <option value="topwear"
                                    {{ old('category_type', $sizeChart->category_type ?? '') == 'topwear' ? 'selected' : '' }}>
                                    Topwear</option>
                                <option value="bottomwear"
                                    {{ old('category_type', $sizeChart->category_type ?? '') == 'bottomwear' ? 'selected' : '' }}>
                                    Bottomwear</option>
                                <option value="footwear"
                                    {{ old('category_type', $sizeChart->category_type ?? '') == 'footwear' ? 'selected' : '' }}>
                                    Footwear</option>
                            </select>
                            <small class="text-muted" id="categoryTypeHint">Select category type to show relevant
                                measurements</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if (isset($sizeChart) && $sizeChart->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $sizeChart->image) }}" style="width:80px;"
                                        class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Default Unit</label>
                            <select name="default_unit" class="form-control">
                                <option value="in"
                                    {{ old('default_unit', $sizeChart->default_unit ?? '') == 'in' ? 'selected' : '' }}>
                                    Inches (in)</option>
                                <option value="cm"
                                    {{ old('default_unit', $sizeChart->default_unit ?? '') == 'cm' ? 'selected' : '' }}>
                                    Centimeters (cm)</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="mt-3">
                        <i class="fas fa-ruler me-2 text-primary"></i> Size Measurements
                        <span id="categoryTypeDisplay" class="category-type-badge topwear ms-2">Topwear</span>
                        <small class="text-muted ms-2" id="fieldInfo">(Size, Chest, Waist, Length, Sleeve)</small>
                    </h6>

                    <div id="sizes-container">
                        @php
                            $sizes = [];
                            if (isset($sizeChart) && $sizeChart->sizes) {
                                if (is_array($sizeChart->sizes)) {
                                    $sizes = $sizeChart->sizes;
                                } else {
                                    $sizes = json_decode($sizeChart->sizes, true) ?: [];
                                }
                            }
                            $categoryType = old('category_type', $sizeChart->category_type ?? 'topwear');
                        @endphp

                        @if (count($sizes) > 0)
                            @foreach ($sizes as $index => $size)
                                <div class="row size-row" data-category="{{ $categoryType }}">
                                    <div class="col-md-2 field-group">
                                        <label class="field-label">Size *</label>
                                        <input type="text" name="sizes[{{ $index }}][size]" class="form-control"
                                            placeholder="e.g., S, M, L" value="{{ $size['size'] ?? '' }}" required>
                                    </div>

                                    <!-- Topwear Fields -->
                                    <div
                                        class="col-md-2 field-group topwear-field {{ $categoryType == 'topwear' ? 'show' : '' }}">
                                        <label class="field-label">Chest</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][chest]"
                                            class="form-control" placeholder="Chest" value="{{ $size['chest'] ?? '' }}">
                                    </div>

                                    <!-- Topwear & Bottomwear Field -->
                                    <div
                                        class="col-md-2 field-group bottomwear-field topwear-field {{ $categoryType == 'topwear' || $categoryType == 'bottomwear' ? 'show' : '' }}">
                                        <label class="field-label">Waist</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][waist]"
                                            class="form-control" placeholder="Waist" value="{{ $size['waist'] ?? '' }}">
                                    </div>

                                    <!-- All Categories Field -->
                                    <div class="col-md-2 field-group all-category-field">
                                        <label class="field-label">Length</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][length]"
                                            class="form-control" placeholder="Length" value="{{ $size['length'] ?? '' }}">
                                    </div>

                                    <!-- Bottomwear Field -->
                                    <div
                                        class="col-md-2 field-group bottomwear-field {{ $categoryType == 'bottomwear' ? 'show' : '' }}">
                                        <label class="field-label">Inseam</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][inseam]"
                                            class="form-control" placeholder="Inseam"
                                            value="{{ $size['inseam'] ?? '' }}">
                                    </div>

                                    <!-- Topwear Field -->
                                    <div
                                        class="col-md-2 field-group topwear-field {{ $categoryType == 'topwear' ? 'show' : '' }}">
                                        <label class="field-label">Sleeve</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][sleeve]"
                                            class="form-control" placeholder="Sleeve"
                                            value="{{ $size['sleeve'] ?? '' }}">
                                    </div>

                                    <!-- Footwear Fields -->
                                    <div
                                        class="col-md-2 field-group footwear-field {{ $categoryType == 'footwear' ? 'show' : '' }}">
                                        <label class="field-label">Width</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][width]"
                                            class="form-control" placeholder="Width" value="{{ $size['width'] ?? '' }}">
                                    </div>
                                    <div
                                        class="col-md-2 field-group footwear-field {{ $categoryType == 'footwear' ? 'show' : '' }}">
                                        <label class="field-label">Heel</label>
                                        <input type="number" step="0.1" name="sizes[{{ $index }}][heel]"
                                            class="form-control" placeholder="Heel" value="{{ $size['heel'] ?? '' }}">
                                    </div>

                                    <div class="col-md-1 field-group" style="margin-top:20px;">
                                        <button type="button" class="btn btn-danger btn-sm remove-size">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row size-row" data-category="{{ $categoryType }}">
                                <div class="col-md-2 field-group">
                                    <label class="field-label">Size *</label>
                                    <input type="text" name="sizes[0][size]" class="form-control"
                                        placeholder="e.g., S, M, L" required>
                                </div>
                                <div
                                    class="col-md-2 field-group topwear-field {{ $categoryType == 'topwear' ? 'show' : '' }}">
                                    <label class="field-label">Chest</label>
                                    <input type="number" step="0.1" name="sizes[0][chest]" class="form-control"
                                        placeholder="Chest">
                                </div>
                                <div
                                    class="col-md-2 field-group bottomwear-field topwear-field {{ $categoryType == 'topwear' || $categoryType == 'bottomwear' ? 'show' : '' }}">
                                    <label class="field-label">Waist</label>
                                    <input type="number" step="0.1" name="sizes[0][waist]" class="form-control"
                                        placeholder="Waist">
                                </div>
                                <div class="col-md-2 field-group all-category-field">
                                    <label class="field-label">Length</label>
                                    <input type="number" step="0.1" name="sizes[0][length]" class="form-control"
                                        placeholder="Length">
                                </div>
                                <div
                                    class="col-md-2 field-group bottomwear-field {{ $categoryType == 'bottomwear' ? 'show' : '' }}">
                                    <label class="field-label">Inseam</label>
                                    <input type="number" step="0.1" name="sizes[0][inseam]" class="form-control"
                                        placeholder="Inseam">
                                </div>
                                <div
                                    class="col-md-2 field-group topwear-field {{ $categoryType == 'topwear' ? 'show' : '' }}">
                                    <label class="field-label">Sleeve</label>
                                    <input type="number" step="0.1" name="sizes[0][sleeve]" class="form-control"
                                        placeholder="Sleeve">
                                </div>
                                <div
                                    class="col-md-2 field-group footwear-field {{ $categoryType == 'footwear' ? 'show' : '' }}">
                                    <label class="field-label">Width</label>
                                    <input type="number" step="0.1" name="sizes[0][width]" class="form-control"
                                        placeholder="Width">
                                </div>
                                <div
                                    class="col-md-2 field-group footwear-field {{ $categoryType == 'footwear' ? 'show' : '' }}">
                                    <label class="field-label">Heel</label>
                                    <input type="number" step="0.1" name="sizes[0][heel]" class="form-control"
                                        placeholder="Heel">
                                </div>
                                <div class="col-md-1 field-group" style="margin-top:20px;">
                                    <button type="button" class="btn btn-danger btn-sm remove-size">✕</button>
                                </div>
                            </div>
                        @endif
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
        let sizeIndex =
            {{ isset($sizeChart) && $sizeChart->sizes ? (is_array($sizeChart->sizes) ? count($sizeChart->sizes) : count(json_decode($sizeChart->sizes, true))) : 0 }};

        // ========== UPDATE FIELDS BASED ON CATEGORY TYPE ==========
        function updateFieldsByCategory(categoryType) {
            // Update badge
            var badge = document.getElementById('categoryTypeDisplay');
            var fieldInfo = document.getElementById('fieldInfo');
            var categoryNames = {
                'topwear': 'Topwear',
                'bottomwear': 'Bottomwear',
                'footwear': 'Footwear'
            };
            var fieldNames = {
                'topwear': '(Size, Chest, Waist, Length, Sleeve)',
                'bottomwear': '(Size, Waist, Length, Inseam)',
                'footwear': '(Size, Length, Width, Heel)'
            };

            badge.textContent = categoryNames[categoryType] || 'Topwear';
            badge.className = 'category-type-badge ' + categoryType;
            fieldInfo.textContent = fieldNames[categoryType] || '';

            // Get all size rows
            var rows = document.querySelectorAll('.size-row');

            rows.forEach(function(row) {
                // All categories: Show Size and Length (always visible)

                if (categoryType === 'topwear') {
                    // Show: Chest, Waist, Sleeve
                    row.querySelectorAll('.topwear-field').forEach(function(el) {
                        el.classList.add('show');
                        el.style.display = 'block';
                    });
                    // Hide: Inseam, Width, Heel
                    row.querySelectorAll('.bottomwear-field').forEach(function(el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    });
                    row.querySelectorAll('.footwear-field').forEach(function(el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    });
                } else if (categoryType === 'bottomwear') {
                    // Show: Waist, Inseam
                    row.querySelectorAll('.bottomwear-field').forEach(function(el) {
                        el.classList.add('show');
                        el.style.display = 'block';
                    });
                    // Hide: Chest, Sleeve, Width, Heel
                    row.querySelectorAll('.topwear-field').forEach(function(el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    });
                    row.querySelectorAll('.footwear-field').forEach(function(el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    });
                } else if (categoryType === 'footwear') {
                    // Show: Width, Heel
                    row.querySelectorAll('.footwear-field').forEach(function(el) {
                        el.classList.add('show');
                        el.style.display = 'block';
                    });
                    // Hide: Chest, Waist, Sleeve, Inseam
                    row.querySelectorAll('.topwear-field').forEach(function(el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    });
                    row.querySelectorAll('.bottomwear-field').forEach(function(el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    });
                }
            });

            // Update hint text
            var hint = document.getElementById('categoryTypeHint');
            var hintTexts = {
                'topwear': 'Topwear measurements: Size, Chest, Waist, Length, Sleeve',
                'bottomwear': 'Bottomwear measurements: Size, Waist, Length, Inseam',
                'footwear': 'Footwear measurements: Size, Length, Width, Heel'
            };
            hint.textContent = hintTexts[categoryType] || 'Select category type to show relevant measurements';
        }

        // ========== CATEGORY TYPE CHANGE EVENT ==========
        document.getElementById('category_type')?.addEventListener('change', function() {
            var categoryType = this.value;
            updateFieldsByCategory(categoryType);
        });

        // ========== ADD SIZE ROW ==========
        document.getElementById('add-size')?.addEventListener('click', function() {
            var container = document.getElementById('sizes-container');
            var categoryType = document.getElementById('category_type').value;

            // Check if any row exists and has valid data
            var existingRows = document.querySelectorAll('.size-row');
            var hasValidRow = false;
            existingRows.forEach(function(row) {
                var sizeInput = row.querySelector('input[name*="[size]"]');
                if (sizeInput && sizeInput.value.trim() !== '') {
                    hasValidRow = true;
                }
            });

            var div = document.createElement('div');
            div.className = 'row size-row';
            div.setAttribute('data-category', categoryType);

            // Determine which fields to show based on category
            var chestDisplay = (categoryType === 'topwear') ? 'block' : 'none';
            var waistDisplay = (categoryType === 'topwear' || categoryType === 'bottomwear') ? 'block' : 'none';
            var inseamDisplay = (categoryType === 'bottomwear') ? 'block' : 'none';
            var sleeveDisplay = (categoryType === 'topwear') ? 'block' : 'none';
            var widthDisplay = (categoryType === 'footwear') ? 'block' : 'none';
            var heelDisplay = (categoryType === 'footwear') ? 'block' : 'none';

            div.innerHTML = `
        <div class="col-md-2 field-group">
            <label class="field-label">Size *</label>
            <input type="text" name="sizes[${sizeIndex}][size]" class="form-control" placeholder="e.g., S, M, L" required>
        </div>
        <div class="col-md-2 field-group topwear-field" style="display:${chestDisplay};">
            <label class="field-label">Chest</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][chest]" class="form-control" placeholder="Chest">
        </div>
        <div class="col-md-2 field-group bottomwear-field topwear-field" style="display:${waistDisplay};">
            <label class="field-label">Waist</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][waist]" class="form-control" placeholder="Waist">
        </div>
        <div class="col-md-2 field-group all-category-field">
            <label class="field-label">Length</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][length]" class="form-control" placeholder="Length">
        </div>
        <div class="col-md-2 field-group bottomwear-field" style="display:${inseamDisplay};">
            <label class="field-label">Inseam</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][inseam]" class="form-control" placeholder="Inseam">
        </div>
        <div class="col-md-2 field-group topwear-field" style="display:${sleeveDisplay};">
            <label class="field-label">Sleeve</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][sleeve]" class="form-control" placeholder="Sleeve">
        </div>
        <div class="col-md-2 field-group footwear-field" style="display:${widthDisplay};">
            <label class="field-label">Width</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][width]" class="form-control" placeholder="Width">
        </div>
        <div class="col-md-2 field-group footwear-field" style="display:${heelDisplay};">
            <label class="field-label">Heel</label>
            <input type="number" step="0.1" name="sizes[${sizeIndex}][heel]" class="form-control" placeholder="Heel">
        </div>
        <div class="col-md-1 field-group" style="margin-top:20px;">
            <button type="button" class="btn btn-danger btn-sm remove-size">✕</button>
        </div>
    `;
            container.appendChild(div);

            // Add show class for visible fields
            if (categoryType === 'topwear') {
                div.querySelectorAll('.topwear-field').forEach(function(el) {
                    el.classList.add('show');
                });
            } else if (categoryType === 'bottomwear') {
                div.querySelectorAll('.bottomwear-field').forEach(function(el) {
                    el.classList.add('show');
                });
            } else if (categoryType === 'footwear') {
                div.querySelectorAll('.footwear-field').forEach(function(el) {
                    el.classList.add('show');
                });
            }

            sizeIndex++;
        });

        // ========== REMOVE SIZE ROW ==========
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-size')) {
                var row = e.target.closest('.size-row');
                if (row) {
                    var rows = document.querySelectorAll('.size-row');
                    if (rows.length <= 1) {
                        alert('At least one size row is required!');
                        return;
                    }
                    if (confirm('Remove this size row?')) {
                        row.remove();
                    }
                }
            }
        });

        // ========== INITIAL SETUP ==========
        document.addEventListener('DOMContentLoaded', function() {
            var categoryType = document.getElementById('category_type').value;
            updateFieldsByCategory(categoryType);
        });
    </script>
@endsection
