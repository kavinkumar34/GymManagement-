@extends('layouts.admin-layout')

@section('content')
<style>
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
        --success: #4caf50;
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

    .expense-form-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .expense-form-card .card-header {
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

    .expense-form-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .expense-form-card .card-header h4 i {
        color: #4a9eff;
    }

    .expense-form-card .card-body {
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
        background: #fff;
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

    .file-input-wrapper {
        position: relative;
        height: 38px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-input-wrapper .file-input-container {
        position: relative;
        flex: 1;
        height: 38px;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .file-input-wrapper .file-label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        background: #fff;
        font-size: 13px;
        color: var(--gray);
        height: 38px;
        transition: all 0.3s;
        position: relative;
        z-index: 1;
        cursor: pointer;
        white-space: nowrap;
    }

    .file-input-wrapper .file-label:hover {
        border-color: var(--primary);
        background: #f8f9fa;
    }

    .file-input-wrapper .file-name {
        font-size: 13px;
        color: var(--dark);
        padding: 0 8px;
        flex: 1;
        min-width: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .file-input-wrapper .file-name .no-file {
        color: var(--gray);
        font-style: italic;
    }

    .file-input-wrapper .file-name .selected-file {
        color: var(--primary);
        font-weight: 500;
    }

    .expense-item {
        background: var(--light-gray);
        border-radius: var(--radius);
        padding: 12px 15px;
        margin-bottom: 10px;
        border: 1px solid var(--border-color);
    }

    .expense-item .remove-item {
        background: none;
        border: none;
        color: var(--danger);
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0 4px;
    }

    .expense-item .remove-item:hover {
        transform: scale(1.2);
    }

    .btn-primary {
        background: var(--primary);
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

    .btn-primary:hover {
        background: var(--primary-dark);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
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

    .btn-success {
        background: var(--success);
        color: #fff;
        border: none;
        padding: 6px 16px;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 12px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-success:hover {
        background: #388e3c;
        color: #fff;
    }

    .form-actions {
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }
        .expense-form-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .expense-form-card .card-header h4 {
            font-size: 16px;
        }
        .expense-form-card .card-body {
            padding: 14px 16px;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="admin-main-content">
    <div class="expense-form-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-plus-circle"></i> Add Expenses</h4>
                <small>Record multiple expenses for a date</small>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.expenses.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- ========================================== -->
                <!-- EXPENSE DETAILS                            -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i> Expense Details
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expense Date <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                        <select name="payment_type" class="form-control" required>
                            <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="online" {{ old('payment_type') == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Receipt Image (Optional)</label>
                        <div class="file-input-wrapper">
                            <div class="file-input-container">
                                <div class="file-label">
                                    <i class="fas fa-image"></i>
                                    <span>Choose receipt</span>
                                </div>
                                <input type="file" name="receipt_image" accept="image/*" id="receiptImage" onchange="updateFileName()">
                            </div>
                            <span class="file-name" id="fileNameDisplay">
                                <span class="no-file">No file chosen</span>
                            </span>
                        </div>
                        <small class="text-muted" style="font-size:11px;">Upload receipt image (JPG, PNG, GIF, WEBP - Max 2MB)</small>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- EXPENSE ITEMS                              -->
                <!-- ========================================== -->
                <div class="section-title mt-3">
                    <i class="fas fa-list"></i> Expense Items
                    <span style="font-size:11px; font-weight:400; color:var(--gray); margin-left:8px;">Add multiple items for this date</span>
                </div>

                <div id="expenseItemsContainer">
                    <div class="expense-item">
                        <div class="row">
                            <div class="col-md-9">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <input type="text" name="descriptions[]" class="form-control" placeholder="e.g., Electricity Bill, Staff Salary, etc." required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                                <div style="display:flex; gap:8px; align-items:center;">
                                    <input type="number" step="0.01" name="amounts[]" class="form-control" placeholder="0.00" required min="0.01" onchange="calculateTotal()">
                                    <button type="button" class="remove-item" onclick="removeExpenseItem(this)" title="Remove" style="margin-top:6px;">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin: 10px 0;">
                    <button type="button" class="btn-success" onclick="addExpenseItem()">
                        <i class="fas fa-plus"></i> Add More Item
                    </button>
                </div>

                <!-- ========================================== -->
                <!-- TOTAL                                      -->
                <!-- ========================================== -->
                <div style="background:var(--light-gray); border-radius:var(--radius); padding:12px 18px; margin:12px 0; border:1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <span style="font-weight:600; font-size:14px;">Total Expenses:</span>
                    <span id="totalAmount" style="font-weight:700; font-size:20px; color:#ef4444;">₹ 0.00</span>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Expenses
                    </button>
                    <a href="{{ route('admin.expenses.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// ============================================
// FILE NAME UPDATE
// ============================================
function updateFileName() {
    var input = document.getElementById('receiptImage');
    var display = document.getElementById('fileNameDisplay');

    if (input.files && input.files.length > 0) {
        var fileName = input.files[0].name;
        if (fileName.length > 30) {
            fileName = fileName.substring(0, 27) + '...';
        }
        display.innerHTML = '<span class="selected-file"><i class="fas fa-check-circle" style="color:#4caf50;"></i> ' + fileName + '</span>';
    } else {
        display.innerHTML = '<span class="no-file">No file chosen</span>';
    }
}

// ============================================
// ADD EXPENSE ITEM
// ============================================
function addExpenseItem() {
    var container = document.getElementById('expenseItemsContainer');
    var items = container.querySelectorAll('.expense-item');
    var index = items.length;

    var div = document.createElement('div');
    div.className = 'expense-item';
    div.innerHTML = `
        <div class="row">
            <div class="col-md-9">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <input type="text" name="descriptions[]" class="form-control" placeholder="e.g., Electricity Bill, Staff Salary, etc." required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                <div style="display:flex; gap:8px; align-items:center;">
                    <input type="number" step="0.01" name="amounts[]" class="form-control" placeholder="0.00" required min="0.01" onchange="calculateTotal()">
                    <button type="button" class="remove-item" onclick="removeExpenseItem(this)" title="Remove" style="margin-top:6px;">&times;</button>
                </div>
            </div>
        </div>
    `;

    container.appendChild(div);
    calculateTotal();
}

// ============================================
// REMOVE EXPENSE ITEM
// ============================================
function removeExpenseItem(button) {
    var container = document.getElementById('expenseItemsContainer');
    var items = container.querySelectorAll('.expense-item');

    if (items.length <= 1) {
        alert('You must have at least one expense item.');
        return;
    }

    var item = button.closest('.expense-item');
    item.remove();
    calculateTotal();
}

// ============================================
// CALCULATE TOTAL
// ============================================
function calculateTotal() {
    var amounts = document.querySelectorAll('input[name="amounts[]"]');
    var total = 0;

    amounts.forEach(function(input) {
        var value = parseFloat(input.value);
        if (!isNaN(value) && value > 0) {
            total += value;
        }
    });

    document.getElementById('totalAmount').textContent = '₹ ' + total.toFixed(2);
}

// ============================================
// INITIALIZE
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>

@endsection