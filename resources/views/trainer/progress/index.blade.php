@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Progress List</h3>

        <a href="{{ route('trainer.progress.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Progress
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Date</th>
                            <th>Weight (Kg)</th>
                            <th>Height (cm)</th>
                            <th>BMI</th>
                            <th>Body Fat %</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($progress as $row)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $row->member->name ?? '-' }}</td>

                            <td>{{ date('d-m-Y', strtotime($row->progress_date)) }}</td>

                            <td>{{ $row->weight }}</td>

                            <td>{{ $row->height }}</td>

                            <td>{{ $row->bmi }}</td>

                            <td>{{ $row->body_fat }}</td>

                            <td>

                                <a href="{{ route('trainer.progress.edit',$row->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a href="{{ route('trainer.progress.chart',$row->member_id) }}"
   class="btn btn-info btn-sm">

    Chart

</a>

                                <form action="{{ route('trainer.progress.destroy',$row->id) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this progress?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center">
                                No Progress Found
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $progress->links() }}
            </div>

        </div>

    </div>

</div>

@endsection