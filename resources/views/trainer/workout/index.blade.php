@extends('layouts.trainer-layout')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Workout Plans</h3>

        <a href="{{ route('trainer.workout.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Workout
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Workout Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($workouts as $key => $workout)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            {{ $workout->member->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $workout->title }}
                        </td>

                        <td>
                            {{ $workout->start_date }}
                        </td>

                        <td>
                            {{ $workout->end_date ?? '-' }}
                        </td>

                        <td>

                            @if($workout->status=='Active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ $workout->status }}
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('trainer.workout.show',$workout->id) }}"
                               class="btn btn-info btn-sm">
                                View
                            </a>

                            <a href="{{ route('trainer.workout.edit',$workout->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('trainer.workout.destroy',$workout->id) }}"
                                  method="POST"
                                  style="display:inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this workout?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            No Workout Plans Found
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection