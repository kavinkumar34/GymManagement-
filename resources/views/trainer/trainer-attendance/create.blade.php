@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h4>Mark My Attendance</h4>

        </div>

        <div class="card-body">

            <form method="POST"
                action="{{ route('trainer.trainer-attendance.store') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Date</label>

                        <input type="date"
                            name="attendance_date"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Status</label>

                        <select name="status"
                            class="form-control"
                            required>

                            <option value="Present">Present</option>

                            <option value="Absent">Absent</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Check In</label>

                        <input type="time"
                            name="check_in"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Check Out</label>

                        <input type="time"
                            name="check_out"
                            class="form-control">

                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Remarks</label>

                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="3"></textarea>

                    </div>

                </div>

                <button class="btn btn-success">

                    Save Attendance

                </button>

            </form>

        </div>

    </div>

</div>

@endsection