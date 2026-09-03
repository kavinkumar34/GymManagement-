@extends('layouts.admin-layout')

@section('content')
<style>
    /* ============================================ */
    /* COLOR VARIABLES                             */
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

    .report-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 20px;
    }

    .report-card .card-header {
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

    .report-card .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .report-card .card-header h4 i {
        color: #4a9eff;
    }

    .report-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .report-card .card-body {
        padding: 20px 24px;
    }

    /* ============================================ */
    /* STAT CARDS                                  */
    /* ============================================ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    @media (max-width: 1200px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .stat-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
        .stat-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .stat-item {
        background: #ffffff;
        border-radius: var(--radius);
        padding: 16px 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
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

    .stat-item .stat-value.green { color: #10b981; }
    .stat-item .stat-value.blue { color: #3b82f6; }
    .stat-item .stat-value.orange { color: #f59e0b; }
    .stat-item .stat-value.purple { color: #8b5cf6; }
    .stat-item .stat-value.red { color: #ef4444; }
    .stat-item .stat-value.teal { color: #0d9488; }
    .stat-item .stat-value.pink { color: #ec4899; }
    .stat-item .stat-value.indigo { color: #6366f1; }

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

    .stat-item .stat-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 10px;
        background: var(--primary);
        color: #fff;
        padding: 2px 10px;
        border-radius: 50px;
        font-weight: 500;
    }

    /* ============================================ */
    /* TABLE CONTAINER                             */
    /* ============================================ */
    .table-container {
        display: none;
        animation: fadeIn 0.5s ease;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid var(--border-color);
    }

    .table-container.active {
        display: block;
    }

    .table-container .table-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-container .table-title i {
        color: var(--primary);
    }

    .table-container .close-table {
        float: right;
        background: none;
        border: none;
        color: var(--gray);
        font-size: 20px;
        cursor: pointer;
        padding: 0 8px;
        transition: all 0.3s;
    }

    .table-container .close-table:hover {
        color: var(--danger);
        transform: rotate(90deg);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ============================================ */
    /* TABLE STYLES                                */
    /* ============================================ */
    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-payment {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
        min-width: 1200px;
    }

    .table-payment thead {
        background: var(--light-gray);
    }

    .table-payment thead th {
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

    .table-payment thead th.text-center {
        text-align: center;
    }

    .table-payment tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        white-space: nowrap;
    }

    .table-payment tbody tr:hover {
        background: #f8f9fa;
    }

    .table-payment tbody tr:last-child td {
        border-bottom: none;
    }

    .table-payment .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .table-payment .member-name {
        font-weight: 600;
        color: var(--dark);
        display: inline-block;
    }

    .table-payment .member-email {
        font-size: 11px;
        color: var(--gray);
        display: inline-block;
        margin-left: 4px;
    }

    .table-payment .plan-tag {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .table-payment .plan-tag.membership {
        background: #e3f2fd;
        color: #1565c0;
    }

    .table-payment .plan-tag.package {
        background: #fef3c7;
        color: #92400e;
    }

    .table-payment .plan-tag.monthly {
        background: #fff3e0;
        color: #e65100;
    }

    .table-payment .plan-tag.none {
        background: #f5f5f5;
        color: #9e9e9e;
    }

    .table-payment .plan-name-badge {
        background: #dbeafe;
        color: #1d4ed8;
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .table-payment .payment-tag {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .table-payment .payment-tag.hand {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .table-payment .payment-tag.online {
        background: #e3f2fd;
        color: #1565c0;
    }

    .table-payment .payment-tag.none {
        background: #f5f5f5;
        color: #9e9e9e;
    }

    .table-payment .price-amount {
        font-weight: 700;
        color: #10b981;
        font-size: 14px;
        white-space: nowrap;
    }

    .table-payment .transaction-id {
        font-size: 11px;
        font-family: monospace;
        background: #f0f0f0;
        padding: 2px 8px;
        border-radius: 4px;
        color: var(--gray);
        white-space: nowrap;
    }

    .table-payment .join-date {
        font-size: 12px;
        color: var(--gray);
        white-space: nowrap;
    }

    .table-payment .status-badge {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .table-payment .status-badge.new {
        background: #dcfce7;
        color: #15803d;
    }

    .table-payment .status-badge.renewed {
        background: #fef3c7;
        color: #92400e;
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

    .search-filter-section {
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

    .search-filter-section .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-filter-section .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        font-size: 14px;
    }

    .search-filter-section .search-box input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        transition: all 0.3s;
        background: #fff;
        height: 38px;
    }

    .search-filter-section .search-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .search-filter-section .filter-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-filter-section .filter-group select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 13px;
        background: #fff;
        height: 38px;
        min-width: 130px;
        transition: all 0.3s;
        color: var(--dark);
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    .search-filter-section .filter-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
        outline: none;
    }

    .search-filter-section .filter-group .btn-reset {
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

    .search-filter-section .filter-group .btn-reset:hover {
        background: #c62828;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 83, 80, 0.35);
    }

    .export-btn {
        background: #22c55e;
        color: white;
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
        height: 38px;
    }

    .export-btn:hover {
        background: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
        color: white;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid var(--border-color);
    }

    .pagination-wrapper .pagination-info {
        font-size: 13px;
        color: var(--gray);
    }

    .pagination-wrapper .pagination-links {
        display: flex;
        gap: 4px;
    }

    .pagination-wrapper .pagination-links .page-item {
        display: inline-block;
    }

    .pagination-wrapper .pagination-links .page-item a,
    .pagination-wrapper .pagination-links .page-item span {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        color: var(--gray);
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid transparent;
        min-width: 36px;
        text-align: center;
    }

    .pagination-wrapper .pagination-links .page-item a:hover {
        background: #f0f0f0;
        color: var(--dark);
    }

    .pagination-wrapper .pagination-links .page-item.active a,
    .pagination-wrapper .pagination-links .page-item.active span {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .pagination-wrapper .pagination-links .page-item.disabled a,
    .pagination-wrapper .pagination-links .page-item.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .admin-main-content {
            padding: 12px 15px;
        }

        .report-card .card-header {
            padding: 12px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .report-card .card-header h4 {
            font-size: 16px;
        }

        .report-card .card-body {
            padding: 14px 16px;
        }

        .stat-item .stat-value {
            font-size: 18px;
        }

        .search-filter-section {
            flex-direction: column;
            padding: 12px 14px;
        }

        .search-filter-section .filter-group {
            flex-direction: column;
            width: 100%;
        }

        .search-filter-section .filter-group select {
            width: 100%;
        }

        .search-filter-section .filter-group .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .export-btn {
            width: 100%;
            justify-content: center;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .table-payment thead th {
            font-size: 10px;
            padding: 6px 8px;
        }

        .table-payment tbody td {
            padding: 6px 8px;
            font-size: 11px;
        }

        .pagination-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .pagination-wrapper .pagination-info {
            font-size: 12px;
        }

        .pagination-wrapper .pagination-links .page-item a,
        .pagination-wrapper .pagination-links .page-item span {
            padding: 4px 10px;
            font-size: 12px;
            min-width: 30px;
        }
    }

    @media (max-width: 576px) {
        .report-card .card-header h4 {
            font-size: 14px;
        }

        .report-card .card-body {
            padding: 10px 12px;
        }

        .stat-item {
            padding: 12px 14px;
        }

        .stat-item .stat-value {
            font-size: 16px;
        }

        .table-payment tbody td {
            padding: 4px 6px;
            font-size: 10px;
        }

        .table-payment thead th {
            padding: 4px 6px;
            font-size: 9px;
        }

        .table-payment .plan-tag {
            font-size: 9px;
            padding: 2px 8px;
        }

        .table-payment .plan-name-badge {
            font-size: 9px;
            padding: 2px 8px;
        }

        .table-payment .price-amount {
            font-size: 12px;
        }
    }
</style>

<div class="admin-main-content">
    
    <!-- ========================================== -->
    <!-- FINANCE REPORT CARD                        -->
    <!-- ========================================== -->
    <div class="report-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-chart-line"></i> Finance Reports</h4>
                <small>Revenue overview by plan type & payment method</small>
            </div>
            <span style="color: rgba(255,255,255,0.7); font-size: 13px;">
                <i class="fas fa-calendar-alt"></i> {{ now()->format('d M Y, h:i A') }}
            </span>
        </div>

        <div class="card-body">
            
            <!-- ========================================== -->
            <!-- REVENUE BY PLAN TYPE                       -->
            <!-- ========================================== -->
            <h6 style="font-weight:600; color:#1a1a2e; margin-bottom:12px;">
                <i class="fas fa-chart-pie" style="color: #4a9eff;"></i> Revenue by Plan Type
            </h6>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-id-card"></i></span>
                    <div class="stat-label">Membership Revenue</div>
                    <div class="stat-value blue">₹ {{ number_format($membershipRevenue, 2) }}</div>
                    <div class="stat-sub">{{ $membershipCount }} Active Members</div>
                </div>

                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-box"></i></span>
                    <div class="stat-label">Package Revenue</div>
                    <div class="stat-value green">₹ {{ number_format($packageRevenue, 2) }}</div>
                    <div class="stat-sub">{{ $packageCount }} Active Members</div>
                </div>

            <!--    <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-calendar-alt"></i></span>
                    <div class="stat-label">Monthly Plan Revenue</div>
                    <div class="stat-value orange">₹ {{ number_format($monthlyRevenue, 2) }}</div>
                    <div class="stat-sub">{{ $monthlyCount }} Active Members</div>
                </div> -->

                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-rupee-sign"></i></span>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value purple">₹ {{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-sub">{{ $totalMembers }} Total Active Members</div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- REVENUE BY PAYMENT TYPE                    -->
            <!-- ========================================== -->
            <h6 style="font-weight:600; color:#1a1a2e; margin:20px 0 12px 0;">
                <i class="fas fa-credit-card" style="color: #4a9eff;"></i> Revenue by Payment Type
            </h6>
            <div class="stat-grid-2">
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="stat-label">Hand Payment Revenue</div>
                    <div class="stat-value teal">₹ {{ number_format($handPaymentRevenue, 2) }}</div>
                    <div class="stat-sub">{{ $handCount }} Active Members</div>
                </div>

                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-wifi"></i></span>
                    <div class="stat-label">Online Payment Revenue</div>
                    <div class="stat-value pink">₹ {{ number_format($onlinePaymentRevenue, 2) }}</div>
                    <div class="stat-sub">{{ $onlineCount }} Active Members</div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- DAYWISE & MONTHWISE COLLECTION BOXES      -->
            <!-- ========================================== -->
            <h6 style="font-weight:600; color:#1a1a2e; margin:20px 0 12px 0;">
                <i class="fas fa-calendar-alt" style="color: #4a9eff;"></i> Collection Reports
                <small style="font-weight:400; color:var(--gray); font-size:12px; margin-left:8px;">Click on a box to view details</small>
            </h6>
            <div class="stat-grid-2">
                <!-- Daywise Box -->
                <div class="stat-item" onclick="toggleTable('daywiseTableContainer')" style="cursor:pointer; border-left: 4px solid #3b82f6;">
                    <span class="stat-icon"><i class="fas fa-calendar-day"></i></span>
                    <span class="stat-badge" style="background:#3b82f6;">Click to View</span>
                    <div class="stat-label">Daywise Collection</div>
                    <div class="stat-value indigo">₹ {{ number_format($daywiseTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">Today | {{ $daywisePayments->count() }} Payments</div>
                </div>

                <!-- Monthwise Box -->
                <div class="stat-item" onclick="toggleTable('monthwiseTableContainer')" style="cursor:pointer; border-left: 4px solid #10b981;">
                    <span class="stat-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span class="stat-badge" style="background:#10b981;">Click to View</span>
                    <div class="stat-label">Monthwise Collection</div>
                    <div class="stat-value green">₹ {{ number_format($monthwiseTotal ?? 0, 2) }}</div>
                    <div class="stat-sub">Last 12 Months | {{ $monthwisePayments->count() }} Payments</div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- DAYWISE TABLE (Hidden by default)          -->
            <!-- ========================================== -->
            <div class="table-container" id="daywiseTableContainer">
                <div class="table-title">
                    <i class="fas fa-calendar-day" style="color: #3b82f6;"></i> Daywise Collection (Today - {{ now()->format('d-m-Y') }})
                    <button class="close-table" onclick="toggleTable('daywiseTableContainer')">&times;</button>
                </div>
                <div class="table-responsive">
                    <table class="table-payment">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>Member</th>
                                <th>Plan Type</th>
                                <th>Plan Name</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Payment Type</th>
                                <th>Transaction ID</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daywisePayments as $index => $payment)
                                <tr>
                                    <td class="text-center sno">{{ $index + 1 }}</td>
                                    <td>
                                        @if($payment->member)
                                            <span class="member-name">{{ $payment->member->name }}</span>
                                            <span class="member-email">{{ $payment->member->email }}</span>
                                        @else
                                            <span class="plan-tag none">Member Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->plan_type == 'membership')
                                            <span class="plan-tag membership"><i class="fas fa-id-card"></i> Membership</span>
                                        @elseif($payment->plan_type == 'package')
                                            <span class="plan-tag package"><i class="fas fa-box"></i> Package</span>
                                        @elseif($payment->plan_type == 'monthly')
                                            <span class="plan-tag monthly"><i class="fas fa-calendar-alt"></i> Monthly</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="plan-name-badge">
                                            <i class="fas fa-tag"></i> {{ $payment->plan_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->duration ?? '-' }}</td>
                                    <td><span class="price-amount">₹ {{ number_format($payment->amount, 2) }}</span></td>
                                    <td>
                                        @if($payment->payment_type == 'hand')
                                            <span class="payment-tag hand"><i class="fas fa-hand-holding-usd"></i> Hand</span>
                                        @elseif($payment->payment_type == 'online')
                                            <span class="payment-tag online"><i class="fas fa-wifi"></i> Online</span>
                                        @else
                                            <span class="payment-tag none">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->transaction_id)
                                            <span class="transaction-id">{{ $payment->transaction_id }}</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    <td><span class="join-date">{{ date('d-m-Y', strtotime($payment->payment_date)) }}</span></td>
                                    <td>
                                        @if($payment->old_expiry_date && $payment->new_expiry_date)
                                            <span class="status-badge renewed">
                                                <i class="fas fa-sync"></i> Renewed
                                            </span>
                                        @else
                                            <span class="status-badge new">
                                                <i class="fas fa-check"></i> New
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-day"></i>
                                            <h5>No Daywise Payments Found</h5>
                                            <p>No payments recorded today.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- MONTHWISE TABLE (Hidden by default)        -->
            <!-- ========================================== -->
            <div class="table-container" id="monthwiseTableContainer">
                <div class="table-title">
                    <i class="fas fa-calendar-alt" style="color: #10b981;"></i> Monthwise Collection (Last 12 Months)
                    <button class="close-table" onclick="toggleTable('monthwiseTableContainer')">&times;</button>
                </div>
                <div class="table-responsive">
                    <table class="table-payment">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>Member</th>
                                <th>Plan Type</th>
                                <th>Plan Name</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Payment Type</th>
                                <th>Transaction ID</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthwisePayments as $index => $payment)
                                <tr>
                                    <td class="text-center sno">{{ $index + 1 }}</td>
                                    <td>
                                        @if($payment->member)
                                            <span class="member-name">{{ $payment->member->name }}</span>
                                            <span class="member-email">{{ $payment->member->email }}</span>
                                        @else
                                            <span class="plan-tag none">Member Deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->plan_type == 'membership')
                                            <span class="plan-tag membership"><i class="fas fa-id-card"></i> Membership</span>
                                        @elseif($payment->plan_type == 'package')
                                            <span class="plan-tag package"><i class="fas fa-box"></i> Package</span>
                                        @elseif($payment->plan_type == 'monthly')
                                            <span class="plan-tag monthly"><i class="fas fa-calendar-alt"></i> Monthly</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="plan-name-badge">
                                            <i class="fas fa-tag"></i> {{ $payment->plan_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->duration ?? '-' }}</td>
                                    <td><span class="price-amount">₹ {{ number_format($payment->amount, 2) }}</span></td>
                                    <td>
                                        @if($payment->payment_type == 'hand')
                                            <span class="payment-tag hand"><i class="fas fa-hand-holding-usd"></i> Hand</span>
                                        @elseif($payment->payment_type == 'online')
                                            <span class="payment-tag online"><i class="fas fa-wifi"></i> Online</span>
                                        @else
                                            <span class="payment-tag none">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->transaction_id)
                                            <span class="transaction-id">{{ $payment->transaction_id }}</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    <td><span class="join-date">{{ date('d-m-Y', strtotime($payment->payment_date)) }}</span></td>
                                    <td>
                                        @if($payment->old_expiry_date && $payment->new_expiry_date)
                                            <span class="status-badge renewed">
                                                <i class="fas fa-sync"></i> Renewed
                                            </span>
                                        @else
                                            <span class="status-badge new">
                                                <i class="fas fa-check"></i> New
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-alt"></i>
                                            <h5>No Monthwise Payments Found</h5>
                                            <p>No payments recorded in the last 12 months.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- PAYMENT HISTORY TABLE                      -->
    <!-- ========================================== -->
    <div class="report-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-history"></i> Payment History</h4>
                <small>Complete payment history of all members (old + new renewals)</small>
            </div>
            <div class="header-actions">
                <span style="color: rgba(255,255,255,0.7); font-size: 13px;">
                    <i class="fas fa-credit-card"></i> Total Payments: {{ $paymentHistory->total() }}
                </span>
                <button class="export-btn" onclick="exportTableToCSV()">
                    <i class="fas fa-file-excel"></i> Export to CSV
                </button>
            </div>
        </div>

        <div class="card-body">
            
            <!-- ===== SEARCH & FILTER ===== -->
            <div class="search-filter-section">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by member name, email, plan..." onkeyup="filterTable()">
                </div>
                <div class="filter-group">
                    <select id="planFilter" onchange="filterTable()">
                        <option value="">All Plans</option>
                        <option value="membership">Membership</option>
                        <option value="package">Package</option>
                        <option value="monthly">Monthly Plan</option>
                    </select>
                    <select id="paymentFilter" onchange="filterTable()">
                        <option value="">All Payment Types</option>
                        <option value="hand">Hand Payment</option>
                        <option value="online">Online Payment</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <!-- ===== TABLE ===== -->
            <div class="table-responsive">
                <table class="table-payment" id="paymentTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">#</th>
                            <th>Member</th>
                            <th>Plan Type</th>
                            <th>Plan Name</th>
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Transaction ID</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($paymentHistory as $index => $payment)
                            <tr>
                                <td class="text-center sno">{{ $paymentHistory->firstItem() + $index }}</td>
                                <td>
                                    @if($payment->member)
                                        <span class="member-name">{{ $payment->member->name }}</span>
                                        <span class="member-email">{{ $payment->member->email }}</span>
                                    @else
                                        <span class="plan-tag none">Member Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->plan_type == 'membership')
                                        <span class="plan-tag membership"><i class="fas fa-id-card"></i> Membership</span>
                                    @elseif($payment->plan_type == 'package')
                                        <span class="plan-tag package"><i class="fas fa-box"></i> Package</span>
                                    @elseif($payment->plan_type == 'monthly')
                                        <span class="plan-tag monthly"><i class="fas fa-calendar-alt"></i> Monthly</span>
                                    @else
                                        <span class="plan-tag none">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="plan-name-badge">
                                        <i class="fas fa-tag"></i> {{ $payment->plan_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $payment->duration ?? '-' }}</td>
                                <td><span class="price-amount">₹ {{ number_format($payment->amount, 2) }}</span></td>
                                <td>
                                    @if($payment->payment_type == 'hand')
                                        <span class="payment-tag hand"><i class="fas fa-hand-holding-usd"></i> Hand</span>
                                    @elseif($payment->payment_type == 'online')
                                        <span class="payment-tag online"><i class="fas fa-wifi"></i> Online</span>
                                    @else
                                        <span class="payment-tag none">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->transaction_id)
                                        <span class="transaction-id">{{ $payment->transaction_id }}</span>
                                    @else
                                        <span class="plan-tag none">-</span>
                                    @endif
                                </td>
                                <td><span class="join-date">{{ date('d-m-Y', strtotime($payment->payment_date)) }}</span></td>
                                <td>
                                    @if($payment->old_expiry_date && $payment->new_expiry_date)
                                        <span class="status-badge renewed">
                                            <i class="fas fa-sync"></i> Renewed
                                        </span>
                                    @else
                                        <span class="status-badge new">
                                            <i class="fas fa-check"></i> New
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="fas fa-credit-card"></i>
                                        <h5>No Payment History Found</h5>
                                        <p>No payments have been recorded yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Showing <strong>{{ $paymentHistory->firstItem() ?? 0 }}</strong> to
                    <strong>{{ $paymentHistory->lastItem() ?? 0 }}</strong> of <strong>{{ $paymentHistory->total() ?? 0 }}</strong>
                    entries
                </div>
                <div class="pagination-links">
                    {{ $paymentHistory->links() }}
                </div>
            </div>

        </div>
    </div>

</div>

<!-- ========================================== -->
<!-- SCRIPTS                                    -->
<!-- ========================================== -->
<script>
// ============================================
// TOGGLE TABLE VISIBILITY
// ============================================
function toggleTable(tableId) {
    var container = document.getElementById(tableId);
    if (container) {
        var allTables = document.querySelectorAll('.table-container');
        allTables.forEach(function(table) {
            if (table.id !== tableId) {
                table.classList.remove('active');
            }
        });
        container.classList.toggle('active');
    }
}

// ============================================
// SEARCH & FILTER TABLE
// ============================================
function filterTable() {
    var searchValue = document.getElementById('searchInput').value.toLowerCase();
    var planFilter = document.getElementById('planFilter').value.toLowerCase();
    var paymentFilter = document.getElementById('paymentFilter').value.toLowerCase();

    var rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var planType = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
        var paymentType = row.querySelector('td:nth-child(7)')?.textContent.toLowerCase() || '';

        var matchesSearch = text.includes(searchValue);
        var matchesPlan = planFilter === '' || planType.includes(planFilter);
        var matchesPayment = paymentFilter === '' || paymentType.includes(paymentFilter);

        if (matchesSearch && matchesPlan && matchesPayment) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    var visibleRows = document.querySelectorAll('#tableBody tr[style*="display: none"]');
    var allRows = document.querySelectorAll('#tableBody tr');

    var noResultRow = document.querySelector('#noResultRow');
    if (noResultRow) {
        noResultRow.remove();
    }

    if (allRows.length > 0 && allRows.length === visibleRows.length) {
        var tbody = document.getElementById('tableBody');
        var tr = document.createElement('tr');
        tr.id = 'noResultRow';
        var td = document.createElement('td');
        td.colSpan = 10;
        td.style.textAlign = 'center';
        td.style.padding = '30px';
        td.style.color = '#6c757d';
        td.innerHTML = '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No payment history found matching your filters.';
        tr.appendChild(td);
        tbody.appendChild(tr);
    }
}

// ============================================
// RESET FILTERS
// ============================================
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('planFilter').value = '';
    document.getElementById('paymentFilter').value = '';
    filterTable();
}

// ============================================
// EXPORT TABLE TO CSV
// ============================================
function exportTableToCSV() {
    var rows = document.querySelectorAll('#paymentTable tbody tr');
    var data = [];

    var headers = ['#', 'Member Name', 'Member Email', 'Plan Type', 'Plan Name', 'Duration', 'Amount', 'Payment Type', 'Transaction ID', 'Payment Date', 'Status'];
    data.push(headers);

    rows.forEach(function(row) {
        if (row.style.display === 'none') return;

        var rowData = [];
        var cells = row.querySelectorAll('td');

        if (cells.length === 0) return;

        cells.forEach(function(cell, index) {
            var text = cell.textContent.trim();

            if (index === 0) {
                rowData.push(text);
            } else if (index === 1) {
                var name = cell.querySelector('.member-name')?.textContent.trim() || '';
                var email = cell.querySelector('.member-email')?.textContent.trim() || '';
                rowData.push(name);
                rowData.push(email);
            } else if (index === 2) {
                var planTag = cell.querySelector('.plan-tag');
                rowData.push(planTag ? planTag.textContent.trim() : text);
            } else if (index === 3) {
                var planName = cell.querySelector('.plan-name-badge');
                rowData.push(planName ? planName.textContent.trim() : text);
            } else if (index === 4) {
                rowData.push(text);
            } else if (index === 5) {
                var price = cell.querySelector('.price-amount');
                rowData.push(price ? price.textContent.trim() : text);
            } else if (index === 6) {
                var paymentTag = cell.querySelector('.payment-tag');
                rowData.push(paymentTag ? paymentTag.textContent.trim() : text);
            } else if (index === 7) {
                var transId = cell.querySelector('.transaction-id');
                rowData.push(transId ? transId.textContent.trim() : text);
            } else if (index === 8) {
                rowData.push(text);
            } else if (index === 9) {
                var statusBadge = cell.querySelector('.status-badge');
                rowData.push(statusBadge ? statusBadge.textContent.trim() : text);
            }
        });

        data.push(rowData);
    });

    var csvContent = '';
    data.forEach(function(row) {
        var rowStr = row.map(function(cell) {
            if (typeof cell === 'string' && (cell.includes(',') || cell.includes('"') || cell.includes('\n'))) {
                return '"' + cell.replace(/"/g, '""') + '"';
            }
            return cell;
        }).join(',');
        csvContent += rowStr + '\n';
    });

    var blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement('a');
    var url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'payment_history_' + new Date().toISOString().slice(0,10) + '.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}
</script>

@endsection