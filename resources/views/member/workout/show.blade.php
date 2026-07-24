@extends('layouts.member-layout')

@section('content')

<div class="container py-4">

    <a href="{{ route('member.workout.index') }}"
       class="btn btn-secondary mb-3">

        Back

    </a>

    <div class="card">

        <div class="card-header">

            <h4>{{ $workout->title }}</h4>

        </div>

        <div class="card-body">

            <p>

                <strong>Trainer :</strong>

                {{ $workout->trainer->name ?? 'N/A' }}

            </p>

            <p>

                <strong>Description :</strong>

                {{ $workout->description }}

            </p>

            <p>

                <strong>Start Date :</strong>

                {{ $workout->start_date }}

            </p>

            <p>

                <strong>End Date :</strong>

                {{ $workout->end_date }}

            </p>

            <hr>

            <h5>Exercises</h5>

            @foreach($workout->exercises as $exercise)

                <div class="card mb-3">

                    <div class="card-body">

                        <h6>

                            {{ $exercise->day }}

                        </h6>

                        <table class="table table-bordered">

                            <tr>

                                <th width="200">Exercise</th>

                                <td>{{ $exercise->exercise_name }}</td>

                            </tr>

                            <tr>

                                <th>Sets</th>

                                <td>{{ $exercise->sets }}</td>

                            </tr>

                            <tr>

                                <th>Reps</th>

                                <td>{{ $exercise->reps }}</td>

                            </tr>

                            <tr>

                                <th>Weight</th>

                                <td>{{ $exercise->weight }}</td>

                            </tr>

                            <tr>

                                <th>Rest Time</th>

                                <td>{{ $exercise->rest_time }}</td>

                            </tr>

                            @if($exercise->trainer_notes)

                            <tr>

                                <th>Trainer Notes</th>

                                <td>

                                    {{ $exercise->trainer_notes }}

                                </td>

                            </tr>

                            @endif

                        </table>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection