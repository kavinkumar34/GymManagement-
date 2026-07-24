@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="fas fa-users"></i> My Members
            </h4>
        </div>

        <div class="card-body">

            @if($members->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>S.No</th>
                                <th>Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
<th>Plan Type</th>
<th>Plan Name</th>                                <th>Goal</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($members as $key => $member)

                            <tr>

                                <td>{{ $key + 1 }}</td>

                                <td>
                                    @if($member->photo)
                                        <img src="{{ asset('storage/'.$member->photo) }}"
                                             width="60"
                                             height="60"
                                             class="rounded-circle border">
                                    @else
                                        <img src="https://via.placeholder.com/60"
                                             width="60"
                                             height="60"
                                             class="rounded-circle border">
                                    @endif
                                </td>

                                <td>{{ $member->member_id }}</td>

                                <td>
                                    <strong>{{ $member->name }}</strong>
                                </td>

                                <td>{{ $member->phone }}</td>

                                <td>{{ $member->email }}</td>

                           <td>
    @if($member->plan_type == 'membership')
        <span class="badge bg-success">
            Membership
        </span>
    @elseif($member->plan_type == 'package')
        <span class="badge bg-warning text-dark">
            Package
        </span>
    @else
        <span class="badge bg-secondary">
            -
        </span>
    @endif
</td>

<td>
    <span class="badge bg-primary">
        {{ $member->membership_plan }}
    </span>
</td>

                                <td>{{ $member->goal_type }}</td>

                                <td>

                                    @if($member->status == 'Active')

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td>

<button
class="btn btn-info btn-sm"
data-bs-toggle="modal"
data-bs-target="#memberModal{{ $member->id }}">

<i class="fas fa-eye"></i> View

</button>

</td>

                            </tr>

                            @endforeach
                            

                        </tbody>

                    </table>
                    @foreach($members as $member)

<div class="modal fade"
id="memberModal{{ $member->id }}"
tabindex="-1">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header bg-success text-white">

<h5 class="modal-title">

Member Details

</h5>

<button
type="button"
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-4 text-center mb-3">

@if($member->photo)

<img src="{{ asset('storage/'.$member->photo) }}"
class="img-fluid rounded-circle border"
width="150"
height="150">

@else

<img src="https://via.placeholder.com/150"
class="rounded-circle border">

@endif

</div>

<div class="col-md-8">

<table class="table table-bordered">

<tr>
<th>Member ID</th>
<td>{{ $member->member_id }}</td>
</tr>

<tr>
<th>Name</th>
<td>{{ $member->name }}</td>
</tr>

<tr>
<th>Gender</th>
<td>{{ $member->gender }}</td>
</tr>

<tr>
<th>Age</th>
<td>{{ $member->age }}</td>
</tr>

<tr>
<th>DOB</th>
<td>{{ $member->dob }}</td>
</tr>

<tr>
<th>Phone</th>
<td>{{ $member->phone }}</td>
</tr>

<tr>
<th>Email</th>
<td>{{ $member->email }}</td>
</tr>

<tr>
<th>Address</th>
<td>{{ $member->address }}</td>
</tr>

<tr>
<th>Height</th>
<td>{{ $member->height }} cm</td>
</tr>

<tr>
<th>Weight</th>
<td>{{ $member->weight }} kg</td>
</tr>

<tr>
<th>BMI</th>
<td>{{ $member->bmi }}</td>
</tr>

<tr>
<th>Goal</th>
<td>{{ $member->goal_type }}</td>
</tr>

<tr>
<th>Plan Type</th>
<td>{{ ucfirst($member->plan_type) }}</td>
</tr>

<tr>
<th>Plan Name</th>
<td>{{ $member->membership_plan }}</td>
</tr>

<tr>
<th>Duration</th>
<td>{{ $member->membership_duration }}</td>
</tr>

<tr>
<th>Final Price</th>
<td>₹{{ number_format($member->final_price,2) }}</td>
</tr>

<tr>
<th>Join Date</th>
<td>{{ date('d-m-Y',strtotime($member->join_date)) }}</td>
</tr>

<tr>
<th>Emergency Contact</th>
<td>{{ $member->emergency_contact }}</td>
</tr>

<tr>
<th>Medical Issues</th>
<td>{{ $member->medical_issues }}</td>
</tr>

<tr>
<th>Status</th>

<td>

@if($member->status=="Active")

<span class="badge bg-success">

Active

</span>

@else

<span class="badge bg-danger">

Inactive

</span>

@endif

</td>

</tr>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

@endforeach

                </div>

            @else

                <div class="alert alert-warning text-center">

                    <i class="fas fa-info-circle"></i>

                    <strong>No members have been assigned to you.</strong>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection