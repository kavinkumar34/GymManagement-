@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="appointment-card-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="appointment-card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i> My Appointments
                        </h4>
                        <a href="{{ route('member.appointment.create') }}" class="btn-book">
                            <i class="fas fa-plus me-1"></i> Book Appointment
                        </a>
                    </div>
                </div>
                
                <div class="appointment-card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($appointments->count())
                        <div class="table-responsive">
                            <table class="appointment-table">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="50">#</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Trainer</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                        <th>Trainer Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="date-cell">
                                                    <i class="fas fa-calendar-day me-1"></i>
                                                    {{ date('d-m-Y', strtotime($appointment->appointment_date)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="time-cell">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="trainer-name">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $appointment->trainer->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="purpose-text">{{ $appointment->purpose }}</span>
                                            </td>
                                            <td>
                                                @if($appointment->status == 'Pending')
                                                    <span class="status-badge pending">
                                                        <i class="fas fa-clock me-1"></i> Pending
                                                    </span>
                                                @elseif($appointment->status == 'Approved')
                                                    <span class="status-badge approved">
                                                        <i class="fas fa-check-circle me-1"></i> Approved
                                                    </span>
                                                @elseif($appointment->status == 'Rejected')
                                                    <span class="status-badge rejected">
                                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                                    </span>
                                                @else
                                                    <span class="status-badge completed">
                                                        <i class="fas fa-check-double me-1"></i> Completed
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($appointment->trainer_remark)
                                                    <span class="remark-text">
                                                        <i class="fas fa-comment me-1"></i>
                                                        {{ $appointment->trainer_remark }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="empty-row">
                                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                                <p>No Appointments Found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            {{ $appointments->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-times fa-4x"></i>
                            <h5>No Appointments Found</h5>
                            <p>You haven't booked any appointments yet.</p>
                            <a href="{{ route('member.appointment.create') }}" class="btn-book-empty">
                                <i class="fas fa-plus me-2"></i> Book Your First Appointment
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* MAIN CARD - Matching Navbar Theme            */
/* ============================================ */
.appointment-card-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.appointment-card-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.appointment-card-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.appointment-card-header h4 i {
    color: #ffd54f;
}

.btn-book {
    display: inline-flex;
    align-items: center;
    padding: 8px 20px;
    background: #ffd54f;
    color: #0d1b3e;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.btn-book:hover {
    background: #fbbf24;
    color: #0d1b3e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 213, 79, 0.3);
}

.appointment-card-body {
    padding: 24px;
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
/* TABLE                                        */
/* ============================================ */
.appointment-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
}

.appointment-table thead {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
}

.appointment-table thead th {
    padding: 12px 14px;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.appointment-table tbody tr {
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
    transition: background 0.2s ease;
}

.appointment-table tbody tr:hover {
    background: #f8fafc;
}

.appointment-table tbody td {
    padding: 10px 14px;
    color: #334155;
    vertical-align: middle;
}

/* ============================================ */
/* TABLE STYLES                                 */
/* ============================================ */
.date-cell {
    font-weight: 500;
    color: #0d1b3e;
    white-space: nowrap;
}

.date-cell i {
    color: #1a2a6c;
}

.time-cell {
    font-weight: 500;
    color: #0d1b3e;
    white-space: nowrap;
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

.purpose-text {
    font-weight: 500;
    color: #0d1b3e;
}

.remark-text {
    color: #64748b;
    font-size: 0.85rem;
}

.remark-text i {
    color: #1a2a6c;
}

/* ============================================ */
/* STATUS BADGES                                */
/* ============================================ */
.status-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.pending i {
    color: #f59e0b;
}

.status-badge.approved {
    background: #ecfdf5;
    color: #065f46;
}

.status-badge.approved i {
    color: #10b981;
}

.status-badge.rejected {
    background: #fef2f2;
    color: #991b1b;
}

.status-badge.rejected i {
    color: #ef4444;
}

.status-badge.completed {
    background: #f0f4ff;
    color: #1a2a6c;
}

.status-badge.completed i {
    color: #1a2a6c;
}

/* ============================================ */
/* EMPTY STATE                                  */
/* ============================================ */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed rgba(13, 27, 62, 0.08);
}

.empty-state i {
    color: #94a3b8;
    margin-bottom: 12px;
}

.empty-state h5 {
    color: #0d1b3e;
    font-weight: 600;
}

.empty-state p {
    color: #94a3b8;
    margin-bottom: 20px;
}

.btn-book-empty {
    display: inline-flex;
    align-items: center;
    padding: 10px 28px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-book-empty:hover {
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 27, 62, 0.25);
}

.empty-row {
    padding: 40px 20px !important;
    color: #94a3b8;
    text-align: center;
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
.pagination-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(13, 27, 62, 0.06);
}

.pagination-wrapper .pagination {
    gap: 4px;
    margin-bottom: 0;
}

.pagination-wrapper .page-item .page-link {
    color: #0d1b3e;
    border: 1px solid rgba(13, 27, 62, 0.08);
    border-radius: 6px;
    padding: 6px 14px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    border-color: #0d1b3e;
    color: #ffffff;
}

.pagination-wrapper .page-item .page-link:hover {
    background: rgba(13, 27, 62, 0.05);
    border-color: #0d1b3e;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .appointment-table {
        font-size: 0.8rem;
    }
    
    .appointment-table thead th,
    .appointment-table tbody td {
        padding: 8px 10px;
    }
}

@media (max-width: 768px) {
    .appointment-card-header {
        padding: 14px 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .appointment-card-header h4 {
        font-size: 1rem;
    }
    
    .btn-book {
        width: 100%;
        justify-content: center;
    }
    
    .appointment-card-body {
        padding: 16px;
    }
    
    .appointment-table {
        font-size: 0.75rem;
    }
    
    .appointment-table thead th,
    .appointment-table tbody td {
        padding: 6px 8px;
    }
    
    .appointment-table thead th {
        font-size: 0.65rem;
    }
    
    .status-badge {
        font-size: 0.65rem;
        padding: 2px 10px;
    }
    
    .pagination-wrapper {
        justify-content: center;
    }
    
    .pagination-wrapper .page-item .page-link {
        padding: 4px 10px;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .appointment-table {
        font-size: 0.65rem;
    }
    
    .appointment-table thead th,
    .appointment-table tbody td {
        padding: 4px 6px;
    }
    
    .appointment-table thead th {
        font-size: 0.55rem;
        letter-spacing: 0;
    }
    
    .status-badge {
        font-size: 0.6rem;
        padding: 2px 8px;
    }
    
    .btn-book-empty {
        width: 100%;
        justify-content: center;
        padding: 10px 16px;
        font-size: 0.85rem;
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

.appointment-table tbody tr {
    animation: fadeInUp 0.3s ease forwards;
}

.appointment-table tbody tr:nth-child(1) { animation-delay: 0.02s; }
.appointment-table tbody tr:nth-child(2) { animation-delay: 0.04s; }
.appointment-table tbody tr:nth-child(3) { animation-delay: 0.06s; }
.appointment-table tbody tr:nth-child(4) { animation-delay: 0.08s; }
.appointment-table tbody tr:nth-child(5) { animation-delay: 0.10s; }
.appointment-table tbody tr:nth-child(6) { animation-delay: 0.12s; }
.appointment-table tbody tr:nth-child(7) { animation-delay: 0.14s; }
.appointment-table tbody tr:nth-child(8) { animation-delay: 0.16s; }
.appointment-table tbody tr:nth-child(9) { animation-delay: 0.18s; }
.appointment-table tbody tr:nth-child(10) { animation-delay: 0.20s; }
</style>
@endsection