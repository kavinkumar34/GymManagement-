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

    .expense-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 20px;
    }

    .expense-card .card-header {
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

    .expense-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .expense-card .card-header h4 i {
        color: #4a9eff;
    }

    .expense-card .card-body {
        padding: 20px 24px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
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
    .stat-item .stat-value.orange { color: #f59e0b; }
    .stat-item .stat-value.blue { color: #3b82f6; }

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

    .btn-danger {
        background: var(--danger);
        color: #fff;
        border: none;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-danger:hover {
        background: #c62828;
        color: #fff;
    }

    .btn-warning {
        background: var(--warning);
        color: #fff;
        border: none;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-warning:hover {
        background: #e69100;
        color: #fff;
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

    .filter-section select,
    .filter-section input {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        background: #fff;
        height: 38px;
        min-width: 150px;
        transition: all 0.3s;
        color: var(--dark);
    }

    .filter-section select:focus,
    .filter-section input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-expenses {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
        min-width: 800px;
    }

    .table-expenses thead {
        background: var(--light-gray);
    }

    .table-expenses thead th {
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

    .table-expenses tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-expenses tbody tr:hover {
        background: #f8f9fa;
    }

    .table-expenses .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .table-expenses .amount {
        font-weight: 700;
        color: #ef4444;
        white-space: nowrap;
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

    .payment-tag.online {
        background: #e3f2fd;
        color: #1565c0;
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

    .action-btns {
        display: flex;
        gap: 4px;
        justify-content: center;
        align-items: center;
    }

    .action-btns .btn-action {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .action-btns .btn-action.edit {
        background: rgba(255, 167, 38, 0.1);
        color: #ffa726;
    }

    .action-btns .btn-action.edit:hover {
        background: #ffa726;
        color: #fff;
        transform: scale(1.1);
    }

    .action-btns .btn-action.delete {
        background: rgba(239, 83, 80, 0.1);
        color: #ef5350;
    }

    .action-btns .btn-action.delete:hover {
        background: #ef5350;
        color: #fff;
        transform: scale(1.1);
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

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
        .admin-main-content {
            padding: 12px 15px;
        }
        .expense-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .expense-card .card-header h4 {
            font-size: 16px;
        }
        .expense-card .card-body {
            padding: 14px 16px;
        }
        .stat-item .stat-value {
            font-size: 18px;
        }
        .filter-section {
            flex-direction: column;
        }
        .filter-section select,
        .filter-section input {
            width: 100%;
        }
        .table-expenses tbody td {
            padding: 6px 8px;
            font-size: 11px;
        }
        .table-expenses thead th {
            padding: 6px 8px;
            font-size: 10px;
        }
    }
</style>

<div class="admin-main-content">
    <div class="expense-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-money-bill-wave"></i> Expenses Management</h4>
                <small style="opacity:0.8;">Track all gym expenses</small>
            </div>
            <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Expense
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="custom-alert success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Stats -->
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-rupee-sign"></i></span>
                    <div class="stat-label">Total Expenses</div>
                    <div class="stat-value red">₹ {{ number_format($totalExpenses ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="stat-label">Cash Payments</div>
                    <div class="stat-value orange">₹ {{ number_format($totalCash ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-wifi"></i></span>
                    <div class="stat-label">Online Payments</div>
                    <div class="stat-value blue">₹ {{ number_format($totalOnline ?? 0, 2) }}</div>
                    <div class="stat-sub">All Time</div>
                </div>
            </div>

            <!-- Filter -->
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.expenses.index') }}" style="display:flex; flex-wrap:wrap; gap:10px; align-items:center; width:100%;">
                    <select name="month" onchange="this.form.submit()">
                        <option value="">All Months</option>
                        @foreach($months as $monthOption)
                            <option value="{{ $monthOption }}" {{ isset($month) && $monthOption == $month ? 'selected' : '' }}>
                                {{ date('M Y', strtotime($monthOption . '-01')) }}
                            </option>
                        @endforeach
                    </select>
                    <noscript>
                        <button type="submit" class="btn-primary" style="padding:8px 16px;">Filter</button>
                    </noscript>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-expenses">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">#</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Receipt</th>
                            <th>Added By</th>
                            <th class="text-center" style="width:100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $index => $expense)
                            <tr>
                                <td class="text-center sno">{{ $index + 1 }}</td>
                                <td>{{ $expense->formatted_date }}</td>
                                <td>{{ $expense->description }}</td>
                                <td><span class="amount">₹ {{ number_format($expense->amount, 2) }}</span></td>
                                <td>
                                    <span class="payment-tag {{ $expense->payment_type }}">
                                        <i class="fas {{ $expense->payment_type == 'cash' ? 'fa-hand-holding-usd' : 'fa-wifi' }}"></i>
                                        {{ $expense->payment_type_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($expense->receipt_image)
                                        <a href="{{ asset('storage/' . $expense->receipt_image) }}" target="_blank" class="btn-action edit" style="background:rgba(74,158,255,0.1); color:#4a9eff; padding:4px 10px; border-radius:4px; text-decoration:none;">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @else
                                        <span class="plan-tag none">-</span>
                                    @endif
                                </td>
                                <td>{{ $expense->createdBy->name ?? 'Admin' }}</td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn-action edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.expenses.destroy', $expense->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <h5>No Expenses Found</h5>
                                        <p>Click "Add Expense" to record your first expense.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($expenses->count() > 0)
                <div style="margin-top:16px; padding-top:14px; border-top:1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="font-size:13px; color:var(--gray);">
                        Showing <strong>{{ $expenses->count() }}</strong> entries
                    </div>
                    <div style="font-size:14px; font-weight:600;">
                        Total: <span style="color:#ef4444;">₹ {{ number_format($totalExpenses ?? 0, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection