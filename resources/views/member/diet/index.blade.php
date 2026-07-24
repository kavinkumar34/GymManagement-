@extends('layouts.member-layout')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4>
                <i class="fas fa-utensils"></i>
                My Diet Plans
            </h4>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Diet Title</th>

                            <th>Goal</th>

                            <th>Trainer</th>

                            <th>Start Date</th>

                            <th>End Date</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($dietPlans as $key => $diet)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $diet->title }}</td>

                            <td>{{ $diet->goal }}</td>

                            <td>{{ $diet->trainer->name ?? '-' }}</td>

                            <td>{{ \Carbon\Carbon::parse($diet->start_date)->format('d-m-Y') }}</td>

                            <td>
                                {{ $diet->end_date ? \Carbon\Carbon::parse($diet->end_date)->format('d-m-Y') : '-' }}
                            </td>

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

                            <td>

                                <a href="{{ route('member.diet.show',$diet->id) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                    View

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                No Diet Plan Available.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection