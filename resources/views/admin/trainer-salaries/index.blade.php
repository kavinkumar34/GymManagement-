@extends('layouts.admin-layout')

@section('content')
<style>
    :root {
        --primary: #4a9eff;
        --primary-dark: #2b7be0;
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

    .salary-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 20px;
    }

    .salary-card .card-header {
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

    .salary-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .salary-card .card-header h4 i {
        color: #4a9eff;
    }

    .salary-card .card-body {
        padding: 20px 24px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-item {
        background: #ffffff;
        border-radius: var(--radius);
        padding: 16px 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .stat-item .stat-label {
        font-size: 11px;
        color: var(--gray);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .stat-item .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-top: 4px;
    }

    .stat-item .stat-value.red { color: #ef4444; }
    .stat-item .stat-value.blue { color: #3b82f6; }
    .stat-item .stat-value.green { color: #10b981; }
    .stat-item .stat-value.orange { color: #f59e0b; }
    .stat-item .stat-value.purple { color: #8b5cf6; }

    .stat-item .stat-icon {
        float: right;
        font-size: 28px;
        opacity: 0.15;
    }

    .stat-item .stat-sub {
        font-size: 12px;
        color: var(--gray);
        margin-top: 2px;
    }

    .btn-primary {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(74, 158, 255, 0.35);
        color: #fff;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        text-decoration: none;
    }

    .btn-action.view {
        background: rgba(74, 158, 255, 0.1);
        color: #4a9eff;
    }

    .btn-action.view:hover {
        background: #4a9eff;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-action.edit {
        background: rgba(255, 167, 38, 0.1);
        color: #ffa726;
    }

    .btn-action.edit:hover {
        background: #ffa726;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-action.delete {
        background: rgba(239, 83, 80, 0.1);
        color: #ef5350;
    }

    .btn-action.delete:hover {
        background: #ef5350;
        color: #fff;
        transform: scale(1.1);
    }

    .action-btns {
        display: flex;
        gap: 4px;
        justify-content: center;
        align-items: center;
    }

    .filter-section {
        background: var(--light-gray);
        border-radius: var(--radius);
        padding: 16px 18px;
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .filter-section select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        background: #fff;
        height: 38px;
        min-width: 150px;
        transition: all 0.3s;
        color: var(--dark);
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    .filter-section select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .filter-section .btn-reset {
        padding: 8px 18px;
        background: var(--danger);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 38px;
    }

    .filter-section .btn-reset:hover {
        background: #c62828;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 83, 80, 0.35);
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-salaries {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
        min-width: 700px;
    }

    .table-salaries thead {
        background: var(--light-gray);
    }

    .table-salaries thead th {
        padding: 12px 14px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark);
        border-bottom: 2px solid var(--border-color);
        text-align: left;
        white-space: nowrap;
    }

    .table-salaries thead th.text-center {
        text-align: center;
    }

    .table-salaries tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-salaries tbody tr:hover {
        background: #f8f9fa;
    }

    .table-salaries .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .table-salaries .amount {
        font-weight: 700;
        color: #10b981;
        white-space: nowrap;
        font-size: 16px;
    }

    .payment-tag {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .payment-tag.cash {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .payment-tag.bank {
        background: #e3f2fd;
        color: #1565c0;
    }

    .payment-tag.online {
        background: #f3e5f5;
        color: #6a1b9a;
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

    .custom-alert.success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left-color: #4caf50;
    }

    .custom-alert.error {
        background: #fce4ec;
        color: #c62828;
        border-left-color: #ef5350;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        color: #dee2e6;
        font-size: 48px;
        margin-bottom: 12px;
    }

    .empty-state h5 {
        color: var(--dark);
        margin-bottom: 4px;
    }

    .empty-state p {
        color: var(--gray);
        font-size: 14px;
        margin-bottom: 12px;
    }

    /* ============================================ */
    /* MODAL STYLES                                 */
    /* ============================================ */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(3px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-container {
        background: #ffffff;
        border-radius: var(--radius-lg);
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header h4 i {
        color: #4a9eff;
    }

    .modal-close {
        background: none;
        border: none;
        color: rgba(255,255,255,0.7);
        font-size: 24px;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0 4px;
    }

    .modal-close:hover {
        color: #fff;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 20px 24px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-body .modal-subtitle {
        font-size: 13px;
        color: var(--gray);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .modal-body .modal-subtitle strong {
        color: var(--dark);
    }

    .modal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .modal-table thead {
        background: var(--light-gray);
    }

    .modal-table thead th {
        padding: 10px 12px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark);
        border-bottom: 2px solid var(--border-color);
        text-align: left;
        white-space: nowrap;
    }

    .modal-table tbody td {
        padding: 8px 12px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .modal-table tbody tr:hover {
        background: #f8f9fa;
    }

    .modal-table .modal-amount {
        font-weight: 700;
        color: #10b981;
        white-space: nowrap;
    }

    .modal-footer {
        padding: 12px 24px;
        background: var(--light-gray);
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .modal-footer .modal-total-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }

    .modal-footer .modal-total-amount {
        font-size: 20px;
        font-weight: 700;
        color: #10b981;
    }

    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }
        .salary-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .salary-card .card-header h4 {
            font-size: 16px;
        }
        .salary-card .card-body {
            padding: 14px 16px;
        }
        .stat-item .stat-value {
            font-size: 18px;
        }
        .filter-section {
            flex-direction: column;
        }
        .filter-section select {
            width: 100%;
        }
        .filter-section .btn-reset {
            width: 100%;
            justify-content: center;
        }
        .modal-container {
            max-width: 95%;
            margin: 10px;
        }
        .modal-header {
            padding: 12px 16px;
        }
        .modal-header h4 {
            font-size: 16px;
        }
        .modal-body {
            padding: 14px 16px;
        }
        .modal-table thead th,
        .modal-table tbody td {
            padding: 6px 8px;
            font-size: 11px;
        }
        .modal-footer {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .salary-card .card-header h4 {
            font-size: 14px;
        }
        .salary-card .card-body {
            padding: 10px 12px;
        }
        .stat-item {
            padding: 12px 14px;
        }
        .stat-item .stat-value {
            font-size: 16px;
        }
        .table-salaries tbody td {
            padding: 4px 6px;
            font-size: 10px;
        }
        .table-salaries thead th {
            padding: 4px 6px;
            font-size: 9px;
        }
        .table-salaries .sno {
            font-size: 10px;
        }
        .table-salaries .amount {
            font-size: 13px;
        }
        .payment-tag {
            font-size: 9px;
            padding: 2px 8px;
        }
        .modal-container {
            max-width: 100%;
            margin: 5px;
            border-radius: 12px;
        }
        .modal-header h4 {
            font-size: 14px;
        }
        .modal-footer .modal-total-amount {
            font-size: 17px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="salary-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-money-bill-wave"></i> Trainer Salary Management</h4>
                <small style="opacity:0.8;">Record and track trainer salaries</small>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('admin.trainer-salaries.report') }}" class="btn btn-primary" style="background:#8b5cf6;">
                    <i class="fas fa-chart-bar"></i> Report
                </a>
                <a href="{{ route('admin.trainer-salaries.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Salary
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="custom-alert success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="custom-alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Stats -->
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-rupee-sign"></i></span>
                    <div class="stat-label">Total Salary</div>
                    <div class="stat-value red">₹ {{ number_format($totalAmount ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="stat-label">Cash Payments</div>
                    <div class="stat-value orange">₹ {{ number_format($cashTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-university"></i></span>
                    <div class="stat-label">Bank Transfers</div>
                    <div class="stat-value blue">₹ {{ number_format($bankTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-wifi"></i></span>
                    <div class="stat-label">Online Payments</div>
                    <div class="stat-value purple">₹ {{ number_format($onlineTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
            </div>

            <!-- Filter -->
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.trainer-salaries.index') }}" style="display:flex; flex-wrap:wrap; gap:10px; align-items:center; width:100%;">
                    <select name="month">
                        <option value="">All Months</option>
                        @foreach($months as $monthOption)
                            <option value="{{ $monthOption }}" {{ request('month') == $monthOption ? 'selected' : '' }}>
                                {{ date('M Y', strtotime($monthOption . '-01')) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary" style="padding:8px 18px;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('admin.trainer-salaries.index') }}" class="btn-reset">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-salaries">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">#</th>
                            <th>Salary Month</th>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Total Amount</th>
                            <th class="text-center" style="width:100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupedSalaries as $index => $group)
                            <tr>
                                <td class="text-center sno">{{ $index + 1 }}</td>
                                <td><strong>{{ $group->month_year }}</strong></td>
                                <td>{{ $group->payment_date ? date('d-m-Y', strtotime($group->payment_date)) : '-' }}</td>
                                <td>
                                    <span class="payment-tag {{ $group->payment_type }}">
                                        <i class="fas {{ $group->payment_type == 'cash' ? 'fa-hand-holding-usd' : ($group->payment_type == 'bank' ? 'fa-university' : 'fa-wifi') }}"></i>
                                        {{ ucfirst($group->payment_type) }}
                                    </span>
                                </td>
                                <td><span class="amount">₹ {{ number_format($group->total_amount, 2) }}</span></td>
                                <td>
                                    <div class="action-btns">
                                        <button type="button" class="btn-action view" onclick="viewSalaryDetails('{{ $group->month_key }}')" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($group->id)
                                            <a href="{{ route('admin.trainer-salaries.edit', $group->id) }}" class="btn-action edit" title="Edit All Trainer Salaries">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.trainer-salaries.destroy', $group->id) }}" style="display:inline;" onsubmit="return confirmDeleteMonth('{{ $group->month_year }}', '{{ number_format($group->total_amount, 2) }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action delete" title="Delete All Trainer Salaries for {{ $group->month_year }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <h5>No Salary Records Found</h5>
                                        <p>Click "Add Salary" to record the first trainer salary.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($groupedSalaries) > 0)
                <div style="margin-top:16px; padding-top:14px; border-top:1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="font-size:13px; color:var(--gray);">
                        Showing <strong>{{ count($groupedSalaries) }}</strong> entries
                    </div>
                    <div style="font-size:14px; font-weight:600;">
                        Total: <span style="color:#10b981;">₹ {{ number_format($totalAmount ?? 0, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL - VIEW SALARY DETAILS              -->
<!-- ========================================== -->
<div class="modal-overlay" id="salaryModal">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fas fa-users"></i> <span id="modalTitle">Salary Details</span></h4>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-subtitle">
                <strong>Month:</strong> <span id="modalMonth"></span> &nbsp;|&nbsp;
                <strong>Payment Date:</strong> <span id="modalDate"></span> &nbsp;|&nbsp;
                <strong>Payment Type:</strong> <span id="modalPaymentType"></span>
            </div>
            <div id="modalContent">
                <table class="modal-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Trainer Name</th>
                            <th>Specialization</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody">
                        <!-- Dynamic content -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <span class="modal-total-label"><i class="fas fa-calculator"></i> Total Salary</span>
            <span class="modal-total-amount" id="modalTotalAmount">₹ 0.00</span>
        </div>
    </div>
</div>

<script>
// ============================================
// VIEW SALARY DETAILS - OPEN MODAL
// ============================================
function viewSalaryDetails(monthKey) {
    // Get all grouped salaries data from the page
    var allData = @json($groupedSalaries);

    // Find the matching month data
    var monthData = null;
    for (var i = 0; i < allData.length; i++) {
        if (allData[i].month_key === monthKey) {
            monthData = allData[i];
            break;
        }
    }

    if (!monthData || !monthData.trainers || monthData.trainers.length === 0) {
        alert('No salary records found for this month.');
        return;
    }

    // Set modal header
    document.getElementById('modalTitle').textContent = 'Salary Details - ' + monthData.month_year;
    document.getElementById('modalMonth').textContent = monthData.month_year;
    document.getElementById('modalDate').textContent = monthData.payment_date ? new Date(monthData.payment_date).toLocaleDateString('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-';
    document.getElementById('modalPaymentType').textContent = monthData.payment_type.charAt(0).toUpperCase() + monthData.payment_type.slice(1);

    // Build table body
    var tbody = document.getElementById('modalTableBody');
    tbody.innerHTML = '';
    var totalAmount = 0;

    monthData.trainers.forEach(function(trainer, index) {
        var tr = document.createElement('tr');
        var amount = parseFloat(trainer.amount) || 0;
        totalAmount += amount;

        tr.innerHTML = `
            <td>${index + 1}</td>
            <td><strong>${trainer.name}</strong></td>
            <td>${trainer.specialization}</td>
            <td class="modal-amount">₹ ${amount.toFixed(2)}</td>
        `;
        tbody.appendChild(tr);
    });

    // Update total
    document.getElementById('modalTotalAmount').textContent = '₹ ' + totalAmount.toFixed(2);

    // Show modal
    document.getElementById('salaryModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// ============================================
// CLOSE MODAL
// ============================================
function confirmDeleteMonth(month, totalAmount) {
    return confirm(
        'Delete all trainer salary records for ' +
        month +
        '?\n\n' +
        'Total Salary: ₹' +
        totalAmount +
        '\n\nThis will delete all trainer salary records for this month.'
    );
}

function closeModal() {
    document.getElementById('salaryModal').classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal on overlay click
document.getElementById('salaryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection