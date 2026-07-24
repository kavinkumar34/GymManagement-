@extends('layouts.member-layout')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('member.diet.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back to Diet Plans
                </a>
            </div>

            <div class="diet-detail-main">
                <!-- Card Header - Matching Navbar Theme -->
                <div class="diet-detail-header">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <h4 class="mb-0">
                            <i class="fas fa-utensils me-2"></i> Diet Plan Details
                        </h4>
                        <span class="diet-status-badge {{ strtolower($diet->status) }}">
                            <i class="fas fa-circle me-1"></i>
                            {{ $diet->status }}
                        </span>
                    </div>
                </div>
                
                <div class="diet-detail-body">
                    <!-- Diet Info Section -->
                    <div class="diet-info-section">
                        <div class="info-grid">
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-apple-alt"></i></span>
                                <div>
                                    <span class="info-label">Diet Title</span>
                                    <span class="info-value">{{ $diet->title }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-bullseye"></i></span>
                                <div>
                                    <span class="info-label">Goal</span>
                                    <span class="info-value">{{ $diet->goal ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-user-tie"></i></span>
                                <div>
                                    <span class="info-label">Trainer</span>
                                    <span class="info-value">{{ $diet->trainer->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-calendar-alt"></i></span>
                                <div>
                                    <span class="info-label">Start Date</span>
                                    <span class="info-value">{{ \Carbon\Carbon::parse($diet->start_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-calendar-check"></i></span>
                                <div>
                                    <span class="info-label">End Date</span>
                                    <span class="info-value">{{ $diet->end_date ? \Carbon\Carbon::parse($diet->end_date)->format('d M Y') : 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="info-card">
                                <span class="info-icon"><i class="fas fa-utensils"></i></span>
                                <div>
                                    <span class="info-label">Total Meals</span>
                                    <span class="info-value">{{ $diet->meals->count() }} Meal(s)</span>
                                </div>
                            </div>
                        </div>

                        @if($diet->description)
                            <div class="diet-description-box">
                                <h6><i class="fas fa-align-left me-2"></i>Description</h6>
                                <p>{{ $diet->description }}</p>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <!-- Meal Schedule Section -->
                    <div class="meals-section">
                        <h5 class="section-title">
                            <i class="fas fa-clock me-2"></i> Meal Schedule
                        </h5>

                        @if($diet->meals->count())
                            <div class="table-responsive">
                                <table class="meal-table">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-calendar-day"></i> Day</th>
                                            <th><i class="fas fa-clock"></i> Meal Time</th>
                                            <th><i class="fas fa-apple-alt"></i> Food Name</th>
                                            <th><i class="fas fa-weight"></i> Quantity</th>
                                            <th><i class="fas fa-fire"></i> Calories</th>
                                            <th><i class="fas fa-dumbbell"></i> Protein</th>
                                            <th><i class="fas fa-bread-slice"></i> Carbs</th>
                                            <th><i class="fas fa-oil-can"></i> Fats</th>
                                            <th><i class="fas fa-sticky-note"></i> Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($diet->meals as $meal)
                                            <tr>
                                                <td>
                                                    <span class="meal-day">{{ $meal->day }}</span>
                                                </td>
                                                <td>
                                                    <span class="meal-time">{{ $meal->meal_time }}</span>
                                                </td>
                                                <td>
                                                    <span class="food-name">{{ $meal->food_name }}</span>
                                                </td>
                                                <td>{{ $meal->quantity ?? '-' }}</td>
                                                <td>
                                                    <span class="calorie-badge">{{ $meal->calories ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <span class="nutrition-value protein">{{ $meal->protein ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <span class="nutrition-value carbs">{{ $meal->carbs ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <span class="nutrition-value fats">{{ $meal->fats ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    @if($meal->notes)
                                                        <span class="meal-notes">{{ $meal->notes }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Meal Summary - FIXED with numeric extraction -->
                            @php
                                // Helper function to extract numeric value from string
                                function extractNumber($value) {
                                    if (is_null($value) || $value === '') {
                                        return 0;
                                    }
                                    // Remove all non-numeric characters except decimal point
                                    $numeric = preg_replace('/[^0-9.]/', '', $value);
                                    return is_numeric($numeric) ? (float)$numeric : 0;
                                }

                                $totalCalories = $diet->meals->sum(function($meal) {
                                    return extractNumber($meal->calories);
                                });
                                $totalProtein = $diet->meals->sum(function($meal) {
                                    return extractNumber($meal->protein);
                                });
                                $totalCarbs = $diet->meals->sum(function($meal) {
                                    return extractNumber($meal->carbs);
                                });
                                $totalFats = $diet->meals->sum(function($meal) {
                                    return extractNumber($meal->fats);
                                });
                            @endphp

                            <div class="meal-summary">
                                <div class="summary-item">
                                    <span class="summary-label">Total Meals:</span>
                                    <span class="summary-value">{{ $diet->meals->count() }}</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Total Calories:</span>
                                    <span class="summary-value">{{ number_format($totalCalories) }} kcal</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Total Protein:</span>
                                    <span class="summary-value">{{ number_format($totalProtein) }}g</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Total Carbs:</span>
                                    <span class="summary-value">{{ number_format($totalCarbs) }}g</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">Total Fats:</span>
                                    <span class="summary-value">{{ number_format($totalFats) }}g</span>
                                </div>
                            </div>
                        @else
                            <div class="empty-meals">
                                <i class="fas fa-utensils"></i>
                                <p>No meals added to this diet plan yet.</p>
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
.diet-detail-main {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(13, 27, 62, 0.08);
    overflow: hidden;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.diet-detail-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
    padding: 18px 24px;
    border-bottom: none;
}

.diet-detail-header h4 {
    font-weight: 600;
    font-size: 1.2rem;
}

.diet-detail-header h4 i {
    color: #ffd54f;
}

.diet-status-badge {
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.diet-status-badge.active {
    background: rgba(16, 185, 129, 0.2);
    color: #6ee7b7;
}

.diet-status-badge.completed {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.diet-status-badge.cancelled {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.diet-detail-body {
    padding: 24px;
}

/* ============================================ */
/* DIET INFO SECTION                            */
/* ============================================ */
.diet-info-section {
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

.info-icon i {
    color: #ffd54f;
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

/* ============================================ */
/* DESCRIPTION BOX                              */
/* ============================================ */
.diet-description-box {
    padding: 14px 18px;
    background: #f8fafc;
    border-radius: 10px;
    border-left: 4px solid #10b981;
}

.diet-description-box h6 {
    color: #0d1b3e;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 4px;
}

.diet-description-box h6 i {
    color: #10b981;
}

.diet-description-box p {
    color: #64748b;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.6;
}

/* ============================================ */
/* MEALS SECTION                                */
/* ============================================ */
.meals-section {
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
/* MEAL TABLE                                   */
/* ============================================ */
.meal-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13, 27, 62, 0.06);
}

.meal-table thead {
    background: linear-gradient(135deg, #0d1b3e 0%, #1a2a6c 100%);
    color: #ffffff;
}

.meal-table thead th {
    padding: 12px 14px;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meal-table thead th i {
    color: #ffd54f;
    margin-right: 4px;
}

.meal-table tbody tr {
    border-bottom: 1px solid rgba(13, 27, 62, 0.06);
    transition: background 0.2s ease;
}

.meal-table tbody tr:hover {
    background: #f8fafc;
}

.meal-table tbody td {
    padding: 10px 14px;
    color: #334155;
}

.meal-day {
    font-weight: 600;
    color: #0d1b3e;
}

.meal-time {
    font-weight: 500;
    color: #1a2a6c;
}

.food-name {
    font-weight: 500;
    color: #0d1b3e;
}

.calorie-badge {
    display: inline-block;
    padding: 2px 10px;
    background: #fef3c7;
    color: #92400e;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.8rem;
}

.nutrition-value {
    font-weight: 600;
}

.nutrition-value.protein {
    color: #10b981;
}

.nutrition-value.carbs {
    color: #3b82f6;
}

.nutrition-value.fats {
    color: #f59e0b;
}

.meal-notes {
    color: #64748b;
    font-size: 0.8rem;
}

/* ============================================ */
/* MEAL SUMMARY                                 */
/* ============================================ */
.meal-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 16px 30px;
    margin-top: 20px;
    padding: 16px 20px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid rgba(13, 27, 62, 0.06);
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.summary-label {
    font-size: 0.8rem;
    color: #94a3b8;
    font-weight: 500;
}

.summary-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0d1b3e;
}

/* ============================================ */
/* EMPTY MEALS                                  */
/* ============================================ */
.empty-meals {
    text-align: center;
    padding: 40px 20px;
    background: #f8fafc;
    border-radius: 10px;
    border: 2px dashed rgba(13, 27, 62, 0.08);
}

.empty-meals i {
    font-size: 3rem;
    color: #94a3b8;
    margin-bottom: 10px;
}

.empty-meals p {
    color: #94a3b8;
    margin: 0;
}

/* ============================================ */
/* RESPONSIVE                                   */
/* ============================================ */
@media (max-width: 992px) {
    .info-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .meal-table {
        font-size: 0.8rem;
    }
}

@media (max-width: 768px) {
    .diet-detail-header {
        padding: 14px 18px;
    }
    
    .diet-detail-header h4 {
        font-size: 1rem;
    }
    
    .diet-detail-body {
        padding: 16px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-card {
        padding: 10px 14px;
    }
    
    .meal-table {
        font-size: 0.75rem;
    }
    
    .meal-table thead th,
    .meal-table tbody td {
        padding: 8px 10px;
    }
    
    .btn-back {
        padding: 6px 16px;
        font-size: 0.85rem;
    }
    
    .meal-summary {
        gap: 10px 20px;
        padding: 12px 16px;
    }
}

@media (max-width: 480px) {
    .diet-detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .meal-table {
        font-size: 0.7rem;
    }
    
    .meal-table thead th,
    .meal-table tbody td {
        padding: 6px 8px;
    }
    
    .meal-table thead th i {
        display: none;
    }
    
    .summary-value {
        font-size: 0.85rem;
    }
    
    .meal-summary {
        gap: 8px 16px;
        padding: 10px 14px;
        flex-direction: column;
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

.diet-detail-main {
    animation: fadeInUp 0.5s ease forwards;
}
</style>
@endsection