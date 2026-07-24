@extends('layouts.trainer-layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Create Workout Plan</h4>
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

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                <form action="{{ route('trainer.workout.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Member(s) <span class="text-danger">*</span></label>

                                <div class="border rounded p-3" style="height:220px;overflow-y:auto;">

                                    @foreach ($members as $member)
                                        <div class="form-check mb-2">

                                            <input class="form-check-input" type="checkbox" name="member_ids[]"
                                                value="{{ $member->id }}" id="member{{ $member->id }}">

                                            <label class="form-check-label" for="member{{ $member->id }}">

                                                {{ $member->name }}
                                                ({{ $member->email }})
                                            </label>

                                        </div>
                                    @endforeach

                                </div>



                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Workout Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>

                    <hr>
                    <h5>Exercises</h5>

                    <div id="exercises-container">
                        <div class="exercise-row card p-3 mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Day <span class="text-danger">*</span></label>
                                        <select name="exercises[0][day]" class="form-control" required>
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
                                    <div class="form-group">
                                        <label>Exercise Name <span class="text-danger">*</span></label>
                                        <input type="text" name="exercises[0][exercise_name]" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sets <span class="text-danger">*</span></label>
                                        <input type="number" name="exercises[0][sets]" class="form-control" value="3"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Reps <span class="text-danger">*</span></label>
                                        <input type="text" name="exercises[0][reps]" class="form-control"
                                            placeholder="12-15" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Weight (kg)</label>
                                        <input type="text" name="exercises[0][weight]" class="form-control"
                                            placeholder="Optional">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rest Time</label>
                                        <input type="text" name="exercises[0][rest_time]" class="form-control"
                                            value="60 sec">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Exercise Image URL</label>
                                        <input type="text" name="exercises[0][exercise_image]" class="form-control"
                                            placeholder="Image URL">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Exercise Video URL</label>
                                        <input type="text" name="exercises[0][exercise_video]" class="form-control"
                                            placeholder="Video URL">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Trainer Notes</label>
                                <textarea name="exercises[0][trainer_notes]" class="form-control" rows="2"
                                    placeholder="Instructions for this exercise"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-info" onclick="addExercise()">
                        <i class="fas fa-plus"></i> Add Exercise
                    </button>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Create Workout Plan</button>
                        <a href="{{ route('trainer.workout.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let exerciseIndex = 1;

        function addExercise() {
            const container = document.getElementById('exercises-container');
            const row = document.createElement('div');
            row.className = 'exercise-row card p-3 mb-3';
            row.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Day</label>
                        <select name="exercises[${exerciseIndex}][day]" class="form-control">
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
                    <div class="form-group">
                        <label>Exercise Name</label>
                        <input type="text" name="exercises[${exerciseIndex}][exercise_name]" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Sets</label>
                        <input type="number" name="exercises[${exerciseIndex}][sets]" class="form-control" value="3">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Reps</label>
                        <input type="text" name="exercises[${exerciseIndex}][reps]" class="form-control" placeholder="12-15">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="text" name="exercises[${exerciseIndex}][weight]" class="form-control" placeholder="Optional">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Rest Time</label>
                        <input type="text" name="exercises[${exerciseIndex}][rest_time]" class="form-control" value="60 sec">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Exercise Image URL</label>
                        <input type="text" name="exercises[${exerciseIndex}][exercise_image]" class="form-control" placeholder="Image URL">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Exercise Video URL</label>
                        <input type="text" name="exercises[${exerciseIndex}][exercise_video]" class="form-control" placeholder="Video URL">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Trainer Notes</label>
                <textarea name="exercises[${exerciseIndex}][trainer_notes]" class="form-control" rows="2" placeholder="Instructions for this exercise"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="this.closest('.exercise-row').remove()">
                <i class="fas fa-trash"></i> Remove
            </button>
        `;
            container.appendChild(row);
            exerciseIndex++;
        }
    </script>
@endsection
