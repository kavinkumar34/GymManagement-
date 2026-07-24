@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4">

        {{ $member->name }} Attendance History

    </h4>

    @php

        $present = $history->where('status','Present')->count();

        $absent = $history->where('status','Absent')->count();

        $total = $history->count();

        $percentage = $total ? round(($present/$total)*100,2) : 0;

    @endphp

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card text-center">

                <div class="card-body">

                    <h3>{{ $total }}</h3>

                    <strong>Total Days</strong>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card text-center bg-success text-white">

                <div class="card-body">

                    <h3>{{ $present }}</h3>

                    <strong>Present</strong>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card text-center bg-danger text-white">

                <div class="card-body">

                    <h3>{{ $absent }}</h3>

                    <strong>Absent</strong>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card text-center bg-primary text-white">

                <div class="card-body">

                    <h3>{{ $percentage }}%</h3>

                    <strong>Attendance</strong>

                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Date</th>

                        <th>Status</th>

                        <th>Check In</th>

                        <th>Check Out</th>

                        <th>Remarks</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($history as $attendance)

                    <tr>

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

                        <td colspan="5" class="text-center">

                            No Attendance History

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection