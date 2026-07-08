@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4><i class="fas fa-plus text-primary me-2"></i> Create New Combo</h4>
                    <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card" style="max-width: 900px; margin: 0 auto;">
                    <div class="card-body" style="padding: 1.5rem;">
                        <form action="{{ route('admin.offers.store') }}" method="POST" id="offerForm">
                            @csrf

                            <div class="row">
                                <!-- Offer Type - Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Offer Type
                                            <span class="text-danger">*</span></label>
                                        <select name="offer_type" id="offerType" class="form-control form-control-sm"
                                            required onchange="toggleProductSelection()">
                                            <option value="">-- Select --</option>
                                            <option value="combo">Multiple Product Combo</option>
                                            <option value="bogo">Single Product</option>
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
                                            class="form-control form-control-sm" placeholder="e.g., Summer Bundle" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Usage Limit -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Usage
                                            Limit</label>
                                        <input type="number" name="usage_limit_total" class="form-control form-control-sm"
                                            placeholder="Leave empty = Unlimited" min="0">
                                        <small class="text-muted" style="font-size: 11px;">Total times this offer can be
                                            used</small>
                                    </div>
                                </div>

                                <!-- Minimum Order Amount -->
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Min Order
                                            Amount</label>
                                        <input type="number" step="0.01" name="min_order_amount"
                                            class="form-control form-control-sm" placeholder="e.g., 500">
                                        <small class="text-muted" style="font-size: 11px;">Minimum order to apply
                                            offer</small>
                                    </div>
                                </div>
                            </div>

                            <!-- ===== SELECT PRODUCTS SECTION ===== -->
                            <div class="mb-2">
                                <label class="form-label" style="font-size: 13px; font-weight: 600;">
                                    Select Products <span class="text-danger">*</span>
                                    <span id="productSelectionHint"
                                        style="font-size: 11px; font-weight: normal; color: #6c757d;">(Select 2 or more
                                        products for combo offer)</span>
                                </label>

                                <!-- ===== FOR SINGLE PRODUCT - DROPDOWN ===== -->
                                <div id="singleProductDropdown" style="display: none;">
                                    <select name="single_product_id" id="singleProductSelect"
                                        class="form-control form-control-sm">
                                        <option value="">-- Select a product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}
                                                (₹{{ number_format($product->price, 2) }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted" style="font-size: 11px;">Select one product for single product
                                        offer</small>
                                </div>

                                <!-- ===== FOR MULTIPLE PRODUCTS - CHECKBOX LIST ===== -->
                                <div id="multipleProductsCheckbox">
                                    <div class="border rounded p-2"
                                        style="max-height: 200px; overflow-y: auto; background: #f8f9fa;">
                                        @forelse ($products as $product)
                                            <div
                                                style="padding: 6px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;">
                                                <input type="checkbox" name="applicable_products[]"
                                                    value="{{ $product->id }}" id="product_{{ $product->id }}"
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
                                            <option value="fixed">Flat (₹)</option>
                                            <option value="percentage">Percentage (%)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Discount
                                            Value <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="discount_value"
                                            class="form-control form-control-sm" placeholder="e.g., 100" required>
                                        <small class="text-muted" style="font-size: 11px;">Amount or % value</small>
                                    </div>
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Expiry Date
                                            <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="end_date" class="form-control form-control-sm"
                                            required>
                                    </div>
                                </div>
                                <input type="hidden" name="start_date" value="{{ now()->format('Y-m-d\TH:i') }}">
                            </div>

                            <!-- Status -->
                            <div class="mb-2">
                                <div class="form-check" style="padding-left: 20px;">
                                    <input type="checkbox" name="status" class="form-check-input" id="statusActive"
                                        value="active" checked>
                                    <label class="form-check-label" for="statusActive" style="font-size: 13px;">
                                        <strong>Active</strong>
                                        <span class="text-muted" style="font-size: 12px;">(Uncheck to make it
                                            Inactive)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                    <i class="fas fa-save me-1"></i> Create Combo
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
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
                btn.disabled = true;
            }
        });

        // ===== AUTO-GENERATE OFFER CODE =====
        document.addEventListener('DOMContentLoaded', function() {
            var nameInput = document.getElementById('offerName');
            var offerCodeInput = document.querySelector('input[name="offer_code"]');

            if (nameInput && offerCodeInput) {
                nameInput.addEventListener('input', function() {
                    var code = this.value
                        .toUpperCase()
                        .replace(/[^A-Z0-9]/g, '')
                        .substring(0, 10);
                    if (code.length > 0) {
                        offerCodeInput.value = code + '-' + Math.floor(Math.random() * 1000);
                    }
                });
            }

            toggleProductSelection();
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
