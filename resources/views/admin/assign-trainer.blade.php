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

        .assign-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 100%;
            margin: 0 auto;
        }

        .assign-card .card-header {
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

        .assign-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .assign-card .card-header h4 i {
            color: #4a9eff;
        }

        .assign-card .card-body {
            padding: 20px 24px;
        }

        /* ============================================ */
        /* SELECTION CARDS                             */
        /* ============================================ */
        .selection-card {
            background: var(--light-gray);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 16px 18px;
            height: 100%;
            transition: all 0.3s;
        }

        .selection-card:hover {
            box-shadow: var(--shadow);
        }

        .selection-card .card-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .selection-card .card-title i {
            margin-right: 8px;
        }

        .selection-card .card-title.text-success i {
            color: #4caf50;
        }

        .selection-card .card-title.text-primary i {
            color: #4a9eff;
        }

        .selection-card select.form-select {
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 8px 12px;
            font-size: 13px;
            background: #ffffff;
            height: 38px;
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .selection-card select.form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.12);
            outline: none;
        }

        .selection-card .text-muted {
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        /* ============================================ */
        /* BULK ACTION BUTTONS                        */
        /* ============================================ */
        .bulk-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 8px;
        }

        .bulk-actions .btn-action-sm {
            padding: 6px 16px;
            border: none;
            border-radius: var(--radius);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .bulk-actions .btn-action-sm.btn-secondary {
            background: #e9ecef;
            color: var(--gray);
        }

        .bulk-actions .btn-action-sm.btn-secondary:hover {
            background: #dee2e6;
            transform: translateY(-2px);
        }

        .bulk-actions .btn-action-sm.btn-info {
            background: #e3f2fd;
            color: #1565c0;
        }

        .bulk-actions .btn-action-sm.btn-info:hover {
            background: #bbdefb;
            transform: translateY(-2px);
        }

        .bulk-actions .btn-action-sm.btn-success {
            background: #4caf50;
            color: #fff;
        }

        .bulk-actions .btn-action-sm.btn-success:hover {
            background: #388e3c;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.35);
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
        /* TABLE STYLES                                */
        /* ============================================ */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .table-assign {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-assign thead {
            background: var(--light-gray);
        }

        .table-assign thead th {
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

        .table-assign thead th.text-center {
            text-align: center;
        }

        .table-assign tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-assign tbody tr:hover {
            background: #f8f9fa;
        }

        .table-assign tbody tr:last-child td {
            border-bottom: none;
        }

        .table-assign .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-assign .member-name {
            font-weight: 600;
            color: var(--dark);
        }

        .table-assign .member-email {
            display: block;
            font-size: 11px;
            color: var(--gray);
        }

        .table-assign .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-assign .status-badge.not-assigned {
            background: #fef3c7;
            color: #92400e;
        }

        .table-assign .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-assign .status-badge.not-assigned .dot {
            background: #ffa726;
        }

        /* ============================================ */
        /* CHECKBOX STYLES                             */
        /* ============================================ */
        .checkbox-custom {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-custom:checked {
            accent-color: var(--primary);
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

        .empty-state .btn-primary {
            background: var(--primary);
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

        .empty-state .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 158, 255, 0.35);
        }

        /* ============================================ */
        /* RESPONSIVE                                  */
        /* ============================================ */
        @media (max-width: 992px) {
            .selection-card {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 768px) {
            .admin-main-content {
                padding: 12px 15px;
            }

            .assign-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .assign-card .card-header h4 {
                font-size: 16px;
            }

            .assign-card .card-body {
                padding: 14px 16px;
            }

            .bulk-actions {
                flex-direction: column;
                width: 100%;
            }

            .bulk-actions .btn-action-sm {
                width: 100%;
                justify-content: center;
            }

            .table-assign thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-assign tbody td {
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
            .assign-card .card-header h4 {
                font-size: 14px;
            }

            .assign-card .card-body {
                padding: 10px 12px;
            }

            .table-assign tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-assign thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .selection-card {
                padding: 12px 14px;
            }

            .selection-card .card-title {
                font-size: 12px;
            }

            .selection-card select.form-select {
                font-size: 12px;
                height: 34px;
            }

            .checkbox-custom {
                width: 14px;
                height: 14px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="assign-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-user-tag"></i> Assign Trainer to Members</h4>
                    <small style="opacity:0.8;">Assign trainers to unassigned members</small>
                </div>
                <a href="{{ route('admin.assign.trainer.list') }}" class="btn btn-primary"
                    style="background:#4a9eff; color:#fff; border:none; padding:7px 18px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:12px; transition:all 0.3s;">
                    <i class="fas fa-list"></i> Assigned Members
                </a>
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

                <!-- ============================================ -->
                <!-- BULK ASSIGN FORM                            -->
                <!-- ============================================ -->
                <form action="{{ route('admin.assign.trainer.bulk') }}" method="POST" id="assignForm">
                    @csrf

                    <div class="row mb-4">
                        <!-- Select Trainer -->
                        <div class="col-md-4">
                            <div class="selection-card">
                                <h5 class="card-title text-success">
                                    <i class="fas fa-user-check"></i> Select Trainer
                                </h5>
                                <select name="trainer_id" id="bulk_trainer_id" class="form-select" required>
                                    <option value="">-- Select Trainer --</option>
                                    @foreach ($trainers as $trainer)
                                        <option value="{{ $trainer->id }}">
                                            {{ $trainer->name }} ({{ $trainer->specialization }}) -
                                            {{ $trainer->assigned_members ?? 0 }} members
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted"><i class="fas fa-info-circle"></i> Select a trainer to assign to
                                    selected members</small>
                            </div>
                        </div>

                        <!-- Select All / Actions -->
                        <div class="col-md-8">
                            <div class="selection-card">
                                <h5 class="card-title text-primary">
                                    <i class="fas fa-users"></i> Bulk Actions
                                </h5>
                                <div class="bulk-actions">
                                    <button type="button" class="btn-action-sm btn-secondary" onclick="selectAll()">
                                        <i class="fas fa-check-double"></i> Select All
                                    </button>
                                    <button type="button" class="btn-action-sm btn-secondary" onclick="deselectAll()">
                                        <i class="fas fa-times"></i> Deselect All
                                    </button>
                                    <button type="button" class="btn-action-sm btn-info" onclick="selectUnassigned()">
                                        <i class="fas fa-user-slash"></i> Select Unassigned
                                    </button>
                                    <button type="submit" class="btn-action-sm btn-success"
                                        onclick="return confirmAssign()">
                                        <i class="fas fa-user-plus"></i> Assign Selected
                                    </button>
                                </div>
                                <small class="text-muted" style="margin-top:6px; display:block;">
                                    <i class="fas fa-info-circle"></i> Select members below and assign them to the selected
                                    trainer
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- SEARCH & FILTER                             -->
                    <!-- ============================================ -->
                    <div class="search-filter-section"
                        style="background:var(--light-gray); border-radius:var(--radius); padding:12px 16px; margin-bottom:16px; border:1px solid var(--border-color); display:flex; flex-wrap:wrap; align-items:center; gap:10px;">
                        <div class="search-box" style="flex:1; min-width:200px; position:relative;">
                            <i class="fas fa-search"
                                style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--gray); font-size:14px;"></i>
                            <input type="text" id="searchInput" placeholder="Search by name, email, phone..."
                                onkeyup="filterTable()"
                                style="width:100%; padding:7px 12px 7px 36px; border:1px solid var(--border-color); border-radius:var(--radius); font-size:13px; background:#fff; height:36px;">
                        </div>
                        <div class="filter-group" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                            <select id="statusFilter" onchange="filterTable()"
                                style="padding:7px 12px; border:1px solid var(--border-color); border-radius:var(--radius); font-size:13px; background:#fff; height:36px; min-width:120px; appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 12 12%22%3E%3Cpath fill=%22%236c757d%22 d=%22M6 8L1 3h10z%22/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 10px center; padding-right:30px;">
                                <option value="">All Status</option>
                                <option value="not assigned">Not Assigned</option>
                            </select>
                            <button class="btn-reset" onclick="resetFilters()"
                                style="padding:7px 16px; background:#ef5350; color:#fff; border:none; border-radius:var(--radius); font-size:13px; font-weight:500; cursor:pointer; transition:all 0.3s; display:inline-flex; align-items:center; gap:6px; height:36px;">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- TABLE                                       -->
                    <!-- ============================================ -->
                    <div class="table-responsive">
                        <table class="table-assign" id="assignTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:50px;">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleAllCheckboxes()"
                                            class="checkbox-custom">
                                    </th>
                                    <th class="text-center" style="width:50px;">#</th>
                                    <th>Member Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @forelse($members as $index => $member)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                                class="member-checkbox checkbox-custom">
                                        </td>
                                        <td class="text-center sno">{{ $members->firstItem() + $index }}</td>
                                        <td>
                                            <span class="member-name">{{ $member->name }}</span>
                                        </td>
                                        <td>
                                            <span class="member-email">{{ $member->email }}</span>
                                        </td>
                                        <td>{{ $member->phone }}</td>
                                        <td>
                                            <span class="status-badge not-assigned">
                                                <span class="dot"></span> Not Assigned
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-check-circle fa-3x" style="color:#4caf50;"></i>
                                                <h5 style="color:#2e7d32;">All Members Are Assigned!</h5>
                                                <p>No unassigned members found.</p>
                                                <a href="{{ route('admin.assign.trainer.list') }}" class="btn-primary">
                                                    <i class="fas fa-list"></i> View Assigned Members
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </form>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <strong>{{ $members->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $members->lastItem() ?? 0 }}</strong> of <strong>{{ $members->total() ?? 0 }}</strong>
                        unassigned members
                    </div>
                    <div class="pagination-links">
                        {{ $members->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SCRIPTS                                    -->
    <!-- ============================================ -->
    <script>
        // ============================================
        // SELECT ALL FUNCTIONS
        // ============================================
        function selectAll() {
            document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
                checkbox.checked = true;
            });
            document.getElementById('selectAllCheckbox').checked = true;
        }

        function deselectAll() {
            document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
                checkbox.checked = false;
            });
            document.getElementById('selectAllCheckbox').checked = false;
        }

        function selectUnassigned() {
            document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
                checkbox.checked = true;
            });
            document.getElementById('selectAllCheckbox').checked = true;
        }

        function toggleAllCheckboxes() {
            const isChecked = document.getElementById('selectAllCheckbox').checked;
            document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        }

        // ============================================
        // CONFIRM ASSIGN
        // ============================================
        function confirmAssign() {
            var checked = document.querySelectorAll('.member-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one member to assign.');
                return false;
            }
            var trainer = document.getElementById('bulk_trainer_id').value;
            if (!trainer) {
                alert('Please select a trainer first.');
                return false;
            }
            return confirm('Are you sure you want to assign ' + checked.length + ' member(s) to this trainer?');
        }

        // ============================================
        // SEARCH & FILTER
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var statusFilter = document.getElementById('statusFilter').value.toLowerCase();

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var status = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase() || '';

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
                td.colSpan = 6;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No members found matching your filters.';
                tr.appendChild(td);
                tbody.appendChild(tr);
            }
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            filterTable();
        }

        // ============================================
        // CUSTOM ALERT - AUTO HIDE
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

            // Update Select All checkbox when individual checkboxes change
            document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll('.member-checkbox');
                    const checkedCheckboxes = document.querySelectorAll('.member-checkbox:checked');
                    document.getElementById('selectAllCheckbox').checked =
                        allCheckboxes.length === checkedCheckboxes.length;
                });
            });
        });
    </script>
@endsection
