@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4><i class="fas fa-edit text-primary me-2"></i> Edit Combo: {{ $offer->offer_name }}</h4>
                    <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card" style="max-width: 900px; margin: 0 auto;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST" id="offerForm">
                            @csrf @method('PUT')

                            <div class="row">
                                <!-- Offer Type - Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Offer Type
                                            <span class="text-danger">*</span></label>
                                        <select name="offer_type" id="offerType" class="form-control form-control-sm"
                                            required onchange="toggleProductSelection()">
                                            <option value="">-- Select --</option>
                                            <option value="combo" {{ $offer->offer_type == 'combo' ? 'selected' : '' }}>
                                                Multiple Product Combo</option>
                                            <option value="bogo" {{ $offer->offer_type == 'bogo' ? 'selected' : '' }}>
                                                Single Product</option>
                                        </select>
                                        <small class="text-muted" style="font-size: 11px;">Select "Multiple Product Combo"
                                            for 2+ products</small>
                                    </div>
                                </div>

                                <!-- Combo Name - Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Combo Name
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="offer_name" id="offerName"
                                            class="form-control form-control-sm" value="{{ $offer->offer_name }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Offer Code -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Offer Code
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="offer_code" class="form-control form-control-sm"
                                            value="{{ $offer->offer_code }}" required>
                                        <small class="text-muted" style="font-size: 11px;">Unique code for this
                                            offer</small>
                                    </div>
                                </div>

                                <!-- Usage Limit -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Usage
                                            Limit</label>
                                        <input type="number" name="usage_limit_total" class="form-control form-control-sm"
                                            value="{{ $offer->usage_limit_total }}" placeholder="Leave empty = Unlimited"
                                            min="0">
                                        <small class="text-muted" style="font-size: 11px;">Total times this offer can be
                                            used</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Minimum Order Amount -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Min Order
                                            Amount</label>
                                        <input type="number" step="0.01" name="min_order_amount"
                                            class="form-control form-control-sm" value="{{ $offer->min_order_amount }}"
                                            placeholder="e.g., 500">
                                        <small class="text-muted" style="font-size: 11px;">Minimum order to apply
                                            offer</small>
                                    </div>
                                </div>

                                <!-- Max Discount -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Max
                                            Discount</label>
                                        <input type="number" step="0.01" name="max_discount_amount"
                                            class="form-control form-control-sm" value="{{ $offer->max_discount_amount }}"
                                            placeholder="e.g., 1000">
                                        <small class="text-muted" style="font-size: 11px;">Maximum discount amount</small>
                                    </div>
                                </div>
                            </div>

                            <!-- ===== SELECT PRODUCTS SECTION ===== -->
                            <div class="mb-2">
                                <label class="form-label" style="font-size: 13px; font-weight: 600;">
                                    Select Products <span class="text-danger">*</span>
                                    <span id="productSelectionHint"
                                        style="font-size: 11px; font-weight: normal; color: #6c757d;">
                                        @if ($offer->offer_type == 'bogo')
                                            (Select one product for single product offer)
                                        @else
                                            (Select 2 or more products for combo offer)
                                        @endif
                                    </span>
                                </label>

                                <!-- ===== FOR SINGLE PRODUCT - DROPDOWN ===== -->
                                <div id="singleProductDropdown"
                                    style="{{ $offer->offer_type == 'bogo' ? 'display:block;' : 'display:none;' }}">
                                    <select name="single_product_id" id="singleProductSelect"
                                        class="form-control form-control-sm">
                                        <option value="">-- Select a product --</option>
                                        @foreach ($products as $product)
                                            @php
                                                $selected = false;
                                                if (is_string($offer->applicable_products)) {
                                                    $productIds = json_decode($offer->applicable_products, true);
                                                } else {
                                                    $productIds = $offer->applicable_products ?? [];
                                                }
                                                if (is_array($productIds) && in_array($product->id, $productIds)) {
                                                    $selected = true;
                                                }
                                            @endphp
                                            <option value="{{ $product->id }}" {{ $selected ? 'selected' : '' }}>
                                                {{ $product->name }} (₹{{ number_format($product->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted" style="font-size: 11px;">Select one product for single
                                        product offer</small>
                                </div>

                                <!-- ===== FOR MULTIPLE PRODUCTS - CHECKBOX LIST ===== -->
                                <div id="multipleProductsCheckbox"
                                    style="{{ $offer->offer_type == 'combo' ? 'display:block;' : 'display:none;' }}">
                                    <div class="border rounded p-2"
                                        style="max-height: 200px; overflow-y: auto; background: #f8f9fa;">
                                        @php
                                            if (is_string($offer->applicable_products)) {
                                                $selectedProducts = json_decode($offer->applicable_products, true);
                                            } else {
                                                $selectedProducts = $offer->applicable_products ?? [];
                                            }
                                            $selectedProducts = is_array($selectedProducts) ? $selectedProducts : [];
                                        @endphp
                                        @forelse ($products as $product)
                                            <div
                                                style="padding: 6px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;">
                                                <input type="checkbox" name="applicable_products[]"
                                                    value="{{ $product->id }}" id="product_{{ $product->id }}"
                                                    {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}
                                                    style="width: 18px; height: 18px; margin-right: 12px; cursor: pointer; flex-shrink: 0; accent-color: #0d6efd;">
                                                <label for="product_{{ $product->id }}"
                                                    style="font-size: 13px; cursor: pointer; flex: 1; margin-bottom: 0;">
                                                    {{ $product->name }}
                                                    <span class="text-muted"
                                                        style="font-size: 11px;">(₹{{ number_format($product->price, 2) }})</span>
                                                </label>
                                            </div>
                                        @empty
                                            <div class="text-center text-muted" style="padding: 20px;">
                                                <i class="fas fa-box-open fa-2x mb-2"></i>
                                                <p>No products available. Please add products first.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    <small class="text-muted" style="font-size: 11px;">Select 2 or more products for combo
                                        offer</small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Discount Type -->
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Discount Type
                                            <span class="text-danger">*</span></label>
                                        <select name="discount_type" class="form-control form-control-sm" required>
                                            <option value="">-- Select --</option>
                                            <option value="fixed"
                                                {{ $offer->discount_type == 'fixed' ? 'selected' : '' }}>Flat (₹)</option>
                                            <option value="percentage"
                                                {{ $offer->discount_type == 'percentage' ? 'selected' : '' }}>Percentage
                                                (%)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Discount
                                            Value <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="discount_value"
                                            class="form-control form-control-sm" value="{{ $offer->discount_value }}"
                                            placeholder="e.g., 100" required>
                                        <small class="text-muted" style="font-size: 11px;">Amount or % value</small>
                                    </div>
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Expiry Date
                                            <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="end_date" class="form-control form-control-sm"
                                            value="{{ $offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d\TH:i') : '' }}"
                                            required>
                                    </div>
                                </div>
                                <input type="hidden" name="start_date"
                                    value="{{ $offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i') }}">
                            </div>

                            <!-- Per User Limit -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Per User
                                            Limit</label>
                                        <input type="number" name="usage_limit_per_user"
                                            class="form-control form-control-sm"
                                            value="{{ $offer->usage_limit_per_user ?? 1 }}">
                                        <small class="text-muted" style="font-size: 11px;">How many times a single user
                                            can use this offer</small>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Status <span
                                                class="text-danger">*</span></label>
                                        <select name="status" class="form-control form-control-sm" required>
                                            <option value="active" {{ $offer->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive" {{ $offer->status == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="scheduled"
                                                {{ $offer->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="expired" {{ $offer->status == 'expired' ? 'selected' : '' }}>
                                                Expired</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                    <i class="fas fa-save me-1"></i> Update Combo
                                </button>
                                <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== TOGGLE PRODUCT SELECTION BASED ON OFFER TYPE =====
        function toggleProductSelection() {
            var offerType = document.getElementById('offerType').value;
            var singleDropdown = document.getElementById('singleProductDropdown');
            var multipleCheckbox = document.getElementById('multipleProductsCheckbox');
            var hint = document.getElementById('productSelectionHint');

            if (offerType === 'bogo') {
                singleDropdown.style.display = 'block';
                multipleCheckbox.style.display = 'none';
                hint.textContent = '(Select one product for single product offer)';
                document.querySelectorAll('input[name="applicable_products[]"]').forEach(function(cb) {
                    cb.checked = false;
                });
            } else if (offerType === 'combo') {
                singleDropdown.style.display = 'none';
                multipleCheckbox.style.display = 'block';
                hint.textContent = '(Select 2 or more products for combo offer)';
                document.getElementById('singleProductSelect').value = '';
            } else {
                singleDropdown.style.display = 'none';
                multipleCheckbox.style.display = 'block';
                hint.textContent = '(Select 2 or more products for combo offer)';
            }
        }

        // ===== FORM VALIDATION =====
        document.getElementById('offerForm').addEventListener('submit', function(e) {
            var offerType = document.getElementById('offerType').value;
            var btn = document.getElementById('submitBtn');

            if (!offerType) {
                e.preventDefault();
                alert('Please select an offer type');
                return false;
            }

            if (offerType === 'bogo') {
                var singleProduct = document.getElementById('singleProductSelect').value;
                if (!singleProduct) {
                    e.preventDefault();
                    alert('Please select a product for single product offer');
                    return false;
                }
            } else if (offerType === 'combo') {
                var checkboxes = document.querySelectorAll('input[name="applicable_products[]"]:checked');
                if (checkboxes.length < 2) {
                    e.preventDefault();
                    alert('Please select at least 2 products for a combo offer');
                    return false;
                }
            }

            // Show loading
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Updating...';
                btn.disabled = true;
            }
        });

        // ===== SHOW SELECTED COUNT =====
        document.querySelectorAll('input[name="applicable_products[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var checked = document.querySelectorAll('input[name="applicable_products[]"]:checked')
                    .length;
                var hint = document.getElementById('productSelectionHint');
                if (hint && checked > 0) {
                    hint.textContent = '(Selected ' + checked + ' products)';
                }
            });
        });

        // ===== INITIALIZE ON PAGE LOAD =====
        document.addEventListener('DOMContentLoaded', function() {
            toggleProductSelection();
        });
    </script>

    <style>
        .form-control-sm {
            font-size: 13px;
            padding: 4px 8px;
            height: 32px;
        }

        .form-control-sm:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.2);
        }

        input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            cursor: pointer;
            accent-color: #0d6efd;
            flex-shrink: 0;
        }

        input[type="checkbox"]:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check {
            padding: 3px 0;
            margin-bottom: 0;
        }

        .form-check:last-child {
            border-bottom: none !important;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 13px;
        }

        .form-check-label:hover {
            color: #0d6efd;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .border {
            border-color: #dee2e6 !important;
        }

        .btn-sm {
            padding: 5px 15px;
            font-size: 13px;
        }

        .form-control[type="number"] {
            -moz-appearance: textfield;
        }

        .form-control[type="number"]::-webkit-outer-spin-button,
        .form-control[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .text-muted {
            font-size: 11px !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 0.75rem !important;
        }

        .form-label {
            margin-bottom: 0.2rem;
        }
    </style>
@endsection
