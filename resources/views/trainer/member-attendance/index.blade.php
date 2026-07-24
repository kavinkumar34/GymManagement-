@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">

        <h4>Member Attendance</h4>

        <a href="{{ route('trainer.member-attendance.create') }}"
            class="btn btn-primary">

            Mark Attendance

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Member</th>

                        <th>Date</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($attendances as $key=>$attendance)

                    <tr>

                        <td>{{ $key+1 }}</td>

                        <td>{{ $attendance->member->name }}</td>

                        <td>{{ date('d-m-Y',strtotime($attendance->attendance_date)) }}</td>

                        <td>

                            @if($attendance->status=='Present')

                                <span class="badge bg-success">Present</span>

                            @else

                                <span class="badge bg-danger">Absent</span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('trainer.member-attendance.show',$attendance->member_id) }}"
                                class="btn btn-info btn-sm">

                                History

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center">

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