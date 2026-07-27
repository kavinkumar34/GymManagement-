@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i> Diet Plan Details
                    </h4>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-utensils me-1"></i> {{ $diet->title }}
                        </span>
                        <a href="{{ route('trainer.diet.edit', $diet->id) }}" 
                           class="btn btn-sm" 
                           style="background: #ffd54f; color: #0d2818; border-radius: 8px;">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('trainer.diet.index') }}" 
                           class="btn btn-sm" 
                           style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Diet Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Member</small>
                            <strong>{{ $diet->member->name ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Member ID</small>
                            <strong>{{ $diet->member->member_id ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Diet Title</small>
                            <strong>{{ $diet->title }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Goal</small>
                            <strong>{{ $diet->goal ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Start Date</small>
                            <strong>{{ date('d M Y', strtotime($diet->start_date)) }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">End Date</small>
                            <strong>{{ $diet->end_date ? date('d M Y', strtotime($diet->end_date)) : '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Status</small>
                            <strong>
                                @if($diet->status == 'Active')
                                    <span class="badge" style="background: #10b981; color: white; padding: 5px 15px;">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Active
                                    </span>
                                @elseif($diet->status == 'Completed')
                                    <span class="badge" style="background: #3b82f6; color: white; padding: 5px 15px;">
                                        <i class="fas fa-check-circle me-1"></i> Completed
                                    </span>
                                @else
                                    <span class="badge" style="background: #ef4444; color: white; padding: 5px 15px;">
                                        <i class="fas fa-times-circle me-1"></i> Cancelled
                                    </span>
                                @endif
                            </strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item" style="background: #f8fafc; padding: 12px 15px; border-radius: 10px; border-left: 3px solid #1a472a;">
                            <small class="text-muted d-block">Description</small>
                            <strong>{{ $diet->description ?: 'No description available.' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Meals Section -->
                <div class="card" style="border-color: #1a472a;">
                    <div class="card-header" style="background: #0d2818; color: white;">
                        <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Meal Schedule</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $groupedByDay = [];
                            foreach($diet->meals as $meal) {
                                $groupedByDay[$meal->day][] = $meal;
                            }
                            
                            function extractNumber($value) {
                                if (is_null($value) || $value === '') return 0;
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

                        @if(count($diet->meals) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle" style="font-size: 0.9rem;">
                                    <thead style="background: #1a472a; color: white;">
                                        <tr>
                                            <th><i class="fas fa-calendar-day me-1"></i> Day</th>
                                            <th><i class="fas fa-clock me-1"></i> Meal Time</th>
                                            <th><i class="fas fa-apple-alt me-1"></i> Food Name</th>
                                            <th><i class="fas fa-weight me-1"></i> Qty</th>
                                            <th><i class="fas fa-fire me-1"></i> Calories</th>
                                            <th><i class="fas fa-dumbbell me-1"></i> Protein</th>
                                            <th><i class="fas fa-bread-slice me-1"></i> Carbs</th>
                                            <th><i class="fas fa-oil-can me-1"></i> Fats</th>
                                            <th><i class="fas fa-sticky-note me-1"></i> Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groupedByDay as $day => $meals)
                                            @php $dayCount = count($meals); @endphp
                                            @foreach($meals as $index => $meal)
                                                <tr>
                                                    @if($index === 0)
                                                        <td class="day-merged" rowspan="{{ $dayCount }}" style="background: #f8fafc; text-align: center; vertical-align: middle; font-weight: 600;">
                                                            {{ $day }}
                                                            <br>
                                                            <span class="badge" style="background: #1a472a; color: white;">{{ $dayCount }}</span>
                                                        </td>
                                                    @endif
                                                    <td>{{ $meal->meal_time }}</td>
                                                    <td><strong>{{ $meal->food_name }}</strong></td>
                                                    <td>{{ $meal->quantity ?? '-' }}</td>
                                                    <td>{{ $meal->calories ?? '-' }}</td>
                                                    <td>{{ $meal->protein ?? '-' }}</td>
                                                    <td>{{ $meal->carbs ?? '-' }}</td>
                                                    <td>{{ $meal->fats ?? '-' }}</td>
                                                    <td>{{ $meal->notes ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert" style="background: rgba(13,40,24,0.05); border-left: 4px solid #1a472a; border-radius: 10px;">
                                        <strong><i class="fas fa-chart-bar me-2" style="color: #1a472a;"></i>Nutrition Summary:</strong>
                                        <span class="ms-3">Total Items: <strong>{{ $diet->meals->count() }}</strong></span>
                                        <span class="ms-3">Total Calories: <strong>{{ number_format($totalCalories) }} kcal</strong></span>
                                        <span class="ms-3">Total Protein: <strong>{{ number_format($totalProtein) }}g</strong></span>
                                        <span class="ms-3">Total Carbs: <strong>{{ number_format($totalCarbs) }}g</strong></span>
                                        <span class="ms-3">Total Fats: <strong>{{ number_format($totalFats) }}g</strong></span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning text-center" style="border-radius: 10px;">
                                <i class="fas fa-info-circle me-2"></i> No meals added for this diet plan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-item {
        transition: all 0.3s ease;
    }
    .info-item:hover {
        background: #e9ecef !important;
        transform: translateX(5px);
    }
    
    .day-merged {
        background: #f8f9fa;
        border-right: 2px solid #dee2e6;
        text-align: center;
        vertical-align: middle !important;
        font-weight: 600;
        min-width: 100px;
    }
    
    .table-hover tbody tr:hover {
        background: rgba(13, 40, 24, 0.03);
    }
    
    @media (max-width: 768px) {
        .card-header .d-flex { flex-direction: column; gap: 10px; align-items: flex-start !important; }
        .table { font-size: 0.8rem; }
        .table thead th i { display: none; }
        .table thead th, .table tbody td { padding: 6px 8px; }
        .day-merged { min-width: 60px; font-size: 0.85rem; }
        .info-item { padding: 8px 12px !important; }
    }
    
    @media (max-width: 576px) {
        .table { font-size: 0.7rem; }
        .table thead th, .table tbody td { padding: 4px 6px; }
        .badge { font-size: 0.6rem; }
        .info-item strong { font-size: 0.85rem; }
        .info-item small { font-size: 0.65rem; }
        .day-merged { min-width: 50px; font-size: 0.75rem; }
    }
</style>

@endsection