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

    .salary-form-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 1000px;
        margin: 0 auto;
    }

    .salary-form-card .card-header {
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

    .salary-form-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .salary-form-card .card-header h4 i {
        color: #4a9eff;
    }

    .salary-form-card .card-body {
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

    select.form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        color: #1a1a2e !important;
    }

    select.form-control:-moz-focusring {
        color: #1a1a2e !important;
        text-shadow: 0 0 0 #1a1a2e !important;
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

    .form-actions {
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .custom-alert {
        padding: 12px 18px;
        border-radius: var(--radius);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        animation: slideDown 0.4s ease;
        border-left: 4px solid;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }

    .custom-alert.error {
        background: #fce4ec;
        color: #c62828;
        border-left-color: #ef5350;
    }

    .custom-alert.success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left-color: #4caf50;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .trainer-salary-row {
        background: var(--light-gray);
        border-radius: var(--radius);
        padding: 12px 15px;
        margin-bottom: 10px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
    }

    .trainer-salary-row:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .trainer-salary-row .remove-row {
        background: none;
        border: none;
        color: var(--danger);
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0 4px;
        margin-top: 6px;
    }

    .trainer-salary-row .remove-row:hover {
        transform: scale(1.2);
    }

    .trainer-salary-row .trainer-info {
        font-size: 13px;
        color: var(--gray);
        margin-top: 2px;
    }

    .trainer-salary-row .trainer-info i {
        color: var(--primary);
        margin-right: 4px;
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

    .total-box {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
        border-radius: var(--radius);
        padding: 12px 20px;
        margin: 12px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        color: #fff;
    }

    .total-box .total-label {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.8;
    }

    .total-box .total-amount {
        font-size: 24px;
        font-weight: 700;
        color: #4caf50;
    }

    .compact-row {
        margin-bottom: 0;
    }

    .compact-row .mb-3 {
        margin-bottom: 10px !important;
    }

    .select-all-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        padding: 8px 14px;
        background: var(--light-gray);
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .select-all-container input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .select-all-container label {
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
        cursor: pointer;
        margin: 0;
    }

    .select-all-container .select-all-count {
        font-size: 12px;
        color: var(--gray);
        margin-left: auto;
    }

    .trainer-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin-top: 6px;
    }

    .salary-input {
        width: 150px;
    }

    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }
        .salary-form-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .salary-form-card .card-header h4 {
            font-size: 16px;
        }
        .salary-form-card .card-body {
            padding: 14px 16px;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
        .trainer-salary-row .row {
            flex-direction: column;
            gap: 8px;
        }
        .salary-input {
            width: 100%;
        }
        .total-box {
            flex-direction: column;
            text-align: center;
        }
        .select-all-container {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .salary-form-card .card-header h4 {
            font-size: 14px;
        }
        .salary-form-card .card-body {
            padding: 10px 12px;
        }
        .form-label {
            font-size: 11px;
        }
        .form-control {
            font-size: 12px;
            padding: 5px 10px;
            height: 34px;
        }
        .section-title {
            font-size: 12px;
            padding: 5px 10px;
        }
        .btn-primary,
        .btn-secondary {
            padding: 7px 16px;
            font-size: 12px;
        }
        .total-box .total-amount {
            font-size: 20px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="salary-form-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-users"></i> Pay Trainer Salaries</h4>
                <small>Select multiple trainers and pay salaries in one go</small>
            </div>
            <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                <i class="fas fa-circle" style="font-size:6px; color:#4caf50;"></i> Bulk Salary
            </span>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="custom-alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="custom-alert success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.trainer-salaries.store') }}">
                @csrf

                <!-- ========================================== -->
                <!-- COMMON DETAILS                            -->
                <!-- ========================================== -->
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i> Common Details
                </div>

                <div class="row compact-row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Salary Month <span class="text-danger">*</span></label>
                        <input type="month" name="salary_month" class="form-control" value="{{ old('salary_month', date('Y-m')) }}" required>
                        @error('salary_month')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        @error('payment_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                        <select name="payment_type" class="form-control" required>
                            <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('payment_type') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="online" {{ old('payment_type') == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                        @error('payment_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row compact-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Common Notes (Optional)</label>
                        <textarea name="common_notes" class="form-control" rows="1" placeholder="e.g., Monthly salary for August 2026">{{ old('common_notes') }}</textarea>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TRAINER SELECTION                          -->
                <!-- ========================================== -->
                <div class="section-title mt-2">
                    <i class="fas fa-user-tie"></i> Select Trainers & Enter Salary
                    <span style="font-size:11px; font-weight:400; color:var(--gray); margin-left:8px;">Select trainers to pay salary</span>
                </div>

                <!-- Select All -->
                <div class="select-all-container">
                    <input type="checkbox" id="selectAll" onchange="toggleAllTrainers()">
                    <label for="selectAll"><i class="fas fa-check-double"></i> Select All Trainers</label>
                    <span class="select-all-count" id="selectedCount">0 trainers selected</span>
                </div>

                <!-- Trainer List -->
                <div id="trainerList">
                    @foreach($trainers as $index => $trainer)
                        <div class="trainer-salary-row" id="trainerRow{{ $trainer->id }}">
                            <div class="row" style="align-items:center;">
                                <div class="col-md-1" style="text-align:center;">
                                    <input type="checkbox" name="trainer_ids[]" value="{{ $trainer->id }}" class="trainer-checkbox" id="trainer{{ $trainer->id }}" onchange="toggleTrainerFields(this); updateTotal();">
                                </div>
                                <div class="col-md-5">
                                    <strong>{{ $trainer->name }}</strong>
                                    <div class="trainer-info">
                                        <i class="fas fa-chalkboard-user"></i> {{ $trainer->specialization ?? 'General' }}
                                        <span style="margin-left:12px;">
                                            <i class="fas fa-phone"></i> {{ $trainer->phone ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" style="font-size:11px; margin-bottom:2px;">Salary Amount (₹) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="amounts[]" class="form-control salary-input" placeholder="Enter amount" min="0.01" oninput="updateTotal()" disabled>
                                    <input type="hidden" name="trainer_ids_hidden[]" value="{{ $trainer->id }}">
                                </div>
                                <div class="col-md-2" style="text-align:center;">
                                    <button type="button" class="remove-row" onclick="removeTrainerRow({{ $trainer->id }})" style="display:none;" id="removeBtn{{ $trainer->id }}">
                                        <i class="fas fa-times-circle"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($trainers->count() == 0)
                    <div style="text-align:center; padding:20px; color:var(--gray);">
                        <i class="fas fa-users" style="font-size:32px; display:block; margin-bottom:8px; color:#dee2e6;"></i>
                        No active trainers found. Please add trainers first.
                    </div>
                @endif

                <!-- ========================================== -->
                <!-- TOTAL                                      -->
                <!-- ========================================== -->
                <div class="total-box">
                    <div>
                        <div class="total-label"><i class="fas fa-calculator"></i> Total Salary</div>
                        <div style="font-size:12px; opacity:0.7;" id="trainerCountDisplay">0 trainers selected</div>
                    </div>
                    <div class="total-amount" id="totalAmount">₹ 0.00</div>
                </div>

                <!-- ========================================== -->
                <!-- FORM ACTIONS                              -->
                <!-- ========================================== -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Pay Salaries
                    </button>
                    <a href="{{ route('admin.trainer-salaries.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// ============================================
// TOGGLE ALL TRAINERS
// ============================================
function toggleAllTrainers() {
    var selectAll = document.getElementById('selectAll');
    var checkboxes = document.querySelectorAll('.trainer-checkbox');
    
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = selectAll.checked;
        toggleTrainerFields(checkbox);
    });
    
    updateTotal();
}

// ============================================
// TOGGLE TRAINER FIELDS
// ============================================
function toggleTrainerFields(checkbox) {
    var row = checkbox.closest('.trainer-salary-row');
    var amountInput = row.querySelector('input[name="amounts[]"]');
    var removeBtn = row.querySelector('.remove-row');
    
    if (checkbox.checked) {
        amountInput.disabled = false;
        amountInput.required = true;
        removeBtn.style.display = 'inline-block';
        row.style.borderColor = 'var(--primary)';
        row.style.background = '#e8f4fd';
    } else {
        amountInput.disabled = true;
        amountInput.required = false;
        amountInput.value = '';
        removeBtn.style.display = 'none';
        row.style.borderColor = 'var(--border-color)';
        row.style.background = 'var(--light-gray)';
    }
}

// ============================================
// REMOVE TRAINER ROW
// ============================================
function removeTrainerRow(trainerId) {
    var checkbox = document.getElementById('trainer' + trainerId);
    if (checkbox) {
        checkbox.checked = false;
        toggleTrainerFields(checkbox);
        updateTotal();
    }
}

// ============================================
// UPDATE TOTAL
// ============================================
function updateTotal() {
    var checkboxes = document.querySelectorAll('.trainer-checkbox:checked');
    var total = 0;
    var count = 0;
    
    checkboxes.forEach(function(checkbox) {
        var row = checkbox.closest('.trainer-salary-row');
        var amountInput = row.querySelector('input[name="amounts[]"]');
        var amount = parseFloat(amountInput.value);
        
        if (!isNaN(amount) && amount > 0) {
            total += amount;
            count++;
        }
    });
    
    // Update total display
    document.getElementById('totalAmount').textContent = '₹ ' + total.toFixed(2);
    document.getElementById('trainerCountDisplay').textContent = count + ' trainers selected';
    document.getElementById('selectedCount').textContent = count + ' trainers selected';
    
    // Update select all checkbox
    var allCheckboxes = document.querySelectorAll('.trainer-checkbox');
    var checkedCheckboxes = document.querySelectorAll('.trainer-checkbox:checked');
    var selectAll = document.getElementById('selectAll');
    
    if (allCheckboxes.length > 0 && checkedCheckboxes.length === allCheckboxes.length && allCheckboxes.length > 0) {
        selectAll.checked = true;
    } else {
        selectAll.checked = false;
    }
}

// ============================================
// AUTO CALCULATE ON AMOUNT CHANGE
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    var amountInputs = document.querySelectorAll('input[name="amounts[]"]');
    amountInputs.forEach(function(input) {
        input.addEventListener('input', updateTotal);
        input.addEventListener('change', updateTotal);
    });
    
    // Initialize
    updateTotal();
});

// ============================================
// FORM VALIDATION
// ============================================
document.querySelector('form').addEventListener('submit', function(e) {
    var checkboxes = document.querySelectorAll('.trainer-checkbox:checked');
    var hasError = false;
    
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Please select at least one trainer.');
        return;
    }
    
    checkboxes.forEach(function(checkbox) {
        var row = checkbox.closest('.trainer-salary-row');
        var amountInput = row.querySelector('input[name="amounts[]"]');
        var amount = parseFloat(amountInput.value);
        
        if (!amountInput.value || isNaN(amount) || amount <= 0) {
            hasError = true;
            amountInput.style.borderColor = '#ef5350';
            amountInput.style.boxShadow = '0 0 0 3px rgba(239,83,80,0.12)';
        } else {
            amountInput.style.borderColor = '';
            amountInput.style.boxShadow = '';
        }
    });
    
    if (hasError) {
        e.preventDefault();
        alert('Please enter valid salary amount for all selected trainers.');
    }
});
</script>

@endsection