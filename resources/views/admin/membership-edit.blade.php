@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-edit"></i>
                    Edit Membership
                </h4>

                <a href="{{ route('admin.membership.index') }}"
                    class="btn btn-light">

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

                <form action="{{ route('admin.membership.update', $membership->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Plan Name -->
                        <div class="col-md-6 mb-3">
                            <label for="plan_name" class="form-label fw-bold">
                                Plan Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                name="plan_name"
                                id="plan_name"
                                class="form-control"
                                value="{{ old('plan_name', $membership->plan_name) }}"
                                required>
                        </div>

                        <!-- Image -->
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label fw-bold">
                                Image
                            </label>
                            <input type="file"
                                name="image"
                                id="image"
                                class="form-control"
                                accept="image/*">

                            @if($membership->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$membership->image) }}"
                                        width="80"
                                        height="80"
                                        style="object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                                    <small class="d-block text-muted mt-1">
                                        Current Image
                                    </small>
                                </div>
                            @endif
                        </div>

                        <!-- Duration -->
                        <div class="col-md-4 mb-3">
                            <label for="duration" class="form-label fw-bold">
                                Duration <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                name="duration"
                                id="duration"
                                class="form-control"
                                value="{{ old('duration', $membership->duration) }}"
                                min="1"
                                required>
                        </div>

                        <!-- Duration Type -->
                        <div class="col-md-4 mb-3">
                            <label for="duration_type" class="form-label fw-bold">
                                Duration Type <span class="text-danger">*</span>
                            </label>
                            <select name="duration_type"
                                id="duration_type"
                                class="form-select"
                                required>

                                <option value="Days"
                                    {{ old('duration_type', $membership->duration_type) == 'Days' ? 'selected' : '' }}>
                                    Days
                                </option>

                                <option value="Months"
                                    {{ old('duration_type', $membership->duration_type) == 'Months' ? 'selected' : '' }}>
                                    Months
                                </option>

                                <option value="Years"
                                    {{ old('duration_type', $membership->duration_type) == 'Years' ? 'selected' : '' }}>
                                    Years
                                </option>

                            </select>
                        </div>

                        <!-- Price -->
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label fw-bold">
                                Price (₹) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                name="price"
                                id="price"
                                class="form-control"
                                value="{{ old('price', $membership->price) }}"
                                step="0.01"
                                min="0"
                                required>
                        </div>

                        <!-- Discount Type -->
                        <div class="col-md-4 mb-3">
                            <label for="discount_type" class="form-label fw-bold">
                                Discount Type
                            </label>
                            <select name="discount_type"
                                id="discount_type"
                                class="form-select">

                                <option value="Flat"
                                    {{ old('discount_type', $membership->discount_type) == 'Flat' ? 'selected' : '' }}>
                                    Flat (₹)
                                </option>

                                <option value="Percentage"
                                    {{ old('discount_type', $membership->discount_type) == 'Percentage' ? 'selected' : '' }}>
                                    Percentage (%)
                                </option>

                            </select>
                        </div>

                        <!-- Discount -->
                        <div class="col-md-4 mb-3">
                            <label for="discount" class="form-label fw-bold">
                                Discount Value
                            </label>
                            <input type="number"
                                name="discount"
                                id="discount"
                                class="form-control"
                                value="{{ old('discount', $membership->discount) }}"
                                step="0.01"
                                min="0">
                            <small class="text-muted">
                                Enter 0 for no discount
                            </small>
                        </div>

                        <!-- Final Price (Auto Calculated - Read Only) -->
                        <div class="col-md-4 mb-3">
                            <label for="final_price" class="form-label fw-bold">
                                Final Price (₹)
                            </label>
                            <input type="text"
                                id="final_price"
                                class="form-control bg-light"
                                value="₹ {{ number_format($membership->final_price, 2) }}"
                                readonly>
                            <small class="text-muted">
                                Auto-calculated after discount
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status"
                                id="status"
                                class="form-select"
                                required>

                                <option value="Active"
                                    {{ old('status', $membership->status) == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="Inactive"
                                    {{ old('status', $membership->status) == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-bold">
                                Description
                            </label>
                            <textarea name="description"
                                id="description"
                                class="form-control"
                                rows="4">{{ old('description', $membership->description) }}</textarea>
                        </div>

                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Update Membership
                        </button>

                        <a href="{{ route('admin.membership.index') }}"
                            class="btn btn-secondary">
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
    // Auto-calculate final price
    document.addEventListener('DOMContentLoaded', function() {

        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount');
        const discountTypeSelect = document.getElementById('discount_type');
        const finalPriceInput = document.getElementById('final_price');

        function calculateFinalPrice() {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const discountType = discountTypeSelect.value;

            let finalPrice = price;

            if (discountType === 'Flat') {
                finalPrice = price - discount;
            } else if (discountType === 'Percentage') {
                finalPrice = price - ((price * discount) / 100);
            }

            if (finalPrice < 0) {
                finalPrice = 0;
            }

            finalPriceInput.value = '₹ ' + finalPrice.toFixed(2);
        }

        // Add event listeners
        priceInput.addEventListener('input', calculateFinalPrice);
        discountInput.addEventListener('input', calculateFinalPrice);
        discountTypeSelect.addEventListener('change', calculateFinalPrice);

        // Initial calculation
        calculateFinalPrice();

    });
</script>

@endsection