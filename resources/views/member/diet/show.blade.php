@extends('layouts.member-layout')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4>
                <i class="fas fa-utensils"></i>
                Diet Plan Details
            </h4>

            <a href="{{ route('member.diet.index') }}"
                class="btn btn-secondary">

                Back

            </a>

        </div>

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">

                    <table class="table table-bordered">

                        <tr>
                            <th>Diet Title</th>
                            <td>{{ $diet->title }}</td>
                        </tr>

                        <tr>
                            <th>Goal</th>
                            <td>{{ $diet->goal }}</td>
                        </tr>

                        <tr>
                            <th>Trainer</th>
                            <td>{{ $diet->trainer->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Start Date</th>
                            <td>{{ \Carbon\Carbon::parse($diet->start_date)->format('d-m-Y') }}</td>
                        </tr>

                        <tr>
                            <th>End Date</th>
                            <td>
                                {{ $diet->end_date ? \Carbon\Carbon::parse($diet->end_date)->format('d-m-Y') : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>

                                @if($diet->status=='Active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @elseif($diet->status=='Completed')

                                    <span class="badge bg-primary">
                                        Completed
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Cancelled
                                    </span>

                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

                <div class="col-md-6">

                    <h5>Description</h5>

                    <div class="border rounded p-3">

                        {{ $diet->description ?: 'No Description Available' }}

                    </div>

                </div>

            </div>

            <hr>

            <h5 class="mb-3">

                Meal Schedule

            </h5>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>

                            <th>Day</th>

                            <th>Meal Time</th>

                            <th>Food Name</th>

                            <th>Quantity</th>

                            <th>Calories</th>

                            <th>Protein</th>

                            <th>Carbs</th>

                            <th>Fats</th>

                            <th>Notes</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($diet->meals as $meal)

                        <tr>

                            <td>{{ $meal->day }}</td>

                            <td>{{ $meal->meal_time }}</td>

                            <td>{{ $meal->food_name }}</td>

                            <td>{{ $meal->quantity }}</td>

                            <td>{{ $meal->calories }}</td>

                            <td>{{ $meal->protein }}</td>

                            <td>{{ $meal->carbs }}</td>

                            <td>{{ $meal->fats }}</td>

                            <td>{{ $meal->notes }}</td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection