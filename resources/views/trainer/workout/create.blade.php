@extends('layouts.trainer-layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header - Green Theme -->
                <div class="card-header" style="background: linear-gradient(135deg, #0d2818 0%, #1a472a 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i> Create Workout Plan
                        </h4>
                        <a href="{{ route('trainer.workout.index') }}" class="btn"
                            style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 20px;">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-left: 4px solid #dc3545;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('trainer.workout.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-users me-1" style="color: #1a472a;"></i> Select Member(s) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="border rounded p-3"
                                        style="height:250px; overflow-y:auto; border-color: #1a472a !important;">
                                        @foreach ($members as $member)
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input"
                                                    id="member{{ $member->id }}" name="member_ids[]"
                                                    value="{{ $member->id }}">
                                                <label class="form-check-label w-100" for="member{{ $member->id }}">
                                                    <strong>{{ $member->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $member->email }}</small>
                                                    <br>
                                                    @if ($member->plan_type == 'membership')
                                                        <span class="badge"
                                                            style="background: #0d2818; color: #ffd54f;">Membership</span>
                                                    @else
                                                        <span class="badge"
                                                            style="background: #ffd54f; color: #0d2818;">Package</span>
                                                    @endif
                                                    <span class="badge"
                                                        style="background: #1a472a; color: white;">{{ $member->membership_plan }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-heading me-1" style="color: #1a472a;"></i> Workout Title <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title"
                                        style="border-color: #1a472a; border-radius: 8px;" placeholder="Enter workout title"
                                        required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-calendar-alt me-1" style="color: #1a472a;"></i> Start Date
                                            </label>
                                            <input type="date" name="start_date" class="form-control"
                                                style="border-color: #1a472a; border-radius: 8px;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-calendar-alt me-1" style="color: #1a472a;"></i> End Date
                                            </label>
                                            <input type="date" name="end_date" class="form-control"
                                                style="border-color: #1a472a; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-align-left me-1" style="color: #1a472a;"></i> Description
                                    </label>
                                    <textarea class="form-control" rows="3" name="description" style="border-color: #1a472a; border-radius: 8px;"
                                        placeholder="Enter workout description..."></textarea>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: #1a472a;">

                        <div id="workout-days">
                            <div class="workout-day card border mb-4" style="border-color: #1a472a !important;">
                                <div class="card-header" style="background: #f8fafc; border-bottom-color: #1a472a;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong style="color: #0d2818;"><i class="fas fa-calendar-day me-2"></i>Workout
                                            Day</strong>
                                        <button type="button" class="btn btn-danger btn-sm remove-day"
                                            style="display:none;">
                                            <i class="fas fa-trash"></i> Remove Day
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold" style="color: #1a472a;">Select Day</label>
                                            <select name="days[0][day]" class="form-control"
                                                style="border-color: #1a472a; border-radius: 8px;">
                                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                    <option value="{{ $day }}">{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="exercise-container">
                                        <div class="exercise-card card border mb-3 p-3" style="border-color: #e5e7eb;">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0" style="color: #1a472a;">
                                                    <i class="fas fa-dumbbell me-2"></i> Exercise
                                                </h6>
                                                <button type="button" class="btn btn-danger btn-sm remove-exercise">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label" style="font-size: 0.85rem;">Exercise Name
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][exercise_name]"
                                                        placeholder="Enter exercise name" required>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label" style="font-size: 0.85rem;">Sets</label>
                                                    <input type="number" class="form-control" value="3"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][sets]">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label" style="font-size: 0.85rem;">Reps</label>
                                                    <input type="text" class="form-control" placeholder="12-15"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][reps]">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label" style="font-size: 0.85rem;">Weight</label>
                                                    <input type="text" class="form-control" placeholder="Optional"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][weight]">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label" style="font-size: 0.85rem;">Rest
                                                        Time</label>
                                                    <input type="text" class="form-control" value="60 sec"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][rest_time]">
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 0.85rem;">Exercise Video
                                                        URL</label>
                                                    <input type="text" class="form-control" placeholder="Video URL"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][exercise_video]">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 0.85rem;">Trainer
                                                        Notes</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Trainer Notes"
                                                        style="border-color: #1a472a; border-radius: 8px;"
                                                        name="days[0][exercises][0][trainer_notes]">
                                                </div>
                                            </div>

                                            <div class="mt-3 text-end">
                                                <button type="button" class="btn btn-success btn-sm add-exercise">
                                                    <i class="fas fa-plus me-1"></i> Add Exercise
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mb-4">
                            <button type="button" id="addWorkoutDay" class="btn"
                                style="background: #0d2818; color: white; border-radius: 8px;">
                                <i class="fas fa-plus-circle me-1"></i> Add Workout Day
                            </button>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn"
                                style="background: #0d2818; color: white; border-radius: 8px; padding: 10px 30px;">
                                <i class="fas fa-save me-2"></i> Create Workout Plan
                            </button>
                            <a href="{{ route('trainer.workout.index') }}" class="btn btn-secondary"
                                style="border-radius: 8px; padding: 10px 30px;">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dayIndex = 1;

        document.addEventListener('DOMContentLoaded', function() {
            // Add Exercise
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-exercise')) {
                    let workoutCard = e.target.closest('.workout-day');
                    let exerciseContainer = workoutCard.querySelector('.exercise-container');
                    let exerciseIndex = exerciseContainer.querySelectorAll('.exercise-card').length;
                    let currentDay = workoutCard.querySelector('select').name.match(/\d+/)[0];

                    let html = `
                <div class="exercise-card card border mb-3 p-3" style="border-color: #e5e7eb;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0" style="color: #1a472a;">
                            <i class="fas fa-dumbbell me-2"></i> Exercise
                        </h6>
                        <button type="button" class="btn btn-danger btn-sm remove-exercise">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label" style="font-size: 0.85rem;">Exercise Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][exercise_name]" placeholder="Enter exercise name" required>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label" style="font-size: 0.85rem;">Sets</label>
                            <input type="number" class="form-control" value="3" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][sets]">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label" style="font-size: 0.85rem;">Reps</label>
                            <input type="text" class="form-control" placeholder="12-15" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][reps]">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label" style="font-size: 0.85rem;">Weight</label>
                            <input type="text" class="form-control" placeholder="Optional" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][weight]">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label" style="font-size: 0.85rem;">Rest Time</label>
                            <input type="text" class="form-control" value="60 sec" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][rest_time]">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem;">Exercise Video URL</label>
                            <input type="text" class="form-control" placeholder="Video URL" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][exercise_video]">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 0.85rem;">Trainer Notes</label>
                            <input type="text" class="form-control" placeholder="Trainer Notes" style="border-color: #1a472a; border-radius: 8px;"
                                name="days[${currentDay}][exercises][${exerciseIndex}][trainer_notes]">
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-success btn-sm add-exercise">
                            <i class="fas fa-plus me-1"></i> Add Exercise
                        </button>
                    </div>
                </div>`;

                    exerciseContainer.insertAdjacentHTML('beforeend', html);
                }
            });

            // Remove Exercise
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-exercise')) {
                    let card = e.target.closest('.exercise-card');
                    let container = card.parentNode;

                    if (container.querySelectorAll('.exercise-card').length > 1) {
                        card.remove();
                    } else {
                        alert('At least one exercise is required.');
                    }
                }
            });

            // Add Workout Day
            document.getElementById('addWorkoutDay').addEventListener('click', function() {
                let container = document.getElementById('workout-days');
                let template = container.querySelector('.workout-day');
                let clone = template.cloneNode(true);

                clone.querySelectorAll('input, textarea, select').forEach(function(el) {
                    if (el.tagName == "INPUT") {
                        el.value = "";
                        if (el.name && el.name.includes('[sets]')) {
                            el.value = "3";
                        }
                        if (el.name && el.name.includes('[rest_time]')) {
                            el.value = "60 sec";
                        }
                    }
                    if (el.tagName == "TEXTAREA") {
                        el.value = "";
                    }
                    if (el.tagName == "SELECT") {
                        el.selectedIndex = 0;
                    }

                    if (el.name) {
                        el.name = el.name.replace(/days\[\d+\]/g, `days[${dayIndex}]`);
                        el.name = el.name.replace(/exercises\[\d+\]/g, 'exercises[0]');
                    }
                });

                let removeBtn = clone.querySelector('.remove-day');
                if (removeBtn) {
                    removeBtn.style.display = 'inline-block';
                }

                let exerciseContainer = clone.querySelector('.exercise-container');
                let exerciseCards = exerciseContainer.querySelectorAll('.exercise-card');
                if (exerciseCards.length > 1) {
                    for (let i = exerciseCards.length - 1; i > 0; i--) {
                        exerciseCards[i].remove();
                    }
                }

                container.appendChild(clone);
                dayIndex++;
            });

            // Remove Workout Day
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-day')) {
                    let allDays = document.querySelectorAll('.workout-day');
                    if (allDays.length == 1) {
                        alert('At least one Workout Day is required.');
                        return;
                    }
                    e.target.closest('.workout-day').remove();
                }
            });
        });
    </script>

    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #0d2818 !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 40, 24, 0.15) !important;
        }

        .form-check-input:checked {
            background-color: #0d2818;
            border-color: #0d2818;
        }

        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start !important;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {

            .form-control,
            .form-select {
                font-size: 0.85rem;
            }

            .card-header h4 {
                font-size: 1.1rem;
            }

            .exercise-card .row .col-md-4,
            .exercise-card .row .col-md-2 {
                margin-bottom: 10px;
            }
        }
    </style>

@endsection
