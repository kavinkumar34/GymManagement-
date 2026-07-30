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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .page-header h4 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-header h4 i {
            color: var(--primary);
        }

        .btn-add {
            background: var(--success);
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-add:hover {
            background: #388e3c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.35);
        }

        .list-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 100%;
            margin: 0 auto;
        }

        .list-card .card-body {
            padding: 20px 24px;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .table-coupons {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-coupons thead {
            background: var(--light-gray);
        }

        .table-coupons thead th {
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

        .table-coupons thead th.text-center {
            text-align: center;
        }

        .table-coupons tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-coupons tbody tr:hover {
            background: #f8f9fa;
        }

        .table-coupons tbody tr:last-child td {
            border-bottom: none;
        }

        .table-coupons .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-coupons .code-text {
            font-weight: 700;
            color: var(--dark);
            font-family: monospace;
            font-size: 14px;
            background: #f0f4f8;
            padding: 3px 12px;
            border-radius: 6px;
            display: inline-block;
        }

        .table-coupons .name-text {
            color: var(--dark);
        }

        .table-coupons .type-badge {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .table-coupons .type-badge.percentage {
            background: #e3f2fd;
            color: #1565c0;
        }

        .table-coupons .type-badge.fixed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-coupons .value-text {
            font-weight: 500;
        }

        .table-coupons .min-order {
            font-size: 12px;
            color: var(--gray);
        }

        .table-coupons .usage-text {
            font-size: 12px;
        }

        .table-coupons .usage-text strong {
            color: var(--dark);
        }

        .table-coupons .validity-text {
            font-size: 11px;
            color: var(--gray);
        }

        .table-coupons .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-coupons .status-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-coupons .status-badge.inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .table-coupons .status-badge.expired {
            background: #fef3c7;
            color: #92400e;
        }

        .table-coupons .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-coupons .status-badge.active .dot {
            background: #4caf50;
        }

        .table-coupons .status-badge.inactive .dot {
            background: #ef5350;
        }

        .table-coupons .status-badge.expired .dot {
            background: #ffa726;
        }

        .action-group {
            display: flex;
            gap: 4px;
            justify-content: center;
            align-items: center;
        }

        .action-group .btn-action {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .action-group .btn-action.view {
            background: rgba(74, 158, 255, 0.1);
            color: #4a9eff;
        }

        .action-group .btn-action.view:hover {
            background: #4a9eff;
            color: #fff;
            transform: scale(1.1);
        }

        .action-group .btn-action.edit {
            background: rgba(255, 167, 38, 0.1);
            color: #ffa726;
        }

        .action-group .btn-action.edit:hover {
            background: #ffa726;
            color: #fff;
            transform: scale(1.1);
        }

        .action-group .btn-action.delete {
            background: rgba(239, 83, 80, 0.1);
            color: #ef5350;
        }

        .action-group .btn-action.delete:hover {
            background: #ef5350;
            color: #fff;
            transform: scale(1.1);
        }

        /* ============================================ */
        /* SEARCH & FILTER SECTION                    */
        /* ============================================ */
        .search-filter-section {
            background: var(--light-gray);
            border-radius: var(--radius);
            padding: 14px 16px;
            margin-bottom: 18px;
            border: 1px solid var(--border-color);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
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
            padding: 7px 12px 7px 36px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 13px;
            transition: all 0.3s;
            background: #fff;
            height: 36px;
        }

        .search-filter-section .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .search-filter-section .filter-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-filter-section .filter-group select {
            padding: 7px 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 13px;
            background: #fff;
            height: 36px;
            min-width: 130px;
            transition: all 0.3s;
            color: var(--dark);
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
        }

        .search-filter-section .filter-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .search-filter-section .filter-group .btn-reset {
            padding: 7px 16px;
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
            height: 36px;
        }

        .search-filter-section .filter-group .btn-reset:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 83, 80, 0.35);
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

        .empty-state a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .empty-state a:hover {
            text-decoration: underline;
        }

        /* ============================================ */
        /* MODAL STYLES                                */
        /* ============================================ */
        .modal-content {
            border-radius: var(--radius-lg);
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 14px 20px;
            background: linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 100%);
            color: #ffffff;
            border-bottom: none;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .modal-header .modal-title {
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header .modal-title i {
            color: #4a9eff;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.7;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 20px 24px;
        }

        .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border-color);
        }

        .detail-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 35%;
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-value {
            width: 65%;
            color: var(--dark);
            font-size: 13px;
        }

        .detail-value .status-badge-sm {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
        }

        .detail-value .status-badge-sm.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .detail-value .status-badge-sm.inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .detail-value .status-badge-sm.expired {
            background: #fef3c7;
            color: #92400e;
        }

        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h4 {
                font-size: 17px;
            }

            .search-filter-section {
                flex-direction: column;
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

            .table-coupons thead th {
                font-size: 10px;
                padding: 8px 10px;
            }

            .table-coupons tbody td {
                padding: 8px 10px;
                font-size: 11px;
            }

            .table-coupons .code-text {
                font-size: 12px;
            }

            .action-group .btn-action {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }

            .modal-body {
                padding: 14px 16px;
            }

            .detail-row {
                flex-direction: column;
                padding: 6px 0;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 2px;
            }

            .detail-value {
                width: 100%;
            }

            .pagination-wrapper {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 576px) {
            .page-header h4 {
                font-size: 15px;
            }

            .btn-add {
                font-size: 12px;
                padding: 6px 14px;
            }

            .table-coupons thead th {
                font-size: 9px;
                padding: 4px 6px;
            }

            .table-coupons tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-coupons .code-text {
                font-size: 10px;
                padding: 2px 8px;
            }

            .action-group .btn-action {
                width: 24px;
                height: 24px;
                font-size: 9px;
            }

            .table-coupons .status-badge {
                font-size: 9px;
                padding: 2px 8px;
            }

            .modal-body {
                padding: 10px 12px;
            }

            .detail-label {
                font-size: 10px;
            }

            .detail-value {
                font-size: 12px;
            }
        }
    </style>

    <div class="admin-main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h4><i class="fas fa-ticket-alt"></i> Coupons</h4>
            <a href="{{ route('admin.coupons.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Add New Coupon
            </a>
        </div>

        <!-- Card -->
        <div class="list-card">
            <div class="card-body">
                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by code, name..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="filter-group">
                        <select id="statusFilter" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="expired">Expired</option>
                        </select>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-coupons" id="couponTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min Order</th>
                                <th>Used / Limit</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th class="text-center" style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($coupons as $index => $coupon)
                                @php
                                    $validity = $coupon->isValid();
                                    $statusClass = $coupon->is_active ? 'active' : 'inactive';
                                    if (!$validity['valid'] && $coupon->is_active) {
                                        $statusClass = 'expired';
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center sno">{{ $loop->iteration }}</td>
                                    <td><span class="code-text">{{ $coupon->code }}</span></td>
                                    <td><span class="name-text">{{ $coupon->name ?? '-' }}</span></td>
                                    <td>
                                        <span
                                            class="type-badge {{ $coupon->type == 'percentage' ? 'percentage' : 'fixed' }}">
                                            <i
                                                class="fas {{ $coupon->type == 'percentage' ? 'fa-percent' : 'fa-rupee-sign' }}"></i>
                                            {{ ucfirst($coupon->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="value-text">
                                            @if ($coupon->type == 'percentage')
                                                {{ $coupon->value }}%
                                            @else
                                                ₹{{ number_format($coupon->value, 2) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="min-order">
                                            ₹{{ number_format($coupon->min_order_amount ?? 0, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="usage-text">
                                            <strong>{{ $coupon->used_count }}</strong> / {{ $coupon->usage_limit ?? '∞' }}
                                            <br><small class="text-muted">Per user:
                                                {{ $coupon->per_user_limit ?? 1 }}</small>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="validity-text">
                                            @if ($coupon->start_date || $coupon->end_date)
                                                @if ($coupon->start_date)
                                                    From: {{ $coupon->start_date->format('d M Y') }}<br>
                                                @endif
                                                @if ($coupon->end_date)
                                                    To: {{ $coupon->end_date->format('d M Y') }}
                                                @endif
                                            @else
                                                <span class="text-muted">Always</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            <span class="dot"></span>
                                            @if ($statusClass == 'active')
                                                Active
                                            @elseif($statusClass == 'expired')
                                                Expired
                                            @else
                                                Inactive
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <button type="button" class="btn-action view"
                                                onclick="viewCoupon('{{ $coupon->id }}')" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                                class="btn-action edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this coupon?')" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action delete" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fas fa-ticket-alt"></i>
                                            <h5>No Coupons Found</h5>
                                            <p><a href="{{ route('admin.coupons.create') }}">Create one now!</a></p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($coupons, 'links'))
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing <strong>{{ $coupons->firstItem() ?? 0 }}</strong> to
                            <strong>{{ $coupons->lastItem() ?? 0 }}</strong> of
                            <strong>{{ $coupons->total() ?? 0 }}</strong> entries
                        </div>
                        <div class="pagination-links">
                            {{ $coupons->links() }}
                        </div>
                    </div>
                @else
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing <strong>{{ $coupons->count() }}</strong> entries
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ===== VIEW COUPON MODAL ===== -->
    <div class="modal fade" id="viewCouponModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-ticket-alt"></i> Coupon Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="couponDetailsBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading coupon details...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s;">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============================================
        // VIEW COUPON DETAILS
        // ============================================
        function viewCoupon(id) {
            const modal = new bootstrap.Modal(document.getElementById('viewCouponModal'));
            const body = document.getElementById('couponDetailsBody');

            body.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading coupon details...</p>
        </div>
    `;

            modal.show();

            fetch(`/admin/coupons/${id}/view`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const coupon = data.coupon;

                        let statusBadge = '';
                        if (coupon.is_active) {
                            const now = new Date();
                            const endDate = coupon.end_date ? new Date(coupon.end_date) : null;
                            if (endDate && endDate < now) {
                                statusBadge = '<span class="status-badge-sm expired">Expired</span>';
                            } else {
                                statusBadge = '<span class="status-badge-sm active">Active</span>';
                            }
                        } else {
                            statusBadge = '<span class="status-badge-sm inactive">Inactive</span>';
                        }

                        const typeBadge = coupon.type === 'percentage' ?
                            '<span class="type-badge percentage"><i class="fas fa-percent"></i> Percentage</span>' :
                            '<span class="type-badge fixed"><i class="fas fa-rupee-sign"></i> Fixed</span>';

                        body.innerHTML = `
                <div class="detail-row">
                    <span class="detail-label">Coupon Code</span>
                    <span class="detail-value"><strong style="font-size:16px;">${coupon.code}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Coupon Name</span>
                    <span class="detail-value">${coupon.name || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Discount Type</span>
                    <span class="detail-value">${typeBadge}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Discount Value</span>
                    <span class="detail-value"><strong>${coupon.type === 'percentage' ? coupon.value + '%' : '₹' + parseFloat(coupon.value).toFixed(2)}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Min Order Amount</span>
                    <span class="detail-value">${parseFloat(coupon.min_order_amount || 0).toFixed(2) > 0 ? '₹' + parseFloat(coupon.min_order_amount).toFixed(2) : 'No minimum'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Usage</span>
                    <span class="detail-value">${coupon.used_count} used / ${coupon.usage_limit || '∞'} limit<br><small class="text-muted">Per user: ${coupon.per_user_limit || 1} time(s)</small></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Validity</span>
                    <span class="detail-value">
                        ${coupon.start_date ? 'From: ' + formatDate(coupon.start_date) + '<br>' : ''}
                        ${coupon.end_date ? 'To: ' + formatDate(coupon.end_date) : 'No expiry'}
                        ${!coupon.start_date && !coupon.end_date ? '<span class="text-muted">Always valid</span>' : ''}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">${statusBadge}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Created At</span>
                    <span class="detail-value">${formatDate(coupon.created_at)}</span>
                </div>
            `;
                    } else {
                        body.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <h5>${data.message || 'Failed to load coupon details'}</h5>
                    <p class="text-muted">Please try again</p>
                </div>
            `;
                    }
                })
                .catch(error => {
                    body.innerHTML = `
            <div class="text-center py-4 text-danger">
                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                <h5>Error loading coupon details</h5>
                <p class="text-muted">${error.message || 'Please try again'}</p>
            </div>
        `;
                });
        }

        function formatDate(dateString) {
            if (!dateString) return 'Not set';
            try {
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return 'Invalid date';
                return date.toLocaleDateString('en-IN', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch (e) {
                return 'Invalid date';
            }
        }

        // ============================================
        // SEARCH & FILTER TABLE
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var statusFilter = document.getElementById('statusFilter').value.toLowerCase();

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var status = row.querySelector('td:nth-child(9)')?.textContent.toLowerCase() || '';

                var matchesSearch = text.includes(searchValue);
                var matchesStatus = statusFilter === '' || status.includes(statusFilter);

                if (matchesSearch && matchesStatus) {
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
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No coupons found matching your filters.';
                tr.appendChild(td);
                tbody.appendChild(tr);
            }
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            filterTable();
        }
    </script>

@endsection
