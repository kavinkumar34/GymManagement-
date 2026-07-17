@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-id-card"></i>
                    Membership List
                </h4>

                <a href="{{ route('admin.membership.create') }}"
                    class="btn btn-light">

                    <i class="fas fa-plus"></i>
                    Add Membership

                </a>

            </div>

            <div class="card-body">

                @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show">

                        {{ session('success') }}

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"></button>

                    </div>

                @endif

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle text-center">

                        <thead class="table-dark">

                            <tr>

                                <th width="60">#</th>

                                <th width="120">Image</th>

                                <th>Plan Name</th>

                                <th>Duration</th>

                                <th>Price</th>

                                <th>Discount Type</th>

                                <th>Discount</th>

                                <th>Final Price</th>

                                <th>Status</th>

                                <th width="180">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($memberships as $key => $membership)

                                <tr>

                                    <td>
                                        {{ $memberships->firstItem() + $key }}
                                    </td>

                                    <td>

                                        @if($membership->image)

                                            <img src="{{ asset('storage/'.$membership->image) }}"
                                                width="70"
                                                height="70"
                                                style="object-fit:cover;border-radius:8px;">

                                        @else

                                            <img src="{{ asset('images/no-image.png') }}"
                                                width="70"
                                                height="70"
                                                style="object-fit:cover;border-radius:8px;">

                                        @endif

                                    </td>

                                    <td>

                                        <strong>
                                            {{ $membership->plan_name }}
                                        </strong>

                                    </td>

                                    <td>

                                        {{ $membership->duration }}

                                        {{ $membership->duration_type }}

                                    </td>

                                    <td>

                                        ₹ {{ number_format($membership->price,2) }}

                                    </td>

                                    <td>

                                        {{ $membership->discount_type }}

                                    </td>

                                    <td>

                                        @if($membership->discount_type=="Percentage")

                                            {{ $membership->discount }} %

                                        @else

                                            ₹ {{ number_format($membership->discount,2) }}

                                        @endif

                                    </td>

                                    <td>

                                        <strong class="text-success">

                                            ₹ {{ number_format($membership->final_price,2) }}

                                        </strong>

                                    </td>

                                    <td>

                                        @if($membership->status=="Active")

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

                                        <a href="{{ route('admin.membership.edit',$membership->id) }}"
                                            class="btn btn-warning btn-sm">

                                            <i class="fas fa-edit"></i>

                                            Edit

                                        </a>

                                        <form action="{{ route('admin.membership.destroy',$membership->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this membership?')">

                                                <i class="fas fa-trash"></i>

                                                Delete

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10">

                                        <div class="text-center p-4">

                                            <h5 class="text-muted">

                                                No Membership Found

                                            </h5>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-end mt-3">

                    {{ $memberships->links() }}

                </div>

            </div>

        </div>

    </div>
</div>

@endsection