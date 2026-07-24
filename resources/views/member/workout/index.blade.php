@extends('layouts.member-layout')

@section('content')
    <div class="container-fluid px-3 px-md-4">
        <div class="row">
            <div class="col-12">
                <div class="workout-card-main">
                    <!-- Card Header - Matching Navbar Theme -->
                    <div class="workout-card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-dumbbell me-2"></i> My Workout Plans
                            </h4>
                            <span class="workout-count">
                                <i class="fas fa-list me-1"></i>
                                {{ $workouts->count() }} Plan(s)
                            </span>
                        </div>
                    </div>

                    <div class="workout-card-body">

                        @if (session('success'))
                            <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($workouts->count())
                            <div class="row g-4">
                                @foreach ($workouts as $workout)
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                        <div class="workout-card">
                                            <!-- Workout Header -->
                                            <div class="workout-card-header-section">
                                                <h5 class="workout-title">
                                                    <i class="fas fa-fire me-2"></i>
                                                    {{ $workout->title }}
                                                </h5>
                                                <span
                                                    class="workout-status-badge {{ strtolower($workout->status) == 'active' ? 'active' : 'completed' }}">
                                                    <i class="fas fa-circle me-1"></i>
                                                    {{ $workout->status }}
                                                </span>
                                            </div>

                                            <!-- Workout Body -->
                                            <div class="workout-card-body">
                                                <div class="workout-info-grid">
                                                    <div class="info-item">
                                                        <span class="info-label">
                                                            <i class="fas fa-user-tie me-1"></i> Trainer
                                                        </span>
                                                        <span class="info-value">
                                                            {{ $workout->trainer->name ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                    <div class="info-item">
                                                        <span class="info-label">
                                                            <i class="fas fa-calendar-alt me-1"></i> Start Date
                                                        </span>
                                                        <span class="info-value">
                                                            {{ \Carbon\Carbon::parse($workout->start_date)->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    <div class="info-item">
                                                        <span class="info-label">
                                                            <i class="fas fa-calendar-check me-1"></i> End Date
                                                        </span>
                                                        <span class="info-value">
                                                            {{ \Carbon\Carbon::parse($workout->end_date)->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    <div class="info-item">
                                                        <span class="info-label">
                                                            <i class="fas fa-clock me-1"></i> Duration
                                                        </span>
                                                        <span class="info-value">
                                                            @php
                                                                $start = \Carbon\Carbon::parse($workout->start_date);
                                                                $end = \Carbon\Carbon::parse($workout->end_date);
                                                                $days = $start->diffInDays($end);
                                                            @endphp
                                                            {{ $days }} Day(s)
                                                        </span>
                                                    </div>
                                                </div>

                                                

                                                <!-- Exercise Count -->
                                                <div class="exercise-count">
                                                    <i class="fas fa-list-ul me-1"></i>
                                                    {{ $workout->exercises->count() }} Exercise(s)
                                                </div>
                                            </div>

                                            <!-- Workout Footer -->
                                            <div class="workout-card-footer">
                                                <a href="{{ route('member.workout.show', $workout->id) }}"
                                                    class="btn-view-workout">
                                                    <i class="fas fa-eye me-2"></i> View Workout
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination - Removed hasPages check -->
                            @if (method_exists($workouts, 'links'))
                                <div class="pagination-wrapper">
                                    {{ $workouts->links() }}
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <i class="fas fa-dumbbell fa-4x"></i>
                                <h5>No Workout Plans Assigned</h5>
                                <p>You haven't been assigned any workout plans yet.</p>
                                <p class="text-muted small">Please contact your trainer for a workout plan.</p>
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
        .workout-card-main {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
            overflow: hidden;
            border: 1px solid rgba(13, 27, 62, 0.06);
        }

        .workout-card-header {
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
            color: #ffffff;
            padding: 18px 24px;
            border-bottom: none;
        }

        .workout-card-header h4 {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .workout-card-header h4 i {
            color: #ffd54f;
        }

        .workout-count {
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .workout-card-body {
            padding: 24px;
        }

        /* ============================================ */
        /* WORKOUT CARD - Professional Design           */
        /* ============================================ */
        .workout-card {
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(13, 27, 62, 0.06);
        }

        .workout-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(13, 27, 62, 0.12);
        }

        /* ============================================ */
        /* WORKOUT HEADER SECTION                       */
        /* ============================================ */
        .workout-card-header-section {
            padding: 18px 20px 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            border-bottom: 1px solid rgba(13, 27, 62, 0.06);
        }

        .workout-title {
            color: #0d1b3e;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            flex: 1;
        }

        .workout-title i {
            color: #ffd54f;
        }

        .workout-status-badge {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .workout-status-badge.active {
            background: #ecfdf5;
            color: #065f46;
        }

        .workout-status-badge.active i {
            color: #10b981;
        }

        .workout-status-badge.completed {
            background: #f0f4ff;
            color: #1a2a6c;
        }

        .workout-status-badge.completed i {
            color: #1a2a6c;
        }

        /* ============================================ */
        /* WORKOUT BODY                                 */
        /* ============================================ */
        .workout-card-body {
            padding: 16px 20px;
            flex: 1;
        }

        .workout-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 20px;
            margin-bottom: 14px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-label i {
            color: #1a2a6c;
        }

        .info-value {
            font-size: 0.85rem;
            font-weight: 600;
            color: #0d1b3e;
            margin-top: 1px;
        }

        /* ============================================ */
        /* PROGRESS BAR                                 */
        /* ============================================ */
        .workout-progress {
            margin-bottom: 10px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 4px;
        }

        .progress-label span:last-child {
            font-weight: 600;
            color: #0d1b3e;
        }

        .progress-bar-custom {
            width: 100%;
            height: 6px;
            background: #e8edf5;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0d1b3e 0%, #1a2a6c 100%);
            border-radius: 10px;
            transition: width 0.8s ease;
        }

        /* ============================================ */
        /* EXERCISE COUNT                               */
        /* ============================================ */
        .exercise-count {
            font-size: 0.8rem;
            color: #64748b;
            padding: 6px 12px;
            background: #f8fafc;
            border-radius: 8px;
            display: inline-block;
        }

        .exercise-count i {
            color: #1a2a6c;
        }

        /* ============================================ */
        /* WORKOUT FOOTER                               */
        /* ============================================ */
        .workout-card-footer {
            padding: 14px 20px 20px;
            background: #f8fafc;
            border-top: 1px solid rgba(13, 27, 62, 0.06);
        }

        .btn-view-workout {
            width: 100%;
            padding: 10px 16px;
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-view-workout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 27, 62, 0.25);
            color: #ffffff;
        }

        .btn-view-workout i {
            color: #ffd54f;
        }

        /* ============================================ */
        /* ALERTS - Custom Colors                       */
        /* ============================================ */
        .alert-custom-success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
            border-radius: 10px;
            padding: 12px 18px;
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
            margin-bottom: 0;
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
            .workout-info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .workout-card-header {
                padding: 14px 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .workout-card-header h4 {
                font-size: 1rem;
            }

            .workout-card-body {
                padding: 16px;
            }

            .workout-card-header-section {
                padding: 14px 16px 10px;
                flex-direction: column;
                gap: 8px;
            }

            .workout-title {
                font-size: 1rem;
            }

            .workout-info-grid {
                grid-template-columns: 1fr 1fr;
                gap: 6px 12px;
            }

            .info-value {
                font-size: 0.8rem;
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
            .workout-info-grid {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .workout-card-footer {
                padding: 12px 16px 16px;
            }

            .btn-view-workout {
                font-size: 0.85rem;
                padding: 8px 14px;
            }

            .workout-count {
                font-size: 0.75rem;
                padding: 2px 10px;
            }
        }

        /* ============================================ */
        /* ANIMATIONS                                   */
        /* ============================================ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .workout-card {
            animation: fadeInUp 0.5s ease forwards;
        }

        .workout-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .workout-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .workout-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .workout-card:nth-child(4) {
            animation-delay: 0.2s;
        }
    </style>
@endsection
