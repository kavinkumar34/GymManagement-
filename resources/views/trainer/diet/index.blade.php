@extends('layouts.trainer-layout')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4>
                <i class="fas fa-utensils"></i>
                Diet Plans
            </h4>

            <a href="{{ route('trainer.diet.create') }}"
                class="btn btn-primary">

                <i class="fas fa-plus"></i>

                Add Diet Plan

            </a>

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

                            <th width="5%">#</th>

                            <th>Member</th>

                            <th>Diet Title</th>

                            <th>Goal</th>

                            <th>Start Date</th>

                            <th>End Date</th>

                            <th>Status</th>

                            <th width="180">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($dietPlans as $key => $diet)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>

                                <strong>{{ $diet->member->name ?? '-' }}</strong>

                                <br>

                                <small>{{ $diet->member->email ?? '' }}</small>

                            </td>

                            <td>

                                {{ $diet->title }}

                            </td>

                            <td>

                                {{ $diet->goal }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($diet->start_date)->format('d-m-Y') }}

                            </td>

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
                                                            <a href="{{ route('trainer.diet.show', $diet->id) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                </a>

                                <a href="{{ route('trainer.diet.edit', $diet->id) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form
                                    action="{{ route('trainer.diet.destroy', $diet->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this diet plan?')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                No Diet Plans Found.

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