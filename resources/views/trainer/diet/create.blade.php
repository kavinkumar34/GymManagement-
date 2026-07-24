@extends('layouts.trainer-layout')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4>
                <i class="fas fa-utensils"></i>
                Add Diet Plan
            </h4>

            <a href="{{ route('trainer.diet.index') }}"
                class="btn btn-secondary">

                Back

            </a>

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

            <form action="{{ route('trainer.diet.store') }}"
                method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label class="form-label">

                                Select Members

                            </label>

                            <div class="border rounded p-3"
                                style="height:220px;overflow-y:auto;">

                                @foreach($members as $member)

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="member_ids[]"
                                            value="{{ $member->id }}"
                                            id="member{{ $member->id }}">

                                        <label
                                            class="form-check-label"
                                            for="member{{ $member->id }}">

                                            {{ $member->name }}

                                            ({{ $member->member_id }})

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label>Diet Title</label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Goal</label>

                            <select
                                name="goal"
                                class="form-control">

                                <option value="">Select Goal</option>

                                <option value="Weight Loss">
                                    Weight Loss
                                </option>

                                <option value="Muscle Gain">
                                    Muscle Gain
                                </option>

                                <option value="Fat Loss">
                                    Fat Loss
                                </option>

                                <option value="Fitness">
                                    Fitness
                                </option>

                                <option value="Body Building">
                                    Body Building
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label>Start Date</label>

                            <input
                                type="date"
                                name="start_date"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-3">

                            <label>End Date</label>

                            <input
                                type="date"
                                name="end_date"
                                class="form-control">

                        </div>

                    </div>

                </div>

                <div class="mb-4">

                    <label>Description</label>

                    <textarea
                        name="description"
                        rows="3"
                        class="form-control"></textarea>

                </div>

                <hr>

                <h5>Meal Schedule</h5>

                <div id="meal-container">

                                    <div class="meal-row card p-3 mb-3">

                        <div class="row">

                            <div class="col-md-3">

                                <div class="mb-3">

                                    <label>Day</label>

                                    <select
                                        name="meals[0][day]"
                                        class="form-control">

                                        <option>Monday</option>
                                        <option>Tuesday</option>
                                        <option>Wednesday</option>
                                        <option>Thursday</option>
                                        <option>Friday</option>
                                        <option>Saturday</option>
                                        <option>Sunday</option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="mb-3">

                                    <label>Meal Time</label>

                                    <select
                                        name="meals[0][meal_time]"
                                        class="form-control">

                                        <option>Early Morning</option>
                                        <option>Breakfast</option>
                                        <option>Mid Morning</option>
                                        <option>Lunch</option>
                                        <option>Evening Snack</option>
                                        <option>Dinner</option>
                                        <option>Before Bed</option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label>Food Name</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="meals[0][food_name]"
                                        placeholder="Example: Oats, Egg, Chicken Breast"
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
                                        name="meals[0][quantity]"
                                        placeholder="100 g">

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="mb-3">

                                    <label>Calories</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="meals[0][calories]"
                                        placeholder="250 kcal">

                                </div>

                            </div>

                            <div class="col-md-2">

                                <div class="mb-3">

                                    <label>Protein</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="meals[0][protein]"
                                        placeholder="25 g">

                                </div>

                            </div>

                            <div class="col-md-2">

                                <div class="mb-3">

                                    <label>Carbs</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="meals[0][carbs]"
                                        placeholder="30 g">

                                </div>

                            </div>

                            <div class="col-md-2">

                                <div class="mb-3">

                                    <label>Fats</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="meals[0][fats]"
                                        placeholder="10 g">

                                </div>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label>Notes</label>

                            <textarea
                                name="meals[0][notes]"
                                class="form-control"
                                rows="3"
                                placeholder="Additional instructions..."></textarea>

                        </div>

                        <button
                            type="button"
                            class="btn btn-danger btn-sm remove-meal">

                            <i class="fas fa-trash"></i>

                            Remove Meal

                        </button>

                    </div>

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

        Save Diet Plan

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

let mealIndex = 1;

function addMeal()
{

let html = `
<div class="meal-row card p-3 mb-3">

<div class="row">

<div class="col-md-3">

<div class="mb-3">

<label>Day</label>

<select name="meals[${mealIndex}][day]" class="form-control">

<option>Monday</option>
<option>Tuesday</option>
<option>Wednesday</option>
<option>Thursday</option>
<option>Friday</option>
<option>Saturday</option>
<option>Sunday</option>

</select>

</div>

</div>

<div class="col-md-3">

<div class="mb-3">

<label>Meal Time</label>

<select name="meals[${mealIndex}][meal_time]" class="form-control">

<option>Early Morning</option>
<option>Breakfast</option>
<option>Mid Morning</option>
<option>Lunch</option>
<option>Evening Snack</option>
<option>Dinner</option>
<option>Before Bed</option>

</select>

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Food Name</label>

<input
type="text"
class="form-control"
name="meals[${mealIndex}][food_name]"
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
name="meals[${mealIndex}][quantity]">

</div>

</div>

<div class="col-md-3">

<div class="mb-3">

<label>Calories</label>

<input
type="text"
class="form-control"
name="meals[${mealIndex}][calories]">

</div>

</div>

<div class="col-md-2">

<div class="mb-3">

<label>Protein</label>

<input
type="text"
class="form-control"
name="meals[${mealIndex}][protein]">

</div>

</div>

<div class="col-md-2">

<div class="mb-3">

<label>Carbs</label>

<input
type="text"
class="form-control"
name="meals[${mealIndex}][carbs]">

</div>

</div>

<div class="col-md-2">

<div class="mb-3">

<label>Fats</label>

<input
type="text"
class="form-control"
name="meals[${mealIndex}][fats]">

</div>

</div>

</div>

<div class="mb-3">

<label>Notes</label>

<textarea
class="form-control"
rows="3"
name="meals[${mealIndex}][notes]"></textarea>

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