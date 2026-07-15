@extends('layouts.admin')

@section('title', 'Add Coupon')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fas fa-plus me-2"></i> Add New Coupon</h4>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.coupons.store') }}" method="POST" id="couponForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="code" id="couponCode"
                                    class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}"
                                    placeholder="e.g., SAVE10" required>
                                <button type="button" class="btn btn-success" onclick="generateCouponCode()">
                                    <i class="fas fa-sync-alt me-1"></i> Generate
                                </button>
                            </div>
                            <small class="text-muted">Click "Generate" to auto-generate a unique 6-digit alphanumeric code,
                                or enter manually</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Coupon Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="e.g., 10% Off First Order">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select name="type" id="discountType"
                                class="form-control @error('type') is-invalid @enderror" required>
                                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage
                                    (%)</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="value"
                                class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}"
                                placeholder="10" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Max Discount (Optional)</label>
                            <input type="number" step="0.01" name="max_discount"
                                class="form-control @error('max_discount') is-invalid @enderror"
                                value="{{ old('max_discount') }}" placeholder="100">
                            <small class="text-muted">Only for percentage discounts</small>
                            @error('max_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Min Order Amount</label>
                            <input type="number" step="0.01" name="min_order_amount"
                                class="form-control @error('min_order_amount') is-invalid @enderror"
                                value="{{ old('min_order_amount', 0) }}" placeholder="0">
                            @error('min_order_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Usage Limit</label>
                            <input type="number" name="usage_limit"
                                class="form-control @error('usage_limit') is-invalid @enderror"
                                value="{{ old('usage_limit') }}" placeholder="Leave empty for unlimited">
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Per User Limit</label>
                            <input type="number" name="per_user_limit"
                                class="form-control @error('per_user_limit') is-invalid @enderror"
                                value="{{ old('per_user_limit', 1) }}" placeholder="1">
                            @error('per_user_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date"
                                class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Create Coupon
                    </button>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function generateCouponCode() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';

            // Generate 6 character code
            for (let i = 0; i < 6; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                code += characters[randomIndex];
            }

            // Set the generated code
            document.getElementById('couponCode').value = code;

            // Check if code already exists (AJAX)
            checkCodeExists(code);
        }

        function checkCodeExists(code) {
            const input = document.getElementById('couponCode');

            fetch(`/admin/coupons/check-code?code=${code}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // Code exists, generate a new one
                        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        let newCode = '';
                        for (let i = 0; i < 6; i++) {
                            newCode += characters[Math.floor(Math.random() * characters.length)];
                        }
                        input.value = newCode;
                        // Recursively check again
                        checkCodeExists(newCode);
                    } else {
                        // Code is unique, show success
                        input.style.borderColor = '#28a745';
                        input.style.backgroundColor = '#f0fff4';
                        setTimeout(() => {
                            input.style.borderColor = '';
                            input.style.backgroundColor = '';
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error checking code:', error);
                    // If API fails, still use the generated code
                });
        }

        // Also allow manual typing - remove green background when user types
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('couponCode');
            if (codeInput) {
                codeInput.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                    this.style.borderColor = '';
                    this.style.backgroundColor = '';
                });
            }
        });
    </script>
@endsection
