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

    .salary-form-card .card-header small {
        display: block;
        margin-top: 4px;
        font-size: 12px;
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

    .section-title .section-subtitle {
        font-size: 11px;
        font-weight: 400;
        color: var(--gray);
        margin-left: 8px;
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
        cursor: pointer;
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

    .validation-errors {
        background: #fff3f3;
        color: #c62828;
        border: 1px solid #ffcdd2;
        border-left: 4px solid #ef5350;
        padding: 12px 18px;
        border-radius: var(--radius);
        margin-bottom: 16px;
        font-size: 13px;
    }

    .validation-errors ul {
        margin: 6px 0 0 20px;
        padding: 0;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ==========================================
       TRAINER ROW
       ========================================== */

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

    .trainer-salary-row.current-trainer {
        border-color: var(--primary);
        background: #e8f4fd;
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

    .trainer-checkbox {
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin-top: 6px;
    }

    .salary-input {
        width: 150px;
    }

    .salary-input:disabled {
        background: #e9ecef;
        cursor: not-allowed;
    }

    .current-badge {
        display: inline-block;
        background: rgba(74,158,255,0.15);
        color: #2b7be0;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 50px;
        margin-left: 8px;
        vertical-align: middle;
    }

    /* ==========================================
       SELECT ALL
       ========================================== */

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

    .select-all-count {
        font-size: 12px;
        color: var(--gray);
        margin-left: auto;
    }

    /* ==========================================
       TOTAL
       ========================================== */

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

    /* ==========================================
       CURRENT RECORD INFO
       ========================================== */

    .edit-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        margin-bottom: 14px;
        background: #e8f4fd;
        border-left: 3px solid var(--primary);
        border-radius: var(--radius);
        color: #2b7be0;
        font-size: 12px;
    }

    .edit-info i {
        font-size: 15px;
    }

    /* ==========================================
       RESPONSIVE
       ========================================== */

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

        .form-actions .btn-primary,
        .form-actions .btn-secondary {
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

        <!-- ========================================== -->
        <!-- HEADER                                     -->
        <!-- ========================================== -->

        <div class="card-header">

            <div>
                <h4>
                    <i class="fas fa-users"></i>
                    Pay Trainer Salaries
                </h4>

                <small>
                    Select trainer and update salary details
                </small>
            </div>

            <span style="
                background:rgba(74,158,255,0.2);
                color:#8ab4f8;
                padding:3px 12px;
                border-radius:50px;
                font-size:11px;
            ">
                <i class="fas fa-edit"></i>
                Edit Salary
            </span>

        </div>


        <div class="card-body">

            <!-- ========================================== -->
            <!-- SESSION ERROR                               -->
            <!-- ========================================== -->

            @if(session('error'))

                <div class="custom-alert error">

                    <i class="fas fa-exclamation-circle"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <!-- ========================================== -->
            <!-- SESSION SUCCESS                             -->
            <!-- ========================================== -->

            @if(session('success'))

                <div class="custom-alert success">

                    <i class="fas fa-check-circle"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            <!-- ========================================== -->
            <!-- VALIDATION ERRORS                           -->
            <!-- ========================================== -->

            @if($errors->any())

                <div class="validation-errors">

                    <strong>
                        <i class="fas fa-exclamation-triangle"></i>
                        Please fix the following errors:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- ========================================== -->
            <!-- COMMON DETAILS                             -->
            <!-- SAME STRUCTURE AS CREATE.BLADE.PHP        -->
            <!-- ========================================== -->

            <div class="section-title">

                <i class="fas fa-calendar-alt"></i>

                Common Details

            </div>


            <div class="row compact-row">

                <!-- SALARY MONTH -->

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Salary Month

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="month"
                        name="salary_month"
                        id="salary_month"
                        class="form-control"
                        value="{{ old('salary_month', optional($salary->salary_month)->format('Y-m')) }}"
                        required
                        form="editSalaryForm"
                    >

                    @error('salary_month')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                <!-- PAYMENT DATE -->

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Payment Date

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="date"
                        name="payment_date"
                        id="payment_date"
                        class="form-control"
                        value="{{ old('payment_date', optional($salary->payment_date)->format('Y-m-d')) }}"
                        required
                        form="editSalaryForm"
                    >

                    @error('payment_date')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                <!-- PAYMENT TYPE -->

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Payment Type

                        <span class="text-danger">*</span>

                    </label>

                    <select
                        name="payment_type"
                        id="payment_type"
                        class="form-control"
                        required
                        form="editSalaryForm"
                    >

                        <option
                            value="cash"
                            {{ old('payment_type', $salary->payment_type) == 'cash' ? 'selected' : '' }}
                        >
                            Cash
                        </option>

                        <option
                            value="bank"
                            {{ old('payment_type', $salary->payment_type) == 'bank' ? 'selected' : '' }}
                        >
                            Bank Transfer
                        </option>

                        <option
                            value="online"
                            {{ old('payment_type', $salary->payment_type) == 'online' ? 'selected' : '' }}
                        >
                            Online
                        </option>

                    </select>

                    @error('payment_type')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>


            <!-- ========================================== -->
            <!-- NOTES                                      -->
            <!-- ========================================== -->

            <div class="row compact-row">

                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Common Notes (Optional)
                    </label>

                    <textarea
                        name="notes"
                        id="notes"
                        class="form-control"
                        rows="1"
                        maxlength="500"
                        placeholder="e.g., Monthly salary for August 2026"
                        form="editSalaryForm"
                    >{{ old('notes', $salary->notes) }}</textarea>

                    @error('notes')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>


            <!-- ========================================== -->
            <!-- TRAINER SELECTION                          -->
            <!-- EDIT ALL TRAINERS FOR THIS MONTH            -->
            <!-- ========================================== -->

            <div class="section-title mt-2">

                <i class="fas fa-user-tie"></i>

                Select Trainers & Enter Salary

                <span class="section-subtitle">
                    Edit all trainer salaries for {{ optional($salary->salary_month)->format('F Y') }}
                </span>

            </div>


            <!-- ========================================== -->
            <!-- SELECT ALL                                 -->
            <!-- ========================================== -->

            <div class="select-all-container">

                <input
                    type="checkbox"
                    id="selectAll"
                    onchange="toggleAllTrainers()"
                >

                <label for="selectAll">

                    <i class="fas fa-check-double"></i>

                    Select All Trainers

                </label>

                <span
                    class="select-all-count"
                    id="selectedCount"
                >
                    0 trainers selected
                </span>

            </div>

            <div style="font-size:11px; color:var(--gray); margin-bottom:12px;">
                <i class="fas fa-info-circle"></i>
                Trainers who already have salary for this month are selected automatically.
                Unchecking a trainer will remove that trainer from this month's salary records.
            </div>


            <!-- ========================================== -->
            <!-- EDIT FORM                                  -->
            <!-- ========================================== -->

            <form
                method="POST"
                action="{{ route('admin.trainer-salaries.update', $salary->id) }}"
                id="editSalaryForm"
            >

                @csrf

                @method('PUT')


                <!-- ========================================== -->
                <!-- TRAINER LIST                               -->
                <!-- ========================================== -->

                <div id="trainerList">

                    @forelse($trainers as $index => $trainer)

                        @php
                            $trainerSalary = $salaryByTrainer->get($trainer->id);
                            $isSelected = !is_null($trainerSalary);

                            $oldAmount = old(
                                'amounts.' . $trainer->id,
                                $trainerSalary ? $trainerSalary->salary_amount : ''
                            );
                        @endphp

                        <div
                            class="trainer-salary-row {{ $isSelected ? 'current-trainer' : '' }}"
                            id="trainerRow{{ $trainer->id }}"
                        >

                            <div
                                class="row"
                                style="align-items:center;"
                            >

                                <!-- CHECKBOX -->

                                <div
                                    class="col-md-1"
                                    style="text-align:center;"
                                >

                                    <input
                                        type="checkbox"
                                        name="trainer_ids[]"
                                        value="{{ $trainer->id }}"
                                        class="trainer-checkbox"
                                        id="trainer{{ $trainer->id }}"
                                        {{ $isSelected ? 'checked' : '' }}
                                        onchange="handleTrainerSelection(this)"
                                    >

                                </div>


                                <!-- TRAINER INFORMATION -->

                                <div class="col-md-5">

                                    <strong>

                                        {{ $trainer->name }}

                                        @if($isSelected)

                                            <span class="current-badge">
                                                SALARY RECORDED
                                            </span>

                                        @endif

                                    </strong>


                                    <div class="trainer-info">

                                        <i class="fas fa-chalkboard-user"></i>

                                        {{ $trainer->specialization ?? 'General' }}

                                        <span style="margin-left:12px;">

                                            <i class="fas fa-phone"></i>

                                            {{ $trainer->phone ?? 'N/A' }}

                                        </span>

                                    </div>

                                </div>


                                <!-- SALARY AMOUNT -->

                                <div class="col-md-4">

                                    <label
                                        class="form-label"
                                        style="font-size:11px; margin-bottom:2px;"
                                    >

                                        Salary Amount (₹)

                                        <span class="text-danger">*</span>

                                    </label>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="amounts[{{ $trainer->id }}]"
                                        id="salaryAmount{{ $trainer->id }}"
                                        class="form-control salary-input"
                                        placeholder="Enter amount"
                                        min="0.01"
                                        value="{{ $oldAmount }}"
                                        {{ $isSelected ? '' : 'disabled' }}
                                        oninput="updateTotal()"
                                    >

                                </div>


                                <!-- STATUS -->

                                <div
                                    class="col-md-2"
                                    style="text-align:center;"
                                >

                                    <span
                                        id="status{{ $trainer->id }}"
                                        style="
                                            font-size:11px;
                                            color:{{ $isSelected ? '#2b7be0' : '#6c757d' }};
                                            font-weight:500;
                                        "
                                    >

                                        <i class="fas {{ $isSelected ? 'fa-edit' : 'fa-minus-circle' }}"></i>

                                        <span class="status-text">
                                            {{ $isSelected ? 'Editing' : 'Not Selected' }}
                                        </span>

                                    </span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div
                            style="
                                text-align:center;
                                padding:20px;
                                color:var(--gray);
                            "
                        >

                            <i
                                class="fas fa-users"
                                style="
                                    font-size:32px;
                                    display:block;
                                    margin-bottom:8px;
                                    color:#dee2e6;
                                "
                            ></i>

                            No active trainers found.

                        </div>

                    @endforelse

                </div>


                <!-- ========================================== -->
                <!-- TOTAL                                      -->
                <!-- ========================================== -->

                <div class="total-box">

                    <div>

                        <div class="total-label">

                            <i class="fas fa-calculator"></i>

                            Total Salary

                        </div>

                        <div
                            style="font-size:12px; opacity:0.7;"
                            id="trainerCountDisplay"
                        >
                            0 trainers selected
                        </div>

                    </div>

                    <div
                        class="total-amount"
                        id="totalAmount"
                    >
                        ₹ 0.00
                    </div>

                </div>


                <!-- ========================================== -->
                <!-- HIDDEN REFERENCE NUMBER                    -->
                <!-- ========================================== -->

                <input
                    type="hidden"
                    name="reference_number"
                    id="reference_number"
                    value="{{ old('reference_number', $salary->reference_number) }}"
                >


                <!-- ========================================== -->
                <!-- FORM ACTIONS                               -->
                <!-- ========================================== -->

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn-primary"
                        id="submitBtn"
                    >

                        <i class="fas fa-save"></i>

                        Update Salary

                    </button>

                    <a
                        href="{{ route('admin.trainer-salaries.index') }}"
                        class="btn-secondary"
                    >

                        <i class="fas fa-times"></i>

                        Cancel

                    </a>

                </div>

            </form>


            <script>

            /* =========================================================
               TRAINER SELECTION
               ========================================================= */

            function handleTrainerSelection(checkbox) {

                var row = checkbox.closest('.trainer-salary-row');

                var amountInput = document.getElementById(
                    'salaryAmount' + checkbox.value
                );

                var status = document.getElementById(
                    'status' + checkbox.value
                );

                if (checkbox.checked) {

                    row.classList.add('current-trainer');

                    row.style.borderColor = 'var(--primary)';
                    row.style.background = '#e8f4fd';

                    amountInput.disabled = false;
                    amountInput.required = true;

                    if (status) {
                        status.style.color = '#2b7be0';
                        status.innerHTML =
                            '<i class="fas fa-edit"></i> ' +
                            '<span class="status-text">Editing</span>';
                    }

                } else {

                    row.classList.remove('current-trainer');

                    row.style.borderColor = 'var(--border-color)';
                    row.style.background = 'var(--light-gray)';

                    amountInput.disabled = true;
                    amountInput.required = false;

                    if (status) {
                        status.style.color = '#6c757d';
                        status.innerHTML =
                            '<i class="fas fa-minus-circle"></i> ' +
                            '<span class="status-text">Not Selected</span>';
                    }

                }

                updateTotal();

            }


            /* =========================================================
               SELECT ALL TRAINERS
               ========================================================= */

            function toggleAllTrainers() {

                var selectAll = document.getElementById('selectAll');

                var checkboxes = document.querySelectorAll(
                    '.trainer-checkbox'
                );

                checkboxes.forEach(function(checkbox) {

                    checkbox.checked = selectAll.checked;

                    handleTrainerSelection(checkbox);

                });

                updateTotal();

            }


            /* =========================================================
               UPDATE TOTAL
               ========================================================= */

            function updateTotal() {

                var selectedCheckboxes = document.querySelectorAll(
                    '.trainer-checkbox:checked'
                );

                var total = 0;
                var count = 0;

                selectedCheckboxes.forEach(function(checkbox) {

                    var amountInput = document.getElementById(
                        'salaryAmount' + checkbox.value
                    );

                    if (amountInput) {

                        var amount = parseFloat(amountInput.value) || 0;

                        total += amount;

                    }

                    count++;

                });

                document.getElementById('totalAmount').textContent =
                    '₹ ' + total.toFixed(2);

                document.getElementById('trainerCountDisplay').textContent =
                    count +
                    ' trainer' +
                    (count !== 1 ? 's' : '') +
                    ' selected';

                document.getElementById('selectedCount').textContent =
                    count +
                    ' trainer' +
                    (count !== 1 ? 's' : '') +
                    ' selected';


                // Keep Select All checkbox synchronized.
                var allCheckboxes = document.querySelectorAll(
                    '.trainer-checkbox'
                );

                var selectAll = document.getElementById('selectAll');

                if (
                    allCheckboxes.length > 0 &&
                    selectedCheckboxes.length === allCheckboxes.length
                ) {
                    selectAll.checked = true;
                } else {
                    selectAll.checked = false;
                }

            }


            /* =========================================================
               FORM VALIDATION
               ========================================================= */

            document.addEventListener('DOMContentLoaded', function() {

                var form = document.getElementById('editSalaryForm');

                var amountInputs = document.querySelectorAll(
                    '.salary-input'
                );


                // Initialize all amount inputs.
                amountInputs.forEach(function(input) {

                    input.addEventListener('input', function() {

                        var amount = parseFloat(this.value);

                        if (!isNaN(amount) && amount > 0) {

                            this.style.borderColor = '#4caf50';
                            this.style.boxShadow =
                                '0 0 0 3px rgba(76,175,80,0.10)';

                        } else {

                            this.style.borderColor = '';
                            this.style.boxShadow = '';

                        }

                        updateTotal();

                    });

                });


                updateTotal();


                form.addEventListener('submit', function(event) {

                    var selectedCheckboxes = document.querySelectorAll(
                        '.trainer-checkbox:checked'
                    );


                    if (selectedCheckboxes.length === 0) {

                        event.preventDefault();

                        alert('Please select at least one trainer.');

                        return;

                    }


                    var invalid = false;

                    selectedCheckboxes.forEach(function(checkbox) {

                        var amountInput = document.getElementById(
                            'salaryAmount' + checkbox.value
                        );

                        var amount = parseFloat(amountInput.value);


                        if (
                            !amountInput.value ||
                            isNaN(amount) ||
                            amount <= 0
                        ) {

                            invalid = true;

                            amountInput.focus();

                            amountInput.style.borderColor = '#ef5350';
                            amountInput.style.boxShadow =
                                '0 0 0 3px rgba(239,83,80,0.12)';

                        }

                    });


                    if (invalid) {

                        event.preventDefault();

                        alert(
                            'Please enter a valid salary amount for all selected trainers.'
                        );

                        return;

                    }


                    /*
                     * Prevent double submit.
                     */

                    var submitBtn = document.getElementById('submitBtn');

                    submitBtn.disabled = true;

                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i> Updating...';

                });

            });

            </script>

        </div>

    </div>

</div>

@endsection
