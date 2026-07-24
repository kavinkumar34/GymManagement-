@extends('layouts.trainer-layout')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Workout Details</h3>

        <div>
            <a href="{{ route('trainer.workout.edit',$workout->id) }}"
                class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('trainer.workout.index') }}"
                class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                Workout Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Member</strong>
                    <br>
                    {{ $workout->member->name ?? '-' }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Email</strong>
                    <br>
                    {{ $workout->member->email ?? '-' }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Workout Title</strong>
                    <br>
                    {{ $workout->title }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status</strong>
                    <br>

                    @if($workout->status=='Active')
                        <span class="badge bg-success">
                            Active
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            {{ $workout->status }}
                        </span>
                    @endif

                </div>

                <div class="col-md-6 mb-3">
                    <strong>Start Date</strong>
                    <br>
                    {{ $workout->start_date }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>End Date</strong>
                    <br>
                    {{ $workout->end_date ?? '-' }}
                </div>

                <div class="col-md-12">

                    <strong>Description</strong>

                    <div class="border rounded p-3 mt-2 bg-light">

                        {{ $workout->description ?: 'No description available.' }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">
                Workout Exercises
            </h5>

        </div>

        <div class="card-body">

            @forelse($workout->exercises as $exercise)

            <div class="card border mb-4">

                <div class="card-header">

                    <strong>
                        {{ $exercise->day }}
                    </strong>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <strong>Exercise</strong>
                            <br>
                            {{ $exercise->exercise_name }}
                        </div>

                        <div class="col-md-2 mb-3">
                            <strong>Sets</strong>
                            <br>
                            {{ $exercise->sets }}
                        </div>

                        <div class="col-md-2 mb-3">
                            <strong>Reps</strong>
                            <br>
                            {{ $exercise->reps }}
                        </div>

                        <div class="col-md-2 mb-3">
                            <strong>Weight</strong>
                            <br>
                            {{ $exercise->weight ?: '-' }}
                        </div>

                        <div class="col-md-2 mb-3">
                            <strong>Rest Time</strong>
                            <br>
                            {{ $exercise->rest_time ?: '-' }}
                        </div>

                    </div>

                    @if($exercise->exercise_image)

                        <div class="mb-3">

                            <strong>Exercise Image</strong>

                            <br>

                            <img src="{{ $exercise->exercise_image }}"
                                class="img-thumbnail mt-2"
                                style="max-width:220px;">

                        </div>

                    @endif


                    @if($exercise->exercise_video)

                        <div class="mb-3">

                            <strong>Exercise Video</strong>

                            <br>

                            <a href="{{ $exercise->exercise_video }}"
                                target="_blank"
                                class="btn btn-primary btn-sm mt-2">

                                Watch Video

                            </a>

                        </div>

                    @endif


                    @if($exercise->trainer_notes)

                        <div class="mt-3">

                            <strong>Trainer Notes</strong>

                            <div class="border rounded p-3 bg-light mt-2">

                                {{ $exercise->trainer_notes }}

                            </div>

                        </div>

                    @endif

                </div>

            </div>

            @empty

                <div class="alert alert-warning">

                    No exercises found.

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection