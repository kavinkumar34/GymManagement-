@extends('layouts.member-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="fas fa-calendar-check"></i>
                My Appointments
            </h4>

            <a href="{{ route('member.appointment.create') }}"
               class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Book Appointment
            </a>

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
                            <th>Date</th>
                            <th>Time</th>
                            <th>Trainer</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Trainer Remark</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($appointments as $appointment)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ date('d-m-Y', strtotime($appointment->appointment_date)) }}
                            </td>

                            <td>
                                {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                            </td>

                            <td>
                                {{ $appointment->trainer->name ?? '-' }}
                            </td>

                            <td>
                                {{ $appointment->purpose }}
                            </td>

                            <td>

                                @if($appointment->status == 'Pending')

                                    <span class="badge bg-warning">
                                        Pending
                                    </span>

                                @elseif($appointment->status == 'Approved')

                                    <span class="badge bg-success">
                                        Approved
                                    </span>

                                @elseif($appointment->status == 'Rejected')

                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>

                                @else

                                    <span class="badge bg-primary">
                                        Completed
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $appointment->trainer_remark ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center">
                                No Appointments Found
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $appointments->links() }}
            </div>

        </div>

    </div>

</div>

@endsection