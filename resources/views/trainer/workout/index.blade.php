@extends('layouts.trainer-layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header - Green Theme -->
                <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-0">
                            <i class="fas fa-dumbbell me-2"></i> Workout Plans
                        </h4>
                        <div>
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-list me-1"></i> Total: {{ $workouts->count() }}
                            </span>
                            <a href="{{ route('trainer.workout.create') }}" class="btn btn-sm"
                                style="background: #ffd54f; color: #0d2818; border-radius: 8px;">
                                <i class="fas fa-plus me-1"></i> Create Workout
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
                        <div class="col-md-5 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text" style="background: #0d2818; color: white; border: none;">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchWorkout"
                                    placeholder="Search workout or member...">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <select class="form-select" id="filterStatus">
                                <option value="all">All Status</option>
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-5">
                            <button class="btn w-100" style="background: #0d2818; color: white; border-radius: 8px;"
                                onclick="resetFilters()">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="workoutTable">
                            <thead style="background: #0d2818; color: white;">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Member</th>
                                    <th>Workout Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th width="220">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workouts as $key => $workout)
                                    <tr data-status="{{ $workout->status }}"
                                        data-search="{{ strtolower($workout->title . ' ' . ($workout->member->name ?? '')) }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <strong>{{ $workout->member->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $workout->member->email ?? '' }}</small>
                                        </td>
                                        <td>{{ $workout->title }}</td>
                                        <td>
                                            <span class="badge" style="background: #1a472a; color: white;">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ date('d M Y', strtotime($workout->start_date)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($workout->end_date)
                                                <span class="badge" style="background: #1a472a; color: white;">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    {{ date('d M Y', strtotime($workout->end_date)) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($workout->status == 'Active')
                                                <span class="badge"
                                                    style="background: #10b981; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                                </span>
                                            @elseif($workout->status == 'Completed')
                                                <span class="badge"
                                                    style="background: #3b82f6; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-check-circle me-1"></i> Completed
                                                </span>
                                            @else
                                                <span class="badge"
                                                    style="background: #f59e0b; color: white; padding: 5px 15px;">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('trainer.workout.show', $workout->id) }}"
                                                    class="btn action-btn"
                                                    style="background: #8b5cf6; color: white; border-radius: 6px; border: none; padding: 3px 10px; font-size: 0.7rem; height: 28px; min-width: 55px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                                <a href="{{ route('trainer.workout.edit', $workout->id) }}"
                                                    class="btn action-btn"
                                                    style="background: #f59e0b; color: white; border-radius: 6px; border: none; padding: 3px 10px; font-size: 0.7rem; height: 28px; min-width: 55px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('trainer.workout.destroy', $workout->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn action-btn"
                                                        style="background: #ef4444; color: white; border-radius: 6px; border: none; padding: 3px 10px; font-size: 0.7rem; height: 28px; min-width: 55px; display: inline-flex; align-items: center; justify-content: center;"
                                                        onclick="return confirm('Delete this workout plan?')">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-dumbbell fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">No Workout Plans Found</h5>
                                            <p class="text-muted">Create a new workout plan for your members.</p>
                                            <a href="{{ route('trainer.workout.create') }}" class="btn"
                                                style="background: #0d2818; color: white; border-radius: 8px; padding: 8px 25px;">
                                                <i class="fas fa-plus me-2"></i> Create Workout
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchWorkout');
            const filterStatus = document.getElementById('filterStatus');
            const table = document.querySelector('table tbody');
            if (!table) return;
            const rows = table.getElementsByTagName('tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const statusFilter = filterStatus.value;

                for (let row of rows) {
                    const searchData = row.getAttribute('data-search') || '';
                    const status = row.getAttribute('data-status') || '';

                    const matchesSearch = searchTerm === '' || searchData.includes(searchTerm);
                    const matchesStatus = statusFilter === 'all' || status === statusFilter;

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                }
            }

            searchInput?.addEventListener('input', filterTable);
            filterStatus?.addEventListener('change', filterTable);
        });

        function resetFilters() {
            document.getElementById('searchWorkout').value = '';
            document.getElementById('filterStatus').value = 'all';
            document.getElementById('searchWorkout')?.dispatchEvent(new Event('input'));
            document.getElementById('filterStatus')?.dispatchEvent(new Event('change'));
        }
    </script>

    <style>
        .table-hover tbody tr:hover {
            background: rgba(13, 40, 24, 0.03);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1a472a !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 71, 42, 0.15) !important;
        }

        .action-btn {
            padding: 3px 10px !important;
            font-size: 0.7rem !important;
            border-radius: 6px !important;
            height: 28px !important;
            min-height: 28px !important;
            max-height: 28px !important;
            min-width: 55px !important;
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

            .d-flex.gap-1 {
                flex-wrap: wrap !important;
            }

            .action-btn {
                height: 26px !important;
                min-height: 26px !important;
                max-height: 26px !important;
                min-width: 48px !important;
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

            .action-btn {
                height: 24px !important;
                min-height: 24px !important;
                max-height: 24px !important;
                min-width: 42px !important;
                padding: 1px 6px !important;
                font-size: 0.6rem !important;
            }

            .action-btn i {
                font-size: 0.55rem !important;
            }
        }
    </style>
@endsection
