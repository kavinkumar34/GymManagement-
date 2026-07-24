@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

<div class="card">

<div class="card-header bg-primary text-white">

<h4>
<i class="fas fa-calendar-check"></i>
Appointments
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
<th>Date</th>
<th>Time</th>
<th>Purpose</th>
<th>Description</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@forelse($appointments as $appointment)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $appointment->member->name ?? '-' }}</td>

<td>{{ date('d-m-Y',strtotime($appointment->appointment_date)) }}</td>

<td>{{ date('h:i A',strtotime($appointment->appointment_time)) }}</td>

<td>{{ $appointment->purpose }}</td>

<td>{{ $appointment->description }}</td>

<td>

@if($appointment->status=='Pending')

<span class="badge bg-warning">Pending</span>

@elseif($appointment->status=='Approved')

<span class="badge bg-success">Approved</span>

@elseif($appointment->status=='Rejected')

<span class="badge bg-danger">Rejected</span>

@else

<span class="badge bg-primary">Completed</span>

@endif

</td>

<td>

@if($appointment->status=='Pending')

<!-- Approve -->

<form action="{{ route('trainer.appointment.approve',$appointment->id) }}"
method="POST"
class="mb-2">

@csrf

<textarea
name="trainer_remark"
class="form-control mb-2"
rows="2"
placeholder="Trainer Remark"></textarea>

<button class="btn btn-success btn-sm">

Approve

</button>

</form>

<!-- Reject -->

<form action="{{ route('trainer.appointment.reject',$appointment->id) }}"
method="POST">

@csrf

<input
type="hidden"
name="trainer_remark"
value="Rejected by Trainer">

<button class="btn btn-danger btn-sm">

Reject

</button>

</form>

@else

{{ $appointment->trainer_remark ?? '-' }}

@endif

</td>

</tr>

@empty

<tr>

<td colspan="8" class="text-center">

No Appointment Found

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