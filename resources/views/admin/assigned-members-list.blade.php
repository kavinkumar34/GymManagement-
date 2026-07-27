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

        .table-assigned {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin: 0;
        }

        .table-assigned thead {
            background: var(--light-gray);
        }

        .table-assigned thead th {
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

        .table-assigned thead th.text-center {
            text-align: center;
        }

        .table-assigned tbody td {
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-assigned tbody tr:hover {
            background: #f8f9fa;
        }

        .table-assigned tbody tr:last-child td {
            border-bottom: none;
        }

        .table-assigned .sno {
            font-weight: 600;
            color: var(--gray);
            font-size: 12px;
            text-align: center;
            width: 40px;
        }

        .table-assigned .trainer-name {
            font-weight: 600;
            color: #2e7d32;
            font-size: 14px;
        }

        .table-assigned .trainer-email {
            font-size: 12px;
            color: var(--gray);
            display: block;
        }

        .table-assigned .member-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            background: #e3f2fd;
            color: #1565c0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin: 2px 4px;
        }

        .table-assigned .member-badge i {
            font-size: 10px;
        }

        .table-assigned .total-members {
            font-size: 12px;
            color: var(--gray);
            display: block;
            margin-top: 4px;
        }

        .table-assigned .btn-action {
            padding: 6px 14px;
            border: none;
            border-radius: var(--radius);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            background: #e3f2fd;
            color: #1565c0;
        }

        .table-assigned .btn-action:hover {
            background: #bbdefb;
            transform: translateY(-2px);
        }

        /* ============================================ */
        /* MODAL STYLES                                */
        /* ============================================ */
        .modal-content {
            border-radius: var(--radius-lg);
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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
            padding: 18px 20px;
        }

        .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border-color);
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
            padding: 8px 12px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--gray);
            border-bottom: 2px solid var(--border-color);
        }

        .modal-table tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .modal-table tbody tr:hover {
            background: #f8f9fa;
        }

        .modal-table .member-name {
            font-weight: 600;
            color: var(--dark);
        }

        .modal-table .goal-badge {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            background: #fce7f3;
            color: #db2777;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .modal-table .plan-badge {
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .modal-table .plan-badge.membership {
            background: #dcfce7;
            color: #15803d;
        }

        .modal-table .plan-badge.package {
            background: #fef3c7;
            color: #92400e;
        }

        .modal-table .plan-badge.none {
            background: #f5f5f5;
            color: #9e9e9e;
        }

        .modal-total {
            font-weight: 600;
            color: var(--dark);
            padding: 10px 0 0 0;
            border-top: 1px solid var(--border-color);
            margin-top: 10px;
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

            .search-filter-section .filter-group .btn-reset {
                width: 100%;
                justify-content: center;
            }

            .table-assigned thead th {
                font-size: 10px;
                padding: 6px 8px;
            }

            .table-assigned tbody td {
                padding: 6px 8px;
                font-size: 11px;
            }

            .table-assigned .member-badge {
                font-size: 10px;
                padding: 2px 8px;
            }

            .modal-body {
                padding: 12px 14px;
            }

            .modal-table {
                font-size: 12px;
            }

            .modal-table thead th,
            .modal-table tbody td {
                padding: 6px 8px;
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

            .search-filter-section .filter-group .btn-reset {
                font-size: 12px;
                height: 34px;
            }

            .table-assigned tbody td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .table-assigned thead th {
                padding: 4px 6px;
                font-size: 9px;
            }

            .table-assigned .trainer-name {
                font-size: 12px;
            }

            .table-assigned .member-badge {
                font-size: 9px;
                padding: 2px 6px;
            }

            .modal-body {
                padding: 10px 12px;
            }

            .modal-table {
                font-size: 11px;
            }

            .modal-table thead th,
            .modal-table tbody td {
                padding: 4px 6px;
            }
        }
    </style>

    <div class="admin-main-content">
        <div class="list-card">
            <!-- Card Header -->
            <div class="card-header">
                <div>
                    <h4><i class="fas fa-users"></i> Assigned Members List</h4>
                    <small style="opacity:0.8;">View all members assigned to trainers</small>
                </div>
                <a href="{{ route('admin.assign.trainer.index') }}" class="btn btn-primary"
                    style="background:#4a9eff; color:#fff; border:none; padding:7px 18px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:12px; transition:all 0.3s;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
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
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-assigned" id="assignedTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>Trainer Name</th>
                                <th>Trainer Email</th>
                                <th>Trainer Phone</th>
                                <th>Assigned Members</th>
                                <th class="text-center" style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @php
                                $groupedMembers = $members->groupBy('trainer_id');
                            @endphp

                            @forelse($groupedMembers as $trainerId => $memberList)
                                @php
                                    $trainer = $memberList->first()->trainer;
                                @endphp
                                <tr>
                                    <td class="text-center sno">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="trainer-name"><i class="fas fa-user-check"></i>
                                            {{ $trainer->name ?? 'N/A' }}</span>
                                        <span class="trainer-email">{{ $trainer->specialization ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $trainer->email ?? 'N/A' }}</td>
                                    <td>{{ $trainer->phone ?? 'N/A' }}</td>
                                    <td>
                                        @foreach ($memberList as $member)
                                            <span class="member-badge">
                                                <i class="fas fa-user"></i> {{ $member->name }}
                                            </span>
                                        @endforeach
                                        <span class="total-members">
                                            <i class="fas fa-users"></i> Total: <strong>{{ $memberList->count() }}</strong>
                                            members
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn-action" data-bs-toggle="modal"
                                            data-bs-target="#viewMembersModal{{ $trainerId }}">
                                            <i class="fas fa-eye"></i> View Members
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-users-slash"></i>
                                            <h5>No Members Assigned to Trainers</h5>
                                            <p>Assign trainers to members from the main page.</p>
                                            <a href="{{ route('admin.assign.trainer.index') }}" class="btn-primary">
                                                <i class="fas fa-user-tag"></i> Assign Now
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $members->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- VIEW MEMBERS MODAL                          -->
    <!-- ============================================ -->
    @foreach ($groupedMembers as $trainerId => $memberList)
        @php
            $trainer = $memberList->first()->trainer;
        @endphp
        <div class="modal fade" id="viewMembersModal{{ $trainerId }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-users"></i> Members of {{ $trainer->name ?? 'N/A' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="modal-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Goal Type</th>
                                        <th>Plan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($memberList as $key => $member)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><span class="member-name">{{ $member->name }}</span></td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td>
                                                <span class="goal-badge">
                                                    <i class="fas fa-bullseye"></i> {{ $member->goal_type ?? 'Fitness' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($member->plan_type == 'membership')
                                                    <span class="plan-badge membership">
                                                        <i class="fas fa-id-card"></i> Membership
                                                    </span>
                                                @elseif($member->plan_type == 'package')
                                                    <span class="plan-badge package">
                                                        <i class="fas fa-box"></i> Package
                                                    </span>
                                                @else
                                                    <span class="plan-badge none">N/A</span>
                                                @endif
                                                <br>
                                                <small style="color: #64748b; font-size: 10px;">
                                                    {{ $member->membership_plan ?? 'Basic' }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-total">
                            <i class="fas fa-users"></i> Total Members: <strong>{{ $memberList->count() }}</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="background:#f0f4f8; color:var(--gray); border:1px solid var(--border-color); padding:7px 20px; border-radius:var(--radius); font-weight:500; font-size:13px; transition:all 0.3s;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- ============================================ -->
    <!-- SCRIPTS                                    -->
    <!-- ============================================ -->
    <script>
        // ============================================
        // SEARCH & FILTER TABLE
        // ============================================
        function filterTable() {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();

            var rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                var matchesSearch = text.includes(searchValue);

                if (matchesSearch) {
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
                td.colSpan = 6;
                td.style.textAlign = 'center';
                td.style.padding = '30px';
                td.style.color = '#6c757d';
                td.innerHTML =
                    '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No trainers found matching your search.';
                tr.appendChild(td);
                tbody.appendChild(tr);
            }
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            document.getElementById('searchInput').value = '';
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
