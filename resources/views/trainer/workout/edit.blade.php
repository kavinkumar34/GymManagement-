@extends('layouts.trainer-layout')

@section('content')

    <div class="container">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h4>Edit Workout Plan</h4>

                <a href="{{ route('trainer.workout.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('trainer.workout.update', $workout->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Member
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="member_id" class="form-control" required>

                                    <option value="">
                                        Select Member
                                    </option>

                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ $workout->member_id == $member->id ? 'selected' : '' }}>

                                            {{ $member->name }}
                                            ({{ $member->email }})
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Workout Title
                                </label>

                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $workout->title) }}" required>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    Start Date
                                </label>

                                <input type="date" name="start_date" class="form-control"
                                    value="{{ $workout->start_date }}" required>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label>
                                    End Date
                                </label>

                                <input type="date" name="end_date" class="form-control" value="{{ $workout->end_date }}">

                            </div>

                        </div>

                    </div>

                    <div class="form-group mb-4">

                        <label>Description</label>

                        <textarea name="description" rows="3" class="form-control">{{ old('description', $workout->description) }}</textarea>

                    </div>

                    <hr>

                    <h5 class="mb-3">
                        Exercises
                    </h5>

                    <div id="exercises-container">

                        @foreach ($workout->exercises as $index => $exercise)
                            <div class="exercise-row card p-3 mb-3">

                                <div class="row">

                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>Day</label>

                                            <select name="exercises[{{ $index }}][day]" class="form-control">

                                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                    <option value="{{ $day }}"
                                                        {{ $exercise->day == $day ? 'selected' : '' }}>

                                                        {{ $day }}

                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>Exercise Name</label>

                                            <input type="text" class="form-control"
                                                name="exercises[{{ $index }}][exercise_name]"
                                                value="{{ $exercise->exercise_name }}">

                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">

                                            <label>Sets</label>

                                            <input type="number" class="form-control"
                                                name="exercises[{{ $index }}][sets]" value="{{ $exercise->sets }}">

                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">

                                            <label>Reps</label>

                                            <input type="text" class="form-control"
                                                name="exercises[{{ $index }}][reps]" value="{{ $exercise->reps }}">

                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">

                                            <label>Weight</label>

                                            <input type="text" class="form-control"
                                                name="exercises[{{ $index }}][weight]"
                                                value="{{ $exercise->weight }}">

                                        </div>

                                    </div>

                                </div>
                                <div class="row mt-3">

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>Rest Time</label>

                                            <input type="text" class="form-control"
                                                name="exercises[{{ $index }}][rest_time]"
                                                value="{{ $exercise->rest_time }}">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>Exercise Image URL</label>

                                            <input type="text" class="form-control"
                                                name="exercises[{{ $index }}][exercise_image]"
                                                value="{{ $exercise->exercise_image }}">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>Exercise Video URL</label>

                                            <input type="text" class="form-control"
                                                name="exercises[{{ $index }}][exercise_video]"
                                                value="{{ $exercise->exercise_video }}">

                                        </div>

                                    </div>

                                </div>

                                <div class="mt-3">

                                    <label>Trainer Notes</label>

                                    <textarea class="form-control" rows="3" name="exercises[{{ $index }}][trainer_notes]">{{ $exercise->trainer_notes }}</textarea>

                                </div>

                                <button type="button" class="btn btn-danger btn-sm mt-3"
                                    onclick="this.closest('.exercise-row').remove()">

                                    <i class="fas fa-trash"></i>
                                    Remove Exercise

                                </button>

                            </div>
                        @endforeach

                    </div>

                    <button type="button" class="btn btn-info mt-3" onclick="addExercise()">

                        <i class="fas fa-plus"></i>

                        Add Exercise

                    </button>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-save"></i>

                            Update Workout

                        </button>

                        <a href="{{ route('trainer.workout.index') }}" class="btn btn-secondary">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        let exerciseIndex = {{ $workout->exercises->count() }};

        function addExercise() {

            let container = document.getElementById('exercises-container');

            let row = document.createElement('div');

            row.className = 'exercise-row card p-3 mb-3';

            row.innerHTML = `

<div class="row">

<div class="col-md-3">

<label>Day</label>

<select name="exercises[\${exerciseIndex}][day]" class="form-control">

<option>Monday</option>
<option>Tuesday</option>
<option>Wednesday</option>
<option>Thursday</option>
<option>Friday</option>
<option>Saturday</option>
<option>Sunday</option>

</select>

</div>

<div class="col-md-3">

<label>Exercise Name</label>

<input type="text"
class="form-control"
name="exercises[\${exerciseIndex}][exercise_name]">

</div>

<div class="col-md-2">

<label>Sets</label>

<input type="number"
class="form-control"
name="exercises[\${exerciseIndex}][sets]"
value="3">

</div>

<div class="col-md-2">

<label>Reps</label>

<input type="text"
class="form-control"
name="exercises[\${exerciseIndex}][reps]">

</div>

<div class="col-md-2">

<label>Weight</label>

<input type="text"
class="form-control"
name="exercises[\${exerciseIndex}][weight]">

</div>

</div>

<div class="row mt-3">

<div class="col-md-4">

<label>Rest Time</label>

<input type="text"
class="form-control"
name="exercises[\${exerciseIndex}][rest_time]"
value="60 sec">

</div>

<div class="col-md-4">

<label>Exercise Image URL</label>

<input type="text"
class="form-control"
name="exercises[\${exerciseIndex}][exercise_image]">

</div>

<div class="col-md-4">

<label>Exercise Video URL</label>

<input type="text"
class="form-control"
name="exercises[\${exerciseIndex}][exercise_video]">

</div>

</div>

<div class="mt-3">

<label>Trainer Notes</label>

<textarea
class="form-control"
rows="3"
name="exercises[\${exerciseIndex}][trainer_notes]"></textarea>

</div>

<button
type="button"
class="btn btn-danger btn-sm mt-3"
onclick="this.closest('.exercise-row').remove()">

Remove Exercise

</button>

`;

            container.appendChild(row);

            exerciseIndex++;

        }
    </script>

@endsection
