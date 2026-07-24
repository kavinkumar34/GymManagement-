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
                        <span class="workout-status-badge {{ strtolower($workout->status) == 'active' ? 'active' : 'completed' }}">
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
                                    <span class="info-value">{{ \Carbon\Carbon::parse($workout->start_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-calendar-check"></i></span>
                                <div>
                                    <span class="info-label">End Date</span>
                                    <span class="info-value">{{ \Carbon\Carbon::parse($workout->end_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-list"></i></span>
                                <div>
                                    <span class="info-label">Exercises</span>
                                    <span class="info-value">{{ $workout->exercises->count() }} Exercise(s)</span>
                                </div>
                            </div>
                        </div>

                        @if($workout->description)
                            <div class="workout-description">
                                <h6><i class="fas fa-align-left me-2"></i>Description</h6>
                                <p>{{ $workout->description }}</p>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <!-- Exercises Section -->
                    <div class="exercises-section">
                        <h5 class="section-title">
                            <i class="fas fa-list-ul me-2"></i> Exercises
                        </h5>

                        <div class="row g-3">
                            @foreach($workout->exercises as $exercise)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                    <div class="exercise-card">
                                        <div class="exercise-header">
                                            <h6 class="exercise-day">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ $exercise->day }}
                                            </h6>
                                        </div>
                                        <div class="exercise-body">
                                            <div class="exercise-name">
                                                <i class="fas fa-running me-2"></i>
                                                {{ $exercise->exercise_name }}
                                            </div>
                                            <div class="exercise-details">
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
                                                    <span class="detail-value">{{ $exercise->weight ?? 'N/A' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Rest Time</span>
                                                    <span class="detail-value">{{ $exercise->rest_time ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                            @if($exercise->trainer_notes)
                                                <div class="trainer-notes">
                                                    <i class="fas fa-sticky-note me-1"></i>
                                                    <span>{{ $exercise->trainer_notes }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

.section-title {
    color: #0d1b3e;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 16px;
}

.section-title i {
    color: #ffd54f;
}

/* ============================================ */
/* EXERCISE CARD                                */
/* ============================================ */
.exercise-card {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
    border: 1px solid rgba(13, 27, 62, 0.06);
    height: 100%;
    transition: all 0.3s ease;
}

.exercise-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(13, 27, 62, 0.1);
}

.exercise-header {
    padding: 10px 16px;
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
}

.exercise-day {
    margin: 0;
    font-weight: 600;
    font-size: 0.85rem;
}

.exercise-day i {
    color: #ffd54f;
}

.exercise-body {
    padding: 14px 16px 16px;
}

.exercise-name {
    font-weight: 700;
    color: #0d1b3e;
    font-size: 0.95rem;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
}

.exercise-name i {
    color: #1a2a6c;
}

.exercise-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px 12px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 3px 0;
}

.detail-label {
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 600;
}

.detail-value {
    font-size: 0.85rem;
    font-weight: 600;
    color: #0d1b3e;
}

.trainer-notes {
    margin-top: 10px;
    padding: 8px 12px;
    background: #fefce8;
    border-radius: 6px;
    border-left: 3px solid #f59e0b;
    font-size: 0.8rem;
    color: #78350f;
}

.trainer-notes i {
    color: #f59e0b;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .info-grid {
        grid-template-columns: 1fr 1fr;
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
    
    .exercise-details {
        grid-template-columns: 1fr 1fr;
    }
    
    .btn-back {
        padding: 6px 16px;
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .workout-detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .exercise-details {
        grid-template-columns: 1fr;
    }
    
    .exercise-body {
        padding: 12px 14px 14px;
    }
    
    .exercise-name {
        font-size: 0.9rem;
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

.exercise-card {
    animation: fadeInUp 0.4s ease forwards;
}

.exercise-card:nth-child(1) { animation-delay: 0.05s; }
.exercise-card:nth-child(2) { animation-delay: 0.1s; }
.exercise-card:nth-child(3) { animation-delay: 0.15s; }
.exercise-card:nth-child(4) { animation-delay: 0.2s; }
.exercise-card:nth-child(5) { animation-delay: 0.25s; }
.exercise-card:nth-child(6) { animation-delay: 0.3s; }
</style>
@endsection