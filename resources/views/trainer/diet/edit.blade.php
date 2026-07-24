@extends('layouts.trainer-layout')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>
                <i class="fas fa-edit"></i>
                Edit Diet Plan
            </h4>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('trainer.diet.update',$diet->id) }}" method="POST">

                @csrf

                @method('PUT')

                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">
                                Member
                            </label>

                            <select
                                name="member_id"
                                class="form-control"
                                required>

                                <option value="">Select Member</option>

                                @foreach($members as $member)

                                    <option
                                        value="{{ $member->id }}"
                                        {{ $diet->member_id==$member->id ? 'selected':'' }}>

                                        {{ $member->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">
                                Diet Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ old('title',$diet->title) }}"
                                required>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label>
                                Goal
                            </label>

                            <select
                                name="goal"
                                class="form-control">

                                <option value="Weight Loss" {{ $diet->goal=='Weight Loss'?'selected':'' }}>
                                    Weight Loss
                                </option>

                                <option value="Weight Gain" {{ $diet->goal=='Weight Gain'?'selected':'' }}>
                                    Weight Gain
                                </option>

                                <option value="Muscle Gain" {{ $diet->goal=='Muscle Gain'?'selected':'' }}>
                                    Muscle Gain
                                </option>

                                <option value="Maintain Fitness" {{ $diet->goal=='Maintain Fitness'?'selected':'' }}>
                                    Maintain Fitness
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">

                            <label>
                                Start Date
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                class="form-control"
                                value="{{ old('start_date',$diet->start_date) }}"
                                required>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">

                            <label>
                                End Date
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                class="form-control"
                                value="{{ old('end_date',$diet->end_date) }}">

                        </div>

                    </div>

                </div>

                <div class="mb-3">

                    <label>
                        Description
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="3">{{ old('description',$diet->description) }}</textarea>

                </div>

                <hr>

                <h5>

                    Meal Schedule

                </h5>

                <div id="meal-container">

                @foreach($diet->meals as $index => $meal)

<div class="meal-row card p-3 mb-3">

    <div class="row">

        <div class="col-md-3">

            <div class="mb-3">

                <label>Day</label>

                <select
                    name="meals[{{ $index }}][day]"
                    class="form-control">

                    <option value="Monday" {{ $meal->day=='Monday'?'selected':'' }}>Monday</option>
                    <option value="Tuesday" {{ $meal->day=='Tuesday'?'selected':'' }}>Tuesday</option>
                    <option value="Wednesday" {{ $meal->day=='Wednesday'?'selected':'' }}>Wednesday</option>
                    <option value="Thursday" {{ $meal->day=='Thursday'?'selected':'' }}>Thursday</option>
                    <option value="Friday" {{ $meal->day=='Friday'?'selected':'' }}>Friday</option>
                    <option value="Saturday" {{ $meal->day=='Saturday'?'selected':'' }}>Saturday</option>
                    <option value="Sunday" {{ $meal->day=='Sunday'?'selected':'' }}>Sunday</option>

                </select>

            </div>

        </div>

        <div class="col-md-3">

            <div class="mb-3">

                <label>Meal Time</label>

                <select
                    name="meals[{{ $index }}][meal_time]"
                    class="form-control">

                    <option value="Early Morning" {{ $meal->meal_time=='Early Morning'?'selected':'' }}>Early Morning</option>
                    <option value="Breakfast" {{ $meal->meal_time=='Breakfast'?'selected':'' }}>Breakfast</option>
                    <option value="Mid Morning" {{ $meal->meal_time=='Mid Morning'?'selected':'' }}>Mid Morning</option>
                    <option value="Lunch" {{ $meal->meal_time=='Lunch'?'selected':'' }}>Lunch</option>
                    <option value="Evening Snack" {{ $meal->meal_time=='Evening Snack'?'selected':'' }}>Evening Snack</option>
                    <option value="Dinner" {{ $meal->meal_time=='Dinner'?'selected':'' }}>Dinner</option>
                    <option value="Before Bed" {{ $meal->meal_time=='Before Bed'?'selected':'' }}>Before Bed</option>

                </select>

            </div>

        </div>

        <div class="col-md-6">

            <div class="mb-3">

                <label>Food Name</label>

                <input
                    type="text"
                    class="form-control"
                    name="meals[{{ $index }}][food_name]"
                    value="{{ $meal->food_name }}"
                    required>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-3">

            <div class="mb-3">

                <label>Quantity</label>

                <input
                    type="text"
                    class="form-control"
                    name="meals[{{ $index }}][quantity]"
                    value="{{ $meal->quantity }}">

            </div>

        </div>

        <div class="col-md-3">

            <div class="mb-3">

                <label>Calories</label>

                <input
                    type="text"
                    class="form-control"
                    name="meals[{{ $index }}][calories]"
                    value="{{ $meal->calories }}">

            </div>

        </div>

        <div class="col-md-2">

            <div class="mb-3">

                <label>Protein</label>

                <input
                    type="text"
                    class="form-control"
                    name="meals[{{ $index }}][protein]"
                    value="{{ $meal->protein }}">

            </div>

        </div>

        <div class="col-md-2">

            <div class="mb-3">

                <label>Carbs</label>

                <input
                    type="text"
                    class="form-control"
                    name="meals[{{ $index }}][carbs]"
                    value="{{ $meal->carbs }}">

            </div>

        </div>

        <div class="col-md-2">

            <div class="mb-3">

                <label>Fats</label>

                <input
                    type="text"
                    class="form-control"
                    name="meals[{{ $index }}][fats]"
                    value="{{ $meal->fats }}">

            </div>

        </div>

    </div>

    <div class="mb-3">

        <label>Notes</label>

        <textarea
            class="form-control"
            rows="3"
            name="meals[{{ $index }}][notes]">{{ $meal->notes }}</textarea>

    </div>

    <button
        type="button"
        class="btn btn-danger btn-sm remove-meal">

        <i class="fas fa-trash"></i>

        Remove Meal

    </button>

</div>

@endforeach
                </div>

                <div class="mt-3">

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="addMeal()">

                        <i class="fas fa-plus"></i>

                        Add Meal

                    </button>

                </div>

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="fas fa-save"></i>

                        Update Diet Plan

                    </button>

                    <a href="{{ route('trainer.diet.index') }}"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

let mealIndex = {{ count($diet->meals) }};

function addMeal()
{

let html = `

<div class="meal-row card p-3 mb-3">

<div class="row">

<div class="col-md-3">

<div class="mb-3">

<label>Day</label>

<select
name="meals[${mealIndex}][day]"
class="form-control">

<option value="Monday">Monday</option>
<option value="Tuesday">Tuesday</option>
<option value="Wednesday">Wednesday</option>
<option value="Thursday">Thursday</option>
<option value="Friday">Friday</option>
<option value="Saturday">Saturday</option>
<option value="Sunday">Sunday</option>

</select>

</div>

</div>

<div class="col-md-3">

<div class="mb-3">

<label>Meal Time</label>

<select
name="meals[${mealIndex}][meal_time]"
class="form-control">

<option value="Early Morning">Early Morning</option>
<option value="Breakfast">Breakfast</option>
<option value="Mid Morning">Mid Morning</option>
<option value="Lunch">Lunch</option>
<option value="Evening Snack">Evening Snack</option>
<option value="Dinner">Dinner</option>
<option value="Before Bed">Before Bed</option>

</select>

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Food Name</label>

<input
type="text"
name="meals[${mealIndex}][food_name]"
class="form-control"
required>

</div>

</div>

</div>

<div class="row">

<div class="col-md-3">

<div class="mb-3">

<label>Quantity</label>

<input
type="text"
name="meals[${mealIndex}][quantity]"
class="form-control">

</div>

</div>

<div class="col-md-3">

<div class="mb-3">

<label>Calories</label>

<input
type="text"
name="meals[${mealIndex}][calories]"
class="form-control">

</div>

</div>

<div class="col-md-2">

<div class="mb-3">

<label>Protein</label>

<input
type="text"
name="meals[${mealIndex}][protein]"
class="form-control">

</div>

</div>

<div class="col-md-2">

<div class="mb-3">

<label>Carbs</label>

<input
type="text"
name="meals[${mealIndex}][carbs]"
class="form-control">

</div>

</div>

<div class="col-md-2">

<div class="mb-3">

<label>Fats</label>

<input
type="text"
name="meals[${mealIndex}][fats]"
class="form-control">

</div>

</div>

</div>

<div class="mb-3">

<label>Notes</label>

<textarea
name="meals[${mealIndex}][notes]"
class="form-control"
rows="3"></textarea>

</div>

<button
type="button"
class="btn btn-danger btn-sm remove-meal">

<i class="fas fa-trash"></i>

Remove Meal

</button>

</div>

`;

document.getElementById('meal-container').insertAdjacentHTML('beforeend', html);

mealIndex++;

}

document.addEventListener('click', function(e){

if(e.target.classList.contains('remove-meal') ||
e.target.closest('.remove-meal'))
{
    e.target.closest('.meal-row').remove();
}

});

</script>

@endsection