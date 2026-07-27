@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-user-clock me-2"></i> 
                        {{ $member->name }} - Attendance History
                    </h4>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-user me-1"></i> {{ $member->member_id }}
                        </span>
                        <a href="{{ route('trainer.member-attendance.index') }}" 
                           class="btn btn-sm" 
                           style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                @php
                    $present = $history->where('status','Present')->count();
                    $absent = $history->where('status','Absent')->count();
                    $total = $history->count();
                    $percentage = $total ? round(($present/$total)*100,2) : 0;
                @endphp

                <!-- Statistics Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #f8fafc; border-radius: 12px; border-left: 4px solid #1a472a;">
                            <small class="text-muted d-block">Total Days</small>
                            <h3 class="mb-0">{{ $total }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #f0fdf4; border-radius: 12px; border-left: 4px solid #10b981;">
                            <small class="text-muted d-block">Present</small>
                            <h3 class="mb-0" style="color: #10b981;">{{ $present }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #fef2f2; border-radius: 12px; border-left: 4px solid #ef4444;">
                            <small class="text-muted d-block">Absent</small>
                            <h3 class="mb-0" style="color: #ef4444;">{{ $absent }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3" style="background: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
                            <small class="text-muted d-block">Attendance %</small>
                            <h3 class="mb-0" style="color: #f59e0b;">{{ $percentage }}%</h3>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="row g-3 mb-4">
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: #0d2818; color: white; border: none;">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchHistory" placeholder="Search by date or remarks...">
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
                    <table class="table table-bordered table-hover align-middle" id="historyTable">
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
                        <tbody id="historyTableBody">
                            @forelse($history as $key => $attendance)
                            <tr data-status="{{ $attendance->status }}" 
                                data-date="{{ $attendance->attendance_date }}" 
                                data-remarks="{{ strtolower($attendance->remarks ?? '') }}">
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
                                    <h5 class="text-muted">No Attendance History Found</h5>
                                    <p class="text-muted">This member has no attendance records yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($history instanceof \Illuminate\Pagination\LengthAwarePaginator && $history->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                    <div>
                        <small class="text-muted">
                            Showing {{ $history->firstItem() ?? 0 }} to {{ $history->lastItem() ?? 0 }} of {{ $history->total() }} entries
                        </small>
                    </div>
                    <div>
                        {{ $history->links() }}
                    </div>
                </div>
                @elseif($history->count() > 10)
                <div class="d-flex justify-content-center mt-4">
                    {{ $history->links() }}
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
    const searchInput = document.getElementById('searchHistory');
    const filterStatus = document.getElementById('filterStatus');
    const filterMonth = document.getElementById('filterMonth');
    const tableBody = document.getElementById('historyTableBody');
    
    if (!tableBody) return;
    
    const rows = tableBody.getElementsByTagName('tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusFilter = filterStatus.value;
        const monthFilter = filterMonth.value;
        
        let visibleCount = 0;
        
        for (let row of rows) {
            const date = row.getAttribute('data-date') || '';
            const status = row.getAttribute('data-status') || '';
            const remarks = row.getAttribute('data-remarks') || '';
            
            const matchesSearch = searchTerm === '' || date.includes(searchTerm) || remarks.includes(searchTerm);
            const matchesStatus = statusFilter === 'all' || status === statusFilter;
            
            let matchesMonth = true;
            if (monthFilter !== '') {
                const rowMonth = date.substring(0, 7);
                matchesMonth = rowMonth === monthFilter;
            }
            
            if (matchesSearch && matchesStatus && matchesMonth) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
    }
    
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
    
    filterTable();
});

function resetFilters() {
    document.getElementById('searchHistory').value = '';
    document.getElementById('filterStatus').value = 'all';
    
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('filterMonth').value = `${year}-${month}`;
    
    const searchInput = document.getElementById('searchHistory');
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
    .table-hover tbody tr:hover {
        background: rgba(13, 40, 24, 0.03);
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #1a472a !important;
        box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.15) !important;
    }

    /* Pagination styling */
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d2818;
        border-color: #0d2818;
        color: white;
    }
    .pagination .page-link {
        color: #1a472a;
    }
    .pagination .page-link:hover {
        color: #0d2818;
    }

    @media (max-width: 768px) {
        .card-header .d-flex {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start !important;
        }
        .btn.w-100 {
            padding: 8px 10px;
            font-size: 0.9rem;
        }
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
            align-items: center !important;
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
        .pagination .page-link {
            padding: 5px 10px;
            font-size: 0.85rem;
        }
    }
</style>
@endpush