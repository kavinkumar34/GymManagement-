@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="attendance-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="attendance-card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i> My Attendance
                    </h4>
                </div>
                
                <div class="attendance-card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Statistics Cards -->
                    @php
                        $present = $history->where('status','Present')->count();
                        $absent = $history->where('status','Absent')->count();
                        $total = $history->count();
                        $percentage = $total ? round(($present/$total)*100,2) : 0;
                    @endphp

                    <div class="stats-grid">
                        <div class="stat-card total">
                            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="stat-info">
                                <span class="stat-value">{{ $total }}</span>
                                <span class="stat-label">Total Days</span>
                            </div>
                        </div>
                        <div class="stat-card present">
                            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="stat-info">
                                <span class="stat-value">{{ $present }}</span>
                                <span class="stat-label">Present</span>
                            </div>
                        </div>
                        <div class="stat-card absent">
                            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                            <div class="stat-info">
                                <span class="stat-value">{{ $absent }}</span>
                                <span class="stat-label">Absent</span>
                            </div>
                        </div>
                        <div class="stat-card percentage">
                            <div class="stat-icon"><i class="fas fa-percentage"></i></div>
                            <div class="stat-info">
                                <span class="stat-value">{{ $percentage }}%</span>
                                <span class="stat-label">Attendance %</span>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="filter-section">
                        <div class="filter-row">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" class="search-input" 
                                       placeholder="Search by trainer..." 
                                       onkeyup="filterTable()">
                            </div>
                            <div class="filter-controls">
                                <input type="date" id="dateFilter" class="filter-date" 
                                       onchange="filterTable()" title="Filter by date">
                                <select id="statusFilter" class="filter-select" onchange="filterTable()">
                                    <option value="">All Status</option>
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                </select>
                                <button class="btn-reset" onclick="resetFilters()">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                        <div class="filter-info">
                            <span id="recordCount">Showing {{ $history->count() }} records</span>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="attendance-table" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60">S.No</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Trainer</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @forelse($history as $index => $attendance)
                                    <tr data-status="{{ $attendance->status }}" 
                                        data-date="{{ date('Y-m-d',strtotime($attendance->attendance_date)) }}"
                                        data-display-date="{{ date('d-m-Y',strtotime($attendance->attendance_date)) }}"
                                        data-trainer="{{ strtolower($attendance->trainer->name ?? '') }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <span class="date-cell">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ date('d-m-Y',strtotime($attendance->attendance_date)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($attendance->status=='Present')
                                                <span class="status-badge present">
                                                    <i class="fas fa-check-circle me-1"></i> Present
                                                </span>
                                            @else
                                                <span class="status-badge absent">
                                                    <i class="fas fa-times-circle me-1"></i> Absent
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_in)
                                                <span class="time-cell">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $attendance->check_in }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->check_out)
                                                <span class="time-cell">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $attendance->check_out }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="trainer-name">
                                                <i class="fas fa-user-tie me-1"></i>
                                                {{ $attendance->trainer->name ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center empty-row">
                                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                            <p>No Attendance Records Found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-section">
                        <div class="pagination-info">
                            <span>Showing <span id="pageStart">1</span> to <span id="pageEnd">10</span> of <span id="totalRecords">{{ $history->count() }}</span> entries</span>
                        </div>
                        <div class="pagination-controls">
                            <button class="page-btn" id="prevPage" onclick="changePage(-1)" disabled>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span id="pageNumbers"></span>
                            <button class="page-btn" id="nextPage" onclick="changePage(1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.attendance-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.attendance-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.attendance-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.attendance-card-header h4 i {
    color: #ffd54f;
}

.attendance-card-body {
    padding: 24px;
}

/* ============================================ */
/* STATISTICS CARDS                             */
/* ============================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid rgba(13, 27, 62, 0.06);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.stat-card.total .stat-icon {
    background: #0d1b3e;
}
.stat-card.present .stat-icon {
    background: #10b981;
}
.stat-card.absent .stat-icon {
    background: #ef4444;
}
.stat-card.percentage .stat-icon {
    background: #1a2a6c;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0d1b3e;
    line-height: 1.2;
}

.stat-label {
    font-size: 0.8rem;
    color: #94a3b8;
    font-weight: 500;
}

/* ============================================ */
/* FILTER SECTION                               */
/* ============================================ */
.filter-section {
    background: #f8fafc;
    padding: 16px 20px;
    border-radius: 12px;
    border: 1px solid rgba(13, 27, 62, 0.06);
    margin-bottom: 20px;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.search-box {
    flex: 1;
    min-width: 180px;
    position: relative;
}

.search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.search-input {
    width: 100%;
    padding: 10px 14px 10px 42px;
    border: 1px solid rgba(13, 27, 62, 0.1);
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #ffffff;
}

.search-input:focus {
    outline: none;
    border-color: #1a2a6c;
    box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.1);
}

.filter-controls {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-date {
    padding: 10px 14px;
    border: 1px solid rgba(13, 27, 62, 0.1);
    border-radius: 8px;
    font-size: 0.9rem;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 160px;
    color: #0d1b3e;
}

.filter-date:focus {
    outline: none;
    border-color: #1a2a6c;
    box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.1);
}

.filter-date::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
}

.filter-date::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}

.filter-select {
    padding: 10px 14px;
    border: 1px solid rgba(13, 27, 62, 0.1);
    border-radius: 8px;
    font-size: 0.9rem;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
}

.filter-select:focus {
    outline: none;
    border-color: #1a2a6c;
    box-shadow: 0 0 0 3px rgba(26, 42, 108, 0.1);
}

.btn-reset {
    padding: 10px 20px;
    background: #0d1b3e;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-reset:hover {
    background: #1a2a6c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 27, 62, 0.2);
}

.filter-info {
    margin-top: 10px;
    font-size: 0.85rem;
    color: #94a3b8;
}

/* ============================================ */
/* TABLE                                        */
/* ============================================ */
.attendance-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
}

.attendance-table thead {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
}

.attendance-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.attendance-table tbody tr {
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
    transition: background 0.2s ease;
}

.attendance-table tbody tr:hover {
    background: #f8fafc;
}

.attendance-table tbody td {
    padding: 12px 16px;
    color: #334155;
}

/* Status Badge */
.status-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-badge.present {
    background: #ecfdf5;
    color: #065f46;
}

.status-badge.present i {
    color: #10b981;
}

.status-badge.absent {
    background: #fef2f2;
    color: #991b1b;
}

.status-badge.absent i {
    color: #ef4444;
}

.date-cell {
    font-weight: 500;
    color: #0d1b3e;
}

.date-cell i {
    color: #1a2a6c;
}

.time-cell {
    font-weight: 500;
    color: #0d1b3e;
}

.time-cell i {
    color: #1a2a6c;
}

.trainer-name {
    color: #64748b;
}

.trainer-name i {
    color: #1a2a6c;
}

.empty-row {
    padding: 40px 20px !important;
    color: #94a3b8;
}

.empty-row i {
    display: block;
    color: #94a3b8;
}

.empty-row p {
    margin: 0;
    font-size: 1rem;
}

/* ============================================ */
/* PAGINATION                                   */
/* ============================================ */
.pagination-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.pagination-info {
    font-size: 0.85rem;
    color: #64748b;
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 6px;
}

.page-btn {
    width: 36px;
    height: 36px;
    border: 1px solid rgba(13, 27, 62, 0.1);
    border-radius: 8px;
    background: #ffffff;
    color: #0d1b3e;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-btn:hover:not(:disabled) {
    background: #0d1b3e;
    color: #ffffff;
    border-color: #0d1b3e;
}

.page-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.page-btn.active {
    background: #0d1b3e;
    color: #ffffff;
    border-color: #0d1b3e;
}

#pageNumbers {
    display: flex;
    gap: 4px;
    align-items: center;
}

.page-number {
    width: 36px;
    height: 36px;
    border: 1px solid rgba(13, 27, 62, 0.1);
    border-radius: 8px;
    background: #ffffff;
    color: #0d1b3e;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    font-size: 0.85rem;
}

.page-number:hover {
    background: #f8fafc;
    border-color: #0d1b3e;
}

.page-number.active {
    background: #0d1b3e;
    color: #ffffff;
    border-color: #0d1b3e;
}

/* ============================================ */
/* ALERTS                                       */
/* ============================================ */
.alert-custom-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
    border-radius: 10px;
    padding: 12px 18px;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .attendance-card-header {
        padding: 14px 18px;
    }
    
    .attendance-card-header h4 {
        font-size: 1rem;
    }
    
    .attendance-card-body {
        padding: 16px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .stat-card {
        padding: 12px 16px;
    }
    
    .stat-value {
        font-size: 1.2rem;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        min-width: unset;
    }
    
    .filter-controls {
        flex-direction: column;
    }
    
    .filter-date {
        width: 100%;
        min-width: unset;
    }
    
    .filter-select {
        width: 100%;
    }
    
    .btn-reset {
        width: 100%;
        justify-content: center;
    }
    
    .attendance-table {
        font-size: 0.8rem;
    }
    
    .attendance-table thead th,
    .attendance-table tbody td {
        padding: 8px 10px;
    }
    
    .pagination-section {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .stat-card {
        padding: 10px 12px;
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }
    
    .stat-icon {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .stat-value {
        font-size: 1rem;
    }
    
    .stat-label {
        font-size: 0.7rem;
    }
    
    .attendance-table {
        font-size: 0.7rem;
    }
    
    .attendance-table thead th,
    .attendance-table tbody td {
        padding: 6px 8px;
    }
    
    .status-badge {
        font-size: 0.7rem;
        padding: 2px 10px;
    }
    
    .page-number {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }
    
    .page-btn {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }
}

/* ============================================ */
/* ANIMATIONS                                   */
/* ============================================ */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.4s ease forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.2s; }

.attendance-table tbody tr {
    animation: fadeInUp 0.3s ease forwards;
}

.attendance-table tbody tr:nth-child(1) { animation-delay: 0.02s; }
.attendance-table tbody tr:nth-child(2) { animation-delay: 0.04s; }
.attendance-table tbody tr:nth-child(3) { animation-delay: 0.06s; }
.attendance-table tbody tr:nth-child(4) { animation-delay: 0.08s; }
.attendance-table tbody tr:nth-child(5) { animation-delay: 0.10s; }
.attendance-table tbody tr:nth-child(6) { animation-delay: 0.12s; }
.attendance-table tbody tr:nth-child(7) { animation-delay: 0.14s; }
.attendance-table tbody tr:nth-child(8) { animation-delay: 0.16s; }
.attendance-table tbody tr:nth-child(9) { animation-delay: 0.18s; }
.attendance-table tbody tr:nth-child(10) { animation-delay: 0.20s; }
</style>

<script>
// ============================================ //
// FILTER FUNCTION                              //
// ============================================ //
function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    const rows = document.querySelectorAll('#tableBody tr');
    let visibleCount = 0;

    rows.forEach(row => {
        // Skip empty row
        if (row.classList.contains('empty-row')) {
            row.style.display = '';
            return;
        }

        const date = row.getAttribute('data-date') || '';
        const displayDate = row.getAttribute('data-display-date') || '';
        const trainer = row.getAttribute('data-trainer') || '';
        const status = row.getAttribute('data-status') || '';

        // Search filter (trainer only)
        const matchesSearch = trainer.includes(searchInput);
        
        // Date filter
        const matchesDate = dateFilter === '' || date === dateFilter;
        
        // Status filter
        const matchesStatus = statusFilter === '' || status === statusFilter;

        if (matchesSearch && matchesDate && matchesStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('recordCount').textContent = `Showing ${visibleCount} records`;
    document.getElementById('totalRecords').textContent = visibleCount;

    // Update pagination
    currentPage = 1;
    setupPagination();
}

// ============================================ //
// RESET FILTERS                                //
// ============================================ //
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';
    filterTable();
}

// ============================================ //
// PAGINATION                                   //
// ============================================ //
let currentPage = 1;
const rowsPerPage = 10;

function setupPagination() {
    const rows = document.querySelectorAll('#tableBody tr:not(.empty-row)');
    const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
    const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;

    if (currentPage > totalPages) currentPage = totalPages;

    // Show/hide rows
    visibleRows.forEach((row, index) => {
        const page = Math.floor(index / rowsPerPage) + 1;
        row.style.display = page === currentPage ? '' : 'none';
    });

    // Update page info
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, visibleRows.length);
    document.getElementById('pageStart').textContent = visibleRows.length > 0 ? start : 0;
    document.getElementById('pageEnd').textContent = visibleRows.length > 0 ? end : 0;

    // Update buttons
    document.getElementById('prevPage').disabled = currentPage <= 1;
    document.getElementById('nextPage').disabled = currentPage >= totalPages;

    // Render page numbers
    renderPageNumbers(totalPages);
}

function renderPageNumbers(totalPages) {
    const container = document.getElementById('pageNumbers');
    container.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.className = 'page-number' + (i === currentPage ? ' active' : '');
        btn.textContent = i;
        btn.onclick = () => goToPage(i);
        container.appendChild(btn);
    }
}

function goToPage(page) {
    currentPage = page;
    setupPagination();
}

function changePage(delta) {
    const rows = document.querySelectorAll('#tableBody tr:not(.empty-row)');
    const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
    const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;

    const newPage = currentPage + delta;
    if (newPage >= 1 && newPage <= totalPages) {
        currentPage = newPage;
        setupPagination();
    }
}

// ============================================ //
// INITIALIZE PAGINATION ON LOAD                //
// ============================================ //
document.addEventListener('DOMContentLoaded', function() {
    setupPagination();
});
</script>
@endsection