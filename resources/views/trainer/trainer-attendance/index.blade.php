@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>My Attendance</h4>

        <a href="{{ route('trainer.trainer-attendance.create') }}"
            class="btn btn-primary">
            Mark Attendance
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Date</th>

                        <th>Status</th>

                        <th>Check In</th>

                        <th>Check Out</th>

                        <th>Remarks</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($attendances as $key=>$attendance)

                    <tr>

                        <td>{{ $key+1 }}</td>

                        <td>{{ date('d-m-Y',strtotime($attendance->attendance_date)) }}</td>

                        <td>

                            @if($attendance->status=='Present')

                                <span class="badge bg-success">Present</span>

                            @else

                                <span class="badge bg-danger">Absent</span>

                            @endif

                        </td>

                        <td>{{ $attendance->check_in }}</td>

                        <td>{{ $attendance->check_out }}</td>

                        <td>{{ $attendance->remarks }}</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Attendance Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection