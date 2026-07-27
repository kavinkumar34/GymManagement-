@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i> My Attendance
                    </h4>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-list me-1"></i> Total: {{ $attendances->count() }}
                        </span>
                        <span class="badge" style="background: #ffd54f; color: #0d2818;">
                            <i class="fas fa-check-circle me-1"></i> Present: {{ $attendances->where('status', 'Present')->count() }}
                        </span>
                        <a href="{{ route('trainer.trainer-attendance.create') }}" 
                           class="btn btn-sm ms-2" 
                           style="background: #ffd54f; color: #0d2818; border-radius: 8px;">
                            <i class="fas fa-plus me-1"></i> Mark Attendance
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #0d2818;">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545;">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="row g-3 mb-4">
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: #0d2818; color: white; border: none;">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchAttendance" placeholder="Search by date or remarks...">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <select class="form-select" id="filterStatus">
                            <option value="all">All Status</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <input type="month" class="form-control" id="filterMonth" placeholder="Filter by month">
                    </div>
                    <div class="col-md-1 col-lg-2">
                        <button class="btn w-100" style="background: #0d2818; color: white; border-radius: 8px;" onclick="resetFilters()">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="attendanceTable">
                        <thead style="background: #0d2818; color: white;">
                            <tr>
                                <th width="50">S.No</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTableBody">
                            @forelse($attendances as $key => $attendance)
                            <tr data-status="{{ $attendance->status }}" data-date="{{ $attendance->attendance_date }}" data-remarks="{{ strtolower($attendance->remarks ?? '') }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <span class="badge" style="background: #1a472a; color: white;">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ date('d M Y', strtotime($attendance->attendance_date)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($attendance->status == 'Present')
                                        <span class="badge" style="background: #10b981; color: white; padding: 5px 15px;">
                                            <i class="fas fa-check-circle me-1"></i> Present
                                        </span>
                                    @else
                                        <span class="badge" style="background: #ef4444; color: white; padding: 5px 15px;">
                                            <i class="fas fa-times-circle me-1"></i> Absent
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->check_in)
                                        <span class="badge" style="background: #ffd54f; color: #0d2818;">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ date('h:i A', strtotime($attendance->check_in)) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->check_out)
                                        <span class="badge" style="background: #ffd54f; color: #0d2818;">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ date('h:i A', strtotime($attendance->check_out)) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->remarks)
                                        <span class="badge" style="background: #8b5cf6; color: white;">
                                            <i class="fas fa-comment me-1"></i>
                                            {{ Str::limit($attendance->remarks, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                    <h5 class="text-muted">No Attendance Records Found</h5>
                                    <p class="text-muted">Start marking your attendance by clicking the "Mark Attendance" button.</p>
                                    <a href="{{ route('trainer.trainer-attendance.create') }}" 
                                       class="btn" 
                                       style="background: #0d2818; color: white; border-radius: 8px; padding: 8px 25px;">
                                        <i class="fas fa-plus me-2"></i> Mark Attendance
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
                @if($attendances->count() > 0)
                <div class="row g-3 mt-3">
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #f8fafc; border-radius: 12px; border-left: 4px solid #1a472a;">
                            <small class="text-muted d-block">Total Days</small>
                            <h4 class="mb-0">{{ $attendances->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #f0fdf4; border-radius: 12px; border-left: 4px solid #10b981;">
                            <small class="text-muted d-block">Present</small>
                            <h4 class="mb-0" style="color: #10b981;">{{ $attendances->where('status', 'Present')->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #fef2f2; border-radius: 12px; border-left: 4px solid #ef4444;">
                            <small class="text-muted d-block">Absent</small>
                            <h4 class="mb-0" style="color: #ef4444;">{{ $attendances->where('status', 'Absent')->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
                            <small class="text-muted d-block">Attendance %</small>
                            <h4 class="mb-0" style="color: #f59e0b;">
                                @php
                                    $total = $attendances->count();
                                    $present = $attendances->where('status', 'Present')->count();
                                    $percentage = $total > 0 ? round(($present / $total) * 100) : 0;
                                @endphp
                                {{ $percentage }}%
                            </h4>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all elements
    const searchInput = document.getElementById('searchAttendance');
    const filterStatus = document.getElementById('filterStatus');
    const filterMonth = document.getElementById('filterMonth');
    const tableBody = document.getElementById('attendanceTableBody');
    
    if (!tableBody) return;
    
    const rows = tableBody.getElementsByTagName('tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusFilter = filterStatus.value;
        const monthFilter = filterMonth.value;
        
        let visibleCount = 0;
        
        for (let row of rows) {
            // Get data from data attributes
            const date = row.getAttribute('data-date') || '';
            const status = row.getAttribute('data-status') || '';
            const remarks = row.getAttribute('data-remarks') || '';
            
            // Check search match
            const matchesSearch = searchTerm === '' || 
                                 date.includes(searchTerm) || 
                                 remarks.includes(searchTerm);
            
            // Check status filter
            const matchesStatus = statusFilter === 'all' || status === statusFilter;
            
            // Check month filter
            let matchesMonth = true;
            if (monthFilter !== '') {
                const rowMonth = date.substring(0, 7); // YYYY-MM
                matchesMonth = rowMonth === monthFilter;
            }
            
            // Show/hide row
            if (matchesSearch && matchesStatus && matchesMonth) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
    }
    
    // Event listeners - auto filter on each change
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    if (filterStatus) {
        filterStatus.addEventListener('change', filterTable);
    }
    if (filterMonth) {
        filterMonth.addEventListener('change', filterTable);
    }
    
    // Set default month to current month
    if (filterMonth) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        filterMonth.value = `${year}-${month}`;
    }
    
    // Initial filter
    filterTable();
});

// Reset function
function resetFilters() {
    document.getElementById('searchAttendance').value = '';
    document.getElementById('filterStatus').value = 'all';
    
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('filterMonth').value = `${year}-${month}`;
    
    // Trigger filter
    const searchInput = document.getElementById('searchAttendance');
    const filterStatus = document.getElementById('filterStatus');
    const filterMonth = document.getElementById('filterMonth');
    
    if (searchInput) {
        searchInput.dispatchEvent(new Event('input'));
    }
    if (filterStatus) {
        filterStatus.dispatchEvent(new Event('change'));
    }
    if (filterMonth) {
        filterMonth.dispatchEvent(new Event('change'));
    }
}
</script>
@endpush

@push('styles')
<style>
    /* Table hover effect */
    .table-hover tbody tr:hover {
        background: rgba(13, 40, 24, 0.03);
        transition: all 0.3s ease;
    }

    /* Form focus effects */
    .form-control:focus, .form-select:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.15) !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header .d-flex {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start !important;
        }
        
        .card-header .d-flex .btn {
            width: 100%;
        }
        
        .btn.w-100 {
            padding: 8px 10px;
            font-size: 0.9rem;
        }
        
        .summary-cards .col-md-3 {
            margin-bottom: 10px;
        }
    }

    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .badge {
            font-size: 0.65rem;
        }
        
        .input-group .form-control {
            font-size: 0.85rem;
        }
        
        .form-select {
            font-size: 0.85rem;
            padding: 6px 10px;
        }
        
        .card-header h4 {
            font-size: 1rem;
        }
    }
</style>
@endpush