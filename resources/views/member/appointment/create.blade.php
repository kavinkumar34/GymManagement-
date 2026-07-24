@extends('layouts.member-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-success text-white">
            <h4>
                <i class="fas fa-calendar-check"></i>
                Book Appointment
            </h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('member.appointment.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trainer</label>

                        <input type="text"
                               class="form-control"
                               value="{{ $trainer->name }}"
                               readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Appointment Date</label>

                        <input type="date"
                               name="appointment_date"
                               class="form-control"
                               min="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Appointment Time</label>

                        <input type="time"
                               name="appointment_time"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Purpose</label>

                        <input type="text"
                               name="purpose"
                               class="form-control"
                               placeholder="Enter Purpose"
                               required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Enter Description (Optional)"></textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>
                    Book Appointment
                </button>

                <a href="{{ route('member.appointment.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>

    </div>

</div>

@endsection