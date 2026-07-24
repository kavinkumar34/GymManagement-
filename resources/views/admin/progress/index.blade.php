@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">

    <div class="container-fluid">

        <div class="card">

            <div class="card-header text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4>
                    <i class="fas fa-chart-line"></i>
                    Member Progress
                </h4>

            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>
                                <th>Member</th>
                                <th>Trainer</th>
                                <th>Date</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>BMI</th>
                                <th>Body Fat %</th>
                                <th>Chest</th>
                                <th>Waist</th>
                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($progress as $row)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $row->member->name ?? '-' }}</td>

                                <td>{{ $row->trainer->name ?? '-' }}</td>

                                <td>{{ date('d-m-Y',strtotime($row->progress_date)) }}</td>

                                <td>{{ $row->weight }} Kg</td>

                                <td>{{ $row->height }} cm</td>

                                <td>{{ $row->bmi }}</td>

                                <td>{{ $row->body_fat }} %</td>

                                <td>{{ $row->chest }}</td>

                                <td>{{ $row->waist }}</td>

                                <td>

                                    <a href="{{ route('admin.progress.show',$row->id) }}"
                                       class="btn btn-info btn-sm">

                                        View

                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="11" class="text-center">

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

</div>

@endsection