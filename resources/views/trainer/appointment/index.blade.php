@extends('layouts.trainer-layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header - Green Theme -->
                <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i> Appointments
                        </h4>
                        <div>
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-calendar me-1"></i> Total: <span
                                    id="totalCount">{{ $appointments->total() }}</span>
                            </span>
                            <span class="badge" style="background: #ffd54f; color: #0d2818;">
                                <i class="fas fa-clock me-1"></i> Pending: <span
                                    id="pendingCount">{{ $appointments->where('status', 'Pending')->count() }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="border-left: 4px solid #0d2818;">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4 col-lg-3">
                            <div class="input-group">
                                <span class="input-group-text" style="background: #0d2818; color: white; border: none;">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchAppointment"
                                    placeholder="Search member...">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <select class="form-select" id="filterStatus">
                                <option value="all">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Completed">Completed</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <input type="date" class="form-control" id="filterDate" placeholder="Filter by date">
                        </div>
                        <div class="col-md-2 col-lg-3">
                            <button class="btn w-100" style="background: #0d2818; color: white; border-radius: 8px;"
                                onclick="resetFilters()">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="appointmentsTable">
                            <thead style="background: #0d2818; color: white;">
                                <tr>
                                    <th width="50">S.No</th>
                                    <th>Member</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th width="280">Action</th>
                                </tr>
                            </thead>
                            <tbody id="appointmentsTableBody">
                                @forelse($appointments as $appointment)
                                    <tr data-status="{{ $appointment->status }}"
                                        data-member="{{ strtolower($appointment->member->name ?? '') }}"
                                        data-date="{{ $appointment->appointment_date }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $appointment->member->name ?? '-' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $appointment->member->email ?? '' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #1a472a; color: white;">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ date('d M Y', strtotime($appointment->appointment_date)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #ffd54f; color: #0d2818;">
                                                <i class="far fa-clock me-1"></i>
                                                {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #8b5cf6; color: white;">
                                                {{ $appointment->purpose ?? 'General' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($appointment->status == 'Pending')
                                                <span class="badge"
                                                    style="background: #f59e0b; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-hourglass-half me-1"></i> Pending
                                                </span>
                                            @elseif($appointment->status == 'Approved')
                                                <span class="badge"
                                                    style="background: #10b981; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-check-circle me-1"></i> Approved
                                                </span>
                                            @elseif($appointment->status == 'Completed')
                                                <span class="badge"
                                                    style="background: #3b82f6; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-check-double me-1"></i> Completed
                                                </span>
                                            @elseif($appointment->status == 'Rejected')
                                                <span class="badge"
                                                    style="background: #ef4444; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-times-circle me-1"></i> Rejected
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($appointment->status == 'Pending')
                                                <!-- Approve Button -->
                                                <button class="btn btn-sm"
                                                    style="background: #10b981; color: white; border-radius: 8px; margin-right: 5px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $appointment->id }}">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </button>

                                                <!-- Reject Button -->
                                                <button class="btn btn-sm"
                                                    style="background: #ef4444; color: white; border-radius: 8px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $appointment->id }}">
                                                    <i class="fas fa-times me-1"></i> Reject
                                                </button>

                                                <!-- View Details Button -->
                                                <button class="btn btn-sm"
                                                    style="background: #1a472a; color: white; border-radius: 8px; margin-top: 5px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewModal{{ $appointment->id }}">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </button>
                                            @else
                                                <!-- View Details Button -->
                                                <button class="btn btn-sm"
                                                    style="background: #1a472a; color: white; border-radius: 8px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewModal{{ $appointment->id }}">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </button>

                                                @if ($appointment->trainer_remark)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-comment me-1"></i>
                                                        {{ $appointment->trainer_remark }}
                                                    </small>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal{{ $appointment->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-check-circle me-2"></i> Approve Appointment
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form
                                                    action="{{ route('trainer.appointment.approve', $appointment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Appointment Details</label>
                                                            <div class="p-3"
                                                                style="background: #f8fafc; border-radius: 10px;">
                                                                <p class="mb-1"><strong>Member:</strong>
                                                                    {{ $appointment->member->name ?? '-' }}</p>
                                                                <p class="mb-1"><strong>Date:</strong>
                                                                    {{ date('d M Y', strtotime($appointment->appointment_date)) }}
                                                                </p>
                                                                <p class="mb-0"><strong>Time:</strong>
                                                                    {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="trainer_remark" class="form-label fw-bold">
                                                                <i class="fas fa-comment me-1"></i> Trainer Remark
                                                            </label>
                                                            <textarea name="trainer_remark" class="form-control" rows="3" placeholder="Add your remarks here..."
                                                                style="border-color: #1a472a;"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn"
                                                            style="background: #10b981; color: white;">
                                                            <i class="fas fa-check me-2"></i> Approve
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $appointment->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-times-circle me-2"></i> Reject Appointment
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('trainer.appointment.reject', $appointment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Are you sure you want to reject this appointment?
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Appointment Details</label>
                                                            <div class="p-3"
                                                                style="background: #f8fafc; border-radius: 10px;">
                                                                <p class="mb-1"><strong>Member:</strong>
                                                                    {{ $appointment->member->name ?? '-' }}</p>
                                                                <p class="mb-1"><strong>Date:</strong>
                                                                    {{ date('d M Y', strtotime($appointment->appointment_date)) }}
                                                                </p>
                                                                <p class="mb-0"><strong>Time:</strong>
                                                                    {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="trainer_remark"
                                                            value="Rejected by Trainer">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn"
                                                            style="background: #ef4444; color: white;">
                                                            <i class="fas fa-times me-2"></i> Reject
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal{{ $appointment->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header"
                                                    style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-calendar-check me-2"></i> Appointment Details
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Member</small>
                                                                <strong>{{ $appointment->member->name ?? '-' }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Email</small>
                                                                <strong>{{ $appointment->member->email ?? '-' }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Date</small>
                                                                <strong>{{ date('d M Y', strtotime($appointment->appointment_date)) }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Time</small>
                                                                <strong>{{ date('h:i A', strtotime($appointment->appointment_time)) }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Purpose</small>
                                                                <strong>{{ $appointment->purpose ?? 'General' }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Status</small>
                                                                <strong>
                                                                    @if ($appointment->status == 'Pending')
                                                                        <span class="badge"
                                                                            style="background: #f59e0b; color: white;">Pending</span>
                                                                    @elseif($appointment->status == 'Approved')
                                                                        <span class="badge"
                                                                            style="background: #10b981; color: white;">Approved</span>
                                                                    @elseif($appointment->status == 'Completed')
                                                                        <span class="badge"
                                                                            style="background: #3b82f6; color: white;">Completed</span>
                                                                    @elseif($appointment->status == 'Rejected')
                                                                        <span class="badge"
                                                                            style="background: #ef4444; color: white;">Rejected</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-secondary">{{ $appointment->status }}</span>
                                                                    @endif
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="info-item"
                                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                                                <small class="text-muted d-block">Description</small>
                                                                <strong>{{ $appointment->description ?? 'No description provided' }}</strong>
                                                            </div>
                                                        </div>
                                                        @if ($appointment->trainer_remark)
                                                            <div class="col-12">
                                                                <div class="info-item"
                                                                    style="background: #fef3c7; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #f59e0b;">
                                                                    <small class="text-muted d-block">Trainer
                                                                        Remark</small>
                                                                    <strong>{{ $appointment->trainer_remark }}</strong>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn"
                                                        style="background: #0d2818; color: white; border-radius: 25px; padding: 8px 30px;"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i> Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">No Appointments Found</h5>
                                            <p class="text-muted">Appointments will appear here when members book sessions.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($appointments->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $appointments->links() }}
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
            const searchInput = document.getElementById('searchAppointment');
            const filterStatus = document.getElementById('filterStatus');
            const filterDate = document.getElementById('filterDate');
            const tableBody = document.getElementById('appointmentsTableBody');
            const totalCount = document.getElementById('totalCount');
            const pendingCount = document.getElementById('pendingCount');

            if (!tableBody) return;

            const rows = tableBody.getElementsByTagName('tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const statusFilter = filterStatus.value;
                const dateFilter = filterDate.value;

                let visibleCount = 0;
                let pendingVisibleCount = 0;

                for (let row of rows) {
                    // Get data from data attributes
                    const member = row.getAttribute('data-member') || '';
                    const status = row.getAttribute('data-status') || '';
                    const date = row.getAttribute('data-date') || '';

                    // Check search match
                    const matchesSearch = searchTerm === '' || member.includes(searchTerm);

                    // Check status filter
                    const matchesStatus = statusFilter === 'all' || status === statusFilter;

                    // Check date filter
                    const matchesDate = dateFilter === '' || date === dateFilter;

                    // Show/hide row
                    if (matchesSearch && matchesStatus && matchesDate) {
                        row.style.display = '';
                        visibleCount++;
                        if (status === 'Pending') {
                            pendingVisibleCount++;
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }

                // Update counts
                if (totalCount) totalCount.textContent = visibleCount;
                if (pendingCount) pendingCount.textContent = pendingVisibleCount;
            }

            // Event listeners - auto filter on each change
            if (searchInput) {
                searchInput.addEventListener('input', filterTable);
            }
            if (filterStatus) {
                filterStatus.addEventListener('change', filterTable);
            }
            if (filterDate) {
                filterDate.addEventListener('change', filterTable);
            }

            // Initial filter
            filterTable();
        });

        // Reset function
        function resetFilters() {
            document.getElementById('searchAppointment').value = '';
            document.getElementById('filterStatus').value = 'all';
            document.getElementById('filterDate').value = '';

            // Trigger filter
            const searchInput = document.getElementById('searchAppointment');
            const filterStatus = document.getElementById('filterStatus');
            const filterDate = document.getElementById('filterDate');

            if (searchInput) {
                searchInput.dispatchEvent(new Event('input'));
            }
            if (filterStatus) {
                filterStatus.dispatchEvent(new Event('change'));
            }
            if (filterDate) {
                filterDate.dispatchEvent(new Event('change'));
            }
        }
    </script>
@endpush

@push('styles')
    <style>
        /* Modal Scrollbar */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #1a472a;
            border-radius: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #0d2818;
        }

        /* Table hover effect */
        .table-hover tbody tr:hover {
            background: rgba(13, 40, 24, 0.03);
            transition: all 0.3s ease;
        }

        /* Form focus effects */
        .form-control:focus,
        .form-select:focus {
            border-color: #1a472a;
            box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.25);
        }

        /* Responsive fixes */
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start !important;
            }

            .modal-dialog {
                margin: 10px;
            }

            .btn.w-100 {
                padding: 8px 10px;
                font-size: 0.9rem;
            }

            td .btn {
                margin-bottom: 5px;
                width: 100%;
            }

            td .btn-sm {
                font-size: 0.8rem;
                padding: 5px 10px;
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

            .modal-body {
                padding: 15px;
            }

            .modal-dialog {
                margin: 5px;
            }

            td .btn-sm {
                font-size: 0.7rem;
                padding: 4px 8px;
            }
        }
    </style>
@endpush
