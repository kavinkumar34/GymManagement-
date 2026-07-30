@extends('layouts.admin-layout')

@section('content')
<style>
    /* ============================================ */
    /* COLOR VARIABLES - MATCHING NAVBAR          */
    /* ============================================ */
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
        --primary-light: #8ab4f8;
        --success: #4caf50;
        --warning: #ffa726;
        --danger: #ef5350;
        --dark: #1a1a2e;
        --gray: #6c757d;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --radius: 10px;
        --radius-lg: 16px;
    }

    .admin-main-content {
        padding: 20px 25px;
        background: #f0f4f8;
        min-height: 100vh;
    }

    .create-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 1100px;
        margin: 0 auto;
    }

    .create-card .card-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: #ffffff;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .create-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .create-card .card-header h4 i {
        color: #4a9eff;
    }

    .create-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .create-card .card-body {
        padding: 20px 24px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        padding: 6px 14px;
        background: var(--light-gray);
        border-radius: var(--radius);
        border-left: 3px solid var(--primary);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 14px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .form-label .text-danger {
        color: var(--danger) !important;
    }

    .form-control {
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        padding: 7px 12px;
        font-size: 13px;
        transition: all 0.3s;
        background: #ffffff;
        height: 38px;
        color: var(--dark);
        width: 100%;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    textarea.form-control {
        height: auto;
        min-height: 50px;
        resize: vertical;
    }

    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
        cursor: pointer;
        color: #1a1a2e !important;
        background-color: #ffffff !important;
    }

    select.form-control option {
        padding: 8px 12px;
        color: #1a1a2e !important;
        background: #ffffff !important;
    }

    select.form-control option:hover,
    select.form-control option:focus {
        background: #e8f4fd !important;
        color: #1a1a2e !important;
    }

    select.form-control option:checked {
        background: #d4e8fc !important;
        color: #1a1a2e !important;
    }

    .input-group-custom {
        display: flex;
        gap: 8px;
    }

    .input-group-custom .form-control {
        flex: 1;
    }

    .input-group-custom .btn-generate {
        padding: 7px 18px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        height: 38px;
    }

    .input-group-custom .btn-generate:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 158, 255, 0.35);
    }

    .compact-row {
        margin-bottom: 0;
    }

    .compact-row .mb-3 {
        margin-bottom: 10px !important;
    }

    .btn-success {
        background: #4caf50;
        color: #fff;
        border: none;
        padding: 9px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-success:hover {
        background: #388e3c;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(76, 175, 80, 0.35);
    }

    .btn-secondary {
        background: #f0f4f8;
        color: var(--gray);
        border: 1px solid var(--border-color);
        padding: 9px 24px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .form-actions {
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .text-muted-sm {
        font-size: 11px;
        color: var(--gray);
        display: block;
        margin-top: 3px;
    }

    @media (max-width: 768px) {
        .admin-main-content { padding: 12px 15px; }
        .create-card .card-header { padding: 12px 16px; flex-direction: column; align-items: flex-start; }
        .create-card .card-header h4 { font-size: 16px; }
        .create-card .card-body { padding: 14px 16px; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
        .input-group-custom { flex-wrap: wrap; }
        .input-group-custom .btn-generate { width: 100%; justify-content: center; }
    }

    @media (max-width: 576px) {
        .create-card .card-header h4 { font-size: 14px; }
        .create-card .card-body { padding: 10px 12px; }
        .form-label { font-size: 11px; }
        .form-control { font-size: 12px; padding: 5px 10px; height: 34px; }
        .section-title { font-size: 12px; padding: 5px 10px; }
        .btn-success, .btn-secondary { padding: 7px 16px; font-size: 12px; }
        .input-group-custom .btn-generate { font-size: 12px; height: 34px; padding: 5px 14px; }
    }
</style>

<div class="admin-main-content">
    <div class="create-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-plus"></i> Add New Coupon</h4>
                <small>Create a new discount coupon</small>
            </div>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary" style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:6px 16px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:500; font-size:12px; transition:all 0.3s;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" style="background:#fce4ec; color:#c62828; border-left:4px solid #ef5350; border-radius:var(--radius); padding:12px 18px; margin-bottom:16px; border:none;">
                    <ul class="mb-0" style="padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.coupons.store') }}" method="POST" id="couponForm">
                @csrf

                <!-- ========================================== -->
                <!-- COUPON DETAILS                             -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-ticket-alt"></i> Coupon Details
                </div>

                <div class="row compact-row">
                    <!-- Coupon Code -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <input type="text" name="code" id="couponCode" class="form-control" value="{{ old('code') }}" placeholder="e.g., SAVE10" required>
                            <button type="button" class="btn-generate" onclick="generateCouponCode()">
                                <i class="fas fa-sync-alt"></i> Generate
                            </button>
                        </div>
                        <small class="text-muted-sm">Click "Generate" to auto-generate a unique code</small>
                        @error('code')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Coupon Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Coupon Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g., 10% Off First Order">
                        @error('name')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- DISCOUNT SETTINGS                          -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-percent"></i> Discount Settings
                </div>

                <div class="row compact-row">
                    <!-- Discount Type -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select name="type" id="discountType" class="form-control" required>
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                        </select>
                        @error('type')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Value -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value') }}" placeholder="10" required>
                        @error('value')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Min Order Amount -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Min Order Amount</label>
                        <input type="number" step="0.01" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', 0) }}" placeholder="0">
                        @error('min_order_amount')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- USAGE LIMITS                               -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-users"></i> Usage Limits
                </div>

                <div class="row compact-row">
                    <!-- Usage Limit -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}" placeholder="Unlimited">
                        <small class="text-muted-sm">Leave empty for unlimited</small>
                        @error('usage_limit')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Per User Limit -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Per User Limit</label>
                        <input type="number" name="per_user_limit" class="form-control" value="{{ old('per_user_limit', 1) }}" placeholder="1">
                        @error('per_user_limit')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- VALIDITY & STATUS                          -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-calendar-alt"></i> Validity & Status
                </div>

                <div class="row compact-row">
                    <!-- Start Date -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="text-danger" style="font-size:12px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Create Coupon
                    </button>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function generateCouponCode() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 6; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        code += characters[randomIndex];
    }
    document.getElementById('couponCode').value = code;
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
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let newCode = '';
            for (let i = 0; i < 6; i++) {
                newCode += characters[Math.floor(Math.random() * characters.length)];
            }
            input.value = newCode;
            checkCodeExists(newCode);
        }
    })
    .catch(error => console.error('Error checking code:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('couponCode');
    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }
});
</script>

@endsection