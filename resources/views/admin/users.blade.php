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
        --shadow: 0 2px 20px rgba(0,0,0,0.05);
        --radius: 10px;
        --radius-lg: 16px;
    }

    /* ============================================ */
    /* MAIN CONTENT                                */
    /* ============================================ */
    .admin-main-content {
        padding: 20px 25px !important;
        background: #f0f4f8;
        min-height: 100vh;
        margin-left: 270px !important;
        width: auto !important;
        max-width: calc(100% - 270px) !important;
        box-sizing: border-box;
    }

    /* ============================================ */
    /* CARD STYLES                                 */
    /* ============================================ */
    .list-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.04);
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

    .list-card .card-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    .list-card .card-body {
        padding: 20px 24px;
    }

    /* ============================================ */
    /* HEADER ACTIONS - EXPORT BUTTON              */
    /* ============================================ */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
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
    }
    
    .export-btn:hover {
        background: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
        color: white;
    }
    
    .export-btn i {
        font-size: 14px;
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
    /* TABLE STYLES                                */
    /* ============================================ */
    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-users {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
    }

    .table-users thead {
        background: var(--light-gray);
    }

    .table-users thead th {
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

    .table-users thead th.text-center {
        text-align: center;
    }

    .table-users tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-users tbody tr:hover {
        background: #f8f9fa;
    }

    .table-users tbody tr:last-child td {
        border-bottom: none;
    }

    .table-users .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .table-users .user-name {
        font-weight: 600;
        color: var(--dark);
    }

    .table-users .user-email {
        font-size: 12px;
        color: var(--gray);
        display: block;
    }

    .table-users .user-phone {
        font-size: 13px;
        color: var(--dark);
    }

    .table-users .verified-badge {
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .table-users .verified-badge.yes {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .table-users .verified-badge.no {
        background: #fce4ec;
        color: #c62828;
    }

    .table-users .verified-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .table-users .verified-badge.yes .dot {
        background: #4caf50;
    }

    .table-users .verified-badge.no .dot {
        background: #ef5350;
    }

    .table-users .created-date {
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
    @media (max-width: 992px) {
        .admin-main-content {
            margin-left: 70px !important;
            max-width: calc(100% - 70px) !important;
            padding: 15px 18px !important;
        }
    }

    @media (max-width: 768px) {
        .admin-main-content {
            margin-left: 0 !important;
            max-width: 100% !important;
            padding: 12px 15px !important;
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

        .table-users thead th {
            font-size: 10px;
            padding: 6px 8px;
        }

        .table-users tbody td {
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

        .table-users tbody td {
            padding: 4px 6px;
            font-size: 10px;
        }

        .table-users thead th {
            padding: 4px 6px;
            font-size: 9px;
        }

        .table-users .sno {
            width: 30px;
            font-size: 9px;
        }

        .table-users .verified-badge {
            font-size: 9px;
            padding: 2px 8px;
        }

        .table-users .created-date {
            font-size: 10px;
        }
    }
</style>

<!-- ============================================ -->
<!-- MAIN CONTENT                                -->
<!-- ============================================ -->
<div class="admin-main-content">
    <div class="list-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-users"></i> Users List</h4>
                <small style="opacity:0.8;">Manage all registered users</small>
            </div>
            
            <!-- ===== HEADER ACTIONS WITH EXPORT BUTTON ===== -->
            <div class="header-actions">
                <span style="background:rgba(74,158,255,0.2); color:#8ab4f8; padding:3px 12px; border-radius:50px; font-size:11px;">
                    <i class="fas fa-user"></i> Total: {{ $users->count() }}
                </span>
                
                <!-- ===== EXPORT BUTTON ===== -->
                <a href="{{ route('admin.users.export', request()->query()) }}" class="export-btn">
                    <i class="fas fa-file-excel"></i> Export to CSV
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Search & Filter -->
            <div class="search-filter-section">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by name, email, phone..." onkeyup="filterTable()">
                </div>
                <div class="filter-group">
                    <select id="verifiedFilter" onchange="filterTable()">
                        <option value="">All Status</option>
                        <option value="yes">Verified</option>
                        <option value="no">Not Verified</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-users" id="usersTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:45px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="text-center">Verified</th>
                            <th class="text-center">Created At</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="text-center sno">{{ $loop->iteration }}</td>
                            <td>
                                <span class="user-name">{{ $user->name }}</span>
                            </td>
                            <td>
                                <span class="user-email">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="user-phone">{{ $user->phone ?? '-' }}</span>
                            </td>
                            <td class="text-center">
                                @if($user->is_verified)
                                    <span class="verified-badge yes">
                                        <span class="dot"></span> Yes
                                    </span>
                                @else
                                    <span class="verified-badge no">
                                        <span class="dot"></span> No
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="created-date">{{ $user->created_at->format('d M Y, h:i A') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h5>No Users Found</h5>
                                    <p>No registered users available.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($users, 'links'))
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <strong>{{ $users->firstItem() ?? 0 }}</strong> to <strong>{{ $users->lastItem() ?? 0 }}</strong> of <strong>{{ $users->total() ?? 0 }}</strong> entries
                    </div>
                    <div class="pagination-links">
                        {{ $users->links() }}
                    </div>
                </div>
            @else
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <strong>{{ $users->count() }}</strong> entries
                    </div>
                </div>
            @endif

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
    var verifiedFilter = document.getElementById('verifiedFilter').value.toLowerCase();

    var rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var verified = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

        var matchesSearch = text.includes(searchValue);
        var matchesVerified = verifiedFilter === '' || verified.includes(verifiedFilter);

        if (matchesSearch && matchesVerified) {
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
        td.innerHTML = '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No users found matching your filters.';
        tr.appendChild(td);
        tbody.appendChild(tr);
    }
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('verifiedFilter').value = '';
    filterTable();
}
</script>

@endsection