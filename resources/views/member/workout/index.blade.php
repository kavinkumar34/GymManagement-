@extends('layouts.member-layout')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>My Workout Plans</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($workouts->count())

        <div class="row">

            @foreach($workouts as $workout)

                <div class="col-md-6 mb-4">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                {{ $workout->title }}
                            </h5>

                            <p>
                                <strong>Trainer :</strong>
                                {{ $workout->trainer->name ?? 'N/A' }}
                            </p>

                            <p>
                                <strong>Start Date :</strong>
                                {{ $workout->start_date }}
                            </p>

                            <p>
                                <strong>End Date :</strong>
                                {{ $workout->end_date }}
                            </p>

                            <p>
                                <strong>Status :</strong>

                                <span class="badge bg-success">
                                    {{ $workout->status }}
                                </span>
                            </p>

                            <a href="{{ route('member.workout.show',$workout->id) }}"
                               class="btn btn-primary">

                                View Workout

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="alert alert-info">

            No workout plans assigned yet.

        </div>

    @endif

</div>

@endsection