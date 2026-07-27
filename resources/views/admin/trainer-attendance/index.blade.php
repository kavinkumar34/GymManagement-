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
        .attendance-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            max-width: 100%;
            margin: 0 auto;
        }

        .attendance-card .card-header {
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

        .attendance-card .card-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .attendance-card .card-header h4 i {
            color: #4a9eff;
        }

        .attendance-card .card-header small {
            font-size: 12px;
            opacity: 0.8;
            font-weight: 400;
        }

        .attendance-card .card-body {
            padding: 20px 24px;
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
            min-width: 120px;
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

        .search-filter-section .filter-group input[type="date"] {
            padding: 7px 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 13px;
            background: #fff;
            height: 36px;
            min-width: 130px;
            transition: all 0.3s;
            color: var(--dark);
        }

        .search-filter-section .filter-group input[type="date"]:focus {
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

        /* ============================================ */
        /* TABLE STYLES                                */
        /* ============================================ */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .table-attendance {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-attendance thead {
            background: var(--light-gray);
        }

        .table-attendance thead th {
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

        .table-attendance thead th.text-center {
            text-align: center;
        }

        .table-attendance tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-attendance tbody tr:hover {
            background: #f8f9fa;
        }

        .table-attendance tbody tr:last-child td {
            border-bottom: none;
        }

        .table-attendance .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-attendance .trainer-name {
            font-weight: 600;
            color: var(--dark);
        }

        .table-attendance .trainer-email {
            font-size: 11px;
            color: var(--gray);
            display: block;
        }

        .table-attendance .date-badge {
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

        .table-attendance .status-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-attendance .status-badge.present {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .table-attendance .status-badge.absent {
            background: #fce4ec;
            color: #c62828;
        }

        .table-attendance .status-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-attendance .status-badge.present .dot {
            background: #4caf50;
        }

        .table-attendance .status-badge.absent .dot {
            background: #ef5350;
        }

        .table-attendance .check-time {
            font-weight: 500;
            color: var(--dark);
            font-family: monospace;
        }

        .table-attendance .check-time i {
            color: var(--gray);
            font-size: 11px;
        }

        .table-attendance .remarks-text {
            font-size: 12px;
            color: var(--gray);
            max-width: 150px;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

            .attendance-card .card-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: flex-start;
            }

            .attendance-card .card-header h4 {
                font-size: 16px;
            }

            .attendance-card .card-body {
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

            .search-filter-section .filter-group select,
            .search-filter-section .filter-group input[type="date"] {
                width: 100%;
            }

            .search-filter-section .filter-group .btn-reset {
                width: 100%;
                justify-content: center;
            }

            .table-attendance thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-attendance tbody td {
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
            .attendance-card .card-header h4 {
                font-size: 14px;
            }

            .attendance-card .card-body {
                padding: 10px 12px;
            }

            .search-filter-section .search-box input {
                font-size: 12px;
                height: 34px;
            }

            .search-filter-section .filter-group select,
            .search-filter-section .filter-group input[type="date"] {
                font-size: 12px;
                height: 34px;
            }

            .search-filter-section .filter-group .btn-reset {
                font-size: 12px;
                height: 34px;
            }

            .table-attendance tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-attendance thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .table-attendance .trainer-name {
                font-size: 12px;
            }

            .table-attendance .status-badge {
                font-size: 9px;
                padding: 2px 10px;
            }

            .table-attendance .date-badge {
                font-size: 9px;
                padding: 2px 8px;
            }

            .table-attendance .check-time {
                font-size: 11px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="attendance-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-clipboard-check"></i> Trainer Attendance</h4>
                    <small style="opacity:0.8;">Manage trainer attendance records</small>
                </div>
                <span
                    style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('d M Y') }}
                </span>
            </div>

            <!-- Card Body -->
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

                <!-- Search & Filter -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search by trainer name, email..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="filter-group">
                        <select id="statusFilter" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                        <input type="date" id="dateFilter" onchange="filterTable()" title="Filter by date">
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-attendance" id="attendanceTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>Trainer</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($attendance as $index => $row)
                                <tr>
                                    <td class="text-center sno">{{ $attendance->firstItem() + $index }}</td>
                                    <td>
                                        <span class="trainer-name">{{ $row->trainer->name ?? '-' }}</span>
                                        <span class="trainer-email">{{ $row->trainer->email ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="date-badge">
                                            <i class="fas fa-calendar"></i>
                                            {{ date('d-m-Y', strtotime($row->attendance_date)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($row->status == 'Present')
                                            <span class="status-badge present">
                                                <span class="dot"></span> Present
                                            </span>
                                        @else
                                            <span class="status-badge absent">
                                                <span class="dot"></span> Absent
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->check_in)
                                            <span class="check-time"><i class="fas fa-clock"></i>
                                                {{ date('h:i A', strtotime($row->check_in)) }}</span>
                                        @else
                                            <span class="text-muted" style="font-size:11px;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->check_out)
                                            <span class="check-time"><i class="fas fa-clock"></i>
                                                {{ date('h:i A', strtotime($row->check_out)) }}</span>
                                        @else
                                            <span class="text-muted" style="font-size:11px;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->remarks)
                                            <span class="remarks-text" title="{{ $row->remarks }}">
                                                <i class="fas fa-comment"></i> {{ Str::limit($row->remarks, 30) }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size:11px;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-clipboard-check"></i>
                                            <h5>No Attendance Records Found</h5>
                                            <p>No trainer attendance records available.</p>
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
                        Showing <strong>{{ $attendance->firstItem() ?? 0 }}</strong> to
                        <strong>{{ $attendance->lastItem() ?? 0 }}</strong> of
                        <strong>{{ $attendance->total() ?? 0 }}</strong> entries
                    </div>
                    <div class="pagination-links">
                        {{ $attendance->links() }}
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
        // SEARCH & FILTER TABLE
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            var dateFilter = document.getElementById('dateFilter').value;

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var status = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
                var date = row.querySelector('td:nth-child(3)')?.textContent.trim() || '';

                // Convert date format for comparison (dd-mm-yyyy to yyyy-mm-dd)
                var dateFormatted = '';
                if (date) {
                    var parts = date.split('-');
                    if (parts.length === 3) {
                        dateFormatted = parts[2] + '-' + parts[1] + '-' + parts[0];
                    }
                }

                var matchesSearch = text.includes(searchValue);
                var matchesStatus = statusFilter === '' || status.includes(statusFilter);
                var matchesDate = dateFilter === '' || dateFormatted === dateFilter;

                if (matchesSearch && matchesStatus && matchesDate) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
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
                var tbody = document.getElementById('tableBody');
                var tr = document.createElement('tr');
                tr.id = 'noResultRow';
                var td = document.createElement('td');
                td.colSpan = 7;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No attendance records found matching your filters.';
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
            document.getElementById('dateFilter').value = '';
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
