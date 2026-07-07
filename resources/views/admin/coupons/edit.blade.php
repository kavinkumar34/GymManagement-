@extends('layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-edit me-2"></i> Edit Coupon: {{ $coupon->code }}</h4>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                               value="{{ old('code', $coupon->code) }}" required>
                        <small class="text-muted">Will be automatically converted to uppercase</small>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Coupon Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $coupon->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="value" class="form-control @error('value') is-invalid @enderror" 
                               value="{{ old('value', $coupon->value) }}" required>
                        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Max Discount (Optional)</label>
                        <input type="number" step="0.01" name="max_discount" class="form-control @error('max_discount') is-invalid @enderror" 
                               value="{{ old('max_discount', $coupon->max_discount) }}">
                        <small class="text-muted">Only for percentage discounts</small>
                        @error('max_discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Min Order Amount</label>
                        <input type="number" step="0.01" name="min_order_amount" class="form-control @error('min_order_amount') is-invalid @enderror" 
                               value="{{ old('min_order_amount', $coupon->min_order_amount ?? 0) }}">
                        @error('min_order_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" 
                               value="{{ old('usage_limit', $coupon->usage_limit) }}">
                        <small class="text-muted">Current used: {{ $coupon->used_count }}</small>
                        @error('usage_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Per User Limit</label>
                        <input type="number" name="per_user_limit" class="form-control @error('per_user_limit') is-invalid @enderror" 
                               value="{{ old('per_user_limit', $coupon->per_user_limit ?? 1) }}">
                        @error('per_user_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                               value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d\TH:i') : '') }}">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                               value="{{ old('end_date', $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i') : '') }}">
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $coupon->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $coupon->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-save me-1"></i> Update Coupon
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection