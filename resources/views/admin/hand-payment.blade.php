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
            --shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            --radius: 10px;
            --radius-lg: 16px;
        }

        .admin-main-content {
            padding: 20px 25px;
            background: #f0f4f8;
            min-height: 100vh;
        }

        /* ============================================ */
        /* CARD STYLES                                 */
        /* ============================================ */
        .payment-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 100%;
            margin: 0 auto;
        }

        .payment-card .card-header {
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

        .payment-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-card .card-header h4 i {
            color: #4a9eff;
        }

        .payment-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .payment-card .card-body {
            padding: 20px 24px;
        }

        .header-date {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
        }

        .header-date i {
            margin-right: 4px;
        }

        /* ============================================ */
        /* SEARCH & FILTER SECTION                    */
        /* ============================================ */
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

        /* ============================================ */
        /* CUSTOM ALERT - AUTO HIDE                    */
        /* ============================================ */
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
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

        .custom-alert .alert-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        .custom-alert .alert-content {
            flex: 1;
        }

        .custom-alert .alert-content strong {
            font-weight: 600;
        }

        .custom-alert .alert-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: inherit;
            opacity: 0.5;
            padding: 0 4px;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .custom-alert .alert-close:hover {
            opacity: 1;
        }

        .custom-alert .alert-timer {
            width: 60px;
            height: 3px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .custom-alert .alert-timer .timer-bar {
            height: 100%;
            border-radius: 4px;
            animation: timerShrink 3s linear forwards;
        }

        .custom-alert.success .alert-timer .timer-bar {
            background: #4caf50;
        }

        .custom-alert.error .alert-timer .timer-bar {
            background: #ef5350;
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

        @keyframes timerShrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* ============================================ */
        /* TABLE STYLES - ALL DATA IN SINGLE LINE      */
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

        .table-payment .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .table-payment .member-id-badge {
            font-family: monospace;
            font-size: 12px;
            color: var(--gray);
            background: #f8f9fa;
            padding: 2px 10px;
            border-radius: 4px;
            white-space: nowrap;
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

        /* ===== PLAN TAG STYLES ===== */
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

        /* ===== PLAN NAME BADGE ===== */
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

        /* ===== PAYMENT TYPE STYLES ===== */
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

        /* ===== PRICE ===== */
        .table-payment .price-amount {
            font-weight: 700;
            color: #10b981;
            font-size: 14px;
            white-space: nowrap;
        }

        /* ===== TRANSACTION ID ===== */
        .table-payment .transaction-id {
            font-size: 11px;
            font-family: monospace;
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 4px;
            color: var(--gray);
            white-space: nowrap;
        }

        /* ===== JOIN DATE ===== */
        .table-payment .join-date {
            font-size: 12px;
            color: var(--gray);
            white-space: nowrap;
        }

        /* ============================================ */
        /* PAGINATION                                 */
        /* ============================================ */
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

        .pagination-wrapper .pagination-info strong {
            color: var(--dark);
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

        /* ============================================ */
        /* EMPTY STATE                                 */
        /* ============================================ */
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
        /* RESPONSIVE                                  */
        /* ============================================ */
        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .payment-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .payment-card .card-header h4 {
                font-size: 16px;
            }

            .payment-card .card-body {
                padding: 14px 16px;
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
            .payment-card .card-header h4 {
                font-size: 14px;
            }

            .payment-card .card-body {
                padding: 10px 12px;
            }

            .search-filter-section .search-box input {
                font-size: 12px;
                height: 34px;
            }

            .search-filter-section .filter-group select {
                font-size: 12px;
                height: 34px;
            }

            .search-filter-section .filter-group .btn-reset {
                font-size: 12px;
                height: 34px;
            }

            .table-payment tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-payment thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .table-payment .avatar-img {
                width: 30px;
                height: 30px;
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
        <div class="payment-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-hand-holding-usd"></i> Hand Payment</h4>
                    <small>Manage hand payments for members</small>
                </div>
                <span class="header-date">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('d M Y, h:i A') }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Custom Alert -->
                @if (session('success'))
                    <div class="custom-alert success" id="customAlert">
                        <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                        <span class="alert-content"><strong>Success!</strong> {{ session('success') }}</span>
                        <button class="alert-close" onclick="closeAlert()">&times;</button>
                        <div class="alert-timer">
                            <div class="timer-bar"></div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="custom-alert error" id="customAlert">
                        <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                        <span class="alert-content"><strong>Error!</strong> {{ session('error') }}</span>
                        <button class="alert-close" onclick="closeAlert()">&times;</button>
                        <div class="alert-timer">
                            <div class="timer-bar"></div>
                        </div>
                    </div>
                @endif

                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by name, email, phone, member ID..."
                            onkeyup="filterTable()">
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
                        <select id="priceFilter" onchange="filterTable()">
                            <option value="">All Prices</option>
                            <option value="high">High to Low</option>
                            <option value="low">Low to High</option>
                        </select>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-payment" id="paymentTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">S.No</th>
                                <th style="width:50px;">Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Plan Type</th>
                                <th>Plan Name</th>
                                <th>Final Price</th>
                                <th>Payment Type</th>
                                <th>Transaction ID</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($members as $index => $member)
                                <tr>
                                    <td class="text-center sno">{{ $members->firstItem() + $index }}</td>
                                    <td>
                                        @if ($member->photo)
                                            <img src="{{ asset('storage/' . $member->photo) }}" class="avatar-img"
                                                alt="{{ $member->name }}">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" class="avatar-img" alt="No Image">
                                        @endif
                                    </td>
                                    <td><span class="member-id-badge">{{ $member->member_id }}</span></td>
                                    <td>
                                        <span class="member-name">{{ $member->name }}</span>
                                        <span class="member-email">{{ $member->email }}</span>
                                    </td>
                                    <td>{{ $member->phone }}</td>
                                    
                                    <!-- ===== PLAN TYPE ===== -->
                                    <td>
                                        @if ($member->plan_type == 'membership')
                                            <span class="plan-tag membership"><i class="fas fa-id-card"></i> Membership</span>
                                        @elseif($member->plan_type == 'package')
                                            <span class="plan-tag package"><i class="fas fa-box"></i> Package</span>
                                        @elseif($member->plan_type == 'monthly')
                                            <span class="plan-tag monthly"><i class="fas fa-calendar-alt"></i> Monthly</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- ===== PLAN NAME ===== -->
                                    <td>
                                        <span class="plan-name-badge">
                                            <i class="fas fa-tag"></i> {{ $member->membership_plan ?? 'Basic' }}
                                        </span>
                                    </td>
                                    
                                    <!-- ===== FINAL PRICE ===== -->
                                    <td><span class="price-amount">₹ {{ number_format($member->final_price ?? 0, 2) }}</span></td>
                                    
                                    <!-- ===== PAYMENT TYPE ===== -->
                                    <td>
                                        @if($member->payment_type == 'hand')
                                            <span class="payment-tag hand"><i class="fas fa-hand-holding-usd"></i> Hand</span>
                                        @elseif($member->payment_type == 'online')
                                            <span class="payment-tag online"><i class="fas fa-wifi"></i> Online</span>
                                        @else
                                            <span class="payment-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- ===== TRANSACTION ID ===== -->
                                    <td>
                                        @if($member->transaction_id)
                                            <span class="transaction-id">{{ $member->transaction_id }}</span>
                                        @else
                                            <span class="plan-tag none">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- ===== JOINED DATE ===== -->
                                    <td><span class="join-date">{{ date('d-m-Y', strtotime($member->join_date)) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <div class="empty-state">
                                            <i class="fas fa-hand-holding-usd"></i>
                                            <h5>No Members Found</h5>
                                            <p>No members are available for hand payment.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <strong>{{ $members->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $members->lastItem() ?? 0 }}</strong> of <strong>{{ $members->total() ?? 0 }}</strong>
                        entries
                    </div>
                    <div class="pagination-links">
                        {{ $members->links() }}
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
        // SEARCH & FILTER TABLE
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var planFilter = document.getElementById('planFilter').value.toLowerCase();
            var paymentFilter = document.getElementById('paymentFilter').value.toLowerCase();
            var priceFilter = document.getElementById('priceFilter').value;

            var rows = document.querySelectorAll('#tableBody tr');

            // Collect all rows with their data for sorting
            var rowData = [];

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var planType = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase() || '';
                var paymentType = row.querySelector('td:nth-child(9)')?.textContent.toLowerCase() || '';
                var priceText = row.querySelector('td:nth-child(8)')?.textContent.replace('₹', '').replace(/,/g, '')
                    .trim() || '0';
                var price = parseFloat(priceText) || 0;

                var matchesSearch = text.includes(searchValue);
                var matchesPlan = planFilter === '' || planType.includes(planFilter);
                var matchesPayment = paymentFilter === '' || paymentType.includes(paymentFilter);

                if (matchesSearch && matchesPlan && matchesPayment) {
                    rowData.push({
                        row: row,
                        price: price,
                        display: true
                    });
                } else {
                    rowData.push({
                        row: row,
                        price: price,
                        display: false
                    });
                }
            });

            // Sort by price if filter is applied
            if (priceFilter === 'high') {
                rowData.sort((a, b) => b.price - a.price);
            } else if (priceFilter === 'low') {
                rowData.sort((a, b) => a.price - b.price);
            }

            // Reorder rows in the table
            var tbody = document.getElementById('tableBody');
            rowData.forEach(function(item) {
                if (item.display) {
                    tbody.appendChild(item.row);
                    item.row.style.display = '';
                } else {
                    item.row.style.display = 'none';
                }
            });

            // Show/hide "No results" message
            var visibleRows = document.querySelectorAll('#tableBody tr[style*="display: none"]');
            var allRows = document.querySelectorAll('#tableBody tr');

            var noResultRow = document.querySelector('#noResultRow');
            if (noResultRow) {
                noResultRow.remove();
            }

            if (allRows.length > 0 && allRows.length === visibleRows.length) {
                var tbody2 = document.getElementById('tableBody');
                var tr = document.createElement('tr');
                tr.id = 'noResultRow';
                var td = document.createElement('td');
                td.colSpan = 11;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No members found matching your filters.';
                tr.appendChild(td);
                tbody2.appendChild(tr);
            }
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('planFilter').value = '';
            document.getElementById('paymentFilter').value = '';
            document.getElementById('priceFilter').value = '';
            filterTable();
        }

        // ============================================
        // CUSTOM ALERT - AUTO HIDE AFTER 3 SECONDS
        // ============================================
        function closeAlert() {
            var alert = document.getElementById('customAlert');
            if (alert) {
                alert.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('customAlert');
            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection