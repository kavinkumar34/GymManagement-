@extends('layouts.member-layout')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4">

        My Attendance

    </h4>

    @php

        $present = $history->where('status','Present')->count();

        $absent = $history->where('status','Absent')->count();

        $total = $history->count();

        $percentage = $total ? round(($present/$total)*100,2) : 0;

    @endphp

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card">

                <div class="card-body text-center">

                    <h3>{{ $total }}</h3>

                    Total Days

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-success text-white">

                <div class="card-body text-center">

                    <h3>{{ $present }}</h3>

                    Present

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-danger text-white">

                <div class="card-body text-center">

                    <h3>{{ $absent }}</h3>

                    Absent

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-primary text-white">

                <div class="card-body text-center">

                    <h3>{{ $percentage }}%</h3>

                    Attendance %

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

                        <th>Trainer</th>

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

                        <td>{{ $attendance->trainer->name ?? '-' }}</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">

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