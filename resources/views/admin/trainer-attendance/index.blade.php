@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card">

            <div class="card-header bg-success text-white">
                <h4>Trainer Attendance</h4>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Trainer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($attendance as $row)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->trainer->name ?? '-' }}</td>
                            <td>{{ $row->attendance_date }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->check_in }}</td>
                            <td>{{ $row->check_out }}</td>
                            <td>{{ $row->remarks }}</td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                No attendance records found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="mt-3">
                    {{ $attendance->links() }}
                </div>

            </div>

        </div>

    </div>
</div>

@endsection