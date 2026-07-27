@extends('layouts.trainer-layout')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Card Header - Green Theme -->
            <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Edit Diet Plan
                    </h4>
                    <a href="{{ route('trainer.diet.index') }}" 
                       class="btn" 
                       style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 20px;">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('trainer.diet.update', $diet->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-1" style="color: #1a472a;"></i> Member <span class="text-danger">*</span>
                                </label>
                                <select name="member_id" class="form-control" style="border-color: #1a472a; border-radius: 8px;" required>
                                    <option value="">Select Member</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ $diet->member_id == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-heading me-1" style="color: #1a472a;"></i> Diet Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" class="form-control" style="border-color: #1a472a; border-radius: 8px;" value="{{ old('title', $diet->title) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-bullseye me-1" style="color: #1a472a;"></i> Goal
                                </label>
                                <select name="goal" class="form-control" style="border-color: #1a472a; border-radius: 8px;">
                                    <option value="">Select Goal</option>
                                    <option value="Weight Loss" {{ $diet->goal == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                                    <option value="Weight Gain" {{ $diet->goal == 'Weight Gain' ? 'selected' : '' }}>Weight Gain</option>
                                    <option value="Muscle Gain" {{ $diet->goal == 'Muscle Gain' ? 'selected' : '' }}>Muscle Gain</option>
                                    <option value="Maintain Fitness" {{ $diet->goal == 'Maintain Fitness' ? 'selected' : '' }}>Maintain Fitness</option>
                                    <option value="Fat Loss" {{ $diet->goal == 'Fat Loss' ? 'selected' : '' }}>Fat Loss</option>
                                    <option value="Body Building" {{ $diet->goal == 'Body Building' ? 'selected' : '' }}>Body Building</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1" style="color: #1a472a;"></i> Start Date
                                </label>
                                <input type="date" name="start_date" class="form-control" style="border-color: #1a472a; border-radius: 8px;" value="{{ old('start_date', $diet->start_date) }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1" style="color: #1a472a;"></i> End Date
                                </label>
                                <input type="date" name="end_date" class="form-control" style="border-color: #1a472a; border-radius: 8px;" value="{{ old('end_date', $diet->end_date) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-align-left me-1" style="color: #1a472a;"></i> Description
                        </label>
                        <textarea name="description" rows="3" class="form-control" style="border-color: #1a472a; border-radius: 8px;" placeholder="Enter diet description...">{{ old('description', $diet->description) }}</textarea>
                    </div>

                    <hr style="border-color: #1a472a;">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0" style="color: #0d2818;">
                            <i class="fas fa-utensils me-2"></i> Meal Schedule
                        </h5>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i> Each meal group = Day + Meal Time
                        </small>
                    </div>

                    <!-- Meal Container -->
                    <div id="meal-container">
                        @php
                            $groupedMeals = [];
                            foreach($diet->meals as $meal) {
                                $key = $meal->day . '|' . $meal->meal_time;
                                if (!isset($groupedMeals[$key])) {
                                    $groupedMeals[$key] = [
                                        'day' => $meal->day,
                                        'meal_time' => $meal->meal_time,
                                        'items' => []
                                    ];
                                }
                                $groupedMeals[$key]['items'][] = $meal;
                            }
                            $mealIndex = 0;
                        @endphp

                        @foreach($groupedMeals as $groupKey => $group)
                            <div class="meal-group card border mb-4" style="border-color: #1a472a !important;">
                                <div class="card-header" style="background: #f8fafc; border-bottom-color: #1a472a;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="color: #0d2818;">
                                            <span class="badge" style="background: #0d2818; color: white;">#{{ $loop->iteration }}</span>
                                            <span class="fw-bold ms-2">Meal Group</span>
                                        </span>
                                        <button type="button" class="btn btn-danger btn-sm remove-meal">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" style="color: #1a472a;">Day <span class="text-danger">*</span></label>
                                            <select name="meals[{{ $mealIndex }}][day]" class="form-control meal-day" style="border-color: #1a472a; border-radius: 8px;" required>
                                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                    <option value="{{ $day }}" {{ $group['day'] == $day ? 'selected' : '' }}>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" style="color: #1a472a;">Meal Time <span class="text-danger">*</span></label>
                                            <select name="meals[{{ $mealIndex }}][meal_time]" class="form-control meal-time" style="border-color: #1a472a; border-radius: 8px;" required>
                                                @foreach(['Early Morning', 'Breakfast', 'Mid Morning', 'Lunch', 'Evening Snack', 'Dinner', 'Before Bed'] as $time)
                                                    <option value="{{ $time }}" {{ $group['meal_time'] == $time ? 'selected' : '' }}>
                                                        @if($time == 'Early Morning') 🌅 @endif
                                                        @if($time == 'Breakfast') 🍳 @endif
                                                        @if($time == 'Mid Morning') ☕ @endif
                                                        @if($time == 'Lunch') 🍱 @endif
                                                        @if($time == 'Evening Snack') 🍪 @endif
                                                        @if($time == 'Dinner') 🍽️ @endif
                                                        @if($time == 'Before Bed') 🌙 @endif
                                                        {{ $time }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="alert alert-info py-1 mb-3" style="border-radius: 8px;">
                                        <small>
                                            <i class="fas fa-clock me-1"></i> 
                                            Current: <span class="meal-display fw-bold">{{ $group['day'] }} - {{ $group['meal_time'] }}</span>
                                        </small>
                                    </div>

                                    <div class="food-items-container border rounded p-3" style="border-color: #1a472a !important;">
                                        <label class="form-label fw-bold" style="color: #1a472a;">Food Items <span class="text-danger">*</span></label>
                                        <small class="text-muted">(Add at least one food item)</small>
                                        
                                        @foreach($group['items'] as $itemIndex => $foodItem)
                                            <div class="food-item-row row mb-2 align-items-center">
                                                <div class="col-md-3 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][food_name]" placeholder="Food Name *" value="{{ $foodItem->food_name }}" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][quantity]" placeholder="Qty" value="{{ $foodItem->quantity }}">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][calories]" placeholder="Calories" value="{{ $foodItem->calories }}">
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][protein]" placeholder="Protein" value="{{ $foodItem->protein }}">
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][carbs]" placeholder="Carbs" value="{{ $foodItem->carbs }}">
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][fats]" placeholder="Fats" value="{{ $foodItem->fats }}">
                                                </div>
                                                <div class="col-md-1 mb-2">
                                                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[{{ $mealIndex }}][food_items][{{ $itemIndex }}][notes]" placeholder="Notes" value="{{ $foodItem->notes }}">
                                                </div>
                                                <div class="col-md-1 mb-2 text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-food-item" title="Remove this food item">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Add Food Item Button - Right Side -->
                                    <div class="mt-2 text-end">
                                        <button type="button" class="btn btn-success btn-sm add-food-item">
                                            <i class="fas fa-plus me-1"></i> Add Food Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @php $mealIndex++; @endphp
                        @endforeach
                    </div>

                    <!-- Add Another Meal Group Button - Above Save/Cancel -->
                    <div class="mt-3 text-end">
                        <button type="button" class="btn" style="background: #0d2818; color: white; border-radius: 8px; padding: 5px 15px;" onclick="addMeal()">
                            <i class="fas fa-plus-circle me-1"></i> Add Another Meal Group
                        </button>
                    </div>

                    <!-- Save and Cancel Buttons -->
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn" style="background: #0d2818; color: white; border-radius: 8px; padding: 10px 30px;">
                            <i class="fas fa-save me-2"></i> Update Diet Plan
                        </button>
                        <a href="{{ route('trainer.diet.index') }}" class="btn btn-secondary" style="border-radius: 8px; padding: 10px 30px;">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let mealIndex = {{ $mealIndex }};

function addMeal() {
    let html = `
        <div class="meal-group card border mb-4" style="border-color: #1a472a !important;">
            <div class="card-header" style="background: #f8fafc; border-bottom-color: #1a472a;">
                <div class="d-flex justify-content-between align-items-center">
                    <span style="color: #0d2818;">
                        <span class="badge" style="background: #0d2818; color: white;">#${mealIndex + 1}</span>
                        <span class="fw-bold ms-2">Meal Group</span>
                    </span>
                    <button type="button" class="btn btn-danger btn-sm remove-meal">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="color: #1a472a;">Day <span class="text-danger">*</span></label>
                        <select name="meals[${mealIndex}][day]" class="form-control meal-day" style="border-color: #1a472a; border-radius: 8px;" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="color: #1a472a;">Meal Time <span class="text-danger">*</span></label>
                        <select name="meals[${mealIndex}][meal_time]" class="form-control meal-time" style="border-color: #1a472a; border-radius: 8px;" required>
                            <option value="Early Morning">🌅 Early Morning</option>
                            <option value="Breakfast">🍳 Breakfast</option>
                            <option value="Mid Morning">☕ Mid Morning</option>
                            <option value="Lunch">🍱 Lunch</option>
                            <option value="Evening Snack">🍪 Evening Snack</option>
                            <option value="Dinner">🍽️ Dinner</option>
                            <option value="Before Bed">🌙 Before Bed</option>
                        </select>
                    </div>
                </div>

                <div class="alert alert-info py-1 mb-3" style="border-radius: 8px;">
                    <small>
                        <i class="fas fa-clock me-1"></i> 
                        Current: <span class="meal-display fw-bold">Monday - Breakfast</span>
                    </small>
                </div>

                <div class="food-items-container border rounded p-3" style="border-color: #1a472a !important;">
                    <label class="form-label fw-bold" style="color: #1a472a;">Food Items <span class="text-danger">*</span></label>
                    <small class="text-muted">(Add at least one food item)</small>
                    
                    <div class="food-item-row row mb-2 align-items-center">
                        <div class="col-md-3 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][food_name]" placeholder="Food Name *" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][quantity]" placeholder="Qty">
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][calories]" placeholder="Calories">
                        </div>
                        <div class="col-md-1 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][protein]" placeholder="Protein">
                        </div>
                        <div class="col-md-1 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][carbs]" placeholder="Carbs">
                        </div>
                        <div class="col-md-1 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][fats]" placeholder="Fats">
                        </div>
                        <div class="col-md-1 mb-2">
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIndex}][food_items][0][notes]" placeholder="Notes">
                        </div>
                        <div class="col-md-1 mb-2 text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-food-item" title="Remove this food item">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add Food Item Button - Right Side -->
                <div class="mt-2 text-end">
                    <button type="button" class="btn btn-success btn-sm add-food-item">
                        <i class="fas fa-plus me-1"></i> Add Food Item
                    </button>
                </div>
            </div>
        </div>
    `;

    document.getElementById('meal-container').insertAdjacentHTML('beforeend', html);
    mealIndex++;
    updateMealDisplay();
}

function updateMealDisplay() {
    document.querySelectorAll('.meal-group').forEach(function(group) {
        const daySelect = group.querySelector('.meal-day');
        const timeSelect = group.querySelector('.meal-time');
        const display = group.querySelector('.meal-display');
        
        if (daySelect && timeSelect && display) {
            const day = daySelect.options[daySelect.selectedIndex].text;
            const time = timeSelect.options[timeSelect.selectedIndex].text;
            display.textContent = day + ' - ' + time;
        }
    });
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-meal') || e.target.closest('.remove-meal')) {
        const mealGroups = document.querySelectorAll('.meal-group');
        if (mealGroups.length > 1) {
            e.target.closest('.meal-group').remove();
            updateMealDisplay();
        } else {
            alert('You need at least one meal group!');
        }
        return;
    }

    if (e.target.classList.contains('remove-food-item') || e.target.closest('.remove-food-item')) {
        const mealGroup = e.target.closest('.meal-group');
        const container = mealGroup.querySelector('.food-items-container');
        const foodItems = container.querySelectorAll('.food-item-row');
        
        if (foodItems.length > 1) {
            e.target.closest('.food-item-row').remove();
        } else {
            alert('You need at least one food item per meal!');
        }
        return;
    }

    if (e.target.classList.contains('add-food-item') || e.target.closest('.add-food-item')) {
        const mealGroup = e.target.closest('.meal-group');
        const container = mealGroup.querySelector('.food-items-container');
        const itemsCount = container.querySelectorAll('.food-item-row').length;
        
        const nameAttr = container.querySelector('input')?.getAttribute('name') || '';
        const match = nameAttr.match(/meals\[(\d+)\]/);
        const mealIdx = match ? match[1] : '0';

        const foodHtml = `
            <div class="food-item-row row mb-2 align-items-center">
                <div class="col-md-3 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][food_name]" placeholder="Food Name *" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][quantity]" placeholder="Qty">
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][calories]" placeholder="Calories">
                </div>
                <div class="col-md-1 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][protein]" placeholder="Protein">
                </div>
                <div class="col-md-1 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][carbs]" placeholder="Carbs">
                </div>
                <div class="col-md-1 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][fats]" placeholder="Fats">
                </div>
                <div class="col-md-1 mb-2">
                    <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;" name="meals[${mealIdx}][food_items][${itemsCount}][notes]" placeholder="Notes">
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-food-item" title="Remove this food item">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', foodHtml);
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('meal-day') || e.target.classList.contains('meal-time')) {
        updateMealDisplay();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    updateMealDisplay();
});
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d2818 !important;
        box-shadow: 0 0 0 0.2rem rgba(13,40,24,0.15) !important;
    }
    @media (max-width: 768px) {
        .card-header .d-flex { flex-direction: column; gap: 10px; align-items: flex-start !important; }
        .btn { width: 100%; justify-content: center; }
        .food-item-row .col-md-3, .food-item-row .col-md-2, .food-item-row .col-md-1 { margin-bottom: 8px; }
        .text-end { text-align: center !important; }
    }
    @media (max-width: 576px) {
        .form-control, .form-select { font-size: 0.85rem; }
        .card-header h4 { font-size: 1.1rem; }
    }
</style>

@endsection