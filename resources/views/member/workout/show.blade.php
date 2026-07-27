@extends('layouts.member-layout')

@section('content')
    <div class="container-fluid px-3 px-md-4">
        <div class="row">
            <div class="col-12">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('member.workout.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i> Back to Workouts
                    </a>
                </div>

                <div class="workout-detail-main">
                    <!-- Card Header - Matching Navbar Theme -->
                    <div class="workout-detail-header">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <h4 class="mb-0">
                                <i class="fas fa-dumbbell me-2"></i> {{ $workout->title }}
                            </h4>
                            <span
                                class="workout-status-badge {{ strtolower($workout->status) == 'active' ? 'active' : 'completed' }}">
                                <i class="fas fa-circle me-1"></i>
                                {{ $workout->status }}
                            </span>
                        </div>
                    </div>

                    <div class="workout-detail-body">
                        <!-- Workout Info -->
                        <div class="workout-info-section">
                            <div class="info-grid">
                                <div class="info-card">
                                    <span class="info-icon"><i class="fas fa-user-tie"></i></span>
                                    <div>
                                        <span class="info-label">Trainer</span>
                                        <span class="info-value">{{ $workout->trainer->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <span class="info-icon"><i class="fas fa-calendar-alt"></i></span>
                                    <div>
                                        <span class="info-label">Start Date</span>
                                        <span
                                            class="info-value">{{ \Carbon\Carbon::parse($workout->start_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <span class="info-icon"><i class="fas fa-calendar-check"></i></span>
                                    <div>
                                        <span class="info-label">End Date</span>
                                        <span
                                            class="info-value">{{ \Carbon\Carbon::parse($workout->end_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <span class="info-icon"><i class="fas fa-clock"></i></span>
                                    <div>
                                        <span class="info-label">Duration</span>
                                        <span class="info-value">
                                            @php
                                                $start = \Carbon\Carbon::parse($workout->start_date);
                                                $end = \Carbon\Carbon::parse($workout->end_date);
                                                $durationDays = $start->diffInDays($end);
                                            @endphp
                                            {{ $durationDays }} Day(s)
                                        </span>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <span class="info-icon"><i class="fas fa-list"></i></span>
                                    <div>
                                        <span class="info-label">Total Exercises</span>
                                        <span class="info-value">{{ $workout->exercises->count() }} Exercise(s)</span>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <span class="info-icon"><i class="fas fa-calendar-week"></i></span>
                                    <div>
                                        <span class="info-label">Workout Days</span>
                                        <span class="info-value">
                                            @php
                                                $uniqueDays = $workout->exercises->groupBy('day')->count();
                                            @endphp
                                            {{ $uniqueDays }} Day(s)
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if ($workout->description)
                                <div class="workout-description">
                                    <h6><i class="fas fa-align-left me-2"></i>Description</h6>
                                    <p>{{ $workout->description }}</p>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <!-- Exercises Section - Grouped by Day with Pagination -->
                        <div class="exercises-section">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-list-ul me-2"></i> Exercises
                                </h5>
                                <span class="exercise-total">
                                    Total: {{ $workout->exercises->count() }} Exercises
                                </span>
                            </div>

                            @php
                                // Group exercises by day
                                $exercisesByDay = $workout->exercises->groupBy('day');
                                $dayOrder = [
                                    'Monday',
                                    'Tuesday',
                                    'Wednesday',
                                    'Thursday',
                                    'Friday',
                                    'Saturday',
                                    'Sunday',
                                ];
                                $sortedDays = $exercisesByDay->sortBy(function ($items, $day) use ($dayOrder) {
                                    return array_search($day, $dayOrder);
                                });

                                // Pagination settings
                                $perPage = 12;
                                $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                $totalDays = $sortedDays->count();
                                $totalPages = ceil($totalDays / $perPage);
                                $offset = ($currentPage - 1) * $perPage;
                                $paginatedDays = $sortedDays->slice($offset, $perPage);
                            @endphp

                            <div class="row g-4" id="dayCardsContainer">
                                @foreach ($paginatedDays as $day => $dayExercises)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 day-card-item">
                                        <!-- Single Day Card -->
                                        <div class="day-card">
                                            <!-- Day Header -->
                                            <div class="day-card-header">
                                                <div class="day-info">
                                                    <i class="fas fa-calendar-day"></i>
                                                    <span class="day-name">{{ $day }}</span>
                                                </div>
                                                <span class="day-count">{{ $dayExercises->count() }} Ex</span>
                                            </div>

                                            <!-- Exercises List with Scroll -->
                                            <div class="day-card-body">
                                                @foreach ($dayExercises as $exercise)
                                                    <div class="exercise-item">
                                                        <div class="exercise-item-header">
                                                            <span class="exercise-icon">🏋️</span>
                                                            <span
                                                                class="exercise-name">{{ $exercise->exercise_name }}</span>
                                                        </div>
                                                        <div class="exercise-item-details">
                                                            <div class="detail-grid">
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Sets</span>
                                                                    <span class="detail-value">{{ $exercise->sets }}</span>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Reps</span>
                                                                    <span class="detail-value">{{ $exercise->reps }}</span>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Weight</span>
                                                                    <span
                                                                        class="detail-value">{{ $exercise->weight ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Rest</span>
                                                                    <span
                                                                        class="detail-value">{{ $exercise->rest_time ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                            @if ($exercise->trainer_notes)
                                                                <div class="exercise-note">
                                                                    <i class="fas fa-sticky-note"></i>
                                                                    {{ $exercise->trainer_notes }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if ($totalPages > 1)
                                <div class="pagination-container">
                                    <div class="pagination-info">
                                        Showing <span id="pageStart">{{ $offset + 1 }}</span> to
                                        <span id="pageEnd">{{ min($offset + $perPage, $totalDays) }}</span>
                                        of <span id="totalRecords">{{ $totalDays }}</span> days
                                    </div>
                                    <div class="pagination-controls">
                                        <button class="page-btn" id="prevPage" onclick="changePage(-1)"
                                            {{ $currentPage <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <div id="pageNumbers" class="page-numbers">
                                            @for ($i = 1; $i <= $totalPages; $i++)
                                                <button class="page-number {{ $i == $currentPage ? 'active' : '' }}"
                                                    onclick="goToPage({{ $i }})">
                                                    {{ $i }}
                                                </button>
                                            @endfor
                                        </div>
                                        <button class="page-btn" id="nextPage" onclick="changePage(1)"
                                            {{ $currentPage >= $totalPages ? 'disabled' : '' }}>
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ============================================ */
        /* BACK BUTTON                                  */
        /* ============================================ */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 8px 20px;
            background: #f8fafc;
            color: #0d1b3e;
            border: 1px solid rgba(13, 27, 62, 0.1);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #0d1b3e;
            color: #ffffff;
            border-color: #0d1b3e;
            transform: translateX(-3px);
        }

        /* ============================================ */
        /* MAIN CARD - Matching Navbar Theme            */
        /* ============================================ */
        .workout-detail-main {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
            overflow: hidden;
            border: 1px solid rgba(13, 27, 62, 0.06);
        }

        .workout-detail-header {
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
            color: #ffffff;
            padding: 18px 24px;
            border-bottom: none;
        }

        .workout-detail-header h4 {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .workout-detail-header h4 i {
            color: #ffd54f;
        }

        .workout-status-badge {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .workout-status-badge.active {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .workout-status-badge.completed {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .workout-detail-body {
            padding: 24px;
        }

        /* ============================================ */
        /* WORKOUT INFO SECTION                         */
        /* ============================================ */
        .workout-info-section {
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .info-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid rgba(13, 27, 62, 0.06);
        }

        .info-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .info-label {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            display: block;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #0d1b3e;
        }

        .workout-description {
            padding: 14px 18px;
            background: #f8fafc;
            border-radius: 10px;
            border-left: 4px solid #1a2a6c;
        }

        .workout-description h6 {
            color: #0d1b3e;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .workout-description p {
            color: #64748b;
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* ============================================ */
        /* EXERCISES SECTION                            */
        /* ============================================ */
        .exercises-section {
            margin-top: 4px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .section-title {
            color: #0d1b3e;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .section-title i {
            color: #ffd54f;
        }

        .exercise-total {
            font-size: 0.8rem;
            color: #64748b;
            padding: 4px 14px;
            background: #f8fafc;
            border-radius: 20px;
            border: 1px solid rgba(13, 27, 62, 0.06);
        }

        /* ============================================ */
        /* DAY CARD - Single Card per Day               */
        /* ============================================ */
        .day-card {
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
            border: 1px solid rgba(13, 27, 62, 0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .day-card:hover {
            box-shadow: 0 8px 30px rgba(13, 27, 62, 0.12);
            transform: translateY(-3px);
        }

        /* Day Card Header */
        .day-card-header {
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
            color: #ffffff;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .day-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .day-info i {
            color: #ffd54f;
            font-size: 1rem;
        }

        .day-name {
            font-weight: 700;
            font-size: 1rem;
        }

        .day-count {
            font-size: 0.7rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Day Card Body - Scrollable */
        .day-card-body {
            padding: 12px 14px;
            flex: 1;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        .day-card-body::-webkit-scrollbar {
            width: 5px;
        }

        .day-card-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .day-card-body::-webkit-scrollbar-thumb {
            background: #1a2a6c;
            border-radius: 10px;
        }

        .day-card-body::-webkit-scrollbar-thumb:hover {
            background: #0d1b3e;
        }

        /* ============================================ */
        /* EXERCISE ITEM - Inside Day Card              */
        /* ============================================ */
        .exercise-item {
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 8px;
            border: 1px solid rgba(13, 27, 62, 0.06);
            transition: all 0.3s ease;
        }

        .exercise-item:last-child {
            margin-bottom: 0;
        }

        .exercise-item:hover {
            background: #f0f4ff;
            border-color: #1a2a6c;
        }

        .exercise-item-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .exercise-icon {
            font-size: 1rem;
        }

        .exercise-name {
            font-weight: 700;
            color: #0d1b3e;
            font-size: 0.9rem;
        }

        .exercise-item-details {
            padding-left: 30px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 4px 8px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.55rem;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .detail-value {
            font-size: 0.8rem;
            font-weight: 600;
            color: #0d1b3e;
        }

        .exercise-note {
            margin-top: 6px;
            padding: 4px 10px;
            background: #fefce8;
            border-radius: 4px;
            border-left: 3px solid #f59e0b;
            font-size: 0.75rem;
            color: #78350f;
        }

        .exercise-note i {
            color: #f59e0b;
            margin-right: 4px;
        }

        /* ============================================ */
        /* PAGINATION                                   */
        /* ============================================ */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 24px;
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

        .page-numbers {
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
            background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
            color: #ffffff;
            border-color: #0d1b3e;
        }

        /* ============================================ */
        /* RESPONSIVE                                   */
        /* ============================================ */
        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: 1fr 1fr;
            }

            .detail-grid {
                grid-template-columns: 1fr 1fr 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .workout-detail-header {
                padding: 14px 18px;
            }

            .workout-detail-header h4 {
                font-size: 1rem;
            }

            .workout-detail-body {
                padding: 16px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-card {
                padding: 10px 14px;
            }

            .btn-back {
                padding: 6px 16px;
                font-size: 0.85rem;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .day-card-body {
                max-height: 300px;
            }

            .detail-grid {
                grid-template-columns: 1fr 1fr;
            }

            .exercise-item-details {
                padding-left: 0;
                margin-top: 4px;
            }

            .pagination-container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .workout-detail-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .day-card-body {
                max-height: 250px;
                padding: 10px 10px;
            }

            .exercise-item {
                padding: 8px 10px;
            }

            .exercise-name {
                font-size: 0.8rem;
            }

            .detail-grid {
                grid-template-columns: 1fr 1fr;
                gap: 2px 6px;
            }

            .detail-value {
                font-size: 0.75rem;
            }

            .day-name {
                font-size: 0.85rem;
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
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .day-card {
            animation: fadeInUp 0.4s ease forwards;
        }

        .day-card-item:nth-child(1) .day-card {
            animation-delay: 0.05s;
        }

        .day-card-item:nth-child(2) .day-card {
            animation-delay: 0.1s;
        }

        .day-card-item:nth-child(3) .day-card {
            animation-delay: 0.15s;
        }

        .day-card-item:nth-child(4) .day-card {
            animation-delay: 0.2s;
        }

        .day-card-item:nth-child(5) .day-card {
            animation-delay: 0.25s;
        }

        .day-card-item:nth-child(6) .day-card {
            animation-delay: 0.3s;
        }

        .day-card-item:nth-child(7) .day-card {
            animation-delay: 0.35s;
        }

        .day-card-item:nth-child(8) .day-card {
            animation-delay: 0.4s;
        }

        .day-card-item:nth-child(9) .day-card {
            animation-delay: 0.45s;
        }

        .day-card-item:nth-child(10) .day-card {
            animation-delay: 0.5s;
        }

        .day-card-item:nth-child(11) .day-card {
            animation-delay: 0.55s;
        }

        .day-card-item:nth-child(12) .day-card {
            animation-delay: 0.6s;
        }
    </style>

    <script>
        // ============================================ //
        // PAGINATION FUNCTIONS                         //
        // ============================================ //
        let currentPage = {{ $currentPage }};
        const totalPages = {{ $totalPages }};

        function goToPage(page) {
            if (page < 1 || page > totalPages) return;
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }

        function changePage(delta) {
            const newPage = currentPage + delta;
            if (newPage >= 1 && newPage <= totalPages) {
                goToPage(newPage);
            }
        }
    </script>
@endsection
