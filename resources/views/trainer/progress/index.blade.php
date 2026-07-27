@extends('layouts.trainer-layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header - Green Theme -->
                <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i> Progress List
                        </h4>
                        <div>
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-list me-1"></i> Total: {{ $progress->total() }}
                            </span>
                            <a href="{{ route('trainer.progress.create') }}" class="btn btn-sm"
                                style="background: #ffd54f; color: #0d2818; border-radius: 8px;">
                                <i class="fas fa-plus me-1"></i> Add Progress
                            </a>
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
                                <input type="text" class="form-control" id="searchProgress"
                                    placeholder="Search member...">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <select class="form-select" id="filterDate">
                                <option value="all">All Dates</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <input type="date" class="form-control" id="filterDateRange" placeholder="Filter by date">
                        </div>
                        <div class="col-md-2 col-lg-3">
                            <button class="btn w-100" style="background: #0d2818; color: white; border-radius: 8px;"
                                onclick="resetFilters()">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="progressTable">
                            <thead style="background: #0d2818; color: white;">
                                <tr>
                                    <th width="50">S.No</th>
                                    <th>Member</th>
                                    <th>Date</th>
                                    <th>Weight (Kg)</th>
                                    <th>Height (cm)</th>
                                    <th>BMI</th>
                                    <th>Body Fat %</th>
                                    <th width="250">Action</th>
                                </tr>
                            </thead>
                            <tbody id="progressTableBody">
                                @forelse($progress as $row)
                                    <tr data-member="{{ strtolower($row->member->name ?? '') }}"
                                        data-date="{{ $row->progress_date }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $row->member->name ?? '-' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $row->member->member_id ?? '' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #1a472a; color: white;">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ date('d M Y', strtotime($row->progress_date)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #3b82f6; color: white;">
                                                {{ $row->weight }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #8b5cf6; color: white;">
                                                {{ $row->height }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($row->bmi < 18.5)
                                                <span class="badge"
                                                    style="background: #f59e0b; color: white;">{{ $row->bmi }}</span>
                                            @elseif($row->bmi >= 18.5 && $row->bmi < 25)
                                                <span class="badge"
                                                    style="background: #10b981; color: white;">{{ $row->bmi }}</span>
                                            @elseif($row->bmi >= 25 && $row->bmi < 30)
                                                <span class="badge"
                                                    style="background: #f59e0b; color: white;">{{ $row->bmi }}</span>
                                            @else
                                                <span class="badge"
                                                    style="background: #ef4444; color: white;">{{ $row->bmi }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #ec4899; color: white;">
                                                {{ $row->body_fat ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1" style="white-space: nowrap;">
                                                <a href="{{ route('trainer.progress.chart', $row->member_id) }}"
                                                    class="btn action-btn"
                                                    style="background: #8b5cf6; color: white; border-radius: 6px; border: none; padding: 3px 10px; font-size: 0.7rem; height: 28px; min-width: 65px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                                    <i class="fas fa-chart-bar me-1"></i> Chart
                                                </a>
                                                <a href="{{ route('trainer.progress.edit', $row->id) }}"
                                                    class="btn action-btn"
                                                    style="background: #f59e0b; color: white; border-radius: 6px; border: none; padding: 3px 10px; font-size: 0.7rem; height: 28px; min-width: 65px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('trainer.progress.destroy', $row->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn action-btn"
                                                        style="background: #ef4444; color: white; border-radius: 6px; border: none; padding: 3px 10px; font-size: 0.7rem; height: 28px; min-width: 65px; display: inline-flex; align-items: center; justify-content: center;"
                                                        onclick="return confirm('Delete this progress record?')">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-chart-line fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">No Progress Records Found</h5>
                                            <p class="text-muted">Start tracking member progress by clicking the "Add
                                                Progress" button.</p>
                                            <a href="{{ route('trainer.progress.create') }}" class="btn"
                                                style="background: #0d2818; color: white; border-radius: 8px; padding: 8px 25px;">
                                                <i class="fas fa-plus me-2"></i> Add Progress
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($progress->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                            <div>
                                <small class="text-muted">
                                    Showing {{ $progress->firstItem() ?? 0 }} to {{ $progress->lastItem() ?? 0 }} of
                                    {{ $progress->total() }} entries
                                </small>
                            </div>
                            <div>
                                {{ $progress->links() }}
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
            const searchInput = document.getElementById('searchProgress');
            const filterDate = document.getElementById('filterDate');
            const filterDateRange = document.getElementById('filterDateRange');
            const tableBody = document.getElementById('progressTableBody');

            if (!tableBody) return;

            const rows = tableBody.getElementsByTagName('tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const dateFilter = filterDate.value;
                const dateRangeFilter = filterDateRange.value;

                const today = new Date().toISOString().split('T')[0];
                const weekAgo = new Date();
                weekAgo.setDate(weekAgo.getDate() - 7);
                const weekAgoStr = weekAgo.toISOString().split('T')[0];
                const monthAgo = new Date();
                monthAgo.setMonth(monthAgo.getMonth() - 1);
                const monthAgoStr = monthAgo.toISOString().split('T')[0];

                let visibleCount = 0;

                for (let row of rows) {
                    const member = row.getAttribute('data-member') || '';
                    const date = row.getAttribute('data-date') || '';

                    const matchesSearch = searchTerm === '' || member.includes(searchTerm);

                    let matchesDate = true;
                    if (dateFilter === 'today') {
                        matchesDate = date === today;
                    } else if (dateFilter === 'week') {
                        matchesDate = date >= weekAgoStr && date <= today;
                    } else if (dateFilter === 'month') {
                        matchesDate = date >= monthAgoStr && date <= today;
                    }

                    const matchesDateRange = dateRangeFilter === '' || date === dateRangeFilter;

                    if (matchesSearch && matchesDate && matchesDateRange) {
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
            if (filterDate) {
                filterDate.addEventListener('change', filterTable);
            }
            if (filterDateRange) {
                filterDateRange.addEventListener('change', filterTable);
            }

            filterTable();
        });

        function resetFilters() {
            document.getElementById('searchProgress').value = '';
            document.getElementById('filterDate').value = 'all';
            document.getElementById('filterDateRange').value = '';

            const searchInput = document.getElementById('searchProgress');
            const filterDate = document.getElementById('filterDate');
            const filterDateRange = document.getElementById('filterDateRange');

            if (searchInput) {
                searchInput.dispatchEvent(new Event('input'));
            }
            if (filterDate) {
                filterDate.dispatchEvent(new Event('change'));
            }
            if (filterDateRange) {
                filterDateRange.dispatchEvent(new Event('change'));
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

        .form-control:focus,
        .form-select:focus {
            border-color: #1a472a !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.15) !important;
        }

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

        /* Action buttons - all exactly same size */
        .action-btn {
            padding: 3px 10px !important;
            font-size: 0.7rem !important;
            border-radius: 6px !important;
            height: 28px !important;
            min-height: 28px !important;
            max-height: 28px !important;
            min-width: 65px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            line-height: 1 !important;
            white-space: nowrap !important;
        }

        .action-btn i {
            font-size: 0.65rem !important;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            opacity: 0.9;
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

            .d-flex.gap-1 {
                flex-wrap: wrap !important;
            }

            .action-btn {
                height: 26px !important;
                min-height: 26px !important;
                max-height: 26px !important;
                min-width: 58px !important;
                padding: 2px 8px !important;
                font-size: 0.65rem !important;
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

            .action-btn {
                height: 24px !important;
                min-height: 24px !important;
                max-height: 24px !important;
                min-width: 50px !important;
                padding: 1px 6px !important;
                font-size: 0.6rem !important;
            }

            .action-btn i {
                font-size: 0.55rem !important;
            }
        }
    </style>
@endpush
