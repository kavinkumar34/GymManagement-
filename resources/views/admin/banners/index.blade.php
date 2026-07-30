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

    .admin-main-content {
        padding: 20px 25px;
        background: #f0f4f8;
        min-height: 100vh;
    }

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
        background: rgba(0,0,0,0.1);
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
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes timerShrink {
        from { width: 100%; }
        to { width: 0%; }
    }

    /* ============================================ */
    /* TABLE STYLES                                */
    /* ============================================ */
    .table-responsive {
        overflow-x: auto;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
    }

    .table-banners {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
    }

    .table-banners thead {
        background: var(--light-gray);
    }

    .table-banners thead th {
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

    .table-banners thead th.text-center {
        text-align: center;
    }

    .table-banners tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .table-banners tbody tr:hover {
        background: #f8f9fa;
    }

    .table-banners tbody tr:last-child td {
        border-bottom: none;
    }

    .table-banners .sno {
        font-weight: 600;
        color: var(--gray);
        font-size: 12px;
        text-align: center;
        width: 40px;
    }

    .table-banners .banner-img {
        width: 80px;
        height: 50px;
        border-radius: var(--radius);
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .table-banners .link-text {
        font-size: 12px;
        color: var(--primary);
        text-decoration: none;
        word-break: break-all;
    }

    .table-banners .link-text:hover {
        text-decoration: underline;
    }

    .table-banners .order-badge {
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        background: #e3f2fd;
        color: #1565c0;
        display: inline-block;
    }

    .table-banners .status-badge {
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .table-banners .status-badge.active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .table-banners .status-badge.inactive {
        background: #fce4ec;
        color: #c62828;
    }

    .table-banners .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .table-banners .status-badge.active .dot {
        background: #4caf50;
    }

    .table-banners .status-badge.inactive .dot {
        background: #ef5350;
    }

    /* ============================================ */
    /* ACTION BUTTONS                              */
    /* ============================================ */
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

    @media (max-width: 768px) {
        .admin-main-content { padding: 12px 15px; }
        .list-card .card-header { padding: 12px 16px; flex-direction: column; align-items: flex-start; }
        .list-card .card-header h4 { font-size: 16px; }
        .list-card .card-body { padding: 14px 16px; }
        .search-filter-section { flex-direction: column; padding: 12px 14px; }
        .search-filter-section .filter-group { flex-direction: column; width: 100%; }
        .search-filter-section .filter-group select { width: 100%; }
        .search-filter-section .filter-group .btn-reset { width: 100%; justify-content: center; }
        .action-group { gap: 3px; }
        .action-group .btn-action { width: 28px; height: 28px; font-size: 10px; }
        .table-banners thead th { font-size: 10px; padding: 6px 8px; }
        .table-banners tbody td { padding: 6px 8px; font-size: 11px; }
        .pagination-wrapper { flex-direction: column; align-items: center; }
        .pagination-wrapper .pagination-info { font-size: 12px; }
        .pagination-wrapper .pagination-links .page-item a,
        .pagination-wrapper .pagination-links .page-item span { padding: 4px 10px; font-size: 12px; min-width: 30px; }
        .table-banners .banner-img { width: 60px; height: 40px; }
    }

    @media (max-width: 576px) {
        .list-card .card-header h4 { font-size: 14px; }
        .list-card .card-body { padding: 10px 12px; }
        .search-filter-section .search-box input { font-size: 12px; height: 34px; }
        .search-filter-section .filter-group select { font-size: 12px; height: 34px; }
        .search-filter-section .filter-group .btn-reset { font-size: 12px; height: 34px; }
        .table-banners tbody td { padding: 4px 6px; font-size: 10px; }
        .table-banners thead th { padding: 4px 6px; font-size: 9px; }
        .action-group .btn-action { width: 24px; height: 24px; font-size: 9px; }
        .table-banners .banner-img { width: 50px; height: 35px; }
        .table-banners .status-badge { font-size: 9px; padding: 2px 8px; }
        .table-banners .order-badge { font-size: 9px; padding: 2px 8px; }
    }
</style>

<div class="admin-main-content">
    <div class="list-card">
        <div class="card-header">
            <div>
                <h4><i class="fas fa-images"></i> Banner Management</h4>
                <small style="opacity:0.8;">Manage all banners</small>
            </div>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-success" style="background:#4caf50; color:#fff; border:none; padding:8px 20px; border-radius:10px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; font-size:13px; transition:all 0.3s;">
                <i class="fas fa-plus"></i> Add Banner
            </a>
        </div>

        <div class="card-body">
            <!-- Custom Alert -->
            @if(session('success'))
                <div class="custom-alert success" id="customAlert">
                    <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-content"><strong>Success!</strong> {{ session('success') }}</span>
                    <button class="alert-close" onclick="closeAlert()">&times;</button>
                    <div class="alert-timer"><div class="timer-bar"></div></div>
                </div>
            @endif

            @if(session('error'))
                <div class="custom-alert error" id="customAlert">
                    <span class="alert-icon"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="alert-content"><strong>Error!</strong> {{ session('error') }}</span>
                    <button class="alert-close" onclick="closeAlert()">&times;</button>
                    <div class="alert-timer"><div class="timer-bar"></div></div>
                </div>
            @endif

            <!-- Search & Filter -->
            <div class="search-filter-section">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by link..." onkeyup="filterTable()">
                </div>
                <div class="filter-group">
                    <select id="statusFilter" onchange="filterTable()">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <button class="btn-reset" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table-banners" id="bannerTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">#</th>
                            <th style="width:100px;">Image</th>
                            <th>Link</th>
                            <th class="text-center" style="width:80px;">Order</th>
                            <th class="text-center" style="width:100px;">Status</th>
                            <th class="text-center" style="width:100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($banners as $index => $banner)
                            <tr>
                                <td class="text-center sno">{{ $loop->iteration }}</td>
                                <td>
                                    @if($banner->image)
                                        <img src="{{ Storage::url($banner->image) }}" class="banner-img" alt="Banner">
                                    @else
                                        <span class="text-muted" style="font-size:11px;">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($banner->link)
                                        <a href="{{ $banner->link }}" target="_blank" class="link-text">{{ Str::limit($banner->link, 40) }}</a>
                                    @else
                                        <span class="text-muted" style="font-size:11px;">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center"><span class="order-badge">{{ $banner->order }}</span></td>
                                <td class="text-center">
                                    <span class="status-badge {{ $banner->status == 'Active' ? 'active' : 'inactive' }}">
                                        <span class="dot"></span> {{ $banner->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-group">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn-action edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" onclick="return confirm('Are you sure you want to delete this banner?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-images"></i>
                                        <h5>No Banners Found</h5>
                                        <p><a href="{{ route('admin.banners.create') }}">Add your first banner now!</a></p>
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
                    Showing <strong>{{ $banners->firstItem() ?? 0 }}</strong> to <strong>{{ $banners->lastItem() ?? 0 }}</strong> of <strong>{{ $banners->total() ?? 0 }}</strong> entries
                </div>
                <div class="pagination-links">
                    {{ $banners->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// ============================================
// SEARCH & FILTER TABLE
// ============================================
function filterTable() {
    var searchValue = document.getElementById('searchInput').value.toLowerCase();
    var statusFilter = document.getElementById('statusFilter').value.toLowerCase();

    var rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var status = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

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
        td.innerHTML = '<i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px; color:#dee2e6;"></i> No banners found matching your filters.';
        tr.appendChild(td);
        tbody.appendChild(tr);
    }
}

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
});
</script>

@endsection