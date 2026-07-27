@extends('layouts.admin-layout')

@section('content')
    <style>
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

        .list-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 100%;
            margin: 0 auto;
        }

        .list-card .card-header {
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

        .list-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .list-card .card-header h4 i {
            color: #4a9eff;
        }

        .list-card .card-body {
            padding: 20px 24px;
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

        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .table-package {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-package thead {
            background: var(--light-gray);
        }

        .table-package thead th {
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

        .table-package thead th.text-center {
            text-align: center;
        }

        .table-package tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-package tbody tr:hover {
            background: #f8f9fa;
        }

        .table-package tbody tr:last-child td {
            border-bottom: none;
        }

        .table-package .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-package .package-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .table-package .package-name {
            font-weight: 600;
            color: var(--dark);
        }

        .table-package .package-desc {
            font-size: 11px;
            color: var(--gray);
            display: block;
        }

        .table-package .price-amount {
            font-weight: 600;
            color: var(--dark);
        }

        .table-package .duration-badge {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            background: #e3f2fd;
            color: #1565c0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .table-package .features-badge {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            background: #f3e5f5;
            color: #6a1b9a;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .table-package .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-package .status-badge.active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-package .status-badge.inactive {
            background: #fce4ec;
            color: #c62828;
        }

        .table-package .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-package .status-badge.active .dot {
            background: #4caf50;
        }

        .table-package .status-badge.inactive .dot {
            background: #ef5350;
        }

        .action-btns {
            display: flex;
            gap: 4px;
            justify-content: center;
            align-items: center;
        }

        .action-btns .btn-action {
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

        .delete-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(2px);
            z-index: 9999;
            align-items: flex-start;
            justify-content: flex-end;
            padding: 25px 30px;
            animation: fadeIn 0.25s ease;
        }

        .delete-modal-overlay.active {
            display: flex;
        }

        .delete-modal {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 16px 20px 18px;
            max-width: 280px;
            width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: slideDownModal 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        @keyframes slideDownModal {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .delete-modal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .delete-modal .modal-header h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .delete-modal .modal-header h4 i {
            color: #ef5350;
            font-size: 14px;
        }

        .delete-modal .modal-close {
            background: none;
            border: none;
            font-size: 16px;
            color: var(--gray);
            cursor: pointer;
            padding: 0 4px;
            transition: all 0.3s;
            line-height: 1;
        }

        .delete-modal .modal-close:hover {
            color: var(--dark);
            transform: rotate(90deg);
        }

        .delete-modal .modal-body {
            font-size: 12px;
            color: var(--gray);
            line-height: 1.5;
            margin-bottom: 12px;
            padding-left: 2px;
        }

        .delete-modal .modal-body .warning-text {
            color: #ef5350;
            font-weight: 500;
            font-size: 11px;
            display: block;
            margin-top: 2px;
        }

        .delete-modal .modal-body .warning-text i {
            font-size: 10px;
            margin-right: 3px;
        }

        .delete-modal .modal-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        .delete-modal .modal-actions .btn-modal {
            padding: 5px 14px;
            border: none;
            border-radius: var(--radius);
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .delete-modal .modal-actions .btn-modal.cancel {
            background: #f0f4f8;
            color: var(--gray);
        }

        .delete-modal .modal-actions .btn-modal.cancel:hover {
            background: #e9ecef;
        }

        .delete-modal .modal-actions .btn-modal.confirm {
            background: #ef5350;
            color: #fff;
        }

        .delete-modal .modal-actions .btn-modal.confirm:hover {
            background: #c62828;
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(239, 83, 80, 0.3);
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

        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .list-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .list-card .card-header h4 {
                font-size: 16px;
            }

            .list-card .card-body {
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

            .action-btns {
                gap: 3px;
            }

            .action-btns .btn-action {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }

            .table-package thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-package tbody td {
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

            .delete-modal-overlay {
                padding: 16px;
                align-items: flex-start;
            }

            .delete-modal {
                max-width: 260px;
                padding: 14px 16px 16px;
            }

            .delete-modal .modal-header h4 {
                font-size: 13px;
            }

            .delete-modal .modal-body {
                font-size: 11px;
            }

            .delete-modal .modal-actions .btn-modal {
                padding: 4px 12px;
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .list-card .card-header h4 {
                font-size: 14px;
            }

            .list-card .card-body {
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

            .table-package tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-package thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .action-btns .btn-action {
                width: 24px;
                height: 24px;
                font-size: 9px;
            }

            .delete-modal-overlay {
                padding: 12px;
            }

            .delete-modal {
                max-width: 240px;
                padding: 12px 14px 14px;
            }

            .delete-modal .modal-header h4 {
                font-size: 12px;
            }

            .delete-modal .modal-body {
                font-size: 10px;
                margin-bottom: 10px;
            }

            .delete-modal .modal-actions .btn-modal {
                padding: 4px 10px;
                font-size: 10px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="list-card">
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-box"></i> Packages List</h4>
                    <small style="opacity:0.8;">Manage all packages</small>
                </div>
                <a href="{{ route('admin.package.create') }}" class="btn btn-primary"
                    style="background:#4a9eff; color:#fff; border:none; padding:8px 20px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:13px; transition:all 0.3s;">
                    <i class="fas fa-plus"></i> Add Package
                </a>
            </div>

            <div class="card-body">
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

                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by package name..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="filter-group">
                        <select id="statusFilter" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table-package" id="packageTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th style="width:60px;">Image</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Features</th>
                                <th>Status</th>
                                <th class="text-center" style="width:100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($packages as $index => $package)
                                <tr>
                                    <td class="text-center sno">{{ $packages->firstItem() + $index }}</td>
                                    <td>
                                        @if ($package->image)
                                            <img src="{{ asset('storage/' . $package->image) }}" class="package-image"
                                                alt="{{ $package->package_name }}">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" class="package-image"
                                                alt="No Image">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="package-name">{{ $package->package_name }}</span>
                                        @if ($package->description)
                                            <span class="package-desc">{{ Str::limit($package->description, 60) }}</span>
                                        @endif
                                    </td>
                                    <td><span class="price-amount">₹ {{ number_format($package->price, 2) }}</span></td>
                                    <td><span class="duration-badge"><i class="fas fa-clock"></i> {{ $package->duration }}
                                            {{ $package->duration_type }}</span></td>
                                    <td>
                                        @php
                                            $features = $package->included_features
                                                ? explode("\n", $package->included_features)
                                                : [];
                                            $features = array_filter(array_map('trim', $features));
                                        @endphp
                                        @if (count($features) > 0)
                                            <span class="features-badge"><i class="fas fa-list"></i>
                                                {{ count($features) }}</span>
                                            <small class="text-muted d-block"
                                                style="font-size:10px;">{{ Str::limit(implode(', ', $features), 40) }}</small>
                                        @else
                                            <span class="text-muted" style="font-size:11px;">No features</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($package->status == 'Active')
                                            <span class="status-badge active">
                                                <span class="dot"></span> Active
                                            </span>
                                        @else
                                            <span class="status-badge inactive">
                                                <span class="dot"></span> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="{{ route('admin.package.edit', $package->id) }}"
                                                class="btn-action edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn-action delete"
                                                onclick="openDeleteModal({{ $package->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-box"></i>
                                            <h5>No Packages Found</h5>
                                            <p>Click "Add Package" to create a new package.</p>
                                            <a href="{{ route('admin.package.create') }}" class="btn btn-primary"
                                                style="background:#4a9eff; color:#fff; border:none; padding:8px 20px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:13px;">
                                                <i class="fas fa-plus"></i> Add Package
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <strong>{{ $packages->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $packages->lastItem() ?? 0 }}</strong> of
                        <strong>{{ $packages->total() ?? 0 }}</strong> entries
                    </div>
                    <div class="pagination-links">
                        {{ $packages->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Custom Delete Modal -->
    <div class="delete-modal-overlay" id="deleteModal">
        <div class="delete-modal">
            <div class="modal-header">
                <h4><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this package?
                <span class="warning-text"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone.</span>
            </div>
            <div class="modal-actions">
                <button class="btn-modal cancel" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn-modal confirm" id="confirmDeleteBtn">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        var deleteId = null;

        function openDeleteModal(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
            deleteId = null;
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteId) {
                let form = document.getElementById('delete-form');
                form.action = '/admin/packages/' + deleteId;
                form.submit();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var statusFilter = document.getElementById('statusFilter').value.toLowerCase();

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var status = row.querySelector('td:nth-child(7)')?.textContent.toLowerCase() || '';

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
                td.colSpan = 8;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No packages found matching your filters.';
                tr.appendChild(td);
                tbody.appendChild(tr);
            }
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            filterTable();
        }

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
