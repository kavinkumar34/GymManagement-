@extends('layouts.trainer-layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header - Green Theme -->
                <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-0">
                            <i class="fas fa-eye me-2"></i> Workout Details
                        </h4>
                        <div>
                            <a href="{{ route('trainer.workout.edit', $workout->id) }}" class="btn btn-sm"
                                style="background: #ffd54f; color: #0d2818; border-radius: 8px;">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('trainer.workout.index') }}" class="btn btn-sm"
                                style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Workout Information -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">Member</small>
                                <strong>{{ $workout->member->name ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $workout->member->email ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">Workout Title</small>
                                <strong>{{ $workout->title }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">Status</small>
                                <strong>
                                    @if ($workout->status == 'Active')
                                        <span class="badge" style="background: #10b981; color: white; padding: 5px 15px;">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                        </span>
                                    @elseif($workout->status == 'Completed')
                                        <span class="badge" style="background: #3b82f6; color: white; padding: 5px 15px;">
                                            <i class="fas fa-check-circle me-1"></i> Completed
                                        </span>
                                    @else
                                        <span class="badge" style="background: #f59e0b; color: white; padding: 5px 15px;">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">Start Date</small>
                                <strong>{{ date('d M Y', strtotime($workout->start_date)) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">End Date</small>
                                <strong>{{ $workout->end_date ? date('d M Y', strtotime($workout->end_date)) : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item"
                                style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                                <small class="text-muted d-block">Description</small>
                                <strong>{{ $workout->description ?: 'No description available.' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Exercises -->
                    <div class="card" style="border-color: #1a472a;">
                        <div class="card-header" style="background: #0d2818; color: white;">
                            <h5 class="mb-0"><i class="fas fa-dumbbell me-2"></i>Workout Exercises</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $groupedExercises = $workout->exercises->groupBy('day');
                                $totalSets = $workout->exercises->sum(function ($exercise) {
                                    $numeric = preg_replace('/[^0-9.]/', '', $exercise->sets ?? 0);
                                    return is_numeric($numeric) ? (float) $numeric : 0;
                                });
                                $totalReps = $workout->exercises->sum(function ($exercise) {
                                    $numeric = preg_replace('/[^0-9.]/', '', $exercise->reps ?? 0);
                                    return is_numeric($numeric) ? (float) $numeric : 0;
                                });
                                $totalExercises = $workout->exercises->count();
                            @endphp

                            @if ($totalExercises > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle" style="font-size: 0.9rem;">
                                        <thead style="background: #1a472a; color: white;">
                                            <tr>
                                                <th><i class="fas fa-calendar-day me-1"></i> Day</th>
                                                <th><i class="fas fa-dumbbell me-1"></i> Exercise</th>
                                                <th><i class="fas fa-layer-group me-1"></i> Sets</th>
                                                <th><i class="fas fa-sync-alt me-1"></i> Reps</th>
                                                <th><i class="fas fa-weight me-1"></i> Weight</th>
                                                <th><i class="fas fa-hourglass-half me-1"></i> Rest</th>
                                                <th><i class="fas fa-video me-1"></i> Video</th>
                                                <th><i class="fas fa-sticky-note me-1"></i> Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupedExercises as $day => $exercises)
                                                @php $dayCount = count($exercises); @endphp
                                                @foreach ($exercises as $index => $exercise)
                                                    <tr>
                                                        @if ($index === 0)
                                                            <td rowspan="{{ $dayCount }}"
                                                                style="background: #f8fafc; text-align: center; vertical-align: middle; font-weight: 600;">
                                                                {{ $day }}
                                                                <br>
                                                                <span class="badge"
                                                                    style="background: #1a472a; color: white;">{{ $dayCount }}</span>
                                                            </td>
                                                        @endif
                                                        <td><strong>{{ $exercise->exercise_name }}</strong></td>
                                                        <td>{{ $exercise->sets ?? '-' }}</td>
                                                        <td>{{ $exercise->reps ?? '-' }}</td>
                                                        <td>{{ $exercise->weight ?? '-' }}</td>
                                                        <td>{{ $exercise->rest_time ?? '-' }}</td>
                                                        <td>
                                                            @if ($exercise->exercise_video)
                                                                <a href="{{ $exercise->exercise_video }}" target="_blank"
                                                                    class="btn btn-sm"
                                                                    style="background: #8b5cf6; color: white; border-radius: 6px;">
                                                                    <i class="fas fa-play"></i>
                                                                </a>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($exercise->trainer_notes)
                                                                <button type="button" class="btn btn-sm"
                                                                    style="background: #f59e0b; color: white; border-radius: 6px;"
                                                                    data-bs-toggle="modal" data-bs-target="#notesModal"
                                                                    data-exercise="{{ $exercise->exercise_name }}"
                                                                    data-notes="{{ $exercise->trainer_notes }}">
                                                                    <i class="fas fa-sticky-note"></i>
                                                                </button>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Summary -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="alert"
                                            style="background: rgba(13,40,24,0.05); border-left: 4px solid #1a472a; border-radius: 10px;">
                                            <strong><i class="fas fa-chart-bar me-2"
                                                    style="color: #1a472a;"></i>Summary:</strong>
                                            <span class="ms-3">Total Exercises:
                                                <strong>{{ $totalExercises }}</strong></span>
                                            <span class="ms-3">Total Sets:
                                                <strong>{{ number_format($totalSets) }}</strong></span>
                                            <span class="ms-3">Total Reps:
                                                <strong>{{ number_format($totalReps) }}</strong></span>
                                            <span class="ms-3">Total Days:
                                                <strong>{{ count($groupedExercises) }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning text-center" style="border-radius: 10px;">
                                    <i class="fas fa-info-circle me-2"></i> No exercises found for this workout plan.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Modal -->
    <div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-sticky-note me-2"></i> Trainer Notes
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Exercise:</strong>
                        <span id="modalExerciseName" style="color: #1a472a;"></span>
                    </div>
                    <hr>
                    <div id="modalNotesContent"
                        style="background: #f8fafc; padding: 15px; border-radius: 10px; min-height: 80px; white-space: pre-wrap; word-wrap: break-word;">
                        <!-- Notes will be injected here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background: #0d2818; color: white; border-radius: 8px;"
                        data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notesModal = document.getElementById('notesModal');
            if (notesModal) {
                notesModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const exerciseName = button.getAttribute('data-exercise');
                    const notes = button.getAttribute('data-notes');

                    document.getElementById('modalExerciseName').textContent = exerciseName;
                    document.getElementById('modalNotesContent').textContent = notes ||
                        'No notes available.';
                });
            }
        });
    </script>

    <style>
        .info-item {
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #e9ecef !important;
            transform: translateX(5px);
        }

        .table-hover tbody tr:hover {
            background: rgba(13, 40, 24, 0.03);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start !important;
            }

            .table {
                font-size: 0.8rem;
            }

            .table thead th i {
                display: none;
            }

            .table thead th,
            .table tbody td {
                padding: 6px 8px;
            }

            .btn-sm {
                padding: 2px 8px;
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .table {
                font-size: 0.7rem;
            }

            .table thead th,
            .table tbody td {
                padding: 4px 6px;
            }

            .btn-sm {
                padding: 1px 6px;
                font-size: 0.6rem;
            }

            .badge {
                font-size: 0.6rem;
            }

            .info-item {
                padding: 8px 12px !important;
            }

            .info-item strong {
                font-size: 0.85rem;
            }

            .info-item small {
                font-size: 0.65rem;
            }

            .modal-dialog {
                margin: 10px;
            }
        }
    </style>

@endsection
